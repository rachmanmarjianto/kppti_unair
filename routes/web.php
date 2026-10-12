<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BniCallbackController;
use App\Http\Controllers\FaceRecognitionApiController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

include_once 'admin.php';
include_once 'peserta.php';
include_once 'sc.php';
include_once 'petugas-kit.php';

// Route::get('/', function () {
//     return view('blank_page');
// });

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/lupa-password', [PenggunaController::class, 'lupaPassword'])->name('lupa-password');
Route::post('/lupa-password', [PenggunaController::class, 'lupaPasswordReset'])->name('lupa-password.reset')->middleware('throttle:5,1');

Route::middleware(['jadwalPenting:1'])->group(function () {
    Route::get('/registrasi', [PenggunaController::class, 'registrasi'])->name('registrasi_kppti');
    Route::post('/registrasi/kirim-otp', [PenggunaController::class, 'kirimOtp'])->name('registrasi_kppti.kirim_otp');
    Route::post('/registrasi/cek-otp', [PenggunaController::class, 'cekOtpRegistrasi'])->name('registrasi_kppti.cek_otp');
    Route::get('/registrasi/search-universitas', [PenggunaController::class, 'searchUniversitas'])->name('registrasi_kppti.search_universitas');
    Route::get('/registrasi/search-institusi', [PenggunaController::class, 'searchInstitusiAsal'])->name('registrasi_kppti.search_institusi');
    Route::post('/registrasi/store', [PenggunaController::class, 'storeRegistrasi'])->name('registrasi_kppti.store');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['akses:All'])->group(function () {
    Route::get('/logout/', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [PenggunaController::class, 'profile'])->name('profile');
    Route::post('/profile/password', [PenggunaController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/role-aktif', [PenggunaController::class, 'ubahRoleAktif'])->name('profile.role.aktifkan');
});

// Webhook publik dari BNI — tidak ada sesi, tidak digerbangi middleware akses.
Route::post('/callback/bni-va', [BniCallbackController::class, 'handle'])->name('callback.bni-va');
Route::get('/callback/bni-va', [BniCallbackController::class, 'handle_forbidden'])->name('callback.bni-va.get');

// API publik untuk server manajemen peserta Face Recognition — tidak ada sesi,
// digerbangi whitelist IP (bukan middleware akses role biasa).
Route::get('/api/face-recognition/peserta', [FaceRecognitionApiController::class, 'pesertaList'])
    ->middleware('face-recognition.ip')
    ->name('api.face-recognition.peserta');
Route::get('/api/face-recognition/foto/{idpengguna}.jpg', [FaceRecognitionApiController::class, 'foto'])
    ->middleware('face-recognition.ip')
    ->whereNumber('idpengguna')
    ->name('api.face-recognition.foto');
