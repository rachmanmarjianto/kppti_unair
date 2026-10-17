@extends('layout.layout')

@section('title', 'Pameran')

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
    <li class="breadcrumb-item active" aria-current="page">Pameran</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Pengajuan Pameran &mdash; Proses Seleksi</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="GET" action="{{ route('master-sc.pameran') }}" id="form-filter-kluster-master-sc">
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
                    <table id="table-master-sc-pameran" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Institusi Asal</th>
                                <th>Tema</th>
                                <th class="text-center">Nilai Final</th>
                                <th class="text-center">Selisih Nilai</th>
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
                                    <td class="text-center">
                                        @if($baris->status_ajuan === '9')
                                            <span class="text-success fw-bold">Terpilih</span>
                                        @elseif($baris->status_ajuan === '8')
                                            <span class="text-danger fw-bold">Tidak Terpilih</span>
                                        @else
                                            <button type="button" class="btn btn-sm btn-success btn-putuskan" data-idpameran="{{ $baris->idpameran }}" data-keputusan="9">Terpilih</button>
                                            <button type="button" class="btn btn-sm btn-danger btn-putuskan" data-idpameran="{{ $baris->idpameran }}" data-keputusan="8">Tidak Terpilih</button>
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

            $('#table-master-sc-pameran').DataTable({
                dom: domLayout,
                language: $.extend({}, bahasaDataTable, { emptyTable: 'Tidak ada pengajuan yang menunggu keputusan.' }),
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            var csrfToken = '{{ csrf_token() }}';
            var putuskanUrl = '{{ route('master-sc.pameran.putuskan') }}';

            function tampilkanError(xhr) {
                var pesan = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan, silakan coba lagi.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
            }

            $('.btn-putuskan').on('click', function () {
                var $btn = $(this);
                var idpameran = $btn.data('idpameran');
                var keputusan = $btn.data('keputusan');
                var labelKonfirmasi = keputusan === 9 || keputusan === '9' ? 'Terpilih' : 'Tidak Terpilih';

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
                            idpameran: idpameran,
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
