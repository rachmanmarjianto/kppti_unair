<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalPentingController extends Controller
{
    /**
     * `idjadwal_penting` is fixed master data (1 Registrasi Peserta,
     * 2 Pengajuan Narasumber, 3 Pengajuan Pameran, 4 Pengiriman Poster,
     * 5 Pengiriman File Presentasi dan Video — see
     * docs/features/017-portal-registrasi-peserta.md §2). Admin only edits
     * `mode`/`timestamp_buka`/`timestamp_tutup` on these existing rows —
     * there is no create/delete.
     */
    public function index()
    {
        $menu = 'jadwal-penting';
        $submenu = '';

        $jadwalList = DB::table('jadwal_penting')->orderBy('idjadwal_penting')->get();

        return view('admin.jadwal-penting', compact('menu', 'submenu', 'jadwalList'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'idjadwal_penting' => ['required', 'exists:jadwal_penting,idjadwal_penting'],
            'mode' => ['required', 'in:1,2'],
            'timestamp_buka' => ['nullable', 'date'],
            'timestamp_tutup' => ['nullable', 'date', 'after:timestamp_buka'],
        ]);

        DB::table('jadwal_penting')
            ->where('idjadwal_penting', $validated['idjadwal_penting'])
            ->update([
                'mode' => $validated['mode'],
                'timestamp_buka' => $validated['timestamp_buka'] ?? null,
                'timestamp_tutup' => $validated['timestamp_tutup'] ?? null,
            ]);

        return $this->jsonResponse(200, 'Jadwal berhasil diperbarui.');
    }
}
