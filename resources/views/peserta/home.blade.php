@extends('layout.layout')

@section('title', 'Beranda Peserta')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        .form-control[readonly] {
            color: #000 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Beranda</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Selamat Datang</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3">
                    <label class="form-label">Nama Institusi</label>
                    <input type="text" class="form-control" value="{{ $institusi->nama_institusi ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Institusi</label>
                    <input type="text" class="form-control" value="{{ $institusi->nama_jenis_institusi ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Peserta Sekontingen</label>
                    <input type="text" class="form-control" value="{{ $jumlahPeserta }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Kelengkapan Data Peserta</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <p class="mb-3">
                    <strong>{{ $jumlahLengkap }}</strong> dari <strong>{{ $jumlahPeserta }}</strong> peserta sudah lengkap datanya.
                </p>

                @if($semuaLengkap)
                    <a href="{{ route('peserta.kartu-kontingen') }}" class="btn btn-primary">
                        <i class="fa-solid fa-download me-1"></i> Unduh Kartu Registrasi Kontingen
                    </a>
                @else
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fa-solid fa-download me-1"></i> Unduh Kartu Registrasi Kontingen
                    </button>
                    <div class="mt-2 text-muted" style="font-size: 12.5px;">
                        Lengkapi semua data peserta terlebih dahulu (lihat menu "Peserta Kontingen") sebelum kartu registrasi bisa diunduh.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
