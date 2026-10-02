<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PesertaAdminController extends Controller
{
    public function index()
    {
        $menu = 'users';
        $submenu = 'peserta';

        $pesertaList = $this->pesertaDenganStatusLengkap();

        $institusiList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->select('i.idinstitusi_asal', 'i.idjenis_institusi', 'i.nama_institusi', 'i.kode_kontingen', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) use ($pesertaList) {
                $institusi->pesertaList = $pesertaList->where('idinstitusi_asal', $institusi->idinstitusi_asal)->values();
                $institusi->jumlahPeserta = $institusi->pesertaList->count();
                $institusi->semuaLengkap = $institusi->jumlahPeserta > 0 && $institusi->pesertaList->every(fn ($p) => $p->lengkap);
                $institusi->token = $this->encryptRouteValue($institusi->idinstitusi_asal);

                return $institusi;
            });

        $jenisInstitusiList = $institusiList->groupBy('nama_jenis_institusi')->map(function ($institusiPerJenis, $namaJenis) {
            return (object) [
                'nama_jenis_institusi' => $namaJenis,
                'institusiList' => $institusiPerJenis->values(),
                'jumlahInstitusi' => $institusiPerJenis->count(),
                'jumlahPeserta' => $institusiPerJenis->sum('jumlahPeserta'),
            ];
        })->values();

        $dashboard = [
            'totalPeserta' => $pesertaList->count(),
            'totalInstitusi' => $institusiList->count(),
            'jumlahCityTour' => $pesertaList->where('city_tour', true)->count(),
            'jumlahLengkap' => $pesertaList->where('lengkap', true)->count(),
            'jumlahBelumLengkap' => $pesertaList->where('lengkap', false)->count(),
            'kontingenSiapCetak' => $institusiList->where('semuaLengkap', true)->count(),
            'kontingenBelumSiap' => $institusiList->where('jumlahPeserta', '>', 0)->where('semuaLengkap', false)->count(),
        ];

        return view('admin.peserta', compact('menu', 'submenu', 'jenisInstitusiList', 'dashboard'));
    }

    /**
     * Fetch a peserta's full detail (personal, institusi, logistik, status foto)
     * for the "Detail Peserta" modal — read-only, cross-institusi (an Admin may
     * view any peserta). The idpeserta travels as an encrypted `token` query
     * value, not a raw GET parameter (CONVENTIONS.md §7).
     */
    public function detailPeserta(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idpeserta = (int) $idpeserta;

        $peserta = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('jenis_transport as jtk', 'jtk.idjenis_transport', '=', 'pe.idjenis_transportasi_kedatangan')
            ->leftJoin('jenis_transport as jtp', 'jtp.idjenis_transport', '=', 'pe.idjenis_transportasi_kepulangan')
            ->where('pe.idpeserta', $idpeserta)
            ->where('p.is_deleted', false)
            ->select(
                'p.nama', 'p.email', 'p.no_wa', 'j.nama_jabatan',
                'i.nama_institusi', 'ji.nama_jenis_institusi', 'i.kode_kontingen',
                'jtk.nama_jenis_transport as nama_transport_kedatangan', 'pe.stasiun_kedatangan', 'pe.tanggal_kedatangan', 'pe.jam_kedatangan',
                'jtp.nama_jenis_transport as nama_transport_kepulangan', 'pe.stasiun_kepulangan', 'pe.tanggal_kepulangan', 'pe.jam_kepulangan',
                'pe.nama_hotel', 'pe.city_tour',
                'pe.idjenis_transportasi_kedatangan', 'pe.idjenis_transportasi_kepulangan', 'pe.path_foto'
            )
            ->first();

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();
        $peserta->logistikLengkap = $this->isLogistikLengkap($peserta, $idKendaraanPribadi);
        $peserta->fotoLengkap = $peserta->path_foto !== null;
        $peserta->lengkap = $peserta->logistikLengkap && $peserta->fotoLengkap;
        unset($peserta->path_foto, $peserta->idjenis_transportasi_kedatangan, $peserta->idjenis_transportasi_kepulangan);

        return $this->jsonResponse(200, 'Detail peserta berhasil diambil.', $peserta);
    }

    /**
     * Reset a peserta's password — scoped across every institusi (an Admin isn't
     * part of any single kontingen), same pattern as
     * PesertaController::resetPasswordPeserta().
     */
    public function resetPassword(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        if (! $peserta->no_wa) {
            return $this->jsonResponse(422, 'Peserta belum memiliki nomor WhatsApp.');
        }

        $password = $this->generateRandomPassword();

        DB::table('pengguna')
            ->where('idpengguna', $peserta->idpengguna)
            ->update(['password' => Hash::make($password)]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Password direset');

        $pesan_1 = 'Password akun KPPTI 2026 Anda telah direset. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$peserta->email} ### Password: {$password}";
        $pesan_3 = 'Akun Aktif';

        try {
            $res = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $peserta->no_wa);
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Password berhasil direset, namun informasi login gagal dikirim melalui WhatsApp.');
        }

        if (strtoupper($res) != strtoupper('sukses')) {
            return $this->jsonResponse(500, 'Password berhasil direset, namun informasi login gagal dikirim melalui WhatsApp. Respon: '.$res);
        }

        return $this->jsonResponse(200, 'Password berhasil direset dan informasi login telah dikirim melalui WhatsApp.', ['wa_response' => $res]);
    }

    /**
     * Download a kontingen's registration card — same completeness gate as
     * PesertaController::kartuKontingen(), just scoped to the institusi chosen
     * by the Admin (via an encrypted token) instead of the logged-in session's
     * own institusi.
     */
    public function cetakKartu(Request $request)
    {
        $idInstitusiAsal = $this->decryptRouteValue($request->query('token'));

        if ($idInstitusiAsal === null) {
            abort(404);
        }

        $idInstitusiAsal = (int) $idInstitusiAsal;

        $institusi = DB::table('institusi_asal')
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->first();

        if (! $institusi) {
            abort(404);
        }

        $pesertaList = $this->pesertaDenganStatusLengkap($idInstitusiAsal);
        $belumLengkap = $pesertaList->where('lengkap', false);

        if ($pesertaList->isEmpty() || $belumLengkap->isNotEmpty()) {
            $namaBelumLengkap = $belumLengkap->pluck('nama')->implode(', ');
            $pesan = $pesertaList->isEmpty()
                ? 'Belum ada peserta dalam kontingen ini.'
                : "Untuk mengunduh kartu registrasi, harap lengkapi semua data peserta. Belum lengkap: {$namaBelumLengkap}.";

            return redirect()->route('admin.peserta')->with('status', [
                'status' => 'danger',
                'message' => $pesan,
            ]);
        }

        return $this->unduhKartuKontingenResponse($institusi);
    }

    /**
     * Find a peserta by idpeserta across every institusi — Admin isn't scoped to
     * one kontingen the way a peserta is.
     */
    private function findPesertaById(int $idpeserta): ?object
    {
        return DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->where('pe.idpeserta', $idpeserta)
            ->where('p.is_deleted', false)
            ->select('p.idpengguna', 'pe.idpeserta', 'p.nama', 'p.email', 'p.no_wa', 'pe.idjabatan')
            ->first();
    }
}
