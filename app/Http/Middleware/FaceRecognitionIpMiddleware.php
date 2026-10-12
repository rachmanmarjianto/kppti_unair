<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FaceRecognitionIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Whitelist IP untuk API peserta face recognition (diakses server lain,
     * bukan browser pengguna) — daftar IP diambil dari
     * `services.face_recognition.allowed_ips` (`.env`), dipisah koma.
     * Exact-match saja, tidak mendukung notasi CIDR/range.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = array_filter(array_map(
            'trim',
            explode(',', (string) config('services.face_recognition.allowed_ips'))
        ));

        if (! in_array($request->ip(), $allowedIps, true)) {
            abort(403, 'IP address tidak diizinkan mengakses API ini.');
        }

        return $next($request);
    }
}
