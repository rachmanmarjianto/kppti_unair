@extends('layout.layout')

@section('title', 'Detail Pengajuan MoU')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mou.pertemuan') }}">Pertemuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan</li>
@endsection

@php
    $labelStatusAjuan = [
        1 => ['Ajuan', 'bg-secondary'],
        2 => ['Temu Diskusi', 'bg-info'],
        3 => ['Tunda Lain Waktu', 'bg-warning'],
        4 => ['Terjalin', 'bg-success'],
        5 => ['Dibatalkan', 'bg-danger'],
    ];

    $waktuLokasi = $pertemuan && $pertemuan->tanggal
        ? \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y').' ('.substr($pertemuan->jam_mulai, 0, 5).'-'.substr($pertemuan->jam_akhir, 0, 5).') — '.$pertemuan->nama_ruang
        : '-';

    $catatan = $lampiranList->firstWhere('jenis_lampiran', 2);
    $fileList = $lampiranList->where('jenis_lampiran', 1);
@endphp

@section('content')
    {{-- Card 1: data pengajuan --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan MoU</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.mou.pertemuan') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Ajuan</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatusAjuan[$pengajuan->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatusAjuan[$pengajuan->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Pengaju</div>
                    <div class="col-12 col-sm-9">{{ $pengajuan->nama_institusi_pengaju }} ({{ $pengajuan->nama_jenis_institusi_pengaju }})</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC Pengaju</div>
                    <div class="col-12 col-sm-9">
                        {{ $pengajuan->nama_pic_pengaju ?? '-' }}
                        @if($pengajuan->no_wa_pic_pengaju)
                            <span class="text-muted">({{ $pengajuan->no_wa_pic_pengaju }})</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Mitra</div>
                    <div class="col-12 col-sm-9">{{ $pengajuan->nama_institusi_mitra }} ({{ $pengajuan->nama_jenis_institusi_mitra }})</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC Mitra</div>
                    <div class="col-12 col-sm-9">
                        {{ $pengajuan->nama_pic_mitra ?? 'Belum ditentukan' }}
                        @if($pengajuan->no_wa_pic_mitra)
                            <span class="text-muted">({{ $pengajuan->no_wa_pic_mitra }})</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Waktu dan Lokasi</div>
                    <div class="col-12 col-sm-9">{{ $waktuLokasi }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: lampiran --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Lampiran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <label class="form-label fw-bold">Catatan</label>
                @if($catatan && $catatan->catatan)
                    <div class="mb-3">{!! $catatan->catatan !!}</div>
                @else
                    <p class="text-muted mb-3">Tidak ada catatan.</p>
                @endif

                <label class="form-label fw-bold">File</label>
                @if($fileList->isEmpty())
                    <p class="text-muted mb-0">Tidak ada file lampiran.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tujuan File</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fileList as $file)
                                    <tr>
                                        <td>{{ $file->catatan ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.mou.pengajuan.lampiran') }}?token={{ $file->token }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-file-arrow-down me-1"></i> Unduh
                                            </a>
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

    {{-- Card 3: riwayat status --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Riwayat Status</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Oleh</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatStatus as $riwayat)
                                <tr>
                                    <td>
                                        <span class="badge {{ $labelStatusAjuan[$riwayat->status][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatusAjuan[$riwayat->status][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $riwayat->nama_done_by ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->done_at)->translatedFormat('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada riwayat status.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
