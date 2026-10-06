# CONVENTIONS — Laravel

> **Dokumen ini berlaku untuk proyek Laravel (PHP + Blade + jQuery + Bootstrap).**
> Ini adalah standar gaya kode pribadi developer yang dibawa ke berbagai proyek. Untuk bahasa atau framework lain akan ada berkas conventions tersendiri (mis. `CONVENTIONS-<nama>.md`).
> Hal yang khusus satu proyek (struktur folder, ID role, integrasi) **tidak** ditaruh di sini, melainkan di `ARCHITECTURE.md` proyek tersebut.
>
> **Prioritas aturan:** instruksi di dokumen ini menang atas panduan bawaan Laravel Boost (`CLAUDE.md`) bila bertentangan. Contoh: Boost menyarankan model dan factory, sedangkan di sini model Eloquent tidak dipakai.

## 1. Prinsip umum

- Ikuti kode yang sudah ada. Sebelum membuat berkas baru, lihat berkas sejenis di sekitarnya untuk struktur, pendekatan, dan penamaan.
- Cek dulu komponen/helper yang sudah ada sebelum menulis yang baru (helper di base `Controller`, komponen template di `public/`).
- Jangan menambah dependensi, folder dasar baru, atau model tanpa persetujuan developer.
- Jangan me-refactor kode lama di luar tugas yang diminta.
- Bila spesifikasi tidak jelas, **tanya**, jangan menebak.

## 2. Akses data: tanpa Eloquent (dengan pengecualian)

- **Default: jangan gunakan Eloquent.** Tidak ada model, relasi Eloquent, factory, atau `Model::query()` untuk logika aplikasi biasa.
- Gunakan **Query Builder** (`DB::table(...)`) atau `DB::select/statement` bila perlu.
- **Pengecualian yang disengaja:** Auth bawaan Laravel (`Auth::routes()`, `AuthenticatesUsers`, provider `eloquent` di `config/auth.php`) mensyaratkan model Eloquent. Untuk kasus ini, `App\Models\Pengguna` (dan relasi pendukungnya `Role`, `RolePengguna` yang dipakai `Pengguna::activeRoles()`) **boleh** tetap Eloquent. Pengecualian ini **hanya untuk jalur Auth** (login, `$request->user()`, `Auth::user()`) — jangan pakai Eloquent di controller/fitur lain di luar itu, dan jangan menambah relasi/model Eloquent baru tanpa alasan yang sama kuatnya (persetujuan developer).
- Untuk semua transaksi/operasi data lain (controller, fitur baru), **tetap gunakan Query Builder**, bukan Eloquent — walau tabelnya sama dengan yang dipakai model Auth di atas (mis. tabel `pengguna`, `role_pengguna` tetap diakses lewat `DB::table(...)` di luar jalur Auth).
- Operasi yang mengubah lebih dari satu tabel **wajib** dalam `DB::transaction`.
- Cek duplikasi/keberadaan data secara eksplisit sebelum insert/update dan kembalikan respons yang jelas (mis. 409), jangan mengandalkan galat database sebagai alur normal.
- Validasi selalu di **server** (`$request->validate`). Validasi JavaScript hanya untuk pengalaman pengguna, bukan pengaman.

## 3. PHP dan controller

Aturan dari Laravel Boost yang tetap berlaku:

- Selalu pakai kurung kurawal untuk struktur kontrol, walau satu baris.
- Constructor property promotion; jangan biarkan `__construct()` kosong.
- **Return type eksplisit** dan type hint pada semua parameter method.
- Enum: kunci TitleCase.
- Lebih baik PHPDoc daripada komentar inline; komentar inline hanya untuk logika yang benar-benar rumit. Gunakan array shape pada PHPDoc.
- Nama deskriptif (`isRegisteredForDiscounts`, bukan `discount`). Method controller camelCase.
- Setelah mengubah berkas PHP, jalankan `vendor/bin/pint --dirty --format agent`.
- Buat berkas lewat `php artisan make:...` dengan `--no-interaction`.
- Gunakan `route()` dan rute bernama untuk membuat URL.

Tambahan gaya developer:

- Validasi di dalam method controller memakai `$request->validate([...])`.
- Konstanta ID referensi (mis. role) didefinisikan sebagai `private const`, bukan angka mentah di dalam logika.
- Teks yang tampil ke pengguna memakai **Bahasa Indonesia**. Identifier dan PHPDoc mengikuti kode di sekitarnya.

## 4. Respons JSON (standar)

Semua endpoint AJAX **wajib** memakai `$this->jsonResponse(int $code, string $message, mixed $data = null)` dari base `Controller`. Jangan membuat `response()->json()` sendiri.

Bentuk respons:

```json
{ "code": 200, "status": "OK", "message": "…", "data": null }
```

Pemakaian kode HTTP:

| Kode | Arti |
|---|---|
| 200 | Berhasil |
| 404 | Data tidak ditemukan |
| 409 | Konflik/duplikat (mis. email sudah terdaftar) |
| 422 | Data tidak valid / prasyarat tidak terpenuhi |
| 500 | Kesalahan server tak terduga |

Pesan (`message`) harus jelas dan bisa langsung ditampilkan ke pengguna.

## 5. Penanganan error (wajib)

Tujuan: **tidak ada runtime error yang lolos tanpa penjelasan**.

- Bungkus operasi berisiko (transaksi database, panggilan HTTP/curl, upload berkas, integrasi eksternal) dengan `try/catch (\Throwable $e)`.
- Di `catch`: panggil `report($e)` (atau `Log::error(...)`) lalu kembalikan respons yang jelas. **Jangan** menelan exception diam-diam dan **jangan** membocorkan pesan exception mentah atau detail SQL ke pengguna.
- Bedakan hasil sebagian: bila data sudah tersimpan tetapi langkah lanjutan gagal (mis. WA gagal terkirim), pesan harus menyatakan keduanya ("berhasil disimpan, namun … gagal dikirim").
- Cek null sebelum memakai hasil query (`->first()`), kembalikan 404 yang jelas bila tidak ada.
- Di sisi JavaScript, setiap AJAX **wajib** punya penanganan error (lihat bagian 6).

## 6. Frontend: JavaScript dan Blade

Stack: Blade, jQuery, Bootstrap, SweetAlert2. Gunakan aset yang sudah ada di template (`public/`); jangan menambah library baru tanpa persetujuan.

### 6.1 Tombol submit
Saat diklik, tombol submit **harus**:
1. menjadi `disabled`, dan
2. teksnya berganti menjadi **loader** (spinner + teks "Memproses…").

Setelah selesai (berhasil atau gagal) tombol **dikembalikan** ke keadaan semula, kecuali halaman akan berpindah/reload. Ini mencegah klik ganda.

### 6.2 AJAX
Gunakan `$.ajax` dari jQuery, dan **lengkapi sampai penanganan error**:

```js
$('#form-contoh').on('submit', function (e) {
    e.preventDefault();

    const $btn = $(this).find('[type="submit"]');
    const teksAwal = $btn.html();
    $btn.prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    })
    .done(function (res) {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
    })
    .fail(function (xhr) {
        // 422 dari validasi Laravel: tampilkan pesan per field bila ada
        const res = xhr.responseJSON || {};
        let pesan = res.message || 'Terjadi kesalahan pada server. Silakan coba lagi.';
        if (xhr.status === 0) {
            pesan = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
        } else if (res.errors) {
            pesan = Object.values(res.errors).flat().join('\n');
        }
        Swal.fire({ icon: 'error', title: 'Gagal', text: pesan });
    })
    .always(function () {
        $btn.prop('disabled', false).html(teksAwal);
    });
});
```

Wajib: `.fail()` yang menangani (a) tidak ada koneksi (`status 0`), (b) galat validasi (`errors`), (c) pesan dari `jsonResponse`, dan (d) pesan cadangan generik.

### 6.3 Notifikasi dan konfirmasi
- **SweetAlert2** adalah standar untuk notifikasi hasil aksi (berhasil/gagal) pada aksi AJAX dan untuk **konfirmasi/verifikasi aksi** sebelum tindakan penting (hapus, reset, kirim, dst).
- Setiap aksi harus berujung pada notifikasi, baik berhasil maupun gagal. Tidak boleh ada aksi yang selesai tanpa umpan balik.

### 6.4 Flash message (submit form biasa / redirect)
**Aturan pemilihan:** submit form biasa (non-AJAX, halaman redirect) memakai **flash alert**; aksi via JavaScript/AJAX memakai **SweetAlert2**. Pengecualian (SweetAlert2 pada submit form) hanya bila developer memintanya secara eksplisit pada fitur tertentu.

Layout sudah menyediakan komponen alert; **controller hanya mengisi flash message** yang sesuai. Flash `status` berisi **dua indeks**: `status` (`success` atau `danger`, sesuai kelas Bootstrap `alert-*`) dan `message`.

Komponen di layout (jangan diduplikasi di halaman):

```blade
<div class="alert alert-{{ session('status')['status'] }} solid alert-dismissible fade show">
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
    {{ session('status')['message'] }}
</div>
```

Cara mengisi di controller:

```php
return redirect()->route('...')->with('status', [
    'status' => 'success',   // atau 'danger'
    'message' => 'Data berhasil disimpan.',
]);
```

### 6.5 Interaksi dengan pengguna
Umpan balik langsung ke pengguna itu penting, bukan hanya setelah submit:

- Validasi **saat mengetik/berpindah field** untuk hal yang bisa dicek di klien. Contoh: field "email" dan "konfirmasi email" harus menampilkan **secara langsung** apakah keduanya sama atau berbeda.
- Tampilkan pesan yang spesifik di dekat field yang bermasalah (mis. `is-invalid` / `invalid-feedback` Bootstrap), bukan hanya pesan umum.
- Berikan indikator saat menunggu proses (loader, tombol disabled).
- Bila form dinamis (field berubah menurut pilihan), field yang disembunyikan tidak boleh ikut divalidasi/dikirim tanpa sengaja, dan server tetap memvalidasi sesuai pilihan.

### 6.6 Ukuran tombol
Visibilitas lebih penting daripada menghemat ruang. **Hindari `btn-sm`** (atau ukuran kecil lain) kecuali ada urgensi nyata (mis. tombol ikon berulang di tiap baris tabel yang padat). Default-nya tombol berukuran normal, termasuk tombol aksi di samping input tunggal (bukan hanya tombol submit form penuh).

## 7. Keamanan dasar

- CSRF: semua `POST` (termasuk AJAX) menyertakan token.
- Otorisasi lewat middleware rute; jangan bergantung pada menyembunyikan tombol di UI.
- Jangan menulis kredensial/kunci API di kode atau dokumen; pakai `config()`/`.env`.
- Kata sandi selalu di-hash (`Hash::make`).
- Jangan log data sensitif (kata sandi, token OTP) dan jangan tampilkan pesan exception mentah ke pengguna.
- **Berkas upload/download tidak boleh diakses langsung lewat URL publik** (tidak disimpan di `public/` atau folder lain yang bisa diakses langsung browser). Simpan lewat disk Laravel yang tidak publik (default `storage/app/`, bukan `storage/app/public/`), dan selalu sajikan lewat **controller** yang mengecek otorisasi dulu, pakai fungsi-fungsi `Storage` (`Storage::get()`, `Storage::download()`, `Storage::response()`, dsb.) — bukan link statis ke file.
- **URL `GET` yang membawa nilai (parameter rute atau query string) harus dienkripsi AES-256**, bukan dikirim mentah (mis. `?id=123` atau `/detail/123`). Pakai `Crypt::encryptString()`/`Crypt::decryptString()` bawaan Laravel (AES-256-CBC) saat membuat dan membaca nilainya di controller.

## 8. Testing

- PHPUnit; buat lewat `php artisan make:test --phpunit {Nama}`. Utamakan feature test.
- Jalankan tes sesempit mungkin: `php artisan test --compact --filter=...`.
- Karena Eloquent tidak dipakai, siapkan data uji dengan `DB::table(...)->insert(...)` (atau seeder), bukan factory model.

## 9. Catatan yang akan ditambah

Daftar ini sengaja dibiarkan tumbuh. Tambahkan aturan baru di sini setiap kali ditemukan AI mengulang kesalahan yang sama.
