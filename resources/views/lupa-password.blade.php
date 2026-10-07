<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Lupa Kata Sandi - KPPTI | Konferensi Puncak Pendidikan Tinggi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('src/assets/img/favicon.ico') }}"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&family=Poppins:500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
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

        .kppti-logo-row img.kppti-partner-logo {
            height: 68px;
            width: auto;
            max-width: 110px;
            object-fit: contain;
            background: none;
            border-radius: 0;
            padding: 0;
        }

        .kppti-logo-divider {
            width: 1px;
            height: 34px;
            background: rgba(255, 255, 255, 0.25);
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

        .kppti-tagline h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 34px;
            line-height: 1.3;
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
            margin-bottom: 30px;
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

        .kppti-metode-pilihan {
            display: flex;
            gap: 20px;
            margin-bottom: 18px;
        }

        .kppti-metode-pilihan .form-check-label {
            font-size: 13.5px;
            color: #4b5563;
        }

        .kppti-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .kppti-input-wrap input {
            width: 100%;
            padding: 13px 14px;
            border-radius: 10px;
            border: 1.5px solid #e3e7ee;
            font-size: 14.5px;
            color: #1f2937;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .kppti-input-wrap input:focus {
            outline: none;
            border-color: var(--kppti-navy);
            box-shadow: 0 0 0 3px rgba(11, 31, 75, 0.12);
        }

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
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px -8px rgba(11, 31, 75, 0.55);
            transition: transform .15s ease, box-shadow .15s ease;
            margin-top: 8px;
        }

        .btn-kppti-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -8px rgba(11, 31, 75, 0.6);
            color: #fff;
        }

        .btn-kppti-login:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
            color: #fff !important;
        }

        .btn-kppti-login .btn-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .kppti-footnote {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 22px;
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
                    <h1>Lupa Kata <span>Sandi?</span></h1>
                    <p>
                        Masukkan email atau nomor WhatsApp yang terdaftar. Kami akan mengirimkan
                        kata sandi baru langsung ke WhatsApp Anda.
                    </p>
                </div>
            </div>
        </div>

        <div class="kppti-form-panel">
            <div class="kppti-form-card">

                <div class="form-heading">
                    <span class="eyebrow">Portal Peserta</span>
                    <h2>Lupa Kata Sandi</h2>
                    <p>Pilih cara pencarian akun Anda, lalu masukkan datanya.</p>
                </div>

                <div class="alert d-none py-2 px-3" id="alertLupaPassword" role="alert" style="font-size: 13.5px; border-radius: 10px;"></div>

                <form id="formLupaPassword">
                    <div class="kppti-metode-pilihan">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode" id="metodeEmail" value="email" checked>
                            <label class="form-check-label" for="metodeEmail">Email</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode" id="metodeWa" value="wa">
                            <label class="form-check-label" for="metodeWa">No. WhatsApp</label>
                        </div>
                    </div>

                    <div class="kppti-input-group">
                        <label for="nilai" id="labelNilai">Email</label>
                        <div class="kppti-input-wrap">
                            <input id="nilai" name="nilai" type="text" placeholder="nama@institusi.ac.id" required autofocus>
                        </div>
                    </div>

                    <button type="submit" id="btnLupaPassword" class="btn btn-kppti-login">
                        <span class="btn-label" id="btnLabel">Kirim Kata Sandi Baru</span>
                    </button>
                </form>

                <p class="kppti-footnote">
                    <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
                </p>

                <p class="kppti-page-footer">&copy; {{ date('Y') }} KPPTI &mdash; Konferensi Puncak Pendidikan Tinggi</p>
            </div>
        </div>

    </div>

    <script>
        (function () {
            var resetUrl = '{{ route('lupa-password.reset') }}';
            var csrfToken = '{{ csrf_token() }}';
            var durasiKunci = 30;

            var $radioEmail = document.getElementById('metodeEmail');
            var $labelNilai = document.getElementById('labelNilai');
            var $inputNilai = document.getElementById('nilai');
            var $form = document.getElementById('formLupaPassword');
            var $btn = document.getElementById('btnLupaPassword');
            var $btnLabel = document.getElementById('btnLabel');
            var $alert = document.getElementById('alertLupaPassword');

            function sesuaikanInput() {
                if ($radioEmail.checked) {
                    $labelNilai.textContent = 'Email';
                    $inputNilai.type = 'email';
                    $inputNilai.placeholder = 'nama@institusi.ac.id';
                } else {
                    $labelNilai.textContent = 'No. WhatsApp';
                    $inputNilai.type = 'text';
                    $inputNilai.placeholder = '08xxxxxxxxxx';
                }
            }

            document.querySelectorAll('input[name="metode"]').forEach(function (el) {
                el.addEventListener('change', sesuaikanInput);
            });

            function tampilkanAlert(jenis, pesan) {
                $alert.className = 'alert alert-' + jenis + ' py-2 px-3';
                $alert.style.fontSize = '13.5px';
                $alert.style.borderRadius = '10px';
                $alert.textContent = pesan;
            }

            function kunciTombol() {
                var sisa = durasiKunci;
                $btn.disabled = true;
                $btnLabel.textContent = 'Coba lagi dalam ' + sisa + ' detik';

                var interval = setInterval(function () {
                    sisa -= 1;

                    if (sisa <= 0) {
                        clearInterval(interval);
                        $btn.disabled = false;
                        $btnLabel.textContent = 'Kirim Kata Sandi Baru';
                        return;
                    }

                    $btnLabel.textContent = 'Coba lagi dalam ' + sisa + ' detik';
                }, 1000);
            }

            $form.addEventListener('submit', function (e) {
                e.preventDefault();

                if ($btn.disabled) {
                    return;
                }

                $btnLabel.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                $btn.disabled = true;

                fetch(resetUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        metode: document.querySelector('input[name="metode"]:checked').value,
                        nilai: $inputNilai.value,
                    }),
                })
                    .then(function (response) {
                        return response.json().then(function (body) {
                            return { ok: response.ok, body: body };
                        });
                    })
                    .then(function (result) {
                        if (result.ok) {
                            tampilkanAlert('success', result.body.message);
                        } else {
                            var pesan = result.body.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
                            if (result.body.errors) {
                                pesan = Object.values(result.body.errors).flat().join('\n');
                            }
                            tampilkanAlert('danger', pesan);
                        }

                        kunciTombol();
                    })
                    .catch(function () {
                        tampilkanAlert('danger', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
                        kunciTombol();
                    });
            });
        })();
    </script>

</body>
</html>
