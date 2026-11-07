# F19 — Registrasi Kontingen di Lokasi Acara (Sistem Antrian)

> Melengkapi F19 di `PRD.md` §5 ("Registrasi kontingen di lokasi acara pada hari kedatangan, dengan sistem antrian") dan §6.3.
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide/asumsi AI, menunggu konfirmasi.
> **Status: spesifikasi lengkap** — semua pertanyaan terbuka sudah dijawab developer. Siap masuk tahap perencanaan implementasi.

## 1. Konteks & cakupan

Pada hari kedatangan, perwakilan kontingen (institusi peserta) datang ke lokasi acara dan mengambil nomor antrian lewat halaman mandiri (tanpa login), lalu menunggu dipanggil lewat layar tampilan antrian (tanpa login, dipasang di depan ruang tunggu). Petugas meja registrasi (role baru) memanggil antrian, melayani kehadiran peserta kontingen tersebut (termasuk cetak PDF daftar hadir untuk tanda tangan manual), lalu menutup layanan dan kembali memanggil antrian berikutnya.

Tiga halaman yang terlibat:

1. **Halaman Ambil Nomor Antrian** — publik, tanpa login, 1 field input, selalu terbuka (tidak digerbangi jadwal).
2. **Halaman Tampilan Antrian** — publik, tanpa login, layar besar di lokasi (3 panel: Antri / Dipanggil / Terlewat).
3. **Halaman Petugas Meja Registrasi** — butuh login, role baru idrole 8.

## 2. Tabel yang terlibat (skema sudah ada, lihat `kppti_33.sql`)

### 2.1 `antrian_regis`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idantrian_regis` | integer, PK, serial | |
| `kode_kontingen` | varchar(7) | Disalin dari `institusi_asal.kode_kontingen` saat registrasi (snapshot). |
| `idinstitusi_asal` | bigint | FK ke `institusi_asal`. |
| `created_at` | timestamp | Waktu registrasi antrian — dipakai juga sebagai **kunci pengelompokan per tanggal** (`DATE(created_at)`), karena tidak ada kolom tanggal terpisah. |
| `status` | char(1) | Kode numerik — lihat tabel di bawah. |
| `dipanggil_oleh` | integer | **FK ke `meja_regis.idmeja_regis`** (dikonfirmasi lewat skema — bukan `idpengguna` langsung seperti draf awal dokumen ini). Nomor meja di-lookup lewat `meja_regis.idmeja_regis = dipanggil_oleh`; petugasnya sendiri (kalau perlu) lewat `meja_regis.idpengguna`. |
| `panggilan_ke` | smallint | Counter "panggil lagi" — di-increment tiap kali tombol "Panggil Lagi" diklik untuk antrian yang sama (status tidak berubah). Dipakai Halaman 2 untuk tahu kapan harus memutar ulang efek bel+TTS meski status tidak berubah (lihat §5.2). |
| `nomor_antrian` | integer | Urut increment per tanggal (lihat §3, poin 4). |

Nilai `status` (sesuai comment kolom di skema):

| Kode | Status |
|---|---|
| `1` | Antri |
| `2` | Dipanggil |
| `3` | Sedang dilayani |
| `4` | Terlayani |
| `5` | Terlewat |

### 2.2 `meja_regis`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idmeja_regis` | integer, PK, serial | |
| `nomor_meja` | char(2) | Mis. `'01'`. |
| `idpengguna` | integer | FK ke `pengguna` — 1 baris = 1 petugas terhubung ke 1 nomor meja. |

**Dikonfirmasi**: diisi/dikelola **Admin lewat halaman baru** (submenu di bawah menu Users, pola CRUD sederhana — pilih pengguna dengan role Petugas Meja Registrasi, isi nomor meja).

### 2.3 Role baru "Petugas Meja Registrasi" — **dikonfirmasi, idrole 8**

Tambah baris baru di tabel `role` (idrole 8), lalu dibangun dengan pola single-menu yang sama seperti Petugas Kit (idrole 5)/Petugas Ruang MoU (idrole 7): `routes/petugas-meja-regis.php`, `PetugasMejaRegisController`, `menu_petugas_meja_regis.blade.php`, entri baru di `Controller::HOME_BY_ROLE`, cabang baru di `layout.layout`.

## 3. Halaman 1 — Ambil Nomor Antrian (publik, tanpa login)

- Route publik baru di `routes/web.php` (pola seperti `/registrasi` — tanpa middleware `akses`). **Dikonfirmasi: tidak digerbangi jadwal** — selalu terbuka berapa pun tanggalnya selama acara berlangsung.
- Isi halaman: **1 field text** untuk kode kontingen.
- **Auto-submit setelah 7 karakter terinput** (JS: `keyup`/`input` listener, panjang string === 7 → submit AJAX langsung, tanpa tombol submit).
- Validasi server:
  1. Cari `institusi_asal` dengan `kode_kontingen` = input (exact match — **[USULAN AI]**: dibandingkan setelah `Str::upper()`/`trim()` di kedua sisi untuk toleransi spasi/huruf kecil, karena kode kontingen biasanya huruf besar semua; belum dikonfirmasi developer tapi risikonya kecil, bisa disesuaikan saat implementasi kalau developer keberatan).
  2. Kalau **tidak ditemukan** — **dikonfirmasi**: SweetAlert2, auto-close 3 detik (sama gaya dengan kasus "sudah daftar" di poin 3), field dikosongkan & fokus ulang ke input.
  3. Kalau **ditemukan**, cek apakah institusi itu **sudah punya baris `antrian_regis`** dengan `DATE(created_at) = CURRENT_DATE` (hari ini) — kalau **ya**: tampilkan **SweetAlert2** "Institusi Anda telah daftar antrian", **auto-close setelah 3 detik** (`timer: 3000`), field dikosongkan, tidak ada insert baru.
  4. Kalau **belum pernah daftar hari ini** — insert baris baru ke `antrian_regis`: `idinstitusi_asal`, `kode_kontingen` (snapshot), `status = '1'` (Antri), `created_at = now()`, `nomor_antrian` = **hitungan baris `antrian_regis` dengan `DATE(created_at) = CURRENT_DATE` + 1** (dihitung di dalam transaksi untuk hindari race 2 kontingen input bersamaan — **[USULAN AI]** pola yang sudah dipakai di F21 untuk klaim slot: `DB::transaction` + `SELECT ... FOR UPDATE` pada baris-baris hari itu sebelum hitung, atau `SELECT MAX(nomor_antrian) FOR UPDATE` + 1).
  5. Setelah berhasil insert — **dikonfirmasi: tidak perlu menampilkan nomor antrian di halaman ini**. Field langsung reset. Perwakilan melihat posisi antriannya sendiri di Halaman 2 (layar di depan ruang tunggu).

## 4. Halaman 2 — Tampilan Antrian (publik, tanpa login, layar besar)

Layout: dibagi vertikal 70% (atas) / 30% (bawah).

- **Bagian atas (70%)** dibagi horizontal 50:50:
  - **Kiri — List "Antri"**: semua `antrian_regis` dengan `status = '1'` **hari ini**, urut `nomor_antrian` ascending (paling awal daftar di atas, paling baru di bawah). List **auto-scroll vertikal pelan** terus-menerus; sampai bawah → balik ke atas (loop). **[USULAN AI]** teknik: `setInterval` menggeser `scrollTop` sedikit demi sedikit (misal setiap 50ms), reset ke 0 saat `scrollTop + clientHeight >= scrollHeight`.
  - **Kanan — List "Dipanggil"**: antrian `status = '2'` (Dipanggil) saja. **Dikonfirmasi**: begitu status berubah jadi `3` (Sedang Dilayani), baris **langsung hilang** dari list ini (bukan "tetap tampil sampai tergeser").
  - Urutan render: entri **terbaru di atas**, entri lama tergeser ke bawah (prepend, bukan append).
  - **Efek panggilan baru** (saat sebuah antrian baru masuk ke list ini, atau `panggilan_ke` bertambah untuk antrian yang sama — "Panggil Lagi"): nama institusi + nomor meja **blink selama 10 detik**. Urutan suara: **bunyi bel dulu** (file audio yang disediakan developer, ditaruh di `public/`, diputar lewat elemen `<audio>`/JS `Audio()`), **setelah file bel selesai diputar** (event `ended`) baru jalankan **TTS** lewat `window.speechSynthesis` (Web Speech API browser, bahasa `id-ID`), menyebut: *"(nama institusi) silahkan ke meja nomor (nomor meja dieja digit, misal 01 → 'Kosong Satu')."*
    - **[USULAN AI]** pengejaan digit nomor meja: fungsi kecil di JS yang memetakan tiap karakter `nomor_meja` (char(2)) ke kata angka Indonesia (`0`→"Kosong", `1`→"Satu", dst), bukan dibaca sebagai angka utuh ("sebelas" dsb).
  - **Refresh data**: **dikonfirmasi — pakai Server-Sent Events (SSE)**. Endpoint baru di server (`StreamedResponse`, `Content-Type: text/event-stream`, loop `while(true)` dengan polling DB tiap beberapa detik di sisi server lalu `echo "data: ...\n\n"` + `flush()`), di-consume di JS lewat `new EventSource(url)` dan `onmessage` yang me-render ulang list + memicu efek blink/bel/TTS saat ada perubahan data yang relevan (baris baru di list Dipanggil, atau `panggilan_ke` bertambah). Tidak butuh dependensi baru (bukan Pusher/Reverb) — ini native browser + PHP.
- **Bagian bawah (30%)** dibagi **3 kolom**: list "Terlewat" (`status = '5'` hari ini), supaya banyak institusi terlewat tetap terlihat sekaligus.

## 5. Halaman 3 — Petugas Meja Registrasi (butuh login, role baru)

### 5.1 Tampilan depan (default setelah login / setelah selesai layani)

- List antrian (`status = '1'` hari ini, urut `nomor_antrian`).
- Tombol **"Panggil Antrian"** — memanggil **antrian teratas** (nomor terkecil yang masih status `1`).
- Atau klik **langsung nama institusi** di list — memanggil institusi itu spesifik (melewati urutan).
- Keduanya berlaku sama: `status` institusi terpilih → `2` (Dipanggil), `dipanggil_oleh` = **`idmeja_regis` milik petugas yang login** (resolve dulu lewat `meja_regis.idpengguna = session('userdata')['idpengguna']`). Kalau petugas yang login belum punya baris `meja_regis` sama sekali (belum dipetakan Admin ke nomor meja manapun) → tolak dengan pesan jelas, bukan error 500 (lihat §2.2, dikelola Admin di "Kedatangan Kontingen → Petugas Meja").
- **Satu petugas hanya boleh punya 1 antrian aktif (status `2`/`3`) miliknya** pada satu waktu — kalau mencoba panggil lagi padahal masih ada yang aktif, ditolak (validasi di server, cek `dipanggil_oleh = idmeja_regis milik petugas ini`).
- Tombol tambahan **"Riwayat Dilayani"** — klik → AJAX ambil daftar antrian **hari ini** dengan `dipanggil_oleh = idmeja_regis` petugas ini (semua status, termasuk yang sudah `4` Terlayani), tampilkan di **modal extra large** (nama institusi, nomor antrian, status, waktu). Tujuannya supaya petugas bisa menjawab kalau ada perwakilan yang bertanya soal antrian yang sudah ditanganinya.

### 5.2 Setelah memanggil

Layar berubah menampilkan kartu antrian yang baru dipanggil, dengan 2 opsi:

1. **"Panggil Lagi"** — mengulang bunyi bel + TTS untuk antrian yang sama (tidak mengubah `status`/`nomor_antrian`, cukup **increment `panggilan_ke`** — Halaman 2 (lewat SSE) mendeteksi perubahan nilai ini untuk tahu harus re-trigger animasi/suara meski `status` tidak berubah). Tombol **disabled 5 detik** setelah diklik (`setTimeout` di JS, re-enable otomatis).
2. **"Terlewat"** — `status` → `5`. Antrian pindah ke list Terlewat (Halaman 2 bagian bawah), dan petugas **kembali ke tampilan depan (§5.1)** untuk memanggil antrian lain.
3. **"Layani"** — `status` → `3`. Masuk ke §5.3.

### 5.3 Halaman Layani (status `3` Sedang Dilayani)

- Tampilkan **list peserta dari institusi tersebut** (`Controller::pesertaAktifQuery($idInstitusiAsal)`, pola yang sudah dipakai di fitur lain seperti Seminar Kit/Petugas Kit) dengan **checkbox per peserta** untuk menandai `peserta.hadir = true` (kolom `hadir` **sudah ada** di tabel `peserta`, tidak perlu kolom baru).
- **Download PDF** — berisi nama institusi, daftar nama peserta, kolom kosong untuk dicentang manual, dan ruang tanda tangan + nama (ditulis tangan oleh perwakilan). **Dikonfirmasi**: pakai `barryvdh/laravel-dompdf` — **sudah terpasang** di proyek ini (`composer show --direct` mengonfirmasi versi 3.1.2), tidak perlu menambah dependensi baru.
- Setelah perwakilan menyerahkan PDF yang sudah ditandatangani, petugas **mencentang checkbox** peserta yang hadir sesuai PDF manual itu (tidak ada OCR/scan — proses manual oleh petugas).
- Tombol **"Selesai Layani"** — `status` → `4` (Terlayani), simpan semua centang `hadir` yang sudah ditandai, lalu kembali ke tampilan depan (§5.1).

## 6. Tabel yang terlibat (ringkasan)

| Tabel | Peran |
|---|---|
| `antrian_regis` | Baca/tulis utama — lihat §2.1. |
| `meja_regis` | Pemetaan petugas ↔ nomor meja (§2.2), dikelola Admin. |
| `institusi_asal` | Cari institusi dari `kode_kontingen` (Halaman 1); sumber nama institusi untuk tampilan (Halaman 2) dan Layani (Halaman 3). |
| `peserta` | Kolom `hadir` diupdate di Halaman 3 §5.3 (sudah ada, tidak perlu kolom baru). Sumber list peserta per institusi lewat `pesertaAktifQuery()`. |
| `pengguna` | Login Petugas Meja Registrasi. |
| `role` / `role_pengguna` | Role baru idrole 8 "Petugas Meja Registrasi". |

## 7. Keputusan yang sudah dikonfirmasi developer

1. Halaman 1 & 2 **tanpa login** (publik); Halaman 1 **tidak digerbangi jadwal**, selalu terbuka.
2. Halaman 1: 1 field, **auto-submit di 7 karakter**.
3. **Satu institusi hanya boleh 1x daftar antrian per tanggal** — duplikat ditolak dengan SweetAlert2 "institusi Anda telah daftar antrian", auto-close 3 detik. Kode kontingen tidak ditemukan → SweetAlert2 serupa, auto-close 3 detik juga.
4. `nomor_antrian` **increment per tanggal registrasi**, bukan global. Tidak ada tampilan konfirmasi nomor antrian di Halaman 1 — perwakilan melihat posisinya di Halaman 2.
5. Layout Halaman 2: **70% atas / 30% bawah**; atas dibagi **50:50** (kiri Antri auto-scroll pelan loop, kanan Dipanggil — hanya status `2`, hilang begitu jadi status `3`); bawah dibagi **3 kolom** untuk list Terlewat.
6. Urutan list Antri: **lebih awal daftar di atas**.
7. Panggilan: ambil antrian **paling atas** (nomor terkecil) kecuali petugas klik institusi spesifik di list.
8. Efek panggilan: **bel (file audio) dimainkan dulu, baru TTS Web Speech API** menyusul setelah bel selesai, menyebut nama institusi + nomor meja (dieja digit, mis. "01" → "Kosong Satu"); **blink nama + nomor meja selama 10 detik** di Halaman 2.
9. **Refresh Halaman 2 pakai Server-Sent Events (SSE)**, bukan polling AJAX biasa maupun WebSocket/broadcasting pihak ketiga.
10. Alur status: `1 Antri → 2 Dipanggil → 3 Sedang Dilayani → 4 Terlayani`, cabang `2 → 5 Terlewat`.
11. Petugas **hanya bisa punya 1 antrian aktif** (status `2`/`3`) pada satu waktu.
12. Tombol **"Panggil Lagi"** disabled **5 detik** setelah diklik; tidak mengubah status, hanya increment `panggilan_ke` sebagai sinyal untuk Halaman 2 memutar ulang efek.
13. Halaman Layani: checkbox kehadiran per peserta (`peserta.hadir`), **download PDF** (`barryvdh/laravel-dompdf`, sudah terpasang) daftar peserta untuk ditandatangani manual, lalu petugas mencentang sesuai PDF yang diserahkan balik.
14. **"Selesai Layani"** mengubah status jadi `4` dan mengembalikan petugas ke tampilan depan.
15. **Nomor meja**: tabel `meja_regis` (idpengguna ↔ nomor_meja), dikelola **Admin lewat halaman baru**.
16. **Role baru** "Petugas Meja Registrasi" = **idrole 8**, disetujui.
17. Halaman Petugas Meja punya tombol **"Riwayat Dilayani"** — modal extra large berisi semua antrian hari ini yang pernah ditangani petugas yang login (AJAX), untuk menjawab pertanyaan perwakilan yang datang kembali.

## 8. Di luar cakupan (dokumen ini)

- Desain visual/tema persis Halaman 2 (warna, font besar untuk keterbacaan jarak jauh) — menyusul saat implementasi, bisa disesuaikan dengan tema admin yang sudah ada atau dibuat halaman mandiri tanpa layout `layout.layout`.
- Laporan/rekap jumlah kontingen yang sudah registrasi vs belum (kemungkinan fitur Admin terpisah, belum diminta developer).
- Isi persis file audio bel (format, durasi) — developer akan menyediakan asetnya sendiri saat implementasi.
