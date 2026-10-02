<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $jadwal->nama_jadwal ?? 'Sesi Ditutup' }} - KPPTI | Konferensi Puncak Pendidikan Tinggi</title>
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
            --kppti-red: #ac1f2d;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f4f6fb;
            min-height: 100vh;
            margin: 0;
        }

        .kppti-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ===== LEFT BRAND PANEL ===== */
        .kppti-brand {
            position: relative;
            flex: 1 1 55%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 64px;
            color: #fff;
            overflow: hidden;
            background:
                radial-gradient(circle at 15% 20%, rgba(212, 164, 55, 0.25), transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(172, 31, 45, 0.35), transparent 45%),
                linear-gradient(150deg, var(--kppti-navy) 0%, var(--kppti-navy-dark) 100%);
        }

        .kppti-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.9), rgba(0,0,0,0.1));
            pointer-events: none;
        }

        .kppti-brand::after {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            right: -180px;
            bottom: -180px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 60px rgba(255, 255, 255, 0.03);
            pointer-events: none;
        }

        .kppti-brand-inner { position: relative; z-index: 1; }

        .kppti-logo-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .kppti-logo-row img {
            height: 46px;
            width: auto;
            background: #fff;
            border-radius: 10px;
            padding: 6px 10px;
        }

        .kppti-logo-row .kppti-logo-fallback {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 46px;
            width: 46px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--kppti-gold), var(--kppti-gold-light));
            color: var(--kppti-navy-dark);
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }

        .kppti-logo-divider {
            width: 1px;
            height: 34px;
            background: rgba(255, 255, 255, 0.25);
        }

        .kppti-logo-row img.kppti-partner-logo {
            height: 68px;
            width: auto;
            max-width: 110px;
            object-fit: contain;
            background: none;
            border-radius: 0;
            padding: 0;
        }

        .kppti-event-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 2px;
            color: var(--kppti-gold-light);
            text-transform: uppercase;
        }

        .kppti-event-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            letter-spacing: 0.5px;
        }

        .kppti-tagline {
            margin-top: 54px;
            max-width: 480px;
        }

        .kppti-tagline .kppti-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--kppti-gold-light);
            margin-bottom: 22px;
        }

        .kppti-tagline h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 38px;
            line-height: 1.28;
            margin: 0 0 18px;
        }

        .kppti-tagline h1 span {
            color: var(--kppti-gold-light);
        }

        .kppti-tagline p {
            font-size: 15.5px;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.75);
            margin: 0;
        }

        .kppti-stats {
            display: flex;
            gap: 36px;
            margin-top: 48px;
            flex-wrap: wrap;
        }

        .kppti-stats .stat h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 26px;
            margin: 0;
            color: #fff;
        }

        .kppti-stats .stat span {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.3px;
        }

        .kppti-audience {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 40px;
        }

        .kppti-audience .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.85);
        }

        .kppti-audience .chip svg { flex: none; }

        /* ===== RIGHT: STATUS PANEL ===== */
        .kppti-form-panel {
            flex: 1 1 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 48px;
        }

        .kppti-status-card {
            max-width: 420px;
            text-align: center;
        }

        .kppti-status-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--kppti-gold), var(--kppti-gold-light));
            color: var(--kppti-navy-dark);
            font-size: 30px;
            margin-bottom: 24px;
        }

        .kppti-status-card h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: var(--kppti-navy);
            margin: 0 0 12px;
        }

        .kppti-status-card p {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin: 0 0 28px;
        }

        .kppti-status-card .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 10px;
            background: var(--kppti-navy);
            color: #fff;
            font-weight: 700;
            text-decoration: none;
            font-size: 14.5px;
        }

        .kppti-status-card .btn-kembali:hover {
            background: var(--kppti-navy-dark);
            color: #fff;
        }

        @media (max-width: 991.98px) {
            .kppti-brand { display: none; }
            .kppti-form-panel { flex: 1 1 100%; }
        }
    </style>
</head>
<body>

    <div class="kppti-wrapper">

        <!-- ===== LEFT: EVENT BRANDING ===== -->
        <div class="kppti-brand">
            <div class="kppti-brand-inner">
                <div class="kppti-logo-row">
                    <img class="kppti-partner-logo" src="{{ asset('src/assets/img/logo_unair_kecil.png') }}" alt="Logo Universitas Airlangga">
                    <span class="kppti-logo-divider"></span>
                    <img src="{{ asset('src/assets/img/kppti_logo.png') }}" alt="Logo KPPTI"
                         onerror="this.replaceWith(Object.assign(document.createElement('div'), {className: 'kppti-logo-fallback', innerText: 'KPPTI'}))">
                    <div>
                        <div class="kppti-event-name">KPPTI 2026</div>
                        <div class="kppti-event-sub">Konferensi Puncak Pendidikan Tinggi</div>
                    </div>
                </div>

                <div class="kppti-tagline">
                    <span class="kppti-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                        Konferensi Puncak Pendidikan Tinggi
                    </span>
                    <h1>Menyatukan Langkah <span>Perguruan Tinggi</span> Indonesia</h1>
                    <p>
                        Portal resmi pendaftaran peserta KPPTI &mdash; ruang temu perguruan tinggi negeri &amp; swasta,
                        asosiasi pendidikan, lembaga akreditasi, dan pemerhati pendidikan dari seluruh
                        Indonesia untuk merumuskan arah pendidikan tinggi nasional.
                    </p>
                </div>

                <div class="kppti-stats">
                    <div class="stat">
                        <h3>1000+</h3>
                        <span>Perguruan Tinggi</span>
                    </div>
                    <div class="stat">
                        <h3>34</h3>
                        <span>Provinsi</span>
                    </div>
                    <div class="stat">
                        <h3>17</h3>
                        <span>Wilayah LLDikti</span>
                    </div>
                </div>
            </div>

            <div class="kppti-audience">
                <span class="chip">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"></path><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"></path></svg>
                    PTN &amp; PTS
                </span>
                <span class="chip">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M6 21v-2a6 6 0 0 1 12 0v2"></path></svg>
                    Asosiasi Pendidikan
                </span>
                <span class="chip">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><path d="M8.5 13.5 6 21l6-3 6 3-2.5-7.5"></path></svg>
                    Lembaga Akreditasi
                </span>
                <span class="chip">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Pemerhati Pendidikan
                </span>
            </div>
        </div>

        <!-- ===== RIGHT: STATUS SESI ===== -->
        <div class="kppti-form-panel">
            <div class="kppti-status-card">
                <div class="kppti-status-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                @php
                    $sekarang = now();
                    $namaSesi = $jadwal->nama_jadwal ?? 'Sesi ini';
                @endphp

                @if(! $jadwal)
                    <h1>Sesi Tidak Tersedia</h1>
                    <p>Sesi ini sedang tidak tersedia. Silakan hubungi panitia untuk informasi lebih lanjut.</p>
                @elseif($jadwal->timestamp_buka && $sekarang->lt($jadwal->timestamp_buka))
                    <h1>{{ $namaSesi }} Belum Dibuka</h1>
                    <p>
                        {{ $namaSesi }} akan dibuka pada<br>
                        <strong>{{ \Carbon\Carbon::parse($jadwal->timestamp_buka)->translatedFormat('d F Y, H:i') }} WIB</strong>.
                    </p>
                @elseif($jadwal->timestamp_tutup && $sekarang->gt($jadwal->timestamp_tutup))
                    <h1>{{ $namaSesi }} Telah Ditutup</h1>
                    <p>
                        {{ $namaSesi }} telah ditutup pada<br>
                        <strong>{{ \Carbon\Carbon::parse($jadwal->timestamp_tutup)->translatedFormat('d F Y, H:i') }} WIB</strong>.
                    </p>
                @else
                    <h1>{{ $namaSesi }} Sedang Ditutup</h1>
                    <p>Sesi ini sedang tidak dapat diakses saat ini. Silakan coba lagi nanti.</p>
                @endif

                <a href="{{ route('login') }}" class="btn-kembali">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>

    </div>

</body>
</html>
