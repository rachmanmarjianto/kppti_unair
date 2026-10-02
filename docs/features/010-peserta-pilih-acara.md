# F10 — Peserta Memilih Acara

> Melengkapi F10 di `PRD.md` ("Peserta memilih acara yang diikuti").
> Status: **selesai diimplementasikan**. Revisi kedua (lihat §7, §3–§4): acara wajib sekarang **otomatis terdaftar saat peserta dibuat**, bukan perlu konfirmasi manual seperti versi pertama; UI dipindah ke menu "Acara" tersendiri.

## 1. Tujuan

Peserta memilih acara/sesi mana yang ingin diikuti, dari daftar acara yang dibuat lewat F09 (`acara.opsi_pilih`: `1` tidak bisa dipilih, `2` opsional, `3` wajib). Pilihan dicatat ke tabel `peserta_acara` (sudah ada di skema, lihat §2).

## 2. Skema tabel (sudah ada, tidak ada migrasi baru)

Tabel `peserta_acara` (migrasi `2025_01_01_000015_create_peserta_acara_table`, sudah ada di database live):

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idpeserta_acara` | bigint, PK | |
| `idpeserta` | bigint, FK → `peserta.idpeserta` | |
| `idacara` | bigint, FK → `acara.idacara` | |

Tidak ada kolom status — **baris ada = peserta terdaftar di acara itu**, baris dihapus = batal (hard delete pada tabel penghubung ini, bukan soft delete — berbeda dari `acara.status`/`pengguna.is_deleted`, karena baris ini murni relasi pilihan, bukan data yang perlu diaudit riwayatnya sendiri; jejak aktivitasnya tetap tercatat lewat `log_peserta`, lihat §3).

## 3. Siapa yang bisa memilih (dikonfirmasi developer)

Sama seperti pola F03/F11 yang sudah ada (`PesertaController::updatePeserta`, `updateLogistik`, dst.): **peserta memilih acara untuk dirinya sendiri secara mandiri, atau anggota kontingen lain boleh membantu memilihkan** — tetap dibatasi ke sesama anggota kontingen yang sama (`findPesertaInOwnInstitusi`, pola yang sama seperti update data peserta lain), bukan lintas institusi. **Setiap pendaftaran maupun pembatalan dicatat ke `log_peserta`** (`aktifitas`: "Mendaftar acara: &lt;tema&gt;" / "Membatalkan pendaftaran acara: &lt;tema&gt;", `done_by` = pengguna yang melakukan aksi, yang bisa berbeda dari peserta pemilik data kalau dibantu anggota lain).

## 4. UI: menu "Acara" tersendiri, 2 card (revisi developer)

Bukan tombol di halaman "Peserta Kontingen" (desain pertama) — sekarang **menu sidebar baru "Acara"** (`peserta.acara`), berisi 2 card:

1. **Card atas — "Peserta Kontingen"**: daftar nama+jabatan peserta sekontingen, tiap baris punya tombol **"Pilih Acara"** yang membuka halaman per-peserta (`peserta.sekontingen.acara`, token terenkripsi per `idpeserta` seperti pola foto/logistik).
2. **Card bawah — "Jadwal Acara"**: seluruh acara aktif, **diurutkan berdasarkan `idacara`** (bukan hari/jam — supaya tampilannya tidak "compang-camping"), dan untuk tiap acara ditampilkan **nama-nama peserta sekontingen sendiri** yang terdaftar di situ (lintas institusi **tidak** ditampilkan, lihat §3).

### Mekanisme pilih (di halaman per-peserta `peserta.sekontingen.acara`)

- Setiap acara yang bisa dipilih (`opsi_pilih` 2 atau 3, dan bukan acara yang punya anak — lihat §6) ditampilkan dengan **checkbox**. Acara wajib (`opsi_pilih=3`) checkbox-nya **selalu tercentang dan terkunci (disabled)** — lihat §7, sudah bukan aksi manual lagi.
- Untuk acara opsional (`opsi_pilih=2`): centang checkbox → AJAX **langsung** mendaftarkan peserta ke acara itu (tidak menunggu tombol "Simpan" terpisah). Hapus centang → AJAX langsung membatalkan.
- Selama proses AJAX berjalan, checkbox **dikunci (disabled) dan diberi indikator loading** (mis. spinner kecil di sampingnya) — supaya peserta tahu prosesnya sedang berjalan dan tidak bisa diklik berulang.
- Hasil ada 2: **berhasil** (checkbox tetap pada state barunya, SweetAlert2/toast singkat opsional) atau **ditolak** (checkbox dikembalikan ke state semula, tampilkan pesan error — lihat §5 untuk kondisi penolakan).

## 5. Validasi bentrok jadwal (dikonfirmasi developer)

**Saat mendaftarkan** (centang checkbox), server menolak kalau acara yang dipilih **bentrok jam** dengan acara lain yang **sudah terdaftar** untuk peserta itu — didefinisikan sebagai: `hari_ke` sama **dan** rentang `jam_mulai`–`jam_akhir` beririsan (`jam_mulai_baru < jam_akhir_lain AND jam_mulai_lain < jam_akhir_baru`). Ini berlaku **lintas payung mana pun** (bukan cuma sesama anak dari satu payung) — terkonfirmasi lewat data acara yang sudah ada: anak-anak dari payung yang **berbeda** (mis. "Sub Tema 1" vs "Sub Tema 2") justru **banyak yang jamnya sama** (keduanya 10:00–12:00, dst.), sedangkan anak-anak **dalam satu payung yang sama** justru berurutan (10–12, 13–15, 15–17, tidak bentrok). Jadi validasi **generik berbasis irisan jam** (bukan "radio per payung") sudah otomatis menangani kedua kasus dengan benar.

- Baris acara yang `jam_mulai`/`jam_akhir`-nya kosong (null) **tidak ikut dicek bentrok** (tidak mungkin tahu irisannya) — baik sebagai acara yang mau didaftarkan maupun sebagai pembanding.
- Kalau ditolak, pesan menyebutkan acara lain yang bentrok, mis. "Bentrok dengan acara yang sudah dipilih: &lt;tema acara lain&gt; (Hari 2, 10:00–12:00)."
- **Membatalkan** (uncheck) tidak divalidasi apa pun — selalu diizinkan.

## 6. Acara yang bisa dipilih: hanya node "daun" dengan `opsi_pilih` 2/3

Dikonfirmasi lewat data acara yang sudah ada (lihat hasil `php artisan tinker` saat spesifikasi ini disusun): **setiap acara yang punya anak (`has_child = true`) selalu `opsi_pilih = 1`** — payung/sesi paralel sendiri **tidak pernah jadi pilihan**, yang bisa dipilih selalu levelnya anak (atau acara mandiri tanpa anak sama sekali, seperti Keynote/Plenary yang `opsi_pilih = 3`). Jadi:

- Acara dengan `has_child = true` → **tidak pernah ditampilkan checkbox**, apa pun nilai `opsi_pilih`-nya (sebagai lapis pertahanan tambahan di server, bukan cuma mengandalkan data yang konsisten).
- Acara dengan `has_child = false` dan `opsi_pilih = 1` → ditampilkan **tanpa checkbox**, hanya informasi (pakai badge yang sama seperti di admin: `admin.partials.opsi-pilih-badge`), supaya peserta tetap bisa melihat agenda penuh.
- Acara dengan `has_child = false` dan `opsi_pilih` 2 atau 3 → ditampilkan **dengan checkbox**.

## 7. Acara "Wajib" (`opsi_pilih = 3`): otomatis terdaftar saat peserta dibuat (revisi developer)

**Developer berubah pikiran dari keputusan pertama** (dulu: tetap perlu konfirmasi manual). Sekarang:

- Peserta **otomatis didaftarkan** ke semua acara wajib **pada saat peserta baru dibuat** — logika ini ditaruh tepat di titik insert baris `peserta` baru (`Controller::registerWajibAcaraUntukPeserta()`, dipanggil dari `PenggunaController::registrasi()` alur F01 dan `PesertaController::tambahPeserta()` alur F03), **bukan** dipicu dari halaman pilih-acara.
- Checkbox acara wajib di halaman pilih-acara jadi **tercentang dan terkunci (disabled)** — tidak bisa dibatalkan oleh peserta ataupun anggota kontingen lain. `daftarAcara()`/`batalAcara()` juga menolak (422) percobaan manual terhadap acara wajib sebagai lapis pertahanan server.
- **Keterbatasan yang disadari**: hook ini hanya jalan saat **peserta baru dibuat**. Kalau admin menambah acara wajib **baru** setelah ada peserta lama, peserta lama **tidak otomatis ikut terdaftar** — perlu backfill manual ulang (lihat riwayat di §11) kalau skenario itu terjadi lagi. Di luar cakupan untuk menghubungkan proses ini ke pembuatan acara F09.

## 8. Status keputusan

- **Lingkup pemilih** (§3): peserta sendiri atau anggota kontingen lain (dibatasi sesama kontingen), semua aksi tercatat `log_peserta`.
- **UI** (§4): menu "Acara" tersendiri, card peserta (tombol Pilih Acara) + card jadwal (siapa saja dari kontingen sendiri yang ikut tiap acara), diurutkan berdasarkan `idacara`.
- **Validasi bentrok** (§5): perlu, berbasis irisan jam, generik lintas payung (bukan cuma radio per payung) — hanya relevan untuk acara opsional, karena wajib sudah otomatis.
- **Node yang bisa dipilih** (§6): hanya acara tanpa anak (`has_child = false`) dengan `opsi_pilih` 2/3; dikonfirmasi empiris payung selalu `opsi_pilih = 1`.
- **Acara wajib** (§7): otomatis terdaftar saat peserta dibuat, checkbox terkunci, tidak bisa dibatalkan.

## 9. Di luar cakupan (out of scope)

- **Tidak mengubah definisi "data lengkap"** yang menggerbangi cetak kartu kontingen (F11/F16) — pemilihan acara **tidak** jadi syarat tambahan untuk kartu registrasi di versi ini.
- **Tidak ada batas waktu/pengisian terkunci** untuk acara opsional — peserta bisa ubah pilihan kapan saja, tidak ada tanggal cutoff di versi ini.
- **Tidak ada dashboard/rekap admin** terkait jumlah peserta per acara di fitur ini (bisa jadi bagian F13 kalau dibutuhkan nanti).
- **Tidak ada ekspor jadwal pribadi** (PDF/cetak) — di luar cakupan F10, bisa jadi bagian F15 kalau dibutuhkan nanti.
- **Tidak menghubungkan auto-registrasi ke pembuatan acara wajib baru** (F09) — lihat keterbatasan di §7.

## 10. Implementasi (gambaran teknis)

- `app/Http/Controllers/Controller.php`: `registerWajibAcaraUntukPeserta(int $idpeserta)` (protected, idempotent) — dipanggil dari titik insert peserta baru di `PenggunaController::registrasi()` dan `PesertaController::tambahPeserta()`.
- `PesertaController`: `acara()` (GET, halaman menu baru, 2 card), `pilihAcara(Request $request)` (GET, halaman per-peserta, token terenkripsi), `daftarAcara(Request $request)`/`batalAcara(Request $request)` (POST, hanya untuk `opsi_pilih=2`).
- View: `resources/views/peserta/acara.blade.php` (baru, 2 card), `resources/views/peserta/pilih-acara.blade.php` (tabel flat urut `idacara`, pola tbody sama seperti `admin/acara.blade.php`).
- Menu baru "Acara" di `resources/views/layout/menu_peserta.blade.php`; tombol "Pilih Acara" yang sebelumnya ada di `sekontingen.blade.php` **dihapus** dari sana.
- Rute di `routes/peserta.php`, grup `akses:2` yang sudah ada.

## 11. Riwayat backfill data

Saat revisi §7 diterapkan, peserta yang sudah ada sebelum fitur ini dibuat **disesuaikan sekali** lewat query langsung (logika identik dengan `registerWajibAcaraUntukPeserta()`) supaya semua peserta lama juga terdaftar di semua acara wajib yang sudah ada saat itu — bukan migrasi skema, murni penyesuaian data.

Dokumen ini siap dijadikan acuan implementasi.
