@extends('layout.layout')

@section('title', 'Narasumber')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
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

        #modal-log-wa .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-log-wa .text-muted { color: #6c757d !important; }
        #modal-log-wa .table { color: #0e1726 !important; }
        #modal-log-wa .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }
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
                                <th class="text-center">Log WA</th>
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
                                        <a href="javascript:void(0);" class="cell-log-wa btn-lihat-log-wa" data-idnarasumber="{{ $baris->idnarasumber }}" data-nama="{{ $baris->nama }}">{{ $baris->jumlah_log_wa }}</a>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{ route('admin.narasumber.detail') }}?token={{ $baris->token }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                        @if(in_array($baris->status_ajuan, ['5', '8'], true))
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-kirim-notif" data-idnarasumber="{{ $baris->idnarasumber }}">
                                                <span class="btn-label"><i class="fa-solid fa-paper-plane"></i> Kirim Notif</span>
                                            </button>
                                        @endif
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

    {{-- Modal: riwayat log notifikasi WA --}}
    <div class="modal fade" id="modal-log-wa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Notifikasi WA &mdash; <span id="judul-log-wa-nama"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="log-wa-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="table-responsive log-wa-content d-none">
                        <table class="table table-sm table-bordered" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pesan 1</th>
                                    <th>Pesan 2</th>
                                    <th>Pesan 3</th>
                                    <th>No. WA</th>
                                    <th>Dikirim Oleh</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-log-wa"></tbody>
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
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var kirimNotifikasiUrl = '{{ route('admin.narasumber.kirim-notifikasi') }}';
            var logNotifikasiUrl = '{{ route('admin.narasumber.log-notifikasi') }}';
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

            $('#table-narasumber').on('click', '.btn-kirim-notif', function () {
                var $btn = $(this);
                var idnarasumber = $btn.data('idnarasumber');
                var teksAwal = $btn.html();

                $btn.prop('disabled', true).html('<span class="btn-label"><span class="spinner-border spinner-border-sm me-1"></span>Proses...</span>');

                $.ajax({
                    url: kirimNotifikasiUrl,
                    method: 'POST',
                    data: { idnarasumber: idnarasumber },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $('.cell-log-wa[data-idnarasumber="' + idnarasumber + '"]').text(res.data.jumlah_log_wa);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            // ------- Riwayat log notifikasi WA (modal, dimuat lewat AJAX) -------
            var $modalLogWa = $('#modal-log-wa');
            var $logWaLoading = $modalLogWa.find('.log-wa-loading');
            var $logWaContent = $modalLogWa.find('.log-wa-content');
            var $tbodyLogWa = $('#tbody-log-wa');

            function escapeHtml(teks) {
                return $('<div>').text(teks == null ? '' : teks).html();
            }

            $('#table-narasumber').on('click', '.btn-lihat-log-wa', function () {
                var idnarasumber = $(this).data('idnarasumber');

                $('#judul-log-wa-nama').text($(this).data('nama'));
                $logWaLoading.removeClass('d-none');
                $logWaContent.addClass('d-none');
                $modalLogWa.find('.modal-alert').addClass('d-none').text('');
                $tbodyLogWa.empty();
                $modalLogWa.modal('show');

                $.ajax({
                    url: logNotifikasiUrl,
                    method: 'GET',
                    data: { idnarasumber: idnarasumber },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var logs = res.data.logs;

                    if (logs.length === 0) {
                        $tbodyLogWa.html('<tr><td colspan="6" class="text-center text-muted">Belum ada notifikasi yang dikirim.</td></tr>');
                    } else {
                        $.each(logs, function (i, log) {
                            $tbodyLogWa.append(
                                '<tr>' +
                                '<td>' + escapeHtml(log.created_at) + '</td>' +
                                '<td>' + escapeHtml(log.pesan_1) + '</td>' +
                                '<td>' + escapeHtml(log.pesan_2) + '</td>' +
                                '<td>' + escapeHtml(log.pesan_3) + '</td>' +
                                '<td>' + escapeHtml(log.no_wa) + '</td>' +
                                '<td>' + escapeHtml(log.nama_pengirim) + '</td>' +
                                '</tr>'
                            );
                        });
                    }

                    $logWaLoading.addClass('d-none');
                    $logWaContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $logWaLoading.addClass('d-none');
                    $modalLogWa.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
