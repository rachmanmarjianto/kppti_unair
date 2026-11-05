@extends('layout.layout')

@section('title', 'Tanggal MoU')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tanggal MoU</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Tanggal MoU</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-primary" id="btn-tambah-tanggal">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Tanggal
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <table class="table table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanggalList as $baris)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($baris->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if($baris->status)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:void(0);" class="btn {{ $baris->status ? 'btn-outline-danger' : 'btn-outline-success' }} btn-toggle-status-tanggal"
                                       title="{{ $baris->status ? 'Nonaktifkan' : 'Aktifkan Lagi' }}" data-idtanggal-mou="{{ $baris->idtanggal_mou }}">
                                        <i class="fa-solid {{ $baris->status ? 'fa-ban' : 'fa-rotate-left' }}"></i>
                                        {{ $baris->status ? 'Nonaktifkan' : 'Aktifkan Lagi' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data tanggal MoU.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal: tambah tanggal MoU --}}
    <div class="modal fade" id="modal-tanggal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-tanggal">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tanggal MoU</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label" for="input-tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="input-tanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-tanggal">
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
            var tambahUrl = '{{ route('admin.mou.tanggal.tambah') }}';
            var toggleStatusUrl = '{{ route('admin.mou.tanggal.toggle-status') }}';
            var $modal = $('#modal-tanggal');

            $('#btn-tambah-tanggal').on('click', function () {
                $('#form-tanggal')[0].reset();
                $modal.find('.modal-alert').addClass('d-none').text('');
                $modal.modal('show');
            });

            $('#form-tanggal').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('.btn-submit-tanggal');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: tambahUrl,
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

            $('.btn-toggle-status-tanggal').on('click', function () {
                var $btn = $(this);
                var idtanggalMou = $btn.data('idtanggal-mou');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Ubah status tanggal MoU ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $btn.addClass('disabled');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: toggleStatusUrl,
                        method: 'POST',
                        data: { idtanggal_mou: idtanggalMou },
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
                        $btn.removeClass('disabled');
                    });
                });
            });
        });
    </script>
@endsection
