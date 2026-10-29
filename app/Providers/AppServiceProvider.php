<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menu "Poster" di sidebar peserta hanya tampil kalau narasumber-nya
        // berstatus Tidak Terpilih ('8') — dipasang sebagai view composer
        // (bukan variabel per controller) karena menu_peserta dirender di
        // SETIAP halaman peserta, menambah variabel di tiap controller
        // berisiko ada yang lupa dan bikin halaman itu 500.
        View::composer('layout.menu_peserta', function ($view) {
            $userdata = session('userdata');

            $tampilkanMenuPoster = $userdata && DB::table('narasumber')
                ->where('idpengguna', $userdata['idpengguna'])
                ->where('status_ajuan', '8')
                ->exists();

            $view->with('tampilkanMenuPoster', $tampilkanMenuPoster);
        });
    }
}
