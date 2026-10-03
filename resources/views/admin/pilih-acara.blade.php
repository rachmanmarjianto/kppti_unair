@extends('layout.layout')

@section('title', 'Pilih Acara')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        .baris-sub-acara > td {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }

        body.dark .baris-sub-acara > td {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .baris-sub-acara .sel-tema {
            padding-left: 2rem;
        }

        .check-acara,
        .check-acara-terkunci {
            width: 1.15em;
            height: 1.15em;
            border: 2px solid #4361ee;
        }

        .check-acara:checked {
            background-color: #4361ee;
            border-color: #4361ee;
        }

        input.check-acara-terkunci:disabled {
            opacity: 1 !important;
            background-color: #888ea8;
            border-color: #888ea8;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.peserta.acara') }}">Acara</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pilih Acara</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Pilih Acara — {{ $peserta->nama }}</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.peserta.acara') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Acara
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>Tema</th>
                                <th>Ruang</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Opsi Pilih</th>
                            </tr>
                        </thead>
                        @forelse ($acaraList as $acara)
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        @if($acara->bisaDipilih)
                                            @if($acara->terkunci)
                                                <input type="checkbox" class="form-check-input check-acara-terkunci" checked disabled title="Terdaftar otomatis (wajib)">
                                            @else
                                                <input type="checkbox" class="form-check-input check-acara" data-idacara="{{ $acara->idacara }}" @checked($acara->sudahTerdaftar)>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="sel-tema" style="white-space: pre-line;">{{ $acara->tema ?? '-' }}</td>
                                    <td>{{ $acara->children->isEmpty() ? ($acara->ruang ?? '-') : '-' }}</td>
                                    <td>{{ $acara->hari_ke ?? '-' }}</td>
                                    <td>{{ $acara->children->isNotEmpty() ? '-' : ($acara->jam_mulai ? substr($acara->jam_mulai, 0, 5).' - '.substr($acara->jam_akhir, 0, 5) : '-') }}</td>
                                    <td>
                                        @if(in_array($acara->opsi_pilih, ['2', '3'], true))
                                            @include('admin.partials.opsi-pilih-badge', ['opsi' => $acara->opsi_pilih])
                                        @endif
                                        <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                                    </td>
                                </tr>
                            </tbody>
                            @if($acara->children->isNotEmpty())
                                <tbody>
                                    @foreach ($acara->children as $anak)
                                        <tr class="baris-sub-acara">
                                            <td class="text-center">
                                                @if($anak->bisaDipilih)
                                                    @if($anak->terkunci)
                                                        <input type="checkbox" class="form-check-input check-acara-terkunci" checked disabled title="Terdaftar otomatis (wajib)">
                                                    @else
                                                        <input type="checkbox" class="form-check-input check-acara" data-idacara="{{ $anak->idacara }}" @checked($anak->sudahTerdaftar)>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="sel-tema" style="white-space: pre-line;">↳ {{ $anak->tema ?? '-' }}</td>
                                            <td>{{ $anak->ruang ?? '-' }}</td>
                                            <td>{{ $anak->hari_ke ?? '-' }}</td>
                                            <td>{{ $anak->jam_mulai ? substr($anak->jam_mulai, 0, 5).' - '.substr($anak->jam_akhir, 0, 5) : '-' }}</td>
                                            <td>
                                                @if(in_array($anak->opsi_pilih, ['2', '3'], true))
                                                    @include('admin.partials.opsi-pilih-badge', ['opsi' => $anak->opsi_pilih])
                                                @endif
                                                <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        @empty
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada acara.</td>
                                </tr>
                            </tbody>
                        @endforelse
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
            var daftarUrl = '{{ route('admin.peserta.acara.daftar') }}';
            var batalUrl = '{{ route('admin.peserta.acara.batal') }}';
            var idpeserta = {{ (int) $idpeserta }};

            $('.check-acara').on('change', function () {
                var $checkbox = $(this);
                var $spinner = $checkbox.closest('tr').find('.spinner-border').first();
                var idacara = $checkbox.data('idacara');
                var mauDidaftarkan = $checkbox.prop('checked');

                $checkbox.prop('disabled', true);
                $spinner.removeClass('d-none');

                $.ajax({
                    url: mauDidaftarkan ? daftarUrl : batalUrl,
                    method: 'POST',
                    data: { idpeserta: idpeserta, idacara: idacara },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $checkbox.prop('checked', !mauDidaftarkan);
                    Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                })
                .always(function () {
                    $checkbox.prop('disabled', false);
                    $spinner.addClass('d-none');
                });
            });
        });
    </script>
@endsection
