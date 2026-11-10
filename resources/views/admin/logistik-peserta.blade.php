@extends('layout.layout')

@section('title', 'Edit Logistik Peserta')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.peserta') }}">Manajemen Peserta</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Logistik</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                        <h4>Data Logistik — {{ $peserta->nama }}</h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-md-end mt-2 mt-md-0">
                        <a href="{{ route('admin.peserta') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Manajemen Peserta
                        </a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <form id="form-logistik-peserta">
                    <input type="hidden" name="idpeserta" value="{{ $idpeserta }}">

                    @if($pesertaLainLengkap->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Salin Data dari Peserta Lain</label>
                            <div class="input-group">
                                <select class="form-select select-copy-dari-peserta">
                                    <option value="" selected>-- Pilih peserta yang datanya sudah lengkap --</option>
                                    @foreach ($pesertaLainLengkap as $p)
                                        <option value="{{ $p->idpeserta }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-secondary btn-salin-logistik">
                                    <i class="fa-solid fa-copy me-1"></i> Salin
                                </button>
                            </div>
                            <div class="form-text">Hanya menyalin data logistik (transportasi, hotel, city tour) — data belum tersimpan sampai Anda klik Simpan.</div>
                        </div>
                    @endif

                    <h6>Kedatangan</h6>
                    <div class="mb-3">
                        <label class="form-label">Jenis Transportasi</label>
                        <select name="idjenis_transportasi_kedatangan" class="form-select select-transport-kedatangan" required>
                            <option value="">Pilih jenis transportasi...</option>
                            @foreach ($jenisTransportOptions as $jt)
                                <option value="{{ $jt->idjenis_transport }}" @selected($logistik->idjenis_transportasi_kedatangan == $jt->idjenis_transport)>{{ $jt->nama_jenis_transport }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 group-stasiun-kedatangan">
                        <label class="form-label">Stasiun/Titik Kedatangan</label>
                        <input type="text" name="stasiun_kedatangan" class="form-control" maxlength="255" value="{{ $logistik->stasiun_kedatangan }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kedatangan</label>
                            <input type="date" name="tanggal_kedatangan" class="form-control" required value="{{ $logistik->tanggal_kedatangan }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Kedatangan</label>
                            <input type="time" name="jam_kedatangan" class="form-control" required value="{{ $logistik->jam_kedatangan ? substr($logistik->jam_kedatangan, 0, 5) : '' }}">
                        </div>
                    </div>

                    <hr>

                    <h6>Kepulangan</h6>
                    <div class="mb-3">
                        <label class="form-label">Jenis Transportasi</label>
                        <select name="idjenis_transportasi_kepulangan" class="form-select select-transport-kepulangan" required>
                            <option value="">Pilih jenis transportasi...</option>
                            @foreach ($jenisTransportOptions as $jt)
                                <option value="{{ $jt->idjenis_transport }}" @selected($logistik->idjenis_transportasi_kepulangan == $jt->idjenis_transport)>{{ $jt->nama_jenis_transport }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 group-stasiun-kepulangan">
                        <label class="form-label">Stasiun/Titik Kepulangan</label>
                        <input type="text" name="stasiun_kepulangan" class="form-control" maxlength="255" value="{{ $logistik->stasiun_kepulangan }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kepulangan</label>
                            <input type="date" name="tanggal_kepulangan" class="form-control" required value="{{ $logistik->tanggal_kepulangan }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Kepulangan</label>
                            <input type="time" name="jam_kepulangan" class="form-control" required value="{{ $logistik->jam_kepulangan ? substr($logistik->jam_kepulangan, 0, 5) : '' }}">
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Nama Hotel (opsional)</label>
                        <input type="text" name="nama_hotel" class="form-control" maxlength="255" value="{{ $logistik->nama_hotel }}">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="city_tour" value="1" class="form-check-input" id="check-city-tour" @checked($logistik->city_tour)>
                        <label class="form-check-label" for="check-city-tour">Mengikuti City Tour</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-simpan-logistik">
                        <span class="btn-label">Simpan</span>
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
            var updateLogistikUrl = '{{ route('admin.peserta.logistik.update') }}';
            var pesertaListUrl = '{{ route('admin.peserta') }}';
            var idKendaraanPribadi = {{ (int) $idKendaraanPribadi }};
            var pesertaLainData = {!! json_encode($pesertaLainLengkap->keyBy('idpeserta')) !!};

            var $form = $('#form-logistik-peserta');
            var $selectTransportKedatangan = $form.find('.select-transport-kedatangan');
            var $selectTransportKepulangan = $form.find('.select-transport-kepulangan');
            var $groupStasiunKedatangan = $form.find('.group-stasiun-kedatangan');
            var $groupStasiunKepulangan = $form.find('.group-stasiun-kepulangan');
            var $selectCopyDariPeserta = $form.find('.select-copy-dari-peserta');

            function toggleStasiun($select, $group) {
                var isKendaraanPribadi = parseInt($select.val(), 10) === idKendaraanPribadi;
                $group.toggle(!isKendaraanPribadi);
                $group.find('input').prop('required', !isKendaraanPribadi);
                if (isKendaraanPribadi) {
                    $group.find('input').val('');
                }
            }

            toggleStasiun($selectTransportKedatangan, $groupStasiunKedatangan);
            toggleStasiun($selectTransportKepulangan, $groupStasiunKepulangan);

            $selectTransportKedatangan.on('change', function () {
                toggleStasiun($selectTransportKedatangan, $groupStasiunKedatangan);
            });

            $selectTransportKepulangan.on('change', function () {
                toggleStasiun($selectTransportKepulangan, $groupStasiunKepulangan);
            });

            function isiFormLogistik(data) {
                $selectTransportKedatangan.val(data.idjenis_transportasi_kedatangan);
                $form.find('[name="stasiun_kedatangan"]').val(data.stasiun_kedatangan);
                $form.find('[name="tanggal_kedatangan"]').val(data.tanggal_kedatangan);
                $form.find('[name="jam_kedatangan"]').val(data.jam_kedatangan ? data.jam_kedatangan.substring(0, 5) : '');
                $selectTransportKepulangan.val(data.idjenis_transportasi_kepulangan);
                $form.find('[name="stasiun_kepulangan"]').val(data.stasiun_kepulangan);
                $form.find('[name="tanggal_kepulangan"]').val(data.tanggal_kepulangan);
                $form.find('[name="jam_kepulangan"]').val(data.jam_kepulangan ? data.jam_kepulangan.substring(0, 5) : '');
                $form.find('[name="nama_hotel"]').val(data.nama_hotel);
                $form.find('[name="city_tour"]').prop('checked', !!data.city_tour);

                toggleStasiun($selectTransportKedatangan, $groupStasiunKedatangan);
                toggleStasiun($selectTransportKepulangan, $groupStasiunKepulangan);
            }

            $form.find('.btn-salin-logistik').on('click', function () {
                var idpesertaSumber = $selectCopyDariPeserta.val();

                if (!idpesertaSumber) {
                    $('.page-alert').removeClass('d-none').text('Pilih peserta sumber data terlebih dahulu.');

                    return;
                }

                isiFormLogistik(pesertaLainData[idpesertaSumber]);
            });

            $form.on('submit', function (e) {
                e.preventDefault();

                if (!$form[0].reportValidity()) {
                    return;
                }

                var $btn = $form.find('.btn-simpan-logistik');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Simpan perubahan data logistik peserta ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var teksAwal = $btn.html();
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                    $('.page-alert').addClass('d-none').text('');

                    $.ajax({
                        url: updateLogistikUrl,
                        method: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    })
                    .done(function (res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                            window.location.href = pesertaListUrl;
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
        });
    </script>
@endsection
