@extends('layout.layout')

@section('title', 'Detail Pengajuan MoU')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-respon-ajuan .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-respon-ajuan .nav-tabs .nav-link.disabled { pointer-events: none; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peserta.mou.pengajuan') }}">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@php
    $labelStatusAjuan = [
        1 => ['Ajuan', 'bg-secondary'],
        2 => ['Temu Diskusi', 'bg-info'],
        3 => ['Tunda Lain Waktu', 'bg-warning'],
        4 => ['Terjalin', 'bg-success'],
        5 => ['Dibatalkan', 'bg-danger'],
    ];

    $waktuLokasi = $pertemuan && $pertemuan->tanggal
        ? \Carbon\Carbon::parse($pertemuan->tanggal)->translatedFormat('d M Y').' ('.substr($pertemuan->jam_mulai, 0, 5).'-'.substr($pertemuan->jam_akhir, 0, 5).') — '.$pertemuan->nama_ruang
        : '-';

    $catatan = $lampiranList->firstWhere('jenis_lampiran', 2);
    $fileList = $lampiranList->where('jenis_lampiran', 1);
@endphp

@section('content')
    {{-- Card 1: data pengajuan --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan MoU</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.mou.pengajuan') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Posisi Institusi Anda</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $pengajuan->posisi === 'Pengaju' ? 'bg-danger' : 'bg-success' }}">
                            {{ $pengajuan->posisi }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Ajuan</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatusAjuan[$pengajuan->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatusAjuan[$pengajuan->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Pengaju</div>
                    <div class="col-12 col-sm-9">{{ $pengajuan->nama_institusi_pengaju }} ({{ $pengajuan->nama_jenis_institusi_pengaju }})</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC Pengaju</div>
                    <div class="col-12 col-sm-9">
                        {{ $pengajuan->nama_pic_pengaju ?? '-' }}
                        @if($pengajuan->no_wa_pic_pengaju)
                            <span class="text-muted">({{ $pengajuan->no_wa_pic_pengaju }})</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Mitra</div>
                    <div class="col-12 col-sm-9">{{ $pengajuan->nama_institusi_mitra }} ({{ $pengajuan->nama_jenis_institusi_mitra }})</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC Mitra</div>
                    <div class="col-12 col-sm-9">
                        {{ $pengajuan->nama_pic_mitra ?? 'Belum ditentukan' }}
                        @if($pengajuan->no_wa_pic_mitra)
                            <span class="text-muted">({{ $pengajuan->no_wa_pic_mitra }})</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Waktu dan Lokasi</div>
                    <div class="col-12 col-sm-9">{{ $waktuLokasi }}</div>
                </div>

                @if($bisaRespon || $bisaBatalkan)
                    <div class="row">
                        <div class="col-12 col-sm-9 offset-sm-3">
                            @if($bisaRespon)
                                <button type="button" class="btn btn-success" id="btn-respon-ajuan">
                                    <i class="fa-solid fa-reply me-1"></i> Respon Ajuan
                                </button>
                            @endif
                            @if($bisaBatalkan)
                                <button type="button" class="btn btn-danger" id="btn-batalkan-ajuan">
                                    <i class="fa-solid fa-ban me-1"></i> Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Card 2: lampiran --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Lampiran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <label class="form-label fw-bold">Catatan</label>
                @if($catatan && $catatan->catatan)
                    <div class="mb-3">{!! $catatan->catatan !!}</div>
                @else
                    <p class="text-muted mb-3">Tidak ada catatan.</p>
                @endif

                <label class="form-label fw-bold">File</label>
                @if($fileList->isEmpty())
                    <p class="text-muted mb-0">Tidak ada file lampiran.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tujuan File</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fileList as $file)
                                    <tr>
                                        <td>{{ $file->catatan ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('peserta.mou.pengajuan.lampiran') }}?token={{ $file->token }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-file-arrow-down me-1"></i> Unduh
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Card 3: riwayat status --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Riwayat Status</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Oleh</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatStatus as $riwayat)
                                <tr>
                                    <td>
                                        <span class="badge {{ $labelStatusAjuan[$riwayat->status][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatusAjuan[$riwayat->status][0] ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $riwayat->nama_done_by ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->done_at)->translatedFormat('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada riwayat status.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($bisaRespon)
        {{-- Modal: Respon Ajuan (Temu Diskusi / Tunda Lain Waktu) --}}
        <div class="modal fade" id="modal-respon-ajuan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Respon Ajuan MoU</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-response-btn" data-bs-toggle="tab" data-bs-target="#tab-response" type="button" role="tab">Response</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link disabled" id="tab-jadwal-btn" data-bs-toggle="tab" data-bs-target="#tab-jadwal" type="button" role="tab">Pilih PIC & Jadwal</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- Tab 1: Response --}}
                            <div class="tab-pane fade show active" id="tab-response" role="tabpanel">
                                <p>Pilih respon Anda terhadap pengajuan MoU ini:</p>
                                <button type="button" class="btn btn-success" id="btn-temu-diskusi">
                                    <i class="fa-solid fa-handshake me-1"></i> Temu Diskusi
                                </button>
                                <button type="button" class="btn btn-danger" id="btn-tunda-ajuan">
                                    <i class="fa-solid fa-clock me-1"></i> Tunda Lain Waktu
                                </button>
                            </div>

                            {{-- Tab 2: Pilih PIC & Jadwal --}}
                            <div class="tab-pane fade" id="tab-jadwal" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label" for="input-pic-mitra">PIC (Institusi Anda)</label>
                                    <select id="input-pic-mitra" class="form-select">
                                        <option value="">-- Pilih PIC --</option>
                                        @foreach($pesertaOptionsMitra as $opsi)
                                            <option value="{{ $opsi->idpengguna }}">{{ $opsi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-tanggal-mou">Tanggal</label>
                                    <select id="input-tanggal-mou" class="form-select">
                                        <option value="">-- Pilih Tanggal --</option>
                                        @foreach($tanggalAktifList as $tanggal)
                                            <option value="{{ $tanggal->idtanggal_mou }}">{{ \Carbon\Carbon::parse($tanggal->tanggal)->translatedFormat('d M Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label" for="input-sesi-mou">Sesi</label>
                                    <select id="input-sesi-mou" class="form-select" disabled>
                                        <option value="">-- Pilih PIC & Tanggal dahulu --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btn-submit-temu-diskusi" disabled>
                            <span class="btn-label">Konfirmasi Temu Diskusi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@if($bisaRespon || $bisaBatalkan)
    @section('page-js')
        <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
        <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            $(function () {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var token = '{{ $token }}';

                @if($bisaBatalkan)
                    var batalkanUrl = '{{ route('peserta.mou.pengajuan.batalkan') }}';

                    $('#btn-batalkan-ajuan').on('click', function () {
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: 'Yakin ingin membatalkan pengajuan MoU ini?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, batalkan',
                            cancelButtonText: 'Tidak',
                        }).then(function (result) {
                            if (!result.isConfirmed) {
                                return;
                            }

                            var $btn = $('#btn-batalkan-ajuan');
                            var teksAwal = $btn.html();
                            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                            $.ajax({
                                url: batalkanUrl,
                                method: 'POST',
                                data: { token: token },
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
                                Swal.fire({ icon: 'error', title: 'Gagal', text: pesan }).then(function () {
                                    location.reload();
                                });
                            });
                        });
                    });
                @endif

                @if($bisaRespon)
                var tundaUrl = '{{ route('peserta.mou.pengajuan.tunda') }}';
                var opsiSesiUrl = '{{ route('peserta.mou.pengajuan.opsi-sesi') }}';
                var responUrl = '{{ route('peserta.mou.pengajuan.respon-temu-diskusi') }}';

                var $modal = $('#modal-respon-ajuan');

                function tampilkanError(xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    } else if (res.errors) {
                        pesan = Object.values(res.errors).flat().join('\n');
                    }
                    $modal.find('.modal-alert').removeClass('d-none').text(pesan);
                }

                function resetModal() {
                    $modal.find('.modal-alert').addClass('d-none').text('');
                    $('#tab-jadwal-btn').addClass('disabled');
                    (new bootstrap.Tab(document.getElementById('tab-response-btn'))).show();
                    $('#input-pic-mitra').val('');
                    $('#input-tanggal-mou').val('');
                    $('#input-sesi-mou').html('<option value="">-- Pilih PIC & Tanggal dahulu --</option>').prop('disabled', true);
                    $('#btn-submit-temu-diskusi').prop('disabled', true);
                }

                $('#btn-respon-ajuan').on('click', function () {
                    resetModal();
                    $modal.modal('show');
                });

                $('#btn-tunda-ajuan').on('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Yakin ingin menunda pengajuan ini ke lain waktu?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, tunda',
                        cancelButtonText: 'Batal',
                    }).then(function (result) {
                        if (!result.isConfirmed) {
                            return;
                        }

                        $.ajax({
                            url: tundaUrl,
                            method: 'POST',
                            data: { token: token },
                            dataType: 'json',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                        })
                        .done(function (res) {
                            $modal.modal('hide');
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                                location.reload();
                            });
                        })
                        .fail(tampilkanError);
                    });
                });

                $('#btn-temu-diskusi').on('click', function () {
                    $('#tab-jadwal-btn').removeClass('disabled');
                    (new bootstrap.Tab(document.getElementById('tab-jadwal-btn'))).show();
                });

                function muatOpsiSesi() {
                    var idPic = $('#input-pic-mitra').val();
                    var idTanggal = $('#input-tanggal-mou').val();
                    var $selectSesi = $('#input-sesi-mou');

                    $selectSesi.html('<option value="">-- Pilih PIC & Tanggal dahulu --</option>').prop('disabled', true);
                    $('#btn-submit-temu-diskusi').prop('disabled', true);

                    if (!idPic || !idTanggal) {
                        return;
                    }

                    $selectSesi.html('<option value="">Memuat...</option>');

                    $.ajax({
                        url: opsiSesiUrl,
                        method: 'GET',
                        data: { token: token, idpic_institusi_mitra: idPic, idtanggal_mou: idTanggal },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        var sesiList = res.data || [];
                        $selectSesi.empty();

                        if (sesiList.length === 0) {
                            $selectSesi.append('<option value="">Tidak ada sesi tersedia</option>');
                            $selectSesi.prop('disabled', true);
                            return;
                        }

                        $selectSesi.append('<option value="">-- Pilih Sesi --</option>');
                        $.each(sesiList, function (i, sesi) {
                            var label = sesi.jam_mulai.substring(0, 5) + '-' + sesi.jam_akhir.substring(0, 5);
                            $selectSesi.append('<option value="' + sesi.idsesi_mou + '">' + label + '</option>');
                        });
                        $selectSesi.prop('disabled', false);
                    })
                    .fail(function (xhr) {
                        $selectSesi.html('<option value="">Gagal memuat sesi</option>');
                        tampilkanError(xhr);
                    });
                }

                $modal.on('change', '#input-pic-mitra, #input-tanggal-mou', muatOpsiSesi);

                $modal.on('change', '#input-sesi-mou', function () {
                    var siap = $('#input-pic-mitra').val() && $('#input-tanggal-mou').val() && $(this).val();
                    $('#btn-submit-temu-diskusi').prop('disabled', !siap);
                });

                $('#btn-submit-temu-diskusi').on('click', function () {
                    var $btn = $(this);
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $modal.find('.modal-alert').addClass('d-none').text('');

                    $.ajax({
                        url: responUrl,
                        method: 'POST',
                        data: {
                            token: token,
                            idpic_institusi_mitra: $('#input-pic-mitra').val(),
                            idtanggal_mou: $('#input-tanggal-mou').val(),
                            idsesi_mou: $('#input-sesi-mou').val(),
                        },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        $modal.modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        if (xhr.status === 409) {
                            $modal.modal('hide');
                            var pesan409 = (xhr.responseJSON || {}).message || 'Meja pada sesi ini sudah penuh.';
                            Swal.fire({ icon: 'error', title: 'Gagal', text: pesan409 }).then(function () {
                                location.reload();
                            });
                            return;
                        }

                        tampilkanError(xhr);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
                @endif
            });
        </script>
    @endsection
@endif
