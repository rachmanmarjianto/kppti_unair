@extends('layout.layout')

@section('title', 'Acara')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />

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
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Acara</li>
@endsection

@section('content')
    {{-- Card: daftar peserta sekontingen, tempat tombol "Pilih Acara" --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Peserta Kontingen</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th class="text-center">Jumlah Acara Diikuti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesertaList as $peserta)
                                <tr>
                                    <td>
                                        {{ $peserta->nama }}
                                        @if($peserta->idpengguna == session('userdata')['idpengguna'])
                                            <span class="badge bg-primary">Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $peserta->nama_jabatan }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $peserta->jumlahAcara }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('peserta.sekontingen.acara') }}?token={{ $peserta->token }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-calendar-check me-1"></i> Pilih Acara
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada peserta.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Card: jadwal acara + siapa saja dari kontingen ini yang mengikuti --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Jadwal Acara</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tema</th>
                                <th>Ruang</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Opsi Pilih</th>
                                <th>Peserta Mengikuti</th>
                            </tr>
                        </thead>
                        @forelse ($acaraList as $acara)
                            <tbody>
                                <tr>
                                    <td class="sel-tema" style="white-space: pre-line;">{{ $acara->tema ?? '-' }}</td>
                                    <td>{{ $acara->children->isEmpty() ? ($acara->ruang ?? '-') : '-' }}</td>
                                    <td>{{ $acara->hari_ke ?? '-' }}</td>
                                    <td>{{ $acara->children->isNotEmpty() ? '-' : ($acara->jam_mulai ? substr($acara->jam_mulai, 0, 5).' - '.substr($acara->jam_akhir, 0, 5) : '-') }}</td>
                                    <td>
                                        @if(in_array($acara->opsi_pilih, ['2', '3'], true))
                                            @include('admin.partials.opsi-pilih-badge', ['opsi' => $acara->opsi_pilih])
                                        @endif
                                    </td>
                                    <td>
                                        @if($acara->namaPeserta->isNotEmpty())
                                            <ul class="mb-0 ps-3">
                                                @foreach($acara->namaPeserta as $nama)
                                                    <li>{{ $nama }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            @if($acara->children->isNotEmpty())
                                <tbody>
                                    @foreach ($acara->children as $anak)
                                        <tr class="baris-sub-acara">
                                            <td class="sel-tema" style="white-space: pre-line;">↳ {{ $anak->tema ?? '-' }}</td>
                                            <td>{{ $anak->ruang ?? '-' }}</td>
                                            <td>{{ $anak->hari_ke ?? '-' }}</td>
                                            <td>{{ $anak->jam_mulai ? substr($anak->jam_mulai, 0, 5).' - '.substr($anak->jam_akhir, 0, 5) : '-' }}</td>
                                            <td>
                                                @if(in_array($anak->opsi_pilih, ['2', '3'], true))
                                                    @include('admin.partials.opsi-pilih-badge', ['opsi' => $anak->opsi_pilih])
                                                @endif
                                            </td>
                                            <td>
                                                @if($anak->namaPeserta->isNotEmpty())
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($anak->namaPeserta as $nama)
                                                            <li>{{ $nama }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
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
@endsection
