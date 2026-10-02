@extends('layout.layout')

@section('title', 'Manajemen Acara')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">

    <style>
        .btn-toggle-anak {
            transition: transform 0.2s ease;
            color: #fff !important;
        }

        .btn-toggle-anak.expanded {
            transform: rotate(90deg);
        }

        tr[data-warna-hari] > td:first-child {
            background-color: var(--warna-hari, #bfc9d4) !important;
        }

        .baris-sub-acara > td {
            background-color: rgba(0, 0, 0, 0.07) !important;
        }

        body.dark .baris-sub-acara > td {
            background-color: rgba(255, 255, 255, 0.08) !important;
        }

        .baris-sub-acara .sel-tema {
            padding-left: 2rem;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manajemen Acara</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Manajemen Acara</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-acara">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Acara
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                @if($legendaHari->isNotEmpty())
                    <div class="mb-3">
                        @foreach($legendaHari as $item)
                            <span class="d-inline-flex align-items-center me-3 mb-1">
                                <span style="display:inline-block; width:12px; height:12px; border-radius:50%; background-color: {{ $item->warna }}; margin-right:6px;"></span>
                                Hari {{ $item->hari_ke }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 30px;"></th>
                                <th>Tema</th>
                                <th>Ruang</th>
                                <th>Opsi Pilih</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Pembicara</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        @forelse ($acaraList as $acara)
                            <tbody>
                                <tr data-warna-hari style="--warna-hari: {{ $acara->warna_hari }};">
                                    <td>
                                        @if($acara->children->isNotEmpty())
                                            <button type="button" class="btn btn-sm btn-link btn-toggle-anak expanded p-0" data-bs-toggle="collapse" data-bs-target="#anak-{{ $acara->idacara }}" aria-expanded="true">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="sel-tema" style="white-space: pre-line;">{{ $acara->tema ?? '-' }}</td>
                                    <td>{{ $acara->children->isEmpty() ? ($acara->ruang ?? '-') : '-' }}</td>
                                    <td>@include('admin.partials.opsi-pilih-badge', ['opsi' => $acara->opsi_pilih])</td>
                                    <td>{{ $acara->hari_ke ?? '-' }}</td>
                                    <td>{{ $acara->children->isNotEmpty() ? '-' : ($acara->jam_mulai ? substr($acara->jam_mulai, 0, 5).' - '.substr($acara->jam_akhir, 0, 5) : '-') }}</td>
                                    <td>
                                        @if(! $acara->perlu_narsum)
                                            {{ $acara->speaker ?? '-' }}
                                        @elseif($acara->narasumberList->isNotEmpty())
                                            <ul class="list-unstyled mb-0">
                                                @foreach($acara->narasumberList as $ns)
                                                    <li>{{ $ns->nama }}@if($ns->subtema) <span class="text-muted">({{ $ns->subtema }})</span>@endif</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted fst-italic">Menunggu hasil review narasumber</span>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning btn-edit-acara" title="Edit" data-idacara="{{ $acara->idacara }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-info btn-tambah-sub" title="Tambah Sub Acara" data-idacara="{{ $acara->idacara }}" data-tema="{{ $acara->tema }}">
                                            <i class="fa-solid fa-diagram-project"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-hapus-acara" title="Hapus" data-idacara="{{ $acara->idacara }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            @if($acara->children->isNotEmpty())
                                <tbody class="collapse show" id="anak-{{ $acara->idacara }}">
                                    @foreach($acara->children as $anak)
                                        <tr class="baris-sub-acara" data-warna-hari style="--warna-hari: {{ $anak->warna_hari }};">
                                            <td></td>
                                            <td class="sel-tema" style="white-space: pre-line;">↳ {{ $anak->tema ?? '-' }}</td>
                                            <td>{{ $anak->ruang ?? '-' }}</td>
                                            <td>@include('admin.partials.opsi-pilih-badge', ['opsi' => $anak->opsi_pilih])</td>
                                            <td>{{ $anak->hari_ke ?? '-' }}</td>
                                            <td>{{ $anak->jam_mulai ? substr($anak->jam_mulai, 0, 5).' - '.substr($anak->jam_akhir, 0, 5) : '-' }}</td>
                                            <td>
                                                @if(! $anak->perlu_narsum)
                                                    {{ $anak->speaker ?? '-' }}
                                                @elseif($anak->narasumberList->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($anak->narasumberList as $ns)
                                                            <li>{{ $ns->nama }}@if($ns->subtema) <span class="text-muted">({{ $ns->subtema }})</span>@endif</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted fst-italic">Menunggu hasil review narasumber</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning btn-edit-acara" title="Edit" data-idacara="{{ $anak->idacara }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btn-hapus-acara" title="Hapus" data-idacara="{{ $anak->idacara }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        @empty
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada acara.</td>
                                </tr>
                            </tbody>
                            @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: tambah/edit acara --}}
    <div class="modal fade" id="modal-acara" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-acara">
                    <input type="hidden" name="idacara" id="input-idacara">
                    <div class="modal-header">
                        <h5 class="modal-title" id="judul-modal-acara">Tambah Acara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3" id="info-induk-tetap" style="display:none;">
                            <div class="alert alert-info py-2 px-3 mb-0">
                                Sub-acara dari: <strong id="teks-induk-tetap"></strong>
                            </div>
                        </div>

                        <div class="mb-3" id="group-select-induk">
                            <label class="form-label">Induk Acara</label>
                            <select name="idparent_acara" id="select-induk-acara" class="form-select">
                                <option value="">— (Acara Utama) —</option>
                                @foreach($parentOptions as $opsi)
                                    <option value="{{ $opsi->idacara }}">{{ $opsi->tema }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="idparent_acara" id="hidden-induk-acara" disabled>

                        <div class="mb-3">
                            <label class="form-label">Tema</label>
                            <textarea name="tema" id="input-tema" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ruang</label>
                            <input type="text" name="ruang" id="input-ruang" class="form-control" maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Opsi Pilih untuk Peserta</label>
                            <select name="opsi_pilih" id="input-opsi-pilih" class="form-select" required>
                                <option value="1">Tidak Bisa Dipilih</option>
                                <option value="2">Opsional</option>
                                <option value="3">Wajib</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Hari Ke</label>
                                <input type="number" name="hari_ke" id="input-hari-ke" class="form-control" min="1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="input-jam-mulai" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jam Akhir</label>
                                <input type="time" name="jam_akhir" id="input-jam-akhir" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Sumber Pembicara</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="perlu_narsum" id="narsum-tetap" value="0" checked>
                                <label class="form-check-label" for="narsum-tetap">Pembicara tetap</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="perlu_narsum" id="narsum-pengajuan" value="1">
                                <label class="form-check-label" for="narsum-pengajuan">Dari pengajuan narasumber</label>
                            </div>
                        </div>

                        <div class="mb-3" id="group-speaker">
                            <label class="form-label">Nama Pembicara</label>
                            <input type="text" name="speaker" id="input-speaker" class="form-control" maxlength="255">
                        </div>

                        <div class="mb-3 d-none" id="group-narasumber-readonly">
                            <label class="form-label">Narasumber</label>
                            <div id="daftar-narasumber-readonly" class="form-control" style="min-height: calc(1.5em + 0.75rem + 2px); height: auto; background-color: #f1f2f3;"></div>
                            <div class="text-muted mt-1" style="font-size: 12.5px;">
                                Diisi otomatis setelah ada narasumber yang diterima lewat alur pengajuan (bukan dari halaman ini). Satu acara bisa punya lebih dari satu narasumber, masing-masing dengan sub-temanya sendiri.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-acara">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        var acaraData = @json($acaraDataJs);

        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var tambahUrl = '{{ route('admin.acara.tambah') }}';
            var updateUrl = '{{ route('admin.acara.update') }}';
            var hapusUrl = '{{ route('admin.acara.hapus') }}';

            var $modal = $('#modal-acara');
            var $selectInduk = $('#select-induk-acara');
            var $hiddenInduk = $('#hidden-induk-acara');
            var $infoIndukTetap = $('#info-induk-tetap');
            var $groupSelectInduk = $('#group-select-induk');

            function cariAcara(idacara) {
                return acaraData.find(function (a) {
                    return a.idacara === idacara;
                });
            }

            function toggleSumberPembicara() {
                var dariPengajuan = $('input[name="perlu_narsum"]:checked').val() === '1';
                $('#group-speaker').toggleClass('d-none', dariPengajuan);
                $('#group-narasumber-readonly').toggleClass('d-none', ! dariPengajuan);
                $('#input-speaker').prop('required', ! dariPengajuan);
            }

            $('input[name="perlu_narsum"]').on('change', toggleSumberPembicara);

            function resetModal() {
                $('#form-acara')[0].reset();
                $('#input-idacara').val('');
                $modal.find('.modal-alert').addClass('d-none').text('');
                $infoIndukTetap.hide();
                $groupSelectInduk.show();
                $selectInduk.prop('disabled', false).val('');
                $hiddenInduk.prop('disabled', true).val('');
                $('#daftar-narasumber-readonly').html('');
                toggleSumberPembicara();
            }

            $('#btn-tambah-acara').on('click', function () {
                resetModal();
                $('#judul-modal-acara').text('Tambah Acara');
                $modal.modal('show');
            });

            $('.btn-tambah-sub').on('click', function () {
                resetModal();
                var idparent = $(this).data('idacara');
                var tema = $(this).data('tema');

                $('#judul-modal-acara').text('Tambah Sub Acara');
                $groupSelectInduk.hide();
                $selectInduk.prop('disabled', true);
                $hiddenInduk.prop('disabled', false).val(idparent);
                $infoIndukTetap.show();
                $('#teks-induk-tetap').text(tema);

                $modal.modal('show');
            });

            $('.btn-edit-acara').on('click', function () {
                resetModal();
                var data = cariAcara($(this).data('idacara'));

                if (! data) {
                    return;
                }

                $('#judul-modal-acara').text('Edit Acara');
                $('#input-idacara').val(data.idacara);
                $('#input-tema').val(data.tema);
                $('#input-ruang').val(data.ruang);
                $('#input-opsi-pilih').val(data.opsi_pilih || '1');
                $('#input-hari-ke').val(data.hari_ke);
                $('#input-jam-mulai').val(data.jam_mulai);
                $('#input-jam-akhir').val(data.jam_akhir);
                $('input[name="perlu_narsum"][value="' + (data.perlu_narsum ? '1' : '0') + '"]').prop('checked', true);
                $('#input-speaker').val(data.speaker);

                var $daftarNarasumber = $('#daftar-narasumber-readonly').empty();
                if (data.narasumberList && data.narasumberList.length > 0) {
                    data.narasumberList.forEach(function (ns) {
                        var teks = ns.nama + (ns.subtema ? ' (' + ns.subtema + ')' : '');
                        $('<div>').text(teks).appendTo($daftarNarasumber);
                    });
                } else {
                    $('<span>').addClass('text-muted fst-italic').text('Menunggu hasil review narasumber').appendTo($daftarNarasumber);
                }

                toggleSumberPembicara();

                if (data.has_child) {
                    $groupSelectInduk.hide();
                    $selectInduk.prop('disabled', true).val('');
                } else {
                    $groupSelectInduk.show();
                    $selectInduk.prop('disabled', false).val(data.idparent_acara || '');
                }

                $modal.modal('show');
            });

            $('#form-acara').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('.btn-submit-acara');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                var idacara = $('#input-idacara').val();
                var url = idacara ? updateUrl : tambahUrl;

                $.ajax({
                    url: url,
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
                    $modal.find('.modal-alert').removeClass('d-none').text(pesan);
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });

            $('.btn-hapus-acara').on('click', function () {
                var idacara = $(this).data('idacara');

                Swal.fire({
                    title: 'Hapus Acara?',
                    text: 'Acara ini akan dihapus (nonaktif).',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (! result.isConfirmed) {
                        return;
                    }

                    $.ajax({
                        url: hapusUrl,
                        method: 'POST',
                        data: { idacara: idacara },
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
                    });
                });
            });

            $('[data-bs-toggle="collapse"]').on('click', function () {
                $(this).toggleClass('expanded');
            });
        });
    </script>
@endsection
