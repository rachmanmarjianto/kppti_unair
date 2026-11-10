@extends('layout.layout')

@section('title', 'Tapping Card')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        .status-idcard-peserta {
            font-size: 12px;
            margin-top: 2px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('petugas-kit.tapping-card') }}">Tapping Card</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>{{ $institusi->nama_institusi }} <small class="text-muted">({{ $institusi->nama_jenis_institusi }})</small></h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('petugas-kit.tapping-card') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p class="text-muted" style="font-size: 12.5px;">
                    Ketik/tap ID card lalu tekan Enter. Fokus otomatis pindah ke baris berikutnya dan nilai langsung tersimpan.
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead>
                            <tr>
                                <th style="min-width: 220px;">Nama Peserta</th>
                                <th style="min-width: 220px;">ID Card</th>
                            </tr>
                        </thead>
                        <tbody id="baris-peserta-idcard">
                            @forelse($pesertaList as $peserta)
                                <tr>
                                    <td>
                                        @if(! $peserta->lengkap && $peserta->isNarasumberDiterima)
                                            <span class="text-primary">{{ $peserta->nama }} (Belum Lengkap) (NARASUMBER)</span>
                                        @elseif(! $peserta->lengkap)
                                            <span class="text-danger">{{ $peserta->nama }} (Belum Lengkap)</span>
                                        @elseif($peserta->isNarasumberDiterima)
                                            <span class="text-primary">{{ $peserta->nama }} (NARASUMBER)</span>
                                        @elseif($peserta->isPetugasJaga)
                                            <span class="text-success">{{ $peserta->nama }} (booth crew)</span>
                                        @else
                                            {{ $peserta->nama }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control input-idcard" data-idpengguna="{{ $peserta->idpengguna }}" value="{{ $peserta->idcard }}" autocomplete="off">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-hapus-idcard" data-idpengguna="{{ $peserta->idpengguna }}" title="Hapus ID Card">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="status-idcard-peserta"></div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada peserta pada kontingen ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var simpanUrl = '{{ route('petugas-kit.tapping-card.simpan') }}';
            var hapusIdcardUrl = '{{ route('petugas-kit.tapping-card.hapus-idcard') }}';

            function tampilkanError(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $('.page-alert').removeClass('d-none').text(pesan);

                return pesan;
            }

            function simpanIdcard($input) {
                var $status = $input.closest('td').find('.status-idcard-peserta');
                var idpengguna = $input.data('idpengguna');
                var idcard = $input.val();

                if (idcard === '') {
                    $status.html('');

                    return;
                }

                $.ajax({
                    url: simpanUrl,
                    method: 'POST',
                    data: { idpengguna: idpengguna, idcard: idcard },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function () {
                    $('.page-alert').addClass('d-none').text('');
                    $status.html('<i class="fa-solid fa-check text-success"></i>');
                })
                .fail(function (xhr) {
                    var pesan = tampilkanError(xhr);
                    $status.html('<i class="fa-solid fa-xmark text-danger" title="' + pesan.replace(/"/g, '&quot;') + '"></i>');
                });

                $status.text('Proses...');
            }

            function fokusInputKosongPertama() {
                var $kosong = $('.input-idcard').filter(function () {
                    return $(this).val() === '';
                }).first();

                if ($kosong.length) {
                    $kosong.focus();
                }
            }

            $('#baris-peserta-idcard').on('click', '.btn-hapus-idcard', function () {
                var $btn = $(this);
                var idpengguna = $btn.data('idpengguna');
                var $input = $('.input-idcard[data-idpengguna="' + idpengguna + '"]');
                var $status = $input.closest('td').find('.status-idcard-peserta');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus ID card peserta ini? Card fisiknya bisa dipakai ulang untuk peserta lain setelah ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: hapusIdcardUrl,
                        method: 'POST',
                        data: { idpengguna: idpengguna },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function () {
                        $input.val('');
                        $status.html('');
                    })
                    .fail(function (xhr) {
                        tampilkanError(xhr);
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html('<i class="fa-solid fa-trash"></i>');
                    });
                });
            });

            $('.input-idcard').on('keydown', function (e) {
                if (e.key !== 'Enter') {
                    return;
                }

                e.preventDefault();

                var $inputs = $('.input-idcard');
                var index = $inputs.index(this);
                var $berikutnya = $inputs.eq(index + 1);

                if ($berikutnya.length) {
                    $berikutnya.focus();
                } else {
                    $(this).blur();
                }

                simpanIdcard($(this));
            });

            fokusInputKosongPertama();
        });
    </script>
@endsection
