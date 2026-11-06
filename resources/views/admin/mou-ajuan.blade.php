@extends('layout.layout')

@section('title', 'Ajuan — Pengajuan MoU')

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

        #table-rekap-mou td, #table-rekap-mou th {
            text-align: center;
        }

        #table-rekap-mou td:first-child, #table-rekap-mou th:first-child,
        #table-rekap-mou td:nth-child(2), #table-rekap-mou th:nth-child(2) {
            text-align: left;
        }

        #table-rekap-mou .col-grup-batas {
            border-left: 2px solid var(--bs-border-color, #4c5564);
        }

        .cell-rekap-mou {
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
        }

        #modal-rekap-mou .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-rekap-mou .table { color: #0e1726 !important; }
        #modal-rekap-mou .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }

        /* `.widget-content-area` punya background putih/gelap sendiri dari
           tema (dt-global_style.css, termasuk varian `body.dark` yang
           spesifisitasnya lebih tinggi dari sekadar menata ulang class di
           sini) — gradient jadi tidak kelihatan kalau cuma ditaruh di
           `.statbox` pembungkusnya. Override langsung di `.widget-content-area`
           dengan `!important`, pola yang sama dipakai di proyek ini untuk
           menimpa warna modal terang/gelap. */
        .stat-box-mou .widget-content-area {
            position: relative;
            overflow: hidden;
            border: none !important;
        }

        .stat-box-mou p { color: rgba(255, 255, 255, 0.85) !important; }
        .stat-box-mou h3 { color: #fff !important; }

        .stat-box-mou .stat-icon {
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

        .stat-box-mou-total .widget-content-area { background: linear-gradient(135deg, #4361ee, #3a0ca3) !important; }
        .stat-box-mou-terjalin .widget-content-area { background: linear-gradient(135deg, #0ca678, #0a9396) !important; }
        .stat-box-mou-institusi .widget-content-area { background: linear-gradient(135deg, #f72585, #7209b7) !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ajuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-sm-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow stat-box-mou stat-box-mou-total">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px">
                        <div>
                            <p class="mb-1">Total Pengajuan MoU</p>
                            <h3 class="mb-0">{{ $jumlahTotalMou }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow stat-box-mou stat-box-mou-terjalin">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px">
                        <div>
                            <p class="mb-1">MoU Terjalin</p>
                            <h3 class="mb-0">{{ $jumlahTerjalin }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow stat-box-mou stat-box-mou-institusi">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px">
                        <div>
                            <p class="mb-1">Institusi dengan MoU Terjalin</p>
                            <h3 class="mb-0">{{ $jumlahInstitusiTerjalin }}</h3>
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
                        <h4>Rekap Ajuan MoU per Institusi</h4>
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
                    <table id="table-rekap-mou" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2">Nama Institusi</th>
                                <th rowspan="2">Jenis Institusi</th>
                                <th colspan="5" class="col-grup-batas">Ajuan (sebagai Pengaju)</th>
                                <th colspan="5" class="col-grup-batas">Penerima (sebagai Mitra)</th>
                            </tr>
                            <tr>
                                <th class="col-grup-batas">Total</th>
                                <th>Belum Respon</th>
                                <th>Ditunda</th>
                                <th>Temu Diskusi</th>
                                <th>Terjalin</th>
                                <th class="col-grup-batas">Total</th>
                                <th>Belum Respon</th>
                                <th>Ditunda</th>
                                <th>Temu Diskusi</th>
                                <th>Terjalin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapList as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    @foreach([
                                        ['peran' => 'pengaju', 'status' => 'total', 'nilai' => $baris->ajuan_total],
                                        ['peran' => 'pengaju', 'status' => '1', 'nilai' => $baris->ajuan_belum],
                                        ['peran' => 'pengaju', 'status' => '3', 'nilai' => $baris->ajuan_tunda],
                                        ['peran' => 'pengaju', 'status' => '2', 'nilai' => $baris->ajuan_temu],
                                        ['peran' => 'pengaju', 'status' => '4', 'nilai' => $baris->ajuan_terjalin],
                                        ['peran' => 'mitra', 'status' => 'total', 'nilai' => $baris->permintaan_total],
                                        ['peran' => 'mitra', 'status' => '1', 'nilai' => $baris->permintaan_belum],
                                        ['peran' => 'mitra', 'status' => '3', 'nilai' => $baris->permintaan_tunda],
                                        ['peran' => 'mitra', 'status' => '2', 'nilai' => $baris->permintaan_temu],
                                        ['peran' => 'mitra', 'status' => '4', 'nilai' => $baris->permintaan_terjalin],
                                    ] as $sel)
                                        <td class="{{ $sel['status'] === 'total' ? 'col-grup-batas' : '' }}">
                                            @if($sel['nilai'] > 0)
                                                <a href="javascript:void(0);" class="cell-rekap-mou"
                                                   data-token="{{ $baris->token }}" data-nama="{{ $baris->nama_institusi }}"
                                                   data-peran="{{ $sel['peran'] }}" data-status="{{ $sel['status'] }}">
                                                    {{ $sel['nilai'] }}
                                                </a>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: daftar institusi untuk satu sel rekap --}}
    <div class="modal fade" id="modal-rekap-mou" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul-modal-rekap-mou"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="rekap-mou-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="table-responsive rekap-mou-content d-none">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Institusi</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-rekap-mou"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
            var listUrl = '{{ route('admin.mou.ajuan.list') }}';
            var detailUrl = '{{ route('admin.mou.pengajuan.detail') }}';

            var tableRekapMou = $('#table-rekap-mou').DataTable({
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
                orderCellsTop: true,
                columnDefs: [{ orderable: false, targets: '_all' }],
            });

            $('#filter-jenis-institusi').on('change', function () {
                tableRekapMou.column(1).search(this.value).draw();
            });

            function escapeHtml(teks) {
                return $('<div>').text(teks == null ? '' : teks).html();
            }

            var $modalRekapMou = $('#modal-rekap-mou');
            var $rekapMouLoading = $modalRekapMou.find('.rekap-mou-loading');
            var $rekapMouContent = $modalRekapMou.find('.rekap-mou-content');
            var $tbodyRekapMou = $('#tbody-rekap-mou');

            $('#table-rekap-mou').on('click', '.cell-rekap-mou', function () {
                var $sel = $(this);
                var labelPeran = $sel.data('peran') === 'pengaju' ? 'Ajuan' : 'Permintaan';

                $('#judul-modal-rekap-mou').text(labelPeran + ' — ' + $sel.data('nama'));
                $rekapMouLoading.removeClass('d-none');
                $rekapMouContent.addClass('d-none');
                $modalRekapMou.find('.modal-alert').addClass('d-none').text('');
                $tbodyRekapMou.empty();
                $modalRekapMou.modal('show');

                $.ajax({
                    url: listUrl,
                    method: 'GET',
                    data: { token: $sel.data('token'), peran: $sel.data('peran'), status: $sel.data('status') },
                    dataType: 'json',
                })
                .done(function (res) {
                    var daftar = res.data || [];

                    if (daftar.length === 0) {
                        $tbodyRekapMou.html('<tr><td colspan="3" class="text-center text-muted">Tidak ada data.</td></tr>');
                    } else {
                        $.each(daftar, function (i, baris) {
                            $tbodyRekapMou.append(
                                '<tr>' +
                                '<td>' + escapeHtml(baris.nama_institusi) + '</td>' +
                                '<td>' + escapeHtml(baris.status_label) + '</td>' +
                                '<td class="text-center"><a href="' + detailUrl + '?token=' + encodeURIComponent(baris.token) + '" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Detail</a></td>' +
                                '</tr>'
                            );
                        });
                    }

                    $rekapMouLoading.addClass('d-none');
                    $rekapMouContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var resErr = xhr.responseJSON || {};
                    var pesan = resErr.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';

                    $rekapMouLoading.addClass('d-none');
                    $modalRekapMou.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
