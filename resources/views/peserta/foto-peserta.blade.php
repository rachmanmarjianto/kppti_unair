@extends('layout.layout')

@section('title', 'Foto Peserta')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        .crop-container {
            position: relative;
            max-width: 360px;
            margin: 0 auto;
        }

        .crop-container img#gambar-crop {
            display: block;
            max-width: 100%;
        }

        .panduan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .foto-tersimpan {
            max-width: 220px;
            border: 1px solid #e0e6ed;
            border-radius: 4px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peserta.sekontingen') }}">Peserta Kontingen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Foto</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Foto Peserta — {{ $peserta->nama }}</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.sekontingen') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Peserta
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($adaFoto)
                    <div class="mb-4">
                        <label class="form-label d-block">Foto Saat Ini</label>
                        <img src="{{ route('peserta.sekontingen.foto.tampil') }}?token={{ $token }}" alt="Foto peserta saat ini" class="foto-tersimpan">
                        <div class="text-muted mt-1" style="font-size: 12.5px;">
                            Ini adalah foto terbaru yang tersimpan.
                        </div>
                    </div>
                @endif

                <p>
                    Foto ini akan digunakan untuk pendaftaran perangkat 
                    <b><em>face recognition</em></b> di lokasi acara. Dimohon:
                    <ol>
                        <li>Gunakan foto terbaru.</li>
                        <li>Pastikan wajah terlihat jelas, menghadap kamera, tanpa penutup kepala.</li>
                        <li>Ikuti panduan kepala &amp; bahu di bawah.</li>
                    </ol>
                    Demi kelancaran acara, pastikan foto yang diunggah sesuai dengan ketentuan di atas.
                </p>

                <div class="mb-3">
                    <label class="form-label" for="input-foto">Pilih Foto Baru</label>
                    <input type="file" id="input-foto" class="form-control" accept="image/jpeg,image/png">
                </div>

                <div id="area-crop" class="crop-container d-none">
                    <img id="gambar-crop" src="" alt="Pratinjau crop">
                    <svg class="panduan-overlay" viewBox="0 0 300 400" preserveAspectRatio="none">
                        <ellipse cx="150" cy="130" rx="70" ry="90" fill="none" stroke="#ffffff" stroke-width="2" stroke-dasharray="6 4" opacity="0.85"></ellipse>
                        <path d="M 40 390 C 40 290, 80 230, 150 230 C 220 230, 260 290, 260 390" fill="none" stroke="#ffffff" stroke-width="2" stroke-dasharray="6 4" opacity="0.85"></path>
                    </svg>
                </div>

                <div class="mt-3 d-none" id="kontrol-crop">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-zoom-in"><i class="fa-solid fa-magnifying-glass-plus"></i> Perbesar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-zoom-out"><i class="fa-solid fa-magnifying-glass-minus"></i> Perkecil</button>
                    <button type="button" class="btn btn-primary ms-2" id="btn-simpan-foto">
                        <span class="btn-label">Simpan Foto</span>
                    </button>
                </div>

                <input type="hidden" id="input-idpeserta" value="{{ $idpeserta }}">
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var updateFotoUrl = '{{ route('peserta.sekontingen.foto.update') }}';
            var cropper = null;

            $('#input-foto').on('change', function (e) {
                var file = e.target.files[0];

                if (!file) {
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (event) {
                    var $img = $('#gambar-crop');
                    $('#area-crop').removeClass('d-none');
                    $('#kontrol-crop').removeClass('d-none');

                    if (cropper) {
                        cropper.destroy();
                    }

                    $img.attr('src', event.target.result);

                    cropper = new Cropper($img[0], {
                        aspectRatio: 3 / 4,
                        viewMode: 1,
                        autoCropArea: 1,
                        dragMode: 'move',
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false,
                        background: false,
                    });
                };
                reader.readAsDataURL(file);
            });

            $('#btn-zoom-in').on('click', function () {
                if (cropper) {
                    cropper.zoom(0.1);
                }
            });

            $('#btn-zoom-out').on('click', function () {
                if (cropper) {
                    cropper.zoom(-0.1);
                }
            });

            $('#btn-simpan-foto').on('click', function () {
                if (!cropper) {
                    return;
                }

                var $btn = $(this);

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Simpan foto ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    cropper.getCroppedCanvas({ width: 600, height: 800 }).toBlob(function (blob) {
                        var formData = new FormData();
                        formData.append('idpeserta', $('#input-idpeserta').val());
                        formData.append('foto', blob, 'foto.jpg');

                        $.ajax({
                            url: updateFotoUrl,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                        })
                        .done(function (res) {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                                location.reload();
                            });
                        })
                        .fail(function (xhr) {
                            var res = xhr.responseJSON || {};
                            var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                            if (xhr.status === 0) {
                                pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                            } else if (res.errors) {
                                pesan = Object.values(res.errors).flat().join('\n');
                            }
                            $('.page-alert').removeClass('d-none').text(pesan);
                        })
                        .always(function () {
                            $btn.prop('disabled', false).html(teksAwal);
                        });
                    }, 'image/jpeg', 0.92);
                });
            });
        });
    </script>
@endsection
