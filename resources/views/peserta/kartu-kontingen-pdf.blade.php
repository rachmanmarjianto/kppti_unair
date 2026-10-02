<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Registrasi Kontingen</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 28px 20px;
            font-family: Helvetica, Arial, sans-serif;
            color: #0e1726;
        }

        .konten {
            margin-top: 150px;
        }

        .logo-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .logo-table td {
            width: 50%;
            vertical-align: middle;
        }

        .logo-table td.kanan {
            text-align: right;
        }

        .logo-table img {
            height: 48px;
        }

        .garis {
            border-top: 2px solid #4361ee;
            margin: 0 0 22px 0;
        }

        .judul {
            text-align: center;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #4361ee;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .nama-institusi {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            line-height: 1.3;
            margin: 0 auto 34px auto;
            padding: 0 10px;
        }

        .qr-wrapper {
            text-align: center;
            margin-bottom: 10px;
        }

        .qr-wrapper img {
            width: 190px;
            height: 190px;
        }

        .kode-kontingen {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #0e1726;
        }

        .kode-kontingen-label {
            text-align: center;
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <table class="logo-table">
        <tr>
            <td class="kiri"><img src="{{ $logoUnairPath }}" alt="Logo Unair"></td>
            <td class="kanan"><img src="{{ $logoKpptiPath }}" alt="Logo KPPTI"></td>
        </tr>
    </table>

    <div class="garis"></div>

    <div class="konten">
        <div class="judul">Kartu Registrasi Kontingen</div>
        <div class="nama-institusi">{{ $namaInstitusi }}</div>

        <div class="qr-wrapper">
            <img src="{{ $qrDataUri }}" alt="QR Code Kode Kontingen">
        </div>

        <div class="kode-kontingen-label">Kode Kontingen</div>
        <div class="kode-kontingen">{{ $kodeKontingen }}</div>
    </div>
</body>
</html>
