<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NarasumberAdminController extends Controller
{
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

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->when($idacara, fn ($query) => $query->where('n.idacara', $idacara))
            ->when(! $idacara && $idparentAcara, fn ($query) => $query->where('a.idparent_acara', $idparentAcara))
            ->select('n.idnarasumber', 'p.nama', 'n.status_ajuan', 'i.nama_institusi')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);

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

        return view('admin.narasumber-detail', compact('menu', 'submenu', 'narasumber', 'riwayat'));
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
