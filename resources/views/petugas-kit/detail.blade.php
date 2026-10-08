@extends('layout.layout')

@section('title', 'Kelola Seminar Kit')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        .check-kit, .check-kit-lengkap {
            width: 1.15em;
            height: 1.15em;
            border: 2px solid #4361ee;
        }

        .check-kit:checked, .check-kit-lengkap:checked {
            background-color: #4361ee;
            border-color: #4361ee;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('petugas-kit.home') }}">Seminar Kit</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kelola</li>
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
                        <a href="{{ route('petugas-kit.home') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p class="text-muted" style="font-size: 12.5px;">
                    Centang tiap kit yang sudah disiapkan untuk peserta tersebut, atau centang "Kit Lengkap" untuk menandai semua kit sekaligus.
                    Tiap peserta menempati 3 baris: baris pertama = status kit, baris kedua = tanggal diproses, baris ketiga = nama petugas yang mengerjakan.
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead>
                            <tr>
                                <th style="min-width: 180px;">Nama Peserta</th>
                                @foreach($kitAktif as $kit)
                                    <th class="text-center">{{ $kit->nama_kit }}</th>
                                @endforeach
                                <th class="text-center">Kit Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesertaList as $peserta)
                                <tr>
                                    <td rowspan="3">{{ $peserta->nama }}</td>
                                    @foreach($kitAktif as $kit)
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input check-kit"
                                                   data-idpeserta="{{ $peserta->idpeserta }}"
                                                   data-idseminar-kit="{{ $kit->idseminar_kit }}"
                                                   @checked($peserta->kitMap[$kit->idseminar_kit]['check'])>
                                            <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                                        </td>
                                    @endforeach
                                    <td rowspan="3" class="text-center">
                                        <input type="checkbox" class="form-check-input check-kit-lengkap"
                                               data-idpeserta="{{ $peserta->idpeserta }}"
                                               @checked($peserta->kit_lengkap)>
                                        <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach($kitAktif as $kit)
                                        <td class="text-center text-muted sel-created-at" style="font-size: 12px;"
                                            data-idpeserta="{{ $peserta->idpeserta }}" data-idseminar-kit="{{ $kit->idseminar_kit }}">
                                            {{ $peserta->kitMap[$kit->idseminar_kit]['created_at'] ? \Illuminate\Support\Carbon::parse($peserta->kitMap[$kit->idseminar_kit]['created_at'])->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($kitAktif as $kit)
                                        <td class="text-center text-muted sel-nama-petugas" style="font-size: 12px;"
                                            data-idpeserta="{{ $peserta->idpeserta }}" data-idseminar-kit="{{ $kit->idseminar_kit }}">
                                            {{ $peserta->kitMap[$kit->idseminar_kit]['nama_petugas'] ?? '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $kitAktif->count() + 2 }}" class="text-center text-muted">Belum ada peserta pada kontingen ini.</td>
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
            var toggleKitUrl = '{{ route('petugas-kit.toggle-kit') }}';
            var toggleLengkapUrl = '{{ route('petugas-kit.toggle-lengkap') }}';

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

            $('.check-kit').on('change', function () {
                var $checkbox = $(this);
                var $spinner = $checkbox.closest('td').find('.spinner-border');
                var idpeserta = $checkbox.data('idpeserta');
                var idseminarKit = $checkbox.data('idseminar-kit');
                var statusSebelum = !$checkbox.prop('checked');
                var checked = $checkbox.prop('checked');

                $checkbox.prop('disabled', true);
                $spinner.removeClass('d-none');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: toggleKitUrl,
                    method: 'POST',
                    data: { idpeserta: idpeserta, idseminar_kit: idseminarKit, checked: checked ? 1 : 0 },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $('.sel-created-at[data-idpeserta="' + idpeserta + '"][data-idseminar-kit="' + idseminarKit + '"]').text(res.data.createdAt);
                    $('.sel-nama-petugas[data-idpeserta="' + idpeserta + '"][data-idseminar-kit="' + idseminarKit + '"]').text(res.data.namaPetugas);
                    $('.check-kit-lengkap[data-idpeserta="' + idpeserta + '"]').prop('checked', res.data.kitLengkap);
                })
                .fail(function (xhr) {
                    $checkbox.prop('checked', statusSebelum);
                    tampilkanError(xhr);
                })
                .always(function () {
                    $checkbox.prop('disabled', false);
                    $spinner.addClass('d-none');
                });
            });

            $('.check-kit-lengkap').on('change', function () {
                var $checkbox = $(this);
                var $spinner = $checkbox.closest('td').find('.spinner-border');
                var idpeserta = $checkbox.data('idpeserta');
                var statusSebelum = !$checkbox.prop('checked');
                var checked = $checkbox.prop('checked');

                $checkbox.prop('disabled', true);
                $spinner.removeClass('d-none');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: toggleLengkapUrl,
                    method: 'POST',
                    data: { idpeserta: idpeserta, checked: checked ? 1 : 0 },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $('.check-kit[data-idpeserta="' + idpeserta + '"]').prop('checked', checked);
                    $('.sel-created-at[data-idpeserta="' + idpeserta + '"]').text(res.data.createdAt);
                    $('.sel-nama-petugas[data-idpeserta="' + idpeserta + '"]').text(res.data.namaPetugas);
                })
                .fail(function (xhr) {
                    $checkbox.prop('checked', statusSebelum);
                    tampilkanError(xhr);
                })
                .always(function () {
                    $checkbox.prop('disabled', false);
                    $spinner.addClass('d-none');
                });
            });
        });
    </script>
@endsection
