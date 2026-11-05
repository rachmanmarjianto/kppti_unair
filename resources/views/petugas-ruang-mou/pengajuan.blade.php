@extends('layout.layout')

@section('title', 'Pengajuan MoU')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        .matrix-pertemuan-mou {
            width: auto;
        }

        .matrix-pertemuan-mou td, .matrix-pertemuan-mou th {
            text-align: center;
            vertical-align: middle;
            min-width: 170px;
        }

        .matrix-pertemuan-mou th:first-child,
        .matrix-pertemuan-mou td:first-child {
            min-width: 110px;
        }

        .matrix-pertemuan-mou .sel-terisi {
            font-size: 11.5px;
            line-height: 1.4;
        }

        .matrix-pertemuan-mou .sel-terisi-link {
            display: block;
            text-decoration: none;
            cursor: pointer;
        }

        #modal-kerja-petugas .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan MoU</li>
@endsection

@php
    $labelStatusAjuan = [
        1 => ['Ajuan', 'bg-secondary'],
        2 => ['Temu Diskusi', 'bg-info'],
        3 => ['Tunda Lain Waktu', 'bg-warning'],
        4 => ['Terjalin', 'bg-success'],
        5 => ['Dibatalkan', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Pengajuan MoU</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="row mb-3 align-items-end" style="padding-left:30px">
                    <div class="col-md-4 col-sm-6 col-12">
                        <label for="filter-tanggal-mou" class="form-label">Tanggal MoU</label>
                        <select id="filter-tanggal-mou" class="form-select">
                            @foreach($tanggalAktifList as $tanggal)
                                <option value="{{ $tanggal->idtanggal_mou }}" @selected((string) $idTanggalTerpilih === (string) $tanggal->idtanggal_mou)>
                                    {{ \Carbon\Carbon::parse($tanggal->tanggal)->translatedFormat('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <label for="filter-ruang-mou" class="form-label">Ruang</label>
                        <select id="filter-ruang-mou" class="form-select">
                            @foreach($ruangList as $ruang)
                                <option value="{{ $ruang->idruang_mou }}" @selected((string) $idRuangTerpilih === (string) $ruang->idruang_mou)>
                                    {{ $ruang->nama_ruang }} (kapasitas {{ $ruang->kapasitas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-2 mt-md-0">
                        <button type="button" class="btn btn-primary" id="btn-sesuaikan-slot" @if(! $tanggalTerpilih || ! $ruangTerpilih) disabled @endif>
                            <span class="btn-label"><i class="fa-solid fa-rotate me-1"></i> Sesuaikan Slot</span>
                        </button>
                    </div>
                </div>

                @if(! $tanggalTerpilih || ! $ruangTerpilih)
                    <p class="text-muted mb-0">Belum ada data Tanggal MoU (aktif) atau Ruang MoU.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered matrix-pertemuan-mou">
                            <thead>
                                <tr>
                                    <th>Sesi</th>
                                    @foreach($kolomMeja as $meja)
                                        <th>Meja {{ $meja }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sesiList as $sesi)
                                    <tr>
                                        <td class="fw-bold text-nowrap">{{ substr($sesi->jam_mulai, 0, 5) }}-{{ substr($sesi->jam_akhir, 0, 5) }}</td>
                                        @foreach($kolomMeja as $meja)
                                            @php
                                                $sel = $pertemuanMap->get("{$sesi->idsesi_mou}-{$meja}");
                                            @endphp
                                            <td>
                                                @if(! $sel)
                                                    <span class="text-muted">-</span>
                                                @elseif(! $sel->idpengajuan_mou)
                                                    <span class="badge bg-success">Kosong</span>
                                                @else
                                                    <a href="javascript:void(0);" class="sel-terisi-link btn-buka-modal-petugas" data-token="{{ $sel->token }}" title="Kelola pertemuan">
                                                        <span class="badge {{ $labelStatusAjuan[$sel->status_ajuan][1] ?? 'bg-secondary' }} mb-1">
                                                            {{ $labelStatusAjuan[$sel->status_ajuan][0] ?? 'Terisi' }}
                                                        </span>
                                                        <div class="sel-terisi">
                                                            <strong>{{ $sel->nama_institusi_pengaju }}</strong>
                                                            <br>&harr;<br>
                                                            <strong>{{ $sel->nama_institusi_mitra }}</strong>
                                                        </div>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal: kerja petugas — catat kehadiran PIC & hasil pertemuan --}}
    <div class="modal fade" id="modal-kerja-petugas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Pertemuan MoU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="kerja-petugas-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="kerja-petugas-content d-none">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">Institusi Pengaju</h6>
                                        <p class="mb-1 nama-institusi-pengaju fw-bold"></p>
                                        <p class="mb-2 text-muted">PIC: <span class="nama-pic-pengaju"></span></p>
                                        <p class="mb-2 status-hadir-pengaju"></p>
                                        <button type="button" class="btn btn-success btn-hadir-pengaju">
                                            <i class="fa-solid fa-user-check me-1"></i> Hadir
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">Institusi Mitra</h6>
                                        <p class="mb-1 nama-institusi-mitra fw-bold"></p>
                                        <p class="mb-2 text-muted">PIC: <span class="nama-pic-mitra"></span></p>
                                        <p class="mb-2 status-hadir-mitra"></p>
                                        <button type="button" class="btn btn-success btn-hadir-mitra">
                                            <i class="fa-solid fa-user-check me-1"></i> Hadir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Hasil Pertemuan</h6>
                                <p class="mb-2">Status saat ini: <span class="badge status-ajuan-saat-ini"></span></p>
                                <button type="button" class="btn btn-success btn-ubah-hasil" data-status="4">
                                    <i class="fa-solid fa-handshake me-1"></i> Terjalin
                                </button>
                                <button type="button" class="btn btn-warning btn-ubah-hasil" data-status="3">
                                    <i class="fa-solid fa-clock me-1"></i> Tunda Lain Waktu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
            var sesuaikanSlotUrl = '{{ route('petugas-ruang-mou.pengajuan.sesuaikan-slot') }}';
            var detailSlotUrl = '{{ route('petugas-ruang-mou.pengajuan.detail-slot') }}';
            var hadirPengajuUrl = '{{ route('petugas-ruang-mou.pengajuan.hadir-pengaju') }}';
            var hadirMitraUrl = '{{ route('petugas-ruang-mou.pengajuan.hadir-mitra') }}';
            var ubahHasilUrl = '{{ route('petugas-ruang-mou.pengajuan.ubah-hasil') }}';
            var baseUrl = '{{ route('petugas-ruang-mou.pengajuan') }}';

            var $modal = $('#modal-kerja-petugas');
            var $loading = $modal.find('.kerja-petugas-loading');
            var $content = $modal.find('.kerja-petugas-content');
            var tokenAktif = null;
            var adaPerubahan = false;

            var labelStatusAjuan = {
                1: ['Ajuan', 'bg-secondary'],
                2: ['Temu Diskusi', 'bg-info'],
                3: ['Tunda Lain Waktu', 'bg-warning'],
                4: ['Terjalin', 'bg-success'],
                5: ['Dibatalkan', 'bg-danger'],
            };

            function muatUlangDenganFilter() {
                var idTanggal = $('#filter-tanggal-mou').val();
                var idRuang = $('#filter-ruang-mou').val();

                if (!idTanggal || !idRuang) {
                    window.location.href = baseUrl;
                    return;
                }

                window.location.href = baseUrl + '?idtanggal_mou=' + encodeURIComponent(idTanggal) + '&idruang_mou=' + encodeURIComponent(idRuang);
            }

            $('#filter-tanggal-mou, #filter-ruang-mou').on('change', muatUlangDenganFilter);

            $('#btn-sesuaikan-slot').on('click', function () {
                var $btn = $(this);
                var idTanggal = $('#filter-tanggal-mou').val();
                var idRuang = $('#filter-ruang-mou').val();

                if (!idTanggal || !idRuang) {
                    return;
                }

                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: sesuaikanSlotUrl,
                    method: 'POST',
                    data: { idtanggal_mou: idTanggal, idruang_mou: idRuang },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (res.data && typeof res.data.jumlah !== 'undefined')
                            ? 'Jumlah slot yang ditambahkan: ' + res.data.jumlah
                            : res.message,
                    }).then(function () {
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
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            function tampilkanErrorModal(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                }
                $modal.find('.modal-alert').removeClass('d-none').text(pesan);
            }

            function renderModal(data) {
                $content.find('.nama-institusi-pengaju').text(data.nama_institusi_pengaju);
                $content.find('.nama-pic-pengaju').text(data.nama_pic_pengaju || '-');
                $content.find('.nama-institusi-mitra').text(data.nama_institusi_mitra);
                $content.find('.nama-pic-mitra').text(data.nama_pic_mitra || '-');

                if (data.pic_pengaju_hadir_at) {
                    $content.find('.status-hadir-pengaju').html('<span class="badge bg-success">Sudah Hadir</span>');
                } else {
                    $content.find('.status-hadir-pengaju').html('<span class="badge bg-secondary">Belum Hadir</span>');
                }

                if (data.pic_mitra_hadir_at) {
                    $content.find('.status-hadir-mitra').html('<span class="badge bg-success">Sudah Hadir</span>');
                } else {
                    $content.find('.status-hadir-mitra').html('<span class="badge bg-secondary">Belum Hadir</span>');
                }

                var labelStatus = labelStatusAjuan[data.status_ajuan] || ['-', 'bg-secondary'];
                // attr('class', ...) dipakai (bukan removeClass() tanpa argumen)
                // supaya class penanda "status-ajuan-saat-ini" tetap ada untuk
                // render berikutnya — removeClass() tanpa argumen menghapus
                // semua class termasuk penanda ini, membuat elemen tidak
                // ditemukan lagi di render kedua dan seterusnya.
                $content.find('.status-ajuan-saat-ini').attr('class', 'badge status-ajuan-saat-ini ' + labelStatus[1]).text(labelStatus[0]);

                $loading.addClass('d-none');
                $content.removeClass('d-none');
            }

            function muatModal(token) {
                tokenAktif = token;
                $modal.find('.modal-alert').addClass('d-none').text('');
                $loading.removeClass('d-none');
                $content.addClass('d-none');
                $modal.modal('show');

                $.ajax({
                    url: detailSlotUrl,
                    method: 'GET',
                    data: { token: token },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    renderModal(res.data);
                })
                .fail(function (xhr) {
                    $loading.addClass('d-none');
                    tampilkanErrorModal(xhr);
                });
            }

            // Delegation dipasang ke tabel matrix (elemen yang pasti ada
            // selama halaman ini punya data), sesuai CONVENTIONS.md §6.8.
            $('.matrix-pertemuan-mou').on('click', '.btn-buka-modal-petugas', function () {
                muatModal($(this).data('token'));
            });

            function jalankanAksi(url, data, $btn, tampilkanSuksesSwal) {
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $.extend({ token: tokenAktif }, data),
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    adaPerubahan = true;
                    renderModal(res.data);

                    if (tampilkanSuksesSwal) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    }
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            }

            $modal.on('click', '.btn-hadir-pengaju', function () {
                jalankanAksi(hadirPengajuUrl, {}, $(this), false);
            });

            $modal.on('click', '.btn-hadir-mitra', function () {
                jalankanAksi(hadirMitraUrl, {}, $(this), false);
            });

            $modal.on('click', '.btn-ubah-hasil', function () {
                var statusAjuan = $(this).data('status');
                jalankanAksi(ubahHasilUrl, { status_ajuan: statusAjuan }, $(this), true);
            });

            $modal.on('hidden.bs.modal', function () {
                if (adaPerubahan) {
                    location.reload();
                }
            });
        });
    </script>
@endsection
