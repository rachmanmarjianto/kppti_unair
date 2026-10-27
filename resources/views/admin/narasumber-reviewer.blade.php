@extends('layout.layout')

@section('title', 'Set Reviewer Narasumber')

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

        .table-narasumber-reviewer {
            width: 100% !important;
            max-width: 100%;
        }

        .table-narasumber-reviewer td {
            white-space: normal;
            word-break: break-word;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.narasumber') }}">Narasumber</a></li>
    <li class="breadcrumb-item active" aria-current="page">Set Reviewer</li>
@endsection

@php
    $labelStatus = [
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
    ];

    // Dipakai sebagai baris keterangan di dalam file Excel yang diunduh
    // (lewat opsi `title` tombol excelHtml5), sama seperti admin.narasumber.
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
                        <h4>Dashboard</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <ul class="list-group">
                    @forelse($dashboardReviewer as $baris)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $baris->nama }}
                            <span class="badge bg-primary rounded-pill">{{ $baris->jumlah }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada SC yang terdaftar.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.narasumber.reviewer') }}" id="form-filter-acara-narasumber-reviewer">
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Set Reviewer Narasumber</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-parent-narasumber-reviewer" class="form-label">Filter Sub Tema</label>
                    <select id="input-filter-parent-narasumber-reviewer" name="idparent_acara" class="form-select" onchange="document.getElementById('input-filter-acara-narasumber-reviewer').value = ''; this.form.submit();">
                        <option value="">-- Semua Sub Tema --</option>
                        @foreach($acaraParentOptions as $parent)
                            <option value="{{ $parent->idparent_acara }}" @if((string) $idparentAcara === (string) $parent->idparent_acara) selected @endif>
                                {{ $parent->parent_tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" style="width: 80%; margin:15px">
                    <label for="input-filter-acara-narasumber-reviewer" class="form-label">Filter Sesi</label>
                    <select id="input-filter-acara-narasumber-reviewer" name="idacara" class="form-select" onchange="this.form.submit()" @if(! $idparentAcara) disabled @endif>
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

                <div class="form-check mb-3" style="margin:15px">
                    <input type="checkbox" class="form-check-input" id="input-sertakan-subtema" checked>
                    <label class="form-check-label" for="input-sertakan-subtema">Sertakan subtema</label>
                </div>

                <div class="form-check mb-3" style="margin:15px">
                    <input type="checkbox" class="form-check-input" id="input-filter-belum-reviewer">
                    <label class="form-check-label" for="input-filter-belum-reviewer">Tampilkan hanya yang belum ada reviewernya</label>
                </div>

                <div class="table-responsive">
                    <table id="table-narasumber-reviewer" class="table table-hover table-bordered table-narasumber-reviewer">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Institusi Asal</th>
                                <th>Subtema</th>
                                <th>Status</th>
                                <th>Reviewer SC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($narasumber as $baris)
                                <tr>
                                    <td>{{ $baris->nama }}</td>
                                    <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                    <td>{{ $baris->subtema ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <select class="form-select select-set-reviewer" data-idnarasumber="{{ $baris->idnarasumber }}">
                                            <option value="">-- Belum Ditugaskan --</option>
                                            @foreach($scOptions as $sc)
                                                <option value="{{ $sc->idpengguna }}" @selected($baris->reviewer_sc == $sc->idpengguna)>
                                                    {{ $sc->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted label-proses-reviewer d-none">Proses...</small>
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
            var setReviewerUrl = '{{ route('admin.narasumber.reviewer.set') }}';
            var keteranganFilterExcel = {!! json_encode($keteranganFilterExcel) !!};

            var tableNarasumberReviewer = $('#table-narasumber-reviewer').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex align-items-center gap-2'Bl><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            className: 'btn btn-outline-success btn-sm',
                            text: '<i class="fa-solid fa-file-excel me-1"></i>Excel',
                            filename: 'List Set Reviewer Narasumber',
                            title: keteranganFilterExcel,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4],
                                format: {
                                    body: function (data, row, column, node) {
                                        if (column === 4) {
                                            return $(node).find('select option:selected').text().trim();
                                        }

                                        return data;
                                    },
                                },
                            },
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
                    emptyTable: 'Belum ada pengajuan narasumber yang bisa dipetakan reviewer-nya.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
            });

            $('#input-sertakan-subtema').on('change', function () {
                tableNarasumberReviewer.column(2).visible(this.checked);
            });

            $.fn.dataTable.ext.search.push(function (settings, searchData, index, rowData, counter) {
                if (settings.nTable.id !== 'table-narasumber-reviewer') {
                    return true;
                }

                if (! $('#input-filter-belum-reviewer').is(':checked')) {
                    return true;
                }

                var row = tableNarasumberReviewer.row(index).node();

                return $(row).find('.select-set-reviewer').val() === '';
            });

            $('#input-filter-belum-reviewer').on('change', function () {
                tableNarasumberReviewer.draw();
            });

            $('#table-narasumber-reviewer').on('change', '.select-set-reviewer', function () {
                var $select = $(this);
                var $labelProses = $select.siblings('.label-proses-reviewer');
                var idnarasumber = $select.data('idnarasumber');
                var idpengguna = $select.val();

                $select.prop('disabled', true);
                $labelProses.removeClass('d-none');

                $.ajax({
                    url: setReviewerUrl,
                    method: 'POST',
                    data: { idnarasumber: idnarasumber, idpengguna: idpengguna },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $labelProses.addClass('d-none');
                    tableNarasumberReviewer.draw(false);
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
                })
                .fail(function (xhr) {
                    $labelProses.addClass('d-none');

                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: pesan }).then(function () {
                        location.reload();
                    });
                })
                .always(function () {
                    $select.prop('disabled', false);
                });
            });
        });
    </script>
@endsection
