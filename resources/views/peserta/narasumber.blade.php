@extends('layout.layout')

@section('title', 'Pengajuan Narasumber')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/editors/quill/quill.snow.css') }}">

    <style>
        #modal-pilih-sesi .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-pilih-sesi .form-label, #modal-pilih-sesi .form-check-label, #modal-pilih-sesi .text-muted { color: #0e1726 !important; }
        #modal-pilih-sesi .form-control { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }
        #modal-pilih-sesi .table { color: #0e1726 !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Narasumber</li>
@endsection

@php
    $labelStatus = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
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
                        <h4>Pengajuan Narasumber</h4>
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
                        <div class="col-12 col-sm-2 fw-bold">Abstrak</div>
                        <div class="col-12 col-sm-10">{!! $narasumber->abstract !!}</div>
                    </div>

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
                        <div class="col-12 col-sm-2 fw-bold">Subtema</div>
                        <div class="col-12 col-sm-10">{{ $narasumber->subtema ?? '-' }}</div>
                    </div>
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
                            <label class="form-label" for="input-subtema">Subtema</label>
                            <input type="text" name="subtema" id="input-subtema" class="form-control" maxlength="255" value="{{ $narasumber->subtema ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Abstrak</label>
                            <div id="editor-abstract" style="height: 220px; background-color: #fff;">{!! $narasumber->abstract ?? '' !!}</div>
                            <input type="hidden" name="abstract" id="input-abstract">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-berkas">Berkas (PDF/DOC/DOCX, maks. 5 MB)</label>
                            <input type="file" name="berkas" id="input-berkas" class="form-control" accept=".pdf,.doc,.docx">
                            @if($draftSaatIni && $draftSaatIni->file_path)
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Sudah ada file tersimpan —
                                    <a href="{{ route('peserta.narasumber.berkas') }}?token={{ $draftSaatIni->token }}" target="_blank">lihat file saat ini</a>.
                                    Biarkan kosong untuk tetap memakai file ini, atau pilih file baru untuk menggantinya.
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Berkas wajib diunggah sebelum pengajuan dapat disimpan.
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
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Berkas
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan SC:</strong><br>{{ $baris->catatan }}</p>
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
                                                    {{ $opsi->parent_tema }} &mdash;
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
    @if($bisaEdit)
        <script src="{{ asset('src/plugins/src/editors/quill/quill.js') }}"></script>
    @endif

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var simpanDraftUrl = '{{ route('peserta.narasumber.simpan-draft') }}';
            var ajukanUrl = '{{ route('peserta.narasumber.ajukan') }}';

            @if($bisaEdit)
                var quillAbstract = new Quill('#editor-abstract', {
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['blockquote', 'link'],
                            ['clean'],
                        ],
                    },
                    placeholder: 'Tuliskan abstrak pengajuan narasumber...',
                    theme: 'snow',
                });
            @endif

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

            function abstrakKosong() {
                if (quillAbstract.getText().trim() === '') {
                    $('.page-alert').removeClass('d-none').text('Abstrak tidak boleh kosong.');
                    return true;
                }
                return false;
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
                $('#input-abstract').val(quillAbstract.root.innerHTML);

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

                if (sesiBelumDipilih() || subtemaKosong() || abstrakKosong()) {
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

                    if (sesiBelumDipilih() || subtemaKosong() || abstrakKosong()) {
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
        });
    </script>
@endsection
