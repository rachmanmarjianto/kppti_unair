@extends('layout.layout')

@section('title', 'Narasumber Terpilih')

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
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.narasumber') }}">Narasumber</a></li>
    <li class="breadcrumb-item active" aria-current="page">Terpilih</li>
@endsection

@section('content')
    <form method="GET" action="{{ route('admin.narasumber.terpilih') }}" id="form-filter-acara-narasumber-terpilih">
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4>Narasumber Terpilih</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="mb-3" style="width: 80%; margin:15px">
                        <label for="input-filter-parent-narasumber-terpilih" class="form-label">Filter Sub Tema</label>
                        <select id="input-filter-parent-narasumber-terpilih" name="idparent_acara" class="form-select" onchange="document.getElementById('input-filter-acara-narasumber-terpilih').value = ''; this.form.submit();">
                            <option value="">-- Semua Sub Tema --</option>
                            @foreach($acaraParentOptions as $parent)
                                <option value="{{ $parent->idparent_acara }}" @if((string) $idparentAcara === (string) $parent->idparent_acara) selected @endif>
                                    {{ $parent->parent_tema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" style="width: 80%; margin:15px">
                        <label for="input-filter-acara-narasumber-terpilih" class="form-label">Filter Sesi</label>
                        <select id="input-filter-acara-narasumber-terpilih" name="idacara" class="form-select" onchange="this.form.submit()" @if(! $idparentAcara) disabled @endif>
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
                        <table id="table-narasumber-terpilih" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Institusi Asal</th>
                                    <th class="text-center">File Presentasi</th>
                                    <th class="text-center">Video Presentasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($narasumber as $baris)
                                    <tr>
                                        <td>{{ $baris->nama }}</td>
                                        <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($baris->idfile_presentasi)
                                                <a href="{{ route('admin.narasumber.terpilih.unduh-presentasi') }}?token={{ $baris->token_presentasi }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa-solid fa-download"></i> Unduh
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($baris->url_video)
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-copy-video" data-url="{{ $baris->url_video }}">
                                                    <i class="fa-solid fa-copy"></i> Copy URL
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
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
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>

    <script>
        $(function () {
            $('#table-narasumber-terpilih').DataTable({
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
                    emptyTable: 'Belum ada narasumber dengan status Terpilih.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: [2, 3] }],
            });

            $('#table-narasumber-terpilih').on('click', '.btn-copy-video', function () {
                var url = $(this).data('url');

                function tampilkanBerhasil() {
                    Swal.fire({ icon: 'success', title: 'Disalin', text: 'URL video berhasil disalin.', timer: 1200, showConfirmButton: false });
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(tampilkanBerhasil).catch(function () {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menyalin URL secara otomatis. URL: ' + url });
                    });
                } else {
                    Swal.fire({ icon: 'info', title: 'URL Video', text: url });
                }
            });
        });
    </script>
@endsection
