@extends('layout.layout')

@section('title', 'Petugas Meja')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Kedatangan Kontingen</a></li>
    <li class="breadcrumb-item active" aria-current="page">Petugas Meja</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Petugas Meja</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-primary" id="btn-tambah-meja-regis">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Meja Regis
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p class="text-muted">Atur pengguna mana yang bertugas di meja registrasi nomor berapa pada hari kedatangan kontingen. Hanya pengguna dengan role "Petugas Meja Registrasi" yang bisa dipetakan, dan satu pengguna hanya bisa dipetakan ke satu meja.</p>

                <table id="table-petugas-meja" class="table table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nomor Meja</th>
                            <th>Petugas</th>
                            <th>No. WA</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mejaRegisList as $baris)
                            <tr>
                                <td>{{ $baris->nomor_meja }}</td>
                                <td>{{ $baris->nama_petugas }}</td>
                                <td>{{ $baris->no_wa ?? '-' }}</td>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:void(0);" class="btn btn-outline-warning btn-edit-meja-regis" title="Edit"
                                       data-idmeja-regis="{{ $baris->idmeja_regis }}" data-nomor-meja="{{ $baris->nomor_meja }}"
                                       data-idpengguna="{{ $baris->idpengguna }}" data-nama-petugas="{{ $baris->nama_petugas }}">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-hapus-meja-regis" title="Hapus"
                                       data-idmeja-regis="{{ $baris->idmeja_regis }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada pemetaan meja registrasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal: tambah/ubah pemetaan meja regis --}}
    <div class="modal fade" id="modal-meja-regis" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-meja-regis">
                    <input type="hidden" name="idmeja_regis" id="input-idmeja-regis">
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul-modal-meja-regis">Tambah Meja Regis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label" for="input-nomor-meja">Nomor Meja</label>
                            <input type="text" name="nomor_meja" id="input-nomor-meja" class="form-control" maxlength="2" placeholder="Contoh: 01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="select-petugas-meja-regis">Petugas</label>
                            <select name="idpengguna" id="select-petugas-meja-regis" class="form-select" required>
                                <option value="">-- Pilih Petugas --</option>
                            </select>
                            <small class="text-muted">Hanya pengguna dengan role "Petugas Meja Registrasi" yang belum dipetakan ke meja lain.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-meja-regis">
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
            var tambahUrl = '{{ route('admin.kedatangan.petugas-meja.tambah') }}';
            var ubahUrl = '{{ route('admin.kedatangan.petugas-meja.ubah') }}';
            var hapusUrl = '{{ route('admin.kedatangan.petugas-meja.hapus') }}';
            var petugasBelumDipetakan = {!! json_encode($petugasBelumDipetakan) !!};
            var $modal = $('#modal-meja-regis');
            var $select = $('#select-petugas-meja-regis');

            function isiOpsiPetugas(opsiTambahan) {
                $select.empty().append('<option value="">-- Pilih Petugas --</option>');

                var daftar = petugasBelumDipetakan.slice();

                if (opsiTambahan) {
                    daftar.unshift(opsiTambahan);
                }

                daftar.forEach(function (petugas) {
                    $select.append($('<option>').val(petugas.idpengguna).text(petugas.nama));
                });
            }

            $('#btn-tambah-meja-regis').on('click', function () {
                $('#form-meja-regis')[0].reset();
                $('#input-idmeja-regis').val('');
                $('#judul-modal-meja-regis').text('Tambah Meja Regis');
                isiOpsiPetugas(null);
                $modal.find('.modal-alert').addClass('d-none').text('');
                $modal.modal('show');
            });

            $('#table-petugas-meja').on('click', '.btn-edit-meja-regis', function () {
                var $btn = $(this);

                $('#form-meja-regis')[0].reset();
                $('#input-idmeja-regis').val($btn.data('idmeja-regis'));
                $('#input-nomor-meja').val($btn.data('nomor-meja'));
                $('#judul-modal-meja-regis').text('Ubah Meja Regis');
                isiOpsiPetugas({ idpengguna: $btn.data('idpengguna'), nama: $btn.data('nama-petugas') });
                $select.val($btn.data('idpengguna'));
                $modal.find('.modal-alert').addClass('d-none').text('');
                $modal.modal('show');
            });

            $('#form-meja-regis').on('submit', function (e) {
                e.preventDefault();

                var idmejaRegis = $('#input-idmeja-regis').val();
                var url = idmejaRegis ? ubahUrl : tambahUrl;
                var $btn = $('.btn-submit-meja-regis');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: url,
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

            $('#table-petugas-meja').on('click', '.btn-hapus-meja-regis', function () {
                var idmejaRegis = $(this).data('idmeja-regis');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus pemetaan meja ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: hapusUrl,
                        method: 'POST',
                        data: { idmeja_regis: idmejaRegis },
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
                    });
                });
            });
        });
    </script>
@endsection
