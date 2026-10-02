@extends('layout.layout')

@section('title', 'Peserta Kontingen')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        .form-control[readonly] {
            color: #000 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Peserta Kontingen</li>
@endsection

@section('content')
    {{-- Card: data institusi asal (readonly, diubah lewat modal) --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Institusi Asal</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-edit-institusi">
                            <i class="fa-solid fa-pen me-1"></i> Ubah Data Institusi
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Institusi</label>
                        <input type="text" class="form-control" value="{{ $institusi->idjenis_institusi == 1 ? 'Perguruan Tinggi' : ($institusi->idjenis_institusi == 4 ? 'LLDikti' : 'Lainnya') }}" readonly>
                    </div>

                    @if($institusi->idjenis_institusi == 1)
                        <div class="col-md-4 mb-3">
                            <label class="form-label">PTN / PTS</label>
                            <input type="text" class="form-control" value="{{ $institusi->ptn_pts == '1' ? 'PTN' : 'PTS' }}" readonly>
                        </div>
                    @endif

                    @if($institusi->idjenis_institusi == 4)
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Wilayah LLDikti</label>
                            <input type="text" class="form-control" value="{{ $lldikti->firstWhere('idlldikti', $institusi->idlldikti)->nomor_lldikti ?? '-' }}" readonly>
                        </div>
                    @endif

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Institusi</label>
                        <input type="text" class="form-control" value="{{ $institusi->nama_institusi }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card: daftar peserta sekontingen --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Peserta Kontingen</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-tambah-peserta">
                            <i class="fa-solid fa-user-plus me-1"></i> Tambah Peserta
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. WA</th>
                                <th>Jabatan</th>
                                <th>Status Data</th>
                                <th class="text-center">Data Peserta</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesertaList as $peserta)
                                <tr>
                                    <td>
                                        {{ $peserta->nama }}
                                        @if($peserta->idpengguna == session('userdata')['idpengguna'])
                                            <span class="badge bg-primary">Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $peserta->email }}</td>
                                    <td>{{ $peserta->no_wa ?? '-' }}</td>
                                    <td>{{ $peserta->nama_jabatan }}</td>
                                    <td>
                                        @if($peserta->lengkap)
                                            <span class="badge bg-success">Lengkap</span>
                                        @else
                                            <span class="badge bg-danger">Belum Lengkap</span>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="javascript:void(0);" class="btn btn-sm {{ $peserta->logistikLengkap ? 'btn-outline-success' : 'btn-outline-danger' }} btn-edit-logistik" title="Data Logistik" data-token="{{ $peserta->token }}">
                                            <i class="fa-solid fa-suitcase-rolling"></i>
                                        </a>
                                        <a href="{{ route('peserta.sekontingen.foto') }}?token={{ $peserta->token }}" class="btn btn-sm {{ $peserta->fotoLengkap ? 'btn-outline-success' : 'btn-outline-danger' }}" title="Foto">
                                            <i class="fa-solid fa-camera"></i>
                                        </a>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning btn-edit-peserta" title="Edit" data-token="{{ $peserta->token }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-reset-password-peserta" title="Reset Password" data-idpeserta="{{ $peserta->idpeserta }}" data-no-wa="{{ $peserta->no_wa }}">
                                            <i class="fa-solid fa-key"></i>
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

    {{-- Modal: ubah data institusi --}}
    <div class="modal fade" id="modal-edit-institusi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit-institusi">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data Institusi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Institusi</label>
                            <input type="text" class="form-control" value="{{ $institusi->idjenis_institusi == 1 ? 'Perguruan Tinggi' : ($institusi->idjenis_institusi == 4 ? 'LLDikti' : 'Lainnya') }}" readonly>
                        </div>

                        @if($institusi->idjenis_institusi == 1)
                            <div class="mb-3">
                                <label class="form-label">PTN / PTS</label>
                                <select name="ptn_pts" class="form-select" required>
                                    <option value="1" @selected($institusi->ptn_pts == '1')>PTN</option>
                                    <option value="2" @selected($institusi->ptn_pts == '2')>PTS</option>
                                </select>
                            </div>
                        @endif

                        @if($institusi->idjenis_institusi == 4)
                            <div class="mb-3">
                                <label class="form-label">Wilayah LLDikti</label>
                                <select name="idlldikti" class="form-select" required>
                                    @foreach($lldikti as $wilayah)
                                        <option value="{{ $wilayah->idlldikti }}" @selected($institusi->idlldikti == $wilayah->idlldikti)>{{ $wilayah->nomor_lldikti }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Institusi</label>
                            <input type="text" name="nama_institusi" class="form-control" value="{{ $institusi->nama_institusi }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-buka-verifikasi-institusi">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('peserta.partials.modal-verifikasi-teks', [
        'id' => 'modal-verifikasi-institusi',
        'judul' => 'Verifikasi Perubahan Data Institusi',
        'teksPeringatan' => 'YA SAYA SECARA SADAR MERUBAH DATA INSTITUSI',
    ])

    {{-- Modal: tambah peserta baru --}}
    <div class="modal fade" id="modal-tambah-peserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-tambah-peserta">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Peserta Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" maxlength="1000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" maxlength="500" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" inputmode="numeric" maxlength="30" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <select name="idjabatan" class="form-select" required>
                                <option value="" selected disabled>Pilih jabatan...</option>
                                @foreach ($jabatanOptions as $jabatan)
                                    <option value="{{ $jabatan->idjabatan }}">{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-tambah-peserta">
                            <span class="btn-label">Tambah Peserta</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: edit peserta --}}
    <div class="modal fade" id="modal-edit-peserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit-peserta">
                    <input type="hidden" name="idpeserta">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Peserta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="edit-loading text-center py-4">
                            <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                        </div>

                        <div class="edit-content d-none">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" maxlength="1000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" maxlength="500" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" name="no_wa" class="form-control" inputmode="numeric" maxlength="30" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="idjabatan" class="form-select" required>
                                    @foreach ($jabatanOptions as $jabatan)
                                        <option value="{{ $jabatan->idjabatan }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-buka-verifikasi-edit d-none">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('peserta.partials.modal-verifikasi-teks', [
        'id' => 'modal-verifikasi-edit-peserta',
        'judul' => 'Verifikasi Perubahan Data Peserta',
        'teksPeringatan' => 'YA SAYA SECARA SADAR MERUBAH DATA PESERTA',
    ])

    {{-- Modal: data logistik peserta --}}
    <div class="modal fade" id="modal-logistik-peserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-logistik-peserta">
                    <input type="hidden" name="idpeserta">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Logistik Peserta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="logistik-loading text-center py-4">
                            <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                        </div>

                        <div class="logistik-content d-none">
                            <h6>Kedatangan</h6>
                            <div class="mb-3">
                                <label class="form-label">Jenis Transportasi</label>
                                <select name="idjenis_transportasi_kedatangan" class="form-select select-transport-kedatangan" required>
                                    <option value="" selected disabled>Pilih jenis transportasi...</option>
                                    @foreach ($jenisTransportOptions as $jt)
                                        <option value="{{ $jt->idjenis_transport }}">{{ $jt->nama_jenis_transport }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 group-stasiun-kedatangan">
                                <label class="form-label">Stasiun/Titik Kedatangan</label>
                                <input type="text" name="stasiun_kedatangan" class="form-control" maxlength="255">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kedatangan</label>
                                    <input type="date" name="tanggal_kedatangan" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Kedatangan</label>
                                    <input type="time" name="jam_kedatangan" class="form-control" required>
                                </div>
                            </div>

                            <hr>

                            <h6>Kepulangan</h6>
                            <div class="mb-3">
                                <label class="form-label">Jenis Transportasi</label>
                                <select name="idjenis_transportasi_kepulangan" class="form-select select-transport-kepulangan" required>
                                    <option value="" selected disabled>Pilih jenis transportasi...</option>
                                    @foreach ($jenisTransportOptions as $jt)
                                        <option value="{{ $jt->idjenis_transport }}">{{ $jt->nama_jenis_transport }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 group-stasiun-kepulangan">
                                <label class="form-label">Stasiun/Titik Kepulangan</label>
                                <input type="text" name="stasiun_kepulangan" class="form-control" maxlength="255">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kepulangan</label>
                                    <input type="date" name="tanggal_kepulangan" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Kepulangan</label>
                                    <input type="time" name="jam_kepulangan" class="form-control" required>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Nama Hotel (opsional)</label>
                                <input type="text" name="nama_hotel" class="form-control" maxlength="255">
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="city_tour" value="1" class="form-check-input" id="check-city-tour">
                                <label class="form-check-label" for="check-city-tour">Mengikuti City Tour</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-simpan-logistik d-none">
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
            var updateInstitusiUrl = '{{ route('peserta.institusi.update') }}';
            var tambahUrl = '{{ route('peserta.sekontingen.tambah') }}';
            var updateUrl = '{{ route('peserta.sekontingen.update') }}';
            var resetPasswordUrl = '{{ route('peserta.sekontingen.reset-password') }}';
            var detailUrl = '{{ route('peserta.sekontingen.detail') }}';
            var detailLogistikUrl = '{{ route('peserta.sekontingen.logistik.detail') }}';
            var updateLogistikUrl = '{{ route('peserta.sekontingen.logistik.update') }}';
            var idKendaraanPribadi = {{ (int) $idKendaraanPribadi }};

            function tampilkanKesalahanAjax($container, xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $container.find('.modal-alert').removeClass('d-none').text(pesan);
            }

            // ------- Ubah data institusi (modal verifikasi teks) -------
            var $modalEditInstitusi = $('#modal-edit-institusi');
            var $modalVerifikasiInstitusi = $('#modal-verifikasi-institusi');
            var $inputVerifikasiInstitusi = $modalVerifikasiInstitusi.find('.input-verifikasi-teks');
            var $btnKonfirmasiInstitusi = $modalVerifikasiInstitusi.find('.btn-konfirmasi-verifikasi');
            var teksPeringatanInstitusi = $inputVerifikasiInstitusi.data('teks-peringatan');

            $inputVerifikasiInstitusi.on('paste', function (e) {
                e.preventDefault();
            });

            $inputVerifikasiInstitusi.on('input', function () {
                $btnKonfirmasiInstitusi.prop('disabled', $inputVerifikasiInstitusi.val() !== teksPeringatanInstitusi);
            });

            $modalVerifikasiInstitusi.on('hidden.bs.modal', function () {
                $inputVerifikasiInstitusi.val('');
                $btnKonfirmasiInstitusi.prop('disabled', true);
                $modalVerifikasiInstitusi.find('.modal-alert').addClass('d-none').text('');
            });

            $('.btn-buka-verifikasi-institusi').on('click', function () {
                if (!$('#form-edit-institusi')[0].reportValidity()) {
                    return;
                }

                $modalVerifikasiInstitusi.find('.verifikasi-ringkasan').text('Anda akan mengubah data institusi asal.');
                $modalVerifikasiInstitusi.modal('show');
            });

            $btnKonfirmasiInstitusi.on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                $.ajax({
                    url: updateInstitusiUrl,
                    method: 'POST',
                    data: $('#form-edit-institusi').serialize(),
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $modalVerifikasiInstitusi.modal('hide');
                    $modalEditInstitusi.modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        location.reload();
                    });
                })
                .fail(function (xhr) {
                    tampilkanKesalahanAjax($modalVerifikasiInstitusi, xhr);
                })
                .always(function () {
                    $btn.html(teksAwal);
                    $btn.prop('disabled', $inputVerifikasiInstitusi.val() !== teksPeringatanInstitusi);
                });
            });

            // ------- Tambah peserta baru (SweetAlert2 confirm, bukan modal teks) -------
            $('#modal-tambah-peserta').on('show.bs.modal', function () {
                $('#form-tambah-peserta')[0].reset();
                $(this).find('.modal-alert').addClass('d-none').text('');
            });

            $('#form-tambah-peserta').on('submit', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('.btn-submit-tambah-peserta');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah data peserta sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $form.find('.modal-alert').addClass('d-none').text('');

                    $.ajax({
                        url: tambahUrl,
                        method: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanKesalahanAjax($form, xhr);
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });

            // ------- Edit peserta (modal verifikasi teks) -------
            var $modalEdit = $('#modal-edit-peserta');
            var $editLoading = $modalEdit.find('.edit-loading');
            var $editContent = $modalEdit.find('.edit-content');
            var $btnBukaVerifikasiEdit = $modalEdit.find('.btn-buka-verifikasi-edit');

            $('.btn-edit-peserta').on('click', function () {
                var token = $(this).data('token');

                $editLoading.removeClass('d-none');
                $editContent.addClass('d-none');
                $btnBukaVerifikasiEdit.addClass('d-none');
                $modalEdit.find('.modal-alert').addClass('d-none').text('');
                $modalEdit.modal('show');

                $.ajax({
                    url: detailUrl + '?token=' + encodeURIComponent(token),
                    method: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var data = res.data;
                    $modalEdit.find('[name="idpeserta"]').val(data.idpeserta);
                    $modalEdit.find('[name="nama"]').val(data.nama);
                    $modalEdit.find('[name="email"]').val(data.email);
                    $modalEdit.find('[name="no_wa"]').val(data.no_wa);
                    $modalEdit.find('[name="idjabatan"]').val(data.idjabatan);
                    $editLoading.addClass('d-none');
                    $editContent.removeClass('d-none');
                    $btnBukaVerifikasiEdit.removeClass('d-none');
                })
                .fail(function (xhr) {
                    tampilkanKesalahanAjax($modalEdit, xhr);
                });
            });

            var $modalVerifikasiEdit = $('#modal-verifikasi-edit-peserta');
            var $inputVerifikasiEdit = $modalVerifikasiEdit.find('.input-verifikasi-teks');
            var $btnKonfirmasiEdit = $modalVerifikasiEdit.find('.btn-konfirmasi-verifikasi');
            var teksPeringatanEdit = $inputVerifikasiEdit.data('teks-peringatan');

            $inputVerifikasiEdit.on('paste', function (e) {
                e.preventDefault();
            });

            $inputVerifikasiEdit.on('input', function () {
                $btnKonfirmasiEdit.prop('disabled', $inputVerifikasiEdit.val() !== teksPeringatanEdit);
            });

            $modalVerifikasiEdit.on('hidden.bs.modal', function () {
                $inputVerifikasiEdit.val('');
                $btnKonfirmasiEdit.prop('disabled', true);
                $modalVerifikasiEdit.find('.modal-alert').addClass('d-none').text('');
            });

            $btnBukaVerifikasiEdit.on('click', function () {
                if (!$('#form-edit-peserta')[0].reportValidity()) {
                    return;
                }

                var nama = $modalEdit.find('[name="nama"]').val();
                $modalVerifikasiEdit.find('.verifikasi-ringkasan').text('Anda akan mengubah data peserta: ' + nama);
                $modalVerifikasiEdit.modal('show');
            });

            $btnKonfirmasiEdit.on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                $.ajax({
                    url: updateUrl,
                    method: 'POST',
                    data: $('#form-edit-peserta').serialize(),
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    $modalVerifikasiEdit.modal('hide');
                    $modalEdit.modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        location.reload();
                    });
                })
                .fail(function (xhr) {
                    tampilkanKesalahanAjax($modalVerifikasiEdit, xhr);
                })
                .always(function () {
                    $btn.html(teksAwal);
                    $btn.prop('disabled', $inputVerifikasiEdit.val() !== teksPeringatanEdit);
                });
            });

            // ------- Data logistik peserta (SweetAlert2 confirm, bukan modal teks) -------
            var $modalLogistik = $('#modal-logistik-peserta');
            var $logistikLoading = $modalLogistik.find('.logistik-loading');
            var $logistikContent = $modalLogistik.find('.logistik-content');
            var $btnSimpanLogistik = $modalLogistik.find('.btn-simpan-logistik');
            var $selectTransportKedatangan = $modalLogistik.find('.select-transport-kedatangan');
            var $selectTransportKepulangan = $modalLogistik.find('.select-transport-kepulangan');
            var $groupStasiunKedatangan = $modalLogistik.find('.group-stasiun-kedatangan');
            var $groupStasiunKepulangan = $modalLogistik.find('.group-stasiun-kepulangan');

            function toggleStasiun($select, $group) {
                var isKendaraanPribadi = parseInt($select.val(), 10) === idKendaraanPribadi;
                $group.toggle(!isKendaraanPribadi);
                $group.find('input').prop('required', !isKendaraanPribadi);
                if (isKendaraanPribadi) {
                    $group.find('input').val('');
                }
            }

            $selectTransportKedatangan.on('change', function () {
                toggleStasiun($selectTransportKedatangan, $groupStasiunKedatangan);
            });

            $selectTransportKepulangan.on('change', function () {
                toggleStasiun($selectTransportKepulangan, $groupStasiunKepulangan);
            });

            $('.btn-edit-logistik').on('click', function () {
                var token = $(this).data('token');

                $logistikLoading.removeClass('d-none');
                $logistikContent.addClass('d-none');
                $btnSimpanLogistik.addClass('d-none');
                $modalLogistik.find('.modal-alert').addClass('d-none').text('');
                $modalLogistik.modal('show');

                $.ajax({
                    url: detailLogistikUrl + '?token=' + encodeURIComponent(token),
                    method: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var data = res.data;
                    $modalLogistik.find('[name="idpeserta"]').val(data.idpeserta);
                    $selectTransportKedatangan.val(data.idjenis_transportasi_kedatangan);
                    $modalLogistik.find('[name="stasiun_kedatangan"]').val(data.stasiun_kedatangan);
                    $modalLogistik.find('[name="tanggal_kedatangan"]').val(data.tanggal_kedatangan);
                    $modalLogistik.find('[name="jam_kedatangan"]').val(data.jam_kedatangan ? data.jam_kedatangan.substring(0, 5) : '');
                    $selectTransportKepulangan.val(data.idjenis_transportasi_kepulangan);
                    $modalLogistik.find('[name="stasiun_kepulangan"]').val(data.stasiun_kepulangan);
                    $modalLogistik.find('[name="tanggal_kepulangan"]').val(data.tanggal_kepulangan);
                    $modalLogistik.find('[name="jam_kepulangan"]').val(data.jam_kepulangan ? data.jam_kepulangan.substring(0, 5) : '');
                    $modalLogistik.find('[name="nama_hotel"]').val(data.nama_hotel);
                    $modalLogistik.find('[name="city_tour"]').prop('checked', !!data.city_tour);

                    toggleStasiun($selectTransportKedatangan, $groupStasiunKedatangan);
                    toggleStasiun($selectTransportKepulangan, $groupStasiunKepulangan);

                    $logistikLoading.addClass('d-none');
                    $logistikContent.removeClass('d-none');
                    $btnSimpanLogistik.removeClass('d-none');
                })
                .fail(function (xhr) {
                    tampilkanKesalahanAjax($modalLogistik, xhr);
                });
            });

            $btnSimpanLogistik.on('click', function () {
                if (!$('#form-logistik-peserta')[0].reportValidity()) {
                    return;
                }

                var $btn = $(this);

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Simpan perubahan data logistik peserta ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $modalLogistik.find('.modal-alert').addClass('d-none').text('');

                    $.ajax({
                        url: updateLogistikUrl,
                        method: 'POST',
                        data: $('#form-logistik-peserta').serialize(),
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanKesalahanAjax($modalLogistik, xhr);
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });

            // ------- Reset password (pola SweetAlert2 sama seperti Admin, tombol -------
            // dikunci 30 detik setelah diklik supaya tidak bisa direset berkali-kali) -------
            $('.btn-reset-password-peserta').on('click', function () {
                var $btn = $(this);

                if ($btn.prop('disabled')) {
                    return;
                }

                var idpeserta = $btn.data('idpeserta');
                var noWa = $btn.data('no-wa');
                var teksAsli = $btn.html();

                Swal.fire({
                    title: 'Reset Password?',
                    text: 'Password akan dikirim ke no WA ' + noWa,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, reset',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var sisaDetik = 30;
                    $btn.prop('disabled', true).text(sisaDetik);

                    var interval = setInterval(function () {
                        sisaDetik--;

                        if (sisaDetik <= 0) {
                            clearInterval(interval);
                            $btn.prop('disabled', false).html(teksAsli);
                        } else {
                            $btn.text(sisaDetik);
                        }
                    }, 1000);

                    $.ajax({
                        url: resetPasswordUrl,
                        method: 'POST',
                        data: { idpeserta: idpeserta },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    })
                    .fail(function (xhr) {
                        var res = xhr.responseJSON || {};
                        var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        if (xhr.status === 0) {
                            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                    });
                });
            });
        });
    </script>
@endsection
