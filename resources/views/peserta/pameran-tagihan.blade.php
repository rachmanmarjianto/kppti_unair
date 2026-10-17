@extends('layout.layout')

@section('title', 'Detail Tagihan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-riwayat-pembayaran .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-riwayat-pembayaran .form-label, #modal-riwayat-pembayaran .form-check-label, #modal-riwayat-pembayaran .text-muted { color: #0e1726 !important; }
        #modal-riwayat-pembayaran .form-control { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peserta.pameran') }}">Pengajuan Pameran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Tagihan</li>
@endsection

@php
    $labelTagihan = [
        1 => ['Tertagih', 'bg-secondary'],
        2 => ['Terbayar Sebagian', 'bg-info'],
        3 => ['Lunas', 'bg-success'],
        4 => ['Batal', 'bg-danger'],
        5 => ['Expired', 'bg-dark'],
        6 => ['Ditangguhkan', 'bg-warning'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Detail Tagihan</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.pameran') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelTagihan[$tagihan->status][1] ?? 'bg-secondary' }}">
                            {{ $labelTagihan[$tagihan->status][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Bank</div>
                    <div class="col-12 col-sm-9">BNI</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nomor Virtual Account</div>
                    <div class="col-12 col-sm-9">{{ $tagihan->va ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Jumlah yang Harus Dibayar</div>
                    <div class="col-12 col-sm-9">Rp {{ number_format($tagihan->sisa_tagihan ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Berlaku Hingga</div>
                    <div class="col-12 col-sm-9">
                        {{ $tagihan->expired_date ? \Illuminate\Support\Carbon::parse($tagihan->expired_date)->format('d/m/Y H:i') : '-' }}
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-primary" id="btn-request-va-baru" @disabled((int) $tagihan->status !== 5)>
                        <span class="btn-label">Request VA Baru</span>
                    </button>
                    <form action="{{ route('peserta.pameran.tagihan.cek-status') }}" method="POST" id="form-cek-status" class="d-inline">
                        @csrf
                        <input type="hidden" name="idtagihan" value="{{ $tagihan->idtagihan }}">
                        <button type="submit" class="btn btn-outline-primary" id="btn-cek-status">
                            <span class="btn-label">Check Status Pembayaran</span>
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-riwayat-pembayaran">
                        Lihat Detail Pembayaran
                    </button>
                </div>

                @if((int) $tagihan->status !== 5)
                    <p class="text-muted mt-2 mb-0" style="font-size: 12.5px;">
                        Tombol "Request VA Baru" hanya aktif setelah tagihan ini dinyatakan expired.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal: riwayat pembayaran --}}
    <div class="modal fade" id="modal-riwayat-pembayaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($pembayaran->isEmpty())
                        <p class="text-muted mb-0">Belum ada pembayaran.</p>
                    @else
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Dibayar</th>
                                    <th>No. Referensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayaran as $bayar)
                                    <tr>
                                        <td>{{ $bayar->datetime_payment ? \Illuminate\Support\Carbon::parse($bayar->datetime_payment)->format('d/m/Y H:i') : '-' }}</td>
                                        <td>Rp {{ number_format($bayar->trx_amount ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $bayar->payment_ntb ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
            var requestVaBaruUrl = '{{ route('peserta.pameran.tagihan.request-va-baru') }}';

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

            $('#form-cek-status').on('submit', function () {
                var $btn = $('#btn-cek-status');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
            });

            $('#btn-request-va-baru').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Buat nomor Virtual Account baru untuk tagihan ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, buat baru',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var $btn = $('#btn-request-va-baru');
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: requestVaBaruUrl,
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
