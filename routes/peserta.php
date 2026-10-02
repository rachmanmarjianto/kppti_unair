<?php

use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:2'])->group(function () {
    Route::get('/home-peserta', [PesertaController::class, 'home'])->name('peserta.home');
    Route::post('/institusi-asal/update', [PesertaController::class, 'updateInstitusi'])->name('peserta.institusi.update');
    Route::get('/peserta-sekontingen', [PesertaController::class, 'sekontingen'])->name('peserta.sekontingen');
    Route::get('/peserta-sekontingen/detail', [PesertaController::class, 'detailPeserta'])->name('peserta.sekontingen.detail');
    Route::post('/peserta-sekontingen/tambah', [PesertaController::class, 'tambahPeserta'])->name('peserta.sekontingen.tambah');
    Route::post('/peserta-sekontingen/update', [PesertaController::class, 'updatePeserta'])->name('peserta.sekontingen.update');
    Route::post('/peserta-sekontingen/reset-password', [PesertaController::class, 'resetPasswordPeserta'])->name('peserta.sekontingen.reset-password');
    Route::get('/peserta-sekontingen/logistik', [PesertaController::class, 'detailLogistik'])->name('peserta.sekontingen.logistik.detail');
    Route::post('/peserta-sekontingen/logistik/update', [PesertaController::class, 'updateLogistik'])->name('peserta.sekontingen.logistik.update');
    Route::get('/kartu-kontingen', [PesertaController::class, 'kartuKontingen'])->name('peserta.kartu-kontingen');
    Route::get('/peserta-sekontingen/foto', [PesertaController::class, 'foto'])->name('peserta.sekontingen.foto');
    Route::get('/peserta-sekontingen/foto/tampil', [PesertaController::class, 'tampilFoto'])->name('peserta.sekontingen.foto.tampil');
    Route::post('/peserta-sekontingen/foto/update', [PesertaController::class, 'updateFoto'])->name('peserta.sekontingen.foto.update');
    Route::get('/peserta-acara', [PesertaController::class, 'acara'])->name('peserta.acara');
    Route::get('/peserta-sekontingen/acara', [PesertaController::class, 'pilihAcara'])->name('peserta.sekontingen.acara');
    Route::post('/peserta-sekontingen/acara/daftar', [PesertaController::class, 'daftarAcara'])->name('peserta.sekontingen.acara.daftar');
    Route::post('/peserta-sekontingen/acara/batal', [PesertaController::class, 'batalAcara'])->name('peserta.sekontingen.acara.batal');
});
