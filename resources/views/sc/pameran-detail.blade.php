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
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Memenuhi', 'bg-success'],
        '6' => ['Tidak Memenuhi', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
        '9' => ['Terpilih', 'bg-success'],
    ];
@endphp

@section('content')
    {{-- Card 1: data pengajuan pameran --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan Pameran</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('sc.pameran') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Asal</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_institusi }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Jenis Institusi</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_jenis_institusi }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_pic ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Saat Ini</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Tema</div>
                    <div class="col-12 col-sm-9">{{ $pameran->tema }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Kluster Pameran</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nomor_kluster ? 'Kluster '.$pameran->nomor_kluster.' — '.$pameran->tema_kluster : '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Risalah Singkat Pameran</div>
                    <div class="col-12 col-sm-9">{!! $pameran->abstract !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Form Keikutsertaan (berkas pertama)</div>
                    <div class="col-12 col-sm-9">
                        @if($pameran->file_path_pertama)
                            <a href="{{ route('sc.pameran.file-pertama') }}?token={{ $token }}" target="_blank">
                                <i class="fa-solid fa-file-arrow-down"></i> Lihat berkas pertama
                            </a>
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: riwayat thread sendiri + aksi review --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4>Riwayat Review Saya</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($riwayat->isEmpty())
                    <p class="text-muted mb-0">Belum ada riwayat.</p>
                @else
                    <div class="accordion mb-4" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            @php $iniAktif = $reviewAktif && $baris->idreview === $reviewAktif->idreview; @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if(! $iniAktif) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
                                        #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse @if($iniAktif) show @endif" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('sc.pameran.portofolio') }}?token={{ $baris->token }}" target="_blank" style="color:green">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Form Keikutsertaan
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan Saya:</strong><br>{{ $baris->catatan }}</p>
                                        @endif

                                        @if($baris->catatan_peserta)
                                            <p><strong>Catatan Peserta:</strong><br>{{ $baris->catatan_peserta }}</p>
                                        @endif

                                        @if($baris->kriteria->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Topik</th>
                                                            <th>Komentar</th>
                                                            <th class="text-center">Bobot</th>
                                                            <th class="text-center">Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($baris->kriteria as $k)
                                                            <tr>
                                                                <td class="text-nowrap">{{ $k->nama_topik }}</td>
                                                                <td class="text-nowrap">{{ $k->isi_review ?? '-' }}</td>
                                                                <td class="text-center text-nowrap">{{ $k->bobot_dlm_persen }}%</td>
                                                                <td class="text-center text-nowrap">{{ $k->nilai ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p class="fw-bold mb-0">Nilai Akhir: {{ $baris->nilai_akhir ?? '-' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($mulaiReviewDiperlukan)
                    <hr>
                    <button type="button" class="btn btn-primary" id="btn-mulai-review">
                        <span class="btn-label">Mulai Review</span>
                    </button>
                @elseif($reviewAktif)
                    <hr>
                    <h5>Beri Review</h5>

                    @foreach($topikAktif as $topik)
                        @php $skor = $skorSaatIni->get($topik->idtopik_review); @endphp
                        <div class="mb-4 border rounded p-3">
                            <label class="form-label fw-bold">{{ $topik->nama_topik }} <span class="text-muted">(bobot {{ $topik->bobot_dlm_persen }}%)</span></label>
                            @if($topik->petunjuk)
                                <p class="text-muted mb-2" style="font-size: 12.5px;">{{ $topik->petunjuk }}</p>
                            @endif
                            <textarea class="form-control input-komentar-topik" data-idtopik="{{ $topik->idtopik_review }}" rows="3" placeholder="Komentar untuk topik ini">{{ $skor->isi_review ?? '' }}</textarea>
                            <div class="mt-2" style="max-width: 160px;">
                                <label class="form-label" style="font-size: 12.5px;">Nilai (0-100)</label>
                                <input type="number" class="form-control input-nilai-topik" data-idtopik="{{ $topik->idtopik_review }}" min="0" max="100" value="{{ $skor->nilai ?? '' }}">
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label" for="input-catatan">Catatan</label>
                        <textarea id="input-catatan" class="form-control" rows="4">{{ $reviewAktif->catatan }}</textarea>
                    </div>

                    <button type="button" class="btn btn-outline-secondary" id="btn-simpan-draft-review">
                        <span class="btn-label">Simpan Draft Review</span>
                    </button>
                    <button type="button" class="btn btn-warning btn-keputusan" id="btn-revisi" disabled>
                        <span class="btn-label">Revisi</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-keputusan" id="btn-tidak-memenuhi" disabled>
                        <span class="btn-label">Tidak Memenuhi</span>
                    </button>
                    <button type="button" class="btn btn-success btn-keputusan" id="btn-memenuhi" disabled>
                        <span class="btn-label">Memenuhi</span>
                    </button>
                    <p id="peringatan-nilai-belum-lengkap" class="text-danger mt-2 mb-0" style="font-size: 12.5px;">
                        Mohon memberi nilai untuk semua komponen penilaian terlebih dahulu
                    </p>
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
            var tokenPameran = '{{ $token }}';
            var mulaiReviewUrl = '{{ route('sc.pameran.mulai-review') }}';
            var simpanReviewUrl = '{{ route('sc.pameran.simpan-review') }}';
            var kirimKeputusanUrl = '{{ route('sc.pameran.kirim-keputusan') }}';
            var idreview = {{ $reviewAktif->idreview ?? 'null' }};

            function tampilkanError(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $('.page-alert').removeClass('d-none').text(pesan);

                if (xhr.status === 409) {
                    setTimeout(function () { location.reload(); }, 1500);
                }
            }

            $('#btn-mulai-review').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: mulaiReviewUrl,
                    method: 'POST',
                    data: { token: tokenPameran },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        location.reload();
                    });
                })
                .fail(function (xhr) {
                    tampilkanError(xhr);
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            function setButtonsDisabled(disabled) {
                $('#btn-simpan-draft-review').prop('disabled', disabled);
                $('.btn-keputusan').prop('disabled', disabled || ! semuaTopikLengkap());
            }

            function kumpulkanTopik() {
                var topik = {};

                $('.input-komentar-topik').each(function () {
                    var idtopik = $(this).data('idtopik');
                    topik[idtopik] = topik[idtopik] || {};
                    topik[idtopik].isi_review = $(this).val();
                });

                $('.input-nilai-topik').each(function () {
                    var idtopik = $(this).data('idtopik');
                    topik[idtopik] = topik[idtopik] || {};
                    topik[idtopik].nilai = $(this).val();
                });

                return topik;
            }

            function semuaTopikLengkap() {
                var lengkap = true;

                $('.input-nilai-topik').each(function () {
                    if ($(this).val().trim() === '') {
                        lengkap = false;
                    }
                });

                return lengkap;
            }

            function perbaruiStatusTombolKeputusan() {
                var lengkap = semuaTopikLengkap();
                $('.btn-keputusan').prop('disabled', ! lengkap);
                $('#peringatan-nilai-belum-lengkap').toggleClass('d-none', lengkap);
            }

            $('.input-komentar-topik, .input-nilai-topik').on('input', perbaruiStatusTombolKeputusan);
            perbaruiStatusTombolKeputusan();

            $('#btn-simpan-draft-review').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                setButtonsDisabled(true);
                $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: simpanReviewUrl,
                    method: 'POST',
                    data: {
                        idreview: idreview,
                        catatan: $('#input-catatan').val(),
                        topik: kumpulkanTopik(),
                    },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        location.reload();
                    });
                })
                .fail(function (xhr) {
                    tampilkanError(xhr);
                    setButtonsDisabled(false);
                    $btn.html(teksAwal);
                });
            });

            function kirimKeputusan(keputusan, labelKonfirmasi, teksKonfirmasi) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: teksKonfirmasi,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    setButtonsDisabled(true);
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: simpanReviewUrl,
                        method: 'POST',
                        data: {
                            idreview: idreview,
                            catatan: $('#input-catatan').val(),
                            topik: kumpulkanTopik(),
                        },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .then(function () {
                        return $.ajax({
                            url: kirimKeputusanUrl,
                            method: 'POST',
                            data: {
                                idreview: idreview,
                                keputusan: keputusan,
                                catatan: $('#input-catatan').val(),
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
                    .fail(function (xhr) {
                        tampilkanError(xhr);
                        setButtonsDisabled(false);
                    });
                });
            }

            $('#btn-revisi').on('click', function () {
                kirimKeputusan('4', 'Revisi', 'Kirim keputusan Revisi untuk pengajuan ini? Pastikan semua topik sudah diisi lengkap.');
            });
            $('#btn-tidak-memenuhi').on('click', function () {
                kirimKeputusan('6', 'Tidak Memenuhi', 'Tidak memenuhi akan mengakibatkan pengajuan ditolak. Lanjutkan?');
            });
            $('#btn-memenuhi').on('click', function () {
                kirimKeputusan('5', 'Memenuhi', 'Kirim keputusan Memenuhi untuk pengajuan ini? Pastikan semua topik sudah diisi lengkap.');
            });
        });
    </script>
@endsection
