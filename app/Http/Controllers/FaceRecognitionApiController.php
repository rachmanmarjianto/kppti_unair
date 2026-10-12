<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FaceRecognitionApiController extends Controller
{
    /**
     * Daftar peserta aktif **yang sudah punya foto** untuk sinkronisasi ke
     * server manajemen perangkat face recognition Hikvision MinMoe —
     * peserta tanpa foto tidak berguna untuk didaftarkan ke perangkat, jadi
     * disaring di sini (bukan tanggung jawab server MinMoe memilah). Endpoint
     * publik tanpa sesi login (diakses server lain, bukan browser pengguna)
     * — dibatasi lewat middleware whitelist IP (`face-recognition.ip`),
     * bukan middleware akses role biasa. Mengembalikan JSON array langsung
     * (bukan dibungkus jsonResponse()), karena bentuk responsnya sudah
     * ditentukan tim perangkat, bukan kontrak internal aplikasi ini.
     */
    public function pesertaList(Request $request): JsonResponse
    {
        $peserta = $this->pesertaAktifQuery()
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('lldikti as l', 'l.idlldikti', '=', 'i.idlldikti')
            ->whereNotNull('pe.path_foto')
            ->select(
                'p.idpengguna', 'p.nama',
                'i.idinstitusi_asal', 'i.nama_institusi',
                'ji.nama_jenis_institusi', 'l.nomor_lldikti'
            )
            ->orderBy('p.idpengguna')
            ->get()
            ->map(function ($baris) {
                $namaPerguruanTinggi = $baris->nama_institusi;

                if ($baris->nama_jenis_institusi === 'LLDikti' && $baris->nomor_lldikti) {
                    $namaPerguruanTinggi .= " (LLDikti {$baris->nomor_lldikti})";
                }

                return [
                    'jenis_user' => 'mahasiswa',
                    'id_personal' => '-',
                    'id_usulan' => '-',
                    'id_pdpt' => '-',
                    'nim_nidn' => (string) $baris->idpengguna,
                    'nama' => $baris->nama,
                    'peran' => '-',
                    'nama_program_studi' => '-',
                    'kode_perguruan tinggi' => (string) $baris->idinstitusi_asal,
                    'nama_perguruan tinggi' => $namaPerguruanTinggi,
                    'id_nidn_dosen_pimnas' => '-',
                    'is_hadir' => '',
                    'path_file' => '-',
                    'nama_file' => "{$baris->idpengguna}.jpg",
                    'id_kelas_pimnas' => '',
                    'kelas_pimnas' => '',
                ];
            })
            ->values();

        return response()->json($peserta);
    }

    /**
     * Serve satu foto peserta berdasarkan `idpengguna` (segmen URL
     * `.../{idpengguna}.jpg`, bukan token terenkripsi — kontrak API ini
     * dengan server MinMoe memakai idpengguna mentah, sama seperti
     * `nim_nidn`/`nama_file` di pesertaList(); `.jpg` di URL murni kosmetik
     * agar namanya mirip nama file, isi gambar tetap diambil dari
     * `path_foto` tersimpan — tidak dipakai untuk menebak ekstensi asli).
     * Endpoint publik, dibatasi middleware whitelist IP yang sama
     * (`face-recognition.ip`).
     */
    public function foto(int $idpengguna): StreamedResponse
    {
        $pathFoto = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->where('p.idpengguna', $idpengguna)
            ->value('pe.path_foto');

        if (! $pathFoto || ! Storage::disk('local')->exists($pathFoto)) {
            abort(404);
        }

        return Storage::disk('local')->response($pathFoto);
    }
}
