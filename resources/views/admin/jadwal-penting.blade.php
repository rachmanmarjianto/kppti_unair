@extends('layout.layout')

@section('title', 'Jadwal Penting')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Jadwal Penting</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Jadwal Penting</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Jadwal</th>
                                <th>Mode</th>
                                <th>Buka</th>
                                <th>Tutup</th>
                                <th>Status Saat Ini</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalList as $jadwal)
                                @php
                                    $sekarang = now();
                                    $terbuka = $jadwal->mode === '2'
                                        || (
                                            (! $jadwal->timestamp_buka || $sekarang->gte($jadwal->timestamp_buka))
                                            && (! $jadwal->timestamp_tutup || $sekarang->lte($jadwal->timestamp_tutup))
                                        );
                                @endphp
                                <tr>
                                    <td>{{ $jadwal->nama_jadwal ?? '-' }}</td>
                                    <td>
                                        @if($jadwal->mode === '2')
                                            <span class="badge bg-info">Open (selalu terbuka)</span>
                                        @else
                                            <span class="badge bg-secondary">Auto (ikuti jadwal)</span>
                                        @endif
                                    </td>
                                    <td>{{ $jadwal->timestamp_buka ? \Carbon\Carbon::parse($jadwal->timestamp_buka)->translatedFormat('d M Y, H:i') : '-' }}</td>
                                    <td>{{ $jadwal->timestamp_tutup ? \Carbon\Carbon::parse($jadwal->timestamp_tutup)->translatedFormat('d M Y, H:i') : '-' }}</td>
                                    <td>
                                        @if($terbuka)
                                            <span class="badge bg-success">Terbuka</span>
                                        @else
                                            <span class="badge bg-danger">Tertutup</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning btn-edit-jadwal"
                                           title="Edit"
                                           data-idjadwal-penting="{{ $jadwal->idjadwal_penting }}"
                                           data-nama-jadwal="{{ $jadwal->nama_jadwal }}"
                                           data-mode="{{ $jadwal->mode }}"
                                           data-timestamp-buka="{{ $jadwal->timestamp_buka ? \Carbon\Carbon::parse($jadwal->timestamp_buka)->format('Y-m-d\TH:i') : '' }}"
                                           data-timestamp-tutup="{{ $jadwal->timestamp_tutup ? \Carbon\Carbon::parse($jadwal->timestamp_tutup)->format('Y-m-d\TH:i') : '' }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: edit jadwal penting --}}
    <div class="modal fade" id="modal-jadwal-penting" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-jadwal-penting">
                    <input type="hidden" name="idjadwal_penting" id="input-idjadwal-penting">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jadwal: <span id="judul-nama-jadwal"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label d-block">Mode</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="mode-auto" value="1" checked>
                                <label class="form-check-label" for="mode-auto">Auto (ikuti jadwal buka/tutup)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="mode-open" value="2">
                                <label class="form-check-label" for="mode-open">Open (selalu terbuka)</label>
                            </div>
                        </div>

                        <div id="group-timestamp">
                            <div class="mb-3">
                                <label class="form-label">Waktu Buka</label>
                                <input type="datetime-local" name="timestamp_buka" id="input-timestamp-buka" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Waktu Tutup</label>
                                <input type="datetime-local" name="timestamp_tutup" id="input-timestamp-tutup" class="form-control">
                            </div>
                            <div class="text-muted" style="font-size: 12.5px;" id="info-mode-open" hidden>
                                Mode "Open" mengabaikan waktu buka/tutup — sesi akan selalu terbuka apa pun nilainya.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-jadwal">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var updateUrl = '{{ route('admin.jadwal-penting.update') }}';

            var $modal = $('#modal-jadwal-penting');
            var $infoModeOpen = $('#info-mode-open');

            function toggleModeOpen() {
                var isOpen = $('input[name="mode"]:checked').val() === '2';
                $infoModeOpen.prop('hidden', !isOpen);
            }

            $('input[name="mode"]').on('change', toggleModeOpen);

            $('.btn-edit-jadwal').on('click', function () {
                var $btn = $(this);

                $modal.find('.modal-alert').addClass('d-none').text('');
                $('#input-idjadwal-penting').val($btn.data('idjadwal-penting'));
                $('#judul-nama-jadwal').text($btn.data('nama-jadwal'));
                $('input[name="mode"][value="' + $btn.data('mode') + '"]').prop('checked', true);
                $('#input-timestamp-buka').val($btn.data('timestamp-buka'));
                $('#input-timestamp-tutup').val($btn.data('timestamp-tutup'));

                toggleModeOpen();
                $modal.modal('show');
            });

            $('#form-jadwal-penting').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('.btn-submit-jadwal');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: $(this).serialize(),
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
                    } else if (res.errors) {
                        pesan = Object.values(res.errors).flat().join('\n');
                    }
                    $modal.find('.modal-alert').removeClass('d-none').text(pesan);
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });
        });
    </script>
@endsection
