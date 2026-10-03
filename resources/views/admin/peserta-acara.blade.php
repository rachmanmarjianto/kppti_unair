@extends('layout.layout')

@section('title', 'Acara Peserta')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        .btn-toggle-anak {
            transition: transform 0.2s ease;
        }

        .btn-toggle-anak.expanded {
            transform: rotate(90deg);
        }

        .baris-peserta > td {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }

        body.dark .baris-peserta > td {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .baris-peserta .sel-nama {
            padding-left: 2rem;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Acara Peserta</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Acara Peserta</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <p class="text-muted mb-0" style="font-size: 12.5px;">
                    Admin bisa mengatur pilihan acara peserta mana pun, termasuk setelah periode registrasi ditutup.
                </p>
            </div>
        </div>
    </div>

    @forelse ($jenisInstitusiList as $jenis)
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4>{{ $jenis->nama_jenis_institusi }}</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 30px;"></th>
                                    <th>Institusi / Peserta</th>
                                    <th>Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($jenis->institusiList as $institusi)
                                <tbody>
                                    <tr>
                                        <td>
                                            @if($institusi->jumlahPeserta > 0)
                                                <button type="button" class="btn btn-sm btn-link btn-toggle-anak expanded p-0" data-bs-toggle="collapse" data-bs-target="#institusi-{{ $institusi->idinstitusi_asal }}" aria-expanded="true">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td><strong>{{ $institusi->nama_institusi }}</strong></td>
                                        <td>{{ $institusi->jumlahPeserta }} peserta</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                @if($institusi->jumlahPeserta > 0)
                                    <tbody class="collapse show" id="institusi-{{ $institusi->idinstitusi_asal }}">
                                        @foreach ($institusi->pesertaList as $peserta)
                                            <tr class="baris-peserta">
                                                <td></td>
                                                <td class="sel-nama">↳ {{ $peserta->nama }}</td>
                                                <td>{{ $peserta->nama_jabatan }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.peserta.pilih-acara') }}?token={{ $peserta->token }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa-solid fa-calendar-check me-1"></i> Pilih Acara
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area text-center text-muted">
                    Belum ada peserta terdaftar.
                </div>
            </div>
        </div>
    @endforelse
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>

    <script>
        $(function () {
            $('[data-bs-toggle="collapse"]').on('click', function () {
                $(this).toggleClass('expanded');
            });
        });
    </script>
@endsection
