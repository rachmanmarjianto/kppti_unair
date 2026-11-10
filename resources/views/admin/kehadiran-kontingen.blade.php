@extends('layout.layout')

@section('title', 'Kehadiran Kontingen')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
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

        /* `.widget-content-area` punya background putih/gelap sendiri dari
           tema — gradient box dashboard ini ditimpa langsung di situ
           dengan `!important`, pola yang sama dipakai di
           `admin/mou-ajuan.blade.php`. */
        .stat-box-kehadiran .widget-content-area {
            position: relative;
            overflow: hidden;
            border: none !important;
        }

        .stat-box-kehadiran p { color: rgba(255, 255, 255, 0.85) !important; }
        .stat-box-kehadiran h3 { color: #fff !important; }

        .stat-box-kehadiran .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
        }

        .stat-box-kehadiran-peserta .widget-content-area { background: linear-gradient(135deg, #0ca678, #0a9396) !important; }
        .stat-box-kehadiran-institusi .widget-content-area { background: linear-gradient(135deg, #f72585, #7209b7) !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Kedatangan Kontingen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kehadiran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-sm-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow stat-box-kehadiran stat-box-kehadiran-peserta">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px">
                        <div>
                            <p class="mb-1">Jumlah Peserta Hadir</p>
                            <h3 class="mb-0">{{ $jumlahPesertaHadir }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-sm-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow stat-box-kehadiran stat-box-kehadiran-institusi">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px">
                        <div>
                            <p class="mb-1">Jumlah Institusi Hadir</p>
                            <h3 class="mb-0">{{ $jumlahInstitusiHadir }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Jumlah institusi yang hadir per jenis Institusi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Institusi</th>
                                <th>Jumlah Institusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapJenisInstitusi as $baris)
                                <tr>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td>{{ $baris->jumlah_institusi }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada kontingen yang hadir.</td>
                                </tr>
                            @endforelse
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
                        <h4>Kehadiran Kontingen</h4>
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
                    <table id="table-kehadiran-kontingen" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Institusi</th>
                                <th>Jenis Institusi</th>
                                <th>Jumlah Peserta Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kehadiranList as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td>{{ $baris->jumlah_hadir }}</td>
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
            var tableKehadiran = $('#table-kehadiran-kontingen').DataTable({
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
                    emptyTable: 'Belum ada kontingen yang hadir.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
            });

            $('#filter-jenis-institusi').on('change', function () {
                tableKehadiran.column(1).search(this.value).draw();
            });
        });
    </script>
@endsection
