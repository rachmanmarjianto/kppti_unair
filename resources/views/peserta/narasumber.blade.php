@extends('layout.layout')

@section('title', 'Pengajuan Narasumber')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        #modal-pilih-sesi .modal-dialog { max-width: 95%; }
        #modal-pilih-sesi .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-pilih-sesi .form-label, #modal-pilih-sesi .form-check-label, #modal-pilih-sesi .text-muted { color: #0e1726 !important; }
        #modal-pilih-sesi .form-control { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }
        #modal-pilih-sesi .table { color: #0e1726 !important; }
        #modal-pilih-sesi .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
        #modal-pilih-sesi .form-check-input:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Menjadi Narasumber</li>
@endsection

@php
    $labelStatus = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Diterima', 'bg-success'],
        '6' => ['Ditolak', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Pengajuan Menjadi Narasumber</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.narasumber.pedoman') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-download me-1"></i> Pedoman Penulisan
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($narasumber)
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Status</div>
                        <div class="col-12 col-sm-10">
                            <span class="badge {{ $labelStatus[$narasumber->status_ajuan][1] ?? 'bg-secondary' }}">
                                {{ $labelStatus[$narasumber->status_ajuan][0] ?? '-' }}
                            </span>
                        </div>
                    </div>
                @endif

                @if($sedangDireview)
                    <div class="alert alert-info">
                        Pengajuan ini sedang direview oleh SC. Mohon tunggu keputusan sebelum dapat mengubah data.
                    </div>
                @endif

                @if($narasumber && ! $bisaEdit)
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Sesi</div>
                        <div class="col-12 col-sm-10">
                            @if($narasumber->acara_parent_tema)
                                {{ $narasumber->acara_parent_tema }} &mdash;
                            @endif
                            {{ $narasumber->acara_tema ?? '-' }}
                            @if($narasumber->acara_hari_ke)
                                (Hari {{ $narasumber->acara_hari_ke }}, {{ substr($narasumber->acara_jam_mulai, 0, 5) }}–{{ substr($narasumber->acara_jam_akhir, 0, 5) }})
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Subtema yang Diusulkan</div>
                        <div class="col-12 col-sm-10">{{ $narasumber->subtema ?? '-' }}</div>
                    </div>
                @endif

                @if($narasumber && $narasumber->status_ajuan === '2')
                    <button type="button" class="btn btn-outline-danger" id="btn-batalkan-ajuan">
                        <span class="btn-label">Batalkan Pengajuan, Kembali ke Draft</span>
                    </button>
                @endif

                @if($bisaEdit)
                    <form id="form-narasumber">
                        <div class="mb-3">
                            <label class="form-label">Sesi Acara</label>
                            <div class="d-flex align-items-center gap-2 border rounded p-2">
                                <span class="flex-grow-1" id="label-sesi-terpilih" style="color:black">
                                    @if($narasumber && $narasumber->idacara)
                                        @if($narasumber->acara_parent_tema)
                                            {{ $narasumber->acara_parent_tema }} &mdash;
                                        @endif
                                        {{ $narasumber->acara_tema }}
                                    @else
                                        Belum dipilih
                                    @endif
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-pilih-sesi">
                                    Pilih Sesi
                                </button>
                            </div>
                            <input type="hidden" name="idacara" id="input-idacara" value="{{ $narasumber->idacara ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-subtema">Subtema yang Diusulkan</label>
                            <input type="text" name="subtema" id="input-subtema" class="form-control" maxlength="255" value="{{ $narasumber->subtema ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-berkas">Extended Abstract (PDF/DOC/DOCX, maks. 10 MB)</label>
                            <input type="file" name="berkas" id="input-berkas" class="form-control" accept=".pdf,.doc,.docx">
                            @if($draftSaatIni && $draftSaatIni->file_path)
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Sudah ada file tersimpan —
                                    <a href="{{ route('peserta.narasumber.berkas') }}?token={{ $draftSaatIni->token }}" target="_blank">lihat file saat ini</a>.
                                    Biarkan kosong untuk tetap memakai file ini, atau pilih file baru untuk menggantinya.
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Extended Abstract wajib diunggah sebelum pengajuan dapat disimpan.
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-outline-primary" id="btn-simpan-draft">
                            <span class="btn-label">Simpan Draft</span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-ajukan">
                            <span class="btn-label">Ajukan</span>
                        </button>
                    </form>
                @endif

                @if($riwayat->isNotEmpty())
                    <hr class="mt-4">
                    <h5>Riwayat Pengajuan</h5>

                    <div class="accordion" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if(!$loop->last) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
                                        #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse @if($loop->last) show @endif" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('peserta.narasumber.berkas') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Extended Abstract
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan SC:</strong><br>{{ $baris->catatan }}</p>
                                        @endif

                                        @if($baris->kriteria->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Komponen Penilaian</th>
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

                                        @if($baris->reviewed_at)
                                            <p class="text-muted mb-0" style="font-size: 12.5px;">
                                                Direview pada {{ \Illuminate\Support\Carbon::parse($baris->reviewed_at)->format('d/m/Y H:i') }}.
                                            </p>
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

    {{-- Modal: pilih sesi acara (narasumber) --}}
    @if($bisaEdit)
        <div class="modal fade" id="modal-pilih-sesi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Sesi Acara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Tema</th>
                                        <th>Ruang</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($acaraOptions as $opsi)
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" name="pilih_idacara" class="form-check-input radio-pilih-sesi" value="{{ $opsi->idacara }}" @checked(($narasumber->idacara ?? null) == $opsi->idacara)>
                                            </td>
                                            <td>
                                                @if($opsi->parent_tema)
                                                    {{ $opsi->parent_tema }} <br>&mdash;
                                                @endif
                                                {{ $opsi->tema }}
                                            </td>
                                            <td>{{ $opsi->ruang ?? '-' }}</td>
                                            <td>{{ $opsi->hari_ke ?? '-' }}</td>
                                            <td>{{ $opsi->jam_mulai ? substr($opsi->jam_mulai, 0, 5).' - '.substr($opsi->jam_akhir, 0, 5) : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btn-konfirmasi-sesi">Pilih Sesi Ini</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var simpanDraftUrl = '{{ route('peserta.narasumber.simpan-draft') }}';
            var ajukanUrl = '{{ route('peserta.narasumber.ajukan') }}';
            var batalkanAjuanUrl = '{{ route('peserta.narasumber.batalkan-ajuan') }}';

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

            function sesiBelumDipilih() {
                if (! $('#input-idacara').val()) {
                    $('.page-alert').removeClass('d-none').text('Pilih sesi acara terlebih dahulu.');
                    return true;
                }
                return false;
            }

            function subtemaKosong() {
                if ($('#input-subtema').val().trim() === '') {
                    $('.page-alert').removeClass('d-none').text('Subtema tidak boleh kosong.');
                    return true;
                }
                return false;
            }

            $('#btn-konfirmasi-sesi').on('click', function () {
                var $radioTerpilih = $('.radio-pilih-sesi:checked');

                if ($radioTerpilih.length === 0) {
                    return;
                }

                $('#input-idacara').val($radioTerpilih.val());
                $('#label-sesi-terpilih').text($radioTerpilih.closest('tr').find('td').eq(1).text().trim());
                $('#modal-pilih-sesi').modal('hide');
            });

            function simpanDraft() {
                var formData = new FormData(document.getElementById('form-narasumber'));

                return $.ajax({
                    url: simpanDraftUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                });
            }

            $('#form-narasumber').on('submit', function (e) {
                e.preventDefault();

                $('.page-alert').addClass('d-none').text('');

                if (sesiBelumDipilih() || subtemaKosong()) {
                    return;
                }

                var $btn = $('#btn-simpan-draft');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                simpanDraft()
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(tampilkanError)
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
            });

            $('#btn-ajukan').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Setelah diajukan, pengajuan ini akan dikirim untuk direview SC. Ajukan sekarang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ajukan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    if (sesiBelumDipilih() || subtemaKosong()) {
                        return;
                    }

                    var $btn = $('#btn-ajukan');
                    var teksAwal = $btn.html();
                    $('#btn-simpan-draft, #btn-ajukan').prop('disabled', true);
                    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                    simpanDraft()
                        .then(function () {
                            return $.ajax({
                                url: ajukanUrl,
                                method: 'POST',
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
                            $('#btn-simpan-draft, #btn-ajukan').prop('disabled', false);
                            $btn.html(teksAwal);
                        });
                });
            });

            $('#btn-batalkan-ajuan').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Pengajuan akan dikembalikan ke Draft. Lanjutkan?',
                    icon: 'warning',
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
                        url: batalkanAjuanUrl,
                        method: 'POST',
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
            });
        });
    </script>
@endsection
