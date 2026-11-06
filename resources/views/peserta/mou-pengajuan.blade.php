@extends('layout.layout')

@section('title', 'Pengajuan — Pengajuan MoU')

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
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pengajuan</li>
@endsection

@php
    $labelStatusAjuan = [
        1 => ['Ajuan', 'bg-secondary'],
        2 => ['Temu Diskusi', 'bg-info'],
        3 => ['Tunda Lain Waktu', 'bg-warning'],
        4 => ['Terjalin', 'bg-success'],
        5 => ['Dibatalkan', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <h4>Pengajuan MoU</h4>
                    </div>
                    <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.mou.pengajuan.template') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-file-arrow-down me-1"></i> Download Template MoU
                        </a>
                        <a href="{{ route('peserta.mou.pengajuan.tambah') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-1"></i> Ajukan MoU Baru
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($jumlahBelumRespon > 0)
                    <div class="alert alert-warning d-flex justify-content-between align-items-center" id="alert-belum-respon" role="alert" style="cursor: pointer;">
                        <span>
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                            Anda memiliki <strong>{{ $jumlahBelumRespon }}</strong> pengajuan MoU yang belum direspon. Klik untuk melihat.
                        </span>
                    </div>
                @endif

                <div class="row mb-3 align-items-end" style="padding-left:30px">
                    <div class="col-md-4 col-sm-6 col-12">
                        <label for="filter-jenis-institusi" class="form-label">Filter Jenis Institusi</label>
                        <select id="filter-jenis-institusi" class="form-select">
                            <option value="">Semua Jenis Institusi</option>
                            @foreach($jenisInstitusiList as $jenis)
                                <option value="{{ $jenis->nama_jenis_institusi }}">{{ $jenis->nama_jenis_institusi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <label for="filter-pic-mou" class="form-label">Filter PIC MoU</label>
                        <select id="filter-pic-mou" class="form-select">
                            <option value="">Semua PIC MoU</option>
                            @foreach($picMouOptions as $nama)
                                <option value="{{ $nama }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-2 mt-md-0">
                        <button type="button" class="btn btn-outline-secondary" id="btn-reset-filter">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-pengajuan-mou" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>PIC MoU</th>
                                <th>Instansi Mitra</th>
                                <th>PIC Mitra</th>
                                <th>Jenis Institusi</th>
                                <th>Posisi</th>
                                <th>Status Ajuan</th>
                                <th>Waktu dan Lokasi</th>
                                <th class="text-center">Aksi</th>
                                <th>Belum Respon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuanList as $baris)
                                @php
                                    $belumRespon = $baris->posisi === 'Penerima' && (int) $baris->status_ajuan === 1;
                                @endphp
                                <tr>
                                    <td>{{ $baris->nama_pic_sendiri ?? '-' }}@if($baris->no_wa_pic_sendiri) <br><span class="text-muted" style="font-size: 12px;">{{ $baris->no_wa_pic_sendiri }}</span>@endif</td>
                                    <td>{{ $baris->nama_institusi_lawan }}</td>
                                    <td>{{ $baris->nama_pic_lawan ?? '-' }}@if($baris->no_wa_pic_lawan) <br><span class="text-muted" style="font-size: 12px;">{{ $baris->no_wa_pic_lawan }}</span>@endif</td>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td>
                                        <span class="badge {{ $baris->posisi === 'Pengaju' ? 'bg-danger' : 'bg-success' }}">
                                            {{ $baris->posisi }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $labelStatusAjuan[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatusAjuan[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $baris->waktu_lokasi }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('peserta.mou.pengajuan.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                    </td>
                                    <td>{{ $belumRespon ? '1' : '0' }}</td>
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
            var tablePengajuanMou = $('#table-pengajuan-mou').DataTable({
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
                    emptyTable: 'Belum ada pengajuan MoU.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: 7 },
                    { visible: false, searchable: true, targets: 8 },
                ],
            });

            $('#filter-jenis-institusi').on('change', function () {
                tablePengajuanMou.column(3).search(this.value).draw();
            });

            $('#filter-pic-mou').on('change', function () {
                tablePengajuanMou.column(0).search(this.value).draw();
            });

            $('#alert-belum-respon').on('click', function () {
                $('#filter-jenis-institusi').val('');
                $('#filter-pic-mou').val('');
                tablePengajuanMou.column(3).search('');
                tablePengajuanMou.column(0).search('');
                tablePengajuanMou.column(8).search('^1$', true, false).draw();
            });

            $('#btn-reset-filter').on('click', function () {
                $('#filter-jenis-institusi').val('');
                $('#filter-pic-mou').val('');
                tablePengajuanMou.search('').columns().search('').draw();
            });
        });
    </script>
@endsection
