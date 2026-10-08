<?php

use App\Http\Controllers\PetugasKitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:5'])->group(function () {
    Route::get('/petugas-kit', [PetugasKitController::class, 'index'])->name('petugas-kit.home');
    Route::get('/petugas-kit/detail', [PetugasKitController::class, 'detail'])->name('petugas-kit.detail');
    Route::post('/petugas-kit/toggle-kit', [PetugasKitController::class, 'toggleKit'])->name('petugas-kit.toggle-kit');
    Route::post('/petugas-kit/toggle-lengkap', [PetugasKitController::class, 'toggleLengkap'])->name('petugas-kit.toggle-lengkap');
});
