<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasKitController extends Controller
{
    /**
     * Daftar kontingen untuk disiapkan seminar kit-nya — isinya sama
     * persis seperti `SeminarKitController::progress()`, bedanya tautan
     * Aksi-nya membuka halaman detail yang interaktif (lihat `detail()`),
     * bukan yang read-only milik admin.
     */
    public function index()
    {
        $menu = 'seminar-kit';
        $submenu = '';

        $kontingen = $this->kontingenKitProgress();

        return view('petugas-kit.progress', compact('menu', 'submenu', 'kontingen'));
    }

    /**
     * Halaman kerja Petugas Kit untuk satu kontingen — checkbox per kit per
     * peserta, langsung diproses AJAX (lihat `toggleKit()`/`toggleLengkap()`).
     */
    public function detail(Request $request)
    {
        $idInstitusiAsal = $this->decryptRouteValue($request->query('token'));

        if ($idInstitusiAsal === null) {
            abort(404);
        }

        $idInstitusiAsal = (int) $idInstitusiAsal;

        $institusi = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->where('i.idinstitusi_asal', $idInstitusiAsal)
            ->select('i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi')
            ->first();

        if (! $institusi) {
            abort(404);
        }

        $menu = 'seminar-kit';
        $submenu = '';
        $token = $this->encryptRouteValue($idInstitusiAsal);

        ['kitAktif' => $kitAktif, 'pesertaList' => $pesertaList] = $this->kitProgressDetail($idInstitusiAsal);

        return view('petugas-kit.detail', compact('menu', 'submenu', 'institusi', 'token', 'kitAktif', 'pesertaList'));
    }

    /**
     * Centang/batalkan satu kit untuk satu peserta — `created_at`/
     * `created_by` di-refresh setiap kali (dikonfirmasi developer, bukan
     * hanya saat baris pertama dibuat). Setelah itu, `peserta.kit_lengkap`
     * disesuaikan otomatis: true hanya kalau SEMUA seminar_kit aktif untuk
     * peserta ini sudah tercentang.
     */
    public function toggleKit(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idseminar_kit' => ['required', 'integer'],
            'checked' => ['required', 'boolean'],
        ]);

        $peserta = DB::table('peserta')->where('idpeserta', $validated['idpeserta'])->first();

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $kitValid = DB::table('seminar_kit')->where('idseminar_kit', $validated['idseminar_kit'])->where('status', true)->exists();

        if (! $kitValid) {
            return $this->jsonResponse(422, 'Jenis kit tidak valid.');
        }

        $kitLengkap = DB::transaction(function () use ($validated, $userdata) {
            DB::table('kit_peserta')->updateOrInsert(
                ['idpeserta' => $validated['idpeserta'], 'idseminar_kit' => $validated['idseminar_kit']],
                ['check' => $validated['checked'], 'created_at' => now(), 'created_by' => $userdata['idpengguna']]
            );

            return $this->sinkronkanKitLengkap((int) $validated['idpeserta']);
        });

        return $this->jsonResponse(200, 'Status kit berhasil disimpan.', [
            'kitLengkap' => $kitLengkap,
            'createdAt' => now()->format('d/m/Y H:i'),
            'namaPetugas' => $userdata['nama'],
        ]);
    }

    /**
     * Centang/batalkan "Kit Lengkap" sekaligus untuk semua kit aktif satu
     * peserta. Mematikan (uncheck) ikut meng-uncheck semua kit individual
     * (dikonfirmasi developer), bukan hanya mengubah `peserta.kit_lengkap`.
     */
    public function toggleLengkap(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'checked' => ['required', 'boolean'],
        ]);

        $peserta = DB::table('peserta')->where('idpeserta', $validated['idpeserta'])->first();

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idKitAktif = DB::table('seminar_kit')->where('status', true)->pluck('idseminar_kit');

        DB::transaction(function () use ($validated, $userdata, $idKitAktif) {
            foreach ($idKitAktif as $idseminar_kit) {
                DB::table('kit_peserta')->updateOrInsert(
                    ['idpeserta' => $validated['idpeserta'], 'idseminar_kit' => $idseminar_kit],
                    ['check' => $validated['checked'], 'created_at' => now(), 'created_by' => $userdata['idpengguna']]
                );
            }

            DB::table('peserta')->where('idpeserta', $validated['idpeserta'])->update([
                'kit_lengkap' => $validated['checked'],
            ]);
        });

        $pesan = $validated['checked'] ? 'Semua kit ditandai lengkap.' : 'Semua kit dibatalkan.';

        return $this->jsonResponse(200, $pesan, [
            'createdAt' => now()->format('d/m/Y H:i'),
            'namaPetugas' => $userdata['nama'],
        ]);
    }

    /**
     * `peserta.kit_lengkap` = true hanya kalau SEMUA seminar_kit aktif
     * sudah punya baris `kit_peserta` dengan `check = true` untuk peserta
     * ini. Dipanggil setelah tiap toggle satu kit (lihat `toggleKit()`).
     */
    private function sinkronkanKitLengkap(int $idPeserta): bool
    {
        $idKitAktif = DB::table('seminar_kit')->where('status', true)->pluck('idseminar_kit');

        $jumlahTercentang = DB::table('kit_peserta')
            ->where('idpeserta', $idPeserta)
            ->whereIn('idseminar_kit', $idKitAktif)
            ->where('check', true)
            ->count();

        $kitLengkap = $idKitAktif->isNotEmpty() && $jumlahTercentang === $idKitAktif->count();

        DB::table('peserta')->where('idpeserta', $idPeserta)->update(['kit_lengkap' => $kitLengkap]);

        return $kitLengkap;
    }
}
