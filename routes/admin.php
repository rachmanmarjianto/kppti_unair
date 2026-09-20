<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:1'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin-users', [AdminController::class, 'adminusers'])->name('admin.admin-users');
    Route::get('/user-account-settings', [AdminController::class, 'useraccountsettings'])->name('admin.user-account-settings');
    Route::get('/nara-sumber', [AdminController::class, 'narasumber'])->name('admin.nara-sumber');
});
