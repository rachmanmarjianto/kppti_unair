# PRD — Sistem Registrasi KPPTI 2026

> Dokumen ini adalah sumber kebenaran untuk **apa** yang dibangun dan **kenapa**.
> Untuk **bagaimana** (stack, struktur kode) lihat `ARCHITECTURE.md`. Spesifikasi detail tiap fitur ada di `features/`.
> Tanda `[TBD]` = belum diputuskan. AI tidak boleh menebak; tanyakan ke developer.

## 1. Ringkasan

Aplikasi web untuk mengelola pendaftaran dan administrasi **KPPTI 2026**, event yang diselenggarakan oleh **Universitas Airlangga** pada **November 2026** `[TBD: tanggal dan lokasi pasti]`.

Pendaftaran dibuka **bulan depan** (sekitar Oktober 2026). Target developer: aplikasi selesai **minggu ini**, lalu ada masa koreksi sebelum benar-benar digunakan.

## 2. Masalah yang diselesaikan

Event ini tidak bisa ditangani dengan Google Form karena:

1. **Jenis peserta beragam** (PTN/PTS, asosiasi, lembaga akreditasi, pemerhati pendidikan, LLDikti, lainnya), dan **data yang diminta berbeda per jenis**.
2. **Pengajuan bertahap dengan review**: pengajuan narasumber (mirip submit paper) dan pengajuan pameran memiliki alur status, revisi, dan penolakan.
3. **Pembayaran berbasis Virtual Account (VA) BNI**, termasuk pembayaran sebagian dan status lunas yang harus terlacak otomatis.
4. **Logistik peserta** (kedatangan, kepulangan, hotel, city tour) dan **pemilihan acara** perlu dikelola terpusat.
5. Verifikasi kontak via **OTP WhatsApp**.

## 3. Pengguna dan role

| Role | Deskripsi | Kemampuan utama |
|---|---|---|
| **Admin** | Panitia pelaksana | Kelola pengguna (admin/SC), kelola master data, pantau pendaftaran, tagihan, dan pembayaran `[TBD: rincian]` |
| **SC** (Steering Committee) | Reviewer | Mereview pengajuan narasumber dan pameran, memberi catatan dan keputusan |
| **Peserta** | Perwakilan institusi/individu | Registrasi, isi data logistik, pilih acara, ajukan pameran, bayar tagihan |
| **Narasumber** | Pembicara pada acara | Mengajukan diri sebagai narasumber (abstrak, berkas), mengikuti alur review |
| **Petugas Kit** (`idrole` 5) | Panitia penyiap seminar kit | Setelah masa registrasi online ditutup, menyiapkan & mengelompokkan seminar kit sesuai jumlah peserta per kontingen (F18) |
| **Petugas Ruang MoU** (`idrole` 7) | Panitia penjaga ruang pertemuan MoU | Pada hari pertemuan terjadwal, mencatat kehadiran PIC institusi pengaju dan PIC institusi mitra untuk sesi "Temu Diskusi" MoU (F20-F23) |

- **Narasumber adalah role tersendiri**, terpisah dari Peserta. **Registrasi peserta dan registrasi narasumber memiliki alur yang berbeda** (dijelaskan per fitur).
- Satu pengguna dapat **memiliki** lebih dari satu role (tabel `role_pengguna`), misalnya Peserta sekaligus Narasumber, tetapi **hanya satu role yang aktif pada satu waktu** (kolom `status`). Pengecekan akses dilakukan oleh middleware `akses:{idrole}` terhadap role yang sedang aktif. Pengguna berpindah antar role dengan mengganti role aktif.
- `[TBD: apakah SC juga bisa memiliki role narasumber?]`

## 4. Status pengembangan saat ini

| Modul | Status |
|---|---|
| Inisialisasi proyek Laravel + layout `blank_page.blade.php` | Selesai |
| Login (auth bawaan Laravel) | Selesai |
| Admin: daftar pengguna role admin dan SC (lihat, tambah, edit) | Selesai |
| Reset password via WA Gateway | Selesai |
| Form registrasi peserta | **Parsial** |
| Sisa modul di bawah | Belum dimulai |

## 5. Daftar fitur

Prioritas: **P0** wajib untuk pendaftaran dibuka, **P1** wajib sebelum hari-H, **P2** bila waktu cukup.

| ID | Fitur | Prioritas | Status |
|---|---|---|---|
| F01 | Registrasi peserta dengan form dinamis per jenis institusi (JavaScript) | P0 | Selesai |
| F02 | Verifikasi OTP WhatsApp saat registrasi | P0 | Selesai (tercakup di F01) |
| F03 | Manajemen institusi asal dan kode kontingen | P0 | Selesai |
| F04 | Tagihan dan pembayaran VA BNI (pembuatan VA, callback, status, pembayaran sebagian) | P0 | Belum |
| F05 | Pengajuan narasumber (draft, pengajuan, review, revisi, diterima/ditolak) | P0 | Selesai |
| F06 | Review narasumber oleh SC (unggah berkas, catatan, keputusan) | P0 | Selesai |
| F07 | Pengajuan pameran (alur status yang sama) dan penetapan nomor stand | P0 | Selesai |
| F08 | Review pameran oleh SC | P0 | Selesai |
| F09 | Manajemen acara/sesi (bertingkat, per hari dan jam) oleh admin | P1 | Selesai |
| F10 | Peserta memilih acara yang diikuti | P1 | Selesai |
| F11 | Data logistik peserta (transportasi, hotel, city tour), kartu registrasi kontingen (PDF), foto peserta untuk face recognition, dan API sinkronisasi data peserta ke server manajemen perangkat Face Recognition (lihat §7) | P1 | Selesai |
| F12 | Petugas jaga stand pameran | P1 | Selesai |
| F13 | Dashboard dan rekap admin (jumlah peserta, pembayaran, pengajuan) | P1 | Belum |
| F14 | Log aktivitas institusi | P2 | **Parsial** (pencatatan `log_institusi`/`log_peserta` sudah berjalan sebagai bagian dari F03/F11, belum ada halaman khusus untuk menampilkan riwayatnya) |
| F15 | Ekspor data (Excel/PDF) | P2 | Belum |
| F16 | Manajemen peserta oleh admin (lihat semua data peserta, dikelompokkan per institusi asal) dan dashboard ringkasan peserta | P1 | Selesai |
| F17 | Portal registrasi peserta (gerbang buka/tutup sesi registrasi berbasis jadwal master `jadwal_penting`) | P0 | Selesai |
| F18 | Persiapan seminar kit per kontingen oleh Petugas Kit, setelah masa registrasi online ditutup (lihat §6.3) | P1 | Belum |
| F19 | Registrasi kontingen di lokasi acara pada hari kedatangan, dengan sistem antrian (lihat §6.3 dan `docs/features/019-registrasi-antrian-kontingen.md`) | P1 | Belum |
| F20 | Pengajuan MoU antar institusi — peserta (sebagai perwakilan institusi) mengajukan MoU ke institusi lain; institusi yang dituju memilih **Temu Diskusi** atau **Tunda lain waktu** (lihat §6.4) | P2 | Selesai |
| F21 | Penjadwalan pertemuan MoU — saat disepakati Temu Diskusi, tentukan tanggal, sesi jam, dan ruang pertemuan (lihat §6.4) | P2 | Belum |
| F22 | Konfirmasi kehadiran pertemuan MoU oleh **Petugas Ruang MoU** (role baru, `idrole` 7) pada hari pertemuan terjadwal (lihat §6.4) | P2 | Belum |
| F23 | Rekap jumlah kerjasama (MoU) yang terjalin, untuk kebutuhan panitia (lihat §6.4) | P2 | Belum |
| F24 | Manajemen MoU oleh Admin — menu "Pengajuan MoU" dengan submenu **Sesi MoU** (lihat data master), **Ruang MoU** (lihat data master), **Tanggal MoU** (lihat, tambah, soft delete), dan **Pertemuan MoU** (matrix slot per tanggal+ruang, tombol "Sesuaikan Slot" mengisi otomatis sesuai kapasitas ruang) (lihat §6.4) | P2 | **Parsial** (generator slot `pertemuan_mou` sudah ada sebagai Artisan command, belum ada halaman admin) |

> Urutan pengerjaan yang disarankan: **F01 → F03 → F04 → F05/F06 → F07/F08 → sisanya**.
> Ini mengikuti kebutuhan minimum agar pendaftaran bisa dibuka.

## 6. Alur bisnis utama

### 6.1 Registrasi dan pembayaran
1. Calon peserta memilih **jenis institusi**; form menyesuaikan field yang diminta.
2. Verifikasi nomor WA via OTP 6 digit.
3. Akun dan institusi terbentuk; **kode kontingen** dibuat otomatis (format `XXZZZ`: XX = tanggal 2 digit, ZZZ = urutan pada hari itu).
4. Tagihan dibuat dan VA BNI diterbitkan `[TBD: nominal dan aturan tagihan per jenis institusi]`.
5. Pembayaran masuk (bisa sebagian) → status tagihan: `1 tertagih` → `2 terbayar sebagian` → `3 lunas` (atau `4 batal`).

### 6.2 Pengajuan narasumber dan pameran
Status pengajuan (dipakai sama pada narasumber dan pameran):

`1 draft` → `2 pengajuan` → `3 review` → `4 revisi` ⇄ `3 review` → `5 diterima` / `6 ditolak`

- Peserta menyusun dan mengirim pengajuan (abstrak, berkas).
- SC mereview, memberi catatan, dan memutuskan.
- Pada status revisi, peserta memperbarui dan mengirim ulang.
- `[TBD: apakah pameran berbayar dan tagihan terbit setelah diterima? Skema tagihan memuat idpameran.]`

### 6.3 Seminar kit dan registrasi kontingen di lokasi

**Seminar kit**: satu paket (tas) berisi alat tulis (notebook, ballpoint), kartu peserta, dan kelengkapan lain. **Satu seminar kit = satu peserta.**

Alur (F18 sudah dirancang di bawah; F19 — spesifikasi lengkap di `docs/features/019-registrasi-antrian-kontingen.md`, beberapa detail teknis masih `[TBD]` di sana):

1. Setelah masa registrasi online ditutup, **Petugas Kit** (role baru, `idrole` 5) menyiapkan seminar kit dan **mengelompokkannya per kontingen** — jumlah kit per kontingen mengikuti jumlah peserta terdaftar di kontingen tersebut. (**F18**)
2. Pada hari kedatangan, ada sesi **registrasi kontingen di lokasi acara**. Satu kontingen cukup diwakili **satu peserta**; perwakilan ini menerima sekaligus seluruh seminar kit untuk kontingennya (sejumlah peserta di kontingen itu). Sesi ini memakai **sistem antrian** — perwakilan mengambil nomor antrian lewat halaman publik (tanpa login), menunggu dipanggil lewat layar tampilan antrian, lalu dilayani oleh **Petugas Meja Registrasi** (role baru, `[TBD]` idrole). (**F19**)
3. Tujuan pengelompokan di langkah 1: begitu perwakilan kontingen registrasi di lokasi (langkah 2), seminar kit kontingen itu sudah siap sejumlah pas, sehingga proses registrasi lokasi berjalan lebih lancar/cepat.

### 6.4 Pengajuan MoU antar institusi

Tujuan: memberi kesempatan bagi institusi yang terdaftar di KPPTI untuk saling menjajaki kerja sama (MoU), dan memudahkan panitia menghitung berapa kerja sama yang terjalin selama event.

Peserta bertindak **sebagai perwakilan institusinya** — MoU terjadi antar institusi (`institusi_asal`), bukan antar individu. Tabel terkait: `pengajuan_mou`, `log_status_mou`, `lampiran_mou`, `sesi_mou`, `ruang_mou`, `tanggal_mou`, `pertemuan_mou` (lihat migrasi terbaru di `database/migrations/`).

**Status pengajuan** (`pengajuan_mou.status_ajuan`):

`1 Ajuan` → `2 Temu diskusi` **atau** `3 Tunda lain waktu` → ... → `4 Terjalin` / `5 Dibatalkan`

Alur:

1. Peserta (mewakili institusi pengaju, `idinstitusi_pengaju`) memilih institusi lain yang terdaftar sebagai mitra (`idinstitusi_mitra`) dan mengajukan MoU, dengan PIC dari masing-masing pihak (`idpic_institusi_pengaju`, `idpic_institusi_mitra`). Bisa melampirkan berkas/catatan pendukung (`lampiran_mou`, `jenis_lampiran`: 1 file, 2 catatan).
2. Peserta yang mewakili institusi mitra menerima ajuan ini, lalu memilih: **Temu Diskusi** atau **Tunda lain waktu**.
3. Bila **Temu Diskusi** dipilih, pengajuan berlanjut ke penjadwalan: pilih tanggal (`tanggal_mou`), sesi jam (`sesi_mou`), dan ruang (`ruang_mou`) → tercatat sebagai satu `pertemuan_mou`.
4. Pada hari pertemuan, **Petugas Ruang MoU** (role baru, `idrole` 7) bertugas di ruang yang dijadwalkan, mencatat kehadiran PIC pengaju dan PIC mitra (`pic_pengaju_hadir_at`/`pic_mitra_hadir_at`, distempel oleh petugas lewat `pic_pengaju_stamp_by`/`pic_mitra_stamp_by`).
5. Setiap perubahan status dicatat di `log_status_mou` (audit trail, siapa & kapan).
6. Hasil akhir pengajuan: `4 Terjalin` (kerja sama disepakati) atau `5 Dibatalkan`. Panitia (Admin) dapat merekap jumlah MoU yang terjalin selama event (F23).

**Sisi Admin (F24)** — master data dan slot pertemuan dikelola lewat menu "Pengajuan MoU" tersendiri, 4 submenu:

- **Sesi MoU**: lihat isi `sesi_mou` (jam mulai/akhir tiap sesi).
- **Ruang MoU**: lihat isi `ruang_mou` (nama ruang + kapasitas meja).
- **Tanggal MoU**: lihat isi `tanggal_mou`, bisa **menambah tanggal baru** dan **soft delete** (kolom `status`).
- **Pertemuan MoU**: halaman paling kompleks — filter **Tanggal MoU** dan **Ruang** (wajib pilih satu ruang, tidak ada opsi "semua ruang"), lalu tampilan **matrix**: kolom = nomor meja (`pertemuan_mou.isi_ke`), baris = sesi (`sesi_mou.jam_mulai`-`jam_akhir`, format jam:menit saja). Tombol **"Sesuaikan Slot"** di atas matrix — mengisi otomatis slot yang belum ada untuk kombinasi tanggal+ruang itu sampai tiap sesi punya slot sejumlah kapasitas meja ruang tersebut (idempoten — kalau sudah penuh/sesuai, tidak menambah apa pun). Setelah proses, tampilkan notifikasi jumlah slot yang ditambahkan (bisa `0` kalau sudah lengkap). Generator slot (logika "Sesuaikan Slot") sudah ada sebagai Artisan command `app:generate-slot-pertemuan-mou` (lihat `app/Console/Commands/GenerateSlotPertemuanMou.php`) — tinggal dipanggil dari halaman admin, bukan dibangun ulang dari nol.

`[TBD: detail lanjutan menyusul didiskusikan — lihat §11]`

## 7. Integrasi eksternal

| Layanan | Kegunaan | Status |
|---|---|---|
| **WA Gateway** | OTP registrasi, reset password | Sudah berfungsi (curl dan key tersedia) |
| **VA BNI** | Penerbitan VA dan notifikasi pembayaran | Belum; `[TBD: dokumentasi API dan kredensial sandbox]` |
| **Hikvision MinMoe (Face Recognition)** | API `GET /api/face-recognition/peserta` — server manajemen perangkat MinMoe menarik data peserta (nama, NIM/NIDN dari `idpengguna`, info perguruan tinggi/LLDikti) untuk didaftarkan ke perangkat face recognition di lokasi acara. Endpoint publik tanpa sesi, dibatasi whitelist IP (`FACE_RECOGNITION_ALLOWED_IPS` di `.env`) | Sudah berfungsi |

## 8. Kebutuhan non-fungsional

- Bahasa antarmuka: **Bahasa Indonesia**.
- Responsif (peserta dominan mengakses dari HP) — Bootstrap 5.2.2.
- Keamanan: hash password, proteksi CSRF, otorisasi per role di setiap route, validasi input di server (bukan hanya JavaScript), berkas unggahan divalidasi tipe dan ukuran.
- Data pribadi (nama, email, no. WA) hanya diakses role yang berwenang.
- Beban puncak diperkirakan saat pendaftaran dibuka `[TBD: perkiraan jumlah peserta]`.

## 9. Di luar cakupan (out of scope)

- Aplikasi mobile native.
- Check-in/scan QR di lokasi `[TBD: konfirmasi apakah dibutuhkan]`.
- Pembayaran selain VA BNI.
- Pemesanan tiket transportasi atau hotel (hanya pencatatan data).

## 10. Batasan proyek

- Target internal developer: aplikasi selesai **minggu ini**, dilanjutkan masa koreksi sebelum dipakai; pendaftaran dibuka bulan depan. Ini target pribadi, bukan tenggat pihak luar, sehingga kualitas tidak boleh dikorbankan demi kecepatan.
- Developer tunggal yang mereview semua hasil AI.
- Database PostgreSQL dengan skema awal `kppti_5.sql`.

## 11. Pertanyaan terbuka

1. Nominal dan aturan tagihan per jenis institusi/peserta?
2. Apakah pameran berbayar?
3. Apakah check-in di lokasi masuk cakupan?
4. Tanggal dan lokasi pasti event?
5. Apakah SC juga bisa memiliki role narasumber?
6. F19 (registrasi kontingen di lokasi + sistem antrian): alur inti sudah dijelaskan developer dan didokumentasikan di `docs/features/019-registrasi-antrian-kontingen.md`; beberapa detail teknis masih terbuka (nomor meja, role baru, mekanisme audio TTS, library PDF) — lihat §8 dokumen tersebut.
7. F21-F23 (Pengajuan MoU, lihat §6.4): rincian alur UI Peserta memilih tanggal/sesi/ruang pertemuan (F21, memanfaatkan slot `pertemuan_mou` yang disiapkan F24), alur Petugas Ruang MoU (F22), dan tampilan rekap F23 untuk Admin — menyusul didiskusikan dengan developer. (Catatan: F20 sudah selesai, dan F24 — siapa mengelola master data `sesi_mou`/`ruang_mou`/`tanggal_mou`/`pertemuan_mou` — sudah terjawab: **Admin**, lewat menu tersendiri.)
