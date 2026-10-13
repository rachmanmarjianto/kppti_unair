@extends('layout.layout')

@section('title', 'Detail Pengajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sc.pameran') }}">Pengajuan Pameran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@php
    $labelStatus = [
        '2' => $pameran->direview_oleh ? ['Sedang Direview', 'bg-warning'] : ['Menunggu Klaim', 'bg-info'],
        '3' => ['Sedang Direview', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
    ];
@endphp

@section('content')
    {{-- Card 1: data pengajuan pameran --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan Pameran</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('sc.pameran') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 220px;">Institusi</th>
                            <td>{{ $pameran->nama_institusi }}</td>
                        </tr>
                        <tr>
                            <th>PIC</th>
                            <td>{{ $pameran->nama_pic }}</td>
                        </tr>
                        <tr>
                            <th>Tema</th>
                            <td>{{ $pameran->tema }}</td>
                        </tr>
                        <tr>
                            <th>Extended Abstrak</th>
                            <td>{!! $pameran->abstract !!}</td>
                        </tr>
                        <tr>
                            <th>Nomor Stand</th>
                            <td>{{ $pameran->nomor_stand }}</td>
                        </tr>
                        <tr>
                            <th>Status Saat Ini</th>
                            <td>
                                <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                                    {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Direview Oleh</th>
                            <td>{{ $pameran->nama_sc }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Card 2: riwayat review_pameran + aksi review --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4>Riwayat Review</h4>
                    </div>
                    <div class="col-auto">
                        @if($pameran->status_ajuan === '2' && ! $pameran->direview_oleh)
                            <button type="button" class="btn btn-primary btn-sm" id="btn-klaim">
                                <span class="btn-label">Klaim untuk Direview</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if(in_array($pameran->status_ajuan, ['2', '3'], true) && $pameran->direview_oleh && ! $reviewAktif)
                    <div class="alert alert-info">
                        Ada SC lain yang sedang mereview pengajuan ini. Isi review belum bisa ditampilkan.
                    </div>
                @endif

                @if($riwayat->isEmpty())
                    <p class="text-muted mb-0">Belum ada riwayat.</p>
                @else
                    <div class="accordion" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            @php $iniAktif = $reviewAktif && $baris->idreview === $reviewAktif->idreview; @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if(! $iniAktif) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
                                        #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse @if($iniAktif) show @endif" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($iniAktif)
                                            <a href="{{ route('sc.pameran.review') }}?token={{ $reviewAktif->token }}" class="btn btn-primary btn-sm mb-3">
                                                Beri Review
                                            </a>
                                        @endif

                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('sc.pameran.portofolio') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Portofolio
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan:</strong><br>{{ $baris->catatan }}</p>
                                        @endif

                                        @if($baris->kriteria->isNotEmpty())
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Kriteria</th>
                                                        <th>Catatan</th>
                                                        <th>Memenuhi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($baris->kriteria as $k)
                                                        <tr>
                                                            <td>{{ $k->nama_topik }}</td>
                                                            <td>{!! $k->isi_review !!}</td>
                                                            <td>
                                                                @if($k->memenuhi)
                                                                    <span class="badge bg-success">Ya</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tidak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var klaimUrl = '{{ route('sc.pameran.klaim') }}';

            $('#btn-klaim').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: klaimUrl,
                    method: 'POST',
                    data: { idpameran: {{ $pameran->idpameran }} },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function () {
                    location.reload();
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
    </script>
@endsection
