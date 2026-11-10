@extends('layout.layout')

@section('title', 'Jadwal Temu')

@section('page-css')
    <style>
        .kotak-pertemuan {
            font-size: 12px;
            line-height: 1.4;
            border: 1px solid #4361ee;
            border-radius: 6px;
            padding: 6px 8px;
            background-color: rgba(67, 97, 238, 0.08);
        }

        #table-jadwal-temu th, #table-jadwal-temu td {
            vertical-align: top;
        }

        #table-jadwal-temu td {
            min-width: 200px;
        }

        /* `border-collapse: separate` (bukan default `collapse` punya
           `table-bordered`) — dengan border collapse, border kolom yang
           di-scroll ikut "menyatu" dengan border kolom sesi yang freeze
           di titik temunya, jadi waktu di-scroll keduanya rebutan di
           lapisan paling atas dan kelihatan tumpang tindih. Dipisah supaya
           kolom sesi konsisten selalu di atas (lihat z-index di bawah). */
        #table-jadwal-temu {
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Freeze kolom "Sesi" (kolom pertama) saat tabel di-scroll
           horizontal — pola Excel freeze pane. Kolom lain (z-index: 1)
           selalu di belakang kolom sesi (z-index: 2/3) saat di-scroll.
           Background putih solid (bukan var(--bs-table-bg), yang
           transparan di tema ini) supaya konten kolom lain tidak tembus
           pandang di baliknya. */
        #table-jadwal-temu th:not(:first-child),
        #table-jadwal-temu td:not(:first-child) {
            position: relative;
            z-index: 1;
        }

        #table-jadwal-temu th:first-child,
        #table-jadwal-temu td:first-child {
            position: sticky;
            left: 0;
            z-index: 2;
            background-color: #ffffff !important;
        }

        #table-jadwal-temu thead th:first-child {
            z-index: 3;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pengajuan MoU</a></li>
    <li class="breadcrumb-item active" aria-current="page">Jadwal Temu</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Jadwal Temu</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                @if($tanggalAktifList->isEmpty())
                    <p class="text-muted mb-0">Belum ada tanggal Temu Diskusi aktif.</p>
                @else
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 col-12">
                            <label for="select-tanggal-mou" class="form-label">Tanggal</label>
                            <select id="select-tanggal-mou" class="form-select">
                                @foreach($tanggalAktifList as $tanggal)
                                    <option value="{{ $tanggal->idtanggal_mou }}" @selected($tanggal->idtanggal_mou == $idTanggalTerpilih)>
                                        {{ \Carbon\Carbon::parse($tanggal->tanggal)->translatedFormat('d M Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table-jadwal-temu" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sesi</th>
                                    @foreach($ruangList as $ruang)
                                        <th>{{ $ruang->nama_ruang }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sesiList as $sesi)
                                    <tr>
                                        <td class="fw-bold">{{ substr($sesi->jam_mulai, 0, 5) }} - {{ substr($sesi->jam_akhir, 0, 5) }}</td>
                                        @foreach($ruangList as $ruang)
                                            @php $pertemuanSel = $pertemuanList->get($sesi->idsesi_mou.'-'.$ruang->idruang_mou, collect()); @endphp
                                            <td>
                                                @forelse($pertemuanSel as $pertemuan)
                                                    <div class="kotak-pertemuan @if(! $loop->last) mb-2 @endif">
                                                        <div><strong>Pengaju:</strong> {{ $pertemuan->nama_institusi_pengaju }} (PIC: {{ $pertemuan->nama_pic_pengaju ?? '-' }})</div>
                                                        <div><strong>Mitra:</strong> {{ $pertemuan->nama_institusi_mitra }} (PIC: {{ $pertemuan->nama_pic_mitra ?? '-' }})</div>
                                                    </div>
                                                @empty
                                                    <span class="text-muted">-</span>
                                                @endforelse
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $ruangList->count() + 1 }}" class="text-center text-muted">Belum ada sesi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('src/plugins/src/global/vendors.min.js') }}"></script>

    <script>
        $(function () {
            var jadwalTemuUrl = '{{ route('peserta.mou.jadwal-temu') }}';

            $('#select-tanggal-mou').on('change', function () {
                window.location.href = jadwalTemuUrl + '?idtanggal_mou=' + encodeURIComponent(this.value);
            });
        });
    </script>
@endsection
