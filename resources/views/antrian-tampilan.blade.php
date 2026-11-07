<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Tampilan Antrian - KPPTI 2026</title>
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

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background: var(--kppti-navy-dark);
            overflow: hidden;
        }

        .layar-antrian {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .baris-atas {
            flex: 7;
            display: flex;
            min-height: 0;
        }

        .baris-bawah {
            flex: 3;
            display: flex;
            min-height: 0;
            background: #fff;
            border-top: 6px solid var(--kppti-red);
        }

        .panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            padding: 20px 28px;
        }

        .panel-antri {
            background: #f4f6fb;
            border-right: 3px solid #dfe3ec;
        }

        .panel-dipanggil {
            background: #fff;
        }

        .panel h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 26px;
            color: var(--kppti-navy);
            margin: 0 0 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .daftar-scroll {
            flex: 1;
            overflow-y: auto;
            scroll-behavior: auto;
        }

        .baris-antri {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 14px 18px;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e3e7f0;
        }

        .baris-antri .nomor {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 28px;
            color: var(--kppti-navy);
            min-width: 64px;
            text-align: center;
        }

        .baris-antri .nama {
            font-size: 20px;
            font-weight: 700;
            color: #222;
        }

        .baris-dipanggil {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 24px;
            margin-bottom: 14px;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef1fb, #fff);
            border: 2px solid #dfe3ec;
        }

        .baris-dipanggil .nama {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: var(--kppti-navy);
        }

        .baris-dipanggil .meja {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 22px;
            color: #fff;
            background: var(--kppti-navy);
            border-radius: 10px;
            padding: 8px 18px;
            white-space: nowrap;
        }

        .baris-dipanggil.baris-blink {
            animation: blink-efek 1s step-start infinite;
        }

        @keyframes blink-efek {
            50% {
                background: var(--kppti-gold-light);
                border-color: var(--kppti-gold);
            }
        }

        .kolom-terlewat {
            flex: 1;
            padding: 16px 20px;
            overflow-y: auto;
            border-right: 1px solid #e3e7f0;
        }

        .kolom-terlewat:last-child {
            border-right: none;
        }

        .baris-terlewat {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            font-size: 16px;
            color: var(--kppti-red);
            border-bottom: 1px dashed #e3e7f0;
        }

        .baris-terlewat .badge-terlewat {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            background: var(--kppti-red);
            color: #fff;
            border-radius: 6px;
            padding: 3px 8px;
        }

        .teks-kosong {
            color: #999;
            font-size: 15px;
            padding: 12px 0;
        }
    </style>
</head>
<body>

    <div class="layar-antrian">
        <div class="baris-atas">
            <div class="panel panel-antri">
                <h2><i class="fa-solid fa-list-ol me-2"></i>Antri</h2>
                <div id="list-antri" class="daftar-scroll"></div>
            </div>
            <div class="panel panel-dipanggil">
                <h2><i class="fa-solid fa-bell me-2"></i>Dipanggil</h2>
                <div id="list-dipanggil" class="daftar-scroll"></div>
            </div>
        </div>
        <div class="baris-bawah">
            <div class="kolom-terlewat" id="kolom-terlewat-0"></div>
            <div class="kolom-terlewat" id="kolom-terlewat-1"></div>
            <div class="kolom-terlewat" id="kolom-terlewat-2"></div>
        </div>
    </div>

    <script>
        (function () {
            var streamUrl = '{{ route('antrian.tampilan.stream') }}';
            var audioBelUrl = '{{ asset('audio/bel-antrian.mp3') }}';

            var $listAntri = document.getElementById('list-antri');
            var $listDipanggil = document.getElementById('list-dipanggil');
            var $kolomTerlewat = [
                document.getElementById('kolom-terlewat-0'),
                document.getElementById('kolom-terlewat-1'),
                document.getElementById('kolom-terlewat-2'),
            ];

            var kataAngka = {
                '0': 'Kosong', '1': 'Satu', '2': 'Dua', '3': 'Tiga', '4': 'Empat',
                '5': 'Lima', '6': 'Enam', '7': 'Tujuh', '8': 'Delapan', '9': 'Sembilan',
            };

            function ejaNomorMeja(nomorMeja) {
                if (!nomorMeja) {
                    return '';
                }

                return String(nomorMeja).split('').map(function (digit) {
                    return kataAngka[digit] || digit;
                }).join(' ');
            }

            function escapeHtml(teks) {
                return document.createElement('div').appendChild(document.createTextNode(teks == null ? '' : teks)).parentNode.innerHTML;
            }

            // ===== Auto-scroll pelan list Antri, loop kembali ke atas =====
            setInterval(function () {
                if ($listAntri.scrollHeight <= $listAntri.clientHeight) {
                    return;
                }

                $listAntri.scrollTop += 1;

                if ($listAntri.scrollTop + $listAntri.clientHeight >= $listAntri.scrollHeight) {
                    $listAntri.scrollTop = 0;
                }
            }, 60);

            // ===== Efek panggilan: bel lalu TTS, diantrikan satu-satu =====
            var audioBel = new Audio(audioBelUrl);
            var antrianEfek = [];
            var sedangMemutarEfek = false;

            function antrikanEfek(item) {
                antrianEfek.push(item);
                prosesEfekBerikutnya();
            }

            function prosesEfekBerikutnya() {
                if (sedangMemutarEfek || antrianEfek.length === 0) {
                    return;
                }

                sedangMemutarEfek = true;
                var item = antrianEfek.shift();

                blinkBarisDipanggil(item.idantrian_regis);

                function selesai() {
                    sedangMemutarEfek = false;
                    prosesEfekBerikutnya();
                }

                function ucapkan() {
                    if (!window.speechSynthesis) {
                        selesai();
                        return;
                    }

                    var teks = item.nama_institusi + ', silahkan ke meja nomor ' + ejaNomorMeja(item.nomor_meja) + '.';
                    var utter = new SpeechSynthesisUtterance(teks);
                    utter.lang = 'id-ID';
                    utter.onend = selesai;
                    utter.onerror = selesai;
                    window.speechSynthesis.speak(utter);
                }

                audioBel.currentTime = 0;
                audioBel.onended = ucapkan;
                audioBel.onerror = ucapkan;

                var playPromise = audioBel.play();

                if (playPromise && typeof playPromise.catch === 'function') {
                    playPromise.catch(ucapkan);
                }
            }

            function blinkBarisDipanggil(idantrianRegis) {
                var $baris = $listDipanggil.querySelector('[data-idantrian-regis="' + idantrianRegis + '"]');

                if (!$baris) {
                    return;
                }

                $baris.classList.add('baris-blink');
                setTimeout(function () {
                    $baris.classList.remove('baris-blink');
                }, 10000);
            }

            // ===== Render dari snapshot SSE =====
            var dipanggilSebelumnya = {};
            var snapshotAntriSebelumnya = '';

            function renderAntri(antri) {
                var snapshotBaru = JSON.stringify(antri);

                if (snapshotBaru === snapshotAntriSebelumnya) {
                    return;
                }

                snapshotAntriSebelumnya = snapshotBaru;

                if (antri.length === 0) {
                    $listAntri.innerHTML = '<p class="teks-kosong">Belum ada yang mengantri.</p>';
                    return;
                }

                $listAntri.innerHTML = antri.map(function (baris) {
                    return '<div class="baris-antri">'
                        + '<div class="nomor">' + escapeHtml(baris.nomor_antrian) + '</div>'
                        + '<div class="nama">' + escapeHtml(baris.nama_institusi) + '</div>'
                        + '</div>';
                }).join('');
            }

            function renderDipanggil(dipanggil) {
                var dipanggilBaru = {};

                dipanggil.forEach(function (baris) {
                    dipanggilBaru[baris.idantrian_regis] = baris.panggilan_ke;
                });

                dipanggil.forEach(function (baris) {
                    var sebelum = dipanggilSebelumnya[baris.idantrian_regis];
                    var baruDipanggil = typeof sebelum === 'undefined';
                    var dipanggilUlang = !baruDipanggil && baris.panggilan_ke > sebelum;

                    if (baruDipanggil || dipanggilUlang) {
                        antrikanEfek(baris);
                    }
                });

                dipanggilSebelumnya = dipanggilBaru;

                if (dipanggil.length === 0) {
                    $listDipanggil.innerHTML = '<p class="teks-kosong">Belum ada yang dipanggil.</p>';
                    return;
                }

                $listDipanggil.innerHTML = dipanggil.map(function (baris) {
                    return '<div class="baris-dipanggil" data-idantrian-regis="' + baris.idantrian_regis + '">'
                        + '<div class="nama">' + escapeHtml(baris.nama_institusi) + '</div>'
                        + '<div class="meja">Meja ' + escapeHtml(baris.nomor_meja || '-') + '</div>'
                        + '</div>';
                }).join('');
            }

            function renderTerlewat(terlewat) {
                $kolomTerlewat.forEach(function ($kolom) {
                    $kolom.innerHTML = '';
                });

                if (terlewat.length === 0) {
                    $kolomTerlewat[0].innerHTML = '<p class="teks-kosong">Belum ada yang terlewat.</p>';
                    return;
                }

                var jumlahKolom = $kolomTerlewat.length;
                var perKolom = Math.ceil(terlewat.length / jumlahKolom);

                terlewat.forEach(function (baris, index) {
                    var indexKolom = Math.min(Math.floor(index / perKolom), jumlahKolom - 1);

                    $kolomTerlewat[indexKolom].innerHTML += '<div class="baris-terlewat">'
                        + '<span class="badge-terlewat">Terlewat</span>'
                        + '<span>' + escapeHtml(baris.nama_institusi) + '</span>'
                        + '</div>';
                });
            }

            function mulaiStream() {
                var sumber = new EventSource(streamUrl);

                sumber.onmessage = function (event) {
                    var data = JSON.parse(event.data);
                    renderAntri(data.antri);
                    renderDipanggil(data.dipanggil);
                    renderTerlewat(data.terlewat);
                };

                // Server menutup koneksi tiap beberapa puluh detik (lihat
                // AntrianRegisController::SSE_BATAS_WAKTU_DETIK) — EventSource
                // otomatis menyambung ulang secara native, tidak perlu kode
                // tambahan di sini untuk itu.
            }

            mulaiStream();
        })();
    </script>
</body>
</html>
