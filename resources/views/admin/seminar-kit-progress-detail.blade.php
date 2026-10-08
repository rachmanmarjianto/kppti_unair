@extends('layout.layout')

@section('title', 'Detail Progress Seminar Kit')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.seminar-kit.progress') }}">Progress Seminar Kit</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                        <a href="{{ route('admin.seminar-kit.progress') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <p class="text-muted" style="font-size: 12.5px;">
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
                                            @if($peserta->kitMap[$kit->idseminar_kit]['check'])
                                                <i class="fa-solid fa-check text-success"></i>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td rowspan="3" class="text-center">
                                        @if($peserta->kit_lengkap)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    @foreach($kitAktif as $kit)
                                        <td class="text-center text-muted" style="font-size: 12px;">
                                            {{ $peserta->kitMap[$kit->idseminar_kit]['created_at'] ? \Illuminate\Support\Carbon::parse($peserta->kitMap[$kit->idseminar_kit]['created_at'])->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($kitAktif as $kit)
                                        <td class="text-center text-muted" style="font-size: 12px;">
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
