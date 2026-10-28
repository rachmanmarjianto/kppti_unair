@extends('layout.layout')

@section('title', 'Detail Narasumber')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-ubah-sesi .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-ubah-sesi .form-label, #modal-ubah-sesi .text-muted { color: #0e1726 !important; }
        #modal-ubah-sesi .form-select { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.narasumber') }}">Narasumber</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
    {{-- Card 1: data pengajuan narasumber --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Pengajuan Narasumber</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.narasumber') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Nama Pengaju</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->nama_pengaju }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Institusi Asal</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->nama_institusi ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Email</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">No. WA</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->no_wa ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Extended Abstrak</div>
                    <div class="col-12 col-sm-9">{!! $narasumber->abstract !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Status Saat Ini</div>
                    <div class="col-12 col-sm-9">
                        <span class="badge {{ $labelStatus[$narasumber->status_ajuan][1] ?? 'bg-secondary' }}">
                            {{ $labelStatus[$narasumber->status_ajuan][0] ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Sesi yang Dipilih Peserta</div>
                    <div class="col-12 col-sm-9">
                        @if($narasumber->acara_parent_tema)
                            {{ $narasumber->acara_parent_tema }} <br>&mdash;
                        @endif
                        {{ $narasumber->acara_tema ?? '-' }}<br>
                        @if($narasumber->acara_hari_ke)
                            (Hari {{ $narasumber->acara_hari_ke }}, {{ substr($narasumber->acara_jam_mulai, 0, 5) }}–{{ substr($narasumber->acara_jam_akhir, 0, 5) }}, {{ $narasumber->acara_ruang ?? '-' }})
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#modal-ubah-sesi">
                            <i class="fa-solid fa-pen"></i> Ubah
                        </button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-sm-3 fw-bold">Subtema</div>
                    <div class="col-12 col-sm-9">{{ $narasumber->subtema ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: riwayat review_narasumber, read-only --}}
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Riwayat Review</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($riwayat->isEmpty())
                    <p class="text-muted mb-0">Belum ada riwayat.</p>
                @else
                    <div class="accordion" id="accordion-riwayat">
                        @foreach($riwayat as $i => $baris)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if(! $loop->last) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#riwayat-{{ $i }}">
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
                                                <a href="{{ route('admin.narasumber.berkas') }}?token={{ $baris->token }}" target="_blank">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat Extended Abstract
                                                </a>
                                            </p>
                                        @endif

                                        @if($baris->catatan)
                                            <p><strong>Catatan:</strong><br>{{ $baris->catatan }}</p>
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
                                            <p class="fw-bold mb-2">Nilai Akhir: {{ $baris->nilai_akhir ?? '-' }}</p>
                                        @endif

                                        @if($baris->nama_sc)
                                            <p class="text-muted mb-0" style="font-size: 12.5px;">
                                                Direview oleh {{ $baris->nama_sc }}
                                                @if($baris->reviewed_at)
                                                    pada {{ \Illuminate\Support\Carbon::parse($baris->reviewed_at)->format('d/m/Y H:i') }}
                                                @endif
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

    {{-- Modal: ubah sesi (acara) pengajuan narasumber --}}
    <div class="modal fade" id="modal-ubah-sesi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Sesi Pengajuan Narasumber</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $idparentAcaraSaatIni = $acaraOptions->firstWhere('idacara', $narasumber->idacara)->idparent_acara ?? null;
                    @endphp
                    <div class="mb-3">
                        <label for="input-ubah-sesi-parent" class="form-label">Sub Tema</label>
                        <select id="input-ubah-sesi-parent" class="form-select">
                            @foreach($acaraParentOptions as $parent)
                                <option value="{{ $parent->idparent_acara }}" @selected((string) $idparentAcaraSaatIni === (string) $parent->idparent_acara)>
                                    {{ $parent->parent_tema }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="input-ubah-sesi-acara" class="form-label">Sesi</label>
                        <select id="input-ubah-sesi-acara" class="form-select"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-ubah-sesi">
                        <span class="btn-label">Simpan</span>
                    </button>
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
            var acaraOptions = {!! json_encode($acaraOptions->map(fn ($a) => [
                'idacara' => $a->idacara,
                'tema' => $a->tema,
                'idparent_acara' => $a->idparent_acara,
            ])->values()) !!};
            var idacaraSaatIni = {{ $narasumber->idacara ?? 'null' }};
            var idnarasumber = {{ $narasumber->idnarasumber }};
            var csrfToken = '{{ csrf_token() }}';
            var ubahSesiUrl = '{{ route('admin.narasumber.ubah-sesi') }}';

            function isiSelectSesi(idacaraTerpilih) {
                var idparent = $('#input-ubah-sesi-parent').val();
                var $selectSesi = $('#input-ubah-sesi-acara');

                $selectSesi.empty();

                acaraOptions
                    .filter(function (a) { return String(a.idparent_acara) === String(idparent); })
                    .forEach(function (a) {
                        $selectSesi.append($('<option>', { value: a.idacara, text: a.tema }));
                    });

                if (idacaraTerpilih) {
                    $selectSesi.val(idacaraTerpilih);
                }
            }

            $('#modal-ubah-sesi').on('show.bs.modal', function () {
                isiSelectSesi(idacaraSaatIni);
            });

            $('#input-ubah-sesi-parent').on('change', function () {
                isiSelectSesi(null);
            });

            function tampilkanError(xhr) {
                var pesan = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan, silakan coba lagi.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
            }

            $('#btn-simpan-ubah-sesi').on('click', function () {
                var $btn = $(this);
                var idacaraBaru = $('#input-ubah-sesi-acara').val();

                if (! idacaraBaru) {
                    Swal.fire({ icon: 'warning', title: 'Pilih sesi', text: 'Pilih Sub Tema dan Sesi terlebih dahulu.' });

                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Ubah sesi pengajuan narasumber ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (! result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

                    $.ajax({
                        url: ubahSesiUrl,
                        method: 'POST',
                        data: {
                            idnarasumber: idnarasumber,
                            idacara: idacaraBaru,
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
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });
        });
    </script>
@endsection
