<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranReviewController extends Controller
{
    /**
     * Label keputusan SC, dipakai untuk pesan log (lihat `kirimKeputusan()`).
     *
     * @var array<string, string>
     */
    private const LABEL_KEPUTUSAN = ['4' => 'Revisi', '5' => 'Diterima', '6' => 'Ditolak'];

    /**
     * Antrean pengajuan yang sudah lunas & menunggu diklaim, plus daftar yang
     * sedang/sudah ditangani (riwayat read-only untuk semua SC — lihat
     * docs/features/007-pengajuan-pameran.md §5).
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = '';

        $antrean = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->where('p.status_ajuan', '2')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tagihan')
                    ->whereColumn('tagihan.idpameran', 'p.idpameran')
                    ->where('tagihan.status', 3);
            })
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        $diproses = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->whereIn('p.status_ajuan', ['3', '4', '5', '6'])
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi', 'p.status_ajuan')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        return view('sc.pameran', compact('menu', 'submenu', 'antrean', 'diproses'));
    }

    /**
     * Klaim satu pengajuan — race condition sederhana lewat conditional
     * update (lihat docs/features/007-pengajuan-pameran.md §5).
     */
    public function klaim(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan tidak ditemukan.');
        }

        $lunas = DB::table('tagihan')->where('idpameran', $pameran->idpameran)->where('status', 3)->exists();

        if (! $lunas) {
            return $this->jsonResponse(422, 'Tagihan pengajuan ini belum lunas.');
        }

        $terklaim = DB::table('pameran')
            ->where('idpameran', $pameran->idpameran)
            ->where('status_ajuan', '2')
            ->update(['status_ajuan' => '3']);

        if ($terklaim === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diambil SC lain.');
        }

        DB::table('review_pameran')->insert([
            'idpameran' => $pameran->idpameran,
            'status_ajuan' => '3',
            'created_by' => $userdata['idpengguna'],
            'created_at' => now(),
        ]);

        return $this->jsonResponse(200, 'Berhasil mengklaim pengajuan ini.', ['token' => $this->encryptRouteValue($pameran->idpameran)]);
    }

    /**
     * Riwayat lengkap + form penilaian (kalau SC yang login sedang
     * mengklaim). Baris terakhir disembunyikan isinya kalau statusnya Review
     * oleh SC lain (lihat docs/features/007-pengajuan-pameran.md §6).
     */
    public function detail(Request $request)
    {
        $userdata = session('userdata');
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $idpameran = (int) $idpameran;

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->where('p.idpameran', $idpameran)
            ->select('p.*', 'i.nama_institusi', 'pic.nama as nama_pic')
            ->first();

        if (! $pameran) {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = '';
        $token = $this->encryptRouteValue($idpameran);

        $semuaRiwayat = DB::table('review_pameran')
            ->where('idpameran', $idpameran)
            ->orderBy('idreview')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview);
                $baris->kriteria = $this->kriteriaUntukReview($baris->idreview);

                return $baris;
            });

        $terakhir = $semuaRiwayat->last();
        $sayaKlaim = $terakhir && $terakhir->status_ajuan === '3' && (int) $terakhir->created_by === (int) $userdata['idpengguna'];

        $riwayat = $semuaRiwayat;
        $reviewAktif = null;

        if ($terakhir && $terakhir->status_ajuan === '3') {
            $riwayat = $semuaRiwayat->slice(0, -1)->values();

            if ($sayaKlaim) {
                $reviewAktif = $terakhir;
            }
        }

        $topikAktif = DB::table('topik_review')->where('status', true)->orderBy('idtopik_review')->get();

        $skorSaatIni = $reviewAktif
            ? DB::table('isi_review_pameran')->where('idreview', $reviewAktif->idreview)->get()->keyBy('idtopik_review')
            : collect();

        return view('sc.pameran-detail', compact(
            'menu', 'submenu', 'pameran', 'token', 'riwayat', 'reviewAktif', 'topikAktif', 'skorSaatIni'
        ));
    }

    /**
     * Simpan draf penilaian (catatan + skor 4 kriteria) — belum final,
     * dipanggil berulang selama SC masih menyusun keputusan.
     */
    public function simpanReview(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview' => ['required', 'integer'],
            'catatan' => ['nullable', 'string'],
            'kriteria' => ['required', 'array'],
            'kriteria.*.isi_review' => ['nullable', 'string'],
            'kriteria.*.memenuhi' => ['nullable', 'boolean'],
        ]);

        $review = $this->reviewAktifMilikSaya((int) $validated['idreview'], (int) $userdata['idpengguna']);

        if (! $review) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        DB::table('review_pameran')->where('idreview', $review->idreview)->update([
            'catatan' => $validated['catatan'] ?? null,
        ]);

        foreach ($validated['kriteria'] as $idtopik => $data) {
            DB::table('isi_review_pameran')->updateOrInsert(
                ['idreview' => $review->idreview, 'idtopik_review' => $idtopik],
                [
                    'isi_review' => $data['isi_review'] ?? null,
                    'memenuhi' => $request->boolean("kriteria.{$idtopik}.memenuhi"),
                    'created_by' => $userdata['idpengguna'],
                    'created_at' => now(),
                ]
            );
        }

        return $this->jsonResponse(200, 'Draf penilaian berhasil disimpan.');
    }

    /**
     * Kirim keputusan final (Revisi/Diterima/Ditolak) — menolak kalau 4
     * kriteria belum lengkap diisi (dikonfirmasi developer, §7).
     */
    public function kirimKeputusan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview' => ['required', 'integer'],
            'keputusan' => ['required', 'in:4,5,6'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = $this->reviewAktifMilikSaya((int) $validated['idreview'], (int) $userdata['idpengguna']);

        if (! $review) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        $idTopikAktif = DB::table('topik_review')->where('status', true)->pluck('idtopik_review');

        $sudahTerisi = DB::table('isi_review_pameran')
            ->where('idreview', $review->idreview)
            ->whereIn('idtopik_review', $idTopikAktif)
            ->whereNotNull('isi_review')
            ->where('isi_review', '!=', '')
            ->pluck('idtopik_review');

        $belumTerisi = $idTopikAktif->diff($sudahTerisi);

        if ($belumTerisi->isNotEmpty()) {
            $namaBelumTerisi = DB::table('topik_review')->whereIn('idtopik_review', $belumTerisi)->pluck('nama_topik');

            return $this->jsonResponse(422, 'Lengkapi catatan untuk kriteria: '.$namaBelumTerisi->implode(', '));
        }

        $pameran = DB::table('pameran')->where('idpameran', $review->idpameran)->first();

        DB::transaction(function () use ($validated, $review) {
            DB::table('review_pameran')->where('idreview', $review->idreview)->update([
                'status_ajuan' => $validated['keputusan'],
                'catatan' => $validated['catatan'] ?? $review->catatan,
            ]);

            DB::table('pameran')->where('idpameran', $review->idpameran)->update([
                'status_ajuan' => $validated['keputusan'],
            ]);
        });

        $label = self::LABEL_KEPUTUSAN[$validated['keputusan']];
        $this->logPeserta((int) $pameran->idpeserta_PIC, $userdata['idpengguna'], "Keputusan pengajuan pameran '{$pameran->tema}': {$label}");

        return $this->jsonResponse(200, "Keputusan '{$label}' berhasil dikirim.");
    }

    /**
     * Serve a portofolio file — never exposed as a static public URL
     * (CONVENTIONS.md §7). SC bisa akses kapan pun kecuali baris masih
     * berstatus Draft (belum pernah diajukan sama sekali).
     */
    public function tampilPortofolio(Request $request)
    {
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran')
            ->where('idreview', (int) $idreview)
            ->where('status_ajuan', '!=', '1')
            ->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * The review_pameran row for $idreview, but only if it's still open
     * (status Review) and belongs to the SC currently making the request.
     */
    private function reviewAktifMilikSaya(int $idreview, int $idpengguna): ?object
    {
        return DB::table('review_pameran')
            ->where('idreview', $idreview)
            ->where('status_ajuan', '3')
            ->where('created_by', $idpengguna)
            ->first();
    }

    /**
     * The 4-criteria scoring breakdown for one review_pameran row (empty for
     * rows that never reached an SC decision).
     */
    private function kriteriaUntukReview(int $idreview)
    {
        return DB::table('isi_review_pameran as i')
            ->join('topik_review as t', 't.idtopik_review', '=', 'i.idtopik_review')
            ->where('i.idreview', $idreview)
            ->select('t.nama_topik', 'i.isi_review', 'i.memenuhi')
            ->orderBy('t.idtopik_review')
            ->get();
    }
}
