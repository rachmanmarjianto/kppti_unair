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
    private const LABEL_KEPUTUSAN = ['4' => 'Revisi', '6' => 'Ditolak', '7' => 'Proses Seleksi'];

    /**
     * Antrean pengajuan yang dipetakan Admin ke SC ini tapi belum masuk
     * Review, plus daftar yang sedang/sudah ia proses — hanya pengajuan
     * dengan `narasumber.reviewer_sc` milik SC ini yang terlihat (admin
     * yang memetakan lewat `NarasumberAdminController::setReviewer()`,
     * menggantikan model klaim bebas, mirror `PameranReviewController::index()`).
     */
    public function index(Request $request)
    {
        $menu = 'narasumber';
        $submenu = '';

        $userdata = session('userdata');

        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.idparent_acara', 'parent.tema as parent_tema')
            ->orderBy('acara.tema')
            ->get();

        // Filter acara dibuat 2 jenjang (dikonfirmasi developer): jenjang 1
        // memilih sub tema (parent), jenjang 2 memilih sesinya sendiri.
        // Semua acara perlu_narsum selalu punya parent di data saat ini.
        $acaraParentOptions = $acaraOptions
            ->unique('idparent_acara')
            ->map(fn ($a) => (object) ['idparent_acara' => $a->idparent_acara, 'parent_tema' => $a->parent_tema])
            ->sortBy('parent_tema')
            ->values();

        $idparentAntrean = $request->query('idparent_antrean');
        $idacaraAntrean = $request->query('idacara_antrean');
        $idparentDiproses = $request->query('idparent_diproses');
        $idacaraDiproses = $request->query('idacara_diproses');

        $acaraOptionsAntrean = $idparentAntrean ? $acaraOptions->where('idparent_acara', $idparentAntrean)->values() : collect();
        $acaraOptionsDiproses = $idparentDiproses ? $acaraOptions->where('idparent_acara', $idparentDiproses)->values() : collect();

        $acaraTerpilihAntrean = $idacaraAntrean ? $acaraOptions->firstWhere('idacara', (int) $idacaraAntrean) : null;
        $acaraTerpilihDiproses = $idacaraDiproses ? $acaraOptions->firstWhere('idacara', (int) $idacaraDiproses) : null;
        $parentTerpilihAntrean = $idparentAntrean ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparentAntrean) : null;
        $parentTerpilihDiproses = $idparentDiproses ? $acaraParentOptions->firstWhere('idparent_acara', (int) $idparentDiproses) : null;

        $idacaraDenganPengajuanBaru = DB::table('narasumber')
            ->where('status_ajuan', '2')
            ->where('reviewer_sc', $userdata['idpengguna'])
            ->whereNotNull('idacara')
            ->distinct()
            ->pluck('idacara');

        $idparentDenganPengajuanBaru = DB::table('narasumber as n')
            ->join('acara as a', 'a.idacara', '=', 'n.idacara')
            ->where('n.status_ajuan', '2')
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->distinct()
            ->pluck('a.idparent_acara');

        $antrean = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->where('n.status_ajuan', '2')
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->when($idacaraAntrean, fn ($query) => $query->where('n.idacara', $idacaraAntrean))
            ->when(! $idacaraAntrean && $idparentAntrean, fn ($query) => $query->where('a.idparent_acara', $idparentAntrean))
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
            ->whereIn('n.status_ajuan', ['3', '4', '5', '6', '7', '8'])
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->when($idacaraDiproses, fn ($query) => $query->where('n.idacara', $idacaraDiproses))
            ->when(! $idacaraDiproses && $idparentDiproses, fn ($query) => $query->where('a.idparent_acara', $idparentDiproses))
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'n.status_ajuan', 'n.subtema', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->selectSub($this->reviewerTerakhirSubquery(), 'reviewer_terakhir')
            ->orderBy('n.idnarasumber')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idnarasumber);

                return $row;
            });

        return view('sc.narasumber', compact(
            'menu', 'submenu', 'acaraParentOptions', 'acaraOptionsAntrean', 'acaraOptionsDiproses',
            'idparentAntrean', 'idacaraAntrean', 'idparentDiproses', 'idacaraDiproses',
            'acaraTerpilihAntrean', 'acaraTerpilihDiproses', 'parentTerpilihAntrean', 'parentTerpilihDiproses',
            'idacaraDenganPengajuanBaru', 'idparentDenganPengajuanBaru', 'antrean', 'diproses'
        ));
    }

    /**
     * Subquery for the name of the most recent SC to have scored any topic
     * for any review turn of a narasumber — relative to `n.idnarasumber`
     * from the outer query. Separate from the current turn's status, so a
     * narasumber back in queue after Revisi still shows who reviewed it
     * last time. See Controller::reviewerTerakhirUntukReviewNarasumber().
     */
    private function reviewerTerakhirSubquery()
    {
        return DB::table('isi_review_narsum as i')
            ->join('review_narasumber as r', 'r.idreview_narasumber', '=', 'i.idreview_narasumber')
            ->join('pengguna as sc', 'sc.idpengguna', '=', 'i.created_by')
            ->whereColumn('r.idnarasumber', 'n.idnarasumber')
            ->orderByDesc('i.created_at')
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
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->select('n.*', 'p.nama as nama_pengaju', 'p.email', 'p.no_wa', 'i.nama_institusi', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->first();

        if (! $narasumber) {
            abort(404);
        }

        $menu = 'narasumber';
        $submenu = '';
        $token = $this->encryptRouteValue($idnarasumber);

        $riwayat = DB::table('review_narasumber as r')
            ->where('r.idnarasumber', $idnarasumber)
            ->orderBy('r.idreview_narasumber')
            ->select('r.*')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview_narasumber);
                // '5' (Diterima) di sini berarti baris yang sama sudah pernah '7'
                // (Proses Seleksi) lalu diputuskan Master SC — skornya tetap
                // melekat di baris yang sama, bukan baris baru.
                $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6', '7', '8'], true)
                    ? $this->kriteriaUntukReviewNarsum($baris->idreview_narasumber)
                    : collect();

                $infoReviewer = $this->reviewerTerakhirUntukReviewNarasumber($baris->idreview_narasumber);
                $baris->nama_sc = $infoReviewer->nama ?? null;
                $baris->reviewed_at = $infoReviewer->created_at ?? null;

                return $baris;
            });

        $reviewAktif = $riwayat->first(fn ($baris) => in_array($baris->status_ajuan, ['2', '3'], true));

        // Akses halaman ini sudah dibatasi lewat filter reviewer_sc di query
        // $narasumber di atas (SC yang bukan reviewer-nya kena 404) — jadi
        // $bolehReview di sini murni soal ada/tidaknya turn aktif untuk
        // diisi, bukan lagi soal lock per-SC. nama_sc di riwayat tetap
        // info tampilan "siapa yang terakhir menilai", bukan pembatas akses.
        $bolehReview = (bool) $reviewAktif;

        $topikAktif = DB::table('topik_review_narsum')->where('status', true)->orderBy('idtopik_review_narsum')->get();
        $skorSaatIni = $reviewAktif
            ? DB::table('isi_review_narsum')->where('idreview_narasumber', $reviewAktif->idreview_narasumber)->get()->keyBy('idtopik_review_narsum')
            : collect();

        return view('sc.narasumber-detail', compact(
            'menu', 'submenu', 'narasumber', 'token', 'riwayat', 'reviewAktif', 'bolehReview', 'topikAktif', 'skorSaatIni'
        ));
    }

    /**
     * Simpan draf penilaian (catatan + topik) — belum final, dipanggil
     * berulang selama SC masih menyusun keputusan. Reviewer sudah pasti
     * dari pemetaan Admin (`narasumber.reviewer_sc`, lihat
     * `NarasumberAdminController::setReviewer()`), jadi query awal di
     * bawah ini sekaligus jadi otorisasi — SC yang bukan reviewer-nya
     * dapat 404. `whereIn(status_ajuan)` di update tetap menjaga agar
     * draft tidak menimpa baris yang sudah final diputuskan.
     */
    public function simpanReview(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview_narasumber' => ['required', 'integer'],
            'catatan' => ['nullable', 'string'],
            'topik' => ['nullable', 'array'],
            'topik.*.isi_review' => ['nullable', 'string'],
            'topik.*.nilai' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $review = DB::table('review_narasumber as r')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'r.idnarasumber')
            ->where('r.idreview_narasumber', $validated['idreview_narasumber'])
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->select('r.*')
            ->first();

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        try {
            DB::transaction(function () use ($validated, $review, $userdata) {
                $diperbarui = DB::table('review_narasumber')
                    ->where('idreview_narasumber', $review->idreview_narasumber)
                    ->whereIn('status_ajuan', ['2', '3'])
                    ->update(['status_ajuan' => '3', 'catatan' => $validated['catatan'] ?? null]);

                if ($diperbarui === 0) {
                    throw new \RuntimeException('Pengajuan ini sudah diproses.');
                }

                foreach ($validated['topik'] ?? [] as $idtopik => $data) {
                    DB::table('isi_review_narsum')->updateOrInsert(
                        ['idreview_narasumber' => $review->idreview_narasumber, 'idtopik_review_narsum' => $idtopik],
                        [
                            'isi_review' => $data['isi_review'] ?? null,
                            'nilai' => $data['nilai'] ?? null,
                            'created_by' => $userdata['idpengguna'],
                            'created_at' => now(),
                        ]
                    );
                }

                $this->syncNarasumberStatus($review->idnarasumber);
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(409, $e->getMessage());
        }

        return $this->jsonResponse(200, 'Draf review berhasil disimpan.');
    }

    /**
     * Kirim keputusan final (Revisi/Ditolak/Proses Seleksi) — menolak
     * kalau ketujuh topik penilaian belum lengkap (nilai saja; komentar per
     * topik tidak lagi wajib, dikonfirmasi developer). "Diterima" tidak
     * lagi dipilih di sini — begitu status jadi "Proses Seleksi" (7),
     * keputusan akhir Diterima/Ditolak ditentukan role Master SC lewat
     * MasterScController::putuskan() (lihat juga narasumber_acara di sana).
     * Boleh dipanggil dari status Pengajuan maupun Review, tapi hanya oleh
     * SC yang dipetakan Admin sebagai reviewer-nya (query awal di bawah
     * sekaligus jadi otorisasi) — `whereIn` di update hanya menjaga agar
     * tidak menimpa baris yang sudah final diputuskan.
     */
    public function kirimKeputusan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview_narasumber' => ['required', 'integer'],
            'keputusan' => ['required', 'in:4,6,7'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = DB::table('review_narasumber as r')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'r.idnarasumber')
            ->where('r.idreview_narasumber', $validated['idreview_narasumber'])
            ->where('n.reviewer_sc', $userdata['idpengguna'])
            ->select('r.*')
            ->first();

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        $idTopikAktif = DB::table('topik_review_narsum')->where('status', true)->pluck('idtopik_review_narsum');

        $sudahTerisi = DB::table('isi_review_narsum')
            ->where('idreview_narasumber', $review->idreview_narasumber)
            ->whereIn('idtopik_review_narsum', $idTopikAktif)
            ->whereNotNull('nilai')
            ->pluck('idtopik_review_narsum');

        $belumTerisi = $idTopikAktif->diff($sudahTerisi);

        if ($belumTerisi->isNotEmpty()) {
            $namaBelumTerisi = DB::table('topik_review_narsum')->whereIn('idtopik_review_narsum', $belumTerisi)->pluck('nama_topik');

            return $this->jsonResponse(422, 'Lengkapi nilai untuk topik: '.$namaBelumTerisi->implode(', '));
        }

        $nilaiAkhir = round(
            (float) DB::table('isi_review_narsum as i')
                ->join('topik_review_narsum as t', 't.idtopik_review_narsum', '=', 'i.idtopik_review_narsum')
                ->where('i.idreview_narasumber', $review->idreview_narasumber)
                ->whereIn('i.idtopik_review_narsum', $idTopikAktif)
                ->selectRaw('COALESCE(SUM(i.nilai * t.bobot_dlm_persen / 100.0), 0) as total')
                ->value('total'),
            2
        );

        $updateReview = [
            'status_ajuan' => $validated['keputusan'],
            'catatan' => $validated['catatan'] ?? null,
            'nilai_akhir' => $nilaiAkhir,
        ];

        try {
            DB::transaction(function () use ($review, $updateReview) {
                $terklaim = DB::table('review_narasumber')
                    ->where('idreview_narasumber', $review->idreview_narasumber)
                    ->whereIn('status_ajuan', ['2', '3'])
                    ->update($updateReview);

                if ($terklaim === 0) {
                    throw new \RuntimeException('Pengajuan ini sudah diproses.');
                }

                $this->syncNarasumberStatus($review->idnarasumber);
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(409, $e->getMessage());
        }

        $narasumber = DB::table('narasumber')->where('idnarasumber', $review->idnarasumber)->first();
        $label = self::LABEL_KEPUTUSAN[$validated['keputusan']];
        $idpeserta = DB::table('peserta')->where('idpengguna', $narasumber->idpengguna)->value('idpeserta');

        if ($idpeserta) {
            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], "Keputusan pengajuan narasumber: {$label} (nilai akhir: {$nilaiAkhir})");
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
