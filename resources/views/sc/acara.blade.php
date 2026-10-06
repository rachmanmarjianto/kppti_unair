@extends('layout.layout')

@section('title', 'Acara')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        .btn-toggle-anak {
            transition: transform 0.2s ease;
            color: #fff !important;
        }

        .btn-toggle-anak.expanded {
            transform: rotate(90deg);
        }

        tr[data-warna-hari] > td:first-child {
            background-color: var(--warna-hari, #bfc9d4) !important;
        }

        .baris-sub-acara > td {
            background-color: rgba(0, 0, 0, 0.07) !important;
        }

        body.dark .baris-sub-acara > td {
            background-color: rgba(255, 255, 255, 0.08) !important;
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
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Acara</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($legendaHari->isNotEmpty())
                    <div class="mb-3">
                        @foreach($legendaHari as $item)
                            <span class="d-inline-flex align-items-center me-3 mb-1">
                                <span style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color: {{ $item->warna }}; margin-right:6px;"></span>
                                Hari {{ $item->hari_ke }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 30px;"></th>
                                <th>Tema</th>
                                <th>Ruang</th>
                                <th>Opsi Pilih</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Pembicara</th>
                            </tr>
                        </thead>
                        @forelse ($acaraList as $acara)
                            <tbody>
                                <tr data-warna-hari style="--warna-hari: {{ $acara->warna_hari }};">
                                    <td>
                                        @if($acara->children->isNotEmpty())
                                            <button type="button" class="btn btn-sm btn-link btn-toggle-anak expanded p-0" data-bs-toggle="collapse" data-bs-target="#anak-{{ $acara->idacara }}" aria-expanded="true">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="sel-tema" style="white-space: pre-line;">{{ $acara->tema ?? '-' }}</td>
                                    <td>{{ $acara->children->isEmpty() ? ($acara->ruang ?? '-') : '-' }}</td>
                                    <td>@include('admin.partials.opsi-pilih-badge', ['opsi' => $acara->opsi_pilih])</td>
                                    <td>{{ $acara->hari_ke ?? '-' }}</td>
                                    <td>{{ $acara->children->isNotEmpty() ? '-' : ($acara->jam_mulai ? substr($acara->jam_mulai, 0, 5).' - '.substr($acara->jam_akhir, 0, 5) : '-') }}</td>
                                    <td>
                                        @if(! $acara->perlu_narsum)
                                            {{ $acara->speaker ?? '-' }}
                                        @elseif($acara->narasumberList->isNotEmpty())
                                            <ul class="list-unstyled mb-0">
                                                @foreach($acara->narasumberList as $ns)
                                                    <li>{{ $ns->nama }}@if($ns->subtema) <span class="text-muted">({{ $ns->subtema }})</span>@endif</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted fst-italic">Menunggu hasil review narasumber</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            @if($acara->children->isNotEmpty())
                                <tbody class="collapse show" id="anak-{{ $acara->idacara }}">
                                    @foreach($acara->children as $anak)
                                        <tr class="baris-sub-acara" data-warna-hari style="--warna-hari: {{ $anak->warna_hari }};">
                                            <td></td>
                                            <td class="sel-tema" style="white-space: pre-line;">↳ {{ $anak->tema ?? '-' }}</td>
                                            <td>{{ $anak->ruang ?? '-' }}</td>
                                            <td>@include('admin.partials.opsi-pilih-badge', ['opsi' => $anak->opsi_pilih])</td>
                                            <td>{{ $anak->hari_ke ?? '-' }}</td>
                                            <td>{{ $anak->jam_mulai ? substr($anak->jam_mulai, 0, 5).' - '.substr($anak->jam_akhir, 0, 5) : '-' }}</td>
                                            <td>
                                                @if(! $anak->perlu_narsum)
                                                    {{ $anak->speaker ?? '-' }}
                                                @elseif($anak->narasumberList->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($anak->narasumberList as $ns)
                                                            <li>{{ $ns->nama }}@if($ns->subtema) <span class="text-muted">({{ $ns->subtema }})</span>@endif</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted fst-italic">Menunggu hasil review narasumber</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        @empty
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada acara.</td>
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

    <script>
        $(function () {
            $('[data-bs-toggle="collapse"]').on('click', function () {
                $(this).toggleClass('expanded');
            });
        });
    </script>
@endsection
