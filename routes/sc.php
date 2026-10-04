<?php

use App\Http\Controllers\PameranReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:4'])->group(function () {
    Route::get('/sc/pameran', [PameranReviewController::class, 'index'])->name('sc.pameran');
    Route::get('/sc/pameran/detail', [PameranReviewController::class, 'detail'])->name('sc.pameran.detail');
    Route::post('/sc/pameran/klaim', [PameranReviewController::class, 'klaim'])->name('sc.pameran.klaim');
    Route::post('/sc/pameran/simpan-review', [PameranReviewController::class, 'simpanReview'])->name('sc.pameran.simpan-review');
    Route::post('/sc/pameran/kirim-keputusan', [PameranReviewController::class, 'kirimKeputusan'])->name('sc.pameran.kirim-keputusan');
    Route::get('/sc/pameran/portofolio', [PameranReviewController::class, 'tampilPortofolio'])->name('sc.pameran.portofolio');
});
