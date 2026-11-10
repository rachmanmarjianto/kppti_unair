@extends('layout.layout')

@section('title', 'Panggil Antrian')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/light/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/assets/css/dark/components/modal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-riwayat-dilayani .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-riwayat-dilayani .table { color: #0e1726 !important; }
        #modal-riwayat-dilayani .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }

        .kartu-nomor-antrian {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 48px;
            color: #4361ee;
        }

        .kartu-meja {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 22px;
        }

        #baris-antrian-list tr,
        #baris-terlewat-list tr {
            cursor: pointer;
        }

        .checkbox-hadir-peserta {
            width: 1.3em;
            height: 1.3em;
        }

        .checkbox-hadir-peserta:checked {
            background-color: #4361ee;
            border-color: #4361ee;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Panggil Antrian</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>
                            Panggil Antrian
                            @if($mejaRegis)
                                <span class="badge bg-primary ms-2">Meja Anda: {{ $mejaRegis->nomor_meja }}</span>
                            @endif
                        </h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <button type="button" class="btn btn-outline-primary" id="btn-riwayat-dilayani">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat Dilayani
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <div id="bagian-belum-dipetakan" class="d-none">
                    <p class="text-muted mb-0">Anda belum dipetakan ke meja registrasi mana pun. Hubungi Admin untuk dipetakan lewat menu "Kedatangan Kontingen → Petugas Meja".</p>
                </div>

                <div id="bagian-list" class="d-none">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="btn-panggil-antrian">
                            <span class="btn-label"><i class="fa-solid fa-bell me-1"></i> Panggil Antrian</span>
                        </button>
                        <button type="button" class="btn btn-outline-secondary float-end" id="btn-refresh-antrian">
                            <span class="btn-label"><i class="fa-solid fa-rotate me-1"></i> Refresh Antrian</span>
                        </button>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Institusi</th>
                            </tr>
                        </thead>
                        <tbody id="baris-antrian-list"></tbody>
                    </table>

                    <h5 class="mt-4 mb-3"><i class="fa-solid fa-ban me-1 text-danger"></i> Terlewat</h5>
                    <p class="text-muted">Klik baris untuk memanggil ulang institusi yang terlewat.</p>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Institusi</th>
                            </tr>
                        </thead>
                        <tbody id="baris-terlewat-list"></tbody>
                    </table>
                </div>

                <div id="bagian-kartu-dipanggil" class="d-none">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8 col-12">
                            <div class="kartu-nomor-antrian" id="kartu-dipanggil-nomor"></div>
                            <h4 class="mb-1" id="kartu-dipanggil-nama"></h4>
                            <span class="kartu-meja text-primary" id="kartu-dipanggil-meja"></span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary" id="btn-panggil-ulang">
                        <span class="btn-label"><i class="fa-solid fa-rotate me-1"></i> Panggil Lagi</span>
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="btn-terlewat">
                        <span class="btn-label"><i class="fa-solid fa-ban me-1"></i> Terlewat</span>
                    </button>
                    <button type="button" class="btn btn-success" id="btn-layani">
                        <span class="btn-label"><i class="fa-solid fa-user-check me-1"></i> Layani</span>
                    </button>
                </div>

                <div id="bagian-kartu-dilayani" class="d-none">
                    <h4 class="mb-3" id="kartu-dilayani-nama"></h4>

                    <a href="{{ route('petugas-meja-regis.unduh-pdf') }}" target="_blank" class="btn btn-outline-primary mb-3">
                        <i class="fa-solid fa-file-pdf me-1"></i> Unduh PDF Daftar Hadir
                    </a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">Hadir</th>
                                <th>Nama Peserta</th>
                                <th class="text-center">Foto Lengkap</th>
                                <th class="text-center">Narasumber</th>
                                <th class="text-center">Booth Crew</th>
                            </tr>
                        </thead>
                        <tbody id="baris-peserta-dilayani"></tbody>
                    </table>

                    <button type="button" class="btn btn-primary" id="btn-selesai-layani">
                        <span class="btn-label"><i class="fa-solid fa-check me-1"></i> Selesai Layani</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: riwayat antrian yang sudah ditangani petugas ini hari ini --}}
    <div class="modal fade" id="modal-riwayat-dilayani" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Dilayani Hari Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="riwayat-loading text-center py-4">
                        <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
                    </div>

                    <div class="table-responsive riwayat-content d-none">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor Antrian</th>
                                    <th>Institusi</th>
                                    <th>Status</th>
                                    <th>Waktu Daftar</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-riwayat-dilayani"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var panggilUrl = '{{ route('petugas-meja-regis.panggil') }}';
            var panggilUlangUrl = '{{ route('petugas-meja-regis.panggil-ulang') }}';
            var terlewatUrl = '{{ route('petugas-meja-regis.terlewat') }}';
            var layaniUrl = '{{ route('petugas-meja-regis.layani') }}';
            var toggleHadirUrl = '{{ route('petugas-meja-regis.toggle-hadir') }}';
            var selesaiLayaniUrl = '{{ route('petugas-meja-regis.selesai-layani') }}';
            var riwayatUrl = '{{ route('petugas-meja-regis.riwayat-dilayani') }}';
            var refreshListUrl = '{{ route('petugas-meja-regis.refresh-list') }}';

            var mejaRegis = {!! json_encode($mejaRegis) !!};
            var kartuAktifAwal = {!! json_encode($kartuAktif) !!};
            var antrianListAwal = {!! json_encode($antrianList) !!};
            var terlewatListAwal = {!! json_encode($terlewatList) !!};

            var STATUS_DIPANGGIL = '2';
            var STATUS_DILAYANI = '3';

            var $bagianBelumDipetakan = $('#bagian-belum-dipetakan');
            var $bagianList = $('#bagian-list');
            var $bagianDipanggil = $('#bagian-kartu-dipanggil');
            var $bagianDilayani = $('#bagian-kartu-dilayani');

            function tampilkanBagian($bagian) {
                $bagianBelumDipetakan.add($bagianList).add($bagianDipanggil).add($bagianDilayani).addClass('d-none');
                $bagian.removeClass('d-none');
            }

            function escapeHtml(teks) {
                return $('<div>').text(teks == null ? '' : teks).html();
            }

            function isiTabelAntrian($tbody, daftar, pesanKosong) {
                $tbody.empty();

                if (daftar.length === 0) {
                    $tbody.html('<tr><td colspan="2" class="text-center text-muted">' + pesanKosong + '</td></tr>');
                    return;
                }

                daftar.forEach(function (baris) {
                    $('<tr>')
                        .attr('data-token', baris.token)
                        .append($('<td>').text(baris.nomor_antrian))
                        .append($('<td>').text(baris.nama_institusi))
                        .appendTo($tbody);
                });
            }

            function renderList(data) {
                isiTabelAntrian($('#baris-antrian-list'), data.antrianList, 'Belum ada yang mengantri.');
                isiTabelAntrian($('#baris-terlewat-list'), data.terlewatList, 'Belum ada yang terlewat.');

                tampilkanBagian($bagianList);
            }

            function renderKartu(kartu) {
                if (kartu.status === STATUS_DILAYANI) {
                    $('#kartu-dilayani-nama').text(kartu.nama_institusi);

                    var $tbodyPeserta = $('#baris-peserta-dilayani').empty();

                    if (kartu.pesertaList.length === 0) {
                        $tbodyPeserta.html('<tr><td colspan="5" class="text-center text-muted">Belum ada peserta terdaftar.</td></tr>');
                    } else {
                        kartu.pesertaList.forEach(function (peserta) {
                            var $checkbox = $('<input>').attr({ type: 'checkbox', 'data-idpeserta': peserta.idpeserta }).addClass('form-check-input checkbox-hadir-peserta');
                            $checkbox.prop('checked', !!peserta.hadir);

                            var $status = $('<div>').addClass('status-hadir-peserta small mt-1');

                            var $fotoLengkap = peserta.fotoLengkap
                                ? $('<span>').text('Ya')
                                : $('<span>').addClass('text-danger').text('Belum');

                            var $centangNarasumber = peserta.isNarasumberDiterima
                                ? $('<i>').addClass('fa-solid fa-check text-success')
                                : $('<span>');

                            var $centangBoothCrew = peserta.isPetugasJaga
                                ? $('<i>').addClass('fa-solid fa-check text-success')
                                : $('<span>');

                            $('<tr>')
                                .append($('<td>').addClass('text-center').append($checkbox).append($status))
                                .append($('<td>').text(peserta.nama))
                                .append($('<td>').addClass('text-center').append($fotoLengkap))
                                .append($('<td>').addClass('text-center').append($centangNarasumber))
                                .append($('<td>').addClass('text-center').append($centangBoothCrew))
                                .appendTo($tbodyPeserta);
                        });
                    }

                    tampilkanBagian($bagianDilayani);
                } else {
                    $('#kartu-dipanggil-nomor').text(kartu.nomor_antrian);
                    $('#kartu-dipanggil-nama').text(kartu.nama_institusi);
                    $('#kartu-dipanggil-meja').text('Meja ' + kartu.nomor_meja);

                    tampilkanBagian($bagianDipanggil);
                }
            }

            function tampilkanErrorHalaman(xhr) {
                var res = xhr.responseJSON || {};
                var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                if (xhr.status === 0) {
                    pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                }
                $('.page-alert').removeClass('d-none').text(pesan);
            }

            // ===== State awal (render dari data PHP, tanpa AJAX) =====
            if (!mejaRegis) {
                tampilkanBagian($bagianBelumDipetakan);
            } else if (kartuAktifAwal) {
                renderKartu(kartuAktifAwal);
            } else {
                renderList({ antrianList: antrianListAwal, terlewatList: terlewatListAwal });
            }

            // ===== Panggil Antrian (teratas atau spesifik) =====
            function panggil(token, $btn) {
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: panggilUrl,
                    method: 'POST',
                    data: { token: token || '' },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                // `.always()` didaftarkan SEBELUM `.done()`/`.fail()` supaya
                // tombol pasti dikembalikan ke keadaan semula lebih dulu,
                // sebelum renderKartu()/tampilkanErrorHalaman() dijalankan —
                // kalau salah satu dari keduanya melempar error tak terduga,
                // tombol tidak ikut tersangkut dalam keadaan disabled/loader.
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                })
                .done(function (res) {
                    renderKartu(res.data);
                })
                .fail(function (xhr) {
                    tampilkanErrorHalaman(xhr);
                });
            }

            $('#btn-panggil-antrian').on('click', function () {
                panggil(null, $(this));
            });

            // Delegation ke #baris-antrian-list/#baris-terlewat-list (tbody
            // permanen), bukan ke baris <tr> yang dirender ulang tiap kali —
            // sesuai CONVENTIONS.md §6.8. Baris Terlewat yang diklik
            // dipanggil lewat proses yang sama persis dengan baris Antri.
            $('#baris-antrian-list, #baris-terlewat-list').on('click', 'tr', function () {
                panggil($(this).data('token'), $(this));
            });

            // ===== Panggil Lagi (disabled 5 detik) =====
            $('#btn-panggil-ulang').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: panggilUlangUrl,
                    method: 'POST',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                // `.always()` lebih dulu (lihat komentar di panggil()) —
                // jadwal re-enable 5 detik tetap terpasang apa pun yang
                // terjadi di render/error handler sesudahnya.
                .always(function () {
                    setTimeout(function () {
                        $btn.prop('disabled', false).html(teksAwal);
                    }, 5000);
                })
                .done(function (res) {
                    renderKartu(res.data);
                })
                .fail(function (xhr) {
                    tampilkanErrorHalaman(xhr);
                });
            });

            // ===== Refresh Antrian =====
            $('#btn-refresh-antrian').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memuat...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: refreshListUrl,
                    method: 'GET',
                    dataType: 'json',
                })
                // `.always()` lebih dulu (lihat komentar di panggil()).
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                })
                .done(function (res) {
                    renderList(res.data);
                })
                .fail(function (xhr) {
                    tampilkanErrorHalaman(xhr);
                });
            });

            // ===== Terlewat =====
            $('#btn-terlewat').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Tandai antrian ini terlewat?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, terlewat',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: terlewatUrl,
                        method: 'POST',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        renderList(res.data);
                    })
                    .fail(function (xhr) {
                        tampilkanErrorHalaman(xhr);
                    });
                });
            });

            // ===== Layani =====
            $('#btn-layani').on('click', function () {
                var $btn = $(this);
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $('.page-alert').addClass('d-none').text('');

                $.ajax({
                    url: layaniUrl,
                    method: 'POST',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                // `.always()` lebih dulu (lihat komentar di panggil()).
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                })
                .done(function (res) {
                    renderKartu(res.data);
                })
                .fail(function (xhr) {
                    tampilkanErrorHalaman(xhr);
                });
            });

            // ===== Checkbox kehadiran — langsung AJAX per-item =====
            $('#baris-peserta-dilayani').on('change', '.checkbox-hadir-peserta', function () {
                var $checkbox = $(this);
                var $status = $checkbox.siblings('.status-hadir-peserta');
                var idpeserta = $checkbox.data('idpeserta');
                var checked = $checkbox.is(':checked');

                $checkbox.prop('disabled', true);
                $status.html('<span class="text-muted">Proses...</span>');

                $.ajax({
                    url: toggleHadirUrl,
                    method: 'POST',
                    // boolean JS dikirim lewat form-encoding jadi string
                    // "true"/"false" — rule `boolean` Laravel hanya
                    // menerima true/false/1/0/"1"/"0", bukan string itu,
                    // jadi dikonversi ke 1/0 dulu di sini.
                    data: { idpeserta: idpeserta, checked: checked ? 1 : 0 },
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function () {
                    $status.html('<i class="fa-solid fa-circle-check text-success"></i>');
                })
                .fail(function (xhr) {
                    $checkbox.prop('checked', !checked);
                    $status.html('<i class="fa-solid fa-circle-xmark text-danger"></i>');
                    tampilkanErrorHalaman(xhr);
                })
                .always(function () {
                    $checkbox.prop('disabled', false);
                });
            });

            // ===== Selesai Layani =====
            $('#btn-selesai-layani').on('click', function () {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Selesaikan layanan untuk kontingen ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, selesai',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: selesaiLayaniUrl,
                        method: 'POST',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            renderList(res.data);
                        });
                    })
                    .fail(function (xhr) {
                        tampilkanErrorHalaman(xhr);
                    });
                });
            });

            // ===== Modal Riwayat Dilayani =====
            var $modalRiwayat = $('#modal-riwayat-dilayani');
            var $riwayatLoading = $modalRiwayat.find('.riwayat-loading');
            var $riwayatContent = $modalRiwayat.find('.riwayat-content');

            $('#btn-riwayat-dilayani').on('click', function () {
                $riwayatLoading.removeClass('d-none');
                $riwayatContent.addClass('d-none');
                $modalRiwayat.find('.modal-alert').addClass('d-none').text('');
                $modalRiwayat.modal('show');

                $.ajax({
                    url: riwayatUrl,
                    method: 'GET',
                    dataType: 'json',
                })
                .done(function (res) {
                    var daftar = res.data || [];
                    var $tbody = $('#tbody-riwayat-dilayani').empty();

                    if (daftar.length === 0) {
                        $tbody.html('<tr><td colspan="4" class="text-center text-muted">Belum ada antrian yang Anda tangani hari ini.</td></tr>');
                    } else {
                        daftar.forEach(function (baris) {
                            $('<tr>')
                                .append($('<td>').text(baris.nomor_antrian))
                                .append($('<td>').text(baris.nama_institusi))
                                .append($('<td>').text(baris.status_label))
                                .append($('<td>').text(baris.created_at))
                                .appendTo($tbody);
                        });
                    }

                    $riwayatLoading.addClass('d-none');
                    $riwayatContent.removeClass('d-none');
                })
                .fail(function (xhr) {
                    var res = xhr.responseJSON || {};
                    var pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';

                    $riwayatLoading.addClass('d-none');
                    $modalRiwayat.find('.modal-alert').removeClass('d-none').text(pesan);
                });
            });
        });
    </script>
@endsection
