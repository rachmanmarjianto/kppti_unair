@extends('layout.layout')

@section('title', 'Test Card')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        .input-test-card {
            font-size: 24px;
            text-align: center;
            max-width: 420px;
        }

        .hasil-test-card {
            max-width: 420px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Test Card</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Test Card</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <p class="text-muted" style="font-size: 12.5px;">
                    Tap atau ketik ID card lalu tekan Enter untuk melihat siapa pemiliknya.
                </p>

                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <input type="text" class="form-control input-test-card mb-4" id="input-test-card" autocomplete="off" autofocus>

                <div class="hasil-test-card d-none">
                    <img id="hasil-foto" src="" alt="Foto peserta" class="img-fluid rounded mb-3 d-none" style="max-height: 260px;">

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 140px;">Nama</th>
                            <td id="hasil-nama"></td>
                        </tr>
                        <tr>
                            <th>No WA</th>
                            <td id="hasil-no-wa"></td>
                        </tr>
                        <tr>
                            <th>Institusi</th>
                            <td id="hasil-nama-institusi"></td>
                        </tr>
                    </table>

                    <button type="button" class="btn btn-outline-danger" id="btn-hapus-idcard">
                        <i class="fa-solid fa-trash me-1"></i> Hapus Data IDCard
                    </button>
                </div>
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
            var cariUrl = '{{ route('admin.test-card.cari') }}';
            var hapusIdcardUrl = '{{ route('admin.test-card.hapus-idcard') }}';

            var $input = $('#input-test-card');
            var $hasil = $('.hasil-test-card');
            var $alert = $('.page-alert');
            var idpenggunaAktif = null;

            $input.focus();

            $input.on('keydown', function (e) {
                if (e.key !== 'Enter') {
                    return;
                }

                e.preventDefault();

                var idcard = $input.val();

                if (idcard === '') {
                    return;
                }

                $alert.addClass('d-none').text('');

                $.ajax({
                    url: cariUrl,
                    method: 'POST',
                    data: { idcard: idcard },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    idpenggunaAktif = res.data.idpengguna;

                    $('#hasil-nama').text(res.data.nama);
                    $('#hasil-no-wa').text(res.data.no_wa || '-');
                    $('#hasil-nama-institusi').text(res.data.nama_institusi || '-');

                    var $foto = $('#hasil-foto');
                    if (res.data.fotoUrl) {
                        $foto.attr('src', res.data.fotoUrl).removeClass('d-none');
                    } else {
                        $foto.addClass('d-none').attr('src', '');
                    }

                    $hasil.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    idpenggunaAktif = null;
                    $hasil.addClass('d-none');
                    $alert.removeClass('d-none').text(pesan);
                })
                .always(function () {
                    $input.val('').focus();
                });
            });

            $('#btn-hapus-idcard').on('click', function () {
                if (!idpenggunaAktif) {
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus data ID card peserta ini? Card fisiknya bisa dipakai ulang untuk peserta lain setelah ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $alert.addClass('d-none').text('');

                    $.ajax({
                        url: hapusIdcardUrl,
                        method: 'POST',
                        data: { idpengguna: idpenggunaAktif },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        idpenggunaAktif = null;
                        $hasil.addClass('d-none');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    })
                    .fail(function (xhr) {
                        var res = xhr.responseJSON || {};
                        var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        if (xhr.status === 0) {
                            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        $alert.removeClass('d-none').text(pesan);
                    })
                    .always(function () {
                        $input.val('').focus();
                    });
                });
            });
        });
    </script>
@endsection
