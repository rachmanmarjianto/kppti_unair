@extends('layout.layout')

@section('title', 'Admin Home')

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

        #table-dashboard-institusi tbody tr {
            cursor: pointer;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="#">Admin Home</a></li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Dashboard Institusi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3" style="width: 80%; margin: 15px">
                    <label for="input-filter-jenis-institusi" class="form-label">Filter Jenis Institusi</label>
                    <select id="input-filter-jenis-institusi" class="form-select">
                        <option value="">-- Semua Jenis Institusi --</option>
                        @foreach($institusiDashboard->pluck('nama_jenis_institusi')->unique()->sort()->values() as $jenis)
                            <option value="{{ $jenis }}">{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive">
                    <table id="table-dashboard-institusi" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Institusi</th>
                                <th>Nama Unit Asal</th>
                                <th class="text-center">Narasumber</th>
                                <th class="text-center">Pameran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($institusiDashboard as $baris)
                                <tr data-href="{{ route('admin.home.institusi-ajuan') }}?token={{ $baris->token }}">
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td class="text-center">{{ $baris->jumlah_narasumber }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $baris->ada_pameran ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $baris->ada_pameran ? 'Ya' : 'Tidak' }}
                                        </span>
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
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Quote of the Day</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">

            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>

    <script>
        $(function () {
            var tableDashboardInstitusi = $('#table-dashboard-institusi').DataTable({
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
                    emptyTable: 'Belum ada institusi.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
            });

            $('#table-dashboard-institusi tbody').on('click', 'tr', function () {
                window.location = $(this).data('href');
            });

            $('#input-filter-jenis-institusi').on('change', function () {
                var jenis = $(this).val();
                var regex = jenis ? '^' + $.fn.dataTable.util.escapeRegex(jenis) + '$' : '';

                tableDashboardInstitusi.column(0).search(regex, true, false).draw();
            });
        });
    </script>
@endsection