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
        $submenu = '';

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

        return view('admin.narasumber', compact(
            'menu', 'submenu', 'narasumber', 'acaraParentOptions', 'acaraOptionsFilter',
            'idparentAcara', 'idacara', 'acaraTerpilih', 'parentTerpilih'
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
        $submenu = '';

        $riwayat = DB::table('review_narasumber as r')
            ->where('r.idnarasumber', $idnarasumber)
            ->orderBy('r.idreview_narasumber')
            ->select('r.*')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview_narasumber);

                $infoReviewer = $this->reviewerTerakhirUntukReviewNarasumber($baris->idreview_narasumber);
                $baris->nama_sc = $infoReviewer->nama ?? null;
                $baris->reviewed_at = $infoReviewer->created_at ?? null;

                return $baris;
            });

        return view('admin.narasumber-detail', compact('menu', 'submenu', 'narasumber', 'riwayat'));
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
