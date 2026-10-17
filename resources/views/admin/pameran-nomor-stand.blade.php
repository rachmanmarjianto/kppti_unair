@extends('layout.layout')

@section('title', 'Nomor Stand Pameran')

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <style>
        /* dt-global_style.css mematok .page-link ke kotak 33x33px untuk tombol
           ikon — di halaman ini labelnya berupa teks ("Sebelumnya"/"Berikutnya"),
           jadi tombol sebelum/berikutnya perlu lebar otomatis supaya teksnya
           tidak tumpang tindih (paling kentara saat tabel kosong, karena saat
           itu cuma dua tombol ini yang berdampingan tanpa tombol halaman lain). */
        .dataTables_wrapper .page-item.previous .page-link,
        .dataTables_wrapper .page-item.next .page-link,
        .dataTables_wrapper .page-item.first .page-link,
        .dataTables_wrapper .page-item.last .page-link {
            width: auto;
            white-space: nowrap;
            padding: 0 12px;
        }

        .table-pameran-nomor-stand {
            width: 95% !important;
            margin: 0 auto;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Nomor Stand Pameran</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Nomor Stand Pameran</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div class="table-responsive">
                    <table id="table-pameran-nomor-stand" class="table table-hover table-bordered table-pameran-nomor-stand">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Jenis Institusi</th>
                                <th>Tema</th>
                                <th>PIC</th>
                                <th>No. WA</th>
                                <th>Jumlah Penjaga</th>
                                <th>Tanggal Loading</th>
                                <th>Nomor Stand</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pameran as $baris)
                                <tr>
                                    <td>{{ $baris->nama_institusi }}</td>
                                    <td>{{ $baris->nama_jenis_institusi }}</td>
                                    <td>{{ $baris->tema }}</td>
                                    <td>{{ $baris->nama_pic }}</td>
                                    <td>{{ $baris->no_wa_pic }}</td>
                                    <td>{{ $baris->jumlah_penjaga }}</td>
                                    <td>{{ $baris->jadwal_loading ? \Illuminate\Support\Carbon::parse($baris->jadwal_loading)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $baris->nomor_stand ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($baris->jumlah_penjaga > 0 && $baris->jadwal_loading && $baris->tagihan_lunas)
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-nomor-stand"
                                                    data-idpameran="{{ $baris->idpameran }}"
                                                    data-nama-institusi="{{ $baris->nama_institusi }}"
                                                    data-nomor-stand="{{ $baris->nomor_stand }}">
                                                {{ $baris->nomor_stand ? 'Ubah' : 'Beri Nomor Stand' }}
                                            </button>
                                        @elseif($baris->jumlah_penjaga == 0)
                                            <span style="font-size: 12.5px; color:red;">Belum ada penjaga</span>
                                        @elseif(! $baris->jadwal_loading)
                                            <span style="font-size: 12.5px; color:red;">Belum ada tanggal loading</span>
                                        @else
                                            <span style="font-size: 12.5px; color:red;">Tagihan belum lunas</span>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-penjaga-{{ $baris->idpameran }}">
                                            Kelola Penjaga
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: isi/ubah nomor stand --}}
    <div class="modal fade" id="modal-nomor-stand" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-nomor-stand">
                    <input type="hidden" name="idpameran" id="input-idpameran">
                    <div class="modal-header">
                        <h5 class="modal-title">Nomor Stand: <span id="judul-nama-institusi"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        <div class="mb-3">
                            <label class="form-label" for="input-nomor-stand">Nomor Stand</label>
                            <input type="text" name="nomor_stand" id="input-nomor-stand" class="form-control" maxlength="5" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-submit-nomor-stand">
                            <span class="btn-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: kelola penjaga stand, satu per baris pameran --}}
    @foreach($pameran as $baris)
        <div class="modal fade" id="modal-penjaga-{{ $baris->idpameran }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Penjaga Stand: {{ $baris->nama_institusi }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                        @for($slot = 0; $slot < 2; $slot++)
                            @php $petugas = $baris->penjaga->get($slot); @endphp
                            <label class="form-label fw-bold">Penjaga {{ $slot + 1 }}</label>

                            <div class="d-flex align-items-center gap-2 border rounded p-2 mb-3 tampilan-penjaga-terisi @unless($petugas) d-none @endunless">
                                <span class="flex-grow-1">{{ $petugas->nama ?? '' }}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-ganti-penjaga">Ganti</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-penjaga-admin" data-idpetugas-jaga="{{ $petugas->idpetugas_jaga ?? '' }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <form class="d-flex gap-2 mb-3 form-tambah-penjaga-admin @if($petugas) d-none @endif"
                                  data-idpameran="{{ $baris->idpameran }}"
                                  data-idpetugas-jaga-lama="{{ $petugas->idpetugas_jaga ?? '' }}">
                                <select name="idpeserta" class="form-control" required>
                                    <option value="">-- Pilih Peserta --</option>
                                    @foreach($baris->pesertaOptions->whereNotIn('idpeserta', $baris->penjaga->pluck('idpeserta')) as $opsi)
                                        <option value="{{ $opsi->idpeserta }}">{{ $opsi->nama }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary text-nowrap d-flex align-items-center justify-content-center">
                                    Simpan
                                </button>
                            </form>
                        @endfor
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('src/plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var updateUrl = '{{ route('admin.pameran.nomor-stand.update') }}';
            var $modal = $('#modal-nomor-stand');

            $('#table-pameran-nomor-stand').DataTable({
                dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ baris',
                    info: 'Menampilkan _START_ - _END_ dari _TOTAL_ baris',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(disaring dari _MAX_ baris)',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada pengajuan pameran yang Diterima.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                },
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: -1 }],
            });

            $('.btn-nomor-stand').on('click', function () {
                var $btn = $(this);

                $modal.find('.modal-alert').addClass('d-none').text('');
                $('#input-idpameran').val($btn.data('idpameran'));
                $('#judul-nama-institusi').text($btn.data('nama-institusi'));
                $('#input-nomor-stand').val($btn.data('nomor-stand'));

                $modal.modal('show');
            });

            $('#form-nomor-stand').on('submit', function (e) {
                e.preventDefault();

                var $btn = $('.btn-submit-nomor-stand');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $modal.find('.modal-alert').addClass('d-none').text('');

                $.ajax({
                    url: updateUrl,
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

            var tambahPenjagaUrl = '{{ route('admin.pameran.penjaga.tambah') }}';
            var hapusPenjagaUrl = '{{ route('admin.pameran.penjaga.hapus') }}';

            function tampilkanErrorPenjaga($form, xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else if (res.errors) {
                    pesan = Object.values(res.errors).flat().join('\n');
                }
                $form.closest('.modal-body').find('.modal-alert').removeClass('d-none').text(pesan);
            }

            $('.btn-ganti-penjaga').on('click', function () {
                var $tampilan = $(this).closest('.tampilan-penjaga-terisi');
                $tampilan.addClass('d-none');
                $tampilan.next('.form-tambah-penjaga-admin').removeClass('d-none');
            });

            $('.btn-hapus-penjaga-admin').on('click', function () {
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
                        tampilkanErrorPenjaga($btn, xhr);
                        $btn.prop('disabled', false);
                    });
                });
            });

            $('.form-tambah-penjaga-admin').on('submit', function (e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $form.closest('.modal-body').find('.modal-alert').addClass('d-none').text('');

                var idpameran = $form.data('idpameran');
                var idpetugasJagaLama = $form.data('idpetugas-jaga-lama');
                var idpeserta = $form.find('select[name="idpeserta"]').val();

                var hapusLama = idpetugasJagaLama
                    ? $.ajax({
                        url: hapusPenjagaUrl,
                        method: 'POST',
                        data: { idpetugas_jaga: idpetugasJagaLama },
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    : $.Deferred().resolve().promise();

                hapusLama
                    .then(function () {
                        return $.ajax({
                            url: tambahPenjagaUrl,
                            method: 'POST',
                            data: { idpameran: idpameran, idpeserta: idpeserta },
                            dataType: 'json',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                        });
                    })
                    .then(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            location.reload();
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanErrorPenjaga($form, xhr);
                    })
                    .always(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    });
            });
        });
    </script>
@endsection
