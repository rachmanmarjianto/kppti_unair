<?php

use App\Http\Controllers\PetugasMejaRegisController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:8'])->group(function () {
    Route::get('/petugas-meja-regis', [PetugasMejaRegisController::class, 'index'])->name('petugas-meja-regis.index');
    Route::get('/petugas-meja-regis/refresh-list', [PetugasMejaRegisController::class, 'refreshList'])->name('petugas-meja-regis.refresh-list');
    Route::post('/petugas-meja-regis/panggil', [PetugasMejaRegisController::class, 'panggil'])->name('petugas-meja-regis.panggil');
    Route::post('/petugas-meja-regis/panggil-ulang', [PetugasMejaRegisController::class, 'panggilUlang'])->name('petugas-meja-regis.panggil-ulang');
    Route::post('/petugas-meja-regis/terlewat', [PetugasMejaRegisController::class, 'terlewat'])->name('petugas-meja-regis.terlewat');
    Route::post('/petugas-meja-regis/layani', [PetugasMejaRegisController::class, 'layani'])->name('petugas-meja-regis.layani');
    Route::post('/petugas-meja-regis/toggle-hadir', [PetugasMejaRegisController::class, 'toggleHadir'])->name('petugas-meja-regis.toggle-hadir');
    Route::post('/petugas-meja-regis/selesai-layani', [PetugasMejaRegisController::class, 'selesaiLayani'])->name('petugas-meja-regis.selesai-layani');
    Route::get('/petugas-meja-regis/riwayat-dilayani', [PetugasMejaRegisController::class, 'riwayatDilayani'])->name('petugas-meja-regis.riwayat-dilayani');
    Route::get('/petugas-meja-regis/unduh-pdf', [PetugasMejaRegisController::class, 'unduhPdfDaftarHadir'])->name('petugas-meja-regis.unduh-pdf');
});
