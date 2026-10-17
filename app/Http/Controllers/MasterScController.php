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

    /**
     * Daftar pengajuan pameran berstatus "Proses Seleksi" (7) — kedua SC
     * reviewer sudah menyatakan Memenuhi, tinggal Master SC yang
     * menentukan Terpilih (9) / Tidak Terpilih (8). Filter kluster flat
     * (bukan 2-jenjang seperti narasumber — kluster pameran tidak punya
     * parent/child, dikonfirmasi developer). Baris yang sudah diputuskan
     * tetap tampil (mirror pola narasumber).
     */
    public function pameranIndex(Request $request)
    {
        $menu = 'pameran';
        $submenu = '';

        $klusterOptions = DB::table('kluster_pameran')->where('status', true)->orderBy('nomor_kluster')->get();
        $idkluster = $request->query('idkluster');

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->whereIn('p.status_ajuan', ['7', '8', '9'])
            ->when($idkluster, fn ($query) => $query->where('p.idkluster_pameran', $idkluster))
            ->select('p.idpameran', 'p.status_ajuan', 'p.tema', 'p.nilai_final', 'p.selisih_nilai', 'i.nama_institusi')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        return view('master-sc.pameran', compact('menu', 'submenu', 'klusterOptions', 'idkluster', 'pameran'));
    }

    /**
     * Keputusan final Terpilih (9) / Tidak Terpilih (8) atas pengajuan
     * pameran berstatus "Proses Seleksi" (7). Tidak ada efek samping lain
     * seperti narasumber_acara milik narasumber — alur nomor stand/jadwal
     * loading sudah berjalan lewat status 9 di PameranAdminController/
     * PameranController (dikonfirmasi developer).
     */
    public function pameranPutuskan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'keputusan' => ['required', 'in:8,9'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->first();

        if (! $pameran || $pameran->status_ajuan !== '7') {
            return $this->jsonResponse(404, 'Pengajuan ini tidak bisa diputuskan.');
        }

        $terklaim = DB::table('pameran')
            ->where('idpameran', $pameran->idpameran)
            ->where('status_ajuan', '7')
            ->update(['status_ajuan' => $validated['keputusan']]);

        if ($terklaim === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diputuskan Master SC lain.');
        }

        $label = $validated['keputusan'] === '9' ? 'Terpilih' : 'Tidak Terpilih';
        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Keputusan akhir pengajuan pameran '{$pameran->tema}' oleh Master SC: {$label}");

        return $this->jsonResponse(200, "Keputusan '{$label}' berhasil dikirim.");
    }
}
