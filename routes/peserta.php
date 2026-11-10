<?php

use App\Http\Controllers\MouController;
use App\Http\Controllers\NarasumberController;
use App\Http\Controllers\PameranController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PosterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['akses:2'])->group(function () {
    Route::get('/home-peserta', [PesertaController::class, 'home'])->name('peserta.home');
    Route::get('/pameran', [PameranController::class, 'index'])->name('peserta.pameran');
    Route::post('/pameran/simpan-draft', [PameranController::class, 'simpanDraft'])->name('peserta.pameran.simpan-draft');
    Route::post('/pameran/ajukan', [PameranController::class, 'ajukan'])->name('peserta.pameran.ajukan');
    Route::post('/pameran/batalkan-ajuan', [PameranController::class, 'batalkanAjuan'])->name('peserta.pameran.batalkan-ajuan');
    Route::get('/pameran/portofolio', [PameranController::class, 'tampilPortofolio'])->name('peserta.pameran.portofolio');
    Route::get('/pameran/file-pertama', [PameranController::class, 'tampilFilePertama'])->name('peserta.pameran.file-pertama');
    Route::get('/pameran/balas-revisi', [PameranController::class, 'tampilBalasRevisi'])->name('peserta.pameran.balas-revisi');
    Route::post('/pameran/balas-revisi/kirim', [PameranController::class, 'balasRevisi'])->name('peserta.pameran.balas-revisi.kirim');
    Route::get('/pameran/template', [PameranController::class, 'unduhTemplate'])->name('peserta.pameran.template');
    Route::get('/pameran/tagihan', [PameranController::class, 'tagihan'])->name('peserta.pameran.tagihan');
    Route::post('/pameran/tagihan/request-va-baru', [PameranController::class, 'requestVaBaru'])->name('peserta.pameran.tagihan.request-va-baru');
    Route::post('/pameran/tagihan/cek-status', [PameranController::class, 'cekStatusPembayaran'])->name('peserta.pameran.tagihan.cek-status');
    Route::post('/pameran/penjaga/tambah', [PameranController::class, 'tambahPenjaga'])->name('peserta.pameran.penjaga.tambah');
    Route::post('/pameran/penjaga/hapus', [PameranController::class, 'hapusPenjaga'])->name('peserta.pameran.penjaga.hapus');
    Route::post('/pameran/jadwal-loading', [PameranController::class, 'simpanJadwalLoading'])->name('peserta.pameran.jadwal-loading');
    Route::get('/narasumber', [NarasumberController::class, 'index'])->name('peserta.narasumber');
    Route::post('/narasumber/simpan-draft', [NarasumberController::class, 'simpanDraft'])->name('peserta.narasumber.simpan-draft');
    Route::post('/narasumber/ajukan', [NarasumberController::class, 'ajukan'])->name('peserta.narasumber.ajukan');
    Route::post('/narasumber/batalkan-ajuan', [NarasumberController::class, 'batalkanAjuan'])->name('peserta.narasumber.batalkan-ajuan');
    Route::get('/narasumber/berkas', [NarasumberController::class, 'tampilBerkas'])->name('peserta.narasumber.berkas');
    Route::get('/narasumber/pedoman', [NarasumberController::class, 'unduhPedoman'])->name('peserta.narasumber.pedoman');
    Route::post('/narasumber/presentasi/simpan', [NarasumberController::class, 'simpanPresentasi'])->name('peserta.narasumber.presentasi.simpan');
    Route::post('/narasumber/presentasi/hapus', [NarasumberController::class, 'hapusPresentasi'])->name('peserta.narasumber.presentasi.hapus');
    Route::get('/narasumber/presentasi/berkas', [NarasumberController::class, 'tampilBerkasPresentasi'])->name('peserta.narasumber.presentasi.berkas');
    Route::post('/narasumber/video/simpan', [NarasumberController::class, 'simpanVideo'])->name('peserta.narasumber.video.simpan');
    Route::post('/narasumber/video/hapus', [NarasumberController::class, 'hapusVideo'])->name('peserta.narasumber.video.hapus');
    Route::get('/poster', [PosterController::class, 'index'])->name('peserta.poster');
    Route::post('/poster/simpan', [PosterController::class, 'simpan'])->name('peserta.poster.simpan');
    Route::post('/poster/hapus', [PosterController::class, 'hapus'])->name('peserta.poster.hapus');
    Route::get('/poster/berkas', [PosterController::class, 'tampilBerkas'])->name('peserta.poster.berkas');
    Route::get('/poster/template', [PosterController::class, 'unduhTemplate'])->name('peserta.poster.template');
    Route::get('/mou/list-peserta', [MouController::class, 'listPeserta'])->name('peserta.mou.list-peserta');
    Route::get('/mou/list-peserta/peserta', [MouController::class, 'pesertaInstitusi'])->name('peserta.mou.list-peserta.peserta');
    Route::get('/mou/pengajuan', [MouController::class, 'daftarPengajuan'])->name('peserta.mou.pengajuan');
    Route::get('/mou/pengajuan/template', [MouController::class, 'unduhTemplate'])->name('peserta.mou.pengajuan.template');
    Route::get('/mou/pengajuan/detail', [MouController::class, 'detailPengajuan'])->name('peserta.mou.pengajuan.detail');
    Route::get('/mou/pengajuan/lampiran', [MouController::class, 'unduhLampiran'])->name('peserta.mou.pengajuan.lampiran');
    Route::get('/mou/pengajuan/tambah', [MouController::class, 'tambahPengajuanForm'])->name('peserta.mou.pengajuan.tambah');
    Route::get('/mou/pengajuan/opsi-mitra', [MouController::class, 'opsiMitraInstitusi'])->name('peserta.mou.pengajuan.opsi-mitra');
    Route::post('/mou/pengajuan/simpan', [MouController::class, 'simpanPengajuan'])->name('peserta.mou.pengajuan.simpan');
    Route::post('/mou/pengajuan/tunda', [MouController::class, 'tundaAjuan'])->name('peserta.mou.pengajuan.tunda');
    Route::post('/mou/pengajuan/batalkan', [MouController::class, 'batalkanAjuan'])->name('peserta.mou.pengajuan.batalkan');
    Route::post('/mou/pengajuan/ubah-pic', [MouController::class, 'ubahPicPengaju'])->name('peserta.mou.pengajuan.ubah-pic');
    Route::get('/mou/jadwal-temu', [MouController::class, 'jadwalTemu'])->name('peserta.mou.jadwal-temu');
    Route::get('/mou/pengajuan/opsi-sesi', [MouController::class, 'opsiSesiTersedia'])->name('peserta.mou.pengajuan.opsi-sesi');
    Route::post('/mou/pengajuan/respon-temu-diskusi', [MouController::class, 'responTemuDiskusi'])->name('peserta.mou.pengajuan.respon-temu-diskusi');
    Route::post('/institusi-asal/update', [PesertaController::class, 'updateInstitusi'])->name('peserta.institusi.update');
    Route::get('/peserta-sekontingen', [PesertaController::class, 'sekontingen'])->name('peserta.sekontingen');
    Route::get('/peserta-sekontingen/detail', [PesertaController::class, 'detailPeserta'])->name('peserta.sekontingen.detail');
    Route::post('/peserta-sekontingen/tambah', [PesertaController::class, 'tambahPeserta'])->name('peserta.sekontingen.tambah');
    Route::post('/peserta-sekontingen/update', [PesertaController::class, 'updatePeserta'])->name('peserta.sekontingen.update');
    Route::post('/peserta-sekontingen/reset-password', [PesertaController::class, 'resetPasswordPeserta'])->name('peserta.sekontingen.reset-password');
    Route::get('/peserta-sekontingen/logistik', [PesertaController::class, 'detailLogistik'])->name('peserta.sekontingen.logistik.detail');
    Route::post('/peserta-sekontingen/logistik/update', [PesertaController::class, 'updateLogistik'])->name('peserta.sekontingen.logistik.update');
    Route::get('/kartu-kontingen', [PesertaController::class, 'kartuKontingen'])->name('peserta.kartu-kontingen');
    Route::get('/peserta-sekontingen/foto', [PesertaController::class, 'foto'])->name('peserta.sekontingen.foto');
    Route::get('/peserta-sekontingen/foto/tampil', [PesertaController::class, 'tampilFoto'])->name('peserta.sekontingen.foto.tampil');
    Route::post('/peserta-sekontingen/foto/update', [PesertaController::class, 'updateFoto'])->name('peserta.sekontingen.foto.update');
    Route::get('/peserta-acara', [PesertaController::class, 'acara'])->name('peserta.acara');
    Route::get('/peserta-sekontingen/acara', [PesertaController::class, 'pilihAcara'])->name('peserta.sekontingen.acara');

    // Khusus penjaga stand pameran × acara wajib — sengaja TIDAK digerbangi
    // jadwalPenting, karena mereka boleh membatalkan/mendaftar ulang acara
    // wajib kapan pun walau sesi registrasi acara sudah ditutup.
    Route::post('/peserta-sekontingen/acara/batal-wajib-penjaga', [PesertaController::class, 'toggleAcaraWajibPenjaga'])->name('peserta.sekontingen.acara.batal-wajib-penjaga');

    // Pilihan acara hanya bisa diubah selama jadwal_penting id=7 (Registrasi
    // Acara) sedang terbuka — pakai syarat default 'buka' (cek timestamp_buka
    // DAN timestamp_tutup), bukan 'tutup' saja: jadwal ini kini jadwal
    // tersendiri (sebelumnya menumpang id=1 Registrasi Peserta, yang mustahil
    // "belum dibuka" karena peserta itu sendiri baru ada setelah registrasi
    // peserta dibuka — asumsi itu tidak berlaku lagi untuk jadwal terpisah
    // ini). Tujuannya alokasi konsumsi di ruangan, bukan data peserta secara
    // umum (yang tetap boleh diubah kapan saja). Lihat
    // docs/features/017-portal-registrasi-peserta.md.
    Route::middleware(['jadwalPenting:7'])->group(function () {
        Route::post('/peserta-sekontingen/acara/daftar', [PesertaController::class, 'daftarAcara'])->name('peserta.sekontingen.acara.daftar');
        Route::post('/peserta-sekontingen/acara/batal', [PesertaController::class, 'batalAcara'])->name('peserta.sekontingen.acara.batal');
    });
});
