<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
     * Daftar kontingen untuk pemetaan ID card ke pengguna — sama pola
     * seperti `index()` (Seminar Kit), bedanya tautan Aksi membuka
     * `tappingCardDetail()`.
     */
    public function tappingCardIndex()
    {
        $menu = 'tapping-card';
        $submenu = '';

        $kontingen = $this->tappingCardProgress();
        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        return view('petugas-kit.tapping-card-index', compact('menu', 'submenu', 'kontingen', 'jenisInstitusiList'));
    }

    /**
     * Halaman kerja Tapping Card untuk satu kontingen — input ID card per
     * peserta, disimpan langsung AJAX per baris (lihat `simpanIdcard()`).
     */
    public function tappingCardDetail(Request $request)
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

        $menu = 'tapping-card';
        $submenu = '';
        $token = $this->encryptRouteValue($idInstitusiAsal);

        $pesertaList = $this->tappingCardPesertaList($idInstitusiAsal);

        return view('petugas-kit.tapping-card-detail', compact('menu', 'submenu', 'institusi', 'token', 'pesertaList'));
    }

    /**
     * Simpan ID card satu pengguna. idcard divalidasi unik antar pengguna
     * aktif (dikonfirmasi developer — satu kartu fisik tidak boleh terpetakan
     * ke dua akun berbeda); boleh ditimpa bebas kapan pun.
     */
    public function simpanIdcard(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
            'idcard' => ['required', 'string', 'max:100'],
        ]);

        $pengguna = DB::table('pengguna')->where('idpengguna', $validated['idpengguna'])->where('is_deleted', false)->first();

        if (! $pengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        $sudahDipakai = DB::table('pengguna')
            ->where('idcard', $validated['idcard'])
            ->where('idpengguna', '!=', $validated['idpengguna'])
            ->where('is_deleted', false)
            ->exists();

        if ($sudahDipakai) {
            return $this->jsonResponse(409, 'ID card ini sudah dipakai pengguna lain.');
        }

        DB::table('pengguna')->where('idpengguna', $validated['idpengguna'])->update(['idcard' => $validated['idcard']]);

        return $this->jsonResponse(200, 'ID card berhasil disimpan.');
    }

    /**
     * AJAX — hapus idcard satu pengguna dari halaman detail Tapping Card.
     * Dipakai kalau ID card yang ter-tap keliru/perlu diulang untuk
     * peserta ini — card fisiknya jadi bisa dipakai ulang.
     */
    public function hapusIdcardTappingCard(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
        ]);

        if (! $this->hapusIdcardPengguna($validated['idpengguna'])) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        return $this->jsonResponse(200, 'ID card berhasil dihapus.');
    }

    /**
     * Halaman "Test Card" — verifikasi cepat sebuah ID card sudah
     * terpetakan ke siapa (lihat `cariTestCard()`).
     */
    public function testCard()
    {
        $menu = 'test-card';
        $submenu = '';

        return view('petugas-kit.test-card', compact('menu', 'submenu'));
    }

    /**
     * AJAX — cari pengguna berdasarkan idcard yang di-tap/diketik.
     */
    public function cariTestCard(Request $request)
    {
        $validated = $request->validate([
            'idcard' => ['required', 'string', 'max:100'],
        ]);

        $pengguna = $this->cariPenggunaByIdcard($validated['idcard']);

        if (! $pengguna) {
            return $this->jsonResponse(404, 'ID card tidak ditemukan.');
        }

        $adaFoto = $pengguna->idpeserta && $pengguna->path_foto;

        return $this->jsonResponse(200, 'Berhasil.', [
            'idpengguna' => $pengguna->idpengguna,
            'nama' => $pengguna->nama,
            'no_wa' => $pengguna->no_wa,
            'nama_institusi' => $pengguna->nama_institusi,
            'fotoUrl' => $adaFoto ? route('petugas-kit.test-card.foto', ['token' => $this->encryptRouteValue($pengguna->idpeserta)]) : null,
        ]);
    }

    /**
     * Serve foto peserta untuk hasil Test Card — pola sama seperti
     * `PesertaAdminController::tampilFoto()`.
     */
    public function tampilFotoTestCard(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $pathFoto = DB::table('peserta')->where('idpeserta', (int) $idpeserta)->value('path_foto');

        if (! $pathFoto || ! Storage::disk('local')->exists($pathFoto)) {
            abort(404);
        }

        return Storage::disk('local')->response($pathFoto);
    }

    /**
     * AJAX — lepas idcard dari pengguna hasil pencarian Test Card. Dipakai
     * saat card yang sudah di-tapping ternyata peserta pemiliknya tidak
     * hadir, supaya card fisiknya bisa dipakai ulang untuk peserta lain.
     */
    public function hapusIdcardTestCard(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
        ]);

        if (! $this->hapusIdcardPengguna($validated['idpengguna'])) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        return $this->jsonResponse(200, 'ID card berhasil dilepas dari pengguna ini.');
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
