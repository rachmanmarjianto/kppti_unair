<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Hadir</title>
    <style>
        @page {
            margin: 28px 32px;
        }

        body {
            margin: 0;
            font-family: Helvetica, Arial, sans-serif;
            color: #0e1726;
            font-size: 12px;
        }

        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .nama-institusi {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        table.daftar-peserta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table.daftar-peserta th, table.daftar-peserta td {
            border: 1px solid #0e1726;
            padding: 6px 8px;
        }

        table.daftar-peserta th {
            background: #eef1fb;
            text-align: left;
        }

        .kolom-nomor {
            width: 30px;
            text-align: center;
        }

        .kolom-centang {
            width: 60px;
            text-align: center;
        }

        .area-tanda-tangan {
            margin-top: 50px;
            width: 260px;
        }

        .garis-tanda-tangan {
            border-top: 1px solid #0e1726;
            margin-top: 60px;
            padding-top: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="judul">Daftar Hadir Registrasi Kontingen</div>
    <div class="nama-institusi">{{ $namaInstitusi }}</div>

    <table class="daftar-peserta">
        <thead>
            <tr>
                <th class="kolom-nomor">No</th>
                <th>Nama Peserta</th>
                <th class="kolom-centang">Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertaList as $peserta)
                <tr>
                    <td class="kolom-nomor">{{ $loop->iteration }}</td>
                    <td>{{ $peserta->nama }}</td>
                    <td class="kolom-centang">&#9633;</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Belum ada peserta terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="area-tanda-tangan">
        <div class="garis-tanda-tangan">Tanda Tangan &amp; Nama Perwakilan</div>
    </div>
</body>
</html>
