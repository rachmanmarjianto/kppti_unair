<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:1'])->group(function () {
    Route::get('/home_admin', [AdminController::class, 'index'])->name('admin.home');
});
