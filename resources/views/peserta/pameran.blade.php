@extends('layout.layout')

@section('title', 'Pengajuan Pameran')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
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
        '2' => ['Pengajuan', 'bg-info'],
        '3' => ['Review', 'bg-warning'],
        '4' => ['Revisi', 'bg-warning'],
        '5' => ['Memenuhi', 'bg-success'],
        '6' => ['Tidak Memenuhi', 'bg-danger'],
        '7' => ['Proses Seleksi', 'bg-dark'],
        '8' => ['Tidak Terpilih', 'bg-danger'],
        '9' => ['Terpilih', 'bg-success'],
    ];

    $labelTagihan = [
        1 => ['Tertagih', 'bg-secondary'],
        2 => ['Terbayar Sebagian', 'bg-info'],
        3 => ['Lunas', 'bg-success'],
        4 => ['Batal', 'bg-danger'],
        5 => ['Expired', 'bg-dark'],
        6 => ['Ditangguhkan', 'bg-warning'],
    ];
@endphp

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Pengajuan Pameran</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('peserta.pameran.template') }}?jenis=pt" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-download me-1"></i> Template PT
                        </a>
                        <a href="{{ route('peserta.pameran.template') }}?jenis=non-pt" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-download me-1"></i> Template Non PT
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($pameran)
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Status</div>
                        <div class="col-12 col-sm-10">
                            <span class="badge {{ $labelStatus[$pameran->status_ajuan][1] ?? 'bg-secondary' }}">
                                {{ $labelStatus[$pameran->status_ajuan][0] ?? '-' }}
                            </span>
                        </div>
                    </div>

                    @if($tagihan)
                        <div class="row mb-2">
                            <div class="col-12 col-sm-2 fw-bold">Status Pembayaran</div>
                            <div class="col-12 col-sm-10">
                                <span class="badge {{ $labelTagihan[$tagihan->status][1] ?? 'bg-secondary' }}">
                                    {{ $labelTagihan[$tagihan->status][0] ?? '-' }}
                                </span>
                                @if($tagihan->status === 5)
                                    <p class="mt-2 mb-0" style="font-size: 12.5px; color:red">
                                        Tagihan ini telah kedaluwarsa. Silahkan buat Tagihan baru
                                    </p>
                                @elseif($tagihan->status === 1)
                                    <p class="mt-2 mb-0" style="font-size: 12.5px; color:red">
                                        Tagihan ini belum dibayar. Silahkan lakukan pembayaran untuk dapat mengikuti Pameran.
                                    </p>
                                @elseif($tagihan->status === 6)
                                    <p class="mt-2 mb-0" style="font-size: 12.5px;">
                                        Tagihan untuk kluster ini ditangguhkan — baru akan ditagihkan jika pengajuan dinyatakan Diterima. Pengajuan ini tetap dapat direview SC sekarang.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12 col-sm-2 fw-bold"></div>
                            <div class="col-12 col-sm-10">
                                <a href="{{ route('peserta.pameran.tagihan') }}" class="btn btn-outline-primary btn-sm">Lihat Detail Tagihan</a>
                            </div>
                        </div>
                    @endif
                @endif

                @if($sedangDireview)
                    <div class="alert alert-info">
                        Pengajuan ini sedang direview oleh SC. Mohon tunggu keputusan sebelum dapat mengubah data.
                    </div>
                @endif

                @if($pameran && ! $bisaEdit)
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">PIC</div>
                        <div class="col-12 col-sm-10">{{ $pameran->nama_pic }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Kluster Pameran</div>
                        <div class="col-12 col-sm-10">
                            @if($pameran->nomor_kluster)
                                Kluster {{ $pameran->nomor_kluster }} — {{ $pameran->tema_kluster }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Tema</div>
                        <div class="col-12 col-sm-10">{{ $pameran->tema }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Risalah Singkat Pameran</div>
                        <div class="col-12 col-sm-10">{!! $pameran->abstract !!}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-sm-2 fw-bold">Nomor Stand</div>
                        <div class="col-12 col-sm-10" style="font-weight: bold; color:red">
                            {{ $pameran->nomor_stand ?? '-' }}
                        </div>
                    </div>
                @endif

                @if($pameran && $pameran->status_ajuan === '2')
                    <button type="button" class="btn btn-outline-danger" id="btn-batalkan-ajuan">
                        <span class="btn-label">Batalkan Pengajuan, Kembali ke Draft</span>
                    </button>
                @endif

                @if($pameran && $pameran->status_ajuan === '9')
                    <hr class="mt-4">
                    <h5>Penjaga Stand &amp; Tanggal Loading</h5>

                    @if($pameran->nomor_stand)
                        <p class="text-muted" style="font-size: 12.5px;">
                            Nomor stand sudah ditetapkan — hubungi admin untuk mengubah penjaga stand atau tanggal loading.
                        </p>
                    @else
                        <p class="fw-bold text-danger" style="font-size: 12.5px;">
                            Nomor stand tidak akan bisa diberikan sebelum minimal 1 penjaga stand sudah dipilih dan tanggal loading sudah ditentukan.
                        </p>
                        <p class="text-muted" style="font-size: 12.5px;">
                            Maksimal 2 penjaga stand, dipilih dari peserta kontingen sendiri — PIC pameran juga boleh dipilih.
                        </p>
                    @endif

                    <div class="row" style="max-width: 700px;">
                        @for($slot = 0; $slot < 2; $slot++)
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Penjaga {{ $slot + 1 }}</label>
                                <div class="d-flex align-items-center gap-2 border rounded p-2">
                                    @if($penjagaStand->get($slot))
                                        <span class="flex-grow-1">{{ $penjagaStand[$slot]->nama }}</span>
                                        @unless($pameran->nomor_stand)
                                            <button type="button" class="btn btn-outline-danger btn-hapus-penjaga" data-idpetugas-jaga="{{ $penjagaStand[$slot]->idpetugas_jaga }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endunless
                                    @elseif($pameran->nomor_stand)
                                        <span class="flex-grow-1 text-muted">-</span>
                                    @else
                                        <button type="button" class="btn btn-outline-primary btn-pilih-penjaga flex-grow-1">
                                            Pilih Penjaga
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endfor

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold" for="input-jadwal-loading">Tanggal Loading</label>
                            @if($pameran->nomor_stand)
                                <div class="border rounded p-2">{{ $pameran->jadwal_loading ? \Illuminate\Support\Carbon::parse($pameran->jadwal_loading)->format('d/m/Y') : '-' }}</div>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <input type="date" id="input-jadwal-loading" class="form-control" value="{{ $pameran->jadwal_loading ? \Illuminate\Support\Carbon::parse($pameran->jadwal_loading)->format('Y-m-d') : '' }}">
                                    <button type="button" class="btn btn-outline-primary text-nowrap" id="btn-simpan-jadwal-loading">
                                        <span class="btn-label">Simpan</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if($bisaEdit)
                    <form id="form-pameran">
                        <div class="mb-3">
                            <label class="form-label" for="input-idkluster-pameran">Kluster Pameran</label>
                            <select name="idkluster_pameran" id="input-idkluster-pameran" class="form-control" required>
                                <option value="">-- Pilih Kluster --</option>
                                @foreach($klusterOptions as $opsi)
                                    <option value="{{ $opsi->idkluster_pameran }}" @selected(($pameran->idkluster_pameran ?? null) == $opsi->idkluster_pameran)>
                                        Kluster {{ $opsi->nomor_kluster }} — {{ $opsi->tema_kluster }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="input-tema">Tema</label>
                            <input type="text" name="tema" id="input-tema" class="form-control" maxlength="255" value="{{ $pameran->tema ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Risalah Singkat Pameran</label>
                            <div id="editor-abstract" style="height: 220px; background-color: #fff;">{!! $pameran->abstract ?? '' !!}</div>
                            <input type="hidden" name="abstract" id="input-abstract">
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
                            <label class="form-label" for="input-portofolio">Form Keikutsertaan (PDF/DOC/DOCX, maks. 10 MB)</label>
                            <input type="file" name="portofolio" id="input-portofolio" class="form-control" accept=".pdf,.doc,.docx">
                            @if($pameran && $pameran->file_path_pertama)
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Sudah ada file tersimpan —
                                    <a href="{{ route('peserta.pameran.file-pertama') }}?token={{ $tokenFilePertama }}" target="_blank">lihat file saat ini</a>.
                                    Biarkan kosong untuk tetap memakai file ini, atau pilih file baru untuk menggantinya.
                                </div>
                            @else
                                <div class="text-muted mt-1" style="font-size: 12.5px;">
                                    Form Keikutsertaan wajib diunggah sebelum pengajuan dapat disimpan.
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

                @if($pameran)
                    <hr class="mt-4">
                    <h5>Riwayat Review</h5>
                    <p class="text-muted" style="font-size: 12.5px;">
                        Pengajuan ini direview oleh 2 SC secara independen.
                    </p>

                    <ul class="nav nav-tabs" id="tab-reviewer" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-reviewer-1-btn" data-bs-toggle="tab" data-bs-target="#tab-reviewer-1" type="button" role="tab">
                                Reviewer Pertama
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-reviewer-2-btn" data-bs-toggle="tab" data-bs-target="#tab-reviewer-2" type="button" role="tab">
                                Reviewer Kedua
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content border border-top-0 rounded-bottom p-3 mb-3" id="tab-reviewer-content">
                        @foreach([1 => $reviewer1, 2 => $reviewer2] as $reviewerKe => $reviewer)
                            <div class="tab-pane fade @if($reviewerKe === 1) show active @endif" id="tab-reviewer-{{ $reviewerKe }}" role="tabpanel">
                                @if(! $reviewer)
                                    <p class="text-muted mb-0">Reviewer belum ditugaskan panitia.</p>
                                @elseif($reviewer['riwayat']->isEmpty())
                                    <p class="text-muted mb-0">Reviewer belum mulai melakukan review.</p>
                                @else
                                    <div class="accordion" id="accordion-riwayat-{{ $reviewerKe }}">
                                        @foreach($reviewer['riwayat'] as $i => $baris)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button @if(!$loop->last) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $reviewerKe }}-{{ $i }}">
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
                                                                <a href="{{ route('peserta.pameran.portofolio') }}?token={{ $baris->token }}" target="_blank">
                                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Form Keikutsertaan
                                                                </a>
                                                            </p>
                                                        @endif

                                                        @if($baris->catatan)
                                                            <p><strong>Catatan SC:</strong><br>{{ $baris->catatan }}</p>
                                                        @endif

                                                        @if($baris->catatan_peserta)
                                                            <p><strong>Catatan Saya:</strong><br>{{ $baris->catatan_peserta }}</p>
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

                                                        @if($loop->last && $baris->status_ajuan === '4')
                                                            <a href="{{ route('peserta.pameran.balas-revisi') }}?token={{ $reviewer['tokenReviewer'] }}" class="btn btn-sm btn-primary mt-2">
                                                                Revisi
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal: pilih penjaga stand --}}
    @if($pameran && $pameran->status_ajuan === '9')
        <div class="modal fade" id="modal-pilih-penjaga" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-pilih-penjaga">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Penjaga Stand</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                            <select name="idpeserta" id="input-pilih-penjaga" class="form-control" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($pesertaOptions->whereNotIn('idpeserta', $penjagaStand->pluck('idpeserta')) as $opsi)
                                    <option value="{{ $opsi->idpeserta }}">{{ $opsi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-submit-pilih-penjaga">
                                <span class="btn-label">Simpan</span>
                            </button>
                        </div>
                    </form>
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
            var simpanDraftUrl = '{{ route('peserta.pameran.simpan-draft') }}';
            var ajukanUrl = '{{ route('peserta.pameran.ajukan') }}';
            var batalkanAjuanUrl = '{{ route('peserta.pameran.batalkan-ajuan') }}';
            var tambahPenjagaUrl = '{{ route('peserta.pameran.penjaga.tambah') }}';
            var hapusPenjagaUrl = '{{ route('peserta.pameran.penjaga.hapus') }}';
            var simpanJadwalLoadingUrl = '{{ route('peserta.pameran.jadwal-loading') }}';

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
                    placeholder: 'Tuliskan risalah singkat pengajuan pameran...',
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
                    $('.page-alert').removeClass('d-none').text('Risalah Singkat Pameran tidak boleh kosong.');
                    return true;
                }
                return false;
            }

            var $modalPilihPenjaga = $('#modal-pilih-penjaga');

            $('.btn-pilih-penjaga').on('click', function () {
                $modalPilihPenjaga.find('.modal-alert').addClass('d-none').text('');
                $('#input-pilih-penjaga').val('');
                $modalPilihPenjaga.modal('show');
            });

            $('#form-pilih-penjaga').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('.btn-submit-pilih-penjaga');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modalPilihPenjaga.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: tambahPenjagaUrl,
                    method: 'POST',
                    data: $(this).serialize(),
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
                    } else if (res.errors) {
                        pesan = Object.values(res.errors).flat().join('\n');
                    }
                    $modalPilihPenjaga.find('.modal-alert').removeClass('d-none').text(pesan);
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            $('.btn-hapus-penjaga').on('click', function () {
                var $btn = $(this);
                var idpetugasJaga = $btn.data('idpetugas-jaga');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Hapus penjaga stand ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $btn.prop('disabled', true);
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: hapusPenjagaUrl,
                        method: 'POST',
                        data: { idpetugas_jaga: idpetugasJaga },
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
                        $btn.prop('disabled', false);
                    });
                });
            });

            $('#btn-simpan-jadwal-loading').on('click', function () {
                var $btn = $(this);
                var tanggal = $('#input-jadwal-loading').val();

                if (! tanggal) {
                    $('.page-alert').removeClass('d-none').text('Tanggal loading tidak boleh kosong.');
                    return;
                }

                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: simpanJadwalLoadingUrl,
                    method: 'POST',
                    data: { jadwal_loading: tanggal },
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

            function simpanDraft() {
                $('#input-abstract').val(quillAbstract.root.innerHTML);

                var formData = new FormData(document.getElementById('form-pameran'));

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

            $('#form-pameran').on('submit', function (e) {
                e.preventDefault();

                $('.page-alert').addClass('d-none').text('');

                if (abstrakKosong()) {
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
                    text: 'Risalah Singkat Pameran dan Form Keikutsertaan akan disimpan, lalu pengajuan ini langsung dapat direview SC. Ajukan sekarang?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ajukan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    if (abstrakKosong()) {
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
                        .fail(function (xhr) {
                            console.log(xhr.responseText);
                            tampilkanError(xhr);
                        })
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
