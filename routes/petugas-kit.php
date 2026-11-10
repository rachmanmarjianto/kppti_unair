<?php

use App\Http\Controllers\PetugasKitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:5'])->group(function () {
    Route::get('/petugas-kit', [PetugasKitController::class, 'index'])->name('petugas-kit.home');
    Route::get('/petugas-kit/detail', [PetugasKitController::class, 'detail'])->name('petugas-kit.detail');
    Route::post('/petugas-kit/toggle-kit', [PetugasKitController::class, 'toggleKit'])->name('petugas-kit.toggle-kit');
    Route::post('/petugas-kit/toggle-lengkap', [PetugasKitController::class, 'toggleLengkap'])->name('petugas-kit.toggle-lengkap');
    Route::get('/petugas-kit/tapping-card', [PetugasKitController::class, 'tappingCardIndex'])->name('petugas-kit.tapping-card');
    Route::get('/petugas-kit/tapping-card/detail', [PetugasKitController::class, 'tappingCardDetail'])->name('petugas-kit.tapping-card.detail');
    Route::post('/petugas-kit/tapping-card/simpan', [PetugasKitController::class, 'simpanIdcard'])->name('petugas-kit.tapping-card.simpan');
    Route::post('/petugas-kit/tapping-card/hapus-idcard', [PetugasKitController::class, 'hapusIdcardTappingCard'])->name('petugas-kit.tapping-card.hapus-idcard');
    Route::get('/petugas-kit/test-card', [PetugasKitController::class, 'testCard'])->name('petugas-kit.test-card');
    Route::post('/petugas-kit/test-card/cari', [PetugasKitController::class, 'cariTestCard'])->name('petugas-kit.test-card.cari');
    Route::get('/petugas-kit/test-card/foto', [PetugasKitController::class, 'tampilFotoTestCard'])->name('petugas-kit.test-card.foto');
    Route::post('/petugas-kit/test-card/hapus-idcard', [PetugasKitController::class, 'hapusIdcardTestCard'])->name('petugas-kit.test-card.hapus-idcard');
});
