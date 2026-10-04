@extends('layout.layout')

@section('title', 'Detail Pengajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sc.pameran') }}">Pengajuan Pameran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@php
    $labelStatus = [
        '2' => ['Menunggu Klaim', 'bg-info'],
        '3' => ['Sedang Direview', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>{{ $pameran->tema }}</h4>
                        <p class="text-muted mb-0">
                            {{ $pameran->nama_institusi }}
                            @if($pameran->nama_pic)
                                &mdash; PIC: {{ $pameran->nama_pic }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p>
                    Status saat ini:
                    <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                        {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                    </span>
                </p>

                <div class="mb-3">
                    <strong>Abstrak:</strong>
                    <div class="mt-1">{!! $pameran->abstract !!}</div>
                </div>

                @if($pameran->status_ajuan === '3' && ! $reviewAktif)
                    <div class="alert alert-info">
                        Ada SC lain yang sedang mereview pengajuan ini. Isi review belum bisa ditampilkan.
                    </div>
                @endif

                @if($riwayat->isNotEmpty())
                    <hr class="mt-4">
                    <h5>Riwayat</h5>

                    <div class="accordion" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
                                        Giliran #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('sc.pameran.portofolio') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Portofolio
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan:</strong><br>{{ $baris->catatan }}</p>
                                        @endif

                                        @if($baris->kriteria->isNotEmpty())
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Kriteria</th>
                                                        <th>Catatan</th>
                                                        <th>Memenuhi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($baris->kriteria as $k)
                                                        <tr>
                                                            <td>{{ $k->nama_topik }}</td>
                                                            <td>{{ $k->isi_review }}</td>
                                                            <td>
                                                                @if($k->memenuhi)
                                                                    <span class="badge bg-success">Ya</span>
                                                                @else
                                                                    <span class="badge bg-danger">Tidak</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($reviewAktif)
                    <hr class="mt-4">
                    <h5>Form Penilaian</h5>

                    @if($reviewAktif->file_path)
                        <p>
                            <a href="{{ route('sc.pameran.portofolio') }}?token={{ $reviewAktif->token }}" target="_blank">
                                <i class="fa-solid fa-file-arrow-down"></i> Lihat Portofolio
                            </a>
                        </p>
                    @endif

                    <form id="form-review">
                        <input type="hidden" name="idreview" value="{{ $reviewAktif->idreview }}">

                        <div class="mb-3">
                            <label class="form-label">Catatan Umum (opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ $reviewAktif->catatan }}</textarea>
                        </div>

                        @foreach($topikAktif as $topik)
                            @php $skor = $skorSaatIni->get($topik->idtopik_review); @endphp
                            <div class="mb-3 border rounded p-3">
                                <label class="form-label fw-bold">{{ $topik->nama_topik }}</label>
                                @if($topik->petunjuk)
                                    <div class="text-muted mb-2" style="font-size: 12.5px;">{{ $topik->petunjuk }}</div>
                                @endif
                                <textarea name="kriteria[{{ $topik->idtopik_review }}][isi_review]" class="form-control mb-2" rows="2" placeholder="Catatan untuk kriteria ini">{{ $skor->isi_review ?? '' }}</textarea>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="kriteria[{{ $topik->idtopik_review }}][memenuhi]" value="1" id="memenuhi-{{ $topik->idtopik_review }}" @checked($skor->memenuhi ?? false)>
                                    <label class="form-check-label" for="memenuhi-{{ $topik->idtopik_review }}">Memenuhi kriteria ini</label>
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-outline-primary" id="btn-simpan-review">
                            <span class="btn-label">Simpan Draft Review</span>
                        </button>
                        <button type="button" class="btn btn-warning btn-keputusan" data-keputusan="4">Revisi</button>
                        <button type="button" class="btn btn-success btn-keputusan" data-keputusan="5">Diterima</button>
                        <button type="button" class="btn btn-danger btn-keputusan" data-keputusan="6">Ditolak</button>
                    </form>
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
            var simpanReviewUrl = '{{ route('sc.pameran.simpan-review') }}';
            var kirimKeputusanUrl = '{{ route('sc.pameran.kirim-keputusan') }}';

            function tampilkanError(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $('.page-alert').removeClass('d-none').text(pesan);
            }

            function simpanReview() {
                return $.ajax({
                    url: simpanReviewUrl,
                    method: 'POST',
                    data: $('#form-review').serialize(),
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                });
            }

            $('#form-review').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('#btn-simpan-review');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                simpanReview()
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    })
                    .fail(tampilkanError)
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
            });

            $('.btn-keputusan').on('click', function () {
                var $btn = $(this);
                var keputusan = $btn.data('keputusan');
                var labelKeputusan = { 4: 'Revisi', 5: 'Diterima', 6: 'Ditolak' }[keputusan];

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Kirim keputusan "' + labelKeputusan + '" untuk pengajuan ini? Pastikan ke-4 kriteria sudah diisi lengkap.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.btn-keputusan, #btn-simpan-review').prop('disabled', true);
                    var teksAwal = $btn.html();
                    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    simpanReview()
                        .then(function () {
                            return $.ajax({
                                url: kirimKeputusanUrl,
                                method: 'POST',
                                data: {
                                    idreview: $('input[name="idreview"]').val(),
                                    keputusan: keputusan,
                                    catatan: $('textarea[name="catatan"]').val(),
                                },
                                dataType: 'json',
                                headers: { 'X-CSRF-TOKEN': csrfToken },
                            });
                        })
                        .done(function (res) {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                                location.reload();
                            });
                        })
                        .fail(tampilkanError)
                        .always(function () {
                            $('.btn-keputusan, #btn-simpan-review').prop('disabled', false);
                            $btn.html(teksAwal);
                        });
                });
            });
        });
    </script>
@endsection
