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

        .dt--top-section,
        .dt--bottom-section {
            padding: 0 15px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Narasumber</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Pengajuan Narasumber &mdash; Proses Seleksi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="GET" action="{{ route('master-sc.narasumber') }}" id="form-filter-acara-master-sc">
                    <div class="mb-3" style="width: 80%; margin: 15px">
                        <label for="input-filter-parent" class="form-label">Filter Sub Tema</label>
                        <select id="input-filter-parent" name="idparent" class="form-select" onchange="document.getElementById('input-filter-acara').value = ''; this.form.submit();">
                            <option value="">-- Semua Sub Tema --</option>
                            @foreach($acaraParentOptions as $parent)
                                <option value="{{ $parent->idparent_acara }}" @if((string) $idparent === (string) $parent->idparent_acara) selected @endif>
                                    {{ $parent->parent_tema }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" style="width: 80%; margin: 15px">
                        <label for="input-filter-acara" class="form-label">Filter Sesi</label>
                        <select id="input-filter-acara" name="idacara" class="form-select" onchange="this.form.submit()" @if(! $idparent) disabled @endif>
                            <option value="">-- Semua Sesi --</option>
                            @foreach($acaraOptionsAnak as $acara)
                                <option value="{{ $acara->idacara }}" @if((string) $idacara === (string) $acara->idacara) selected @endif>
                                    {{ $acara->tema }}
                                </option>
                            @endforeach
                        </select>
                        @if(! $idparent)
                            <small class="text-muted">Pilih Sub Tema terlebih dahulu.</small>
                        @endif
                    </div>
                </form>

                <p class="mb-3" style="margin: 15px">
                    <b>Acara yang dipilih:</b><br>
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
                    <table id="table-master-sc-narasumber" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Pengaju</th>
                                <th>Institusi Asal</th>
                                <th class="text-center">Nilai Akhir</th>
                                <th>Catatan SC</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($narasumber as $baris)
                                <tr>
                                    <td>{{ $baris->nama }}</td>
                                    <td>{{ $baris->nama_institusi ?? '-' }}</td>
                                    <td class="text-center">{{ $baris->nilai_akhir ?? '-' }}</td>
                                    <td>{{ $baris->catatan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($baris->status_ajuan === '5')
                                            <span class="text-success fw-bold">Diterima</span>
                                        @elseif($baris->status_ajuan === '8')
                                            <span class="text-danger fw-bold">Tidak Terpilih</span>
                                        @else
                                            <button type="button" class="btn btn-sm btn-success btn-putuskan" data-idreview="{{ $baris->idreview_narasumber }}" data-keputusan="5">Diterima</button>
                                            <button type="button" class="btn btn-sm btn-danger btn-putuskan" data-idreview="{{ $baris->idreview_narasumber }}" data-keputusan="8">Tidak Terpilih</button>
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
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var bahasaDataTable = {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ baris',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ baris',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ baris)',
                zeroRecords: 'Data tidak ditemukan',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            };

            var domLayout = "<'dt--top-section'<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>";

            $('#table-master-sc-narasumber').DataTable({
                dom: domLayout,
                language: $.extend({}, bahasaDataTable, { emptyTable: 'Tidak ada pengajuan yang menunggu keputusan.' }),
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            var csrfToken = '{{ csrf_token() }}';
            var putuskanUrl = '{{ route('master-sc.narasumber.putuskan') }}';

            function tampilkanError(xhr) {
                var pesan = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan, silakan coba lagi.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
            }

            $('.btn-putuskan').on('click', function () {
                var $btn = $(this);
                var idreviewNarasumber = $btn.data('idreview');
                var keputusan = $btn.data('keputusan');
                var labelKonfirmasi = keputusan === 5 || keputusan === '5' ? 'Diterima' : 'Tidak Terpilih';

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Putuskan pengajuan ini sebagai ' + labelKonfirmasi + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, putuskan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var $baris = $btn.closest('tr');
                    var teksAwal = $btn.html();
                    $baris.find('.btn-putuskan').prop('disabled', true);
                    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                    $.ajax({
                        url: putuskanUrl,
                        method: 'POST',
                        data: {
                            idreview_narasumber: idreviewNarasumber,
                            keputusan: keputusan,
                        },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanError(xhr);
                        $baris.find('.btn-putuskan').prop('disabled', false);
                        $btn.html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
