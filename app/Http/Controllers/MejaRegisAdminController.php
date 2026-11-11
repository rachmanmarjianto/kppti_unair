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

    /**
     * Submenu "Kehadiran" (menu "Kedatangan Kontingen") — rekap institusi
     * yang sudah punya minimal 1 peserta dengan `peserta.hadir = true`,
     * beserta jumlah peserta hadirnya.
     */
    public function kehadiranIndex()
    {
        $menu = 'kedatangan-kontingen';
        $submenu = 'kehadiran';

        $jumlahHadirPerInstitusi = $this->pesertaAktifQuery()
            ->where('pe.hadir', true)
            ->select('p.idinstitusi_asal')
            ->get()
            ->countBy('idinstitusi_asal');

        $kehadiranList = DB::table('institusi_asal as ia')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'ia.idjenis_institusi')
            ->whereIn('ia.idinstitusi_asal', $jumlahHadirPerInstitusi->keys())
            ->select('ia.idinstitusi_asal', 'ia.nama_institusi', 'ji.nama_jenis_institusi')
            ->orderBy('ia.nama_institusi')
            ->get()
            ->map(function ($baris) use ($jumlahHadirPerInstitusi) {
                $baris->jumlah_hadir = $jumlahHadirPerInstitusi->get($baris->idinstitusi_asal, 0);
                $baris->token = $this->encryptRouteValue($baris->idinstitusi_asal);

                return $baris;
            });

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        // Dashboard ini menghitung jumlah INSTITUSI yang minimal satu
        // pesertanya hadir per jenis institusi — bukan total peserta hadir
        // (itu sudah ada per-baris di $kehadiranList). Dasarnya SEMUA jenis
        // institusi (bukan cuma yang muncul di $kehadiranList), supaya
        // jenis yang belum ada satu pun perwakilannya hadir tetap tampil
        // dengan angka 0.
        $jumlahInstitusiPerJenis = $kehadiranList->groupBy('nama_jenis_institusi')
            ->map(fn ($grup) => $grup->count());

        $rekapJenisInstitusi = $jenisInstitusiList->map(function ($jenis) use ($jumlahInstitusiPerJenis) {
            return (object) [
                'nama_jenis_institusi' => $jenis->nama_jenis_institusi,
                'jumlah_institusi' => $jumlahInstitusiPerJenis->get($jenis->nama_jenis_institusi, 0),
            ];
        });

        $jumlahPesertaHadir = $jumlahHadirPerInstitusi->sum();

        // $kehadiranList sudah difilter ke institusi yang minimal satu
        // pesertanya hadir (lihat whereIn di atas), jadi jumlah barisnya
        // sendiri adalah jawabannya.
        $jumlahInstitusiHadir = $kehadiranList->count();

        return view('admin.kehadiran-kontingen', compact(
            'menu', 'submenu', 'kehadiranList', 'jenisInstitusiList', 'rekapJenisInstitusi', 'jumlahPesertaHadir', 'jumlahInstitusiHadir'
        ));
    }

    /**
     * AJAX — daftar peserta yang hadir (`peserta.hadir = true`) milik satu
     * institusi, untuk modal detail di baris tabel Kehadiran. Kolom sama
     * seperti tabel peserta di layar "Sedang Dilayani" Petugas Meja
     * Registrasi (lihat `PetugasMejaRegisController::dataKartuAktif()`):
     * `fotoLengkap`, `isNarasumberDiterima`, `isPetugasJaga`.
     */
    public function pesertaHadirInstitusi(Request $request)
    {
        $idInstitusiAsal = $this->decryptRouteValue($request->query('token'));

        if ($idInstitusiAsal === null) {
            return $this->jsonResponse(404, 'Institusi tidak ditemukan.');
        }

        $idInstitusiAsal = (int) $idInstitusiAsal;

        $institusi = DB::table('institusi_asal')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $institusi) {
            return $this->jsonResponse(404, 'Institusi tidak ditemukan.');
        }

        $pesertaList = $this->pesertaAktifQuery($idInstitusiAsal)
            ->where('pe.hadir', true)
            ->select('pe.idpeserta', 'p.idpengguna', 'p.nama', 'pe.hadir', 'pe.path_foto')
            ->orderBy('p.nama')
            ->get();

        $idPenggunaNarasumber = $this->idPenggunaNarasumberDiterima();

        $idPesertaJaga = DB::table('petugas_jaga')
            ->whereIn('idpeserta', $pesertaList->pluck('idpeserta'))
            ->pluck('idpeserta')
            ->unique();

        $pesertaList = $pesertaList->map(function ($peserta) use ($idPenggunaNarasumber, $idPesertaJaga) {
            $peserta->fotoLengkap = $peserta->path_foto !== null;
            $peserta->isNarasumberDiterima = $idPenggunaNarasumber->contains($peserta->idpengguna);
            $peserta->isPetugasJaga = $idPesertaJaga->contains($peserta->idpeserta);

            return $peserta;
        });

        // Riwayat petugas meja yang menyelesaikan layanan (status '4'
        // Terlayani) untuk institusi ini — diambil langsung dari
        // `antrian_regis.dipanggil_oleh` (dikonfirmasi developer), bukan
        // dari `log_antrian_regis` (tabel itu ada di skema tapi belum
        // pernah ditulis kode mana pun, jadi selalu kosong). `created_at`
        // dipakai sebagai "waktu melayani" karena `antrian_regis` tidak
        // punya kolom tersendiri untuk waktu selesai dilayani. Bisa lebih
        // dari satu baris kalau institusi ini registrasi ulang/ditangani
        // beberapa kali.
        $riwayatPetugas = DB::table('antrian_regis as ar')
            ->join('meja_regis as mr', 'mr.idmeja_regis', '=', 'ar.dipanggil_oleh')
            ->join('pengguna as p', 'p.idpengguna', '=', 'mr.idpengguna')
            ->where('ar.idinstitusi_asal', $idInstitusiAsal)
            ->where('ar.status', '4')
            ->select('p.nama', 'ar.created_at')
            ->orderByDesc('ar.created_at')
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', [
            'nama_institusi' => $institusi->nama_institusi,
            'pesertaList' => $pesertaList,
            'riwayatPetugas' => $riwayatPetugas,
        ]);
    }
}
