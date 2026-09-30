# F01 — Registrasi Peserta

> Melengkapi F01 (dan sebagian F02) di `PRD.md`. Untuk pola controller/rute lihat `ARCHITECTURE.md`, untuk gaya kode lihat `CONVENTIONS.md`.
> `[TBD]` = belum diputuskan developer; jangan ditebak, jangan dikerjakan dulu bagian itu.
> Status: **spesifikasi lengkap** (semua pertanyaan terbuka sudah dijawab, lihat §11) — menunggu kata "mulai" dari developer sebelum coding dimulai.

## 1. Tujuan

Melengkapi `resources/views/registrasikppti.blade.php` (saat ini hanya tampilan statis, form belum tersambung ke apa pun) menjadi alur registrasi peserta yang utuh: buat akun `pengguna`, verifikasi nomor WA lewat OTP, buat/pilih `institusi_asal`, dan buat baris `peserta` (termasuk jabatan).

## 2. Cakupan (in scope)

- Form registrasi dinamis: field institusi dan **Jabatan** berubah menurut **Jenis Institusi** yang dipilih (lihat §5–§6).
- Verifikasi nomor WA lewat OTP 6 digit, dengan **cek langsung (AJAX) saat mengetik** untuk mengaktifkan tombol submit (lihat §8 — ini bukan reuse polos dari `cekOtp()` yang sudah ada, ada aturan tambahan: hanya OTP *terakhir* yang berlaku, dan berlaku cuma 1 menit).
- **Satu institusi = satu kontingen**: peserta dari institusi yang sama (dipilih ulang lewat referensi `universitas`, atau lewat saran nama institusi yang sudah pernah didaftarkan) memakai baris `institusi_asal` yang **sama** — bukan bikin baris baru tiap kali ada peserta baru dari institusi itu. Lihat §7.
- Saat submit berhasil, dalam satu `DB::transaction`:
  - Insert `pengguna` (password di-hash).
  - Insert `role_pengguna` (`idrole = 2` Peserta, `status = true`).
  - Cari `institusi_asal` yang sudah ada dan cocok (lihat §7); kalau ada → pakai ulang (reuse id + kode kontingen), kalau tidak ada → insert baris baru dengan `kode_kontingen` baru.
  - Insert `peserta` (`idjabatan`; kolom logistik dulu null — diisi di fitur lain).
- Setelah insert berhasil (di luar transaksi, sama seperti pola `AdminController::tambahPenggunaBaru`): kirim WA berisi email + password lewat `kirim_wa_oca_token_3` — dipakai peserta untuk login nanti.
- Validasi penuh di server (bukan hanya JavaScript), termasuk cek OTP dan duplikat email/no_wa.
- Setelah sukses: redirect ke halaman login dengan flash message sukses (bukan auto-login), sesuai `CONVENTIONS.md` §6.4 (submit form biasa → flash alert).

## 3. Di luar cakupan (out of scope)

- Field logistik peserta (transportasi, hotel, city tour) — F11, menyusul.
- Tagihan / VA BNI — F04, menyusul.
- UI kelola master data institusi & kode kontingen oleh Admin — F03, menyusul. Fitur ini hanya **membuat** `institusi_asal` baru saat registrasi, belum ada halaman kelola.
- Pengajuan sebagai Nara Sumber — alur terpisah (lihat `PRD.md` §3).

## 4. Field form

**Sudah ada (dipertahankan):** Nama Lengkap, Email, Ulangi Email, Password, Ulangi Password, Nomor WhatsApp + tombol "Kirim OTP", Kode OTP, Jenis Institusi Asal (select, sudah ada tapi belum memicu apa pun).

**Ditambahkan** (berubah menurut Jenis Institusi — lihat §5):

| Field | Muncul untuk jenis | Tipe |
|---|---|---|
| PTN / PTS | Perguruan Tinggi | select/radio, nilai `1=PTN`, `2=PTS` |
| Nama Perguruan Tinggi | Perguruan Tinggi | TomSelect, cari-AJAX ke tabel `universitas` |
| Wilayah LLDikti | LLDikti | select, dari tabel `lldikti` |
| Nama Institusi | LLDikti, Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya | TomSelect dengan opsi "buat baru" (`create: true`), cari-AJAX ke `institusi_asal.nama_institusi` yang sudah ada (lihat §7) |
| Jabatan | semua jenis | select, opsi dari `jenis_institusi_jabatan` → `kelompok_jabatan` → `jabatan` |

## 5. Field dinamis per jenis institusi (dikonfirmasi developer)

- **Jenis = "Perguruan Tinggi"** (`idjenis_institusi = 1`):
  1. Pilih **PTN (1) / PTS (2)** → `institusi_asal.ptn_pts`.
  2. Pilih **Nama Perguruan Tinggi** lewat TomSelect, cari-AJAX ke tabel `universitas` (6.037 baris, sudah terisi; endpoint mengikuti pola `AdminController::searchPengguna`).
  3. Pilih **Jabatan** (§6).

  Catatan teknis: tabel `universitas` **tidak** punya kolom PTN/PTS, jadi pilihan PTN/PTS di langkah 1 murni self-declared oleh peserta — tidak memfilter daftar TomSelect di langkah 2 (datanya tidak mendukung itu).

- **Jenis = "LLDikti"** (`idjenis_institusi = 4`):
  1. Pilih **Wilayah LLDikti** dari tabel `lldikti` (17 wilayah, format Romawi I–XVII) → `institusi_asal.idlldikti`.
  2. Isi **Nama Institusi** — TomSelect dengan opsi "buat baru" (bukan input teks polos): saat mengetik, tampilkan saran dari `institusi_asal.nama_institusi` yang sudah ada (di-scope ke `idjenis_institusi=4` dan `idlldikti` yang sama). Kalau peserta pilih salah satu saran → dipakai ulang. Kalau mengetik nama baru (tidak ada yang cocok) → nanti dibuat baris baru saat submit.
  3. Pilih **Jabatan** (§6) — mekanisme sama seperti Perguruan Tinggi.

- **Jenis lain** (Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya): logika **sama seperti LLDikti** langkah 2–3 (TomSelect nama institusi dengan saran + create, lalu Jabatan) — bedanya tidak ada field Wilayah LLDikti, dan pencarian saran di-scope ke `idjenis_institusi` masing-masing (tanpa `idlldikti`).

**Prinsip umum** (berlaku semua jenis): **satu institusi = satu baris `institusi_asal`**, dipakai bersama oleh semua peserta dari institusi itu supaya mereka masuk kontingen yang sama. Untuk Perguruan Tinggi, pencocokan otomatis di server lewat `idref_institusi` (tidak perlu UI saran karena TomSelect sudah memilih ID unik dari tabel referensi). Untuk jenis lain, pencocokan dibantu UI saran di atas, **plus** validasi ulang di server (cek `nama_institusi` mirip persis, case-insensitive) untuk jaga-jaga peserta mengetik nama baru yang sebenarnya sama dengan yang sudah ada tapi tidak memilih saran. Detail lengkap di §7.

## 6. Field dinamis "Jabatan" per jenis institusi

Data referensi sudah ada di database (tidak perlu dibuat baru):

| Jenis Institusi | Kelompok Jabatan | Pilihan Jabatan |
|---|---|---|
| Perguruan Tinggi | Perguruan Tinggi | Rektor, Wakil Rektor, Dosen, Mahasiswa, Tenaga Kependidikan |
| Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya | (kelompok umum) | Direktur, Wakil Direktur, Staff |
| LLDikti | LLDikti | Ketua, Wakil Ketua, Staff |

Alur: pilih Jenis Institusi → isi ulang `<select>` Jabatan sesuai `jenis_institusi_jabatan` (data kecil dan statis, bisa di-preload sebagai JSON di halaman, tidak perlu AJAX terpisah) `[konfirmasi: preload vs AJAX — usulan preload karena datanya kecil dan jarang berubah]`.

## 7. Institusi bersama ("satu kontingen") dan kode kontingen

**Dikonfirmasi developer**: peserta mendaftar mandiri (self-service), tapi peserta dari institusi yang sama harus otomatis terkelompok ke kontingen (`institusi_asal`) yang sama — bukan satu baris `institusi_asal` per peserta.

### 7.1 Cara mencocokkan institusi yang sudah ada

| Jenis Institusi | Kunci pencocokan | Mekanisme |
|---|---|---|
| Perguruan Tinggi | `idjenis_institusi=1 AND idref_institusi=<iduniversitas terpilih>` | Otomatis di server saat submit (tidak perlu UI saran — TomSelect sudah memilih ID unik dari `universitas`) |
| LLDikti | `idjenis_institusi=4 AND idlldikti=<terpilih> AND nama_institusi` cocok | UI saran (TomSelect create-or-search ke `institusi_asal`) + validasi ulang di server |
| Lainnya (Lembaga Akreditasi, Asosiasi, Pemerhati Pendidikan, Lainnya) | `idjenis_institusi=<terpilih> AND nama_institusi` cocok | UI saran (TomSelect create-or-search ke `institusi_asal`) + validasi ulang di server |

Alur saat submit (di dalam `DB::transaction`, sebelum insert `pengguna` supaya bisa rollback bersih kalau gagal):
1. Cari `institusi_asal` yang cocok sesuai tabel di atas.
2. Kalau **ketemu** → pakai `idinstitusi_asal` itu (reuse `kode_kontingen` yang sudah ada, tidak generate baru).
3. Kalau **tidak ketemu** → insert baris `institusi_asal` baru + generate `kode_kontingen` baru (§7.2).

**Keputusan** (diserahkan developer ke AI): pencocokan nama institusi (LLDikti & jenis lain) dilakukan `trim()` lalu `ilike` **exact match** (case-insensitive, tanpa spasi di awal/akhir) terhadap `nama_institusi` yang sudah ada, di-scope ke `idjenis_institusi` yang sama (dan `idlldikti` yang sama untuk jenis LLDikti). Tidak pakai fuzzy-matching (mis. Levenshtein/similarity) — kalau peserta mengetik nama yang mirip tapi beda persis (mis. "Universitas Airlangga" vs "UNAIR"), keduanya dianggap institusi berbeda kecuali peserta memang memilih saran yang sama dari TomSelect. Ini sudah cukup karena UI saran (autocomplete) yang menuntun peserta memilih entri yang sudah ada adalah lini pertahanan utama; validasi server hanya jaring pengaman kalau peserta mengetik ulang persis nama yang sama tanpa klik saran.

### 7.2 Generate kode kontingen (hanya saat institusi_asal baris baru)

Format `XXZZZ` (`kppti_5.sql`, komentar kolom `institusi_asal.kode_kontingen`): `XX` = tanggal 2 digit, `ZZZ` = urutan pada hari itu.

**Dikonfirmasi developer**: pakai tanggal registrasi + urutan global per hari.

- `XX` = tanggal **hari ini** (tanggal saat baris `institusi_asal` baru dibuat, bukan tanggal event), di-pad 2 digit (`str_pad($tanggal, 2, '0', STR_PAD_LEFT)`, mis. tanggal 5 → `"05"`).
- `ZZZ` = urutan **global** per hari, dihitung dari jumlah `institusi_asal` yang **baru dibuat** hari itu: `count(institusi_asal WHERE date(created_at) = today) + 1`, di-pad **3 digit** (`str_pad($urutan, 3, '0', STR_PAD_LEFT)`, mis. urutan ke-7 → `"007"`).
- Total **harus tepat 5 karakter** (`XX` 2 digit + `ZZZ` 3 digit) karena kolom `institusi_asal.kode_kontingen` adalah `varchar(5)` — kalau urutan tembus 4 digit (>999 institusi baru dalam satu hari) kode akan terpotong/invalid; secara realistis jumlah institusi (bukan peserta) yang mendaftar per hari sangat kecil dibanding jumlah peserta, jadi risiko ini diterima untuk event ini, tidak perlu penanganan khusus.
- **Catatan keterbatasan** (bukan bug, tapi perlu disadari): karena `XX` hanya tanggal (tanpa bulan), kode kontingen bisa "tabrakan" kalau periode registrasi mencakup **tanggal yang sama di bulan berbeda** (mis. institusi baru pertama tanggal 5 Oktober dan tanggal 5 November sama-sama dapat `XX="05"`, `ZZZ="001"` → kode identik `"05001"`). Ini mengikuti format yang sudah ditentukan di `kppti_5.sql` apa adanya (bukan sesuatu yang kita ubah), risikonya kecil karena periode pendaftaran KPPTI 2026 menurut `PRD.md` hanya beberapa minggu (buka sekitar Oktober, event November).
- Karena ini dibaca-lalu-tulis (race condition mungkin kalau 2 peserta dari institusi berbeda submit bersamaan di detik yang sama), generate `kode_kontingen` dilakukan **di dalam** `DB::transaction` yang sama dengan insert `institusi_asal`-nya.

## 8. Alur OTP

Dikonfirmasi developer — **beda** dari `PenggunaController::cekOtp()` yang sudah ada (yang itu cuma cek "ada baris cocok", tanpa peduli baris mana atau kedaluwarsa):

1. Peserta isi Nomor WhatsApp → klik "Kirim OTP" → reuse `PenggunaController::kirimOtp()` (insert baris baru ke `token`, kirim WA). Sama seperti sekarang.
2. Saat peserta mengetik Kode OTP (6 karakter), **cek AJAX otomatis** (live, seperti pola modal Admin `admin-users.blade.php`) — tapi dengan aturan baru:
   - Ambil baris `token` **terakhir** untuk `no_wa` itu (`ORDER BY created_at DESC LIMIT 1`) — bukan sembarang baris yang kebetulan cocok.
   - Cocokkan `token` yang diinput dengan baris itu.
   - Cek baris itu **belum kedaluwarsa**: `created_at` tidak lebih dari **1 menit** yang lalu (`now()->diffInSeconds($token->created_at) <= 60`).
   - Kalau kode OTP lama (bukan yang terakhir) diinput meski dulu valid → tetap **gagal** (karena bukan baris terakhir).
   - **Dikonfirmasi developer**: `cekOtp()` dijadikan **generik di base `Controller.php`**, dipakai ulang oleh kedua alur (Admin & registrasi peserta), bukan endpoint terpisah:

```php
// Controller.php
protected function isOtpValid(string $no_wa, string $otp, ?int $maxAgeSeconds = null): bool
{
    $latestToken = DB::table('token')
        ->where('no_wa', $no_wa)
        ->orderByDesc('created_at')
        ->first();

    if (! $latestToken || $latestToken->token !== $otp) {
        return false; // termasuk kasus: $otp cocok tapi bukan baris TERAKHIR
    }

    if ($maxAgeSeconds !== null && now()->diffInSeconds($latestToken->created_at) > $maxAgeSeconds) {
        return false;
    }

    return true;
}
```

- `PenggunaController::cekOtp()` (dipakai modal Admin, sudah ada) → panggil `$this->isOtpValid($no_wa, $otp)` (tanpa batas waktu — perilaku existing untuk Admin tidak berubah, kecuali sekarang **juga** mensyaratkan token itu adalah yang terakhir untuk nomor tersebut, bukan cuma "ada yang cocok").
- Endpoint cek-otp registrasi peserta (baru) → panggil `$this->isOtpValid($no_wa, $otp, 60)` (batas 1 menit).

Endpoint AJAX-nya sendiri tetap dua rute terpisah (beda controller/beda halaman/beda autentikasi), yang berbeda hanya nilai `$maxAgeSeconds` saat memanggil helper generik ini.
3. Tombol submit ("Daftar") aktif hanya kalau **semua** kondisi berikut terpenuhi (semua field required, dicek live seperti pola yang sudah ada di halaman ini):
   - Kode OTP benar (hasil cek AJAX langkah 2).
   - Email & Ulangi Email sama.
   - Kata Sandi & Ulangi Kata Sandi sama.
4. Saat submit form, server **validasi ulang** OTP (jangan percaya status tombol di client) dengan aturan yang sama di langkah 2, lalu tandai baris `token` itu `used_at`/`used_by` setelah pengguna berhasil dibuat (pola sama seperti `AdminController::tambahPenggunaBaru`).

Rute publik baru (di luar middleware `akses`) di `routes/web.php`:
- `POST /registrasi/kirim-otp` (nama `registrasi_kppti.kirim_otp`, sudah dirujuk blade lewat `Route::has()` tapi belum didaftarkan).
- `POST /registrasi/cek-otp` (nama `registrasi_kppti.cek_otp`) — endpoint baru untuk langkah 2 di atas.

**Dikonfirmasi developer**: notifikasi tombol "Kirim OTP" (kirim WA) **tidak** pakai SweetAlert2 — cukup teks status di bawah field Nomor WhatsApp ("Mengirim OTP...", "Kode OTP telah dikirim.", "Gagal mengirim OTP.", dst), sama seperti yang sudah berjalan di halaman ini sekarang. Transport AJAX-nya **wajib `$.ajax` jQuery** (bukan `fetch()`), sesuai `CONVENTIONS.md` §6.2, termasuk penanganan error lengkap (`.fail()` untuk status 0/koneksi putus, `errors` validasi, `message` dari `jsonResponse`, dan fallback generik) — halaman ini perlu memuat jQuery (`vendors.min.js`) yang saat ini belum dimuat sama sekali di `registrasikppti.blade.php`. Yang jadi pengecualian dari standar hanyalah **notifikasinya** (hint inline, bukan SweetAlert2), bukan cara memanggil AJAX-nya. Cek OTP live (langkah 2) juga pakai `$.ajax` dengan pola yang sama, hint tetap inline.

## 9. Validasi server (ringkasan)

- `nama` — required, string.
- `email` — required, format email, **unique** di `pengguna` (belum terdaftar/soft-deleted).
- `email_confirmation` — `confirmed`.
- `password` — required, `confirmed`, `Password::min(8)->mixedCase()->numbers()->symbols()` — **disamakan dengan aturan ganti password Admin** (`PenggunaController::updatePassword`). JS di halaman ini perlu diperbarui juga (saat ini cuma cek panjang ≥8) supaya validasi client-side konsisten dengan aturan server — ikuti pola cek kekuatan password di `profile.blade.php`.
- `nomor_wa` — required, format nomor Indonesia, **unique** di `pengguna`.
- `jenis_institusi` — required, `exists:jenis_institusi,idjenis_institusi`.
- Field institusi dinamis (§5), semua divalidasi ulang di server sesuai `jenis_institusi` yang dikirim (jangan percaya field mana yang ditampilkan di client):
  - Perguruan Tinggi → `ptn_pts` required (`in:1,2`), `iduniversitas` required & `exists:universitas,iduniversitas`.
  - LLDikti → `idlldikti` required & `exists:lldikti,idlldikti`, `nama_institusi` required (string; boleh berupa id saran yang dipilih atau teks baru — lihat §7.1).
  - Jenis lain → `nama_institusi` required (string).
- `idjabatan` — wajib ada di antara pilihan yang valid **untuk jenis institusi terpilih** (validasi ulang di server lewat `jenis_institusi_jabatan`, jangan percaya pilihan dari client — sesuai `CONVENTIONS.md` §6.5 soal form dinamis).
- `otp` — validasi dengan aturan §8 (baris `token` **terakhir** untuk `no_wa` itu, `token` cocok, dan `created_at` tidak lebih dari 1 menit lalu) — bukan sekadar `exists`. Tandai `used_at`/`used_by` setelah pengguna berhasil dibuat.

## 10. Transaksi & error handling

Urutan di dalam **satu `DB::transaction`** (sesuai `CONVENTIONS.md` §5):
1. Validasi ulang OTP (§8 langkah 4).
2. Cari/insert `institusi_asal` (§7.1–§7.2).
3. Insert `pengguna` (password di-hash).
4. Insert `role_pengguna` (`idrole=2`, `status=true`).
5. Insert `peserta` (`idjabatan`, kolom logistik null).
6. Tandai `token` terpakai (`used_at`/`used_by`).

Kalau ada langkah yang gagal di tengah, semua di-rollback dan pengguna melihat pesan error yang jelas (`withErrors`), bukan pesan exception mentah. Pengiriman WA kredensial (langkah setelah transaksi commit, lihat §2) dibungkus `try/catch` terpisah — kalau WA gagal terkirim, akun **tetap dibuat** (tidak rollback), tapi pesan ke peserta harus menyebutkan keduanya ("akun berhasil dibuat, namun WA gagal terkirim"), sesuai `CONVENTIONS.md` §5.

## 11. Status keputusan

Semua poin yang sebelumnya terbuka **sudah diputuskan** developer. Ringkasan:

- **Field dinamis** (§4–§6): PTN/PTS self-declared (tidak memfilter TomSelect universitas), `idlldikti` hanya untuk jenis "LLDikti", Jabatan mengikuti `jenis_institusi_jabatan` untuk semua jenis.
- **Satu institusi = satu kontingen** (§7): dikonfirmasi — `institusi_asal` dipakai bersama, dicocokkan otomatis (Perguruan Tinggi via `idref_institusi`) atau lewat TomSelect saran+create (jenis lain), dengan fallback pencocokan server `trim()`+`ilike` exact match.
- **Kode kontingen** (§7.2): tanggal registrasi (`XX`, 2 digit) + urutan global per hari (`ZZZ`, 3 digit) — total wajib 5 karakter sesuai kolom `varchar(5)`.
- **OTP** (§8): live-check AJAX wajib untuk mengaktifkan tombol submit, pakai `$.ajax` jQuery (bukan `fetch()`) sesuai `CONVENTIONS.md` §6.2; `cekOtp()` dijadikan generik lewat helper `isOtpValid()` di base `Controller.php` (dipakai ulang oleh Admin & registrasi peserta, beda hanya parameter `$maxAgeSeconds`); notifikasi tombol "Kirim OTP" tetap hint inline (bukan SweetAlert2) — cuma soal transport-nya yang wajib `$.ajax`.
- **Password** (§9): aturan kekuatan disamakan dengan `PenggunaController::updatePassword` (`min(8)->mixedCase()->numbers()->symbols()`); JS di halaman perlu diperbarui mengikuti pola `profile.blade.php`.

Dokumen ini siap dijadikan acuan implementasi. Kalau developer setuju, langkah berikutnya adalah memecah pengerjaan menjadi urutan kecil (mis. field dinamis dulu → OTP generik → institusi/kode kontingen → transaksi akhir) dan mulai coding per langkah dengan review di tiap langkah.
