@extends('layout.layout')

@section('title', 'Narasumber')

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

        .table-narasumber {
            width: 95% !important;
            margin: 0 auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Narasumber</li>
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

    // Dipakai sebagai baris keterangan di dalam file Excel yang diunduh
    // (lewat opsi `title` tombol excelHtml5), supaya pembaca file tahu
    // lingkup data tanpa harus menebak dari nama filenya.
    if ($acaraTerpilih) {
        $keteranganFilterExcel = 'Sub Tema: '.($acaraTerpilih->parent_tema ?? '-').' — Sesi: '.$acaraTerpilih->tema;
    } elseif ($parentTerpilih) {
        $keteranganFilterExcel = 'Sub Tema: '.$parentTerpilih->parent_tema.' — Sesi: Semua Sesi';
    } else {
        $keteranganFilterExcel = 'Sub Tema: Semua Sub Tema — Sesi: Semua Sesi';
    }
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Dashboard Pengajuan per Sesi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @forelse($dashboardSesi as $subtema => $sesiList)
                    <div class="accordion mb-2" id="accordion-dashboard-{{ $loop->index }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dashboard-sesi-{{ $loop->index }}">
                                    {{ $subtema }}
                                </button>
                            </h2>
                            <div id="dashboard-sesi-{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#accordion-dashboard-{{ $loop->index }}">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Sesi</th>
                                                    <th class="text-center">Jumlah Pengajuan</th>
                                                    <th class="text-center">Proses Seleksi</th>
                                                    <th class="text-center">Lolos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sesiList as $baris)
                                                    <tr>
                                                        <td>{{ $baris->tema }}</td>
                                                        <td class="text-center">{{ $baris->jumlah_pengajuan }}</td>
                                                        <td class="text-center">{{ $baris->jumlah_proses_seleksi }}</td>
                                                        <td class="text-center">{{ $baris->jumlah_lolos }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada sesi yang perlu narasumber.</p>
                @endforelse
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.narasumber') }}" id="form-filter-acara-narasumber">
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Narasumber</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-parent-narasumber" class="form-label">Filter Sub Tema</label>
                    <select id="input-filter-parent-narasumber" name="idparent_acara" class="form-select" onchange="document.getElementById('input-filter-acara-narasumber').value = ''; this.form.submit();">
                        <option value="">-- Semua Sub Tema --</option>
                        @foreach($acaraParentOptions as $parent)
                            <option value="{{ $parent->idparent_acara }}" @if((string) $idparentAcara === (string) $parent->idparent_acara) selected @endif>
                                {{ $parent->parent_tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-acara-narasumber" class="form-label">Filter Sesi</label>
                    <select id="input-filter-acara-narasumber" name="idacara" class="form-select" onchange="this.form.submit()" @if(! $idparentAcara) disabled @endif>
                        <option value="">-- Semua Sesi --</option>
                        @foreach($acaraOptionsFilter as $acara)
                            <option value="{{ $acara->idacara }}" @if((string) $idacara === (string) $acara->idacara) selected @endif>
                                {{ $acara->tema }}
                            </option>
                        @endforeach
                    </select>
                    @if(! $idparentAcara)
                        <small class="text-muted">Pilih Sub Tema terlebih dahulu.</small>
                    @endif
                </div>

                <p class="mb-3" style="margin:15px">
                    <b>Acara yang dipilih:</b>
                    @if($acaraTerpilih)
                        @if($acaraTerpilih->parent_tema)
                            {{ $acaraTerpilih->parent_tema }} <br>&mdash;
                        @endif
                        {{ $acaraTerpilih->tema }}
                    @elseif($parentTerpilih)
                        {{ $parentTerpilih->parent_tema }}
                    @else
                        Semua Acara
                    @endif
                </p>

                <div class="table-responsive">
                    <table id="table-narasumber" class="table table-hover table-bordered table-narasumber">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Institusi Asal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($narasumber as $baris)
                                <tr>
                                    <td>{{ $baris->nama }}</td>
                                    <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
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
            </div>
        </div>
    </div>
    </form>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>

    <script>
        $(function () {
            var keteranganFilterExcel = {!! json_encode($keteranganFilterExcel) !!};

            $('#table-narasumber').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex align-items-center gap-2'Bl><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            className: 'btn btn-outline-success btn-sm',
                            text: '<i class="fa-solid fa-file-excel me-1"></i>Excel',
                            filename: 'List Pengajuan Narasumber',
                            title: keteranganFilterExcel,
                            exportOptions: { columns: [0, 1, 2] },
                        },
                    ],
                },
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ baris',
                    info: 'Menampilkan _START_ - _END_ dari _TOTAL_ baris',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(disaring dari _MAX_ baris)',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada pengajuan narasumber.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });
        });
    </script>
@endsection
