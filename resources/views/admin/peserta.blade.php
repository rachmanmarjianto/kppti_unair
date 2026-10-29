@extends('layout.layout')

@section('title', 'Manajemen Peserta')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        .btn-toggle-anak {
            transition: transform 0.2s ease;
        }

        .btn-toggle-anak.expanded {
            transform: rotate(90deg);
        }

        .baris-peserta > td {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }

        body.dark .baris-peserta > td {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .baris-peserta .sel-nama {
            padding-left: 2rem;
        }

        .kartu-statistik {
            border-left: 4px solid var(--warna-statistik, #4361ee);
            height: 100%;
        }

        .kartu-statistik .widget-content-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .kartu-statistik .ikon-statistik {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 50%;
            font-size: 18px;
            color: #fff;
            background-color: var(--warna-statistik, #4361ee);
        }

        .kartu-statistik .nilai-statistik {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin: 0;
        }

        .kartu-statistik .nilai-statistik.nilai-utama {
            font-size: 1.9rem;
        }

        .teks-ringkasan-jenis {
            color: #3b3f5c;
        }

        body.dark .teks-ringkasan-jenis {
            color: #e0e6ed;
        }

        .kartu-statistik .label-statistik {
            font-size: 0.8rem;
            margin: 0;
            color: #888ea8;
        }

        #modal-detail-peserta .modal-dialog {
            max-width: 95%;
        }

        #modal-edit-email .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-edit-email .form-label, #modal-edit-email .text-muted { color: #0e1726 !important; }
        #modal-edit-email .form-control { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }

        #modal-pindah-kontingen .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-pindah-kontingen .form-label, #modal-pindah-kontingen .text-muted { color: #0e1726 !important; }
        #modal-pindah-kontingen .form-select { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }

        #modal-detail-peserta .modal-content {
            background-color: #fff;
            color: #3b3f5c;
        }

        #modal-detail-peserta .modal-header {
            background: linear-gradient(135deg, #4361ee, #2196f3);
            color: #fff;
            border-bottom: none;
        }

        #modal-detail-peserta .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        #modal-detail-peserta .modal-body td,
        #modal-detail-peserta .modal-body p {
            color: #3b3f5c;
        }

        #modal-detail-peserta .modal-body td.text-muted {
            color: #6c757d !important;
        }

        #modal-detail-peserta .seksi-detail {
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }

        #modal-detail-peserta .seksi-data-diri {
            background-color: rgba(67, 97, 238, 0.08);
            border-left: 4px solid #4361ee;
        }

        #modal-detail-peserta .seksi-logistik {
            background-color: rgba(0, 171, 85, 0.08);
            border-left: 4px solid #00ab55;
        }

        #modal-detail-peserta .seksi-status {
            background-color: rgba(226, 160, 63, 0.1);
            border-left: 4px solid #e2a03f;
        }

        #modal-detail-peserta .seksi-detail h6 {
            font-weight: 700;
            color: #3b3f5c;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manajemen Peserta</li>
@endsection

@section('content')
    {{-- Dashboard ringkasan --}}
    <div class="row">
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #00ab55;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <p class="nilai-statistik">{{ $dashboard['jumlahLengkap'] }}</p>
                        <p class="label-statistik">Data Lengkap</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #e7515a;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-circle-exclamation"></i></span>
                    <div>
                        <p class="nilai-statistik">{{ $dashboard['jumlahBelumLengkap'] }}</p>
                        <p class="label-statistik">Data Belum Lengkap</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #4361ee;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-users"></i></span>
                    <div>
                        <p class="nilai-statistik nilai-utama">{{ $dashboard['totalPeserta'] }}</p>
                        <p class="label-statistik">Total Peserta</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #805dca;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-bus"></i></span>
                    <div>
                        <p class="nilai-statistik">{{ $dashboard['jumlahCityTour'] }}</p>
                        <p class="label-statistik">Ikut City Tour</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #2196f3;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-building-columns"></i></span>
                    <div>
                        <p class="nilai-statistik nilai-utama">{{ $dashboard['totalInstitusi'] }}</p>
                        <p class="label-statistik">Total Institusi</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 layout-spacing">
            <div class="statbox widget box box-shadow kartu-statistik" style="--warna-statistik: #e2a03f;">
                <div class="widget-content widget-content-area">
                    <span class="ikon-statistik"><i class="fa-solid fa-id-card"></i></span>
                    <div>
                        <p class="nilai-statistik">{{ $dashboard['kontingenSiapCetak'] }} / {{ $dashboard['kontingenSiapCetak'] + $dashboard['kontingenBelumSiap'] }}</p>
                        <p class="label-statistik">Kontingen Siap Cetak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4>Peserta &amp; Institusi per Jenis Institusi</h4>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-outline-success btn-sm" id="btn-download-excel-peserta">
                            <i class="fa-solid fa-file-excel me-1"></i> Download Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row">
                    @foreach ($jenisInstitusiList as $jenis)
                        <div class="col-md-4 col-sm-6 col-12 mb-3">
                            <p class="fw-bold mb-0 teks-ringkasan-jenis" style="font-size: 1.05rem;">{{ $jenis->nama_jenis_institusi }}</p>
                            <p class="mb-0 teks-ringkasan-jenis" style="font-size: 0.95rem;">{{ $jenis->jumlahInstitusi }} institusi, {{ $jenis->jumlahPeserta }} peserta</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel tersembunyi, hanya dipakai sebagai sumber data tombol
         "Download Excel" di atas (lewat DataTables Buttons) — kolomnya
         beda dari tabel tampilan (pakai City Tour, bukan email/jabatan).
         Pembungkus di luar ikut disembunyikan karena DataTables merender
         toolbar tombolnya sendiri (hasil `dom: 'B'`) sebagai elemen sibling
         di luar <table>, bukan di dalamnya — kalau hanya <table> yang
         disembunyikan, toolbar tombol bawaan itu tetap akan terlihat. --}}
    <div style="display:none">
        <table id="table-export-peserta">
            <thead>
                <tr>
                    <th>Jenis Institusi</th>
                    <th>Institusi Asal</th>
                    <th>Nama Peserta</th>
                    <th>Status</th>
                    <th>City Tour</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisInstitusiList as $jenis)
                    @foreach ($jenis->institusiList as $institusi)
                        @foreach ($institusi->pesertaList as $peserta)
                            <tr>
                                <td>{{ $jenis->nama_jenis_institusi }}</td>
                                <td>{{ $institusi->nama_institusi }}</td>
                                <td>{{ $peserta->nama }}</td>
                                <td>{{ $peserta->lengkap ? 'Lengkap' : 'Belum Lengkap' }}</td>
                                <td>{{ $peserta->city_tour ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Daftar peserta, dikelompokkan per jenis institusi lalu institusi asal --}}
    @forelse ($jenisInstitusiList as $jenis)
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4>{{ $jenis->nama_jenis_institusi }} <span class="text-muted fs-6">({{ $jenis->jumlahInstitusi }} institusi, {{ $jenis->jumlahPeserta }} peserta)</span></h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 30px;"></th>
                                    <th>Institusi / Peserta</th>
                                    <th>Email / Kode Kontingen</th>
                                    <th>No. WA / Jabatan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($jenis->institusiList as $institusi)
                                <tbody>
                                    <tr>
                                        <td>
                                            @if($institusi->jumlahPeserta > 0)
                                                <button type="button" class="btn btn-sm btn-link btn-toggle-anak expanded p-0" data-bs-toggle="collapse" data-bs-target="#institusi-{{ $institusi->idinstitusi_asal }}" aria-expanded="true">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td><strong>{{ $institusi->nama_institusi }}</strong></td>
                                        <td>{{ $institusi->kode_kontingen ?? '-' }}</td>
                                        <td>{{ $institusi->jumlahPeserta }} peserta</td>
                                        <td>
                                            @if($institusi->jumlahPeserta === 0)
                                                <span class="badge bg-secondary">Belum Ada Peserta</span>
                                            @elseif($institusi->semuaLengkap)
                                                <span class="badge bg-success">Semua Lengkap</span>
                                            @else
                                                <span class="badge bg-danger">Ada yang Belum Lengkap</span>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap">
                                            @if($institusi->semuaLengkap)
                                                <a href="{{ route('admin.peserta.cetak-kartu') }}?token={{ $institusi->token }}" class="btn btn-sm btn-outline-primary" title="Cetak Kartu Registrasi">
                                                    <i class="fa-solid fa-id-card"></i>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Lengkapi semua data peserta terlebih dahulu">
                                                    <i class="fa-solid fa-id-card"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                                @if($institusi->jumlahPeserta > 0)
                                    <tbody class="collapse show" id="institusi-{{ $institusi->idinstitusi_asal }}">
                                        @foreach ($institusi->pesertaList as $peserta)
                                            <tr class="baris-peserta" data-token="{{ $peserta->token }}">
                                                <td></td>
                                                <td class="sel-nama">↳ {{ $peserta->nama }}</td>
                                                <td>{{ $peserta->email }}</td>
                                                <td>{{ $peserta->no_wa ?? '-' }} / {{ $peserta->nama_jabatan }}</td>
                                                <td>
                                                    @if($peserta->lengkap)
                                                        <span class="badge bg-success">Lengkap</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum Lengkap</span>
                                                    @endif
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-info btn-detail-peserta" title="Detail Peserta" data-token="{{ $peserta->token }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-edit-email-peserta" title="Edit Email" data-idpeserta="{{ $peserta->idpeserta }}" data-email="{{ $peserta->email }}">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-reset-password-peserta" title="Reset Password" data-idpeserta="{{ $peserta->idpeserta }}" data-no-wa="{{ $peserta->no_wa }}">
                                                        <i class="fa-solid fa-key"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning btn-pindah-kontingen" title="Pindah Kontingen" data-idpeserta="{{ $peserta->idpeserta }}" data-nama="{{ $peserta->nama }}" data-idinstitusi-asal="{{ $institusi->idinstitusi_asal }}">
                                                        <i class="fa-solid fa-right-left"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-hapus-role-peserta" title="Hapus Role Peserta" data-idpeserta="{{ $peserta->idpeserta }}" data-nama="{{ $peserta->nama }}">
                                                        <i class="fa-solid fa-user-slash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area text-center text-muted">
                    Belum ada peserta terdaftar.
                </div>
            </div>
        </div>
    @endforelse

    {{-- Modal: detail peserta (read-only) --}}
    <div class="modal fade" id="modal-detail-peserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="detail-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="detail-content d-none">
                        <div class="row mb-1">
                            <div class="col-md-3">
                                <div class="seksi-detail seksi-data-diri h-100 text-center">
                                    <h6 class="mb-2">Foto</h6>
                                    <img src="" alt="Foto peserta" class="sel-foto-img img-fluid rounded d-none" style="max-width: 100%;">
                                    <p class="sel-foto-kosong text-muted mb-0 d-none">Belum ada foto.</p>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="seksi-detail seksi-data-diri h-100">
                                    <h6 class="mb-2">Data Diri</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td class="text-muted" style="width: 180px;">Nama</td><td class="sel-nama">:</td></tr>
                                        <tr><td class="text-muted">Email</td><td class="sel-email">:</td></tr>
                                        <tr><td class="text-muted">No. WhatsApp</td><td class="sel-no-wa">:</td></tr>
                                        <tr><td class="text-muted">Jabatan</td><td class="sel-jabatan">:</td></tr>
                                        <tr><td class="text-muted">Institusi</td><td class="sel-institusi">:</td></tr>
                                        <tr><td class="text-muted">Jenis Institusi</td><td class="sel-jenis-institusi">:</td></tr>
                                        <tr><td class="text-muted">Kode Kontingen</td><td class="sel-kode-kontingen">:</td></tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="seksi-detail seksi-logistik h-100">
                                    <h6 class="mb-2">Logistik</h6>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr><td class="text-muted" style="width: 180px;">Transportasi Kedatangan</td><td class="sel-transport-kedatangan">:</td></tr>
                                        <tr><td class="text-muted">Stasiun/Titik Kedatangan</td><td class="sel-stasiun-kedatangan">:</td></tr>
                                        <tr><td class="text-muted">Tanggal &amp; Jam Kedatangan</td><td class="sel-waktu-kedatangan">:</td></tr>
                                        <tr><td class="text-muted">Transportasi Kepulangan</td><td class="sel-transport-kepulangan">:</td></tr>
                                        <tr><td class="text-muted">Stasiun/Titik Kepulangan</td><td class="sel-stasiun-kepulangan">:</td></tr>
                                        <tr><td class="text-muted">Tanggal &amp; Jam Kepulangan</td><td class="sel-waktu-kepulangan">:</td></tr>
                                        <tr><td class="text-muted">Hotel</td><td class="sel-hotel">:</td></tr>
                                        <tr><td class="text-muted">City Tour</td><td class="sel-city-tour">:</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="seksi-detail seksi-status mb-0">
                            <h6 class="mb-2">Status Kelengkapan Data</h6>
                            <p class="mb-1">Logistik: <span class="sel-logistik-lengkap"></span></p>
                            <p class="mb-0">Foto: <span class="sel-foto-lengkap"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: edit email peserta --}}
    <div class="modal fade" id="modal-edit-email" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit-email">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Email Peserta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <input type="hidden" name="idpeserta" id="input-edit-email-idpeserta">

                        <div class="mb-3">
                            <label class="form-label" for="input-edit-email-baru">Email Baru</label>
                            <input type="email" name="email" id="input-edit-email-baru" class="form-control" maxlength="500" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit-edit-email">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: pindah kontingen peserta --}}
    <div class="modal fade" id="modal-pindah-kontingen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.peserta.pindah-kontingen') }}" id="form-pindah-kontingen">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Pindah Kontingen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idpeserta" id="input-pindah-idpeserta">

                        <p class="mb-3">Pindahkan <strong id="sel-pindah-nama"></strong> ke kontingen:</p>

                        <div class="mb-3">
                            <label class="form-label" for="input-pindah-institusi">Kontingen Tujuan</label>
                            <select name="idinstitusi_asal_baru" id="input-pindah-institusi" class="form-select" required>
                                <option value="">-- Pilih Kontingen --</option>
                                @foreach ($institusiList as $institusiOpsi)
                                    <option value="{{ $institusiOpsi->idinstitusi_asal }}">{{ $institusiOpsi->nama_institusi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/button-ext/buttons.html5.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // ------- Download Excel (data peserta per jenis & institusi) -------
            var tableExportPeserta = $('#table-export-peserta').DataTable({
                dom: 'B',
                paging: false,
                searching: false,
                info: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        filename: 'Peserta dan Institusi',
                    },
                ],
            });

            $('#btn-download-excel-peserta').on('click', function () {
                tableExportPeserta.button(0).trigger();
            });
            var resetPasswordUrl = '{{ route('admin.peserta.reset-password') }}';
            var detailUrl = '{{ route('admin.peserta.detail') }}';
            var fotoUrl = '{{ route('admin.peserta.foto') }}';
            var updateEmailUrl = '{{ route('admin.peserta.email.update') }}';
            var hapusRolePesertaUrl = '{{ route('admin.peserta.hapus-role') }}';

            $('[data-bs-toggle="collapse"]').on('click', function () {
                $(this).toggleClass('expanded');
            });

            // ------- Detail peserta (read-only, dimuat lewat AJAX) -------
            var $modalDetail = $('#modal-detail-peserta');
            var $detailLoading = $modalDetail.find('.detail-loading');
            var $detailContent = $modalDetail.find('.detail-content');

            function formatTanggalJam(tanggal, jam) {
                if (!tanggal) {
                    return '-';
                }
                return tanggal + (jam ? ' ' + jam.substring(0, 5) : '');
            }

            $('.btn-detail-peserta').on('click', function () {
                var token = $(this).data('token');

                $detailLoading.removeClass('d-none');
                $detailContent.addClass('d-none');
                $modalDetail.find('.modal-alert').addClass('d-none').text('');
                $modalDetail.modal('show');

                $.ajax({
                    url: detailUrl + '?token=' + encodeURIComponent(token),
                    method: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    var data = res.data;

                    if (data.fotoLengkap) {
                        $modalDetail.find('.sel-foto-img').attr('src', fotoUrl + '?token=' + encodeURIComponent(token)).removeClass('d-none');
                        $modalDetail.find('.sel-foto-kosong').addClass('d-none');
                    } else {
                        $modalDetail.find('.sel-foto-img').addClass('d-none').attr('src', '');
                        $modalDetail.find('.sel-foto-kosong').removeClass('d-none');
                    }

                    $modalDetail.find('.sel-nama').text(': ' + data.nama);
                    $modalDetail.find('.sel-email').text(': ' + data.email);
                    $modalDetail.find('.sel-no-wa').text(': ' + (data.no_wa || '-'));
                    $modalDetail.find('.sel-jabatan').text(': ' + data.nama_jabatan);
                    $modalDetail.find('.sel-institusi').text(': ' + data.nama_institusi);
                    $modalDetail.find('.sel-jenis-institusi').text(': ' + data.nama_jenis_institusi);
                    $modalDetail.find('.sel-kode-kontingen').text(': ' + (data.kode_kontingen || '-'));

                    $modalDetail.find('.sel-transport-kedatangan').text(': ' + (data.nama_transport_kedatangan || '-'));
                    $modalDetail.find('.sel-stasiun-kedatangan').text(': ' + (data.stasiun_kedatangan || '-'));
                    $modalDetail.find('.sel-waktu-kedatangan').text(': ' + formatTanggalJam(data.tanggal_kedatangan, data.jam_kedatangan));
                    $modalDetail.find('.sel-transport-kepulangan').text(': ' + (data.nama_transport_kepulangan || '-'));
                    $modalDetail.find('.sel-stasiun-kepulangan').text(': ' + (data.stasiun_kepulangan || '-'));
                    $modalDetail.find('.sel-waktu-kepulangan').text(': ' + formatTanggalJam(data.tanggal_kepulangan, data.jam_kepulangan));
                    $modalDetail.find('.sel-hotel').text(': ' + (data.nama_hotel || '-'));
                    $modalDetail.find('.sel-city-tour').text(': ' + (data.city_tour ? 'Ya' : 'Tidak'));

                    $modalDetail.find('.sel-logistik-lengkap').html(data.logistikLengkap
                        ? '<span class="badge bg-success">Lengkap</span>'
                        : '<span class="badge bg-danger">Belum Lengkap</span>');
                    $modalDetail.find('.sel-foto-lengkap').html(data.fotoLengkap
                        ? '<span class="badge bg-success">Lengkap</span>'
                        : '<span class="badge bg-danger">Belum Lengkap</span>');

                    $detailLoading.addClass('d-none');
                    $detailContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                    if (xhr.status === 0) {
                        pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }
                    $detailLoading.addClass('d-none');
                    $modalDetail.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });

            // ------- Reset password (pola SweetAlert2 sama seperti sisi Peserta, -------
            // tombol dikunci 30 detik setelah diklik supaya tidak bisa direset berkali-kali) -------
            $('.btn-reset-password-peserta').on('click', function () {
                var $btn = $(this);

                if ($btn.prop('disabled')) {
                    return;
                }

                var idpeserta = $btn.data('idpeserta');
                var noWa = $btn.data('no-wa');
                var teksAsli = $btn.html();

                Swal.fire({
                    title: 'Reset Password?',
                    text: 'Password akan dikirim ke no WA ' + noWa,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, reset',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var sisaDetik = 30;
                    $btn.prop('disabled', true).text(sisaDetik);

                    var interval = setInterval(function () {
                        sisaDetik--;

                        if (sisaDetik <= 0) {
                            clearInterval(interval);
                            $btn.prop('disabled', false).html(teksAsli);
                        } else {
                            $btn.text(sisaDetik);
                        }
                    }, 1000);

                    $.ajax({
                        url: resetPasswordUrl,
                        method: 'POST',
                        data: { idpeserta: idpeserta },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                    })
                    .fail(function (xhr) {
                        var res = xhr.responseJSON || {};
                        var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                        if (xhr.status === 0) {
                            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        }
                        Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
                    });
                });
            });

            // ------- Hapus role Peserta (hapus baris role_pengguna, atau nonaktifkan -------
            // akun kalau Peserta adalah satu-satunya role, ditentukan oleh server) -------
            $('.btn-hapus-role-peserta').on('click', function () {
                var $btn = $(this);
                var idpeserta = $btn.data('idpeserta');
                var nama = $btn.data('nama');
                var teksAsli = $btn.html();

                Swal.fire({
                    title: 'Hapus Role Peserta?',
                    text: 'Role Peserta akan dihapus dari ' + nama + '. Jika Peserta adalah satu-satunya role yang dimiliki, akun ini akan dinonaktifkan. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                    $.ajax({
                        url: hapusRolePesertaUrl,
                        method: 'POST',
                        data: { idpeserta: idpeserta },
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
                        $btn.prop('disabled', false).html(teksAsli);
                    });
                });
            });

            // ------- Edit email peserta -------
            var $modalEditEmail = $('#modal-edit-email');

            $('.btn-edit-email-peserta').on('click', function () {
                var $btn = $(this);

                $modalEditEmail.find('.modal-alert').addClass('d-none').text('');
                $('#input-edit-email-idpeserta').val($btn.data('idpeserta'));
                $('#input-edit-email-baru').val($btn.data('email'));
                $modalEditEmail.modal('show');
            });

            $('#form-edit-email').on('submit', function (e) {
                e.preventDefault();

                var idpeserta = $('#input-edit-email-idpeserta').val();
                var emailBaru = $('#input-edit-email-baru').val();

                Swal.fire({
                    title: 'Ubah Email Peserta?',
                    text: 'Email peserta akan diubah menjadi ' + emailBaru + '. Email ini juga akan dipakai peserta untuk login. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var $btn = $('#btn-submit-edit-email');
                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $modalEditEmail.find('.modal-alert').addClass('d-none').text('');

                    $.ajax({
                        url: updateEmailUrl,
                        method: 'POST',
                        data: { idpeserta: idpeserta, email: emailBaru },
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
                        $modalEditEmail.find('.modal-alert').removeClass('d-none').text(pesan);
                        $btn.prop('disabled', false).html(teksAwal);
                    });
                });
            });

            // ------- Pindah kontingen (submit form biasa, bukan AJAX, -------
            // sehingga halaman reload setelah berhasil, dikonfirmasi developer) -------
            var $modalPindahKontingen = $('#modal-pindah-kontingen');
            var $selectPindahInstitusi = $('#input-pindah-institusi');

            $('.btn-pindah-kontingen').on('click', function () {
                var idinstitusiAsalSaatIni = String($(this).data('idinstitusi-asal'));

                $('#input-pindah-idpeserta').val($(this).data('idpeserta'));
                $('#sel-pindah-nama').text($(this).data('nama'));

                $selectPindahInstitusi.val('');
                $selectPindahInstitusi.find('option').prop('disabled', false).show();
                $selectPindahInstitusi.find('option[value="' + idinstitusiAsalSaatIni + '"]').prop('disabled', true).hide();

                $modalPindahKontingen.modal('show');
            });

            $selectPindahInstitusi.on('change', function () {
                if ($(this).val() === '') {
                    return;
                }

                var namaPeserta = $('#sel-pindah-nama').text();
                var namaKontingenBaru = $(this).find('option:selected').text().trim();

                Swal.fire({
                    title: 'Konfirmasi Pindah Kontingen',
                    text: 'Pindahkan ' + namaPeserta + ' ke kontingen "' + namaKontingenBaru + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, pindahkan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $('#form-pindah-kontingen').submit();
                    } else {
                        $selectPindahInstitusi.val('');
                    }
                });
            });
        });
    </script>
@endsection
