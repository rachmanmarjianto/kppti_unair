<?php

namespace App\Http\Controllers;

use App\Services\BniVirtualAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranController extends Controller
{
    private const TAGIHAN_STATUS_EXPIRED = 5;

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

        $penjagaStand = ($pameran && $pameran->status_ajuan === '5')
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

        $riwayat = collect();
        $sedangDireview = $pameran && (
            $pameran->status_ajuan === '3'
            || ($pameran->status_ajuan === '2' && $pameran->direview_oleh !== null)
        );
        $draftSaatIni = null;

        if ($pameran) {
            $semuaRiwayat = DB::table('review_pameran')
                ->where('idpameran', $pameran->idpameran)
                ->orderBy('idreview')
                ->get()
                ->map(function ($baris) {
                    $baris->token = $this->encryptRouteValue($baris->idreview);
                    $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6'], true)
                        ? $this->kriteriaUntukReview($baris->idreview)
                        : collect();

                    return $baris;
                });

            $terakhir = $semuaRiwayat->last();

            if ($terakhir && $terakhir->status_ajuan === '1') {
                $draftSaatIni = $terakhir;
                $riwayat = $semuaRiwayat->slice(0, -1)->values();
            } else {
                $riwayat = $semuaRiwayat;
            }
        }

        $bisaEdit = ! $pameran || in_array($pameran->status_ajuan, ['1', '4'], true);

        return view('peserta.pameran', compact(
            'menu', 'submenu', 'pameran', 'tagihan', 'pesertaOptions', 'klusterOptions', 'riwayat',
            'sedangDireview', 'draftSaatIni', 'bisaEdit', 'penjagaStand'
        ));
    }

    /**
     * Save (or start) the current draft turn — creates the `pameran` row on
     * the very first save, and either updates the open Draft row or starts a
     * new one when the previous turn ended in Revisi (see
     * docs/features/007-pengajuan-pameran.md §8).
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
                        'status_ajuan' => '1',
                    ]);
                }

                $terakhir = DB::table('review_pameran')
                    ->where('idpameran', $pameran->idpameran)
                    ->orderByDesc('idreview')
                    ->first();

                if ($terakhir && $terakhir->status_ajuan === '1') {
                    $idreview = $terakhir->idreview;
                } elseif (! $terakhir || $terakhir->status_ajuan === '4') {
                    $idreview = DB::table('review_pameran')->insertGetId([
                        'idpameran' => $pameran->idpameran,
                        'status_ajuan' => '1',
                        'created_by' => $userdata['idpengguna'],
                        'created_at' => now(),
                    ], 'idreview');
                } else {
                    throw new \RuntimeException('Pengajuan ini tidak bisa diubah pada status saat ini.');
                }

                if ($request->hasFile('portofolio')) {
                    $path = $this->simpanPortofolioPameran($pameran->idpameran, $idreview, $request->file('portofolio'));
                    DB::table('review_pameran')->where('idreview', $idreview)->update(['file_path' => $path]);
                } elseif (! $terakhir || $terakhir->status_ajuan !== '1' || ! $terakhir->file_path) {
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
     * Submit the open Draft turn — moves it to Pengajuan and issues a
     * tagihan (first submission only; later Revisi→Pengajuan cycles reuse
     * the same tagihan, see docs/features/007-pengajuan-pameran.md §4).
     */
    public function ajukan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Belum ada pengajuan pameran untuk diajukan.');
        }

        $draft = DB::table('review_pameran')
            ->where('idpameran', $pameran->idpameran)
            ->orderByDesc('idreview')
            ->first();

        if (! $draft || $draft->status_ajuan !== '1') {
            return $this->jsonResponse(422, 'Tidak ada draf yang bisa diajukan saat ini.');
        }

        if (! $pameran->tema || ! $pameran->abstract || ! $pameran->idpeserta_PIC || ! $pameran->idkluster_pameran || ! $draft->file_path) {
            return $this->jsonResponse(422, 'Lengkapi tema, kluster, PIC, Risalah Singkat Pameran, dan Form Keikutsertaan sebelum mengajukan.');
        }

        $sudahPernahDiajukan = DB::table('tagihan')->where('idpameran', $pameran->idpameran)->exists();

        if (! $sudahPernahDiajukan && ! $this->jadwalSedangBuka(3)) {
            return $this->jsonResponse(422, 'Sesi pengajuan pameran sedang ditutup. Pengajuan awal hanya bisa dilakukan dalam periode yang ditentukan panitia.');
        }

        $tagihanBaruDibuat = false;
        $perluBayar = false;

        try {
            $pic = $this->dataPicPameran($pameran);

            DB::transaction(function () use ($pameran, $draft, $idInstitusiAsal, $userdata, $pic, &$tagihanBaruDibuat, &$perluBayar) {
                DB::table('review_pameran')->where('idreview', $draft->idreview)->update(['status_ajuan' => '2']);
                DB::table('pameran')->where('idpameran', $pameran->idpameran)->update(['status_ajuan' => '2']);

                $tagihan = $this->tagihanTerbaru($pameran->idpameran);
                $klusterBerbayar = (int) $pameran->idkluster_pameran === self::IDKLUSTER_BERBAYAR;

                if (! $tagihan) {
                    // Belum pernah ada tagihan sama sekali — pengajuan pertama kali.
                    $tagihanBaruDibuat = true;
                    $perluBayar = $klusterBerbayar;
                } elseif ($klusterBerbayar && (int) $tagihan->status === 3 && ! $this->pernahDibayar($pameran->idpameran)) {
                    // Kluster baru diganti jadi berbayar, padahal tagihan yang ada
                    // sekarang cuma auto-lunas (kluster lama tidak berbayar) —
                    // belum pernah ada pembayaran sungguhan. Terbitkan tagihan
                    // baru yang sungguh perlu dibayar (bukan update baris lama,
                    // sama seperti requestVaBaru() — satu pameran bisa punya
                    // beberapa baris tagihan berturutan).
                    $tagihanBaruDibuat = true;
                    $perluBayar = true;
                }

                if ($tagihanBaruDibuat && $perluBayar) {
                    $idtagihan = DB::table('tagihan')->insertGetId([
                        'idinstitusi_asal' => $idInstitusiAsal,
                        'idpameran' => $pameran->idpameran,
                        'created_at' => now(),
                        'created_by' => $userdata['idpengguna'],
                        'status' => 1,
                        'tagihan' => config('services.biaya_pameran'),
                        'sisa_tagihan' => config('services.biaya_pameran'),
                    ], 'idtagihan');

                    $tagihan = DB::table('tagihan')->where('idtagihan', $idtagihan)->first();

                    $va_arr = app(BniVirtualAccountService::class)->requestVa($tagihan->idtagihan, $pic->nama, $pic->email, $pic->no_wa);

                    if ($va_arr['code'] !== 200) {
                        throw new \RuntimeException('Gagal membuat nomor Virtual Account baru: '.$va_arr['message']);
                    }

                    DB::table('tagihan')->where('idtagihan', $tagihan->idtagihan)->update([
                        'va' => $va_arr['data']['va_number'],
                        'expired_date' => $va_arr['data']['datetime_expired'],
                    ]);
                } elseif ($tagihanBaruDibuat) {
                    // Kluster tidak dikenakan biaya — tagihan langsung lunas tanpa
                    // VA, supaya pengajuan langsung bisa direview SC.
                    DB::table('tagihan')->insertGetId([
                        'idinstitusi_asal' => $idInstitusiAsal,
                        'idpameran' => $pameran->idpameran,
                        'created_at' => now(),
                        'created_by' => $userdata['idpengguna'],
                        'status' => 3,
                        'tagihan' => 0,
                        'sisa_tagihan' => 0,
                    ], 'idtagihan');
                }

                $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], "Mengajukan pameran: {$pameran->tema}");
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengajukan pameran.');
        }

        if ($perluBayar) {
            $pesan = 'Pengajuan pameran berhasil dikirim. Silakan selesaikan pembayaran agar bisa direview SC.';
        } elseif ($tagihanBaruDibuat) {
            $pesan = 'Pengajuan pameran berhasil dikirim. Kluster ini tidak dikenakan biaya, pengajuan langsung dapat direview SC.';
        } else {
            $pesan = 'Pengajuan pameran berhasil dikirim ulang untuk direview SC.';
        }

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Apakah pameran ini pernah punya pembayaran sungguhan (lintas semua
     * baris tagihan miliknya, bukan cuma yang terbaru) — dipakai untuk
     * membedakan tagihan yang lunas karena kluster gratis (auto-lunas, tidak
     * pernah ada baris `pembayaran`) dari yang benar-benar sudah dibayar.
     */
    private function pernahDibayar(int $idpameran): bool
    {
        return DB::table('pembayaran as pb')
            ->join('tagihan as t', 't.idtagihan', '=', 'pb.idtagihan')
            ->where('t.idpameran', $idpameran)
            ->exists();
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
     * kontingen sendiri (PIC boleh ikut dipilih), cuma setelah Diterima.
     */
    public function tambahPenjaga(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran || $pameran->status_ajuan !== '5') {
            return $this->jsonResponse(422, 'Pengajuan harus sudah Diterima.');
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
     * Simpan tanggal loading barang — hanya setelah Diterima, dan terkunci
     * (sama seperti penjaga stand) begitu admin menetapkan nomor stand.
     */
    public function simpanJadwalLoading(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'jadwal_loading' => ['required', 'date'],
        ]);

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran || $pameran->status_ajuan !== '5') {
            return $this->jsonResponse(422, 'Pengajuan harus sudah Diterima.');
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
     * Serve a portofolio file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Scoped to the kontingen that owns the pameran;
     * SC/admin access the same file via their own controllers.
     */
    public function tampilPortofolio(Request $request)
    {
        $userdata = session('userdata');
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran as r')
            ->join('pameran as p', 'p.idpameran', '=', 'r.idpameran')
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
     * Data kontak PIC pameran (nama/email/no_wa) — dikirim ke BNI saat
     * request VA, bukan data pengguna yang sedang login, karena PIC yang
     * jadi penanggung jawab pembayaran, bukan sembarang anggota kontingen
     * yang mungkin mengeklik tombol.
     */
    private function dataPicPameran(object $pameran): object
    {
        $pic = DB::table('peserta as pe')
            ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
            ->where('pe.idpeserta', $pameran->idpeserta_PIC)
            ->select('p.nama', 'p.email', 'p.no_wa')
            ->first();

        if (! $pic) {
            throw new \RuntimeException('Data PIC pameran tidak ditemukan.');
        }

        return $pic;
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
}
