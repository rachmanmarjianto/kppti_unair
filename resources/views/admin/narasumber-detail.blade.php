@extends('layout.layout')

@section('title', 'Detail Narasumber')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.narasumber') }}">Narasumber</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@php
    $labelStatus = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
    ];
@endphp

@section('content')
    {{-- Card 1: data pengajuan narasumber --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan Narasumber</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.narasumber') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nama Pengaju</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->nama_pengaju }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Asal</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->nama_institusi ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Email</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">No. WA</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->no_wa ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Extended Abstrak</div>
                    <div class="col-12 col-sm-9">{!! $narasumber->abstract !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Saat Ini</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatus[$narasumber->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatus[$narasumber->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Sesi yang Dipilih Peserta</div>
                    <div class="col-12 col-sm-9">
                        @if($narasumber->acara_parent_tema)
                            {{ $narasumber->acara_parent_tema }} <br>&mdash;
                        @endif
                        {{ $narasumber->acara_tema ?? '-' }}<br>
                        @if($narasumber->acara_hari_ke)
                            (Hari {{ $narasumber->acara_hari_ke }}, {{ substr($narasumber->acara_jam_mulai, 0, 5) }}–{{ substr($narasumber->acara_jam_akhir, 0, 5) }}, {{ $narasumber->acara_ruang ?? '-' }})
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Subtema</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->subtema ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: riwayat review_narasumber, read-only --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Riwayat Review</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($riwayat->isEmpty())
                    <p class="text-muted mb-0">Belum ada riwayat.</p>
                @else
                    <div class="accordion" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if(! $loop->last) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
                                        #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse @if($loop->last) show @endif" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('admin.narasumber.berkas') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Extended Abstract
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan:</strong><br>{{ $baris->catatan }}</p>
                                        @endif

                                        @if($baris->kriteria->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Topik</th>
                                                            <th>Komentar</th>
                                                            <th class="text-center">Bobot</th>
                                                            <th class="text-center">Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($baris->kriteria as $k)
                                                            <tr>
                                                                <td class="text-nowrap">{{ $k->nama_topik }}</td>
                                                                <td class="text-nowrap">{{ $k->isi_review ?? '-' }}</td>
                                                                <td class="text-center text-nowrap">{{ $k->bobot_dlm_persen }}%</td>
                                                                <td class="text-center text-nowrap">{{ $k->nilai ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p class="fw-bold mb-2">Nilai Akhir: {{ $baris->nilai_akhir ?? '-' }}</p>
                                        @endif

                                        @if($baris->nama_sc)
                                            <p class="text-muted mb-0" style="font-size: 12.5px;">
                                                Direview oleh {{ $baris->nama_sc }}
                                                @if($baris->reviewed_at)
                                                    pada {{ \Illuminate\Support\Carbon::parse($baris->reviewed_at)->format('d/m/Y H:i') }}
                                                @endif
                                            </p>
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
