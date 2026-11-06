@extends('layout.layout')

@section('title', 'Ajukan MoU Baru')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/tomSelect/tom-select.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}">
    <style>
        #modal-pilih-mitra .modal-content,
        #modal-pilih-pic .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
        #modal-pilih-pic .table { color: #0e1726 !important; }
        #modal-pilih-pic .table thead th { background-color: #f1f2f3 !important; color: #0e1726 !important; }

        #editor-catatan { height: 180px; background-color: #fff; }

        .card-lampiran-mou { border: 1px solid var(--bs-border-color); border-radius: .5rem; padding: 1rem; margin-bottom: 1rem; position: relative; }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peserta.mou.pengajuan') }}">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ajukan MoU Baru</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Ajukan MoU Baru</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="page-alert alert alert-danger d-none mb-3" role="alert"></div>

                <form id="form-pengajuan-mou">
                    <input type="hidden" name="idinstitusi_mitra" id="input-idinstitusi-mitra">
                    <input type="hidden" name="idpic_institusi_pengaju" id="input-idpic-pengaju">
                    <input type="hidden" name="catatan" id="input-catatan">

                    <div class="card-lampiran-mou">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-md-3 fw-bold">Mitra</div>
                            <div class="col-12 col-md-9">
                                <span id="label-mitra" class="text-muted">Belum dipilih</span>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="btn-pilih-mitra">Pilih Mitra</button>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 fw-bold">PIC (Institusi Anda)</div>
                            <div class="col-12 col-md-9">
                                <span id="label-pic" class="text-muted">Belum dipilih</span>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="btn-pilih-pic" data-bs-toggle="modal" data-bs-target="#modal-pilih-pic">Pilih PIC</button>
                            </div>
                        </div>
                    </div>

                    <div id="container-catatan"></div>
                    <div id="container-files"></div>

                    <button type="button" class="btn btn-outline-secondary" id="btn-tambah-catatan">
                        <i class="fa-solid fa-note-sticky me-1"></i> + Tambah Catatan
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="btn-tambah-file">
                        <i class="fa-solid fa-file-arrow-up me-1"></i> + Tambah File
                    </button>

                    <hr class="mt-4">

                    <button type="submit" class="btn btn-primary" id="btn-submit-pengajuan">
                        <span class="btn-label">Kirim Pengajuan</span>
                    </button>
                    <a href="{{ route('peserta.mou.pengajuan') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Template card catatan (disalin lewat JS) --}}
    <template id="template-card-catatan">
        <div class="card-lampiran-mou" id="card-catatan">
            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-hapus-catatan">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <label class="form-label fw-bold">Catatan</label>
            <div id="editor-catatan"></div>
        </div>
    </template>

    {{-- Template card file (disalin lewat JS, index diisi dinamis) --}}
    <template id="template-card-file">
        <div class="card-lampiran-mou card-file-mou">
            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-hapus-file">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="mb-3">
                <label class="form-label fw-bold">Tujuan File</label>
                <input type="text" class="form-control input-tujuan-file" maxlength="255" placeholder="Contoh: Draf naskah MoU">
            </div>
            <div class="mb-0">
                <label class="form-label fw-bold">Berkas (PDF/DOCX, maks. 5 MB)</label>
                <input type="file" class="form-control input-berkas-file" accept=".pdf,.docx">
            </div>
        </div>
    </template>

    {{-- Modal: Pilih Mitra --}}
    <div class="modal fade" id="modal-pilih-mitra" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-alert alert alert-danger d-none mb-3" role="alert"></div>

                    <div class="mb-3">
                        <label class="form-label" for="modal-jenis-institusi">Jenis Institusi</label>
                        <select id="modal-jenis-institusi" class="form-select">
                            <option value="">-- Pilih Jenis Institusi --</option>
                            @foreach($jenisInstitusiList as $jenis)
                                <option value="{{ $jenis->idjenis_institusi }}">{{ $jenis->nama_jenis_institusi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="modal-institusi-mitra">Institusi</label>
                        <select id="modal-institusi-mitra" placeholder="Pilih jenis institusi dahulu..."></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-konfirmasi-mitra" disabled>Pilih</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Pilih PIC --}}
    <div class="modal fade" id="modal-pilih-pic" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih PIC (Institusi Anda)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-outline-primary mb-3 btn-pic-saya-sendiri" data-idpengguna="{{ session('userdata')['idpengguna'] }}" data-nama="{{ session('userdata')['nama'] }}">
                        <i class="fa-solid fa-user me-1"></i> Saya Sendiri
                    </button>

                    <div class="table-responsive">
                        <table id="table-pilih-pic" class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesertaOptions as $opsi)
                                    <tr>
                                        <td>{{ $opsi->nama }}</td>
                                        <td>{{ $opsi->nama_jabatan }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-pilih-pic" data-idpengguna="{{ $opsi->idpengguna }}" data-nama="{{ $opsi->nama }}">
                                                Pilih PIC
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
    <script src="{{ asset('src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
    <script src="{{ asset('src/plugins/src/editors/quill/quill.js') }}"></script>
    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>

    <script>
        $(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var opsiMitraUrl = '{{ route('peserta.mou.pengajuan.opsi-mitra') }}';
            var simpanUrl = '{{ route('peserta.mou.pengajuan.simpan') }}';
            var daftarUrl = '{{ route('peserta.mou.pengajuan') }}';

            // ------- Pilih Mitra -------
            var tomSelectMitra = new TomSelect('#modal-institusi-mitra', {
                valueField: 'idinstitusi_asal',
                labelField: 'nama_institusi',
                searchField: ['nama_institusi'],
                options: [],
                create: false,
                placeholder: 'Pilih jenis institusi dahulu...',
                load: function (query, callback) {
                    var idJenisInstitusi = $('#modal-jenis-institusi').val();

                    if (!idJenisInstitusi) {
                        return callback();
                    }

                    fetch(opsiMitraUrl + '?idjenis_institusi=' + encodeURIComponent(idJenisInstitusi) + '&q=' + encodeURIComponent(query))
                        .then(function (response) { return response.json(); })
                        .then(function (res) { callback(res.data || []); })
                        .catch(function () { callback(); });
                },
            });

            $('#modal-jenis-institusi').on('change', function () {
                tomSelectMitra.clear();
                tomSelectMitra.clearOptions();
                tomSelectMitra.load('');
            });

            tomSelectMitra.on('change', function (value) {
                $('#btn-konfirmasi-mitra').prop('disabled', !value);
            });

            $('#btn-pilih-mitra').on('click', function () {
                $('#modal-pilih-mitra').modal('show');
            });

            $('#btn-konfirmasi-mitra').on('click', function () {
                var idinstitusi = tomSelectMitra.getValue();
                var data = tomSelectMitra.options[idinstitusi];

                if (!idinstitusi || !data) {
                    return;
                }

                $('#input-idinstitusi-mitra').val(idinstitusi);
                $('#label-mitra').removeClass('text-muted').text(data.nama_institusi);
                $('#btn-pilih-mitra').text('Ganti Mitra');
                $('#modal-pilih-mitra').modal('hide');
            });

            // ------- Pilih PIC -------
            function pilihPic(idpengguna, nama) {
                $('#input-idpic-pengaju').val(idpengguna);
                $('#label-pic').removeClass('text-muted').text(nama);
                $('#btn-pilih-pic').text('Ganti PIC');
                $('#modal-pilih-pic').modal('hide');
            }

            $('#table-pilih-pic').on('click', '.btn-pilih-pic', function () {
                pilihPic($(this).data('idpengguna'), $(this).data('nama'));
            });

            $('.btn-pic-saya-sendiri').on('click', function () {
                pilihPic($(this).data('idpengguna'), $(this).data('nama'));
            });

            // ------- Tambah Catatan (maksimal 1) -------
            var quillCatatan = null;

            $('#btn-tambah-catatan').on('click', function () {
                var html = document.getElementById('template-card-catatan').innerHTML;
                $('#container-catatan').html(html);

                quillCatatan = new Quill('#editor-catatan', {
                    theme: 'snow',
                    modules: { toolbar: [['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['link']] },
                });

                $(this).prop('disabled', true);
            });

            $('#container-catatan').on('click', '.btn-hapus-catatan', function () {
                $('#container-catatan').empty();
                quillCatatan = null;
                $('#btn-tambah-catatan').prop('disabled', false);
            });

            // ------- Tambah File (berulang) -------
            var indexFile = 0;

            $('#btn-tambah-file').on('click', function () {
                var html = document.getElementById('template-card-file').innerHTML;
                var $card = $(html);
                $card.attr('data-index', indexFile);
                $card.find('.input-tujuan-file').attr('name', 'files[' + indexFile + '][tujuan]');
                $card.find('.input-berkas-file').attr('name', 'files[' + indexFile + '][berkas]');
                $('#container-files').append($card);
                indexFile++;
            });

            $('#container-files').on('click', '.btn-hapus-file', function () {
                $(this).closest('.card-file-mou').remove();
            });

            // ------- Submit -------
            $('#form-pengajuan-mou').on('submit', function (e) {
                e.preventDefault();

                $('.page-alert').addClass('d-none').text('');

                if (!$('#input-idinstitusi-mitra').val()) {
                    $('.page-alert').removeClass('d-none').text('Pilih Mitra sebelum mengirim pengajuan.');
                    return;
                }

                if (!$('#input-idpic-pengaju').val()) {
                    $('.page-alert').removeClass('d-none').text('Pilih PIC sebelum mengirim pengajuan.');
                    return;
                }

                if (quillCatatan) {
                    var teksCatatan = quillCatatan.getText().trim();
                    $('#input-catatan').val(teksCatatan.length ? quillCatatan.root.innerHTML : '');
                }

                var $btn = $('#btn-submit-pengajuan');
                var teksAwal = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                var formData = new FormData(document.getElementById('form-pengajuan-mou'));

                $.ajax({
                    url: simpanUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message }).then(function () {
                        window.location.href = daftarUrl;
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
                })
                .always(function () {
                    $btn.prop('disabled', false).html(teksAwal);
                });
            });
        });
    </script>
@endsection
