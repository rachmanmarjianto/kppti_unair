<?php

namespace App\Http\Controllers;

use App\Services\BniVirtualAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranController extends Controller
{
    private const TAGIHAN_STATUS_EXPIRED = 5;

    private const TAGIHAN_STATUS_DITANGGUHKAN = 6;

    private const IDKLUSTER_BERBAYAR = 5;

    /**
     * Show the kontingen's pameran submission — one per institusi. Shows an
     * editable form when there's no submission yet, or the current one is
     * Draft/Revisi; otherwise a read-only status + history view. The last
     * history row is hidden entirely while an SC is still composing their
     * decision (status Review) — see docs/features/007-pengajuan-pameran.md §6.
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = '';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran as p')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->leftJoin('kluster_pameran as kp', 'kp.idkluster_pameran', '=', 'p.idkluster_pameran')
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->select('p.*', 'pic.nama as nama_pic', 'kp.nomor_kluster', 'kp.tema_kluster')
            ->first();

        $tagihan = $pameran ? $this->tagihanTerbaru($pameran->idpameran) : null;

        if ($tagihan) {
            $tagihan = $this->cekKadaluwarsaTagihan($tagihan, $userdata['idpengguna']);
        }

        $penjagaStand = ($pameran && $pameran->status_ajuan === '9')
            ? DB::table('petugas_jaga as pj')
                ->join('peserta as pe', 'pe.idpeserta', '=', 'pj.idpeserta')
                ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
                ->where('pj.idpameran', $pameran->idpameran)
                ->select('pj.idpetugas_jaga', 'pj.idpeserta', 'p.nama')
                ->orderBy('pj.idpetugas_jaga')
                ->get()
            : collect();

        $pesertaOptions = $this->pesertaAktifQuery($idInstitusiAsal)
            ->select('pe.idpeserta', 'p.nama')
            ->orderBy('p.nama')
            ->get();

        $klusterOptions = DB::table('kluster_pameran')
            ->where('status', true)
            ->orderBy('nomor_kluster')
            ->get();

        $reviewer1 = $pameran ? $this->riwayatReviewerPameran($pameran->idpameran, 1) : null;
        $reviewer2 = $pameran ? $this->riwayatReviewerPameran($pameran->idpameran, 2) : null;
        $tokenFilePertama = $pameran ? $this->encryptRouteValue($pameran->idpameran) : null;

        $sedangDireview = $pameran && $pameran->status_ajuan === '3';
        $bisaEdit = ! $pameran || $pameran->status_ajuan === '1';

        return view('peserta.pameran', compact(
            'menu', 'submenu', 'pameran', 'tagihan', 'pesertaOptions', 'klusterOptions',
            'reviewer1', 'reviewer2', 'tokenFilePertama', 'sedangDireview', 'bisaEdit', 'penjagaStand'
        ));
    }

    /**
     * Riwayat satu thread reviewer (reviewer_ke 1 atau 2) untuk sebuah
     * pameran — null kalau Admin belum memetakan reviewer di slot itu
     * (dikonfirmasi developer: 2 reviewer independen, masing-masing
     * riwayat/revisi terpisah, lihat Controller::syncPameranStatus()).
     *
     * @return array{reviewerPameran: object, namaSc: string, riwayat: Collection}|null
     */
    private function riwayatReviewerPameran(int $idpameran, int $reviewerKe): ?array
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

        return [
            'reviewerPameran' => $reviewerPameran,
            'tokenReviewer' => $this->encryptRouteValue($reviewerPameran->idreviewer_pameran),
            'namaSc' => $reviewerPameran->nama_sc,
            'riwayat' => $riwayat,
        ];
    }

    /**
     * Save (or start) the Draft — creates the `pameran` row on the very
     * first save, else updates it in place. The first-ever uploaded file
     * is stored on `pameran.file_path_pertama` directly (dikonfirmasi
     * developer) — there's no review_pameran row yet at this stage, since
     * SC reviewer threads only start once Admin maps reviewers and an SC
     * clicks "Mulai Review" (see PameranReviewController::mulaiReview()).
     */
    public function simpanDraft(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idpeserta_PIC' => ['required', 'integer'],
            'idkluster_pameran' => ['required', 'integer'],
            'tema' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'portofolio' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $validated['abstract'] = $this->sanitizeRichText($validated['abstract']);

        $pic = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta_PIC'], $idInstitusiAsal);

        if (! $pic) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        $klusterAktif = DB::table('kluster_pameran')
            ->where('idkluster_pameran', $validated['idkluster_pameran'])
            ->where('status', true)
            ->exists();

        if (! $klusterAktif) {
            return $this->jsonResponse(422, 'Kluster pameran yang dipilih tidak valid.');
        }

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if ($pameran && $pameran->status_ajuan !== '1') {
            return $this->jsonResponse(422, 'Pengajuan ini tidak bisa diubah pada status saat ini.');
        }

        try {
            DB::transaction(function () use ($request, $validated, $idInstitusiAsal, $userdata, &$pameran) {
                if (! $pameran) {
                    $idpameran = DB::table('pameran')->insertGetId([
                        'idinstitusi_asal' => $idInstitusiAsal,
                        'tema' => $validated['tema'],
                        'abstract' => $validated['abstract'],
                        'idpeserta_PIC' => $validated['idpeserta_PIC'],
                        'idkluster_pameran' => $validated['idkluster_pameran'],
                        'status_ajuan' => '1',
                    ], 'idpameran');

                    $pameran = DB::table('pameran')->where('idpameran', $idpameran)->first();
                } else {
                    DB::table('pameran')->where('idpameran', $pameran->idpameran)->update([
                        'tema' => $validated['tema'],
                        'abstract' => $validated['abstract'],
                        'idpeserta_PIC' => $validated['idpeserta_PIC'],
                        'idkluster_pameran' => $validated['idkluster_pameran'],
                    ]);
                }

                if ($request->hasFile('portofolio')) {
                    $path = $this->simpanFilePertamaPameran($pameran->idpameran, $request->file('portofolio'));
                    DB::table('pameran')->where('idpameran', $pameran->idpameran)->update(['file_path_pertama' => $path]);
                } elseif (! $pameran->file_path_pertama) {
                    throw new \RuntimeException('Form Keikutsertaan (PDF/DOC/DOCX) wajib diunggah.');
                }

                $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Menyimpan draf pengajuan pameran: {$validated['tema']}");
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menyimpan draf pengajuan pameran.');
        }

        return $this->jsonResponse(200, 'Draf pengajuan pameran berhasil disimpan.');
    }

    /**
     * Submit the Draft — moves `pameran.status_ajuan` to Pengajuan (2) and
     * issues a tagihan (first submission only). No `review_pameran` row is
     * touched here anymore — SC reviewer threads only start once Admin
     * maps reviewers and an SC clicks "Mulai Review".
     */
    public function ajukan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran || $pameran->status_ajuan !== '1') {
            return $this->jsonResponse(422, 'Tidak ada draf yang bisa diajukan saat ini.');
        }

        if (! $pameran->tema || ! $pameran->abstract || ! $pameran->idpeserta_PIC || ! $pameran->idkluster_pameran || ! $pameran->file_path_pertama) {
            return $this->jsonResponse(422, 'Lengkapi tema, kluster, PIC, Risalah Singkat Pameran, dan Form Keikutsertaan sebelum mengajukan.');
        }

        $sudahPernahDiajukan = DB::table('tagihan')->where('idpameran', $pameran->idpameran)->exists();

        if (! $sudahPernahDiajukan && ! $this->jadwalSedangBuka(3)) {
            return $this->jsonResponse(422, 'Sesi pengajuan pameran sedang ditutup. Pengajuan awal hanya bisa dilakukan dalam periode yang ditentukan panitia.');
        }

        $tagihanBaruDibuat = false;
        $klusterBerbayar = (int) $pameran->idkluster_pameran === self::IDKLUSTER_BERBAYAR;

        try {
            DB::transaction(function () use ($pameran, $idInstitusiAsal, $userdata, $klusterBerbayar, &$tagihanBaruDibuat) {
                DB::table('pameran')->where('idpameran', $pameran->idpameran)->update(['status_ajuan' => '2']);

                $tagihan = $this->tagihanTerbaru($pameran->idpameran);

                if (! $tagihan) {
                    $tagihanBaruDibuat = true;

                    // Kluster berbayar (5) tidak lagi diminta bayar saat
                    // pengajuan — tagihan dibuat dengan status Ditangguhkan
                    // (6), tanpa VA, supaya pengajuan tetap bisa langsung
                    // direview SC (dikonfirmasi developer; lihat juga
                    // PameranReviewController yang menerima status 3 & 6).
                    // Tagihan baru benar-benar ditagihkan (VA diterbitkan)
                    // kalau hasil review-nya Diterima — menyusul setelah
                    // metode review diubah (pekerjaan terpisah).
                    DB::table('tagihan')->insertGetId([
                        'idinstitusi_asal' => $idInstitusiAsal,
                        'idpameran' => $pameran->idpameran,
                        'created_at' => now(),
                        'created_by' => $userdata['idpengguna'],
                        'status' => $klusterBerbayar ? self::TAGIHAN_STATUS_DITANGGUHKAN : 3,
                        'tagihan' => $klusterBerbayar ? config('services.biaya_pameran') : 0,
                        'sisa_tagihan' => $klusterBerbayar ? config('services.biaya_pameran') : 0,
                    ], 'idtagihan');
                }

                $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], "Mengajukan pameran: {$pameran->tema}");
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengajukan pameran.');
        }

        if ($tagihanBaruDibuat && $klusterBerbayar) {
            $pesan = 'Pengajuan pameran berhasil dikirim. Tagihan untuk kluster ini ditangguhkan dan baru ditagihkan jika pengajuan Diterima — pengajuan tetap langsung dapat direview SC.';
        } elseif ($tagihanBaruDibuat) {
            $pesan = 'Pengajuan pameran berhasil dikirim. Pengajuan langsung dapat direview SC.';
        } else {
            $pesan = 'Pengajuan pameran berhasil dikirim ulang untuk direview SC.';
        }

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Halaman detail tagihan + riwayat pembayaran — dipisah dari halaman
     * utama Pengajuan Pameran. Cek kadaluwarsa VA dijalankan lagi di sini
     * (sama seperti index()) sesuai arahan developer.
     */
    public function tagihan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran) {
            abort(404);
        }

        $tagihan = $this->tagihanTerbaru($pameran->idpameran);

        if (! $tagihan) {
            abort(404);
        }

        $tagihan = $this->cekKadaluwarsaTagihan($tagihan, $userdata['idpengguna']);

        // Gabungkan riwayat pembayaran dari semua baris tagihan milik pameran
        // ini (bukan cuma baris tagihan yang aktif sekarang) — begitu VA lama
        // expired dan diganti baris baru (requestVaBaru()), pembayaran yang
        // sudah pernah masuk lewat VA lama tidak boleh hilang dari riwayat.
        $pembayaran = DB::table('pembayaran as pb')
            ->join('tagihan as t', 't.idtagihan', '=', 'pb.idtagihan')
            ->where('t.idpameran', $pameran->idpameran)
            ->orderBy('pb.datetime_payment')
            ->select('pb.*')
            ->get();

        $menu = 'pameran';
        $submenu = '';

        return view('peserta.pameran-tagihan', compact('menu', 'submenu', 'pameran', 'tagihan', 'pembayaran'));
    }

    /**
     * Minta nomor VA baru untuk tagihan yang sudah expired — satu-satunya
     * cara tagihan bisa dibayar lagi setelah VA lamanya kadaluwarsa.
     */
    public function requestVaBaru(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran tidak ditemukan.');
        }

        $tagihanLama = $this->tagihanTerbaru($pameran->idpameran);

        if (! $tagihanLama) {
            return $this->jsonResponse(404, 'Tagihan tidak ditemukan.');
        }

        $tagihanLama = $this->cekKadaluwarsaTagihan($tagihanLama, $userdata['idpengguna']);

        if ((int) $tagihanLama->status !== self::TAGIHAN_STATUS_EXPIRED) {
            return $this->jsonResponse(422, 'Tagihan ini belum expired, tidak perlu membuat VA baru.');
        }

        try {
            $pic = $this->dataPicPameran($pameran);

            DB::transaction(function () use ($tagihanLama, $idInstitusiAsal, $userdata, $pic) {
                // Baris tagihan baru dulu (bukan update baris lama) — bank BNI
                // menolak permintaan VA baru dengan trx_id (idtagihan) yang
                // sama. Relasi pameran→tagihan sudah one-to-many; sisa_tagihan
                // baris lama (jumlah yang masih belum terbayar) dibawa jadi
                // nilai tagihan baris baru ini.

                if ($tagihanLama->sisa_tagihan == $tagihanLama->tagihan) {
                    $sisa_tagihan = config('services.biaya_pameran');
                } else {
                    $sisa_tagihan = $tagihanLama->sisa_tagihan;
                }

                $idtagihanBaru = DB::table('tagihan')->insertGetId([
                    'idinstitusi_asal' => $idInstitusiAsal,
                    'idpameran' => $tagihanLama->idpameran,
                    'created_at' => now(),
                    'created_by' => $userdata['idpengguna'],
                    'status' => 1,
                    'tagihan' => $sisa_tagihan,
                    'sisa_tagihan' => $sisa_tagihan,
                ], 'idtagihan');

                $va_arr = app(BniVirtualAccountService::class)->requestVa($idtagihanBaru, $pic->nama, $pic->email, $pic->no_wa);

                if ($va_arr['code'] !== 200) {
                    throw new \RuntimeException('Gagal membuat nomor Virtual Account baru: '.$va_arr['message']);
                }

                DB::table('tagihan')->where('idtagihan', $idtagihanBaru)->update([
                    'va' => $va_arr['data']['va_number'],
                    'expired_date' => $va_arr['data']['datetime_expired'],
                ]);

                $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Membuat tagihan dan nomor Virtual Account baru menggantikan tagihan pameran yang expired.');
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal membuat nomor Virtual Account baru.');
        }

        return $this->jsonResponse(200, 'Nomor Virtual Account baru berhasil dibuat.');
    }

    /**
     * Cek manual status pembayaran lewat inquiry billing ke BNI — untuk
     * kasus notifikasi callback BNI gagal terkirim ke server kita. Submit
     * form biasa (bukan AJAX), balik ke halaman yang sama dengan flash
     * status. Logika baca hasil inquiry & update tagihan/pembayaran ada di
     * Controller::prosesInquiryBillingTagihan() (dipakai bersama dengan
     * TagihanPameranController::cekStatusBayar() di sisi admin).
     */
    public function cekStatusPembayaran(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idtagihan' => ['required', 'integer'],
        ]);

        $tagihan = DB::table('tagihan')
            ->where('idtagihan', $validated['idtagihan'])
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->first();

        if (! $tagihan) {
            abort(404);
        }

        try {
            $this->prosesInquiryBillingTagihan($tagihan);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('peserta.pameran.tagihan')->with('status', [
                'status' => 'danger',
                'message' => 'Gagal mengecek status pembayaran ke BNI. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('peserta.pameran.tagihan')->with('status', [
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diperbarui, silahkan Cek Status Pembayaran terbaru!',
        ]);
    }

    /**
     * Tambah satu penjaga stand — maksimal 2 orang per pameran, dari
     * kontingen sendiri (PIC boleh ikut dipilih), cuma setelah Terpilih (9).
     */
    public function tambahPenjaga(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran || $pameran->status_ajuan !== '9') {
            return $this->jsonResponse(422, 'Pengajuan harus sudah Terpilih.');
        }

        if ($pameran->nomor_stand) {
            return $this->jsonResponse(422, 'Nomor stand sudah ditetapkan. Hubungi admin untuk mengubah penjaga stand.');
        }

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $idInstitusiAsal);

        if (! $peserta) {
            return $this->jsonResponse(422, 'Penjaga stand harus peserta dari kontingen Anda sendiri.');
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

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], "Menambahkan {$peserta->nama} sebagai penjaga stand pameran.");

        return $this->jsonResponse(200, 'Penjaga stand berhasil ditambahkan.');
    }

    /**
     * Simpan tanggal loading barang — hanya setelah Terpilih (9), dan
     * terkunci (sama seperti penjaga stand) begitu admin menetapkan nomor
     * stand.
     */
    public function simpanJadwalLoading(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'jadwal_loading' => ['required', 'date'],
        ]);

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran || $pameran->status_ajuan !== '9') {
            return $this->jsonResponse(422, 'Pengajuan harus sudah Terpilih.');
        }

        if ($pameran->nomor_stand) {
            return $this->jsonResponse(422, 'Nomor stand sudah ditetapkan. Hubungi admin untuk mengubah tanggal loading.');
        }

        DB::table('pameran')->where('idpameran', $pameran->idpameran)->update([
            'jadwal_loading' => $validated['jadwal_loading'],
        ]);

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], "Menyimpan tanggal loading pameran: {$validated['jadwal_loading']}");

        return $this->jsonResponse(200, 'Tanggal loading berhasil disimpan.');
    }

    /**
     * Hapus satu penjaga stand — hanya baris milik pameran institusi sesi
     * ini yang boleh dihapus.
     */
    public function hapusPenjaga(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idpetugas_jaga' => ['required', 'integer'],
        ]);

        $petugas = DB::table('petugas_jaga as pj')
            ->join('pameran as p', 'p.idpameran', '=', 'pj.idpameran')
            ->where('pj.idpetugas_jaga', $validated['idpetugas_jaga'])
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->select('pj.idpetugas_jaga', 'p.nomor_stand')
            ->first();

        if (! $petugas) {
            return $this->jsonResponse(404, 'Penjaga stand tidak ditemukan.');
        }

        if ($petugas->nomor_stand) {
            return $this->jsonResponse(422, 'Nomor stand sudah ditetapkan. Hubungi admin untuk mengubah penjaga stand.');
        }

        DB::table('petugas_jaga')->where('idpetugas_jaga', $petugas->idpetugas_jaga)->delete();

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Menghapus satu penjaga stand pameran.');

        return $this->jsonResponse(200, 'Penjaga stand berhasil dihapus.');
    }

    /**
     * Serve a portofolio file for a specific review turn — never exposed
     * as a static public URL (CONVENTIONS.md §7). Scoped to the kontingen
     * that owns the pameran, reached via review_pameran.created_by →
     * reviewer_pameran.idpameran (review_pameran no longer has its own
     * idpameran column, dikonfirmasi developer).
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
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->where('r.idreview', (int) $idreview)
            ->where('p.idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->select('r.file_path')
            ->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * Serve the very first uploaded file (pameran.file_path_pertama) —
     * shown in both reviewer tabs' intro and used by SC when they click
     * "Mulai Review" (file_path copied from here into their own
     * review_pameran row).
     */
    public function tampilFilePertama(Request $request)
    {
        $userdata = session('userdata');
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $pameran = DB::table('pameran')
            ->where('idpameran', (int) $idpameran)
            ->where('idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->first();

        if (! $pameran || ! $pameran->file_path_pertama || ! Storage::disk('local')->exists($pameran->file_path_pertama)) {
            abort(404);
        }

        return Storage::disk('local')->response($pameran->file_path_pertama);
    }

    /**
     * Halaman untuk membalas permintaan revisi dari satu reviewer —
     * menampilkan catatan + breakdown kriteria permintaan revisi tersebut
     * (konteks baca saja) sebelum peserta mengunggah file baru.
     */
    public function tampilBalasRevisi(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $idreviewerPameran = $this->decryptRouteValue($request->query('token'));

        if ($idreviewerPameran === null) {
            abort(404);
        }

        $reviewerPameran = DB::table('reviewer_pameran as rp')
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->join('pengguna as sc', 'sc.idpengguna', '=', 'rp.idpengguna')
            ->where('rp.idreviewer_pameran', (int) $idreviewerPameran)
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->select('rp.idreviewer_pameran', 'rp.idpameran', 'sc.nama as nama_sc', 'p.tema')
            ->first();

        if (! $reviewerPameran) {
            abort(404);
        }

        $permintaanRevisi = DB::table('review_pameran')
            ->where('created_by', $reviewerPameran->idreviewer_pameran)
            ->orderByDesc('idreview')
            ->first();

        if (! $permintaanRevisi || $permintaanRevisi->status_ajuan !== '4') {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = '';
        $token = $this->encryptRouteValue($reviewerPameran->idreviewer_pameran);
        $kriteria = $this->kriteriaUntukReviewPameran($permintaanRevisi->idreview);

        return view('peserta.pameran-balas-revisi', compact(
            'menu', 'submenu', 'token', 'reviewerPameran', 'permintaanRevisi', 'kriteria'
        ));
    }

    /**
     * Balas permintaan revisi dari salah satu reviewer — upload file baru
     * (wajib) + catatan opsional untuk reviewer, menambahkan baris baru di
     * thread reviewer tersebut. Catatan peserta disimpan di kolom
     * `catatan_peserta`, terpisah dari `catatan` yang dipakai SC
     * (dikonfirmasi developer). Hanya bisa dilakukan ketika giliran
     * terakhir thread itu berstatus Revisi (4).
     */
    public function balasRevisi(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $idreviewerPameran = $this->decryptRouteValue($request->input('token'));

        if ($idreviewerPameran === null) {
            abort(404);
        }

        $validated = $request->validate([
            'portofolio' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'catatan' => ['nullable', 'string'],
        ]);

        $reviewerPameran = DB::table('reviewer_pameran as rp')
            ->join('pameran as p', 'p.idpameran', '=', 'rp.idpameran')
            ->where('rp.idreviewer_pameran', (int) $idreviewerPameran)
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->select('rp.idreviewer_pameran', 'rp.idpameran')
            ->first();

        if (! $reviewerPameran) {
            return $this->jsonResponse(404, 'Reviewer tidak ditemukan.');
        }

        $terakhir = DB::table('review_pameran')
            ->where('created_by', $reviewerPameran->idreviewer_pameran)
            ->orderByDesc('idreview')
            ->first();

        if (! $terakhir || $terakhir->status_ajuan !== '4') {
            return $this->jsonResponse(422, 'Tidak ada permintaan revisi yang menunggu dibalas pada reviewer ini.');
        }

        try {
            DB::transaction(function () use ($request, $validated, $reviewerPameran, $idInstitusiAsal, $userdata) {
                $idreview = DB::table('review_pameran')->insertGetId([
                    'created_by' => $reviewerPameran->idreviewer_pameran,
                    'status_ajuan' => '2',
                    'catatan_peserta' => $validated['catatan'] ?? null,
                    'created_at' => now(),
                ], 'idreview');

                $path = $this->simpanPortofolioPameran($reviewerPameran->idpameran, $idreview, $request->file('portofolio'));
                DB::table('review_pameran')->where('idreview', $idreview)->update(['file_path' => $path]);

                $this->syncPameranStatus($reviewerPameran->idpameran);

                $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Membalas permintaan revisi pameran.');
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengirim balasan revisi.');
        }

        return $this->jsonResponse(200, 'Balasan revisi berhasil dikirim.');
    }

    /**
     * Unduh file template portofolio pameran (PT / Non PT) — berkas statis
     * bersama untuk semua peserta, bukan data per-kontingen, disimpan di
     * `storage/app/private/dokumen-template/`. `jenis` dibatasi whitelist
     * supaya tidak bisa dipakai menebak path berkas lain di disk yang sama.
     */
    public function unduhTemplate(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:pt,non-pt'],
        ]);

        $namaFile = [
            'pt' => 'Template_Portofolio_Expo_PT.docx',
            'non-pt' => 'Template_Portofolio_Expo_Non_PT.docx',
        ][$validated['jenis']];

        $path = "dokumen-template/{$namaFile}";

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $namaFile);
    }

    /**
     * Tandai tagihan expired kalau waktunya sudah lewat dan status masih
     * tertagih/terbayar sebagian — dipanggil setiap halaman pameran/detail
     * tagihan dibuka (bukan cuma sekali), jadi dijaga idempotent: status
     * lunas/batal/sudah-expired tidak diproses ulang.
     */
    private function cekKadaluwarsaTagihan(object $tagihan, int $idpengguna): object
    {
        if (in_array((int) $tagihan->status, [3, 4, self::TAGIHAN_STATUS_EXPIRED], true)) {
            return $tagihan;
        }

        if (! $tagihan->expired_date || now()->lessThanOrEqualTo($tagihan->expired_date)) {
            return $tagihan;
        }

        DB::transaction(function () use ($tagihan, $idpengguna) {
            DB::table('tagihan')->where('idtagihan', $tagihan->idtagihan)->update([
                'status' => self::TAGIHAN_STATUS_EXPIRED,
            ]);

            DB::table('log_ubah_status_by_pengguna')->insert([
                'done_at' => now(),
                'done_by' => $idpengguna,
                'idtagihan' => $tagihan->idtagihan,
                'status_awal' => $tagihan->status,
                'status_akhir' => self::TAGIHAN_STATUS_EXPIRED,
            ]);
        });

        return DB::table('tagihan')->where('idtagihan', $tagihan->idtagihan)->first();
    }

    /**
     * Store an uploaded portofolio file on the private `local` disk, keyed
     * deterministically by idpameran+idreview so re-uploading within the
     * same draft turn simply overwrites it (no stale leftover file).
     */
    private function simpanPortofolioPameran(int $idpameran, int $idreview, UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "portofolio-pameran/pameran-{$idpameran}-{$idreview}.{$ext}";

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }

    /**
     * Store the very first uploaded file directly on pameran.file_path_pertama
     * — keyed by idpameran only (no idreview yet at this stage), so
     * re-uploading before the first ajukan() simply overwrites it.
     */
    private function simpanFilePertamaPameran(int $idpameran, UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "portofolio-pameran/pameran-{$idpameran}-pertama.{$ext}";

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }
}
