<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Ambil Nomor Antrian - KPPTI 2026</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('src/assets/img/favicon.ico') }}"/>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&family=Poppins:500,600,700,800&display=swap" rel="stylesheet">
    <link href="{{ asset('src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}">

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

        .kppti-kartu-antrian {
            width: 100%;
            max-width: 560px;
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

        .kppti-kartu-antrian p.kppti-subjudul {
            font-size: 15.5px;
            color: #666;
            margin: 0 0 32px;
        }

        #input-kode-kontingen {
            width: 100%;
            font-size: 34px;
            letter-spacing: 10px;
            text-align: center;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--kppti-navy);
            border: 2px solid #dfe3ec;
            border-radius: 14px;
            padding: 18px 12px;
        }

        #input-kode-kontingen:focus {
            outline: none;
            border-color: var(--kppti-gold);
            box-shadow: 0 0 0 4px rgba(212, 164, 55, 0.2);
        }

        .kppti-keterangan {
            margin-top: 20px;
            font-size: 13.5px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="kppti-kartu-antrian">
        <div class="kppti-logo-row">
            <img src="{{ asset('src/assets/img/logo_unair_kecil.png') }}" alt="Logo Universitas Airlangga">
            <span class="kppti-logo-divider"></span>
            <img src="{{ asset('src/assets/img/kppti_logo.png') }}" alt="Logo KPPTI"
                 onerror="this.style.display='none'">
        </div>

        <h1>Ambil Nomor Antrian</h1>
        <p class="kppti-subjudul">Masukkan kode kontingen institusi Anda</p>

        <form id="form-ambil-nomor">
            @csrf
            <input type="text" id="input-kode-kontingen" name="kode_kontingen" maxlength="7"
                   autocomplete="off" autofocus inputmode="latin" placeholder="•••••••">
        </form>

        <p class="kppti-keterangan">Nomor antrian otomatis terdaftar setelah 7 karakter kode diketik.</p>
    </div>

    <script src="{{ asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script>
        (function () {
            var csrfToken = document.querySelector('input[name="_token"]').value;
            var submitUrl = '{{ route('antrian.ambil-nomor.submit') }}';
            var $input = document.getElementById('input-kode-kontingen');
            var sedangProses = false;

            function resetInput() {
                $input.value = '';
                $input.focus();
            }

            function tampilkanPesan(icon, pesan) {
                Swal.fire({
                    icon: icon,
                    text: pesan,
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(resetInput);
            }

            $input.addEventListener('input', function () {
                $input.value = $input.value.toUpperCase();

                if ($input.value.length !== 7 || sedangProses) {
                    return;
                }

                sedangProses = true;
                $input.disabled = true;

                fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({ kode_kontingen: $input.value }),
                })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    if (result.ok) {
                        tampilkanPesan('success', result.data.message);
                    } else {
                        tampilkanPesan('error', result.data.message || 'Terjadi kesalahan pada server. Silakan coba lagi.');
                    }
                })
                .catch(function () {
                    tampilkanPesan('error', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
                })
                .finally(function () {
                    sedangProses = false;
                    $input.disabled = false;
                });
            });
        })();
    </script>
</body>
</html>
