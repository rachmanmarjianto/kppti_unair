# F11 — Data Logistik Peserta, Kelengkapan Data, dan Kartu Registrasi Kontingen

> Melengkapi F11 di `PRD.md` ("Data logistik peserta: transportasi, hotel, city tour"). Awalnya didiktekan sebagai bagian dari F03, dipisah ke sini karena isinya field logistik (di luar cakupan F03: institusi & kontingen).
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide tambahan AI, menunggu konfirmasi.
> Status: **§1–§4 (logistik, kelengkapan data, kartu kontingen) sudah diimplementasikan dan berjalan.** §5 (foto peserta untuk face recognition) adalah **penambahan spesifikasi baru**, dirancang di bawah, belum dikerjakan.

## 1. Tujuan

Peserta melengkapi data logistik dirinya di tabel `peserta`, sistem menandai peserta yang belum lengkap, dan setelah seluruh peserta dalam satu kontingen (institusi) lengkap datanya, kontingen tersebut bisa mengunduh **kartu registrasi kontingen** dalam bentuk PDF (ukuran A5) berisi nama institusi dan QR code `kode_kontingen`.

## 2. Cakupan (garis besar dari dikte developer, F03 §6 lama)

### 2.1 Kelengkapan data peserta

**Dikonfirmasi developer** (setuju dengan usulan kondisional yang diajukan): kolom di tabel `peserta` yang dianggap "lengkap" mengikuti aturan berikut (selain `idjabatan`, yang sudah wajib sejak F01):

| Kolom | Wajib? |
|---|---|
| `idjenis_transportasi_kedatangan` | Wajib untuk semua peserta |
| `stasiun_kedatangan` | Wajib, **kecuali** `idjenis_transportasi_kedatangan` = Kendaraan Pribadi (kendaraan pribadi tidak berhenti di stasiun) |
| `tanggal_kedatangan` | Wajib untuk semua peserta |
| `jam_kedatangan` | Wajib untuk semua peserta |
| `idjenis_transportasi_kepulangan` | Wajib untuk semua peserta |
| `stasiun_kepulangan` | Wajib, **kecuali** `idjenis_transportasi_kepulangan` = Kendaraan Pribadi |
| `tanggal_kepulangan` | Wajib untuk semua peserta |
| `jam_kepulangan` | Wajib untuk semua peserta |
| `nama_hotel` | **Tidak wajib** (opsional — tidak ada kolom penanda "menginap atau tidak" di skema, jadi diperlakukan sebagai info tambahan, bukan syarat kelengkapan) |
| `city_tour` | **Tidak wajib** (kolom boolean dengan default `false`, jadi selalu punya nilai — tidak menghalangi status "lengkap") |

Peserta yang belum lengkap diberi tanda (badge) di daftar peserta (lihat F03 §5) dan di halaman ringkasan miliknya sendiri.

### 2.2 Kartu registrasi kontingen (PDF, ukuran A5)

- **Gate**: kartu baru bisa diunduh setelah **semua peserta dalam kontingen** (institusi) yang sama sudah lengkap datanya (dikonfirmasi developer — ini memang per kontingen, bukan per individu). Kalau ada satu saja anggota kontingen yang belum lengkap, kartu belum bisa diunduh oleh siapa pun di kontingen itu.
- Pesan saat belum bisa diunduh: info jelas "Untuk mengunduh kartu registrasi, harap lengkapi semua data peserta" — `[USULAN AI]` sebutkan juga siapa saja yang belum lengkap, supaya peserta lain bisa menagih/mengingatkan.
- **Isi & tata letak kartu** (dikonfirmasi developer), dari atas ke bawah:
  1. Logo Unair (kiri) dan logo KPPTI (kanan), berdampingan di bagian paling atas.
  2. Teks "Kartu Registrasi Kontingen" (judul kartu).
  3. Nama institusi — teks besar, rata tengah (center).
  4. Jarak/margin yang cukup lega.
  5. QR code berisi `kode_kontingen` — rata tengah.
  6. Teks `kode_kontingen` tepat di bawah QR code.
  - Kombinasi warna, font, dan detail visual lain **diserahkan ke AI** — akan dibuat draf untuk direview sebelum coding dimulai (bukan langsung dikerjakan tanpa preview).
  - Aset logo sudah tersedia di `public/src/assets/img/`: `unair_logo.svg` dan `kppti_logo.png` (juga ada `logo_unair_kecil.png`) — tidak perlu logo baru.
- **Dependensi**:
  - **PDF**: `barryvdh/laravel-dompdf` — **sudah disetujui developer**, ditambahkan ke `composer.json` (lihat catatan instalasi di bawah).
  - **QR code**: `[TBD — developer masih memilih]`. Lihat §3 untuk perbandingan opsi dan penjelasan soal "format/standar QR code yang mudah/sulit dibaca".

## 3. Pilihan library QR code

Developer punya pengalaman: pernah pakai satu format/standar QR code yang **sulit dipindai (scan)**, ganti ke format/standar lain jadi **lebih mudah & cepat dibaca**, tapi detail persisnya sudah lupa.

Kemungkinan besar yang dimaksud adalah **tingkat koreksi kesalahan (Error Correction Level / ECC)** pada QR code, bukan "jenis kode 2D" yang berbeda (QR code hanya satu standar internasional, ISO/IEC 18004 — bukan seperti Data Matrix/PDF417/Aztec yang benar-benar beda standar). Penjelasan singkat:

- Tiap QR code punya salah satu dari 4 level koreksi kesalahan: **L** (~7% toleransi rusak/kotor), **M** (~15%), **Q** (~25%), **H** (~30%).
- Level lebih rendah (L) menghasilkan pola QR yang **lebih "renggang"/sederhana** tapi **lebih rentan** gagal dibaca kalau kualitas cetak/kamera kurang baik, ada bayangan/silau, atau kode dicetak kecil.
- Level lebih tinggi (H) menghasilkan pola yang **lebih padat** (lebih banyak modul hitam-putih untuk data yang sama) tapi jauh **lebih tahan** terhadap kualitas cetak/scan yang kurang ideal — ini kemungkinan besar "format yang lebih mudah dibaca" yang dimaksud developer.
- Faktor lain yang juga sering berpengaruh ke kemudahan scan (di luar ECC): **ukuran modul/kotak** (jangan terlalu kecil saat dicetak A5), **quiet zone** (margin putih di sekeliling QR, minimal 4 modul), dan **kontras warna** (hitam di atas putih polos, hindari background pola/gambar di belakang QR). Kemungkinan besar kombinasi ECC tinggi + margin cukup + tanpa logo/overlay di tengah adalah yang membuat pengalaman developer dulu jadi "lebih mudah dibaca", bukan semata pilihan library.

### Opsi library

| Library | Kontrol ECC | Format output | Catatan |
|---|---|---|---|
| **`endroid/qr-code`** | Ya — eksplisit pilih `ErrorCorrectionLevel::Low/Medium/Quartile/High` | PNG, SVG, EPS, WebP | Aktif dikembangkan, tidak wajib ekstensi native (SVG murni tanpa `gd`/`imagick`; PNG butuh `gd` atau `imagick`) |
| **`simplesoftwareio/simple-qrcode`** | Ya — method `->errorCorrection('H')` | PNG, SVG, EPS | API lebih sederhana (facade `QrCode::`), tapi maintenance rilis terakhir lebih jarang dibanding `endroid/qr-code` — perlu dicek kompatibilitas Laravel 13 saat instalasi nanti |

**Dikonfirmasi developer**: `endroid/qr-code` — sudah ditambahkan ke `composer.json`. Dipakai dengan `ErrorCorrectionLevel::High` (30%, paling tahan terhadap kualitas cetak/scan yang kurang ideal) + margin/quiet zone standar + ukuran modul cukup besar untuk kertas A5.

## 4. Status keputusan

Semua poin yang sebelumnya terbuka **sudah diputuskan** developer:

- **Kelengkapan data** (§2.1): aturan kondisional di atas disetujui.
- **Field logistik tambahan**: **tidak perlu** — skema `peserta` yang ada sekarang sudah cukup, tidak ada `ALTER TABLE`.
- **Desain kartu** (§2.2): tata letak & konten sudah dikonfirmasi; kombinasi warna/font diserahkan ke AI, dibuat draf visual dulu untuk direview sebelum coding.

Satu hal yang masih perlu digali saat mulai coding (bukan pertanyaan terbuka besar, hanya detail teknis kecil): daftar `idjenis_transport` mana persis yang dianggap "Kendaraan Pribadi" untuk aturan `stasiun_kedatangan`/`stasiun_kepulangan` opsional (lihat `JenisTransportSeeder` — ada 2 baris "Kendaraan Pribadi" dengan `status` true/false; yang dipakai untuk pengecualian ini adalah yang `status = true`, karena `status` menandai opsi mana yang aktif/bisa dipilih pengguna).

Dokumen ini siap dijadikan acuan implementasi.

## 5. Foto peserta untuk face recognition (penambahan spesifikasi, dikte developer)

### 5.1 Tujuan & konteks

Peserta wajib mengunggah foto (kolom `peserta.path_foto`, sudah ditambahkan lewat migrasi `2026_10_01_053808_add_path_foto_to_peserta_table`). Foto ini **nanti akan dimigrasikan ke perangkat face recognition Hikvision model DS-K1T673DWX** untuk absensi — jadi format/ukuran foto harus mengikuti ketentuan perangkat tersebut, bukan sekadar foto profil biasa.

**Dikonfirmasi developer**: proses tambah/ubah foto dibuat **terpisah** dari proses melengkapi data logistik (menu/tombol sendiri), tapi statusnya tetap ikut dihitung sebagai bagian dari syarat "data lengkap" peserta (lihat §5.5).

### 5.2 Ketentuan teknis foto (sumber: dokumentasi resmi Hikvision)

Dicek langsung ke dokumentasi Hikvision ("Import Data" / face photo import requirements) untuk model Face Recognition Terminal ini:

- Format: **JPEG/JPG**.
- Resolusi: **lebih dari 640×480 piksel dan kurang dari 2160×3840 piksel**.
- Ukuran berkas: **antara 40 KB dan 200 KB**.
- Foto harus tampak wajah penuh (full-face), menghadap langsung ke kamera, **tanpa penutup kepala**.

Dokumentasi resmi tidak menyebut rasio aspek pasti, tapi sesuai instruksi developer ("template kepala dan badan setengah badan") dan praktik umum foto untuk perangkat sejenis, dipakai **rasio potret 3:4** (lebih tinggi daripada lebar, meliputi kepala + bahu/setengah badan atas).

`[Sumber: Hikvision "Import Data" — enpinfo.hikvision.com, dicek 2026-10-01]`

**Update 2026-10-12 (dikonfirmasi tim perangkat, lalu dikembalikan)**: tim yang menghandle perangkat face recognition **Hikvision MinMoe** di lokasi (bukan model `DS-K1T673DWX` yang dicek dari dokumentasi umum di atas) sempat minta output foto tepat 300×400 piksel — lebih kecil dari batas minimum "640×480" di dokumentasi umum §5.2. Perubahan itu sempat diterapkan, lalu developer meminta dikembalikan lagi. Target output yang **sekarang dipakai di kode**: **600×800 piksel** (rasio 3:4, sesuai batas resolusi dokumentasi umum di atas), JPEG, dikompres otomatis di server supaya ukuran berkas tidak melebihi 200 KB.

### 5.3 Alur pengguna

1. Di halaman "Peserta Kontingen" (`sekontingen.blade.php`), tiap baris peserta dapat tombol baru **"Foto"** (ikon kamera), terpisah dari tombol Edit/Data Logistik/Reset Password — mengikuti pola akses F03 (semua peserta dalam kontingen boleh mengelola foto peserta lain, bukan cuma diri sendiri).
2. Tombol ini membuka **halaman tersendiri** (bukan modal — area crop butuh ruang), menampilkan:
   - Foto yang sudah tersimpan saat ini (kalau ada), dengan keterangan jelas **"Ini adalah foto terbaru yang tersimpan"** (supaya tidak ambigu dengan versi lama di perangkat Hikvision).
   - Tombol "Pilih Foto Baru" (file input, hanya menerima gambar).
3. Setelah peserta memilih berkas gambar, muncul **area crop interaktif** (pakai Cropper.js — lihat §5.4) dengan **template overlay kepala + bahu** (garis panduan transparan) supaya peserta tahu ke mana memposisikan wajah. Peserta bisa **drag** (geser) dan **zoom in/out** (scroll/pinch/slider) gambar sampai pas dengan template.
4. Tombol "Simpan Foto" → **SweetAlert2 konfirmasi** ("Simpan foto ini?") — **bukan** modal verifikasi teks (konsisten dengan penyederhanaan yang sama seperti data logistik, karena ini bukan data identitas sensitif seperti email/password).
5. Hasil crop (canvas) diekspor jadi gambar lalu dikirim ke server. Server memproses ulang (resize tepat ke 600×800, re-encode JPEG, kompres sampai di bawah 200 KB) — **tidak percaya ukuran/format hasil crop dari browser begitu saja**, sesuai prinsip "validasi server" di `CONVENTIONS.md`.
6. Foto lama (kalau ada) **dihapus** dan diganti yang baru (satu peserta = satu foto aktif, selalu yang terbaru).
7. Dicatat ke `log_peserta`: `"Foto diperbarui"`.

### 5.4 Implementasi teknis

- **Crop UI**: **Cropper.js** (CDN, MIT license) — `[dikonfirmasi developer]`, dimuat per-halaman seperti pola Font Awesome/SweetAlert2 yang sudah ada (`CONVENTIONS.md` §6: "tiap halaman memuat sendiri plugin yang ia perlukan"). Cropper.js dikonfigurasi `aspectRatio: 3/4`, `viewMode` dikunci supaya crop box tidak keluar dari gambar; template overlay kepala+bahu adalah elemen gambar/SVG statis yang ditumpuk (`pointer-events: none`) di atas area crop sebagai panduan visual, tidak memengaruhi logika crop itu sendiri.
- **Pemrosesan gambar di server**: pakai **GD** (ekstensi PHP bawaan, sudah aktif di server ini — dicek `php -m`), **tidak perlu menambah dependensi baru** (mis. Intervention Image) untuk resize + kompresi. Loop turunkan kualitas JPEG (`imagejpeg($im, $path, $quality)`) sampai ukuran berkas ≤200 KB.
- **Penyimpanan berkas** (sesuai `CONVENTIONS.md` §7 yang baru ditambahkan — berkas upload tidak boleh publik):
  - Disk Laravel baru/khusus yang **tidak publik**, mis. `storage/app/foto-peserta/` (bukan `storage/app/public/`).
  - Nama berkas dibuat dari `idpeserta` (mis. `peserta-{idpeserta}.jpg`) supaya upload baru otomatis menimpa yang lama secara alami — tetap hapus eksplisit dulu untuk jaga-jaga ukuran berkas lama beda.
  - `peserta.path_foto` menyimpan path relatif di disk tsb (bukan URL publik).
  - Foto **ditampilkan kembali** (preview di halaman) lewat **route GET terproteksi** yang menyajikan isi berkas lewat controller (`Storage::get()`/`response()->file()`), dengan idpeserta di URL **dienkripsi AES-256** (`encryptRouteValue()`/`decryptRouteValue()` yang sudah ada di base `Controller.php`) sesuai `CONVENTIONS.md` §7 — bukan URL statis ke berkas.
  - Scoped ke institusi sendiri (pola `findPesertaInOwnInstitusi`), sama seperti endpoint lain di F03/F11.

### 5.5 Kelengkapan data (pembaruan aturan §2.1)

**Dikonfirmasi developer**: foto **wajib** diisi. `path_foto IS NOT NULL` ditambahkan sebagai syarat baru di `isPesertaLengkap()` — peserta yang belum unggah foto dianggap belum lengkap (tidak bisa unduh kartu kontingen sampai semua peserta di kontingen, termasuk fotonya, lengkap).

### 5.6 Hal yang diserahkan ke AI (akan dibuat lalu ditunjukkan)

- Desain visual halaman upload + crop (tata letak, kotak overlay panduan kepala/bahu — bentuknya seperti apa persis).
- Pesan-pesan UI (termasuk penegasan "foto terbaru").

