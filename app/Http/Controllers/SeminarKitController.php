<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeminarKitController extends Controller
{
    /**
     * Master Kit — semua baris seminar_kit (termasuk yang nonaktif), untuk
     * CRUD oleh admin.
     */
    public function index()
    {
        $menu = 'seminar-kit';
        $submenu = 'master-kit';

        $seminarKit = DB::table('seminar_kit')->orderBy('idseminar_kit')->get();

        return view('admin.seminar-kit-master', compact('menu', 'submenu', 'seminarKit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kit' => ['required', 'string', 'max:255'],
        ]);

        DB::table('seminar_kit')->insert([
            'nama_kit' => $validated['nama_kit'],
            'status' => true,
        ]);

        return $this->jsonResponse(200, 'Jenis kit berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'idseminar_kit' => ['required', 'integer'],
            'nama_kit' => ['required', 'string', 'max:255'],
        ]);

        $seminarKit = DB::table('seminar_kit')->where('idseminar_kit', $validated['idseminar_kit'])->first();

        if (! $seminarKit) {
            return $this->jsonResponse(404, 'Jenis kit tidak ditemukan.');
        }

        DB::table('seminar_kit')->where('idseminar_kit', $validated['idseminar_kit'])->update([
            'nama_kit' => $validated['nama_kit'],
        ]);

        return $this->jsonResponse(200, 'Jenis kit berhasil diperbarui.');
    }

    /**
     * Nonaktifkan/aktifkan satu jenis kit — soft toggle (sama seperti
     * `AcaraController` menonaktifkan acara via kolom `status`), bukan hard
     * delete, supaya baris `kit_peserta` yang sudah mereferensi jenis kit
     * ini tidak jadi yatim.
     */
    public function toggleStatus(Request $request)
    {
        $validated = $request->validate([
            'idseminar_kit' => ['required', 'integer'],
        ]);

        $seminarKit = DB::table('seminar_kit')->where('idseminar_kit', $validated['idseminar_kit'])->first();

        if (! $seminarKit) {
            return $this->jsonResponse(404, 'Jenis kit tidak ditemukan.');
        }

        $statusBaru = ! $seminarKit->status;

        DB::table('seminar_kit')->where('idseminar_kit', $validated['idseminar_kit'])->update([
            'status' => $statusBaru,
        ]);

        $pesan = $statusBaru ? 'Jenis kit berhasil diaktifkan.' : 'Jenis kit berhasil dinonaktifkan.';

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Progress — daftar kontingen dan sejauh mana Petugas Kit menyiapkan
     * seminar kit untuk tiap kontingen. Read-only untuk admin.
     */
    public function progress()
    {
        $menu = 'seminar-kit';
        $submenu = 'progress';

        $kontingen = $this->kontingenKitProgress();

        return view('admin.seminar-kit-progress', compact('menu', 'submenu', 'kontingen'));
    }

    /**
     * Detail progress satu kontingen — read-only (tanda centang, bukan
     * checkbox interaktif; itu wewenang Petugas Kit lewat
     * `PetugasKitController::detail()`).
     */
    public function progressDetail(Request $request)
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
        $submenu = 'progress';

        ['kitAktif' => $kitAktif, 'pesertaList' => $pesertaList] = $this->kitProgressDetail($idInstitusiAsal);

        return view('admin.seminar-kit-progress-detail', compact('menu', 'submenu', 'institusi', 'kitAktif', 'pesertaList'));
    }
}
