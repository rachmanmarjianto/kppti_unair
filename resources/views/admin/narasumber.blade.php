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
@endphp

@section('content')
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
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>

    <script>
        $(function () {
            $('#table-narasumber').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
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
