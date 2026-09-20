<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

include_once 'admin.php';

// Route::get('/', function () {
//     return view('blank_page');
// });

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/registrasi', [PenggunaController::class, 'registrasi'])->name('registrasi_kppti');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['akses:All'])->group(function () {
    Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [PenggunaController::class, 'profile'])->name('profile');
    Route::post('/profile/password', [PenggunaController::class, 'updatePassword'])->name('profile.password.update');
});
