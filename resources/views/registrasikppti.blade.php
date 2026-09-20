<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Registrasi Peserta - KPPTI | Konferensi Puncak Pendidikan Tinggi</title>
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

        .kppti-input-wrap input,
        .kppti-input-wrap select {
            width: 100%;
            padding: 13px 14px 13px 44px;
            border-radius: 10px;
            border: 1.5px solid #e3e7ee;
            font-size: 14.5px;
            color: #1f2937;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .kppti-input-wrap select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .kppti-input-wrap input.has-toggle {
            padding-right: 44px;
        }

        .kppti-input-wrap input:focus,
        .kppti-input-wrap select:focus {
            outline: none;
            border-color: var(--kppti-navy);
            box-shadow: 0 0 0 3px rgba(11, 31, 75, 0.12);
        }

        .kppti-input-wrap input.is-valid {
            border-color: #1e9e5a;
        }

        .kppti-input-wrap input.is-invalid {
            border-color: var(--kppti-red);
        }

        .kppti-field-hint {
            font-size: 12.5px;
            margin-top: 6px;
            min-height: 16px;
        }

        .kppti-field-hint.text-danger { color: var(--kppti-red); }
        .kppti-field-hint.text-success { color: #1e9e5a; }

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
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }

        .btn-kppti-login:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -8px rgba(11, 31, 75, 0.6);
            color: #fff;
        }

        .btn-kppti-login:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
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

        <!-- ===== RIGHT: REGISTRATION FORM ===== -->
        <div class="kppti-form-panel">
            <div class="kppti-form-card">

                <div class="form-heading">
                    <span class="eyebrow">Portal Peserta</span>
                    <h2>Registrasi Peserta</h2>
                    <p>Lengkapi data berikut untuk mendaftar sebagai peserta KPPTI.</p>
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

                <form id="formRegistrasiKppti" method="POST" action="{{ Route::has('registrasi_kppti.store') ? route('registrasi_kppti.store') : url('/registrasi-kppti') }}">
                    @csrf

                    <div class="kppti-input-group">
                        <label for="nama">Nama Lengkap</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input id="nama" type="text" name="nama" class="@error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" placeholder="Nama lengkap Anda"
                                   required autocomplete="name" autofocus>
                        </div>
                        <div class="kppti-field-hint"></div>
                        @error('nama')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="jenis_institusi">Jenis Institusi Asal</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M5 21V7l7-4 7 4v14"></path><path d="M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"></path></svg>
                            <select id="jenis_institusi" name="jenis_institusi" class="@error('jenis_institusi') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih jenis institusi</option>
                                @foreach($institusi_asal as $institusi)
                                    <option value="{{ $institusi->idjenis_institusi }}" {{ old('jenis_institusi') == $institusi->idjenis_institusi ? 'selected' : '' }}>
                                        {{ $institusi->nama_jenis_institusi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="kppti-field-hint"></div>
                        @error('jenis_institusi')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="nomor_wa">Nomor WhatsApp</label>
                        <div style="display: flex; gap: 10px; align-items: flex-start;">
                            <div class="kppti-input-wrap" style="flex: 1;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <input id="nomor_wa" type="text" name="nomor_wa" inputmode="numeric" class="@error('nomor_wa') is-invalid @enderror"
                                       value="{{ old('nomor_wa') }}" placeholder="08xxxxxxxxxx"
                                       required autocomplete="tel">
                            </div>
                            <button type="button" id="btnKirimOtp" class="btn btn-kppti-login" style="width: auto; white-space: nowrap; padding: 13px 18px;">Kirim OTP</button>
                        </div>
                        <div id="waHint" class="kppti-field-hint"></div>
                        @error('nomor_wa')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="otp">Kode OTP</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="otp" type="text" name="otp" inputmode="numeric" maxlength="6" class="@error('otp') is-invalid @enderror"
                                   value="{{ old('otp') }}" placeholder="Masukkan kode OTP" required>
                        </div>
                        <div class="kppti-field-hint"></div>
                        @error('otp')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="email">Email</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 6 12 13 2 6"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                            <input id="email" type="text" name="email" class="@error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="nama@institusi.ac.id"
                                   required autocomplete="email">
                        </div>
                        <div id="emailHint" class="kppti-field-hint"></div>
                        @error('email')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="email_confirmation">Ulangi Email</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 6 12 13 2 6"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                            <input id="email_confirmation" type="text" name="email_confirmation"
                                   placeholder="Ulangi email Anda" required autocomplete="email">
                        </div>
                        <div id="emailMatchHint" class="kppti-field-hint"></div>
                    </div>

                    <div class="kppti-input-group">
                        <label for="password">Kata Sandi</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="password" type="password" name="password" class="has-toggle @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter" required autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="kpptiTogglePassword('password', 'kpptiEyeIconPassword')" aria-label="Tampilkan kata sandi">
                                <svg id="kpptiEyeIconPassword" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                        <div id="passwordHint" class="kppti-field-hint"></div>
                        @error('password')
                            <div class="invalid-feedback" style="font-size: 12.5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="kppti-input-group">
                        <label for="password_confirmation">Ulangi Kata Sandi</label>
                        <div class="kppti-input-wrap">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="has-toggle"
                                   placeholder="Ulangi kata sandi" required autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="kpptiTogglePassword('password_confirmation', 'kpptiEyeIconPasswordConfirmation')" aria-label="Tampilkan kata sandi">
                                <svg id="kpptiEyeIconPasswordConfirmation" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                        <div id="passwordMatchHint" class="kppti-field-hint"></div>
                    </div>

                    <button type="submit" id="btnRegistrasi" class="btn btn-kppti-login" disabled>Daftar</button>
                </form>

                <div class="kppti-divider">sudah punya akun</div>

                <p class="kppti-footnote">
                    <a href="{{ Route::has('login') ? route('login') : url('/login') }}">Masuk sebagai peserta</a>
                </p>

                <p class="kppti-page-footer">&copy; {{ date('Y') }} KPPTI &mdash; Konferensi Puncak Pendidikan Tinggi</p>
            </div>
        </div>

    </div>

    <script>
        function kpptiTogglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';

            document.getElementById(iconId).innerHTML = isHidden
                ? '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.87 19.87 0 0 1 4.22-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a19.79 19.79 0 0 1-2.16 3.19"></path><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }

        (function () {
            const nomorWaInput = document.getElementById('nomor_wa');
            const btnKirimOtp = document.getElementById('btnKirimOtp');
            const waHint = document.getElementById('waHint');
            const waRegex = /^0[0-9]{9,14}$/;
            let otpCountdown = 0;
            let otpTimer = null;

            function setWaHint(message, type) {
                waHint.textContent = message;
                waHint.classList.remove('text-danger', 'text-success');
                if (type) {
                    waHint.classList.add(type);
                }
            }

            function startOtpCountdown() {
                otpCountdown = 60;
                btnKirimOtp.disabled = true;
                btnKirimOtp.textContent = `Kirim ulang (${otpCountdown}s)`;

                otpTimer = setInterval(() => {
                    otpCountdown -= 1;
                    if (otpCountdown <= 0) {
                        clearInterval(otpTimer);
                        btnKirimOtp.disabled = false;
                        btnKirimOtp.textContent = 'Kirim OTP';
                        return;
                    }
                    btnKirimOtp.textContent = `Kirim ulang (${otpCountdown}s)`;
                });
            }

            btnKirimOtp.addEventListener('click', async function () {
                const nomorWa = nomorWaInput.value.trim();

                if (!waRegex.test(nomorWa)) {
                    setWaHint('Nomor WhatsApp tidak valid.', 'text-danger');
                    nomorWaInput.classList.add('is-invalid');
                    return;
                }
                nomorWaInput.classList.remove('is-invalid');
                nomorWaInput.classList.add('is-valid');

                btnKirimOtp.disabled = true;
                setWaHint('Mengirim OTP...', null);

                try {
                    const response = await fetch("{{ Route::has('registrasi_kppti.kirim_otp') ? route('registrasi_kppti.kirim_otp') : url('/registrasi-kppti/kirim-otp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: JSON.stringify({ nomor_wa: nomorWa }),
                    });

                    if (response.ok) {
                        setWaHint('Kode OTP telah dikirim ke WhatsApp Anda.', 'text-success');
                    } else {
                        setWaHint('Gagal mengirim OTP. Silakan coba lagi.', 'text-danger');
                    }
                } catch (error) {
                    setWaHint('Gagal mengirim OTP. Silakan coba lagi.', 'text-danger');
                }

                startOtpCountdown();
            });

            const emailInput = document.getElementById('email');
            const emailConfirmationInput = document.getElementById('email_confirmation');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const btnRegistrasi = document.getElementById('btnRegistrasi');

            const emailHint = document.getElementById('emailHint');
            const emailMatchHint = document.getElementById('emailMatchHint');
            const passwordHint = document.getElementById('passwordHint');
            const passwordMatchHint = document.getElementById('passwordMatchHint');

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const minPasswordLength = 8;

            const state = {
                emailValid: false,
                emailMatch: false,
                passwordValid: false,
                passwordMatch: false,
            };

            function setHint(el, message, type) {
                el.textContent = message;
                el.classList.remove('text-danger', 'text-success');
                if (type) {
                    el.classList.add(type);
                }
            }

            function setFieldStyle(inputEl, isValid) {
                inputEl.classList.remove('is-valid', 'is-invalid');
                if (inputEl.value.length === 0) {
                    return;
                }
                inputEl.classList.add(isValid ? 'is-valid' : 'is-invalid');
            }

            function validateEmail() {
                const value = emailInput.value.trim();
                state.emailValid = emailRegex.test(value);
                setFieldStyle(emailInput, state.emailValid);

                if (value.length === 0) {
                    setHint(emailHint, '', null);
                } else {
                    setHint(
                        emailHint,
                        state.emailValid ? 'Format email valid.' : 'Format email tidak valid.',
                        state.emailValid ? 'text-success' : 'text-danger'
                    );
                }

                validateEmailMatch();
            }

            function validateEmailMatch() {
                const value = emailInput.value.trim();
                const confirmation = emailConfirmationInput.value.trim();
                state.emailMatch = state.emailValid && value.length > 0 && value === confirmation;
                setFieldStyle(emailConfirmationInput, confirmation.length > 0 && value === confirmation);

                if (confirmation.length === 0) {
                    setHint(emailMatchHint, '', null);
                } else if (value !== confirmation) {
                    setHint(emailMatchHint, 'Email tidak sama.', 'text-danger');
                } else {
                    setHint(emailMatchHint, 'Email cocok.', 'text-success');
                }

                updateSubmitState();
            }

            function validatePassword() {
                const value = passwordInput.value;
                state.passwordValid = value.length >= minPasswordLength;
                setFieldStyle(passwordInput, state.passwordValid);

                if (value.length === 0) {
                    setHint(passwordHint, '', null);
                } else {
                    setHint(
                        passwordHint,
                        state.passwordValid ? 'Kata sandi valid.' : `Kata sandi minimal ${minPasswordLength} karakter.`,
                        state.passwordValid ? 'text-success' : 'text-danger'
                    );
                }

                validatePasswordMatch();
            }

            function validatePasswordMatch() {
                const value = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;
                state.passwordMatch = state.passwordValid && value.length > 0 && value === confirmation;
                setFieldStyle(passwordConfirmationInput, confirmation.length > 0 && value === confirmation);

                if (confirmation.length === 0) {
                    setHint(passwordMatchHint, '', null);
                } else if (value !== confirmation) {
                    setHint(passwordMatchHint, 'Kata sandi tidak sama.', 'text-danger');
                } else {
                    setHint(passwordMatchHint, 'Kata sandi cocok.', 'text-success');
                }

                updateSubmitState();
            }

            function updateSubmitState() {
                const isFormValid = state.emailValid && state.emailMatch && state.passwordValid && state.passwordMatch;
                btnRegistrasi.disabled = !isFormValid;
            }

            emailInput.addEventListener('input', validateEmail);
            emailConfirmationInput.addEventListener('input', validateEmailMatch);
            passwordInput.addEventListener('input', validatePassword);
            passwordConfirmationInput.addEventListener('input', validatePasswordMatch);
        })();
    </script>

</body>
</html>
