# F16 — Manajemen Peserta oleh Admin & Dashboard Peserta

> Melengkapi F16 di `PRD.md` ("Manajemen peserta oleh admin (lihat semua data peserta, dikelompokkan per institusi asal) dan dashboard ringkasan peserta").
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide tambahan AI, menunggu konfirmasi.
> Status: **spesifikasi lengkap** (semua pertanyaan terbuka sudah dijawab) — menunggu kata "mulai" dari developer sebelum coding dimulai.

## 1. Tujuan

Admin bisa **melihat seluruh data peserta** yang sudah terdaftar (lintas institusi, bukan cuma miliknya sendiri seperti di area Peserta/F03), **dikelompokkan per jenis institusi lalu per institusi asal (kontingen)**, bisa **membantu peserta reset password** dan **mencetak kartu registrasi kontingen**, plus **dashboard ringkasan** terkait peserta.

## 2. Temuan penting: slot menu & rute ini sudah ada, tapi rusak

`resources/views/layout/menu_admin.blade.php` sudah lama punya menu "Peserta" di bawah "Users", menunjuk ke `route('admin.user-account-settings')` — tapi rute itu di `routes/admin.php` menunjuk ke method `AdminController::useraccountsettings` yang **tidak ada** (sudah dicatat sejak awal proyek di `ARCHITECTURE.md` §10 sebagai utang teknis, sengaja dibiarkan sampai gilirannya digarap). **F16 inilah gilirannya.**

**Dikonfirmasi developer**: rute baru **digabung di `routes/admin.php`** bersama rute admin lain (bukan file rute terpisah) — konsisten dengan pola `AcaraController` yang juga didaftarkan di file yang sama walau controllernya beda. Nama rute diganti jadi `admin.peserta.*` (lebih jelas daripada nama lama `user-account-settings`); link menu di `menu_admin.blade.php` disesuaikan mengikuti nama baru ini, sekaligus menghapus baris utang teknis terkait di `ARCHITECTURE.md` §10.

## 3. Dashboard ringkasan peserta

**Dikonfirmasi developer** — kartu-kartu ringkasan di bagian atas halaman:

1. Total peserta terdaftar (seluruh event).
2. Total institusi/kontingen terdaftar.
3. Jumlah peserta **per jenis institusi**.
4. Jumlah institusi **per jenis institusi**.
5. Jumlah peserta yang **mengikuti city tour** (`peserta.city_tour = true`).
6. Jumlah/persentase peserta yang **data lengkap** vs **belum lengkap** (pakai logika yang sama dengan `PesertaController::isLogistikLengkap()`/`fotoLengkap`, lihat §6).
7. Jumlah kontingen yang **semua anggotanya sudah lengkap** (siap unduh kartu registrasi) vs yang belum.

## 4. Daftar peserta: dikelompokkan per jenis institusi, lalu per institusi asal

**Dikonfirmasi developer**: pengelompokan dua tingkat —

1. **Tingkat 1 — Jenis Institusi** (Perguruan Tinggi, LLDikti, Asosiasi, Lembaga Akreditasi, Pemerhati Pendidikan, Lainnya): tiap jenis jadi grup/seksi sendiri (mis. tab atau accordion tingkat atas), menampilkan jumlah institusi dan jumlah peserta di jenis itu.
2. **Tingkat 2 — Institusi asal (kontingen)** di dalam tiap jenis: nama institusi, **kode kontingen** (ditampilkan ke admin — beda dari sisi Peserta yang sengaja disembunyikan), jumlah peserta, badge status kelengkapan kontingen ("Semua Lengkap" / "Ada yang Belum Lengkap").
3. **Tingkat 3 — Peserta** di dalam tiap institusi (expand): nama, email, no. WA, jabatan, badge status data (logistik+foto, hijau/merah seperti di F03), tombol **Reset Password** dan tombol **Cetak Kartu Registrasi Kontingen** (lihat §5).

Pencarian/filter: **ditunda** — dikonfirmasi developer "nanti saja, ketika data sudah banyak". Tidak dikerjakan di versi awal ini.

## 5. Aksi: reset password & cetak kartu registrasi kontingen

**Dikonfirmasi developer**: F16 **bukan** murni read-only — ada 2 aksi:

1. **Reset password peserta** (tombol per baris peserta) — reuse logika & pola persis `PesertaController::resetPasswordPeserta()` (generate password baru lewat `generateRandomPassword()`, kirim WA berisi email+password baru, SweetAlert2 konfirmasi "Password akan dikirim ke no WA ..." sebelum eksekusi, sama seperti pola admin/peserta yang sudah ada). **Wajib dicatat ke `log_peserta`** (`"Password direset"`, `done_by` = admin yang melakukan) — sama seperti yang sudah berjalan di F03, cuma pemicunya sekarang bisa dari Admin, bukan cuma sesama peserta.
2. **Cetak/unduh kartu registrasi kontingen** (tombol per institusi, bukan per peserta) — reuse logika `PesertaController::kartuKontingen()` (generate PDF A5 + QR code) **apa adanya, termasuk gerbang kelengkapan datanya**. **Dikonfirmasi developer**: "tetap dengan ketentuan seperti peserta" — kartu baru bisa dicetak kalau **semua peserta di institusi itu sudah lengkap datanya** (logistik + foto), persis aturan yang sama di sisi Peserta (§2.2, `011-logistik-dan-kartu-kontingen.md`). Kalau belum lengkap, tampilkan pesan yang sama ("Untuk mengunduh kartu registrasi, harap lengkapi semua data peserta. Belum lengkap: ...") — bukan dikecualikan untuk Admin.

Tidak ada aksi edit data peserta (nama/email/no_wa/jabatan/logistik/foto) dari F16 — itu tetap domain F03/F11 (peserta/sesama kontingen).

## 6. Implementasi (gambaran teknis)

- Controller baru: `app/Http/Controllers/PesertaAdminController.php`, method `index()` (halaman + dashboard), `resetPassword(Request $request)`, `cetakKartu(Request $request)` — middleware `akses:1`, didaftarkan di `routes/admin.php`.
- Query daftar peserta: mirip `PesertaController::pesertaSekontingenQuery()`/`pesertaDenganStatusLengkap()` tapi **lintas semua institusi** (tanpa filter `idinstitusi_asal`), dikelompokkan di PHP per `idjenis_institusi` lalu per `idinstitusi_asal`.
- **Konsolidasi logika kelengkapan data**: `isLogistikLengkap()`/`idJenisTransportKendaraanPribadi()`/perhitungan `fotoLengkap` saat ini ada di `PesertaController` (private). **Dipindah jadi method protected di base `Controller.php`** supaya dipakai ulang oleh `PesertaController` (scoped institusi sendiri) dan `PesertaAdminController` (lintas institusi) tanpa duplikasi — method lama di `PesertaController` tetap ada sebagai pemanggil (delegasi), perilaku tidak berubah.
- Reset password: method baru di `PesertaAdminController`, logikanya menduplikasi pola `PesertaController::resetPasswordPeserta()` tapi scoped lintas-institusi (tanpa cek `idinstitusi_asal` milik admin, karena admin bukan bagian dari kontingen mana pun) — `done_by` di `log_peserta` diisi `idpengguna` admin yang login.
- Cetak kartu: method baru, logikanya menduplikasi `PesertaController::kartuKontingen()` **apa adanya termasuk gerbang kelengkapannya**, cuma scoped ke `idinstitusi_asal` yang dipilih admin dari daftar (bukan dari sesi peserta).
- View baru: `resources/views/admin/peserta.blade.php`.
- Rute (`routes/admin.php`, grup `akses:1` yang sudah ada):
  ```php
  Route::get('/admin-peserta', [PesertaAdminController::class, 'index'])->name('admin.peserta');
  Route::post('/admin-peserta/reset-password', [PesertaAdminController::class, 'resetPassword'])->name('admin.peserta.reset-password');
  Route::get('/admin-peserta/cetak-kartu', [PesertaAdminController::class, 'cetakKartu'])->name('admin.peserta.cetak-kartu');
  ```
  (`idinstitusi_asal` untuk cetak kartu dikirim lewat `token` terenkripsi di query string, sesuai `CONVENTIONS.md` §7 — pola sama seperti `encryptRouteValue()`/`decryptRouteValue()` yang sudah ada.)
- Rute lama `admin.user-account-settings` → `AdminController::useraccountsettings` **dihapus** dari `routes/admin.php`, link di `menu_admin.blade.php` diarahkan ke `admin.peserta`, catatan utang teknis terkait di `ARCHITECTURE.md` §10 dibersihkan.

## 7. Status keputusan

Semua poin yang sebelumnya terbuka **sudah diputuskan** developer:

- **Aksi** (§5): bukan read-only — ada reset password (dicatat ke `log_peserta`) dan cetak kartu registrasi kontingen.
- **Dashboard** (§3): 7 metrik di atas, termasuk tambahan "ikut city tour", "peserta per jenis institusi", "institusi per jenis institusi".
- **Rute** (§2): digabung ke `routes/admin.php`, nama baru `admin.peserta.*`.
- **Pencarian/filter** (§4): ditunda sampai data banyak.
- **Pengelompokan** (§4): 2 tingkat — per jenis institusi, lalu per institusi asal.
- **Gerbang cetak kartu** (§5): sama persis seperti sisi Peserta — ditolak kalau ada anggota kontingen yang belum lengkap datanya, tidak ada pengecualian untuk Admin.

Dokumen ini siap dijadikan acuan implementasi.
