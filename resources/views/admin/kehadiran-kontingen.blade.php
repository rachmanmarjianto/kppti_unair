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

        #table-kehadiran-kontingen tbody tr {
            cursor: pointer;
        }

        #modal-peserta-hadir .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }

        .checkbox-hadir-institusi {
            width: 1.3em;
            height: 1.3em;
        }

        /* `!important` pada opacity perlu ditimpa khusus karena checkbox ini
           disabled (read-only, cuma menampilkan status) — Bootstrap
           memudarkan opacity `.form-check-input:disabled` jadi 0.5 bawaan,
           yang membuat warna biru di bawah ini jadi pudar kalau tidak
           ditimpa juga. */
        .checkbox-hadir-institusi:checked {
            background-color: #4361ee !important;
            border-color: #4361ee !important;
            opacity: 1 !important;
        }
        #modal-peserta-hadir .table { color: #0e1726 !important; }
        #modal-peserta-hadir .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }
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
                                <tr data-token="{{ $baris->token }}">
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

    {{-- Modal: daftar peserta yang hadir milik satu institusi — kolom sama
         seperti tabel peserta di layar "Sedang Dilayani" Petugas Meja
         Registrasi (lihat resources/views/petugas-meja-regis/index.blade.php). --}}
    <div class="modal fade" id="modal-peserta-hadir" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Peserta Hadir — <span class="sel-nama-institusi"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="peserta-hadir-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="peserta-hadir-content d-none">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;" class="text-center">Hadir</th>
                                        <th>Nama Peserta</th>
                                        <th class="text-center">Foto Lengkap</th>
                                        <th class="text-center">Narasumber</th>
                                        <th class="text-center">Booth Crew</th>
                                    </tr>
                                </thead>
                                <tbody id="baris-peserta-hadir"></tbody>
                            </table>
                        </div>

                        <h6 class="mt-4">Riwayat Petugas Meja yang Melayani</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Petugas Meja Registrasi</th>
                                        <th>Waktu Melayani</th>
                                    </tr>
                                </thead>
                                <tbody id="baris-riwayat-petugas"></tbody>
                            </table>
                        </div>
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

            // ------- Modal: daftar peserta hadir per institusi (klik baris tabel) -------
            var pesertaHadirUrl = '{{ route('admin.kedatangan.kehadiran.peserta') }}';
            var $modalPesertaHadir = $('#modal-peserta-hadir');
            var $pesertaHadirLoading = $modalPesertaHadir.find('.peserta-hadir-loading');
            var $pesertaHadirContent = $modalPesertaHadir.find('.peserta-hadir-content');

            $('#table-kehadiran-kontingen tbody').on('click', 'tr', function () {
                var token = $(this).data('token');

                if (!token) {
                    return;
                }

                $pesertaHadirLoading.removeClass('d-none');
                $pesertaHadirContent.addClass('d-none');
                $modalPesertaHadir.find('.modal-alert').addClass('d-none').text('');
                $modalPesertaHadir.find('.sel-nama-institusi').text('');
                $modalPesertaHadir.modal('show');

                $.ajax({
                    url: pesertaHadirUrl + '?token=' + encodeURIComponent(token),
                    method: 'GET',
                    dataType: 'json',
                })
                .done(function (res) {
                    $modalPesertaHadir.find('.sel-nama-institusi').text(res.data.nama_institusi);

                    var $tbody = $('#baris-peserta-hadir').empty();

                    if (res.data.pesertaList.length === 0) {
                        $tbody.html('<tr><td colspan="5" class="text-center text-muted">Belum ada peserta yang hadir.</td></tr>');
                    } else {
                        res.data.pesertaList.forEach(function (peserta) {
                            var $checkbox = $('<input>').attr({ type: 'checkbox', disabled: true }).addClass('form-check-input checkbox-hadir-institusi');
                            $checkbox.prop('checked', !!peserta.hadir);

                            var $fotoLengkap = peserta.fotoLengkap
                                ? $('<span>').text('Ya')
                                : $('<span>').addClass('text-danger').text('Belum');

                            var $centangNarasumber = peserta.isNarasumberDiterima
                                ? $('<i>').addClass('fa-solid fa-check text-success')
                                : $('<span>');

                            var $centangBoothCrew = peserta.isPetugasJaga
                                ? $('<i>').addClass('fa-solid fa-check text-success')
                                : $('<span>');

                            $('<tr>')
                                .append($('<td>').addClass('text-center').append($checkbox))
                                .append($('<td>').text(peserta.nama))
                                .append($('<td>').addClass('text-center').append($fotoLengkap))
                                .append($('<td>').addClass('text-center').append($centangNarasumber))
                                .append($('<td>').addClass('text-center').append($centangBoothCrew))
                                .appendTo($tbody);
                        });
                    }

                    var $tbodyRiwayat = $('#baris-riwayat-petugas').empty();

                    if (res.data.riwayatPetugas.length === 0) {
                        $tbodyRiwayat.html('<tr><td colspan="2" class="text-center text-muted">Belum ada riwayat petugas yang melayani.</td></tr>');
                    } else {
                        res.data.riwayatPetugas.forEach(function (riwayat) {
                            $('<tr>')
                                .append($('<td>').text(riwayat.nama))
                                .append($('<td>').text(riwayat.created_at))
                                .appendTo($tbodyRiwayat);
                        });
                    }

                    $pesertaHadirLoading.addClass('d-none');
                    $pesertaHadirContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $pesertaHadirLoading.addClass('d-none');
                    $modalPesertaHadir.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
