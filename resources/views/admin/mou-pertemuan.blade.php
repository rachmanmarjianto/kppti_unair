@extends('layout.layout')

@section('title', 'Pertemuan MoU')

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
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pertemuan MoU</li>
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
                        <h4>Pertemuan MoU</h4>
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
                    <p class="text-muted mb-0">Belum ada data Tanggal MoU (aktif) atau Ruang MoU — tambahkan dulu di submenu terkait sebelum matrix slot bisa ditampilkan.</p>
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
                                                    <a href="{{ route('admin.mou.pengajuan.detail') }}?token={{ $sel->token }}" class="sel-terisi-link" title="Lihat detail pengajuan">
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
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var sesuaikanSlotUrl = '{{ route('admin.mou.pertemuan.sesuaikan-slot') }}';
            var baseUrl = '{{ route('admin.mou.pertemuan') }}';

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
        });
    </script>
@endsection
