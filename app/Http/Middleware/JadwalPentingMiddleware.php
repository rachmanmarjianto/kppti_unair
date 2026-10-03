<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class JadwalPentingMiddleware
{
    /**
     * Gate access to a scheduled process based on the `jadwal_penting` master
     * table (see docs/features/017-portal-registrasi-peserta.md).
     *
     * `$syarat`:
     * - 'buka' (default) — passes only while currently open (see
     *   `sedangBuka()`), used to gate the registration flow itself.
     * - 'tutup' — passes until `timestamp_tutup` is reached (ignores
     *   `timestamp_buka`), used to lock peserta's own data/acara edits once
     *   the registration period has closed — "not yet open" is irrelevant
     *   here since no peserta could exist before registration opened.
     *
     * Mode '2' (open) always passes for either `$syarat`. A missing row
     * fails closed.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $idJadwalPenting, string $syarat = 'buka'): Response
    {
        $jadwal = DB::table('jadwal_penting')->where('idjadwal_penting', $idJadwalPenting)->first();

        $lolos = $syarat === 'tutup' ? $this->belumTutup($jadwal) : $this->sedangBuka($jadwal);

        if ($lolos) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'code' => 403,
                'status' => 'Forbidden',
                'message' => $syarat === 'tutup'
                    ? 'Periode registrasi sudah ditutup. Data peserta dan pilihan acara tidak bisa diubah lagi.'
                    : 'Sesi ini sedang ditutup.',
                'data' => null,
            ], 403);
        }

        return response()->view('jadwal-tertutup', ['jadwal' => $jadwal], 403);
    }

    private function sedangBuka(?object $jadwal): bool
    {
        if (! $jadwal) {
            return false;
        }

        if ($jadwal->mode === '2') {
            return true;
        }

        $sekarang = now();

        if ($jadwal->timestamp_buka && $sekarang->lt($jadwal->timestamp_buka)) {
            return false;
        }

        if ($jadwal->timestamp_tutup && $sekarang->gt($jadwal->timestamp_tutup)) {
            return false;
        }

        return true;
    }

    private function belumTutup(?object $jadwal): bool
    {
        if (! $jadwal) {
            return false;
        }

        if ($jadwal->mode === '2') {
            return true;
        }

        return ! ($jadwal->timestamp_tutup && now()->gte($jadwal->timestamp_tutup));
    }
}
