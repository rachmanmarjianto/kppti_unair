<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Masuk - KPPTI | Konferensi Puncak Pendidikan Tinggi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('src/assets/img/favicon.ico') }}"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&family=Poppins:500,600,700,800&display=swap" rel="stylesheet">
    <link href="{{ asset('src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

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

        /* ===== RIGHT FORM PANEL ===== */
        .kppti-form-panel {
            flex: 1 1 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: #f4f6fb;
        }

        .kppti-form-card {
            width: 100%;
            max-width: 420px;
        }

        .kppti-form-card .form-heading {
            margin-bottom: 34px;
        }

        .kppti-form-card .form-heading .eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--kppti-red);
            margin-bottom: 10px;
        }

        .kppti-form-card .form-heading h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 26px;
            color: var(--kppti-navy);
            margin: 0 0 8px;
        }

        .kppti-form-card .form-heading p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .kppti-input-group {
            margin-bottom: 18px;
        }

        .kppti-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--kppti-navy);
            margin-bottom: 8px;
        }

        .kppti-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .kppti-input-wrap > svg {
            position: absolute;
            left: 14px;
            color: #9aa4b2;
            pointer-events: none;
        }

        .kppti-input-wrap .toggle-password {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #9aa4b2;
            background: none;
            border: none;
            border-radius: 8px;
            padding: 0;
            transition: background-color .15s ease, color .15s ease;
        }

        .kppti-input-wrap .toggle-password:hover,
        .kppti-input-wrap .toggle-password:focus-visible {
            background-color: #eef1f7;
            color: var(--kppti-navy);
            outline: none;
        }

        .kppti-input-wrap input {
            width: 100%;
            padding: 13px 14px 13px 44px;
            border-radius: 10px;
            border: 1.5px solid #e3e7ee;
            font-size: 14.5px;
            color: #1f2937;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .kppti-input-wrap input.has-toggle {
            padding-right: 44px;
        }

        .kppti-input-wrap input:focus {
            outline: none;
            border-color: var(--kppti-navy);
            box-shadow: 0 0 0 3px rgba(11, 31, 75, 0.12);
        }

        .kppti-form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .kppti-form-row .form-check-label {
            font-size: 13.5px;
            color: #4b5563;
        }

        .kppti-form-row a {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--kppti-navy);
            text-decoration: none;
        }

        .kppti-form-row a:hover { color: var(--kppti-red); }

        .btn-kppti-login {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--kppti-navy), var(--kppti-navy-dark));
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.3px;
            box-shadow: 0 10px 20px -8px rgba(11, 31, 75, 0.55);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-kppti-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -8px rgba(11, 31, 75, 0.6);
            color: #fff;
        }

        .kppti-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 26px 0;
            color: #9aa4b2;
            font-size: 12.5px;
        }

        .kppti-divider::before,
        .kppti-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e3e7ee;
        }

        .kppti-footnote {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        .kppti-footnote a {
            color: var(--kppti-navy);
            font-weight: 700;
            text-decoration: none;
        }

        .kppti-page-footer {
            text-align: center;
            font-size: 12px;
            color: #9aa4b2;
            margin-top: 28px;
        }

        .invalid-feedback { display: block; }

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

        <!-- ===== RIGHT: LOGIN FORM ===== -->
        <div class="kppti-form-panel">
            <div class="kppti-form-card">

                <div class="form-heading">
                    <span class="eyebrow">Portal Peserta</span>
                    <h2>Selamat Datang Kembali</h2>
                    <p>Masuk untuk mengelola pendaftaran dan partisipasi Anda di KPPTI.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 px-3" role="alert" style="font-size: 13.5px; border-radius: 10px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success py-2 px-3" role="alert" style="font-size: 13.5px; border-radius: 10px;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}">
                    @csrf

                    <div class="kppti-input-group">
                        <label for="email">Email</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" opacity="0"></path><path d="M22 6 12 13 2 6"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                            <input id="email" type="email" name="email" class="@error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="nama@institusi.ac.id"
                                   required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="password">Kata Sandi</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="password" type="password" name="password" class="has-toggle @error('password') is-invalid @enderror"
                                   placeholder="Masukkan kata sandi" required autocomplete="current-password">
                            <button type="button" class="toggle-password" onclick="kpptiTogglePassword()" aria-label="Tampilkan kata sandi">
                                <svg id="kpptiEyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-kppti-login">Masuk</button>
                </form>

                <div class="kppti-divider">belum terdaftar</div>

                <p class="kppti-footnote">
                    Institusi Anda belum terdaftar?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Daftar sebagai peserta</a>
                    @else
                        <a href="#">Daftar sebagai peserta</a>
                    @endif
                </p>

                <p class="kppti-page-footer">&copy; {{ date('Y') }} KPPTI &mdash; Konferensi Puncak Pendidikan Tinggi</p>
            </div>
        </div>

    </div>

    <script>
        function kpptiTogglePassword() {
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';

            document.getElementById('kpptiEyeIcon').innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.87 19.87 0 0 1 4.22-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a19.79 19.79 0 0 1-2.16 3.19"></path><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    </script>

</body>
</html>
