<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Antrian Registrasi Kontingen - KPPTI 2026</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('src/assets/img/favicon.ico') }}"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&family=Poppins:500,600,700,800&display=swap" rel="stylesheet">
    <link href="{{ asset('src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --kppti-navy: #0b1f4b;
            --kppti-navy-dark: #071433;
            --kppti-gold: #d4a437;
            --kppti-gold-light: #f3d27a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 15% 20%, rgba(212, 164, 55, 0.25), transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(172, 31, 45, 0.25), transparent 45%),
                linear-gradient(150deg, var(--kppti-navy) 0%, var(--kppti-navy-dark) 100%);
            padding: 24px;
        }

        .kppti-kartu-landing {
            width: 100%;
            max-width: 640px;
            background: #fff;
            border-radius: 20px;
            padding: 56px 48px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
        }

        .kppti-logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .kppti-logo-row img {
            height: 48px;
            width: auto;
        }

        .kppti-logo-divider {
            width: 1px;
            height: 36px;
            background: #dfe3ec;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 26px;
            color: var(--kppti-navy);
            margin: 0 0 10px;
        }

        .kppti-kartu-landing p.kppti-subjudul {
            font-size: 15.5px;
            color: #666;
            margin: 0 0 36px;
        }

        .kppti-pilihan {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .kppti-tombol-pilihan {
            flex: 1 1 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            padding: 32px 20px;
            border-radius: 16px;
            border: 2px solid #dfe3ec;
            text-decoration: none;
            color: var(--kppti-navy);
            transition: all .15s ease;
        }

        .kppti-tombol-pilihan:hover {
            border-color: var(--kppti-gold);
            background: #fdf8ef;
            color: var(--kppti-navy);
        }

        .kppti-tombol-pilihan .ikon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #fff;
            background: linear-gradient(135deg, var(--kppti-gold), var(--kppti-gold-light));
        }

        .kppti-tombol-pilihan .label {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 17px;
        }
    </style>
</head>
<body>

    <div class="kppti-kartu-landing">
        <div class="kppti-logo-row">
            <img src="{{ asset('src/assets/img/logo_unair_kecil.png') }}" alt="Logo Universitas Airlangga">
            <span class="kppti-logo-divider"></span>
            <img src="{{ asset('src/assets/img/kppti_logo.png') }}" alt="Logo KPPTI"
                 onerror="this.style.display='none'">
        </div>

        <h1>Antrian Registrasi Kontingen</h1>
        <p class="kppti-subjudul">Pilih salah satu di bawah ini</p>

        <div class="kppti-pilihan">
            <a href="{{ route('antrian.ambil-nomor') }}" class="kppti-tombol-pilihan">
                <span class="ikon"><i class="fa-solid fa-ticket"></i></span>
                <span class="label">Registrasi Antrian</span>
            </a>
            <a href="{{ route('antrian.tampilan') }}" class="kppti-tombol-pilihan">
                <span class="ikon"><i class="fa-solid fa-tv"></i></span>
                <span class="label">Tampilan Antrian</span>
            </a>
        </div>
    </div>

</body>
</html>
