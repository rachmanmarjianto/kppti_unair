<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DiagnostikServerController extends Controller
{
    /**
     * Endpoint debug produksi untuk melihat phpinfo(). Sengaja tidak
     * digerbangi middleware `akses` (perlu dicek walau sesi/login
     * bermasalah) — gerbangnya murni kolom `aktif` di tabel `php_info`,
     * yang hanya diubah manual lewat DB oleh developer saat butuh debug.
     * Nama route dibuat tidak lazim agar tidak mudah ditebak.
     */
    public function tampilkanInfoPhp()
    {
        $aktif = DB::table('php_info')->value('aktif');

        if (! $aktif) {
            abort(404);
        }

        phpinfo();

        exit;
    }
}
