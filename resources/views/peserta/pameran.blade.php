@extends('layout.layout')

@section('title', 'Pengajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/editors/quill/quill.snow.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan Pameran</li>
@endsection

@php
    $labelStatus = [
        '1' => ['Draft', 'bg-secondary'],
        '2' => ['Menunggu Pembayaran / Antrean Review', 'bg-info'],
        '3' => ['Sedang Direview SC', 'bg-warning'],
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
                        <h4>Pengajuan Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($pameran)
                    <p>
                        Status saat ini:
                        <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                        </span>
                        @if($pameran->nomor_stand)
                            &mdash; Nomor Stand: <strong>{{ $pameran->nomor_stand }}</strong>
                        @endif
                    </p>
                @endif

                @if($sedangDireview)
                    <div class="alert alert-info">
                        Pengajuan ini sedang direview oleh SC. Mohon tunggu keputusan sebelum dapat mengubah data.
                    </div>
                @endif

                @if($bisaEdit)
                    <form id="form-pameran">
                        <div class="mb-3">
                            <label class="form-label" for="input-tema">Tema</label>
                            <input type="text" name="tema" id="input-tema" class="form-control" maxlength="255" value="{{ $pameran->tema ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-idpeserta-pic">PIC (Person in Charge)</label>
                            <select name="idpeserta_PIC" id="input-idpeserta-pic" class="form-control" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($pesertaOptions as $opsi)
                                    <option value="{{ $opsi->idpeserta }}" @selected(($pameran->idpeserta_PIC ?? null) == $opsi->idpeserta)>{{ $opsi->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Abstrak</label>
                            <div id="editor-abstract" style="height: 220px; background-color: #fff;">{!! $pameran->abstract ?? '' !!}</div>
                            <input type="hidden" name="abstract" id="input-abstract">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-portofolio">Portofolio (PDF/DOC/DOCX, maks. 5 MB)</label>
                            <input type="file" name="portofolio" id="input-portofolio" class="form-control" accept=".pdf,.doc,.docx">
                            @if($draftSaatIni && $draftSaatIni->file_path)
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Sudah ada file tersimpan —
                                    <a href="{{ route('peserta.pameran.portofolio') }}?token={{ $draftSaatIni->token }}" target="_blank">lihat file saat ini</a>.
                                    Biarkan kosong untuk tetap memakai file ini, atau pilih file baru untuk menggantinya.
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Portofolio wajib diunggah sebelum pengajuan dapat disimpan.
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
                                        Giliran #{{ $i + 1 }} &mdash;
                                        <span class="badge ms-2 {{ $labelStatus[$baris->status_ajuan][1] ?? 'bg-secondary' }}">
                                            {{ $labelStatus[$baris->status_ajuan][0] ?? '-' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="riwayat-{{ $i }}" class="accordion-collapse collapse @if($loop->last) show @endif" data-bs-parent="#accordion-riwayat">
                                    <div class="accordion-body">
                                        @if($baris->file_path)
                                            <p>
                                                <a href="{{ route('peserta.pameran.portofolio') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Portofolio
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan SC:</strong><br>{{ $baris->catatan }}</p>
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
            </div>
        </div>
    </div>
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
            var simpanDraftUrl = '{{ route('peserta.pameran.simpan-draft') }}';
            var ajukanUrl = '{{ route('peserta.pameran.ajukan') }}';

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
                    placeholder: 'Tuliskan abstrak pengajuan pameran...',
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

            $('#form-pameran').on('submit', function (e) {
                e.preventDefault();

                $('.page-alert').addClass('d-none').text('');

                if (quillAbstract.getText().trim() === '') {
                    $('.page-alert').removeClass('d-none').text('Abstrak tidak boleh kosong.');
                    return;
                }

                $('#input-abstract').val(quillAbstract.root.innerHTML);

                var $btn = $('#btn-simpan-draft');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                var formData = new FormData(this);

                $.ajax({
                    url: simpanDraftUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
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
                    text: 'Setelah diajukan, tagihan akan diterbitkan dan kontingen harus menyelesaikan pembayaran sebelum SC dapat mereview. Ajukan sekarang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ajukan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var $btn = $('#btn-ajukan');
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: ajukanUrl,
                        method: 'POST',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
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
            });
        });
    </script>
@endsection
