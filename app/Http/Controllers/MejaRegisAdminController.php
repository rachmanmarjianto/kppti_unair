<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MejaRegisAdminController extends Controller
{
    /**
     * Role ID Petugas Meja Registrasi, per tabel referensi `role` (F19).
     */
    private const ROLE_PETUGAS_MEJA_REGIS = 8;

    /**
     * Submenu "Petugas Meja" (menu "Kedatangan Kontingen") — kelola isi
     * `meja_regis` (pemetaan 1 petugas = 1 nomor meja).
     */
    public function index()
    {
        $menu = 'kedatangan-kontingen';
        $submenu = 'petugas-meja';

        $mejaRegisList = DB::table('meja_regis as mr')
            ->join('pengguna as p', 'p.idpengguna', '=', 'mr.idpengguna')
            ->select('mr.idmeja_regis', 'mr.nomor_meja', 'mr.idpengguna', 'p.nama as nama_petugas', 'p.no_wa')
            ->orderBy('mr.nomor_meja')
            ->get();

        $idpenggunaSudahDipetakan = $mejaRegisList->pluck('idpengguna');

        $petugasBelumDipetakan = DB::table('pengguna as p')
            ->join('role_pengguna as rp', 'rp.idpengguna', '=', 'p.idpengguna')
            ->where('rp.idrole', self::ROLE_PETUGAS_MEJA_REGIS)
            ->where('p.is_deleted', false)
            ->whereNotIn('p.idpengguna', $idpenggunaSudahDipetakan)
            ->select('p.idpengguna', 'p.nama')
            ->orderBy('p.nama')
            ->get();

        return view('admin.petugas-meja', compact('menu', 'submenu', 'mejaRegisList', 'petugasBelumDipetakan'));
    }

    /**
     * Tambah pemetaan baru (nomor meja baru + petugas yang belum punya meja).
     */
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
            'nomor_meja' => ['required', 'string', 'regex:/^\d{2}$/'],
        ]);

        if (! $this->penggunaAdalahPetugasMejaRegis((int) $validated['idpengguna'])) {
            return $this->jsonResponse(422, 'Pengguna yang dipilih bukan Petugas Meja Registrasi.');
        }

        $sudahDipetakan = DB::table('meja_regis')->where('idpengguna', $validated['idpengguna'])->exists();

        if ($sudahDipetakan) {
            return $this->jsonResponse(409, 'Pengguna ini sudah dipetakan ke meja lain.');
        }

        DB::table('meja_regis')->insert([
            'idpengguna' => $validated['idpengguna'],
            'nomor_meja' => $validated['nomor_meja'],
        ]);

        return $this->jsonResponse(200, 'Pemetaan meja berhasil ditambahkan.');
    }

    /**
     * Ubah pemetaan yang sudah ada — bisa mengubah nomor meja dan/atau
     * petugas yang ditugaskan.
     */
    public function ubah(Request $request)
    {
        $validated = $request->validate([
            'idmeja_regis' => ['required', 'integer'],
            'idpengguna' => ['required', 'integer'],
            'nomor_meja' => ['required', 'string', 'regex:/^\d{2}$/'],
        ]);

        $baris = DB::table('meja_regis')->where('idmeja_regis', $validated['idmeja_regis'])->first();

        if (! $baris) {
            return $this->jsonResponse(404, 'Data pemetaan meja tidak ditemukan.');
        }

        if (! $this->penggunaAdalahPetugasMejaRegis((int) $validated['idpengguna'])) {
            return $this->jsonResponse(422, 'Pengguna yang dipilih bukan Petugas Meja Registrasi.');
        }

        $sudahDipetakanKeLain = DB::table('meja_regis')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('idmeja_regis', '!=', $validated['idmeja_regis'])
            ->exists();

        if ($sudahDipetakanKeLain) {
            return $this->jsonResponse(409, 'Pengguna ini sudah dipetakan ke meja lain.');
        }

        DB::table('meja_regis')->where('idmeja_regis', $validated['idmeja_regis'])->update([
            'idpengguna' => $validated['idpengguna'],
            'nomor_meja' => $validated['nomor_meja'],
        ]);

        return $this->jsonResponse(200, 'Pemetaan meja berhasil diubah.');
    }

    /**
     * Hapus satu pemetaan meja (tidak ada kolom status di `meja_regis`,
     * jadi ini hapus baris sungguhan, bukan soft delete).
     */
    public function hapus(Request $request)
    {
        $validated = $request->validate([
            'idmeja_regis' => ['required', 'integer'],
        ]);

        $baris = DB::table('meja_regis')->where('idmeja_regis', $validated['idmeja_regis'])->first();

        if (! $baris) {
            return $this->jsonResponse(404, 'Data pemetaan meja tidak ditemukan.');
        }

        DB::table('meja_regis')->where('idmeja_regis', $validated['idmeja_regis'])->delete();

        return $this->jsonResponse(200, 'Pemetaan meja berhasil dihapus.');
    }

    private function penggunaAdalahPetugasMejaRegis(int $idpengguna): bool
    {
        return DB::table('role_pengguna')
            ->where('idpengguna', $idpengguna)
            ->where('idrole', self::ROLE_PETUGAS_MEJA_REGIS)
            ->exists();
    }
}
