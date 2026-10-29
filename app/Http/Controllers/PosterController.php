<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class PosterController extends Controller
{
    /**
     * Ukuran minimum kertas A0 (mm) — poster boleh lebih besar dari A0,
     * tidak boleh lebih kecil. `TOLERANSI_UKURAN_MM` hanya menutup selisih
     * pembulatan antar aplikasi pembuat PDF (Word, Canva, Illustrator, dll),
     * bukan untuk melonggarkan batas minimum itu sendiri.
     */
    private const A0_LEBAR_MM = 841.0;

    private const A0_TINGGI_MM = 1189.0;

    private const TOLERANSI_UKURAN_MM = 5.0;

    /**
     * Status narasumber yang berhak mengakses menu Poster — satu-satunya
     * keputusan akhir negatif ("Tidak Terpilih"), final/tidak pernah
     * berubah lagi (sama prinsipnya dengan status Diterima).
     */
    private const STATUS_TIDAK_TERPILIH = '8';

    /**
     * idref_tabel di tabel `file` untuk baris yang menunjuk ke `poster`.
     */
    private const IDREF_TABEL_POSTER = 2;

    /**
     * idjadwal_penting untuk periode pengiriman poster ("Pengiriman Poster").
     */
    private const IDJADWAL_POSTER = 4;

    public function index()
    {
        $userdata = session('userdata');

        $narasumber = $this->narasumberEligible($userdata['idpengguna']);

        if (! $narasumber) {
            abort(403);
        }

        $menu = 'poster';
        $submenu = '';

        $sesi = DB::table('acara as a')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->where('a.idacara', $narasumber->idacara)
            ->select('a.tema', 'parent.tema as parent_tema')
            ->first();

        $poster = DB::table('poster')->where('idnarasumber', $narasumber->idnarasumber)->first();

        $fileAktif = null;

        if ($poster) {
            $fileAktif = DB::table('file')
                ->where('idref_tabel', self::IDREF_TABEL_POSTER)
                ->where('idref', $poster->idposter)
                ->where('status', true)
                ->orderByDesc('idfile')
                ->first();

            if ($fileAktif) {
                $fileAktif->token = $this->encryptRouteValue($fileAktif->idfile);
            }
        }

        $jadwal = DB::table('jadwal_penting')->where('idjadwal_penting', self::IDJADWAL_POSTER)->first();
        $jadwalSedangBuka = $this->jadwalSedangBuka(self::IDJADWAL_POSTER);

        return view('peserta.poster', compact('menu', 'submenu', 'narasumber', 'sesi', 'fileAktif', 'jadwal', 'jadwalSedangBuka'));
    }

    /**
     * Simpan (atau ganti) file poster A0 — mirip `NarasumberController::simpanDraft()`
     * tapi tanpa draft/status sama sekali, poster hanya penyimpanan file.
     * Re-upload menandai `file` aktif sebelumnya `status=false` (bukan
     * dihapus) lalu menambah baris `file` baru.
     */
    public function simpan(Request $request)
    {
        $userdata = session('userdata');

        $narasumber = $this->narasumberEligible($userdata['idpengguna']);

        if (! $narasumber) {
            abort(403);
        }

        if (! $this->jadwalSedangBuka(self::IDJADWAL_POSTER)) {
            return $this->jsonResponse(422, 'Periode pengiriman poster sedang ditutup.');
        }

        $poster = DB::table('poster')->where('idnarasumber', $narasumber->idnarasumber)->first();

        if ($poster && $this->fileAktifPoster($poster->idposter)) {
            return $this->jsonResponse(422, 'Anda sudah mengirim poster. Hapus file yang ada terlebih dahulu untuk mengganti.');
        }

        $validated = $request->validate([
            'berkas' => ['required', 'file', 'mimes:pdf', 'max:51200'],
        ]);

        if (! $this->ukuranA0Valid($validated['berkas'])) {
            return $this->jsonResponse(422, 'Ukuran halaman PDF minimal A0 (841 x 1189 mm, Portrait). Periksa kembali ukuran dokumen Anda, atau gunakan template yang tersedia di halaman ini, sebelum mengunggah.');
        }

        try {
            DB::transaction(function () use ($narasumber, $poster, $validated, $userdata) {
                if (! $poster) {
                    $idposter = DB::table('poster')->insertGetId([
                        'idnarasumber' => $narasumber->idnarasumber,
                        'created_at' => now(),
                    ], 'idposter');
                } else {
                    $idposter = $poster->idposter;
                }

                $path = $this->simpanBerkasPoster($narasumber->idnarasumber, $idposter, $validated['berkas']);

                DB::table('file')->insert([
                    'path_file' => $path,
                    'status' => true,
                    'jenis' => 1,
                    'idref_tabel' => self::IDREF_TABEL_POSTER,
                    'idref' => $idposter,
                    'created_at' => now(),
                ]);

                $idpeserta = DB::table('peserta')->where('idpengguna', $userdata['idpengguna'])->value('idpeserta');

                if ($idpeserta) {
                    $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], 'Mengunggah file poster');
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menyimpan file poster.');
        }

        return $this->jsonResponse(200, 'File poster berhasil disimpan.');
    }

    /**
     * Unduh template PowerPoint poster A0 — berkas statis bersama untuk
     * semua peserta, disimpan di `storage/app/private/dokumen-template/`
     * (pola sama seperti NarasumberController::unduhPedoman()).
     */
    public function unduhTemplate()
    {
        $namaFile = 'Template_Poster_A0_KPPTI_2026.pptx';
        $path = "dokumen-template/{$namaFile}";

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $namaFile);
    }

    /**
     * Hapus file poster yang sudah dikirim (status=false, bukan dihapus
     * fisik — menjaga riwayat) sehingga peserta bisa mengunggah lagi.
     * Digerbangi jadwal yang sama dengan `simpan()` karena menghapus poster
     * yang sudah masuk juga termasuk mengubah pengajuan.
     */
    public function hapus(Request $request)
    {
        $userdata = session('userdata');

        $narasumber = $this->narasumberEligible($userdata['idpengguna']);

        if (! $narasumber) {
            abort(403);
        }

        if (! $this->jadwalSedangBuka(self::IDJADWAL_POSTER)) {
            return $this->jsonResponse(422, 'Periode pengiriman poster sedang ditutup.');
        }

        $poster = DB::table('poster')->where('idnarasumber', $narasumber->idnarasumber)->first();

        if (! $poster || ! $this->fileAktifPoster($poster->idposter)) {
            return $this->jsonResponse(422, 'Tidak ada file poster yang bisa dihapus.');
        }

        DB::table('file')
            ->where('idref_tabel', self::IDREF_TABEL_POSTER)
            ->where('idref', $poster->idposter)
            ->where('status', true)
            ->update(['status' => false]);

        $idpeserta = DB::table('peserta')->where('idpengguna', $userdata['idpengguna'])->value('idpeserta');

        if ($idpeserta) {
            $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], 'Menghapus file poster');
        }

        return $this->jsonResponse(200, 'File poster berhasil dihapus.');
    }

    /**
     * Serve file poster — hanya bisa diakses oleh pemilik narasumber-nya
     * sendiri, pola identik `NarasumberController::tampilBerkas()`.
     */
    public function tampilBerkas(Request $request)
    {
        $userdata = session('userdata');
        $idfile = $this->decryptRouteValue($request->query('token'));

        if ($idfile === null) {
            abort(404);
        }

        $file = DB::table('file as f')
            ->join('poster as po', 'po.idposter', '=', 'f.idref')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'po.idnarasumber')
            ->where('f.idfile', (int) $idfile)
            ->where('f.idref_tabel', self::IDREF_TABEL_POSTER)
            ->where('n.idpengguna', $userdata['idpengguna'])
            ->select('f.path_file')
            ->first();

        if (! $file || ! $file->path_file || ! Storage::disk('local')->exists($file->path_file)) {
            abort(404);
        }

        return Storage::disk('local')->response($file->path_file);
    }

    /**
     * Narasumber milik pengguna ini, hanya kalau statusnya Tidak Terpilih —
     * dipakai sebagai gate di setiap method, bukan cuma menyembunyikan menu.
     */
    private function narasumberEligible(int $idpengguna): ?object
    {
        return DB::table('narasumber')
            ->where('idpengguna', $idpengguna)
            ->where('status_ajuan', self::STATUS_TIDAK_TERPILIH)
            ->first();
    }

    /**
     * Cek ukuran halaman PDF yang diunggah sesuai A0 Portrait, dibaca dari
     * `MediaBox` halaman pertama (dalam point, 1pt = 1/72 inci). File yang
     * gagal diparse (rusak/terenkripsi) dianggap tidak valid.
     */
    private function ukuranA0Valid(UploadedFile $file): bool
    {
        try {
            $pdf = (new PdfParser)->parseFile($file->getRealPath());
            $halamanPertama = $pdf->getPages()[0] ?? null;

            if (! $halamanPertama) {
                return false;
            }

            $mediaBox = $halamanPertama->getDetails()['MediaBox'] ?? null;

            if (! is_array($mediaBox) || count($mediaBox) < 4) {
                return false;
            }

            $lebarMm = abs((float) $mediaBox[2] - (float) $mediaBox[0]) * 25.4 / 72;
            $tinggiMm = abs((float) $mediaBox[3] - (float) $mediaBox[1]) * 25.4 / 72;

            return $lebarMm >= self::A0_LEBAR_MM - self::TOLERANSI_UKURAN_MM
                && $tinggiMm >= self::A0_TINGGI_MM - self::TOLERANSI_UKURAN_MM;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function fileAktifPoster(int $idposter): bool
    {
        return DB::table('file')
            ->where('idref_tabel', self::IDREF_TABEL_POSTER)
            ->where('idref', $idposter)
            ->where('status', true)
            ->exists();
    }

    /**
     * Disk `local` dikonfigurasi dengan `throw => false` (config/filesystems.php),
     * jadi `put()` tidak melempar exception kalau penulisan gagal — hanya
     * mengembalikan `false`. Dicek manual supaya baris `file` tidak ikut
     * tersimpan seolah berhasil padahal berkas fisiknya tidak ada (lihat
     * catatan yang sama di NarasumberController::simpanBerkasPresentasi()).
     */
    private function simpanBerkasPoster(int $idnarasumber, int $idposter, UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "poster/poster-{$idnarasumber}-{$idposter}-".time().".{$ext}";

        $berhasil = Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        if (! $berhasil) {
            throw new \RuntimeException('Gagal menyimpan berkas poster ke storage.');
        }

        return $path;
    }
}
