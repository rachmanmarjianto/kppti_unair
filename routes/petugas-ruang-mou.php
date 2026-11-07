<?php

use App\Http\Controllers\PetugasRuangMouController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:7'])->group(function () {
    Route::get('/petugas-ruang-mou/pengajuan', [PetugasRuangMouController::class, 'index'])->name('petugas-ruang-mou.pengajuan');
    Route::post('/petugas-ruang-mou/pengajuan/sesuaikan-slot', [PetugasRuangMouController::class, 'sesuaikanSlot'])->name('petugas-ruang-mou.pengajuan.sesuaikan-slot');
    Route::get('/petugas-ruang-mou/pengajuan/detail-slot', [PetugasRuangMouController::class, 'detailSlot'])->name('petugas-ruang-mou.pengajuan.detail-slot');
    Route::post('/petugas-ruang-mou/pengajuan/hadir-pengaju', [PetugasRuangMouController::class, 'hadirPengaju'])->name('petugas-ruang-mou.pengajuan.hadir-pengaju');
    Route::post('/petugas-ruang-mou/pengajuan/batal-hadir-pengaju', [PetugasRuangMouController::class, 'batalHadirPengaju'])->name('petugas-ruang-mou.pengajuan.batal-hadir-pengaju');
    Route::post('/petugas-ruang-mou/pengajuan/hadir-mitra', [PetugasRuangMouController::class, 'hadirMitra'])->name('petugas-ruang-mou.pengajuan.hadir-mitra');
    Route::post('/petugas-ruang-mou/pengajuan/batal-hadir-mitra', [PetugasRuangMouController::class, 'batalHadirMitra'])->name('petugas-ruang-mou.pengajuan.batal-hadir-mitra');
    Route::post('/petugas-ruang-mou/pengajuan/ubah-hasil', [PetugasRuangMouController::class, 'ubahHasilPertemuan'])->name('petugas-ruang-mou.pengajuan.ubah-hasil');
});
