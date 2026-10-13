@extends('layout.layout')

@section('title', 'Beri Review Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/editors/quill/quill.snow.css') }}">
@endsection

@php
    $labelStatusPenilaian = [
        '4' => 'Revisi',
        '5' => 'Diterima',
        '6' => 'Ditolak',
    ];
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sc.pameran') }}">Pengajuan Pameran</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sc.pameran.detail') }}?token={{ $tokenPameran }}">Detail</a></li>
    <li class="breadcrumb-item active" aria-current="page">Beri Review</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Beri Review &mdash; {{ $pameran->tema }}</h4>
                        <p class="text-muted mb-0">
                            {{ $pameran->nama_institusi }}
                            @if($pameran->nama_pic)
                                &mdash; PIC: {{ $pameran->nama_pic }}
                            @endif
                        </p>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('sc.pameran.detail') }}?token={{ $tokenPameran }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Detail
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="mb-3">
                    <strong>Extended Abstrak:</strong>
                    <div class="mt-1">{!! $pameran->abstract !!}</div>
                </div>

                @if($review->file_path)
                    <p>
                        <a href="{{ route('sc.pameran.portofolio') }}?token={{ $token }}" target="_blank">
                            <i class="fa-solid fa-file-arrow-down"></i> Lihat Portofolio
                        </a>
                    </p>
                @endif

                @if($penilaianSebelumnya->isNotEmpty())
                    <div class="mb-4 border rounded p-3 bg-light">
                        <label class="form-label fw-bold">Salin Nilai dari Penilaian Sebelumnya</label>
                        <div class="text-muted mb-2" style="font-size: 12.5px;">
                            Mengisi ulang keempat kriteria dengan nilai dari penilaian yang dipilih — isian yang sedang diketik akan tertimpa.
                        </div>
                        <div class="d-flex gap-2">
                            <select id="pilih-penilaian-salin" class="form-control">
                                <option value="">-- Pilih Penilaian --</option>
                                @foreach($penilaianSebelumnya as $p)
                                    <option value="{{ $p['idreview'] }}">
                                        Penilaian #{{ $p['nomorPenilaian'] }} ({{ $labelStatusPenilaian[$p['statusAjuan']] ?? $p['statusAjuan'] }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-secondary text-nowrap" id="btn-salin-penilaian">
                                <i class="fa-solid fa-copy me-1"></i> Salin
                            </button>
                        </div>
                    </div>
                @endif

                <form id="form-review">
                    <input type="hidden" name="idreview" value="{{ $review->idreview }}">

                    <div class="mb-4">
                        <label class="form-label">Catatan Umum (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ $review->catatan }}</textarea>
                    </div>

                    @foreach($topikAktif as $topik)
                        @php $skor = $skorSaatIni->get($topik->idtopik_review); @endphp
                        <div class="mb-4 border rounded p-3">
                            <label class="form-label fw-bold">{{ $topik->nama_topik }}</label>
                            <div id="editor-kriteria-{{ $topik->idtopik_review }}" class="bg-white" style="height: 180px;">
                                {!! $skor ? $skor->isi_review : $topik->petunjuk !!}
                            </div>
                            <input type="hidden" name="kriteria[{{ $topik->idtopik_review }}][isi_review]" id="input-kriteria-{{ $topik->idtopik_review }}">
                            <div class="form-check form-switch mt-2">
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
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/editors/quill/quill.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var simpanReviewUrl = '{{ route('sc.pameran.simpan-review') }}';
            var kirimKeputusanUrl = '{{ route('sc.pameran.kirim-keputusan') }}';
            var detailUrl = '{{ route('sc.pameran.detail') }}?token={{ $tokenPameran }}';

            var quillKriteria = {};
            @foreach($topikAktif as $topik)
                quillKriteria[{{ $topik->idtopik_review }}] = new Quill('#editor-kriteria-{{ $topik->idtopik_review }}', {
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['blockquote', 'link'],
                            ['clean'],
                        ],
                    },
                    theme: 'snow',
                });
            @endforeach

            var skorPenilaianSebelumnya = @json($skorPenilaianSebelumnya);

            $('#btn-salin-penilaian').on('click', function () {
                var idreview = $('#pilih-penilaian-salin').val();

                if (! idreview) {
                    return;
                }

                var skorPenilaian = skorPenilaianSebelumnya[idreview] || {};

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Isian keempat kriteria yang sedang diketik akan tertimpa dengan nilai dari penilaian terpilih. Lanjutkan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, salin',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (! result.isConfirmed) {
                        return;
                    }

                    $.each(quillKriteria, function (idtopik, quill) {
                        var skor = skorPenilaian[idtopik];

                        if (skor) {
                            quill.root.innerHTML = skor.isi_review || '';
                            $('#memenuhi-' + idtopik).prop('checked', !! skor.memenuhi);
                        }
                    });
                });
            });

            function sinkronKriteria() {
                $.each(quillKriteria, function (idtopik, quill) {
                    $('#input-kriteria-' + idtopik).val(quill.root.innerHTML);
                });
            }

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
                sinkronKriteria();

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
                                window.location.href = detailUrl;
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
