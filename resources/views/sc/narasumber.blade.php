@extends('layout.layout')

@section('title', 'Pengajuan Narasumber')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <style>
        .dataTables_wrapper .page-item.previous .page-link,
        .dataTables_wrapper .page-item.next .page-link,
        .dataTables_wrapper .page-item.first .page-link,
        .dataTables_wrapper .page-item.last .page-link {
            width: auto;
            white-space: nowrap;
            padding: 0 12px;
        }

        .table-sc-narasumber {
            width: 95% !important;
            margin: 0 auto;
        }

        .dt--top-section,
        .dt--bottom-section {
            padding: 0 15px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Narasumber</li>
@endsection

@php
    $labelStatus = [
        '2' => ['Menunggu Review', 'bg-info'],
        '3' => ['Sedang Direview', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
    ];
@endphp

@section('content')
    <form method="GET" action="{{ route('sc.narasumber') }}" id="form-filter-acara-narasumber">
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Antrean Pengajuan Narasumber</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-parent-antrean" class="form-label">Filter Sub Tema</label>
                    <select id="input-filter-parent-antrean" name="idparent_antrean" class="form-select" onchange="document.getElementById('input-filter-acara-antrean').value = ''; this.form.submit();">
                        <option value="">-- Semua Sub Tema --</option>
                        @foreach($acaraParentOptions as $parent)
                            <option
                                value="{{ $parent->idparent_acara }}"
                                @if((string) $idparentAntrean === (string) $parent->idparent_acara) selected @endif
                                @if($idparentDenganPengajuanBaru->contains($parent->idparent_acara)) style="color: #e7515a; font-weight: 600;" @endif
                            >
                                {{ $parent->parent_tema }}
                                @if($idparentDenganPengajuanBaru->contains($parent->idparent_acara))
                                    (Ada Pengajuan Baru)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-acara-antrean" class="form-label">Filter Sesi</label>
                    <select id="input-filter-acara-antrean" name="idacara_antrean" class="form-select" onchange="this.form.submit()" @if(! $idparentAntrean) disabled @endif>
                        <option value="">-- Semua Sesi --</option>
                        @foreach($acaraOptionsAntrean as $acara)
                            <option
                                value="{{ $acara->idacara }}"
                                @if((string) $idacaraAntrean === (string) $acara->idacara) selected @endif
                                @if($idacaraDenganPengajuanBaru->contains($acara->idacara)) style="color: #e7515a; font-weight: 600;" @endif
                            >
                                {{ $acara->tema }}
                                @if($idacaraDenganPengajuanBaru->contains($acara->idacara))
                                    (Ada Pengajuan Baru)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @if(! $idparentAntrean)
                        <small class="text-muted">Pilih Sub Tema terlebih dahulu.</small>
                    @endif
                </div>

                <p class="mb-3" style="margin:15px">
                    <b>Acara yang dipilih:</b>
                    @if($acaraTerpilihAntrean)
                        @if($acaraTerpilihAntrean->parent_tema)
                            {{ $acaraTerpilihAntrean->parent_tema }} <br>&mdash;
                        @endif
                        {{ $acaraTerpilihAntrean->tema }}
                    @elseif($parentTerpilihAntrean)
                        {{ $parentTerpilihAntrean->parent_tema }}
                    @else
                        Semua Acara
                    @endif
                </p>

                <div class="table-responsive">
                    <table id="table-antrean-narasumber" class="table table-hover table-bordered table-sc-narasumber">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Institusi Asal</th>
                                <th>Status</th>
                                <th class="text-center">Jumlah Riwayat Ajuan</th>
                                <th>Reviewer Terakhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($antrean as $baris)
                                <tr>
                                    <td>{{ $baris->nama }}</td>
                                    <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $baris->jumlah_riwayat }}</td>
                                    <td>{{ $baris->reviewer_terakhir ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('sc.narasumber.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Sedang / Sudah Diproses</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-parent-diproses" class="form-label">Filter Sub Tema</label>
                    <select id="input-filter-parent-diproses" name="idparent_diproses" class="form-select" onchange="document.getElementById('input-filter-acara-diproses').value = ''; this.form.submit();">
                        <option value="">-- Semua Sub Tema --</option>
                        @foreach($acaraParentOptions as $parent)
                            <option value="{{ $parent->idparent_acara }}" @if((string) $idparentDiproses === (string) $parent->idparent_acara) selected @endif>
                                {{ $parent->parent_tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-acara-diproses" class="form-label">Filter Sesi</label>
                    <select id="input-filter-acara-diproses" name="idacara_diproses" class="form-select" onchange="this.form.submit()" @if(! $idparentDiproses) disabled @endif>
                        <option value="">-- Semua Sesi --</option>
                        @foreach($acaraOptionsDiproses as $acara)
                            <option value="{{ $acara->idacara }}" @if((string) $idacaraDiproses === (string) $acara->idacara) selected @endif>
                                {{ $acara->tema }}
                            </option>
                        @endforeach
                    </select>
                    @if(! $idparentDiproses)
                        <small class="text-muted">Pilih Sub Tema terlebih dahulu.</small>
                    @endif
                </div>

                <p class="mb-3" style="margin:15px">
                    <b>Acara yang dipilih:</b>
                    @if($acaraTerpilihDiproses)
                        @if($acaraTerpilihDiproses->parent_tema)
                            {{ $acaraTerpilihDiproses->parent_tema }} <br>&mdash;
                        @endif
                        {{ $acaraTerpilihDiproses->tema }}
                    @elseif($parentTerpilihDiproses)
                        {{ $parentTerpilihDiproses->parent_tema }}
                    @else
                        Semua Acara
                    @endif
                </p>

                <div class="table-responsive">
                    <table id="table-diproses-narasumber" class="table table-hover table-bordered table-sc-narasumber">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Institusi Asal</th>
                                <th>Status</th>
                                <th>Reviewer Terakhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diproses as $baris)
                                <tr>
                                    <td>{{ $baris->nama }}</td>
                                    <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $baris->reviewer_terakhir ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('sc.narasumber.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>

    <script>
        $(function () {
            var bahasaDataTable = {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ baris',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ baris',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ baris)',
                zeroRecords: 'Data tidak ditemukan',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            };

            var domLayout = "<'dt--top-section'<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>";

            $('#table-antrean-narasumber').DataTable({
                dom: domLayout,
                language: $.extend({}, bahasaDataTable, { emptyTable: 'Tidak ada pengajuan yang menunggu review.' }),
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('#table-diproses-narasumber').DataTable({
                dom: domLayout,
                language: $.extend({}, bahasaDataTable, { emptyTable: 'Belum ada yang diproses.' }),
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });
        });
    </script>
@endsection
