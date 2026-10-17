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
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var kirimWaUrl = '{{ route('admin.pameran.terpilih.kirim-wa') }}';

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
        });
    </script>
@endsection
