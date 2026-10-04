@extends('layout.layout')

@section('title', 'Tagihan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tagihan Pameran</li>
@endsection

@php
    $labelStatus = [
        1 => ['Tertagih', 'bg-secondary'],
        2 => ['Terbayar Sebagian', 'bg-info'],
        3 => ['Lunas', 'bg-success'],
        4 => ['Batal', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Tagihan Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="alert alert-warning">
                    Integrasi Virtual Account BNI belum aktif. Gunakan tombol "Tandai Lunas" untuk menandai tagihan secara manual sampai integrasi tersedia.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Tema Pameran</th>
                                <th>Nominal</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihan as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td>{{ number_format($baris->tagihan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if((int) $baris->status !== 3)
                                            <button type="button" class="btn btn-sm btn-outline-success btn-tandai-lunas" data-idtagihan="{{ $baris->idtagihan }}">
                                                Tandai Lunas
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada tagihan pameran.</td>
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
            var tandaiLunasUrl = '{{ route('admin.tagihan-pameran.tandai-lunas') }}';

            $('.btn-tandai-lunas').on('click', function () {
                var $btn = $(this);
                var idtagihan = $btn.data('idtagihan');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Tandai tagihan ini lunas? Pastikan pembayaran sudah benar-benar diterima.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, tandai lunas',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: tandaiLunasUrl,
                        method: 'POST',
                        data: { idtagihan: idtagihan },
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
                        }
                        $('.page-alert').removeClass('d-none').text(pesan);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
