<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranReviewController extends Controller
{
    /**
     * Label keputusan SC, dipakai untuk pesan log (lihat `kirimKeputusan()`).
     * "Diterima"/"Ditolak" berganti nama jadi "Memenuhi"/"Tidak Memenuhi" —
     * keputusan akhir Terpilih/Tidak Terpilih sekarang domain Master SC
     * (dikonfirmasi developer, lihat Controller::syncPameranStatus()).
     *
     * @var array<string, string>
     */
    private const LABEL_KEPUTUSAN = ['4' => 'Revisi', '5' => 'Memenuhi', '6' => 'Tidak Memenuhi'];

    /**
     * Status tagihan yang membuat sebuah pengajuan pameran siap direview SC
     * — Lunas (3) atau Ditangguhkan (6, kluster berbayar yang baru
     * benar-benar ditagihkan kalau hasil review-nya Terpilih, dikonfirmasi
     * developer; lihat PameranController::ajukan()).
     *
     * @var array<int, int>
     */
    private const TAGIHAN_STATUS_BOLEH_REVIEW = [3, 6];

    /**
     * Antrean pengajuan yang dipetakan Admin ke SC ini tapi belum ia mulai
     * review, plus daftar yang sudah ia mulai (riwayat thread-nya sendiri
     * saja — SC lain yang juga direviewer di pameran yang sama tidak
     * terlihat di sini, dikonfirmasi developer). Tidak ada lagi klaim
     * rebutan — reviewer sudah pasti dari mapping Admin di `reviewer_pameran`.
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = '';

        $userdata = session('userdata');

        $belumMulai = fn ($query) => $query->whereNotExists(
            fn ($sub) => $sub->select('idreview')->from('review_pameran')->whereColumn('created_by', 'rp.idreviewer_pameran')
        );

        $antrean = DB::table('reviewer_pameran as rp')
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('kluster_pameran as k', 'k.idkluster_pameran', '=', 'p.idkluster_pameran')
            ->where('rp.idpengguna', $userdata['idpengguna'])
            ->where($belumMulai)
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi', 'k.nomor_kluster', 'k.tema_kluster')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        $diproses = DB::table('reviewer_pameran as rp')
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('kluster_pameran as k', 'k.idkluster_pameran', '=', 'p.idkluster_pameran')
            ->where('rp.idpengguna', $userdata['idpengguna'])
            ->whereExists(
                fn ($sub) => $sub->select('idreview')->from('review_pameran')->whereColumn('created_by', 'rp.idreviewer_pameran')
            )
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi', 'p.status_ajuan', 'k.nomor_kluster', 'k.tema_kluster')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        return view('sc.pameran', compact('menu', 'submenu', 'antrean', 'diproses'));
    }

    /**
     * Riwayat thread sendiri + form penilaian inline (kartu per topik),
     * sama seperti NarasumberReviewController::detail(). Kalau thread
     * belum punya baris review_pameran sama sekali, tampilkan tombol
     * "Mulai Review" (lihat `mulaiReview()`) bukan form penilaian.
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

        $reviewerPameran = $this->reviewerPameranUntukPengguna($idpameran, $userdata['idpengguna']);

        if (! $reviewerPameran) {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = '';
        $token = $this->encryptRouteValue($idpameran);

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

        $mulaiReviewDiperlukan = $riwayat->isEmpty();
        $reviewAktif = $riwayat->first(fn ($baris) => in_array($baris->status_ajuan, ['2', '3'], true));

        $topikAktif = DB::table('topik_review')->where('status', true)->orderBy('idtopik_review')->get();
        $skorSaatIni = $reviewAktif
            ? DB::table('isi_review_pameran')->where('idreview', $reviewAktif->idreview)->get()->keyBy('idtopik_review')
            : collect();

        return view('sc.pameran-detail', compact(
            'menu', 'submenu', 'pameran', 'token', 'riwayat', 'reviewAktif', 'mulaiReviewDiperlukan', 'topikAktif', 'skorSaatIni'
        ));
    }

    /**
     * Mulai thread review SC ini — hanya sekali per reviewer_pameran
     * (dikonfirmasi developer). Membuat baris review_pameran pertama di
     * thread ini, file_path disalin dari pameran.file_path_pertama.
     */
    public function mulaiReview(Request $request)
    {
        $userdata = session('userdata');
        $idpameran = $this->decryptRouteValue($request->input('token'));

        if ($idpameran === null) {
            return $this->jsonResponse(404, 'Pengajuan tidak ditemukan.');
        }

        $idpameran = (int) $idpameran;

        $reviewerPameran = $this->reviewerPameranUntukPengguna($idpameran, $userdata['idpengguna']);

        if (! $reviewerPameran) {
            return $this->jsonResponse(404, 'Anda tidak ditugaskan sebagai reviewer pengajuan ini.');
        }

        $sudahMulai = DB::table('review_pameran')->where('created_by', $reviewerPameran->idreviewer_pameran)->exists();

        if ($sudahMulai) {
            return $this->jsonResponse(422, 'Review ini sudah dimulai.');
        }

        $pameran = DB::table('pameran')->where('idpameran', $idpameran)->first();

        if (! $pameran || ! in_array($pameran->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(422, 'Pengajuan ini tidak bisa direview pada status saat ini.');
        }

        $tagihan = $this->tagihanTerbaru($idpameran);

        if (! $tagihan || ! in_array((int) $tagihan->status, self::TAGIHAN_STATUS_BOLEH_REVIEW, true)) {
            return $this->jsonResponse(422, 'Tagihan pengajuan ini belum lunas.');
        }

        try {
            DB::transaction(function () use ($reviewerPameran, $pameran) {
                // Row lock supaya 2 klik beruntun dari SC yang sama (dobel
                // klik, atau request yang di-retry) tidak lolos cek
                // "sudahMulai" bersamaan dan membuat 2 baris review_pameran
                // untuk thread yang sama — klik kedua akan menunggu baris
                // ini, lalu cek ulang dan ditolak (dikonfirmasi lewat
                // pengujian 2 koneksi terpisah).
                DB::table('reviewer_pameran')->where('idreviewer_pameran', $reviewerPameran->idreviewer_pameran)->lockForUpdate()->first();

                $sudahMulai = DB::table('review_pameran')->where('created_by', $reviewerPameran->idreviewer_pameran)->exists();

                if ($sudahMulai) {
                    throw new \RuntimeException('Review ini sudah dimulai.');
                }

                DB::table('review_pameran')->insert([
                    'created_by' => $reviewerPameran->idreviewer_pameran,
                    'status_ajuan' => '3',
                    'file_path' => $pameran->file_path_pertama,
                    'created_at' => now(),
                ]);

                $this->syncPameranStatus($pameran->idpameran);
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        }

        return $this->jsonResponse(200, 'Review berhasil dimulai.');
    }

    /**
     * Simpan draf penilaian (catatan umum + komentar/nilai per topik) —
     * belum final, dipanggil berulang selama SC masih menyusun keputusan.
     * Mirror NarasumberReviewController::simpanReview().
     */
    public function simpanReview(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview' => ['required', 'integer'],
            'catatan' => ['nullable', 'string'],
            'topik' => ['nullable', 'array'],
            'topik.*.isi_review' => ['nullable', 'string'],
            'topik.*.nilai' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $review = $this->reviewPameranUntukPengguna((int) $validated['idreview'], (int) $userdata['idpengguna']);

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        $statusPameran = DB::table('pameran')->where('idpameran', $review->idpameran)->value('status_ajuan');

        if (in_array($statusPameran, ['6', '7', '8', '9'], true)) {
            return $this->jsonResponse(404, 'Pengajuan ini tidak bisa diubah pada status saat ini.');
        }

        DB::transaction(function () use ($validated, $review, $userdata) {
            DB::table('review_pameran')->where('idreview', $review->idreview)->update([
                'status_ajuan' => '3',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($validated['topik'] ?? [] as $idtopik => $data) {
                DB::table('isi_review_pameran')->updateOrInsert(
                    ['idreview' => $review->idreview, 'idtopik_review' => $idtopik],
                    [
                        'isi_review' => $data['isi_review'] ?? null,
                        'nilai' => $data['nilai'] ?? null,
                        'created_by' => $userdata['idpengguna'],
                        'created_at' => now(),
                    ]
                );
            }

            $this->syncPameranStatus($review->idpameran);
        });

        return $this->jsonResponse(200, 'Draf penilaian berhasil disimpan.');
    }

    /**
     * Kirim keputusan final (Revisi/Memenuhi/Tidak Memenuhi) — menolak
     * kalau ada topik aktif yang nilainya belum diisi (komentar tetap
     * opsional, dikonfirmasi developer — mirror narasumber). Menghitung
     * nilai_akhir berbobot, lalu Controller::syncPameranStatus() yang
     * menentukan efeknya ke pameran (termasuk override "Tidak Memenuhi"
     * dan agregasi nilai_final/selisih_nilai kalau kedua reviewer Memenuhi).
     */
    public function kirimKeputusan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idreview' => ['required', 'integer'],
            'keputusan' => ['required', 'in:4,5,6'],
            'catatan' => ['nullable', 'string'],
        ]);

        $review = $this->reviewPameranUntukPengguna((int) $validated['idreview'], (int) $userdata['idpengguna']);

        if (! $review || ! in_array($review->status_ajuan, ['2', '3'], true)) {
            return $this->jsonResponse(404, 'Review ini tidak bisa diubah.');
        }

        $statusPameran = DB::table('pameran')->where('idpameran', $review->idpameran)->value('status_ajuan');

        if (in_array($statusPameran, ['6', '7', '8', '9'], true)) {
            return $this->jsonResponse(404, 'Pengajuan ini tidak bisa diubah pada status saat ini.');
        }

        $idTopikAktif = DB::table('topik_review')->where('status', true)->pluck('idtopik_review');

        $sudahTerisi = DB::table('isi_review_pameran')
            ->where('idreview', $review->idreview)
            ->whereIn('idtopik_review', $idTopikAktif)
            ->whereNotNull('nilai')
            ->pluck('idtopik_review');

        $belumTerisi = $idTopikAktif->diff($sudahTerisi);

        if ($belumTerisi->isNotEmpty()) {
            $namaBelumTerisi = DB::table('topik_review')->whereIn('idtopik_review', $belumTerisi)->pluck('nama_topik');

            return $this->jsonResponse(422, 'Lengkapi nilai untuk topik: '.$namaBelumTerisi->implode(', '));
        }

        $nilaiAkhir = round(
            (float) DB::table('isi_review_pameran as i')
                ->join('topik_review as t', 't.idtopik_review', '=', 'i.idtopik_review')
                ->where('i.idreview', $review->idreview)
                ->whereIn('i.idtopik_review', $idTopikAktif)
                ->selectRaw('COALESCE(SUM(i.nilai * t.bobot_dlm_persen / 100.0), 0) as total')
                ->value('total'),
            2
        );

        DB::transaction(function () use ($validated, $review, $nilaiAkhir) {
            DB::table('review_pameran')->where('idreview', $review->idreview)->update([
                'status_ajuan' => $validated['keputusan'],
                'catatan' => $validated['catatan'] ?? null,
                'nilai_akhir' => $nilaiAkhir,
            ]);

            $this->syncPameranStatus($review->idpameran);
        });

        $pameran = DB::table('pameran')->where('idpameran', $review->idpameran)->first();
        $label = self::LABEL_KEPUTUSAN[$validated['keputusan']];
        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Keputusan pengajuan pameran '{$pameran->tema}': {$label} (nilai akhir: {$nilaiAkhir})");

        return $this->jsonResponse(200, "Keputusan '{$label}' berhasil dikirim.");
    }

    /**
     * Serve a portofolio file untuk satu giliran review — hanya reviewer
     * pemilik thread tersebut yang boleh akses (dikonfirmasi developer:
     * SC hanya melihat thread-nya sendiri).
     */
    public function tampilPortofolio(Request $request)
    {
        $userdata = session('userdata');
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran as r')
            ->join('reviewer_pameran as rp', 'rp.idreviewer_pameran', '=', 'r.created_by')
            ->where('r.idreview', (int) $idreview)
            ->where('rp.idpengguna', $userdata['idpengguna'])
            ->select('r.file_path')
            ->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * Serve file pertama (pameran.file_path_pertama) — dipakai SC untuk
     * melihat berkas asli sebelum/selagi "Mulai Review".
     */
    public function tampilFilePertama(Request $request)
    {
        $userdata = session('userdata');
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $idpameran = (int) $idpameran;

        if (! $this->reviewerPameranUntukPengguna($idpameran, $userdata['idpengguna'])) {
            abort(404);
        }

        $pameran = DB::table('pameran')->where('idpameran', $idpameran)->first();

        if (! $pameran || ! $pameran->file_path_pertama || ! Storage::disk('local')->exists($pameran->file_path_pertama)) {
            abort(404);
        }

        return Storage::disk('local')->response($pameran->file_path_pertama);
    }

    /**
     * The review_pameran row for $idreview, only if the requesting pengguna
     * is the reviewer that owns its thread (joined via reviewer_pameran —
     * reviewers are Admin-assigned, not self-claimed, dikonfirmasi
     * developer).
     */
    private function reviewPameranUntukPengguna(int $idreview, int $idpengguna): ?object
    {
        return DB::table('review_pameran as r')
            ->join('reviewer_pameran as rp', 'rp.idreviewer_pameran', '=', 'r.created_by')
            ->where('r.idreview', $idreview)
            ->where('rp.idpengguna', $idpengguna)
            ->select('r.*', 'rp.idpameran', 'rp.idreviewer_pameran')
            ->first();
    }
}
