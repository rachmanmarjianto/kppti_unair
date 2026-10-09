<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NarasumberReviewController extends Controller
{
    /**
     * Label keputusan SC, dipakai untuk pesan log (lihat `kirimKeputusan()`).
     *
     * @var array<string, string>
     */
    private const LABEL_KEPUTUSAN = ['4' => 'Revisi', '5' => 'Diterima', '6' => 'Ditolak'];

    /**
     * Antrean pengajuan yang belum ada yang menangani (status Pengajuan),
     * plus daftar yang sedang/sudah diproses (riwayat read-only untuk semua
     * SC). Tidak ada tagihan/klaim terpisah di sini — lihat
     * NarasumberReviewController::simpanReview()/kirimKeputusan() untuk
     * mekanisme race-condition "siapa cepat dia yang dapat".
     */
    public function index()
    {
        $menu = 'narasumber';
        $submenu = '';

        $antrean = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->where('n.status_ajuan', '2')
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'n.status_ajuan', 'n.subtema', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->selectSub(
                DB::table('review_narasumber')->whereColumn('idnarasumber', 'n.idnarasumber')->selectRaw('count(*)'),
                'jumlah_riwayat'
            )
            ->selectSub($this->reviewerTerakhirSubquery(), 'reviewer_terakhir')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);

                return $row;
            });

        $diproses = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->whereIn('n.status_ajuan', ['3', '4', '5', '6'])
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'n.status_ajuan', 'n.subtema', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->selectSub($this->reviewerTerakhirSubquery(), 'reviewer_terakhir')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);

                return $row;
            });

        return view('sc.narasumber', compact('menu', 'submenu', 'antrean', 'diproses'));
    }

    /**
     * Subquery for the name of the most recent SC to have reviewed any turn
     * of a narasumber (the latest review_narasumber row with a non-null
     * reviewed_by) — relative to `n.idnarasumber` from the outer query.
     * Separate from the current turn's status, so a narasumber back in
     * queue after Revisi still shows who reviewed it last time.
     */
    private function reviewerTerakhirSubquery()
    {
        return DB::table('review_narasumber as r')
            ->join('pengguna as sc', 'sc.idpengguna', '=', 'r.reviewed_by')
            ->whereColumn('r.idnarasumber', 'n.idnarasumber')
            ->orderByDesc('r.idreview_narasumber')
            ->limit(1)
            ->select('sc.nama');
    }

    /**
     * Riwayat lengkap + form penilaian inline (catatan + keputusan). Tidak
     * ada halaman form-review terpisah seperti pameran — narasumber tidak
     * punya skor 4 kriteria.
     */
    public function detail(Request $request)
    {
        $userdata = session('userdata');
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
        $token = $this->encryptRouteValue($idnarasumber);

        $riwayat = DB::table('review_narasumber as r')
            ->leftJoin('pengguna as sc', 'sc.idpengguna', '=', 'r.reviewed_by')
            ->where('r.idnarasumber', $idnarasumber)
            ->orderBy('r.idreview_narasumber')
            ->select('r.*', 'sc.nama as nama_sc')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview_narasumber);

                return $baris;
            });

        $reviewAktif = $riwayat->first(fn ($baris) => in_array($baris->status_ajuan, ['2', '3'], true));

        $bolehReview = $reviewAktif && (
            $reviewAktif->status_ajuan === '2'
            || (int) $reviewAktif->reviewed_by === (int) $userdata['idpengguna']
        );

        return view('sc.narasumber-detail', compact(
            'menu', 'submenu', 'narasumber', 'token', 'riwayat', 'reviewAktif', 'bolehReview'
        ));
    }

    /**
     * Simpan draf penilaian (catatan) — belum final, dipanggil berulang
     * selama SC masih menyusun keputusan. Klaim atomic di submit pertama:
     * conditional update yang sekaligus menetapkan `reviewed_by`/
     * `reviewed_at` — SC lain yang submit setelahnya kena 409.
     */
    public function simpanReview(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview_narasumber' => ['required', 'integer'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = DB::table('review_narasumber')->where('idreview_narasumber', $validated['idreview_narasumber'])->first();

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        $klaimPertama = DB::table('review_narasumber')
            ->where('idreview_narasumber', $review->idreview_narasumber)
            ->where('status_ajuan', '2')
            ->whereNull('reviewed_by')
            ->update([
                'status_ajuan' => '3',
                'catatan' => $validated['catatan'] ?? null,
                'reviewed_by' => $userdata['idpengguna'],
                'reviewed_at' => now(),
            ]);

        if ($klaimPertama > 0) {
            DB::table('narasumber')->where('idnarasumber', $review->idnarasumber)->update(['status_ajuan' => '3']);

            return $this->jsonResponse(200, 'Draf review berhasil disimpan.');
        }

        $lanjutMilikSaya = DB::table('review_narasumber')
            ->where('idreview_narasumber', $review->idreview_narasumber)
            ->where('status_ajuan', '3')
            ->where('reviewed_by', $userdata['idpengguna'])
            ->update(['catatan' => $validated['catatan'] ?? null]);

        if ($lanjutMilikSaya === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diproses SC lain.');
        }

        return $this->jsonResponse(200, 'Draf review berhasil disimpan.');
    }

    /**
     * Kirim keputusan final (Revisi/Diterima/Ditolak). Boleh dipanggil
     * langsung dari status Pengajuan (first-touch sekaligus keputusan
     * final) atau dari status Review (harus baris yang sama SC-nya).
     * Keputusan Diterima membuat baris narasumber_acara memakai `idacara`
     * (dan `subtema`) yang sudah dipilih/diisi peserta sendiri sejak
     * pengajuan — bukan oleh SC (dikonfirmasi developer; lihat
     * docs/features/009-manajemen-acara.md §2.2 untuk konteks
     * narasumber_acara).
     */
    public function kirimKeputusan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview_narasumber' => ['required', 'integer'],
            'keputusan' => ['required', 'in:4,5,6'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = DB::table('review_narasumber')->where('idreview_narasumber', $validated['idreview_narasumber'])->first();

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        if ($validated['keputusan'] === '5') {
            $narasumberAwal = DB::table('narasumber')->where('idnarasumber', $review->idnarasumber)->first();

            if (! $narasumberAwal->idacara || ! $narasumberAwal->subtema) {
                return $this->jsonResponse(422, 'Peserta belum melengkapi sesi acara/subtema untuk pengajuan ini.');
            }
        }

        $updateReview = [
            'status_ajuan' => $validated['keputusan'],
            'catatan' => $validated['catatan'] ?? null,
        ];

        if ($review->status_ajuan === '2') {
            $terklaim = DB::table('review_narasumber')
                ->where('idreview_narasumber', $review->idreview_narasumber)
                ->where('status_ajuan', '2')
                ->whereNull('reviewed_by')
                ->update($updateReview + ['reviewed_by' => $userdata['idpengguna'], 'reviewed_at' => now()]);
        } else {
            $terklaim = DB::table('review_narasumber')
                ->where('idreview_narasumber', $review->idreview_narasumber)
                ->where('status_ajuan', '3')
                ->where('reviewed_by', $userdata['idpengguna'])
                ->update($updateReview);
        }

        if ($terklaim === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diproses SC lain.');
        }

        $narasumber = DB::table('narasumber')->where('idnarasumber', $review->idnarasumber)->first();

        DB::transaction(function () use ($validated, $narasumber) {
            $updateNarasumber = ['status_ajuan' => $validated['keputusan']];

            if ($validated['keputusan'] === '5') {
                DB::table('narasumber_acara')->insert([
                    'idacara' => $narasumber->idacara,
                    'idnarasumber' => $narasumber->idnarasumber,
                    'status' => true,
                ]);
            }

            DB::table('narasumber')->where('idnarasumber', $narasumber->idnarasumber)->update($updateNarasumber);
        });

        $label = self::LABEL_KEPUTUSAN[$validated['keputusan']];
        $idpeserta = DB::table('peserta')->where('idpengguna', $narasumber->idpengguna)->value('idpeserta');

        if ($idpeserta) {
            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], "Keputusan pengajuan narasumber: {$label}");
        }

        return $this->jsonResponse(200, "Keputusan '{$label}' berhasil dikirim.");
    }

    /**
     * Serve a berkas file — never exposed as a static public URL
     * (CONVENTIONS.md §7). SC bisa akses kapan pun kecuali baris masih
     * berstatus Draft (belum pernah diajukan sama sekali).
     */
    public function tampilBerkas(Request $request)
    {
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_narasumber')
            ->where('idreview_narasumber', (int) $idreview)
            ->where('status_ajuan', '!=', '1')
            ->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }
}
