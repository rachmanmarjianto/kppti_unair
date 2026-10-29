<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NarasumberAdminController extends Controller
{
    /**
     * Status yang berhak dikirimi notifikasi manual lewat tombol "Kirim
     * Notif" di halaman Ajuan — Diterima (kirim file presentasi & video)
     * dan Tidak Terpilih (kirim poster), dua keputusan akhir narasumber.
     */
    private const STATUS_DITERIMA = '5';

    private const STATUS_TIDAK_TERPILIH = '8';

    /**
     * Daftar semua pengajuan narasumber — admin punya visibilitas paling
     * luas di aplikasi ini, jadi ditampilkan tanpa kecuali (termasuk yang
     * masih Draft), sama seperti pola `PameranAdminController::index()`.
     */
    public function index(Request $request)
    {
        $menu = 'narasumber';
        $submenu = 'ajuan';

        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.idparent_acara', 'parent.tema as parent_tema')
            ->orderBy('acara.tema')
            ->get();

        // Filter acara dibuat 2 jenjang, mengikuti pola yang sudah ada di
        // halaman SC (`NarasumberReviewController::index()`): jenjang 1
        // memilih sub tema (parent), jenjang 2 memilih sesinya sendiri.
        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $idparentAcara = $request->query('idparent_acara');
        $idacara = $request->query('idacara');

        $acaraOptionsFilter = $idparentAcara ? $acaraOptions->where('idparent_acara', $idparentAcara)->values() : collect();
        $acaraTerpilih = $idacara ? $acaraOptions->firstWhere('idacara', (int) $idacara) : null;
        $parentTerpilih = $idparentAcara ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparentAcara) : null;

        // Jumlah notifikasi WA yang sudah dikirim per narasumber, untuk
        // kolom "Log WA" — dihitung terpisah (bukan leftJoin+groupBy pada
        // query utama) supaya tidak perlu groupBy semua kolom lain yang
        // dipilih.
        $jumlahLogWaPerNarasumber = DB::table('log_notifikasi_narasumber')
            ->select('idnarasumber')
            ->selectRaw('count(*) as jumlah')
            ->groupBy('idnarasumber')
            ->pluck('jumlah', 'idnarasumber');

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->when($idacara, fn ($query) => $query->where('n.idacara', $idacara))
            ->when(! $idacara && $idparentAcara, fn ($query) => $query->where('a.idparent_acara', $idparentAcara))
            ->select('n.idnarasumber', 'p.nama', 'n.status_ajuan', 'i.nama_institusi')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) use ($jumlahLogWaPerNarasumber) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);
                $row->jumlah_log_wa = $jumlahLogWaPerNarasumber->get($row->idnarasumber, 0);

                return $row;
            });

        // Dashboard jumlah pengajuan & lolos per sesi — "pengajuan" tidak
        // menghitung baris yang masih Draft (status '1', belum benar-benar
        // diajukan peserta), "lolos" = status '5' (Diterima), satu-satunya
        // keputusan akhir positif narasumber (lihat MasterScController::putuskan()).
        $dashboardSesi = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->leftJoin('narasumber as n', function ($join) {
                $join->on('n.idacara', '=', 'acara.idacara')->where('n.status_ajuan', '!=', '1');
            })
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'parent.tema as parent_tema')
            ->selectRaw('count(n.idnarasumber) as jumlah_pengajuan')
            ->selectRaw("count(case when n.status_ajuan = '7' then 1 end) as jumlah_proses_seleksi")
            ->selectRaw("count(case when n.status_ajuan = '5' then 1 end) as jumlah_lolos")
            ->groupBy('acara.idacara', 'acara.tema', 'parent.tema')
            ->orderBy('acara.tema')
            ->get()
            ->groupBy(fn ($baris) => $baris->parent_tema ?? '-');

        return view('admin.narasumber', compact(
            'menu', 'submenu', 'narasumber', 'acaraParentOptions', 'acaraOptionsFilter',
            'idparentAcara', 'idacara', 'acaraTerpilih', 'parentTerpilih', 'dashboardSesi'
        ));
    }

    /**
     * Kirim (ulang) notifikasi WA manual ke narasumber yang statusnya
     * Diterima atau Tidak Terpilih — isi pesan beda per status (lihat
     * pesanNotifikasiUntukStatus()). Setiap pengiriman yang BERHASIL
     * dicatat ke `log_notifikasi_narasumber`; gagal kirim tidak dicatat
     * supaya "Log WA" hanya menghitung yang benar-benar terkirim.
     */
    public function kirimNotifikasi(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idnarasumber' => ['required', 'integer', 'exists:narasumber,idnarasumber'],
        ]);

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->where('n.idnarasumber', $validated['idnarasumber'])
            ->select('n.idnarasumber', 'n.status_ajuan', 'p.nama', 'p.no_wa')
            ->first();

        if (! in_array($narasumber->status_ajuan, [self::STATUS_DITERIMA, self::STATUS_TIDAK_TERPILIH], true)) {
            return $this->jsonResponse(422, 'Notifikasi hanya bisa dikirim untuk status Diterima atau Tidak Terpilih.');
        }

        if (! $narasumber->no_wa) {
            return $this->jsonResponse(422, 'Pengaju ini belum memiliki nomor WhatsApp.');
        }

        [$pesan1, $pesan2, $pesan3] = $this->pesanNotifikasiUntukStatus($narasumber->status_ajuan, $narasumber->nama);

        try {
            $this->kirim_wa_oca_token_3($pesan1, $pesan2, $pesan3, $narasumber->no_wa);
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengirim notifikasi WhatsApp.');
        }

        DB::table('log_notifikasi_narasumber')->insert([
            'idnarasumber' => $narasumber->idnarasumber,
            'pesan_1' => $pesan1,
            'pesan_2' => $pesan2,
            'pesan_3' => $pesan3,
            'no_wa' => $narasumber->no_wa,
            'created_at' => now(),
            'created_by' => $userdata['idpengguna'],
        ]);

        $jumlahLogWa = DB::table('log_notifikasi_narasumber')->where('idnarasumber', $narasumber->idnarasumber)->count();

        return $this->jsonResponse(200, 'Notifikasi WhatsApp berhasil dikirim.', ['jumlah_log_wa' => $jumlahLogWa]);
    }

    /**
     * Riwayat notifikasi WA yang sudah dikirim ke satu narasumber, untuk
     * modal yang dibuka lewat klik angka di kolom "Log WA" — diurutkan dari
     * yang paling lama ke paling baru (created_at).
     */
    public function logNotifikasi(Request $request)
    {
        $validated = $request->validate([
            'idnarasumber' => ['required', 'integer', 'exists:narasumber,idnarasumber'],
        ]);

        $logs = DB::table('log_notifikasi_narasumber as l')
            ->leftJoin('pengguna as p', 'p.idpengguna', '=', 'l.created_by')
            ->where('l.idnarasumber', $validated['idnarasumber'])
            ->select('l.pesan_1', 'l.pesan_2', 'l.pesan_3', 'l.no_wa', 'l.created_at', 'p.nama as nama_pengirim')
            ->orderBy('l.created_at')
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', ['logs' => $logs]);
    }

    /**
     * @return array{0: string, 1: string, 2: string}
     */
    private function pesanNotifikasiUntukStatus(string $statusAjuan, string $nama): array
    {
        if ($statusAjuan === self::STATUS_DITERIMA) {
            return [
                "Selamat {$nama},",
                'Anda terpilih menjadi Narasumber KPPTI 2026. Silakan kirim file presentasi dan link video presentasi Anda melalui portal.',
                'Perhatikan ada batas waktu pengiriman yang telah ditentukan panitia.',
            ];
        }

        return [
            "Selamat {$nama},",
            'Anda terpilih untuk mengirimkan Poster di KPPTI 2026 sesuai dengan Extended Abstract yang Anda ajukan sebagai Narasumber.',
            'Perhatikan ada batas waktu pengiriman yang telah ditentukan panitia.',
        ];
    }

    /**
     * Detail read-only — tampilan sama seperti halaman detail SC, tapi tanpa
     * aksi apa pun (tidak ada beri review/keputusan), sama seperti pola
     * `PameranAdminController::detail()`.
     */
    public function detail(Request $request)
    {
        $idnarasumber = $this->decryptRouteValue($request->query('token'));

        if ($idnarasumber === null) {
            abort(404);
        }

        $idnarasumber = (int) $idnarasumber;

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->where('n.idnarasumber', $idnarasumber)
            ->select('n.*', 'p.nama as nama_pengaju', 'p.email', 'p.no_wa', 'i.nama_institusi', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->first();

        if (! $narasumber) {
            abort(404);
        }

        $menu = 'narasumber';
        $submenu = 'ajuan';

        // Opsi sesi 2 jenjang untuk modal ubah sesi, pola identik index().
        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.idparent_acara', 'parent.tema as parent_tema')
            ->orderBy('acara.tema')
            ->get();

        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $riwayat = DB::table('review_narasumber as r')
            ->where('r.idnarasumber', $idnarasumber)
            ->orderBy('r.idreview_narasumber')
            ->select('r.*')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview_narasumber);
                // Sama seperti NarasumberReviewController::detail() — '5' (Diterima)
                // di sini berarti baris yang sama sudah pernah '7' (Proses Seleksi)
                // lalu diputuskan Master SC, skornya tetap melekat di baris yang sama.
                $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6', '7', '8'], true)
                    ? $this->kriteriaUntukReviewNarsum($baris->idreview_narasumber)
                    : collect();

                $infoReviewer = $this->reviewerTerakhirUntukReviewNarasumber($baris->idreview_narasumber);
                $baris->nama_sc = $infoReviewer->nama ?? null;
                $baris->reviewed_at = $infoReviewer->created_at ?? null;

                return $baris;
            });

        return view('admin.narasumber-detail', compact('menu', 'submenu', 'narasumber', 'riwayat', 'acaraOptions', 'acaraParentOptions'));
    }

    /**
     * Admin mengoreksi sesi (`idacara`) yang dipilih peserta — murni
     * perubahan klasifikasi, tidak seperti kluster pameran tidak ada
     * implikasi tagihan/kapasitas (tabel acara tidak punya kolom kapasitas,
     * review_narasumber tidak menyimpan idacara), jadi tidak dibatasi
     * status_ajuan dan tidak menyentuh field lain.
     */
    public function ubahSesi(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idnarasumber' => ['required', 'integer', 'exists:narasumber,idnarasumber'],
            'idacara' => ['required', 'integer'],
        ]);

        $narasumber = DB::table('narasumber')->where('idnarasumber', $validated['idnarasumber'])->first();

        if ((int) $narasumber->idacara === $validated['idacara']) {
            return $this->jsonResponse(422, 'Sesi yang dipilih sama dengan sesi saat ini.');
        }

        $acaraLama = DB::table('acara')->where('idacara', $narasumber->idacara)->first();
        $acaraBaru = $this->acaraAktifQuery()
            ->where('idacara', $validated['idacara'])
            ->where('perlu_narsum', true)
            ->first();

        if (! $acaraBaru) {
            return $this->jsonResponse(422, 'Sesi acara yang dipilih tidak valid.');
        }

        DB::table('narasumber')->where('idnarasumber', $narasumber->idnarasumber)->update(['idacara' => $validated['idacara']]);

        $idpeserta = DB::table('peserta')->where('idpengguna', $narasumber->idpengguna)->value('idpeserta');

        if ($idpeserta) {
            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'],
                "Admin mengubah sesi pengajuan narasumber dari '{$acaraLama->tema}' menjadi '{$acaraBaru->tema}'.");
        }

        return $this->jsonResponse(200, 'Sesi pengajuan narasumber berhasil diubah.');
    }

    /**
     * Daftar pengajuan narasumber yang sudah diajukan (status bukan Draft)
     * untuk dipetakan ke satu SC reviewer — menggantikan model klaim bebas
     * SC, mirror `PameranAdminController::reviewerIndex()` tapi lebih
     * sederhana (1 kolom `reviewer_sc` langsung di `narasumber`, bukan
     * tabel junction 2-slot seperti `reviewer_pameran`).
     */
    public function reviewerIndex(Request $request)
    {
        $menu = 'narasumber';
        $submenu = 'reviewer';

        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.idparent_acara', 'parent.tema as parent_tema')
            ->orderBy('acara.tema')
            ->get();

        // Filter Sub Tema/Sesi 2 jenjang, sama seperti index() (Ajuan).
        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $idparentAcara = $request->query('idparent_acara');
        $idacara = $request->query('idacara');

        $acaraOptionsFilter = $idparentAcara ? $acaraOptions->where('idparent_acara', $idparentAcara)->values() : collect();
        $acaraTerpilih = $idacara ? $acaraOptions->firstWhere('idacara', (int) $idacara) : null;
        $parentTerpilih = $idparentAcara ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparentAcara) : null;

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('pengguna as sc', 'sc.idpengguna', '=', 'n.reviewer_sc')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->where('n.status_ajuan', '!=', '1')
            ->when($idacara, fn ($query) => $query->where('n.idacara', $idacara))
            ->when(! $idacara && $idparentAcara, fn ($query) => $query->where('a.idparent_acara', $idparentAcara))
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'n.subtema', 'n.status_ajuan', 'n.reviewer_sc', 'sc.nama as nama_reviewer')
            ->orderBy('n.idnarasumber')
            ->get();

        $scOptions = $this->scOptions();

        $dashboardReviewer = $scOptions->map(function ($sc) use ($narasumber) {
            return (object) [
                'nama' => $sc->nama,
                'jumlah' => $narasumber->where('reviewer_sc', $sc->idpengguna)->count(),
            ];
        })->sortByDesc('jumlah')->values();

        return view('admin.narasumber-reviewer', compact(
            'menu', 'submenu', 'narasumber', 'scOptions', 'acaraParentOptions', 'acaraOptionsFilter',
            'idparentAcara', 'idacara', 'acaraTerpilih', 'parentTerpilih', 'dashboardReviewer'
        ));
    }

    /**
     * Tetapkan (atau lepas, kalau `idpengguna` kosong) SC reviewer untuk
     * satu pengajuan narasumber.
     */
    public function setReviewer(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idnarasumber' => ['required', 'integer', 'exists:narasumber,idnarasumber'],
            'idpengguna' => ['nullable', 'integer'],
        ]);

        $idpengguna = $validated['idpengguna'] ?? null;

        if ($idpengguna) {
            $sc = DB::table('pengguna as p')
                ->join('role_pengguna as rp', 'rp.idpengguna', '=', 'p.idpengguna')
                ->where('p.idpengguna', $idpengguna)
                ->where('rp.idrole', 4)
                ->select('p.nama')
                ->first();

            if (! $sc) {
                return $this->jsonResponse(422, 'Pengguna yang dipilih bukan SC.');
            }
        }

        $narasumber = DB::table('narasumber')->where('idnarasumber', $validated['idnarasumber'])->first();

        DB::table('narasumber')->where('idnarasumber', $narasumber->idnarasumber)->update(['reviewer_sc' => $idpengguna]);

        $idpeserta = DB::table('peserta')->where('idpengguna', $narasumber->idpengguna)->value('idpeserta');

        if ($idpeserta) {
            $pesanLog = $idpengguna
                ? "Admin memetakan {$sc->nama} sebagai reviewer pengajuan narasumber."
                : 'Admin melepas pemetaan reviewer pengajuan narasumber.';

            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], $pesanLog);
        }

        return $this->jsonResponse(200, 'Reviewer berhasil diperbarui.');
    }

    /**
     * Monitor narasumber yang Terpilih (status_ajuan = '5', Diterima) beserta
     * status pengiriman file presentasi & link video yang mereka kirim lewat
     * halaman peserta (lihat NarasumberController::simpanPresentasi() /
     * simpanVideo()) — keduanya tersimpan di `file` dengan idref_tabel=1
     * (idref=idnarasumber langsung, tanpa tabel perantara), dibedakan lewat
     * `jenis` (1=file presentasi, 2=link video). Filter Sub Tema/Sesi sama
     * dengan pola index()/reviewerIndex().
     */
    public function terpilihIndex(Request $request)
    {
        $menu = 'narasumber';
        $submenu = 'terpilih';

        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.idparent_acara', 'parent.tema as parent_tema')
            ->orderBy('acara.tema')
            ->get();

        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $idparentAcara = $request->query('idparent_acara');
        $idacara = $request->query('idacara');

        $acaraOptionsFilter = $idparentAcara ? $acaraOptions->where('idparent_acara', $idparentAcara)->values() : collect();
        $acaraTerpilih = $idacara ? $acaraOptions->firstWhere('idacara', (int) $idacara) : null;
        $parentTerpilih = $idparentAcara ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparentAcara) : null;

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('file as fp', function ($join) {
                $join->on('fp.idref', '=', 'n.idnarasumber')
                    ->where('fp.idref_tabel', 1)
                    ->where('fp.jenis', 1)
                    ->where('fp.status', true);
            })
            ->leftJoin('file as fv', function ($join) {
                $join->on('fv.idref', '=', 'n.idnarasumber')
                    ->where('fv.idref_tabel', 1)
                    ->where('fv.jenis', 2)
                    ->where('fv.status', true);
            })
            ->where('n.status_ajuan', '5')
            ->when($idacara, fn ($query) => $query->where('n.idacara', $idacara))
            ->when(! $idacara && $idparentAcara, fn ($query) => $query->where('a.idparent_acara', $idparentAcara))
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'fp.idfile as idfile_presentasi', 'fv.keterangan as url_video')
            ->orderBy('p.nama')
            ->get()
            ->map(function ($row) {
                if ($row->idfile_presentasi) {
                    $row->token_presentasi = $this->encryptRouteValue($row->idfile_presentasi);
                }

                return $row;
            });

        return view('admin.narasumber-terpilih', compact(
            'menu', 'submenu', 'narasumber', 'acaraParentOptions', 'acaraOptionsFilter',
            'idparentAcara', 'idacara', 'acaraTerpilih', 'parentTerpilih'
        ));
    }

    /**
     * Unduh file presentasi milik satu narasumber Terpilih — pola sama
     * dengan `PosterAdminController::unduh()` (forced download, bukan
     * inline).
     */
    public function unduhPresentasiTerpilih(Request $request)
    {
        $idfile = $this->decryptRouteValue($request->query('token'));

        if ($idfile === null) {
            abort(404);
        }

        $file = DB::table('file as f')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'f.idref')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->where('f.idfile', (int) $idfile)
            ->where('f.idref_tabel', 1)
            ->where('f.jenis', 1)
            ->select('f.path_file', 'p.nama')
            ->first();

        if (! $file || ! $file->path_file || ! Storage::disk('local')->exists($file->path_file)) {
            abort(404);
        }

        $ext = strtolower(pathinfo($file->path_file, PATHINFO_EXTENSION));
        $namaFile = 'Presentasi-'.str_replace(' ', '-', $file->nama).'.'.$ext;

        return Storage::disk('local')->download($file->path_file, $namaFile);
    }

    /**
     * Serve a berkas file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Admin boleh akses kapan pun termasuk saat baris
     * masih Draft (beda dari SC yang menolak status Draft).
     */
    public function tampilBerkas(Request $request)
    {
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_narasumber')->where('idreview_narasumber', (int) $idreview)->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }
}
