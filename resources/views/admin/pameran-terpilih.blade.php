@extends('layout.layout')

@section('title', 'Pameran Terpilih')

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

        .dt--top-section,
        .dt--bottom-section {
            padding: 0 15px;
        }

        #modal-log-notif .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-log-notif .text-muted { color: #6c757d !important; }
        #modal-log-notif .table { color: #0e1726 !important; }
        #modal-log-notif .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pameran Terpilih</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Pameran Terpilih</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <form method="GET" action="{{ route('admin.pameran.terpilih') }}" id="form-filter-kluster-terpilih">
                    <div class="mb-3" style="width: 80%; margin: 15px">
                        <label for="input-filter-kluster" class="form-label">Filter Kluster</label>
                        <select id="input-filter-kluster" name="idkluster" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Kluster --</option>
                            @foreach($klusterOptions as $kluster)
                                <option value="{{ $kluster->idkluster_pameran }}" @if((string) $idkluster === (string) $kluster->idkluster_pameran) selected @endif>
                                    Kluster {{ $kluster->nomor_kluster }} &mdash; {{ $kluster->tema_kluster }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="table-pameran-terpilih" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Institusi Asal</th>
                                <th>Tema</th>
                                <th class="text-center">Nilai Final</th>
                                <th class="text-center">Selisih Nilai</th>
                                <th>PIC</th>
                                <th class="text-center">Juml Not</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pameran as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td class="text-center">{{ $baris->nilai_final ?? '-' }}</td>
                                    <td class="text-center @if(($baris->selisih_nilai ?? 0) >= 20) text-danger fw-bold @endif">
                                        {{ $baris->selisih_nilai ?? '-' }}
                                    </td>
                                    <td>{{ $baris->nama_pic ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="cell-log-notif btn-lihat-log-notif" data-idpameran="{{ $baris->idpameran }}" data-tema="{{ $baris->tema }}">{{ $baris->jumlah_log_notif }}</a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-kirim-wa" data-idpameran="{{ $baris->idpameran }}" @disabled(! $baris->no_wa_pic)>
                                            Kirim WA
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: riwayat log notifikasi WA --}}
    <div class="modal fade" id="modal-log-notif" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Notifikasi WA &mdash; <span id="judul-log-notif-tema"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="log-notif-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="table-responsive log-notif-content d-none">
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
                            <tbody id="tbody-log-notif"></tbody>
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
            var kirimWaUrl = '{{ route('admin.pameran.terpilih.kirim-wa') }}';
            var logNotifikasiUrl = '{{ route('admin.pameran.terpilih.log-notifikasi') }}';

            $('#table-pameran-terpilih').DataTable({
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
                    emptyTable: 'Belum ada pengajuan pameran yang Terpilih.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('.btn-kirim-wa').on('click', function () {
                var $btn = $(this);
                var idpameran = $btn.data('idpameran');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Kirim notifikasi WhatsApp ke PIC pengajuan ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...');

                    $.ajax({
                        url: kirimWaUrl,
                        method: 'POST',
                        data: { idpameran: idpameran },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        $('.cell-log-notif[data-idpameran="' + idpameran + '"]').text(res.data.jumlah_log_notif);
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    })
                    .fail(function (xhr) {
                        var resErr = xhr.responseJSON || {};
                        var pesan = resErr.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });

            // ------- Riwayat log notifikasi WA (modal, dimuat lewat AJAX) -------
            var $modalLogNotif = $('#modal-log-notif');
            var $logNotifLoading = $modalLogNotif.find('.log-notif-loading');
            var $logNotifContent = $modalLogNotif.find('.log-notif-content');
            var $tbodyLogNotif = $('#tbody-log-notif');

            function escapeHtml(teks) {
                return $('<div>').text(teks == null ? '' : teks).html();
            }

            $('#table-pameran-terpilih').on('click', '.btn-lihat-log-notif', function () {
                var idpameran = $(this).data('idpameran');

                $('#judul-log-notif-tema').text($(this).data('tema'));
                $logNotifLoading.removeClass('d-none');
                $logNotifContent.addClass('d-none');
                $modalLogNotif.find('.modal-alert').addClass('d-none').text('');
                $tbodyLogNotif.empty();
                $modalLogNotif.modal('show');

                $.ajax({
                    url: logNotifikasiUrl,
                    method: 'GET',
                    data: { idpameran: idpameran },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var logs = res.data.logs;

                    if (logs.length === 0) {
                        $tbodyLogNotif.html('<tr><td colspan="6" class="text-center text-muted">Belum ada notifikasi yang dikirim.</td></tr>');
                    } else {
                        $.each(logs, function (i, log) {
                            $tbodyLogNotif.append(
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

                    $logNotifLoading.addClass('d-none');
                    $logNotifContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $logNotifLoading.addClass('d-none');
                    $modalLogNotif.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
