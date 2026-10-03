# F17 — Portal Registrasi Peserta

> Melengkapi F17 di `PRD.md` ("Portal Registrasi Peserta").
> Status: **spesifikasi lengkap** (dikte langsung oleh developer) — siap diimplementasikan.

## 1. Tujuan

Gerbang buka/tutup untuk proses-proses berjadwal di KPPTI 2026, berbasis tabel master baru `jadwal_penting`. Saat ini baru **Registrasi Peserta** yang punya portalnya (satu-satunya proses yang sudah dibangun); "Pengajuan Narasumber" dan "Pengajuan Pameran" sudah terdaftar sebagai baris master data (untuk dipakai F05/F07 nanti) tapi belum ada gerbangnya karena fiturnya sendiri belum dibangun.

## 2. Skema tabel (sudah ada di live DB, migrasi menyusul ditandai *applied*)

Tabel `jadwal_penting` (dikonfirmasi lewat `database-schema`, sudah ada datanya di live DB):

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idjadwal_penting` | integer, PK, auto | **Nilai tetap** — `1` Registrasi Peserta, `2` Pengajuan Narasumber, `3` Pengajuan Pameran (dikonfirmasi dari data live, bukan ditebak). |
| `nama_jadwal` | varchar(255), nullable | Nama proses, untuk ditampilkan di halaman tertutup. |
| `timestamp_buka` | timestamp, nullable | Kapan sesi mulai dibuka (dipakai saat `mode=1`). |
| `timestamp_tutup` | timestamp, nullable | Kapan sesi berakhir (dipakai saat `mode=1`). |
| `mode` | char(1), nullable | **Dikonfirmasi developer**: `1` = **auto** (ikuti `timestamp_buka`/`timestamp_tutup`), `2` = **open** (selalu terbuka, mengabaikan timestamp). |

Data master saat ini (diambil dari live DB untuk seeder, lihat §6):

| id | nama_jadwal | timestamp_buka | timestamp_tutup | mode |
|---|---|---|---|---|
| 1 | Registrasi Peserta | 2026-10-02 12:00:00 | 2026-10-06 20:31:31 | 1 |
| 2 | Pengajuan Narasumber | 2026-10-02 12:00:00 | 2026-10-06 20:31:31 | 1 |
| 3 | Pengajuan Pameran | 2026-10-02 12:00:00 | 2026-10-06 20:31:31 | 1 |

## 3. Aturan buka/tutup

- `mode = '2'` (open): sesi **selalu terbuka**, `timestamp_buka`/`timestamp_tutup` diabaikan sepenuhnya.
- `mode = '1'` (auto): sesi terbuka **hanya jika** waktu sekarang berada di antara `timestamp_buka` dan `timestamp_tutup` (inklusif). Kalau salah satu timestamp kosong (null), sisi itu dianggap tidak membatasi (`timestamp_buka` null = tidak ada batas bawah, `timestamp_tutup` null = tidak ada batas atas).
- Baris `jadwal_penting` tidak ditemukan untuk id yang diminta (data hilang/salah konfigurasi) → dianggap **tertutup** (fail-safe, bukan fail-open), supaya kesalahan konfigurasi tidak diam-diam membuka akses publik.

## 4. Mekanisme portal: middleware `jadwalPenting:{id}`

Mengikuti pola `akses:{idrole}` yang sudah ada (`AksesMiddleware`/alias `akses`):

- Middleware baru `JadwalPentingMiddleware`, alias `jadwalPenting`, didaftarkan di `bootstrap/app.php` sejajar `akses`.
- Dipasang ke grup rute registrasi (`routes/web.php`: `/registrasi`, `/registrasi/kirim-otp`, `/registrasi/cek-otp`, `/registrasi/search-universitas`, `/registrasi/search-institusi`, `/registrasi/store`) dengan parameter `jadwalPenting:1`.
- Kalau sesi **terbuka**: lanjut ke controller seperti biasa (`$next($request)`).
- Kalau sesi **tertutup**:
  - Request yang mengharapkan JSON (`$request->expectsJson()`/AJAX — berlaku untuk endpoint OTP dan search) → respons JSON 403 dengan bentuk yang sama seperti `jsonResponse()` (`code`/`status`/`message`/`data`), supaya JS front-end yang sudah ada tidak perlu diubah pola errornya.
  - Request halaman biasa (`GET /registrasi`) → render langsung view halaman tertutup (bukan redirect, supaya URL tetap `/registrasi` dan tidak ada redirect loop), status HTTP 403.
- Dipasang per-rute dengan parameter angka (bukan hardcode di controller) supaya **reusable** untuk F05 (`jadwalPenting:2`) dan F07 (`jadwalPenting:3`) saat fitur itu dibangun nanti — di luar cakupan F17 untuk membuat gerbang narasumber/pameran sungguhan sekarang, tapi arsitekturnya sudah siap dipakai ulang.

## 5. Halaman "Sesi Ditutup"

View baru `resources/views/jadwal-tertutup.blade.php` — halaman mandiri (bukan `layout.layout`, mengikuti pola `registrasikppti.blade.php`/`login_kppti.blade.php` yang juga mandiri), dengan panel kiri branding KPPTI yang sama (dipakai ulang persis dari `registrasikppti.blade.php`) dan panel kanan berisi pesan status:

- Kalau sekarang **sebelum** `timestamp_buka` (dan sesi memang `mode=1`): "Registrasi belum dibuka. Akan dibuka pada **{tanggal+jam timestamp_buka}**."
- Kalau sekarang **setelah** `timestamp_tutup`: "Registrasi telah ditutup pada **{tanggal+jam timestamp_tutup}**."
- Tombol/link kembali ke halaman login.

## 6. Migrasi & seeder

- Migrasi baru `create_jadwal_penting_table` sesuai skema §2 — tabel sudah ada di live DB (dari `kppti_16.sql` yang disebut developer, walau berkasnya sendiri belum ada di repo), jadi migrasi ini **ditandai *applied*** (insert manual ke tabel `migrations`), bukan dijalankan ulang — pola yang sama seperti perubahan skema `acara` sebelumnya.
- Seeder baru `JadwalPentingSeeder` (data master) — isi 3 baris di §2, pola `insertOrIgnore` + `syncSequence` seperti `JenisTransportSeeder`, didaftarkan di `DatabaseSeeder`.

## 7. Halaman admin: mengatur jadwal (revisi — developer sempat lupa menyebutkan ini di awal)

**Admin bisa mengubah `mode`/`timestamp_buka`/`timestamp_tutup`** lewat UI, bukan cuma lewat database langsung:

- Controller baru `JadwalPentingController` (`index()` GET, `update(Request $request)` POST), rute di `routes/admin.php` (`admin.jadwal-penting`, `admin.jadwal-penting.update`), middleware `akses:1`.
- `idjadwal_penting` adalah **nilai tetap** (1/2/3) — ini **bukan** CRUD penuh, admin hanya **mengedit** ke-3 baris yang sudah ada (`mode`/`timestamp_buka`/`timestamp_tutup`), tidak ada tambah/hapus baris. Validasi `idjadwal_penting` dibatasi `in:1,2,3` (bukan `exists` generik) supaya percobaan mengirim id lain ditolak jelas. `nama_jadwal` ditampilkan read-only (bukan field yang diedit).
- View baru `resources/views/admin/jadwal-penting.blade.php` — tabel 3 baris tetap (bukan accordion), tiap baris menampilkan `mode`, waktu buka/tutup, dan **badge status saat ini (Terbuka/Tertutup)** dihitung langsung di Blade dengan logika yang sama persis seperti `JadwalPentingMiddleware::sedangBuka()`, supaya admin langsung melihat efek perubahannya. Modal edit per baris (pola `$.ajax` + SweetAlert2 + `jsonResponse()`, sama seperti `admin/acara.blade.php`).
- Menu sidebar baru "Jadwal Penting" di `resources/views/layout/menu_admin.blade.php`, sejajar menu "Acara".

## 8. Gerbang kedua: kunci **pilihan acara** setelah `timestamp_tutup` (revisi kedua — cakupan dipersempit)

Gerbang registrasi (§4) hanya mengatur **pendaftaran peserta baru**. Developer menambahkan syarat kedua: begitu **waktu sekarang ≥ `timestamp_tutup`** (jadwal id=1, Registrasi Peserta), peserta yang **sudah terdaftar** tidak boleh lagi mengubah **pilihan acaranya**.

**Revisi developer**: cakupan awalnya sempat mencakup data kontingen juga (institusi, tambah/update peserta, logistik, foto), lalu **dipersempit hanya ke pilihan acara** — data peserta secara umum tetap boleh diubah kapan saja, tidak ikut dikunci. Alasannya: tujuan gerbang ini adalah **alokasi konsumsi di ruangan** (jumlah peserta per acara perlu final untuk perencanaan konsumsi/logistik ruangan), bukan membekukan seluruh data kontingen.

Ini **beda logika** dari gerbang registrasi: gerbang registrasi menolak kalau **belum dibuka atau sudah ditutup** (dua sisi); gerbang ini **hanya** peduli "sudah lewat tutup" — sisi "belum dibuka" tidak relevan karena mustahil ada peserta terdaftar sebelum registrasi pernah dibuka.

- `JadwalPentingMiddleware::handle()` menerima parameter ke-2 opsional `$syarat` (`'buka'` default, atau `'tutup'`). Saat `$syarat='tutup'`, middleware memanggil `belumTutup()` (bukan `sedangBuka()`): `mode='2'` tetap selalu lolos; `mode='1'` lolos selama `now() < timestamp_tutup` (null `timestamp_tutup` = tidak ada batas, selalu lolos).
- Dipasang di `routes/peserta.php` sebagai `jadwalPenting:1,tutup`, membungkus **hanya 2 rute**: `peserta.sekontingen.acara.daftar` dan `peserta.sekontingen.acara.batal`. Rute data kontingen lain (`peserta.institusi.update`, `peserta.sekontingen.tambah`, `peserta.sekontingen.update`, `peserta.sekontingen.logistik.update`, `peserta.sekontingen.foto.update`, `peserta.sekontingen.reset-password`) **tidak** digerbangi — tetap bisa diubah kapan saja.
- Rute yang digerbangi di sini adalah endpoint `$.ajax`/POST, jadi responsnya selalu JSON 403 (`{"code":403,"message":"Periode registrasi sudah ditutup. Data peserta dan pilihan acara tidak bisa diubah lagi."}`) — tidak pernah jatuh ke render halaman `jadwal-tertutup.blade.php` (itu hanya relevan untuk gerbang registrasi di §4/§5 yang punya halaman GET).

## 9. Jalur admin: tetap bisa mengubah pilihan acara peserta setelah tutup

**Jaga-jaga untuk hari pelaksanaan**: kalau ada peserta yang perlu mengubah pilihan acaranya setelah §8 mengunci rute `peserta.sekontingen.acara.*`, admin bisa melayani lewat jalur terpisah:

- Menu baru "Acara" di bawah "Users" (`resources/views/layout/menu_admin.blade.php`) → `admin.peserta.acara` (daftar semua peserta lintas institusi, dikelompokkan jenis institusi → institusi, tombol "Pilih Acara" per baris) → `admin.peserta.pilih-acara` (halaman sama persis seperti `peserta/pilih-acara.blade.php`: checkbox wajib terkunci, badge opsi-pilih, validasi bentrok) → AJAX ke `admin.peserta.acara.daftar`/`.batal`.
- Method-method ini (`PesertaAdminController::acara()`/`pilihAcara()`/`daftarAcara()`/`batalAcara()`) **menduplikasi logika persis** dari `PesertaController` yang sepadan, cuma ganti pencarian peserta dari `findPesertaInOwnInstitusi()` (scoped sekontingen) ke `findPesertaById()` (lintas institusi, sudah ada sejak F16) — pola duplikasi yang sama seperti method admin lain di controller ini.
- **Rute ini hidup di grup `akses:1`, terpisah total dari grup `akses:2` milik peserta** — jadi secara struktural **tidak pernah** digerbangi `jadwalPenting:1,tutup` (middleware itu cuma dipasang di `routes/peserta.php`). Tidak perlu logika bypass khusus; admin otomatis bisa akses kapan pun, sebelum maupun sesudah tutup.
- **Dikonfirmasi developer**: cakupan jalur admin ini **hanya untuk pilihan acara** — admin belum bisa mengedit data umum peserta (nama/email/jabatan/logistik/foto) lewat jalur ini.
- `acaraBentrok()` (validasi bentrok jadwal) dipindah dari `PesertaController` (privat) ke base `Controller.php` (`protected`) supaya dipakai bareng kedua controller tanpa duplikasi logika pengecekan bentrok itu sendiri.

## 10. Di luar cakupan

- Gerbang sungguhan untuk Pengajuan Narasumber (F05)/Pengajuan Pameran (F07) — fiturnya sendiri belum dibangun, baris datanya sudah disiapkan tapi middleware-nya belum dipasang di rute manapun.
- Login/akses existing user tidak digerbang oleh fitur ini — hanya proses pendaftaran baru dan perubahan data peserta/acara yang dibatasi.

Dokumen ini siap dijadikan acuan implementasi.
