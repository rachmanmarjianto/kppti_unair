<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AntrianRegisController extends Controller
{
    /**
     * `antrian_regis.status` — kode numerik, lihat comment kolom di skema
     * (`kppti_33.sql`) dan docs/features/019-registrasi-antrian-kontingen.md §2.1.
     */
    private const STATUS_ANTRI = '1';

    private const STATUS_DIPANGGIL = '2';

    private const STATUS_DILAYANI = '3';

    private const STATUS_TERLAYANI = '4';

    private const STATUS_TERLEWAT = '5';

    /**
     * Berapa detik satu koneksi SSE (`streamTampilan()`) dipertahankan
     * sebelum stream ditutup dari sisi server — browser (`EventSource`)
     * otomatis menyambung ulang, jadi ini bukan batas waktu tampilan,
     * hanya siklus hidup satu koneksi HTTP (menghindari satu koneksi
     * menahan worker server selamanya).
     */
    private const SSE_BATAS_WAKTU_DETIK = 90;

    /**
     * Jeda antar kiriman snapshot data lewat SSE.
     */
    private const SSE_JEDA_DETIK = 1;

    /**
     * Halaman landas /antrian — publik, tanpa login, pilih mau ke halaman
     * ambil nomor antrian atau halaman tampilan antrian.
     */
    public function landing()
    {
        return view('antrian-landing');
    }

    /**
     * Halaman 1 (F19) — publik, tanpa login, 1 field kode kontingen.
     */
    public function formAmbilNomor()
    {
        return view('antrian-ambil-nomor');
    }

    /**
     * AJAX — submit kode kontingen, daftarkan institusi ke antrian hari ini
     * (sekali per institusi per tanggal).
     */
    public function ambilNomor(Request $request)
    {
        $validated = $request->validate([
            'kode_kontingen' => ['required', 'string', 'size:7'],
        ]);

        $kodeKontingen = Str::upper(trim($validated['kode_kontingen']));

        $institusi = DB::table('institusi_asal')
            ->whereRaw('upper(trim(kode_kontingen)) = ?', [$kodeKontingen])
            ->first();

        if (! $institusi) {
            return $this->jsonResponse(404, 'Kode kontingen tidak ditemukan.');
        }

        // Gerbang yang sama dengan unduh kartu registrasi kontingen
        // (PesertaController::unduhKartuKontingen()) — kontingen yang
        // datanya belum lengkap belum berhak ambil nomor antrian kedatangan,
        // dikonfirmasi developer.
        $pesertaList = $this->pesertaDenganStatusLengkap($institusi->idinstitusi_asal);
        $belumLengkap = $pesertaList->where('lengkap', false);

        if ($pesertaList->isEmpty() || $belumLengkap->isNotEmpty()) {
            $pesan = $pesertaList->isEmpty()
                ? 'Belum ada peserta dalam kontingen ini.'
                : 'Data peserta kontingen ini belum lengkap. Harap lengkapi data peserta sebelum mengambil nomor antrian.';

            return $this->jsonResponse(422, $pesan);
        }

        return DB::transaction(function () use ($institusi) {
            // `antrian_regis` tidak punya baris penanda per-tanggal yang bisa
            // dikunci lewat SELECT ... FOR UPDATE ketika belum ada satu pun
            // baris untuk hari ini (gap lock problem) — dua institusi yang
            // mendaftar bersamaan di hari pertama bisa sama-sama menghitung
            // nomor_antrian = 1. Advisory lock Postgres yang diskop ke
            // tanggal hari ini menutup celah ini: transaksi kedua menunggu
            // transaksi pertama selesai sebelum ikut menghitung.
            DB::select('SELECT pg_advisory_xact_lock(?)', [crc32(today()->toDateString())]);

            $antrianHariIni = DB::table('antrian_regis')->whereDate('created_at', today())->get();

            $sudahDaftar = $antrianHariIni->contains('idinstitusi_asal', $institusi->idinstitusi_asal);

            if ($sudahDaftar) {
                return $this->jsonResponse(409, 'Institusi Anda telah daftar antrian.');
            }

            DB::table('antrian_regis')->insert([
                'idinstitusi_asal' => $institusi->idinstitusi_asal,
                'kode_kontingen' => $institusi->kode_kontingen,
                'status' => self::STATUS_ANTRI,
                'created_at' => now(),
                'nomor_antrian' => $antrianHariIni->count() + 1,
            ]);

            return $this->jsonResponse(200, 'Berhasil daftar antrian.');
        });
    }

    /**
     * Halaman 2 (F19) — publik, tanpa login, layar tampilan antrian 3 panel.
     */
    public function tampilan()
    {
        return view('antrian-tampilan');
    }

    /**
     * SSE — kirim snapshot 3 list (Antri/Dipanggil/Terlewat) tiap beberapa
     * detik supaya Halaman 2 bisa merender ulang tanpa reload penuh.
     */
    public function streamTampilan(): StreamedResponse
    {
        return response()->stream(function () {
            set_time_limit(0);

            if (ob_get_level() === 0) {
                ob_start();
            }

            $mulai = time();

            while (! connection_aborted() && (time() - $mulai) < self::SSE_BATAS_WAKTU_DETIK) {
                echo 'data: '.json_encode($this->snapshotTampilanAntrian())."\n\n";

                ob_flush();
                flush();

                sleep(self::SSE_JEDA_DETIK);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }

    /**
     * Data hari ini untuk Halaman 2: list Antri (urut nomor), Dipanggil
     * (institusi berstatus Dipanggil/Sedang Dilayani/Terlayani — tetap
     * tampil di panel ini sampai dibatalkan jadi Terlewat, dengan nomor
     * meja lewat `meja_regis`), dan Terlewat. Urutan tampil "terbaru di
     * atas" untuk panel Dipanggil diatur di JS Halaman 2 (tidak ada kolom
     * timestamp "waktu dipanggil" di skema untuk dijadikan ORDER BY
     * server), bukan di query ini.
     */
    private function snapshotTampilanAntrian(): array
    {
        $antri = DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->whereDate('ar.created_at', today())
            ->where('ar.status', self::STATUS_ANTRI)
            ->orderBy('ar.nomor_antrian')
            ->select('ar.idantrian_regis', 'ar.nomor_antrian', 'ia.nama_institusi')
            ->get();

        $dipanggil = DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->leftJoin('meja_regis as mr', 'mr.idmeja_regis', '=', 'ar.dipanggil_oleh')
            ->whereDate('ar.created_at', today())
            ->whereIn('ar.status', [self::STATUS_DIPANGGIL, self::STATUS_DILAYANI, self::STATUS_TERLAYANI])
            ->orderByDesc('ar.created_at')
            ->select('ar.idantrian_regis', 'ia.nama_institusi', 'mr.nomor_meja', 'ar.panggilan_ke', 'ar.status')
            ->get();

        $terlewat = DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->whereDate('ar.created_at', today())
            ->where('ar.status', self::STATUS_TERLEWAT)
            ->orderBy('ar.nomor_antrian')
            ->select('ar.idantrian_regis', 'ia.nama_institusi')
            ->get();

        return [
            'antri' => $antri,
            'dipanggil' => $dipanggil,
            'terlewat' => $terlewat,
        ];
    }
}
