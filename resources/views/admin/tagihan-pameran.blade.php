@extends('layout.layout')

@section('title', 'Tagihan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <style>
        /* dt-global_style.css mematok .page-link ke kotak 33x33px untuk tombol
           ikon — di halaman ini labelnya berupa teks ("Sebelumnya"/"Berikutnya"),
           jadi tombol sebelum/berikutnya perlu lebar otomatis supaya teksnya
           tidak tumpang tindih (paling kentara saat tabel kosong, karena saat
           itu cuma dua tombol ini yang berdampingan tanpa tombol halaman lain). */
        .dataTables_wrapper .page-item.previous .page-link,
        .dataTables_wrapper .page-item.next .page-link,
        .dataTables_wrapper .page-item.first .page-link,
        .dataTables_wrapper .page-item.last .page-link {
            width: auto;
            white-space: nowrap;
            padding: 0 12px;
        }

        .table-tagihan-pameran {
            width: 95% !important;
            margin: 0 auto;
        }

        #modal-status-bayar .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-status-bayar .text-muted { color: #0e1726 !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tagihan Pameran</li>
@endsection

@php
    $labelStatus = [
        1 => ['Tertagih', 'bg-secondary'],
        2 => ['Terbayar Sebagian', 'bg-info'],
        3 => ['Lunas', 'bg-success'],
        4 => ['Batal', 'bg-danger'],
        5 => ['Expired', 'bg-dark'],
        6 => ['Ditangguhkan', 'bg-warning'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Tagihan Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="alert alert-warning">
                    Integrasi Virtual Account BNI belum aktif. Gunakan tombol "Tandai Lunas" untuk menandai tagihan secara manual sampai integrasi tersedia.
                </div>

                <div class="table-responsive">
                    <table id="table-tagihan-pameran" class="table table-hover table-bordered table-tagihan-pameran">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Tema Pameran</th>
                                <th>Nominal</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td>{{ number_format($baris->tagihan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-status-bayar" data-idtagihan="{{ $baris->idtagihan }}">
                                            Status Bayar
                                        </button>
                                        @if((int) $baris->status !== 3)
                                            <button type="button" class="btn btn-sm btn-outline-success btn-tandai-lunas" data-idtagihan="{{ $baris->idtagihan }}">
                                                Tandai Lunas
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

    {{-- Modal: hasil inquiry billing BNI --}}
    <div class="modal fade" id="modal-status-bayar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Pengecekan Status Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="status-bayar-pesan mb-3"></p>
                    <table class="table table-sm table-bordered mb-0">
                        <tbody class="status-bayar-data"></tbody>
                    </table>
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
            var tandaiLunasUrl = '{{ route('admin.tagihan-pameran.tandai-lunas') }}';
            var cekStatusBayarUrl = '{{ route('admin.tagihan-pameran.cek-status-bayar') }}';
            var statusBerubah = false;
            var $modalStatusBayar = $('#modal-status-bayar');

            $modalStatusBayar.on('hidden.bs.modal', function () {
                if (statusBerubah) {
                    location.reload();
                }
            });

            $('.btn-status-bayar').on('click', function () {
                var $btn = $(this);
                var idtagihan = $btn.data('idtagihan');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: cekStatusBayarUrl,
                    method: 'POST',
                    data: { idtagihan: idtagihan },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    statusBerubah = !!(res.data && res.data.status_berubah);

                    var inquiry = (res.data && res.data.inquiry) || {};
                    var $tbody = $modalStatusBayar.find('.status-bayar-data').empty();

                    if ($.isEmptyObject(inquiry)) {
                        $tbody.append('<tr><td class="text-muted">Tidak ada data yang dikembalikan BNI.</td></tr>');
                    } else {
                        $.each(inquiry, function (key, value) {
                            $('<tr>')
                                .append($('<th>').css('width', '220px').text(key))
                                .append($('<td>').text(value === null || value === '' ? '-' : value))
                                .appendTo($tbody);
                        });
                    }

                    $modalStatusBayar.find('.status-bayar-pesan').text(res.message);
                    $modalStatusBayar.modal('show');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $('.page-alert').removeClass('d-none').text(pesan);
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            $('#table-tagihan-pameran').DataTable({
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
                    emptyTable: 'Belum ada tagihan pameran.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('.btn-tandai-lunas').on('click', function () {
                var $btn = $(this);
                var idtagihan = $btn.data('idtagihan');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Tandai tagihan ini lunas? Pastikan pembayaran sudah benar-benar diterima.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, tandai lunas',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: tandaiLunasUrl,
                        method: 'POST',
                        data: { idtagihan: idtagihan },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        var res = xhr.responseJSON || {};
                        var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        if (xhr.status === 0) {
                            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        $('.page-alert').removeClass('d-none').text(pesan);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
