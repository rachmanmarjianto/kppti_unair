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
     * table (see docs/features/017-portal-registrasi-peserta.md). Mode '2'
     * (open) always passes; mode '1' (auto) only passes while now() is within
     * [timestamp_buka, timestamp_tutup] (either bound may be null, meaning no
     * limit on that side). A missing row fails closed.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $idJadwalPenting): Response
    {
        $jadwal = DB::table('jadwal_penting')->where('idjadwal_penting', $idJadwalPenting)->first();

        if ($this->sedangBuka($jadwal)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'code' => 403,
                'status' => 'Forbidden',
                'message' => 'Sesi ini sedang ditutup.',
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
}
