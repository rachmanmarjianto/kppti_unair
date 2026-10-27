<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranAdminController extends Controller
{
    // Samakan dengan PameranController::IDKLUSTER_BERBAYAR.
    private const IDKLUSTER_BERBAYAR = 5;

    /**
     * Daftar semua pengajuan pameran — admin punya visibilitas paling luas
     * di aplikasi ini, jadi ditampilkan tanpa kecuali (termasuk yang masih
     * Draft), beda dari SC yang sama sekali tidak bisa melihat Draft.
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = 'ajuan';

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('kluster_pameran as k', 'k.idkluster_pameran', '=', 'p.idkluster_pameran')
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi', 'p.status_ajuan', 'k.nomor_kluster', 'k.tema_kluster')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        // Dashboard jumlah mengajukan & terpilih per kluster — "mengajukan"
        // tidak menghitung baris yang masih Draft (status '1', belum benar-
        // benar diajukan peserta), "terpilih" = status '9', satu-satunya
        // keputusan akhir positif pameran (lihat MasterScController::pameranPutuskan()).
        $dashboardKluster = DB::table('kluster_pameran as k')
            ->where('k.status', true)
            ->leftJoin('pameran as p', function ($join) {
                $join->on('p.idkluster_pameran', '=', 'k.idkluster_pameran')->where('p.status_ajuan', '!=', '1');
            })
            ->select('k.idkluster_pameran', 'k.nomor_kluster', 'k.tema_kluster')
            ->selectRaw('count(p.idpameran) as jumlah_mengajukan')
            ->selectRaw("count(case when p.status_ajuan = '9' then 1 end) as jumlah_terpilih")
            ->groupBy('k.idkluster_pameran', 'k.nomor_kluster', 'k.tema_kluster')
            ->orderBy('k.nomor_kluster')
            ->get();

        return view('admin.pameran-ajuan', compact('menu', 'submenu', 'pameran', 'dashboardKluster'));
    }

    /**
     * Detail read-only — tampilan sama seperti halaman detail SC, tapi tanpa
     * aksi apa pun. Riwayat dipecah per reviewer (2 thread independen,
     * dikonfirmasi developer) — tidak ada lagi satu `direview_oleh`/riwayat
     * tunggal, lihat Controller::syncPameranStatus().
     */
    public function detail(Request $request)
    {
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $idpameran = (int) $idpameran;

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->leftJoin('kluster_pameran as k', 'k.idkluster_pameran', '=', 'p.idkluster_pameran')
            ->where('p.idpameran', $idpameran)
            ->select('p.*', 'i.nama_institusi', 'ji.nama_jenis_institusi', 'pic.nama as nama_pic', 'k.nomor_kluster', 'k.tema_kluster')
            ->first();

        if (! $pameran) {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = 'ajuan';
        $token = $this->encryptRouteValue($idpameran);

        $reviewer1 = $this->riwayatReviewerPameranAdmin($idpameran, 1);
        $reviewer2 = $this->riwayatReviewerPameranAdmin($idpameran, 2);

        $klusterOptions = DB::table('kluster_pameran')->where('status', true)->orderBy('nomor_kluster')->get();

        return view('admin.pameran-ajuan-detail', compact('menu', 'submenu', 'pameran', 'token', 'reviewer1', 'reviewer2', 'klusterOptions'));
    }

    /**
     * Admin mengoreksi kluster yang sudah dipilih peserta. Tagihan lama
     * dibatalkan (status 4, sama seperti PameranController::batalkanAjuan())
     * walau sudah Lunas/Tertagih, lalu tagihan baru dibuat sesuai aturan
     * kluster baru (pola identik PameranController::ajukan()) — tidak
     * menyentuh VA BNI sama sekali di langkah ini.
     */
    public function ubahKluster(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer', 'exists:pameran,idpameran'],
            'idkluster_pameran' => ['required', 'integer', 'exists:kluster_pameran,idkluster_pameran'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->first();

        if ((int) $pameran->idkluster_pameran === $validated['idkluster_pameran']) {
            return $this->jsonResponse(422, 'Kluster yang dipilih sama dengan kluster saat ini.');
        }

        $kluster = DB::table('kluster_pameran')->where('idkluster_pameran', $validated['idkluster_pameran'])->first();

        try {
            DB::transaction(function () use ($pameran, $validated, $kluster, $userdata) {
                DB::table('pameran')->where('idpameran', $pameran->idpameran)
                    ->update(['idkluster_pameran' => $validated['idkluster_pameran']]);

                $tagihanLama = $this->tagihanTerbaru($pameran->idpameran);

                if ($tagihanLama && (int) $tagihanLama->status !== 4) {
                    DB::table('tagihan')->where('idtagihan', $tagihanLama->idtagihan)->update(['status' => 4]);

                    DB::table('log_ubah_status_by_pengguna')->insert([
                        'done_at' => now(),
                        'done_by' => $userdata['idpengguna'],
                        'idtagihan' => $tagihanLama->idtagihan,
                        'status_awal' => $tagihanLama->status,
                        'status_akhir' => 4,
                    ]);
                }

                $berbayar = (int) $validated['idkluster_pameran'] === self::IDKLUSTER_BERBAYAR;

                DB::table('tagihan')->insert([
                    'idinstitusi_asal' => $pameran->idinstitusi_asal,
                    'idpameran' => $pameran->idpameran,
                    'created_at' => now(),
                    'created_by' => $userdata['idpengguna'],
                    'status' => $berbayar ? 6 : 3,
                    'tagihan' => $berbayar ? config('services.biaya_pameran') : 0,
                    'sisa_tagihan' => $berbayar ? config('services.biaya_pameran') : 0,
                ]);

                $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'],
                    "Admin mengubah kluster pameran '{$pameran->tema}' menjadi Kluster {$kluster->nomor_kluster} — {$kluster->tema_kluster}");
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengubah kluster pameran.');
        }

        return $this->jsonResponse(200, 'Kluster pameran berhasil diubah. Tagihan lama dibatalkan dan tagihan baru dibuat.');
    }

    /**
     * Riwayat satu thread reviewer untuk tampilan admin (read-only, semua
     * baris terlihat termasuk yang masih berjalan — beda dari tampilan SC
     * yang membatasi ke thread sendiri).
     *
     * @return array{namaSc: string, riwayat: Collection}|null
     */
    private function riwayatReviewerPameranAdmin(int $idpameran, int $reviewerKe): ?array
    {
        $reviewerPameran = DB::table('reviewer_pameran as rp')
            ->join('pengguna as sc', 'sc.idpengguna', '=', 'rp.idpengguna')
            ->where('rp.idpameran', $idpameran)
            ->where('rp.reviewer_ke', $reviewerKe)
            ->select('rp.idreviewer_pameran', 'sc.nama as nama_sc')
            ->first();

        if (! $reviewerPameran) {
            return null;
        }

        $riwayat = DB::table('review_pameran')
            ->where('created_by', $reviewerPameran->idreviewer_pameran)
            ->orderBy('idreview')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview);
                $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6'], true)
                    ? $this->kriteriaUntukReviewPameran($baris->idreview)
                    : collect();

                return $baris;
            });

        return ['namaSc' => $reviewerPameran->nama_sc, 'riwayat' => $riwayat];
    }

    /**
     * Daftar pengajuan pameran yang sudah Terpilih — satu-satunya tempat
     * admin menetapkan nomor stand.
     */
    public function nomorStand()
    {
        $menu = 'pameran';
        $submenu = 'nomor-stand';

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->where('p.status_ajuan', '9')
            ->select('p.idpameran', 'p.idinstitusi_asal', 'p.tema', 'p.nomor_stand', 'p.jadwal_loading', 'i.nama_institusi', 'ji.nama_jenis_institusi', 'pic.nama as nama_pic', 'pic.no_wa as no_wa_pic')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);
                $row->penjaga = DB::table('petugas_jaga as pj')
                    ->join('peserta as pe', 'pe.idpeserta', '=', 'pj.idpeserta')
                    ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
                    ->where('pj.idpameran', $row->idpameran)
                    ->select('pj.idpetugas_jaga', 'pj.idpeserta', 'p.nama')
                    ->orderBy('pj.idpetugas_jaga')
                    ->get();
                $row->jumlah_penjaga = $row->penjaga->count();
                $row->pesertaOptions = $this->pesertaAktifQuery($row->idinstitusi_asal)
                    ->select('pe.idpeserta', 'p.nama')
                    ->orderBy('p.nama')
                    ->get();

                $tagihan = $this->tagihanTerbaru($row->idpameran);
                $row->tagihan_lunas = $tagihan && (int) $tagihan->status === 3;

                return $row;
            });

        return view('admin.pameran-nomor-stand', compact('menu', 'submenu', 'pameran'));
    }

    /**
     * Tetapkan/ubah nomor stand satu pengajuan yang sudah Terpilih — nomor
     * stand harus unik antar pengajuan Terpilih (dikonfirmasi developer).
     */
    public function updateNomorStand(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'nomor_stand' => ['required', 'string', 'max:5'],
        ]);

        $nomorStand = trim($validated['nomor_stand']);

        $pameran = DB::table('pameran')
            ->where('idpameran', $validated['idpameran'])
            ->where('status_ajuan', '9')
            ->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran Terpilih tidak ditemukan.');
        }

        $adaPenjaga = DB::table('petugas_jaga')->where('idpameran', $pameran->idpameran)->exists();

        if (! $adaPenjaga) {
            return $this->jsonResponse(422, 'Pengajuan ini belum punya penjaga stand. Minimal 1 penjaga stand diperlukan sebelum nomor stand bisa diberikan.');
        }

        if (! $pameran->jadwal_loading) {
            return $this->jsonResponse(422, 'Tanggal loading belum diisi peserta. Tanggal loading diperlukan sebelum nomor stand bisa diberikan.');
        }

        $tagihan = $this->tagihanTerbaru($pameran->idpameran);

        if (! $tagihan || (int) $tagihan->status !== 3) {
            return $this->jsonResponse(422, 'Tagihan pengajuan ini belum lunas. Nomor stand baru bisa diberikan setelah tagihan terbayar.');
        }

        $sudahDipakai = DB::table('pameran')
            ->where('status_ajuan', '9')
            ->where('idpameran', '!=', $pameran->idpameran)
            ->whereRaw('LOWER(nomor_stand) = ?', [mb_strtolower($nomorStand)])
            ->exists();

        if ($sudahDipakai) {
            return $this->jsonResponse(422, 'Nomor stand ini sudah dipakai institusi lain.');
        }

        DB::table('pameran')->where('idpameran', $pameran->idpameran)->update([
            'nomor_stand' => $nomorStand,
        ]);

        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Admin menetapkan nomor stand pameran: {$nomorStand}");

        return $this->jsonResponse(200, 'Nomor stand berhasil disimpan.');
    }

    /**
     * Tambah satu penjaga stand — versi admin, dipakai sebagai jalan keluar
     * setelah nomor stand ditetapkan (saat itu peserta sudah tidak bisa lagi
     * mengubah sendiri). Institusi diambil dari baris `pameran`, bukan dari
     * sesi admin — dan tidak ada gerbang status nomor stand di sini.
     */
    public function tambahPenjaga(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'idpeserta' => ['required', 'integer'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->where('status_ajuan', '9')->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran Terpilih tidak ditemukan.');
        }

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $pameran->idinstitusi_asal);

        if (! $peserta) {
            return $this->jsonResponse(422, 'Penjaga stand harus peserta dari institusi asal yang sama dengan pengajuan ini.');
        }

        $jumlahSaatIni = DB::table('petugas_jaga')->where('idpameran', $pameran->idpameran)->count();

        if ($jumlahSaatIni >= 2) {
            return $this->jsonResponse(422, 'Maksimal 2 penjaga stand.');
        }

        $sudahJadiPenjaga = DB::table('petugas_jaga')
            ->where('idpameran', $pameran->idpameran)
            ->where('idpeserta', $validated['idpeserta'])
            ->exists();

        if ($sudahJadiPenjaga) {
            return $this->jsonResponse(422, 'Peserta ini sudah jadi penjaga stand.');
        }

        DB::table('petugas_jaga')->insert([
            'idpameran' => $pameran->idpameran,
            'idpeserta' => $validated['idpeserta'],
        ]);

        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Admin menambahkan {$peserta->nama} sebagai penjaga stand pameran.");

        return $this->jsonResponse(200, 'Penjaga stand berhasil ditambahkan.');
    }

    /**
     * Hapus satu penjaga stand — versi admin, tanpa batasan institusi sesi
     * (admin boleh menghapus penjaga pameran mana pun).
     */
    public function hapusPenjaga(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpetugas_jaga' => ['required', 'integer'],
        ]);

        $petugas = DB::table('petugas_jaga as pj')
            ->join('pameran as p', 'p.idpameran', '=', 'pj.idpameran')
            ->where('pj.idpetugas_jaga', $validated['idpetugas_jaga'])
            ->select('pj.idpetugas_jaga', 'p.idinstitusi_asal')
            ->first();

        if (! $petugas) {
            return $this->jsonResponse(404, 'Penjaga stand tidak ditemukan.');
        }

        DB::table('petugas_jaga')->where('idpetugas_jaga', $petugas->idpetugas_jaga)->delete();

        $this->logInstitusi($petugas->idinstitusi_asal, $userdata['idpengguna'], 'Admin menghapus satu penjaga stand pameran.');

        return $this->jsonResponse(200, 'Penjaga stand berhasil dihapus.');
    }

    /**
     * Serve a portofolio file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Admin boleh akses kapan pun termasuk saat baris
     * masih Draft (beda dari SC yang menolak status Draft).
     */
    public function tampilPortofolio(Request $request)
    {
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran')->where('idreview', (int) $idreview)->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * Serve the very first uploaded file (pameran.file_path_pertama).
     * Admin boleh akses kapan pun, tanpa batasan kepemilikan.
     */
    public function tampilFilePertama(Request $request)
    {
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $pameran = DB::table('pameran')->where('idpameran', (int) $idpameran)->first();

        if (! $pameran || ! $pameran->file_path_pertama || ! Storage::disk('local')->exists($pameran->file_path_pertama)) {
            abort(404);
        }

        return Storage::disk('local')->response($pameran->file_path_pertama);
    }

    /**
     * Daftar pengajuan pameran yang sudah diajukan (status >= 2, belum
     * Draft) untuk dipetakan 2 SC reviewer-nya — mirror pola
     * tambahPenjaga()/hapusPenjaga() (maksimal 2 slot), tapi SC bukan
     * peserta institusi sendiri (dikonfirmasi developer).
     */
    public function reviewerIndex(Request $request)
    {
        $menu = 'pameran';
        $submenu = 'reviewer';

        $klusterOptions = DB::table('kluster_pameran')->where('status', true)->orderBy('nomor_kluster')->get();
        $idkluster = $request->query('idkluster');
        $klusterTerpilih = $idkluster ? $klusterOptions->firstWhere('idkluster_pameran', (int) $idkluster) : null;

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->where('p.status_ajuan', '!=', '1')
            ->when($idkluster, fn ($query) => $query->where('p.idkluster_pameran', $idkluster))
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);
                $row->reviewer = DB::table('reviewer_pameran as rp')
                    ->join('pengguna as sc', 'sc.idpengguna', '=', 'rp.idpengguna')
                    ->where('rp.idpameran', $row->idpameran)
                    ->select('rp.idreviewer_pameran', 'rp.reviewer_ke', 'sc.idpengguna', 'sc.nama')
                    ->orderBy('rp.reviewer_ke')
                    ->get()
                    ->keyBy('reviewer_ke');

                return $row;
            });

        $scOptions = $this->scOptions();

        return view('admin.pameran-reviewer', compact(
            'menu', 'submenu', 'klusterOptions', 'idkluster', 'klusterTerpilih', 'pameran', 'scOptions'
        ));
    }

    /**
     * Petakan satu SC ke salah satu slot reviewer (1 atau 2) sebuah
     * pameran — slot harus masih kosong, dan satu SC tidak boleh mengisi
     * kedua slot pameran yang sama.
     */
    public function tambahReviewer(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'idpengguna' => ['required', 'integer'],
            'reviewer_ke' => ['required', 'in:1,2'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->where('status_ajuan', '!=', '1')->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran tidak ditemukan.');
        }

        $slotTerisi = DB::table('reviewer_pameran')
            ->where('idpameran', $pameran->idpameran)
            ->where('reviewer_ke', $validated['reviewer_ke'])
            ->exists();

        if ($slotTerisi) {
            return $this->jsonResponse(422, 'Slot reviewer ini sudah terisi. Hapus dulu sebelum menggantinya.');
        }

        $scSudahDiSlotLain = DB::table('reviewer_pameran')
            ->where('idpameran', $pameran->idpameran)
            ->where('idpengguna', $validated['idpengguna'])
            ->exists();

        if ($scSudahDiSlotLain) {
            return $this->jsonResponse(422, 'SC ini sudah jadi reviewer lain pada pengajuan yang sama.');
        }

        $sc = DB::table('pengguna as p')
            ->join('role_pengguna as rp', 'rp.idpengguna', '=', 'p.idpengguna')
            ->where('p.idpengguna', $validated['idpengguna'])
            ->where('rp.idrole', 4)
            ->select('p.nama')
            ->first();

        if (! $sc) {
            return $this->jsonResponse(422, 'Pengguna yang dipilih bukan SC.');
        }

        DB::table('reviewer_pameran')->insert([
            'idpameran' => $pameran->idpameran,
            'idpengguna' => $validated['idpengguna'],
            'reviewer_ke' => $validated['reviewer_ke'],
        ]);

        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Admin memetakan {$sc->nama} sebagai reviewer ke-{$validated['reviewer_ke']} pameran: {$pameran->tema}");

        return $this->jsonResponse(200, 'Reviewer berhasil dipetakan.');
    }

    /**
     * Hapus satu reviewer dari slotnya — ditolak kalau thread itu sudah
     * mulai review (ada baris review_pameran), supaya riwayat penilaian
     * tidak jadi anak yatim tanpa reviewer_pameran induknya.
     */
    public function hapusReviewer(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreviewer_pameran' => ['required', 'integer'],
        ]);

        $reviewerPameran = DB::table('reviewer_pameran as rp')
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->where('rp.idreviewer_pameran', $validated['idreviewer_pameran'])
            ->select('rp.idreviewer_pameran', 'p.idinstitusi_asal')
            ->first();

        if (! $reviewerPameran) {
            return $this->jsonResponse(404, 'Reviewer tidak ditemukan.');
        }

        $sudahMulai = DB::table('review_pameran')->where('created_by', $reviewerPameran->idreviewer_pameran)->exists();

        if ($sudahMulai) {
            return $this->jsonResponse(422, 'Reviewer ini sudah mulai review, tidak bisa dihapus.');
        }

        DB::table('reviewer_pameran')->where('idreviewer_pameran', $reviewerPameran->idreviewer_pameran)->delete();

        $this->logInstitusi($reviewerPameran->idinstitusi_asal, $userdata['idpengguna'], 'Admin menghapus satu reviewer pameran.');

        return $this->jsonResponse(200, 'Reviewer berhasil dihapus.');
    }

    /**
     * Daftar pengajuan pameran berstatus Terpilih (9) — tampilan sama
     * seperti halaman Master SC, tapi read-only + tombol kirim WA ke PIC
     * (dikonfirmasi developer).
     */
    public function terpilihIndex(Request $request)
    {
        $menu = 'pameran';
        $submenu = 'terpilih';

        $klusterOptions = DB::table('kluster_pameran')->where('status', true)->orderBy('nomor_kluster')->get();
        $idkluster = $request->query('idkluster');

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->where('p.status_ajuan', '9')
            ->when($idkluster, fn ($query) => $query->where('p.idkluster_pameran', $idkluster))
            ->select('p.idpameran', 'p.tema', 'p.nilai_final', 'p.selisih_nilai', 'i.nama_institusi', 'pic.nama as nama_pic', 'pic.no_wa as no_wa_pic')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        return view('admin.pameran-terpilih', compact('menu', 'submenu', 'klusterOptions', 'idkluster', 'pameran'));
    }

    /**
     * Kirim (ulang) notifikasi WA ke PIC pameran yang sudah Terpilih —
     * tombol manual, pakai helper yang sama dengan pengiriman otomatis
     * saat Master SC memutuskan Terpilih (lihat
     * Controller::kirimWaPameranTerpilih() dan
     * MasterScController::pameranPutuskan()).
     */
    public function kirimWaTerpilih(Request $request)
    {
        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
        ]);

        $ada = DB::table('pameran')->where('idpameran', $validated['idpameran'])->where('status_ajuan', '9')->exists();

        if (! $ada) {
            return $this->jsonResponse(404, 'Pengajuan pameran Terpilih tidak ditemukan.');
        }

        $hasil = $this->kirimWaPameranTerpilih($validated['idpameran']);

        if (! $hasil['sent']) {
            return $this->jsonResponse(422, $hasil['message']);
        }

        return $this->jsonResponse(200, 'Notifikasi WhatsApp berhasil dikirim.', ['wa_response' => $hasil['response']]);
    }
}
