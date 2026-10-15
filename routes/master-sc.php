<?php

use App\Http\Controllers\MasterScController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:6'])->group(function () {
    Route::get('/master-sc/narasumber', [MasterScController::class, 'index'])->name('master-sc.narasumber');
    Route::post('/master-sc/narasumber/putuskan', [MasterScController::class, 'putuskan'])->name('master-sc.narasumber.putuskan');
});
