@extends('layout.layout')

@section('title', 'Poster')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Poster</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Poster</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p style="font-size: 18px;">
                    Anda terpilih untuk mengirimkan Poster dari extended abstract yang telah anda ajukan sebagai Narasumber.<br>Silakan unggah file poster
                    (ukuran A0) untuk dicetak panitia.
                </p>

                <div class="alert alert-info">
                    <i class="fa-solid fa-circle-info"></i>
                    Syarat file poster: format <strong>PDF</strong>, ukuran halaman minimal <strong>A0 (841 x 1189 mm, Portrait)</strong>, maks. 50 MB.
                    Ukuran lebih besar dari A0 tetap diperbolehkan. File dengan ukuran halaman di bawah minimal akan ditolak otomatis.
                    <br>
                    Silahkan unduh template PowerPoint berikut, sesuaikan kontennya, lalu ekspor ke PDF
                    (ukuran halaman akan otomatis sesuai A0):
                    <a href="{{ route('peserta.poster.template') }}" class="fw-bold" style="color: #8a060d;" target="_blank">
                        <i class="fa-solid fa-file-powerpoint" ></i> Unduh Template Poster A0
                    </a>
                </div>

                <div class="row mb-3" style="margin-top: 20px;">
                    <div class="col-12 col-sm-3 fw-bold">Sesi yang Dipilih</div>
                    <div class="col-12 col-sm-9">
                        @if($sesi && $sesi->parent_tema)
                            {{ $sesi->parent_tema }} <br>&mdash;
                        @endif
                        {{ $sesi->tema ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-sm-3 fw-bold">Subtema</div>
                    <div class="col-12 col-sm-9">
                        {{ $narasumber->subtema ?? '-' }}
                    </div>
                </div>

                @if($jadwal)
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 fw-bold">Batas Waktu Pengiriman</div>
                        <div class="col-12 col-sm-9">
                            @if($jadwal->timestamp_buka)
                                {{ \Illuminate\Support\Carbon::parse($jadwal->timestamp_buka)->format('d/m/Y H:i') }} &mdash;
                            @endif
                            {{ $jadwal->timestamp_tutup ? \Illuminate\Support\Carbon::parse($jadwal->timestamp_tutup)->format('d/m/Y H:i') : '-' }}
                            @if(! $jadwalSedangBuka)
                                <span class="badge bg-danger ms-1">Ditutup</span>
                            @endif
                        </div>
                    </div>
                @endif

                @if($fileAktif)
                    <div class="card border mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="fw-bold"><i class="fa-solid fa-file-pdf text-danger"></i> File Poster Terkirim</div>
                                <div class="text-muted" style="font-size: 12.5px;">
                                    Diunggah pada {{ \Illuminate\Support\Carbon::parse($fileAktif->created_at)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('peserta.poster.berkas') }}?token={{ $fileAktif->token }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-download"></i> Unduh
                                </a>
                                @if($jadwalSedangBuka)
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="btn-hapus-poster">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($jadwalSedangBuka)
                    <form id="form-poster">
                        <div class="mb-3">
                            <label class="form-label" for="input-berkas-poster">File Poster (PDF, ukuran halaman minimal A0 Portrait, maks. 50 MB)</label>
                            <input type="file" name="berkas" id="input-berkas-poster" class="form-control" accept=".pdf" required>
                        </div>

                        <button type="submit" class="btn btn-primary" id="btn-simpan-poster">
                            <span class="btn-label">Unggah Poster</span>
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning">
                        Periode pengiriman poster sudah ditutup dan Anda belum mengirimkan file poster.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = '{{ csrf_token() }}';
            var simpanUrl = '{{ route('peserta.poster.simpan') }}';
            var hapusUrl = '{{ route('peserta.poster.hapus') }}';

            function tampilkanError(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';

                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }

                $('.page-alert').removeClass('d-none').text(pesan);
            }

            $('#form-poster').on('submit', function (e) {
                e.preventDefault();

                $('.page-alert').addClass('d-none').text('');

                var $btn = $('#btn-simpan-poster');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Mengunggah...');

                var formData = new FormData(document.getElementById('form-poster'));

                $.ajax({
                    url: simpanUrl,
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
                    tampilkanError(xhr);
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            $('#btn-hapus-poster').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'File poster yang sudah dikirim akan dihapus. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Tidak',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    var $btn = $('#btn-hapus-poster');
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...');

                    $.ajax({
                        url: hapusUrl,
                        method: 'POST',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanError(xhr);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
