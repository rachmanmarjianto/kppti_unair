@extends('layout.layout')

@section('title', 'List Peserta — Pengajuan MoU')

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

        .row-institusi-mou {
            cursor: pointer;
        }

        #modal-list-peserta-mou .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-list-peserta-mou .text-muted { color: #6c757d !important; }
        #modal-list-peserta-mou .table { color: #0e1726 !important; }
        #modal-list-peserta-mou .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">List Peserta</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>List Peserta per Institusi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-3">
                    <div class="col-md-4 col-sm-6 col-12" style="padding-left:30px">
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
                    <table id="table-mou-institusi" class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Institusi Asal</th>
                                <th>Jenis Institusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($institusiList as $institusi)
                                <tr class="row-institusi-mou" data-token="{{ $institusi->token }}" data-nama="{{ $institusi->nama_institusi }}">
                                    <td>{{ $institusi->nama_institusi }}</td>
                                    <td>{{ $institusi->nama_jenis_institusi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: daftar nama peserta per institusi --}}
    <div class="modal fade" id="modal-list-peserta-mou" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Peserta &mdash; <span id="judul-institusi-mou"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="peserta-mou-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="table-responsive peserta-mou-content d-none">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">No.</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-peserta-mou"></tbody>
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
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var pesertaInstitusiUrl = '{{ route('peserta.mou.list-peserta.peserta') }}';

            var tableMouInstitusi = $('#table-mou-institusi').DataTable({
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
                    emptyTable: 'Belum ada institusi dengan peserta terdaftar.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
            });

            $('#filter-jenis-institusi').on('change', function () {
                tableMouInstitusi.column(1).search(this.value).draw();
            });

            // ------- Daftar peserta per institusi (modal, dimuat lewat AJAX) -------
            var $modalPesertaMou = $('#modal-list-peserta-mou');
            var $pesertaMouLoading = $modalPesertaMou.find('.peserta-mou-loading');
            var $pesertaMouContent = $modalPesertaMou.find('.peserta-mou-content');
            var $tbodyPesertaMou = $('#tbody-peserta-mou');

            function escapeHtml(teks) {
                return $('<div>').text(teks == null ? '' : teks).html();
            }

            $('#table-mou-institusi').on('click', '.row-institusi-mou', function () {
                var token = $(this).data('token');

                $('#judul-institusi-mou').text($(this).data('nama'));
                $pesertaMouLoading.removeClass('d-none');
                $pesertaMouContent.addClass('d-none');
                $modalPesertaMou.find('.modal-alert').addClass('d-none').text('');
                $tbodyPesertaMou.empty();
                $modalPesertaMou.modal('show');

                $.ajax({
                    url: pesertaInstitusiUrl,
                    method: 'GET',
                    data: { token: token },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var pesertaList = res.data.peserta;

                    if (pesertaList.length === 0) {
                        $tbodyPesertaMou.html('<tr><td colspan="2" class="text-center text-muted">Belum ada peserta terdaftar.</td></tr>');
                    } else {
                        $.each(pesertaList, function (i, peserta) {
                            $tbodyPesertaMou.append(
                                '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + escapeHtml(peserta.nama) + '</td>' +
                                '</tr>'
                            );
                        });
                    }

                    $pesertaMouLoading.addClass('d-none');
                    $pesertaMouContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var resErr = xhr.responseJSON || {};
                    var pesan = resErr.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';

                    $pesertaMouLoading.addClass('d-none');
                    $modalPesertaMou.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
