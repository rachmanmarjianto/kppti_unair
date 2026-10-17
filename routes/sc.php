<?php

use App\Http\Controllers\AcaraScController;
use App\Http\Controllers\NarasumberReviewController;
use App\Http\Controllers\PameranReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:4'])->group(function () {
    Route::get('/sc/acara', [AcaraScController::class, 'index'])->name('sc.acara');

    Route::get('/sc/pameran', [PameranReviewController::class, 'index'])->name('sc.pameran');
    Route::get('/sc/pameran/detail', [PameranReviewController::class, 'detail'])->name('sc.pameran.detail');
    Route::post('/sc/pameran/mulai-review', [PameranReviewController::class, 'mulaiReview'])->name('sc.pameran.mulai-review');
    Route::post('/sc/pameran/simpan-review', [PameranReviewController::class, 'simpanReview'])->name('sc.pameran.simpan-review');
    Route::post('/sc/pameran/kirim-keputusan', [PameranReviewController::class, 'kirimKeputusan'])->name('sc.pameran.kirim-keputusan');
    Route::get('/sc/pameran/portofolio', [PameranReviewController::class, 'tampilPortofolio'])->name('sc.pameran.portofolio');
    Route::get('/sc/pameran/file-pertama', [PameranReviewController::class, 'tampilFilePertama'])->name('sc.pameran.file-pertama');

    Route::get('/sc/narasumber', [NarasumberReviewController::class, 'index'])->name('sc.narasumber');
    Route::get('/sc/narasumber/detail', [NarasumberReviewController::class, 'detail'])->name('sc.narasumber.detail');
    Route::post('/sc/narasumber/simpan-review', [NarasumberReviewController::class, 'simpanReview'])->name('sc.narasumber.simpan-review');
    Route::post('/sc/narasumber/kirim-keputusan', [NarasumberReviewController::class, 'kirimKeputusan'])->name('sc.narasumber.kirim-keputusan');
    Route::get('/sc/narasumber/berkas', [NarasumberReviewController::class, 'tampilBerkas'])->name('sc.narasumber.berkas');
});
