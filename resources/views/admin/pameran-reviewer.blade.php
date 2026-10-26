@extends('layout.layout')

@section('title', 'Reviewer Pameran')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
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

        .table-pameran-reviewer {
            width: 95% !important;
            margin: 0 auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reviewer Pameran</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Reviewer Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <form method="GET" action="{{ route('admin.pameran.reviewer') }}" id="form-filter-kluster-reviewer">
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

                <div class="form-check mb-3" style="margin:15px">
                    <input type="checkbox" class="form-check-input" id="input-sertakan-tema" checked>
                    <label class="form-check-label" for="input-sertakan-tema">Sertakan tema</label>
                </div>

                <div class="table-responsive">
                    <table id="table-pameran-reviewer" class="table table-hover table-bordered table-pameran-reviewer">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Tema</th>
                                <th>Reviewer 1</th>
                                <th>Reviewer 2</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pameran as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td>{{ $baris->reviewer->get(1)->nama ?? '-' }}</td>
                                    <td>{{ $baris->reviewer->get(2)->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-reviewer-{{ $baris->idpameran }}">
                                            Kelola Reviewer
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

    {{-- Modal: kelola reviewer, satu per baris pameran --}}
    @foreach($pameran as $baris)
        <div class="modal fade" id="modal-reviewer-{{ $baris->idpameran }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reviewer Pameran: {{ $baris->nama_institusi }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        @for($slot = 1; $slot <= 2; $slot++)
                            @php $reviewer = $baris->reviewer->get($slot); @endphp
                            <label class="form-label fw-bold">Reviewer {{ $slot }}</label>

                            <div class="d-flex align-items-center gap-2 border rounded p-2 mb-3 tampilan-reviewer-terisi @unless($reviewer) d-none @endunless">
                                <span class="flex-grow-1">{{ $reviewer->nama ?? '' }}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-ganti-reviewer">Ganti</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-reviewer" data-idreviewer-pameran="{{ $reviewer->idreviewer_pameran ?? '' }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <form class="d-flex gap-2 mb-3 form-tambah-reviewer @if($reviewer) d-none @endif"
                                  data-idpameran="{{ $baris->idpameran }}"
                                  data-reviewer-ke="{{ $slot }}"
                                  data-idreviewer-pameran-lama="{{ $reviewer->idreviewer_pameran ?? '' }}">
                                <select name="idpengguna" class="form-control" required>
                                    <option value="">-- Pilih SC --</option>
                                    @foreach($scOptions->whereNotIn('idpengguna', $baris->reviewer->pluck('idpengguna')) as $opsi)
                                        <option value="{{ $opsi->idpengguna }}">{{ $opsi->nama }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary text-nowrap d-flex align-items-center justify-content-center">
                                    Simpan
                                </button>
                            </form>
                        @endfor
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var tambahReviewerUrl = '{{ route('admin.pameran.reviewer.tambah') }}';
            var hapusReviewerUrl = '{{ route('admin.pameran.reviewer.hapus') }}';
            var namaFileExcel = {!! json_encode($klusterTerpilih ? 'Kluster '.$klusterTerpilih->nomor_kluster.' - '.$klusterTerpilih->tema_kluster : 'Semua Kluster') !!};

            var tablePameranReviewer = $('#table-pameran-reviewer').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            className: 'btn btn-outline-success btn-sm',
                            text: '<i class="fa-solid fa-file-excel me-1"></i>Excel',
                            filename: namaFileExcel,
                            exportOptions: { columns: [0, 1, 2, 3] },
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
                    emptyTable: 'Belum ada pengajuan pameran yang bisa dipetakan reviewer-nya.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('#input-sertakan-tema').on('change', function () {
                tablePameranReviewer.column(1).visible(this.checked);
            });

            function tampilkanError($form, xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $form.closest('.modal-body').find('.modal-alert').removeClass('d-none').text(pesan);
            }

            $('.btn-ganti-reviewer').on('click', function () {
                var $tampilan = $(this).closest('.tampilan-reviewer-terisi');
                $tampilan.addClass('d-none');
                $tampilan.next('.form-tambah-reviewer').removeClass('d-none');
            });

            $('.btn-hapus-reviewer').on('click', function () {
                var $btn = $(this);
                var idreviewerPameran = $btn.data('idreviewer-pameran');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus reviewer ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $btn.prop('disabled', true);

                    $.ajax({
                        url: hapusReviewerUrl,
                        method: 'POST',
                        data: { idreviewer_pameran: idreviewerPameran },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanError($btn, xhr);
                        $btn.prop('disabled', false);
                    });
                });
            });

            $('.form-tambah-reviewer').on('submit', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $form.closest('.modal-body').find('.modal-alert').addClass('d-none').text('');

                var idpameran = $form.data('idpameran');
                var reviewerKe = $form.data('reviewer-ke');
                var idreviewerPameranLama = $form.data('idreviewer-pameran-lama');
                var idpengguna = $form.find('select[name="idpengguna"]').val();

                var hapusLama = idreviewerPameranLama
                    ? $.ajax({
                        url: hapusReviewerUrl,
                        method: 'POST',
                        data: { idreviewer_pameran: idreviewerPameranLama },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    : $.Deferred().resolve().promise();

                hapusLama
                    .then(function () {
                        return $.ajax({
                            url: tambahReviewerUrl,
                            method: 'POST',
                            data: { idpameran: idpameran, idpengguna: idpengguna, reviewer_ke: reviewerKe },
                            dataType: 'json',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                        });
                    })
                    .then(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanError($form, xhr);
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
            });
        });
    </script>
@endsection
