@extends('layout.layout')

@section('title', 'Data Master Universitas')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Data Master</a></li>
    <li class="breadcrumb-item active" aria-current="page">Universitas</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Tambah Universitas</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="form-alert alert alert-danger d-none mb-3" role="alert"></div>

                <form id="form-tambah-universitas">
                    <div class="mb-3">
                        <label class="form-label" for="input-nama-universitas">Nama Universitas</label>
                        <input type="text" name="nama" id="input-nama-universitas" class="form-control" maxlength="255" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-label">Tambah Universitas</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Cari Universitas</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="mb-3">
                    <label class="form-label" for="input-cari-universitas">Nama Universitas (sebagian)</label>
                    <input type="text" id="input-cari-universitas" class="form-control" placeholder="Ketik minimal beberapa huruf...">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Universitas</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-hasil-cari-universitas">
                            <tr>
                                <td colspan="2" class="text-center text-muted">Ketik nama universitas untuk mencari.</td>
                            </tr>
                        </tbody>
                    </table>
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
            var cariUrl = '{{ route('admin.data-master.universitas.cari') }}';
            var tambahUrl = '{{ route('admin.data-master.universitas.tambah') }}';
            var timerCari = null;

            function tampilkanErrorForm(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $('.form-alert').removeClass('d-none').text(pesan);
            }

            function renderHasilCari(hasil) {
                var $tbody = $('#tbody-hasil-cari-universitas');
                $tbody.empty();

                if (hasil.length === 0) {
                    $tbody.append('<tr><td colspan="2" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>');
                    return;
                }

                $.each(hasil, function (_, baris) {
                    $tbody.append(
                        $('<tr>').append(
                            $('<td>').text(baris.kode_universitas),
                            $('<td>').text(baris.nama_universitas)
                        )
                    );
                });
            }

            function cariUniversitas(keyword) {
                return $.ajax({
                    url: cariUrl,
                    method: 'GET',
                    data: { q: keyword },
                    dataType: 'json',
                });
            }

            $('#input-cari-universitas').on('keyup', function () {
                var keyword = $(this).val().trim();

                clearTimeout(timerCari);

                if (keyword === '') {
                    renderHasilCari([]);
                    $('#tbody-hasil-cari-universitas').html('<tr><td colspan="2" class="text-center text-muted">Ketik nama universitas untuk mencari.</td></tr>');
                    return;
                }

                timerCari = setTimeout(function () {
                    cariUniversitas(keyword)
                        .done(function (hasil) {
                            renderHasilCari(hasil);
                        })
                        .fail(function () {
                            $('#tbody-hasil-cari-universitas').html('<tr><td colspan="2" class="text-center text-danger">Gagal memuat data. Silakan coba lagi.</td></tr>');
                        });
                }, 400);
            });

            function kirimTambahUniversitas($btn, teksAwal, nama) {
                $.ajax({
                    url: tambahUrl,
                    method: 'POST',
                    data: { nama: nama },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    $('#form-tambah-universitas')[0].reset();

                    var keywordCari = $('#input-cari-universitas').val().trim();
                    if (keywordCari !== '') {
                        cariUniversitas(keywordCari).done(renderHasilCari);
                    }
                })
                .fail(function (xhr) {
                    tampilkanErrorForm(xhr);
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            }

            $('#form-tambah-universitas').on('submit', function (e) {
                e.preventDefault();

                var $btn = $(this).find('button[type="submit"]');
                var teksAwal = $btn.html();
                var nama = $('#input-nama-universitas').val().trim();

                $('.form-alert').addClass('d-none').text('');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                cariUniversitas(nama)
                    .done(function (hasil) {
                        if (hasil.length === 0) {
                            kirimTambahUniversitas($btn, teksAwal, nama);
                            return;
                        }

                        var daftarMirip = $.map(hasil, function (baris) {
                            return '<li>' + $('<div>').text(baris.nama_universitas).html() + '</li>';
                        }).join('');

                        Swal.fire({
                            icon: 'question',
                            title: 'Universitas serupa ditemukan',
                            html: 'Apakah salah satu universitas berikut yang Anda maksud?<ul class="text-start">' + daftarMirip + '</ul>',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Ada, batalkan',
                            denyButtonText: 'Tidak ada, tambahkan',
                            cancelButtonText: 'Batal',
                        }).then(function (result) {
                            if (result.isDenied) {
                                kirimTambahUniversitas($btn, teksAwal, nama);
                                return;
                            }

                            $btn.prop('disabled', false).html(teksAwal);
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanErrorForm(xhr);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
            });
        });
    </script>
@endsection
