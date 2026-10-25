@extends('layout.layout')

@section('title', 'Balas Revisi Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peserta.pameran') }}">Pengajuan Pameran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Balas Revisi</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Balas Revisi &mdash; {{ $reviewerPameran->nama_sc }}</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.pameran') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <p><strong>Tema:</strong> {{ $reviewerPameran->tema }}</p>

                @if($permintaanRevisi->catatan)
                    <p><strong>Catatan Revisi:</strong><br>{{ $permintaanRevisi->catatan }}</p>
                @endif

                @if($kriteria->isNotEmpty())
                    <table class="table table-sm table-bordered mb-4">
                        <thead>
                            <tr>
                                <th>Topik</th>
                                <th>Komentar</th>
                                <th class="text-center">Bobot</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria as $k)
                                <tr>
                                    <td>{{ $k->nama_topik }}</td>
                                    <td>{{ $k->isi_review ?? '-' }}</td>
                                    <td class="text-center">{{ $k->bobot_dlm_persen }}%</td>
                                    <td class="text-center">{{ $k->nilai ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <hr>
                <h5>Revisi</h5>

                <form id="form-balas-revisi">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label" for="input-portofolio">Form Keikutsertaan baru (PDF/DOC/DOCX, maks. 10 MB)</label>
                        <input type="file" name="portofolio" id="input-portofolio" class="form-control" accept=".pdf,.doc,.docx" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="input-catatan">Catatan untuk Reviewer (opsional)</label>
                        <textarea name="catatan" id="input-catatan" class="form-control" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btn-kirim-balasan">
                        <span class="btn-label">Kirim Revisi</span>
                    </button>
                </form>
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
            var kirimUrl = '{{ route('peserta.pameran.balas-revisi.kirim') }}';
            var pameranUrl = '{{ route('peserta.pameran') }}';

            $('#form-balas-revisi').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('#btn-kirim-balasan');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...');
                $('.page-alert').addClass('d-none').text('');

                var formData = new FormData(document.getElementById('form-balas-revisi'));

                $.ajax({
                    url: kirimUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        window.location.href = pameranUrl;
                    });
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    } else if (res.errors) {
                        pesan = Object.values(res.errors).flat().join('\n');
                    }
                    $('.page-alert').removeClass('d-none').text(pesan);
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });
        });
    </script>
@endsection
