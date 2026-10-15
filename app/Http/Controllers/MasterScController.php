<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterScController extends Controller
{
    /**
     * Daftar pengajuan narasumber yang sudah/sedang melalui seleksi akhir
     * Master SC — status "Proses Seleksi" (7, tombol keputusan masih
     * tampil), "Diterima" (5), atau "Tidak Terpilih" (8). Baris yang sudah
     * diputuskan tetap tampil di list (dikonfirmasi developer), hanya
     * tombolnya diganti teks status. Filter berjenjang (sub tema lalu
     * sesi), sama seperti sc.narasumber — acara dibatasi ke yang
     * `perlu_narsum` true.
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

        // Filter acara dibuat 2 jenjang (dikonfirmasi developer), sama
        // seperti NarasumberReviewController::index() — jenjang 1 memilih
        // sub tema (parent), jenjang 2 memilih sesinya sendiri.
        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $idparent = $request->query('idparent');
        $idacara = $request->query('idacara');
        $acaraOptionsAnak = $idparent ? $acaraOptions->where('idparent_acara', $idparent)->values() : collect();

        $acaraTerpilih = $idacara ? $acaraOptions->firstWhere('idacara', (int) $idacara) : null;
        $parentTerpilih = $idparent ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparent) : null;

        $narasumber = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->join('review_narasumber as r', function ($join) {
                $join->on('r.idnarasumber', '=', 'n.idnarasumber')
                    ->whereIn('r.status_ajuan', ['5', '7', '8']);
            })
            ->whereIn('n.status_ajuan', ['5', '7', '8'])
            ->when($idacara, fn ($query) => $query->where('n.idacara', $idacara))
            ->when(! $idacara && $idparent, fn ($query) => $query->where('a.idparent_acara', $idparent))
            ->select('n.idnarasumber', 'n.status_ajuan', 'p.nama', 'i.nama_institusi', 'r.idreview_narasumber', 'r.nilai_akhir', 'r.catatan')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);

                return $row;
            });

        return view('master-sc.narasumber', compact(
            'menu', 'submenu', 'acaraParentOptions', 'acaraOptionsAnak',
            'idparent', 'idacara', 'parentTerpilih', 'acaraTerpilih', 'narasumber'
        ));
    }

    /**
     * Keputusan final Diterima (5) / Tidak Terpilih (8) atas pengajuan
     * berstatus "Proses Seleksi" (7). Diterima membuat baris
     * narasumber_acara memakai idacara/subtema yang sudah dipilih peserta —
     * pindahan dari NarasumberReviewController::kirimKeputusan() sebelum
     * peran ini ada (lihat docs/features/009-manajemen-acara.md §2.2).
     * Status 8 terpisah dari status 6 "Ditolak" milik SC biasa — 6 berarti
     * ditolak sebelum masuk seleksi akhir, 8 berarti tidak terpilih setelah
     * melalui seleksi akhir Master SC (dikonfirmasi developer).
     */
    public function putuskan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview_narasumber' => ['required', 'integer'],
            'keputusan' => ['required', 'in:5,8'],
        ]);

        $review = DB::table('review_narasumber')->where('idreview_narasumber', $validated['idreview_narasumber'])->first();

        if (! $review || $review->status_ajuan !== '7') {
            return $this->jsonResponse(404, 'Pengajuan ini tidak bisa diputuskan.');
        }

        $narasumber = DB::table('narasumber')->where('idnarasumber', $review->idnarasumber)->first();

        if ($validated['keputusan'] === '5' && (! $narasumber->idacara || ! $narasumber->subtema)) {
            return $this->jsonResponse(422, 'Peserta belum melengkapi sesi acara/subtema untuk pengajuan ini.');
        }

        $terklaim = DB::table('review_narasumber')
            ->where('idreview_narasumber', $review->idreview_narasumber)
            ->where('status_ajuan', '7')
            ->update(['status_ajuan' => $validated['keputusan']]);

        if ($terklaim === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diputuskan Master SC lain.');
        }

        DB::transaction(function () use ($validated, $narasumber) {
            if ($validated['keputusan'] === '5') {
                DB::table('narasumber_acara')->insert([
                    'idacara' => $narasumber->idacara,
                    'idnarasumber' => $narasumber->idnarasumber,
                    'status' => true,
                ]);
            }

            $this->syncNarasumberStatus($narasumber->idnarasumber);
        });

        $label = $validated['keputusan'] === '5' ? 'Diterima' : 'Tidak Terpilih';
        $idpeserta = DB::table('peserta')->where('idpengguna', $narasumber->idpengguna)->value('idpeserta');

        if ($idpeserta) {
            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], "Keputusan akhir pengajuan narasumber oleh Master SC: {$label}");
        }

        return $this->jsonResponse(200, "Keputusan '{$label}' berhasil dikirim.");
    }
}
