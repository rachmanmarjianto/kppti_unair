# ARCHITECTURE — KPPTI 2026

> Menjelaskan **bagaimana** sistem dibangun. Untuk tujuan produk lihat `PRD.md`, untuk gaya kode lihat `CONVENTIONS.md`.
> Bagian ini diturunkan dari kode yang sudah ada. Jika kode berbeda dengan dokumen ini, **kode yang benar**; beri tahu developer agar dokumen diperbarui.
> `[TBD]` = belum dikonfirmasi; jangan ditebak.

## 1. Stack

| Lapisan | Teknologi |
|---|---|
| Bahasa / framework | PHP 8.5, Laravel |
| Database | PostgreSQL (skema awal: `kppti_5.sql`) |
| Frontend | Blade, JavaScript, jQuery, Bootstrap **5.2.2** |
| Template UI | Template pihak ketiga; seluruh aset ada di folder `public/` |
| Auth | Bawaan Laravel (login email + password) |
| Integrasi | WA Gateway (OTP, kirim password), VA BNI `[TBD: belum dibuat]` |
| Format kode | Laravel Pint |
| Testing | PHPUnit |
| Tooling AI | Laravel Boost (MCP): `database-schema`, `database-query`, `search-docs` |

Jangan menambah atau mengubah dependensi (Composer/npm) tanpa persetujuan developer.

## 2. Struktur folder yang dipakai

```
app/Http/Controllers/     ← satu controller per role/area (contoh: AdminController)
app/Http/Middleware/      ← middleware `akses` (cek role aktif)
routes/
  web.php                 ← Auth::routes() bawaan, "/" (redirect ke login), GET /registrasi,
                             include_once admin.php, grup akses:All (logout, profile)
  admin.php               ← rute role Admin (idrole 1)
resources/views/
  layout/layout.blade.php ← layout induk template (dipakai lewat @extends('layout.layout'))
  blank_page.blade.php    ← TEMPLATE WAJIB untuk halaman baru (di dalam layout.layout)
  admin/                  ← view untuk role Admin (home, admin-users, ...)
public/                   ← aset template (CSS/JS/gambar)
```

Aturan: **jangan membuat folder dasar baru** tanpa persetujuan. Halaman untuk role lain mengikuti pola yang sama: `resources/views/{role}/`, controller `{Role}Controller`, file rute `routes/{role}.php`.

Folder/rute untuk Peserta, Nara Sumber, dan SC **belum dibuat** — proyek ini dikembangkan **per fitur** (lihat `CLAUDE.md`), jadi struktur untuk role tersebut baru dibuat saat fiturnya digarap, bukan disiapkan di muka. Saat ini hanya `routes/admin.php` dan `resources/views/admin/` yang ada; akun ber-role SC untuk saat ini dikelola **oleh Admin** lewat `admin-users` (daftar pengguna dengan role SC), bukan area kerja SC tersendiri.

## 3. Pola halaman (Blade)

Setiap halaman baru **wajib** dibuat dari `resources/views/blank_page.blade.php`:

```blade
@extends('layout.layout')

@section('title', '...')
@section('page-css') ... @endsection          {{-- CSS khusus halaman --}}
@section('breadcrumb') <li class="breadcrumb-item">...</li> @endsection
@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header"> ...<h4>Judul</h4>... </div>
            <div class="widget-content widget-content-area"> ... </div>
        </div>
    </div>
@endsection
@section('page-js') ... @endsection            {{-- JS khusus halaman --}}
```

- CSS/JS khusus halaman ditaruh di `page-css` / `page-js`, **bukan** inline di sembarang tempat.
- Controller mengirim `$menu` dan `$submenu` ke view untuk menandai menu sidebar aktif (contoh: `menu = 'users'`, `submenu = 'admin'`).
- Gunakan komponen dan kelas dari template yang sudah ada di `public/`; cek dulu sebelum menulis komponen baru.

## 4. Pola rute

- Satu file rute per role, dibungkus middleware `akses:{idrole}`:

```php
Route::middleware(['akses:1'])->group(function () {
    Route::get('/admin-users', [AdminController::class, 'adminusers'])->name('admin.admin-users');
    Route::post('/admin-users/update', [AdminController::class, 'updatePengguna'])->name('admin.admin-users.update');
});
```

- Nama rute: `{role}.{halaman}` atau `{role}.{halaman}.{aksi}`. Gunakan `route()` untuk membuat URL.
- URL memakai kebab-case Indonesia (`/admin-users/tambah-baru`).
- Halaman = `GET`, aksi mengubah data = `POST`. Data dinamis untuk modal/select diambil lewat `GET` yang mengembalikan JSON.

## 5. Role dan otorisasi

- Tabel: `role`, `role_pengguna` (`idpengguna`, `idrole`, `status`).
- Seorang pengguna **bisa punya banyak role, tetapi hanya satu yang aktif** (`status = true`). Mengaktifkan role menonaktifkan yang lain (lihat `activateSingleRole` di `AdminController`).
- Middleware `akses:{idrole}` sudah tersedia dan **dipakai untuk semua pembatasan akses**. Jangan menulis pengecekan role manual di controller.
- ID role: **1 = Admin, 2 = Peserta, 3 = Nara Sumber, 4 = SC**.
- ID role didefinisikan sebagai konstanta `private const ROLE_*` di controller yang memakainya. `[TBD: pertimbangkan dipindah ke satu tempat bersama, mis. Enum, bila dipakai lintas controller]`

## 6. Akses data

- Saat ini kode memakai **Query Builder** (`DB::table(...)`), **bukan Eloquent model**, kecuali jalur Auth (lihat catatan di bawah dan `CONVENTIONS.md` §2). Ikuti pola Query Builder untuk semua fitur baru; jangan membuat model baru tanpa persetujuan.
- **Pengecualian Auth:** `App\Models\Pengguna` (plus `Role`, `RolePengguna` sebagai relasi pendukungnya) adalah model Eloquent karena Auth bawaan Laravel mensyaratkannya (`config/auth.php`, provider `eloquent`). Dipakai **hanya** di `LoginController` (`$request->user()`, `->load('activeRoles')`). Jangan pakai ketiga model ini di controller/fitur lain — akses tabel `pengguna`/`role`/`role_pengguna` di luar jalur Auth tetap lewat `DB::table(...)`, seperti yang sudah dilakukan `AdminController`.
- Tabel dan kolom mengikuti skema `kppti_5.sql` (nama Indonesia, primary key berformat `id{nama_tabel}`, contoh `idpengguna`, `idinstitusi_asal`), bukan konvensi default Laravel (`id`).
- Operasi yang mengubah lebih dari satu tabel **wajib** dibungkus `DB::transaction`.
- Pencarian teks memakai `ilike` (PostgreSQL).
- Penghapusan pengguna adalah **soft delete manual** lewat kolom `is_deleted`; semua query pengguna harus menyaring `is_deleted = false`.
- Sebelum menulis migrasi atau query pada tabel, periksa struktur lewat tool Boost `database-schema`.
- Nilai status memakai angka dengan arti tercatat di komentar kolom (contoh `status_ajuan`: 1 draft, 2 pengajuan, 3 review, 4 revisi, 5 diterima, 6 ditolak). Lihat `kppti_5.sql`.

## 7. Pola controller dan respons

- Validasi dengan `$request->validate([...])` di dalam method.
- Aturan gaya (respons JSON, error handling, AJAX, notifikasi) ada di `CONVENTIONS.md`.
- Helper di base `App\Http\Controllers\Controller` (`protected`, **reuse, jangan tulis ulang**):
  - `jsonResponse(int $code, string $message, mixed $data = null): JsonResponse` → `{code, status, message, data}`.
  - `generateRandomToken(int $length = 6): string` → karakter `1-9a-z`.
  - `kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $hp)` → kirim WA 3 baris lewat H2H Unair. **Melempar `\RuntimeException`** bila gagal, jadi pemanggil wajib `try/catch`. Kredensial dari `config('services.h2h.user')` dan `config('services.h2h.key')`.

## 8. Integrasi eksternal

### WA Gateway
- Dipakai untuk OTP registrasi dan pengiriman kredensial/reset password lewat `kirim_wa_oca_token_3` (endpoint `h2h.unair.ac.id`). Kredensial ada di `config/services.php` (`services.h2h.*`) / `.env` — **jangan ditulis di kode atau dokumen**.
- Pemanggilan curl mengikuti spesifikasi dari admin gateway, termasuk opsi SSL (`CURLOPT_SSL_VERIFYPEER`/`VERIFYHOST` = false). **Jangan mengubah opsi tersebut atau "memperbaikinya"**; ini di luar kendali developer.
- Tabel `token` menyimpan OTP 6 karakter (`token`, `no_wa`, `created_at`, `used_at`, `used_by`).

### Library JavaScript
- Semua library disediakan template di `public/src`, `public/layouts`, dan `public/build`. Pakai yang sudah ada; **jangan menambah library baru** tanpa persetujuan.
- `resources/views/layout/layout.blade.php` **tidak** memuat jQuery/SweetAlert2/DataTables/select/dsb secara global — layout hanya memuat `bootstrap.bundle.min.js`, `perfect-scrollbar`, `mousetrap`, `waves`, dan `app.js` (toggle sidebar/tema). Setiap halaman memuat sendiri plugin yang ia perlukan lewat `@section('page-js')`/`@section('page-css')` (contoh: `admin-users.blade.php` memuat `vendors.min.js` untuk jQuery, DataTables, TomSelect, dan SweetAlert2).
- **Select2 tidak tersedia** di aset template (`public/`). Pengganti untuk kebutuhan select pencarian-AJAX adalah **TomSelect** (`public/src/plugins/src/tomSelect/`) — sudah dipakai di `admin-users.blade.php`, pakai ini untuk kebutuhan serupa di fitur lain.

### VA BNI `[TBD]`
- Belum diimplementasikan. Spesifikasi akan ditulis di `features/` (F04) setelah dokumentasi API dan kredensial sandbox tersedia.

## 9. Fitur yang sudah ada (referensi pola)

| Area | Lokasi | Catatan |
|---|---|---|
| Login | bawaan Laravel (`LoginController`), view `resources/views/login_kppti.blade.php` | berjalan; halaman **standalone**, tidak pakai `blank_page.blade.php`/`layout.layout` — desain khusus atas permintaan developer |
| Kelola pengguna Admin/SC | `AdminController` + `admin.admin-users` | contoh pola CRUD berbasis modal + AJAX (struktur controller/rute/modal) |
| Reset password via WA | `AdminController::resetPassword` | |
| Form registrasi peserta | `PenggunaController::registrasi()`, view `resources/views/registrasikppti.blade.php`, rute `GET /registrasi` (`registrasi_kppti`) | **Parsial**: hanya tampilan. Submit (`registrasi_kppti.store`) dan kirim OTP (`registrasi_kppti.kirim_otp`) belum dibuat — akan dikerjakan sebagai fitur berikutnya. Halaman ini juga **standalone** seperti login, sesuai permintaan developer. |

Saat membuat fitur baru, **jadikan struktur `AdminController` dan view `admin/admin-users` sebagai acuan pola** (controller, rute, modal, validasi, `jsonResponse`).

**Kecuali untuk AJAX/notifikasi**: `admin-users.blade.php` dibuat sebelum standar `$.ajax` (jQuery) + SweetAlert2 di `CONVENTIONS.md` §6.2–6.3 ditetapkan, jadi ia memakai `fetch()` bawaan browser dan alert Bootstrap kustom (`showPageAlert`/`showModalAlert`), bukan SweetAlert2. Kode ini **dibiarkan apa adanya** (tidak di-refactor); tetapi **fitur baru wajib mengikuti `CONVENTIONS.md`** (`$.ajax` + SweetAlert2), jangan mencontoh pola AJAX di `admin-users.blade.php`.

## 10. Catatan dan utang teknis yang diketahui

- Satu rute admin menunjuk ke method controller yang **tidak ada**, jadi akan error bila diakses:
  - `admin.nara-sumber` → `AdminController::narasumber` (dipakai link sidebar "Nara Sumber").

  Ini **dibiarkan apa adanya untuk saat ini** — metode pengembangan proyek ini per fitur dengan supervisi developer; rute ini akan ditangani (dibuat method-nya, atau dihapus) saat gilirannya sampai pada fitur Nara Sumber, bukan diperbaiki mendahului rencana. (Rute serupa untuk "Peserta", `admin.user-account-settings`, sudah diperbaiki oleh F16 — lihat `app/Http/Controllers/PesertaAdminController.php`.)
- Beberapa method belum memiliki return type (`index`, `searchPengguna`, dst) dan penamaan ada yang tidak camelCase (`adminusers`). Kode baru mengikuti `CONVENTIONS.md`; **jangan refactor kode lama tanpa diminta**.
- Kata sandi acak yang dikirim lewat WA berupa teks biasa (memang disengaja untuk alur ini); pastikan pengguna dapat mengganti kata sandi. `[TBD: fitur ganti password]`
