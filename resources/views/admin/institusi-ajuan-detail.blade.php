@extends('layout.layout')

@section('title', 'Detail Ajuan Institusi')

@section('page-css')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Ajuan Institusi</li>
@endsection

@php
    $labelStatusNarasumber = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
    ];

    $labelStatusPameran = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Memenuhi', 'bg-success'],
        '6' => ['Tidak Memenuhi', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
        '9' => ['Terpilih', 'bg-success'],
    ];
@endphp

@section('content')
    {{-- Card 1: info institusi --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Detail Ajuan Institusi</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Jenis Institusi</div>
                    <div class="col-12 col-sm-9">{{ $institusi->nama_jenis_institusi ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nama Unit Asal</div>
                    <div class="col-12 col-sm-9">{{ $institusi->nama_institusi ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: ajuan narasumber --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Ajuan Narasumber</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($narasumberList->isEmpty())
                    <p class="text-muted mb-0">Belum ada pengajuan narasumber.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Pengaju</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($narasumberList as $baris)
                                    <tr>
                                        <td>{{ $baris->nama }}</td>
                                        <td>
                                            <span class="badge {{ $labelStatusNarasumber[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                                {{ $labelStatusNarasumber[$baris->status_ajuan][0] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.narasumber.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Card 3: ajuan pameran --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Ajuan Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if(! $pameran)
                    <p class="text-muted mb-0">Belum ada pengajuan pameran.</p>
                @else
                    <div class="row mb-2">
                        <div class="col-12 col-sm-3 fw-bold">Tema</div>
                        <div class="col-12 col-sm-9">{{ $pameran->tema ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-sm-3 fw-bold">Status</div>
                        <div class="col-12 col-sm-9">
                            <span class="badge {{ $labelStatusPameran[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                                {{ $labelStatusPameran[$pameran->status_ajuan][0] ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.pameran.ajuan.detail') }}?token={{ $pameran->token }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-js')

@endsection
