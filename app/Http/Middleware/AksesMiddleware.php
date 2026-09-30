<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AksesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (Auth::check() && (in_array(session('userdata')['idrole_aktif'], $role) || in_array('All', $role))) { // admin aplikasi
            return $next($request);
        } else {
            session()->flush();
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'message' => 'Tidak memiliki akses pada halaman tersebut',
            ]);

        }
    }
}
