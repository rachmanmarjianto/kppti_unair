@extends('layout.layout')

@section('title', 'Tapping Card')

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

        .table-tapping-card {
            width: 95% !important;
            margin: 0 auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tapping Card</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Daftar Kontingen</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-3" style="padding-left:30px">
                    <div class="col-md-4 col-sm-6 col-12">
                        <label for="filter-jenis-institusi" class="form-label">Filter Jenis Institusi</label>
                        <select id="filter-jenis-institusi" class="form-select">
                            <option value="">Semua Jenis Institusi</option>
                            @foreach($jenisInstitusiList as $jenis)
                                <option value="{{ $jenis->nama_jenis_institusi }}">{{ $jenis->nama_jenis_institusi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-tapping-card" class="table table-hover table-bordered table-tapping-card">
                        <thead>
                            <tr>
                                <th>Asal Institusi</th>
                                <th>Jenis Institusi</th>
                                <th class="text-center">Jumlah Peserta</th>
                                <th class="text-center">Card</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kontingen as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td class="text-center">{{ $baris->jumlahPeserta }}</td>
                                    <td class="text-center">{{ $baris->jumlahSudahCard }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('petugas-kit.tapping-card.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Detail</a>
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
            var tableTappingCard = $('#table-tapping-card').DataTable({
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
                    emptyTable: 'Belum ada kontingen.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('#filter-jenis-institusi').on('change', function () {
                tableTappingCard.column(1).search(this.value).draw();
            });
        });
    </script>
@endsection
