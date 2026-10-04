@extends('layout.layout')

@section('title', 'Pengajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Pameran</li>
@endsection

@php
    $labelStatus = [
        '3' => ['Sedang Direview', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Antrean Pengajuan Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Tema</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrean as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary btn-klaim" data-idpameran="{{ $baris->idpameran }}">
                                            <span class="btn-label">Klaim</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada pengajuan yang menunggu review.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Sedang / Sudah Diproses</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Tema</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($diproses as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sc.pameran.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada yang diproses.</td>
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
            var klaimUrl = '{{ route('sc.pameran.klaim') }}';
            var detailUrl = '{{ route('sc.pameran.detail') }}';

            $('.btn-klaim').on('click', function () {
                var $btn = $(this);
                var idpameran = $btn.data('idpameran');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Klaim pengajuan ini untuk direview? Hanya satu SC yang bisa mereview setiap pengajuan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, klaim',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: klaimUrl,
                        method: 'POST',
                        data: { idpameran: idpameran },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        window.location.href = detailUrl + '?token=' + res.data.token;
                    })
                    .fail(function (xhr) {
                        var res = xhr.responseJSON || {};
                        var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        if (xhr.status === 0) {
                            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        $('.page-alert').removeClass('d-none').text(pesan);
                        $btn.prop('disabled', false).html(teksAwal);

                        if (xhr.status === 409) {
                            location.reload();
                        }
                    });
                });
            });
        });
    </script>
@endsection
