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
     * Antrean pengajuan yang sudah lunas & belum diklaim siapa pun, plus
     * daftar yang sedang/sudah ditangani (riwayat read-only untuk semua SC —
     * lihat docs/features/007-pengajuan-pameran.md §5).
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = '';

        $antrean = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->where('p.status_ajuan', '2')
            ->whereNull('p.direview_oleh')
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
            ->where(function ($query) {
                $query->whereNotNull('p.direview_oleh')->orWhereIn('p.status_ajuan', ['3', '4', '5', '6']);
            })
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
     * update kolom `pameran.direview_oleh` (lihat
     * docs/features/007-pengajuan-pameran.md §5). Tidak membuat baris
     * `review_pameran` baru — SC bekerja langsung di baris yang sudah dibuat
     * peserta saat mengajukan.
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
            ->whereNull('direview_oleh')
            ->update(['direview_oleh' => $userdata['idpengguna']]);

        if ($terklaim === 0) {
            return $this->jsonResponse(409, 'Pengajuan ini sudah diambil SC lain.');
        }

        return $this->jsonResponse(200, 'Berhasil mengklaim pengajuan ini.', ['token' => $this->encryptRouteValue($pameran->idpameran)]);
    }

    /**
     * Riwayat lengkap + form penilaian (kalau SC yang login sedang
     * mengklaim). Isi penilaian (`isi_review_pameran`) baris yang masih
     * berstatus Pengajuan (2) hanya ditampilkan ke SC yang mengklaimnya —
     * lihat docs/features/007-pengajuan-pameran.md §6.
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
            ->leftJoin('pengguna as sc', 'sc.idpengguna', '=', 'p.direview_oleh')
            ->where('p.idpameran', $idpameran)
            ->select('p.*', 'i.nama_institusi', 'pic.nama as nama_pic', 'sc.nama as nama_sc')
            ->first();

        if (! $pameran) {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = '';
        $token = $this->encryptRouteValue($idpameran);

        $sayaReviewer = $pameran->direview_oleh !== null && (int) $pameran->direview_oleh === (int) $userdata['idpengguna'];

        $riwayat = DB::table('review_pameran')
            ->where('idpameran', $idpameran)
            ->orderBy('idreview')
            ->get()
            ->map(function ($baris) use ($sayaReviewer) {
                $baris->token = $this->encryptRouteValue($baris->idreview);

                $tampilkanKriteria = in_array($baris->status_ajuan, ['4', '5', '6'], true)
                    || (in_array($baris->status_ajuan, ['2', '3'], true) && $sayaReviewer);

                $baris->kriteria = $tampilkanKriteria ? $this->kriteriaUntukReview($baris->idreview) : collect();

                return $baris;
            });

        $reviewAktif = $sayaReviewer
            ? $riwayat->first(fn ($baris) => in_array($baris->status_ajuan, ['2', '3'], true))
            : null;

        return view('sc.pameran-detail', compact(
            'menu', 'submenu', 'pameran', 'token', 'riwayat', 'reviewAktif'
        ));
    }

    /**
     * Halaman tersendiri untuk mengisi penilaian 4 kriteria (WYSIWYG) — lebih
     * leluasa dibanding modal untuk 4 editor penuh (dikonfirmasi developer).
     * Nilai awal tiap editor diisi dari `topik_review.petunjuk` kalau SC
     * belum pernah menyimpan isi untuk kriteria itu, supaya tinggal
     * dilengkapi/dihapus (dikonfirmasi developer).
     */
    public function formReview(Request $request)
    {
        $userdata = session('userdata');
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = $this->reviewYangSayaKlaim((int) $idreview, (int) $userdata['idpengguna']);

        if (! $review) {
            abort(404);
        }

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->where('p.idpameran', $review->idpameran)
            ->select('p.*', 'i.nama_institusi', 'pic.nama as nama_pic')
            ->first();

        $menu = 'pameran';
        $submenu = '';
        $token = $this->encryptRouteValue($review->idreview);
        $tokenPameran = $this->encryptRouteValue($review->idpameran);

        $topikAktif = DB::table('topik_review')->where('status', true)->orderBy('idtopik_review')->get();
        $skorSaatIni = DB::table('isi_review_pameran')->where('idreview', $review->idreview)->get()->keyBy('idtopik_review');

        $penilaianSebelumnya = $this->penilaianSebelumnyaDenganSkor($review->idpameran, $review->idreview);
        $skorPenilaianSebelumnya = $penilaianSebelumnya->keyBy('idreview')->map(fn ($p) => $p['skor']);

        return view('sc.pameran-review', compact(
            'menu', 'submenu', 'pameran', 'review', 'token', 'tokenPameran',
            'topikAktif', 'skorSaatIni', 'penilaianSebelumnya', 'skorPenilaianSebelumnya'
        ));
    }

    /**
     * Penilaian-penilaian sebelumnya (`review_pameran` lain milik `idpameran`
     * yang sama) yang sudah pernah dinilai SC — dipakai untuk opsi "salin
     * nilai dari penilaian sebelumnya" di form penilaian, supaya SC tidak
     * perlu menulis ulang dari nol tiap siklus revisi.
     */
    private function penilaianSebelumnyaDenganSkor(int $idpameran, int $idreviewSaatIni)
    {
        return DB::table('review_pameran')
            ->where('idpameran', $idpameran)
            ->orderBy('idreview')
            ->get()
            ->values()
            ->map(fn ($baris, $i) => [
                'idreview' => $baris->idreview,
                'nomorPenilaian' => $i + 1,
                'statusAjuan' => $baris->status_ajuan,
                'skor' => DB::table('isi_review_pameran')
                    ->where('idreview', $baris->idreview)
                    ->get()
                    ->mapWithKeys(fn ($s) => [$s->idtopik_review => ['isi_review' => $s->isi_review, 'memenuhi' => (bool) $s->memenuhi]]),
            ])
            ->filter(fn ($p) => $p['idreview'] !== $idreviewSaatIni && $p['skor']->isNotEmpty())
            ->values();
    }

    /**
     * Simpan draf penilaian (catatan + skor 4 kriteria) — belum final,
     * dipanggil berulang selama SC masih menyusun keputusan. Ditulis
     * langsung ke baris `review_pameran` milik peserta (bukan baris baru),
     * dan menandai baris itu (+ `pameran`) berstatus Review (3) — SC masih
     * bisa terus menyimpan ulang draf ini sampai kirim keputusan final.
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

        $review = $this->reviewYangSayaKlaim((int) $validated['idreview'], (int) $userdata['idpengguna']);

        if (! $review) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        DB::transaction(function () use ($validated, $review, $request, $userdata) {
            DB::table('review_pameran')->where('idreview', $review->idreview)->update([
                'status_ajuan' => '3',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            DB::table('pameran')->where('idpameran', $review->idpameran)->update([
                'status_ajuan' => '3',
            ]);

            foreach ($validated['kriteria'] as $idtopik => $data) {
                DB::table('isi_review_pameran')->updateOrInsert(
                    ['idreview' => $review->idreview, 'idtopik_review' => $idtopik],
                    [
                        'isi_review' => $this->sanitizeRichText($data['isi_review'] ?? null),
                        'memenuhi' => $request->boolean("kriteria.{$idtopik}.memenuhi"),
                        'created_by' => $userdata['idpengguna'],
                        'created_at' => now(),
                    ]
                );
            }
        });

        return $this->jsonResponse(200, 'Draf penilaian berhasil disimpan.');
    }

    /**
     * Kirim keputusan final (Revisi/Diterima/Ditolak) — menolak kalau 4
     * kriteria belum lengkap diisi (dikonfirmasi developer, §7). Keputusan
     * "Revisi" juga melepas klaim (`direview_oleh` dikosongkan) supaya SC
     * mana pun bisa mengklaim giliran revisi berikutnya.
     */
    public function kirimKeputusan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview' => ['required', 'integer'],
            'keputusan' => ['required', 'in:4,5,6'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = $this->reviewYangSayaKlaim((int) $validated['idreview'], (int) $userdata['idpengguna']);

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

            $updatePameran = ['status_ajuan' => $validated['keputusan']];

            if ($validated['keputusan'] === '4') {
                $updatePameran['direview_oleh'] = null;
            }

            DB::table('pameran')->where('idpameran', $review->idpameran)->update($updatePameran);
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
     * (status Pengajuan atau Review) and its pameran is currently claimed by
     * the SC making the request (`pameran.direview_oleh`).
     */
    private function reviewYangSayaKlaim(int $idreview, int $idpengguna): ?object
    {
        return DB::table('review_pameran as r')
            ->join('pameran as p', 'p.idpameran', '=', 'r.idpameran')
            ->where('r.idreview', $idreview)
            ->whereIn('r.status_ajuan', ['2', '3'])
            ->where('p.direview_oleh', $idpengguna)
            ->select('r.*')
            ->first();
    }

    /**
     * The 4-criteria scoring breakdown for one review_pameran row (empty for
     * rows that never reached an SC decision), joined with topik_review for
     * the criteria name.
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
