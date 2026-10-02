<?php

use App\Http\Controllers\AcaraController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalPentingController;
use App\Http\Controllers\PesertaAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:1'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin-acara', [AcaraController::class, 'index'])->name('admin.acara');
    Route::post('/admin-acara/tambah', [AcaraController::class, 'store'])->name('admin.acara.tambah');
    Route::post('/admin-acara/update', [AcaraController::class, 'update'])->name('admin.acara.update');
    Route::post('/admin-acara/hapus', [AcaraController::class, 'destroy'])->name('admin.acara.hapus');
    Route::get('/admin-users', [AdminController::class, 'adminusers'])->name('admin.admin-users');
    Route::get('/admin-users/search-pengguna', [AdminController::class, 'searchPengguna'])->name('admin.admin-users.search-pengguna');
    Route::post('/admin-users/tambah-baru', [AdminController::class, 'tambahPenggunaBaru'])->name('admin.admin-users.tambah-baru');
    Route::post('/admin-users/tambah-lama', [AdminController::class, 'tambahPenggunaLama'])->name('admin.admin-users.tambah-lama');
    Route::get('/admin-users/detail', [AdminController::class, 'detailPengguna'])->name('admin.admin-users.detail');
    Route::post('/admin-users/ubah-role-aktif', [AdminController::class, 'ubahRoleAktif'])->name('admin.admin-users.ubah-role-aktif');
    Route::post('/admin-users/update', [AdminController::class, 'updatePengguna'])->name('admin.admin-users.update');
    Route::post('/admin-users/reset-password', [AdminController::class, 'resetPassword'])->name('admin.admin-users.reset-password');
    Route::get('/admin-peserta', [PesertaAdminController::class, 'index'])->name('admin.peserta');
    Route::get('/admin-peserta/detail', [PesertaAdminController::class, 'detailPeserta'])->name('admin.peserta.detail');
    Route::post('/admin-peserta/reset-password', [PesertaAdminController::class, 'resetPassword'])->name('admin.peserta.reset-password');
    Route::get('/admin-peserta/cetak-kartu', [PesertaAdminController::class, 'cetakKartu'])->name('admin.peserta.cetak-kartu');
    Route::get('/nara-sumber', [AdminController::class, 'narasumber'])->name('admin.nara-sumber');
    Route::get('/admin-jadwal-penting', [JadwalPentingController::class, 'index'])->name('admin.jadwal-penting');
    Route::post('/admin-jadwal-penting/update', [JadwalPentingController::class, 'update'])->name('admin.jadwal-penting.update');
});
