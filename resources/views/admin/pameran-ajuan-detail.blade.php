@extends('layout.layout')

@section('title', 'Detail Ajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-ubah-kluster .modal-content {
            background-color: #ffffff !important;
            color: #0e1726 !important;
        }

        #modal-ubah-kluster .form-label,
        #modal-ubah-kluster .text-muted {
            color: #0e1726 !important;
        }

        #modal-ubah-kluster .form-select {
            background-color: #ffffff !important;
            color: #0e1726 !important;
            border-color: #e0e6ed !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pameran.ajuan') }}">Ajuan Pameran</a></li>
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
                        <a href="{{ route('admin.pameran.ajuan') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_institusi }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Jenis Institusi</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_jenis_institusi }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">PIC</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nama_pic }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Tema</div>
                    <div class="col-12 col-sm-9">{{ $pameran->tema }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Kluster Pameran</div>
                    <div class="col-12 col-sm-9">
                        {{ $pameran->nomor_kluster ? 'Kluster '.$pameran->nomor_kluster.' — '.$pameran->tema_kluster : '-' }}
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#modal-ubah-kluster">
                            <i class="fa-solid fa-pen"></i> Ubah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Risalah Singkat Pameran</div>
                    <div class="col-12 col-sm-9">{!! $pameran->abstract !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Form Keikutsertaan (berkas pertama)</div>
                    <div class="col-12 col-sm-9">
                        @if($pameran->file_path_pertama)
                            <a href="{{ route('admin.pameran.ajuan.file-pertama') }}?token={{ $token }}" target="_blank">
                                <i class="fa-solid fa-file-arrow-down"></i> Lihat berkas pertama
                            </a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nomor Stand</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nomor_stand }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nilai Final / Selisih Nilai</div>
                    <div class="col-12 col-sm-9">{{ $pameran->nilai_final ?? '-' }} / {{ $pameran->selisih_nilai ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Saat Ini</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2 & 3: riwayat per reviewer, read-only — 2 thread independen
         (dikonfirmasi developer), masing-masing bisa null kalau Admin
         belum memetakan reviewer di slot itu. --}}
    @foreach([1 => $reviewer1, 2 => $reviewer2] as $reviewerKe => $reviewer)
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4>Riwayat Reviewer {{ $reviewerKe }}@if($reviewer) &mdash; {{ $reviewer['namaSc'] }}@endif</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    @if(! $reviewer)
                        <p class="text-muted mb-0">Reviewer belum ditugaskan Admin.</p>
                    @elseif($reviewer['riwayat']->isEmpty())
                        <p class="text-muted mb-0">Reviewer belum mulai review.</p>
                    @else
                        <div class="accordion" id="accordion-riwayat-{{ $reviewerKe }}">
                            @foreach($reviewer['riwayat'] as $i => $baris)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button @if(! $loop->last) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $reviewerKe }}-{{ $i }}">
                                            #{{ $i + 1 }} &mdash;
                                            <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                                {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="riwayat-{{ $reviewerKe }}-{{ $i }}" class="accordion-collapse collapse @if($loop->last) show @endif" data-bs-parent="#accordion-riwayat-{{ $reviewerKe }}">
                                        <div class="accordion-body">
                                            @if($baris->file_path)
                                                <p>
                                                    <a href="{{ route('admin.pameran.ajuan.portofolio') }}?token={{ $baris->token }}" target="_blank">
                                                        <i class="fa-solid fa-file-arrow-down"></i> Lihat Form Keikutsertaan
                                                    </a>
                                                </p>
                                            @endif

                                            @if($baris->catatan)
                                                <p><strong>Catatan SC:</strong><br>{{ $baris->catatan }}</p>
                                            @endif

                                            @if($baris->catatan_peserta)
                                                <p><strong>Catatan Peserta:</strong><br>{{ $baris->catatan_peserta }}</p>
                                            @endif

                                            @if($baris->kriteria->isNotEmpty())
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
                                                                <td>{{ $k->nama_topik }}</td>
                                                                <td>{{ $k->isi_review ?? '-' }}</td>
                                                                <td class="text-center">{{ $k->bobot_dlm_persen }}%</td>
                                                                <td class="text-center">{{ $k->nilai ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <p class="fw-bold mb-0">Nilai Akhir: {{ $baris->nilai_akhir ?? '-' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal: ubah kluster pameran --}}
    <div class="modal fade" id="modal-ubah-kluster" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Kluster Pameran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Mengubah kluster akan membatalkan tagihan saat ini (walau sudah Lunas) dan membuat tagihan baru sesuai kluster yang dipilih.</p>
                    <label for="input-ubah-kluster" class="form-label">Kluster Baru</label>
                    <select id="input-ubah-kluster" class="form-select">
                        @foreach($klusterOptions as $k)
                            <option value="{{ $k->idkluster_pameran }}" @selected((int) $pameran->idkluster_pameran === $k->idkluster_pameran)>
                                Kluster {{ $k->nomor_kluster }} &mdash; {{ $k->tema_kluster }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-simpan-ubah-kluster">Simpan</button>
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
            var ubahKlusterUrl = '{{ route('admin.pameran.ajuan.ubah-kluster') }}';
            var idpameran = {{ $pameran->idpameran }};

            $('#btn-simpan-ubah-kluster').on('click', function () {
                var idklusterBaru = $('#input-ubah-kluster').val();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Kluster akan diubah, tagihan lama (walau sudah Lunas) akan dibatalkan dan tagihan baru dibuat sesuai kluster baru. Lanjutkan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var $btn = $('#btn-simpan-ubah-kluster');
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                    $.ajax({
                        url: ubahKlusterUrl,
                        method: 'POST',
                        data: { idpameran: idpameran, idkluster_pameran: idklusterBaru },
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
                        Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
