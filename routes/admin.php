<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:1'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin-users', [AdminController::class, 'adminusers'])->name('admin.admin-users');
    Route::get('/admin-users/search-pengguna', [AdminController::class, 'searchPengguna'])->name('admin.admin-users.search-pengguna');
    Route::post('/admin-users/tambah-baru', [AdminController::class, 'tambahPenggunaBaru'])->name('admin.admin-users.tambah-baru');
    Route::post('/admin-users/tambah-lama', [AdminController::class, 'tambahPenggunaLama'])->name('admin.admin-users.tambah-lama');
    Route::get('/admin-users/detail/{idpengguna}', [AdminController::class, 'detailPengguna'])->name('admin.admin-users.detail');
    Route::post('/admin-users/ubah-role-aktif', [AdminController::class, 'ubahRoleAktif'])->name('admin.admin-users.ubah-role-aktif');
    Route::post('/admin-users/update', [AdminController::class, 'updatePengguna'])->name('admin.admin-users.update');
    Route::post('/admin-users/reset-password', [AdminController::class, 'resetPassword'])->name('admin.admin-users.reset-password');
    Route::get('/user-account-settings', [AdminController::class, 'useraccountsettings'])->name('admin.user-account-settings');
    Route::get('/nara-sumber', [AdminController::class, 'narasumber'])->name('admin.nara-sumber');
});
