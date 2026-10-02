# F03 — Manajemen Institusi Asal dan Kontingen (area Peserta)

> Melengkapi F03 di `PRD.md` ("Manajemen institusi asal dan kode kontingen"). Untuk pola controller/rute lihat `ARCHITECTURE.md`, untuk gaya kode lihat `CONVENTIONS.md`.
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide tambahan dari AI, **menunggu konfirmasi** — jangan dianggap disetujui sebelum developer menjawab.
> Kelengkapan data peserta (field logistik) dan kartu registrasi kontingen (PDF) **dipindah ke `011-logistik-dan-kartu-kontingen.md` (F11)** — di luar cakupan dokumen ini.
> Status: **spesifikasi lengkap** (semua pertanyaan terbuka sudah dijawab). Migrasi tabel `log_peserta` **sudah dibuat, FK-nya sudah diperbaiki, dan sudah dijalankan** (lihat catatan skema di §5.1). Menunggu kata "mulai" dari developer sebelum coding fitur (controller/rute/view) dimulai.

## 1. Tujuan

Setelah peserta login (role aktif = Peserta, `idrole=2`), sediakan area kerja peserta (`resources/views/peserta/`, `PesertaController`, `routes/peserta.php`, menu `resources/views/layout/menu_peserta.blade.php`) yang memungkinkan peserta:

1. Melihat dan (terbatas) mengubah data institusi asalnya sendiri.
2. Melihat semua peserta lain dalam kontingen (institusi) yang sama.
3. Menambah, mengedit, dan mereset password peserta lain dalam kontingen yang sama — dengan verifikasi eksplisit sebelum tiap aksi.
4. Mendaftar ke acara — **di-hold**, menyusul setelah data acara siap (lihat §3).

Kelengkapan data peserta dan kartu registrasi kontingen (PDF) — lihat F11 (`011-logistik-dan-kartu-kontingen.md`).

## 2. Struktur & menu (baru)

Mengikuti pola `ARCHITECTURE.md` §2 (folder per role dibuat saat fiturnya digarap):

```
app/Http/Controllers/PesertaController.php
routes/peserta.php                          ← group middleware akses:2, di-include dari web.php
resources/views/peserta/                    ← home, institusi, daftar-peserta, form peserta
resources/views/layout/menu_peserta.blade.php ← disesuaikan (saat ini masih copy menu_admin.blade.php)
```

**Usulan menu sidebar** (developer minta masukan, akan dikoreksi sambil jalan):

- **Beranda** — ringkasan singkat: nama institusi, kode kontingen **disembunyikan**, jumlah peserta dalam kontingen. Nanti (F11) di sini juga tempat status kelengkapan data & tombol unduh kartu.
- **Institusi Asal** — lihat/ubah data institusi (§4).
- **Peserta Sekontingen** — daftar semua peserta di kontingen yang sama + tambah/edit/reset password (§5). Mengedit **data diri sendiri** juga dilakukan dari sini (baris peserta yang login ditandai, pakai tombol Edit yang sama), jadi **tidak** dibuat menu "Data Saya" terpisah — lebih sederhana dan tidak duplikasi kode. Ganti password mandiri (tanpa perlu tahu password lama vs reset-oleh-orang-lain) tetap lewat `profile.blade.php` yang sudah ada lintas role, tidak dibuat ulang di sini.

## 3. Di luar cakupan (out of scope)

- **Pendaftaran ke acara** (poin 4 dikte developer) — **di-hold**, data acara (`acara`, F09) belum siap. Tidak dikerjakan sama sekali di F03 ini.
- **Kelengkapan data peserta (field logistik) dan kartu registrasi kontingen (PDF)** — dipisah jadi **F11** (`011-logistik-dan-kartu-kontingen.md`), dikerjakan terpisah setelah F03.
- Tagihan/pembayaran (F04).
- Perubahan `jenis_institusi` institusi (mis. dari "Perguruan Tinggi" jadi "Lainnya") — **tidak** termasuk kolom yang bisa diubah (lihat §4). **Dikonfirmasi developer**: untuk saat ini akses ubah institusi tetap ada di sisi peserta sendiri (belum ada halaman Admin untuk ini), dan yang boleh diubah **hanya** kolom-kolom di §4 (tidak termasuk `idjenis_institusi`) — kalau `jenis_institusi` perlu diperbaiki, ini di luar cakupan F03, ditangani lain waktu/cara.
- Registrasi peserta baru lewat form publik (`registrasi_kppti`) — sudah dikerjakan di F01, tidak diubah di sini.

## 4. Institusi asal: lihat dan ubah data

**Tampilan**: nama institusi, jenis institusi, PTN/PTS (kalau relevan), wilayah LLDikti (kalau relevan). **`kode_kontingen` disembunyikan** dari tampilan peserta (sesuai permintaan developer) — tapi tetap dipakai di internal (mis. untuk kartu kontingen, F11).

**Kolom yang boleh diubah peserta** (hanya kolom di tabel `institusi_asal`, via form edit, dengan validasi server penuh) — **dikonfirmasi developer**:

| Jenis institusi | Kolom yang boleh diubah | Validasi |
|---|---|---|
| Perguruan Tinggi (`idjenis_institusi=1`) | `ptn_pts`, `nama_institusi` | `ptn_pts`: `in:1,2`; `nama_institusi`: required, string |
| LLDikti (`idjenis_institusi=4`) | `idlldikti`, `nama_institusi` | `idlldikti`: `exists:lldikti,idlldikti`; `nama_institusi`: required, string |
| Jenis lain (Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya) | `nama_institusi` saja | required, string |

Field mana yang ditampilkan di form edit ditentukan oleh `idjenis_institusi` institusi yang login (server tetap memvalidasi ulang sesuai jenisnya, jangan percaya field mana yang dikirim client — sesuai `CONVENTIONS.md` §6.5).

**Perubahan `nama_institusi` — pertimbangan dedup** (mengikuti §7 di `001-registrasi-peserta.md`, prinsip "satu institusi = satu kontingen" harus tetap terjaga):

- Untuk **Perguruan Tinggi**: pencocokan institusi baru saat registrasi tetap berdasarkan `idref_institusi` (bukan `nama_institusi`), jadi mengganti `nama_institusi` di sini **tidak** memengaruhi logika dedup pendaftar baru — aman diubah bebas (mis. meralat nama universitas yang sudah berganti nama).
- Untuk **jenis lain** (LLDikti, Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya): dedup saat registrasi mengandalkan `trim()`+`ilike` exact match pada `nama_institusi` (di-scope `idjenis_institusi`, dan `idlldikti` untuk LLDikti). Kalau nama diubah di sini jadi sama persis dengan `institusi_asal` lain yang sudah ada (scope sama), itu akan menggandakan nama tapi tetap dua kontingen terpisah.
- **Dikonfirmasi developer**: **tolak** perubahan (validasi server, pesan error jelas) kalau nama baru **persis sama** (setelah `trim()`+`ilike`, scope sama: `idjenis_institusi` dan `idlldikti` untuk LLDikti) dengan `institusi_asal` **lain** (id berbeda) yang sudah ada. Aturan yang sama berlaku juga untuk perubahan `idlldikti` (kombinasi nama+wilayah baru tidak boleh identik dengan institusi lain).
- **Dikonfirmasi developer**: `nama_institusi` disimpan dalam **huruf kapital semua** (`mb_strtoupper`) setiap kali disimpan — baik saat registrasi (F01) maupun saat diedit di sini. Pencocokan dedup (`ilike`) tidak terpengaruh (case-insensitive), tapi penyeragaman ini membuat tampilan lebih rapi dan konsisten. **Catatan implementasi**: ini berarti `PenggunaController::resolveInstitusiAsal()` (F01) juga perlu disesuaikan supaya konsisten (uppercase saat insert), dilakukan saat coding F03/patch kecil ke F01 — bukan mengubah data yang sudah lanjur tersimpan sebelumnya kecuali diminta.

**Log wajib** (dikonfirmasi developer, satu baris log per kolom yang berubah, format teks bebas-deskriptif): setiap perubahan insert satu baris ke `log_institusi` per kolom yang berubah:
- `idinstitusi_asal` = institusi yang diubah.
- `done_by` = `idpengguna` peserta yang melakukan perubahan.
- `done_at` = `now()`.
- `aktifitas` = kalimat sederhana `"{Nama field} diubah dari '{nilai lama}' menjadi '{nilai baru}'"`, contoh:
  - `"PTN/PTS diubah dari 'PTN' menjadi 'PTS'"`
  - `"Wilayah LLDikti diubah dari 'IV' menjadi 'VII'"`
  - `"Nama institusi diubah dari 'Universitas A' menjadi 'Universitas B'"`
  - Kalau beberapa kolom berubah dalam satu submit → beberapa baris log (satu per kolom), semua dengan `done_at`/`done_by` yang sama.

**Verifikasi sebelum simpan** (dikonfirmasi developer): pakai **modal teks peringatan**, mekanisme sama persis dengan §5.1 (bukan SweetAlert2) — prevent paste, tombol simpan disabled sampai teks cocok persis, reuse komponen/partial yang sama. Teks peringatan disesuaikan konteksnya: **"YA SAYA SECARA SADAR MERUBAH DATA INSTITUSI"** (bukan "...DATA PESERTA", karena yang diubah data institusi) `[USULAN AI — penyesuaian kalimat wajar, bukan pertanyaan terbuka, tapi silakan koreksi kalau developer mau teks lain]`.

## 5. Peserta sekontingen: lihat, tambah, edit, reset password

**Daftar**: semua peserta (`pengguna` + `peserta` + `role_pengguna` aktif idrole=2) dengan `idinstitusi_asal` sama dengan peserta yang login. Kolom yang ditampilkan (**dikonfirmasi developer**): nama, email, no. WA, jabatan — status kelengkapan data (badge) baru relevan setelah F11 selesai, bisa ditambahkan ke tabel ini nanti.

**Tambah peserta baru** (dalam kontingen yang sama):
- Field: nama, email, nomor WA, jabatan. **Tanpa** field password, **tanpa** verifikasi OTP nomor WA (beda dari F01 — di sini yang menambahkan sudah terautentikasi dan bertanggung jawab atas data yang dimasukkan).
- Password: digenerate acak lewat fungsi generator baru (lihat §5.2) — **bukan** `generateRandomToken()` yang sudah ada, karena harus lolos aturan `Password::min(8)->mixedCase()->numbers()->symbols()`.
- `idinstitusi_asal` peserta baru **otomatis** sama dengan institusi peserta yang menambahkan (tidak bisa pilih institusi lain).
- Setelah insert: kirim WA (`kirim_wa_oca_token_3`, reuse pola F01) berisi email + password ke nomor WA yang diinput.
- Validasi email & no_wa tetap **unique** di `pengguna` (sama seperti F01) — beri pesan error jelas kalau bentrok, bukan exception mentah.
- Role: insert `role_pengguna` (`idrole=2`, `status=true`) seperti F01.
- **Verifikasi** (dikonfirmasi developer): **bukan** modal teks peringatan (§5.1) — cukup konfirmasi **SweetAlert2** standar sebelum submit, teks: **"Apakah data peserta sudah benar?"**. Kalau dikonfirmasi ("Ya") baru kirim `$.ajax`.

**Edit peserta** (baik peserta lain dalam kontingen, maupun diri sendiri) — **dikonfirmasi developer**: field yang bisa diubah hanya **nama, email, no. WA, jabatan** (field logistik ada di F11). Verifikasi: modal teks peringatan §5.1. Setiap kolom yang berubah dicatat ke `log_peserta` (lihat §5.1).

**Reset password** (peserta lain maupun diri sendiri) — **dikonfirmasi developer**: logika & verifikasi **sama seperti reset password Admin/SC** (`AdminController::resetPassword` + modal admin-users), **bukan** modal teks peringatan §5.1:
1. Tombol "Reset Password" memicu **SweetAlert2** konfirmasi, teks: `"Password akan dikirim ke no WA {no_wa peserta}"` (pola persis sama seperti `admin-users.blade.php`).
2. Kalau dikonfirmasi ("Ya, reset") → `$.ajax` ke endpoint reset password: generate password baru lewat fungsi generator §5.2, `Hash::make()`, update `pengguna.password`, kirim WA (email + password baru) ke `no_wa` yang **tersimpan di database** (bukan input yang belum disimpan di form, kalau ada).
3. Tidak perlu OTP.
4. Dicatat ke `log_peserta`: `aktifitas = "Password direset"` (tanpa menyebut password baru, demi keamanan — sesuai `CONVENTIONS.md` §7 "jangan log data sensitif").

### 5.1 Modal verifikasi teks peringatan (edit peserta & edit institusi — bukan tambah peserta, bukan reset password)

Berlaku untuk: **edit peserta lain, edit diri sendiri** (§5), dan **edit institusi asal** (§4). **Tidak** berlaku untuk "tambah peserta baru" (SweetAlert2 biasa) maupun "reset password" (SweetAlert2 + pola admin/SC, lihat di atas).

Alur modal:
1. Modal muncul saat tombol aksi (Edit) diklik, sebelum request dikirim.
2. Isi modal: info jelas data siapa/apa yang akan diubah, lalu satu input teks dengan instruksi: ketik persis **"YA SAYA SECARA SADAR MERUBAH DATA PESERTA"** (untuk edit peserta) atau **"YA SAYA SECARA SADAR MERUBAH DATA INSTITUSI"** (untuk edit institusi, lihat §4).
3. Input teks ini **prevent paste** (event `paste` di-`preventDefault()`, pola sama seperti field "Ulangi Email"/"Ulangi Kata Sandi" di F01).
4. Tombol eksekusi di modal **disabled** secara default, jadi **enabled** hanya kalau isi input **sama persis** dengan teks di atas — **dikonfirmasi developer: harus persis sama termasuk besar/kecil huruf dan spasi, tanpa trim** (tujuannya memastikan pengguna benar-benar sadar/teliti mengetik ulang) — dicek live tiap `input` event (bukan hanya saat submit).
5. Saat tombol eksekusi diklik → baru kirim AJAX (`$.ajax`, sesuai `CONVENTIONS.md` §6.2) ke endpoint sebenarnya.

Satu komponen/partial Blade + satu fungsi JS generik untuk modal ini (dipakai ulang di edit-peserta-lain, edit-peserta-sendiri, edit-institusi), teks peringatan berbeda sedikit sesuai konteks (poin 2 di atas) tapi mekanismenya identik.

**Log — tabel baru `log_peserta`** (dikonfirmasi developer, ditambahkan lewat `kppti_6.sql`; migrasi Laravel `2026_09_30_114430_create_log_peserta_table` sudah dibuat & dijalankan terhadap database):

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idlog_peserta` | bigint, PK, auto increment | |
| `done_at` | timestamp(6), nullable | `now()` |
| `done_by` | bigint, nullable, FK → `pengguna.idpengguna` | peserta yang melakukan perubahan |
| `aktifitas` | varchar(2000), nullable | teks aktivitas (lihat format di bawah) |
| `idpeserta` | bigint, nullable, FK → `peserta.idpeserta` | peserta yang datanya diubah |

**Catatan skema (sudah diperbaiki)**: `kppti_6.sql` (dump developer) tadinya mendefinisikan `log_peserta` dengan **dua foreign key yang salah** — keduanya menunjuk dari kolom `idpeserta` (satu ke `pengguna.idpengguna`, satu lagi ke `peserta.idpeserta`), sementara `done_by` sama sekali tidak punya FK (kemungkinan salah tempel saat membuat dump). **Sudah diperbaiki** (dikonfirmasi developer) lewat migrasi korektif `2026_09_30_114924_fix_log_peserta_foreign_keys`: FK salah pada `idpeserta`→`pengguna` di-drop, ditambah FK baru `done_by`→`pengguna.idpengguna`. Skema live sekarang sudah sesuai pola `log_institusi`: `done_by`→`pengguna`, `idpeserta`→`peserta`. Catatan lain: migrasi Laravel di proyek ini (`database/migrations/2025_01_01_*`) **belum pernah benar-benar dijalankan** terhadap database sebelumnya (skema dibuat langsung dari import SQL) — sudah disinkronkan (`migrations` table diisi manual untuk migrasi yang tabelnya sudah ada, tanpa mengubah skema apa pun), supaya `php artisan migrate` ke depannya bekerja normal.

**Format `aktifitas`** (dikonfirmasi developer — **beda dari `log_institusi`**: tidak perlu menyebut nilai lama, cukup nama field + nilai baru, karena kolom `varchar(2000)` dan yang penting cukup jejak "kolom apa yang berubah"): satu baris log per kolom yang berubah, format `"{Nama field} diubah menjadi '{nilai baru}'"`, contoh:
- `"Nama diubah menjadi 'BUDI SANTOSO'"`
- `"Email diubah menjadi 'budi@contoh.ac.id'"`
- `"Nomor WhatsApp diubah menjadi '081234567890'"`
- `"Jabatan diubah menjadi 'Dosen'"`
- Untuk reset password: `"Password direset"` (tanpa nilai baru, demi keamanan).

### 5.2 Generator password acak (tambah peserta baru & reset password)

**Dikonfirmasi developer** — fungsi baru (bukan `generateRandomToken()` yang sudah ada), harus lolos aturan `Password::min(8)->mixedCase()->numbers()->symbols()` dan menghindari karakter yang gampang tertukar secara visual:

- **Dikecualikan** (tidak pernah dipakai): huruf `l` kecil dan `I` kapital (mirip angka 1 dan mirip satu sama lain), angka `0` dan huruf `o`/`O` (mirip satu sama lain).
- Karakter spesial **hanya** dari set: `! @ # $ & ?`.
- Panjang: **8 karakter** (dikonfirmasi developer).
- Implementasi: fungsi baru di base `Controller.php` (sejenis `generateRandomToken()`, tapi khusus password) yang menyusun password dari gabungan pool karakter yang sudah difilter, memastikan minimal 1 huruf besar, 1 huruf kecil, 1 angka, 1 simbol (supaya selalu lolos `Password::mixedCase()->numbers()->symbols()`), sisanya diacak dari keseluruhan pool.

## 6. Peran & otorisasi

- Semua rute di `routes/peserta.php` dibungkus `akses:2` (role aktif = Peserta), sesuai pola `ARCHITECTURE.md` §4–§5.
- Peserta **hanya** boleh melihat/mengubah institusi & peserta lain dalam **`idinstitusi_asal` yang sama dengan dirinya** — dicek server-side di setiap query/aksi (bukan cuma disembunyikan di UI), sesuai `CONVENTIONS.md` §7.
- **Dikonfirmasi developer**: untuk saat ini **semua peserta dalam satu kontingen setara** — siapa saja boleh tambah/edit/reset password peserta lain dalam kontingen yang sama, tidak ada peran "penanggung jawab kontingen" yang punya hak lebih.

## 7. Validasi & error handling (ringkasan)

- Semua endpoint AJAX (tambah/edit/reset password/ubah institusi) memakai `jsonResponse()`, sesuai `CONVENTIONS.md` §4.
- Operasi yang menyentuh lebih dari satu tabel (mis. tambah peserta: `pengguna`+`role_pengguna`+`peserta`) wajib `DB::transaction`.
- Validasi kepemilikan (`idinstitusi_asal` sama) dan validasi `jenis_institusi_jabatan` (jabatan valid untuk jenis institusi) mengikuti pola F01.

## 8. Status keputusan

Semua poin yang sebelumnya terbuka **sudah diputuskan** developer — lihat ringkasan di tiap bagian (§4–§6). Dokumen ini siap dijadikan acuan implementasi.
