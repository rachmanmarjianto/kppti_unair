# F21 — Respon Mitra atas Ajuan MoU (Temu Diskusi / Tunda) + Penjadwalan Pertemuan

> Melengkapi F21 ("Penjadwalan pertemuan MoU") di `PRD.md` §5, §6.4.
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide/asumsi AI, menunggu konfirmasi.
> **Status: spesifikasi lengkap** — semua pertanyaan terbuka sudah dijawab developer. Siap masuk tahap perencanaan implementasi.

## 1. Konteks & cakupan

Melanjutkan F20 — halaman detail pengajuan MoU sisi Peserta (`peserta/mou-pengajuan-detail.blade.php`, route `peserta.mou.pengajuan.detail`) saat ini **view only**. F21 menambahkan aksi di halaman itu **khusus untuk institusi yang berposisi "Penerima"** (Mitra) pada pengajuan berstatus `1 Ajuan` (belum direspon): tombol **"Respon Ajuan"**.

## 2. Tombol "Respon Ajuan"

- Muncul di halaman detail **hanya jika**: `$pengajuan->posisi === 'Penerima'` **dan** `$pengajuan->status_ajuan == 1`.
- Klik → modal **extra large** (`modal-xl`) terbuka, berisi 2 tab (Bootstrap nav-tabs): **"Response"** (default aktif) dan **"Pilih PIC & Jadwal"** (awalnya disabled/tersembunyi sampai tab 1 memilih "Temu Diskusi").

## 3. Tab 1 — "Response"

Dua tombol: **"Temu Diskusi"** dan **"Tunda Lain Waktu"**.

- **"Tunda Lain Waktu"** diklik → SweetAlert2 konfirmasi ("Yakin ingin menunda pengajuan ini?"). Kalau **Ya**:
  - `status_ajuan` → `3` (Tunda lain waktu), insert `log_status_mou`.
  - Proses berhenti di sini (sesuai instruksi developer) — modal ditutup, halaman reload, badge status di halaman detail berubah jadi "Tunda Lain Waktu".
- **"Temu Diskusi"** diklik → tab 2 terbuka (lihat §4 untuk kapan tepatnya status berubah ke `2`).

## 4. Transisi status saat "Temu Diskusi" diklik — **dikonfirmasi developer**

**Status baru berubah ke `2 Temu Diskusi` setelah Tab 2 berhasil submit** (satu transaksi akhir: `status_ajuan = 2`, `idpic_institusi_mitra`, dan klaim slot `pertemuan_mou` semua terjadi bersamaan — lihat §5.4). Sebelum submit berhasil, klik "Temu Diskusi" di Tab 1 **hanya navigasi UI** (membuka Tab 2), tidak mengubah apa pun di DB.

Konsekuensi: kalau modal ditutup di tengah Tab 2 (belum submit), `status_ajuan` tetap `1 Ajuan` dan tombol "Respon Ajuan" tetap muncul — mitra tinggal mengulang dari Tab 1.

## 5. Tab 2 — "Pilih PIC & Jadwal"

### 5.1 Field

1. **Select PIC** — peserta dari institusi Mitra (institusi yang login), urut **alfabet** (`orderBy('nama')`). Sumber: `Controller::pesertaAktifQuery($idInstitusiAsalMitra)`, sama pola dengan Pilih PIC di F20 (§4.2 dokumen 020), tapi di sini **select biasa** (bukan modal tabel — developer minta "select" langsung di tab ini). **Dikonfirmasi developer**: peserta yang login (yang merespon ajuan ini) boleh memilih dirinya sendiri sebagai PIC, sama seperti aturan F20.
2. **Select Tanggal** — dari `tanggal_mou`, urut **tanggal**, **hanya yang `status` aktif** (dikonfirmasi developer, konsisten dengan F20/F24).

### 5.2 Cek ketersediaan sesi (AJAX, dipicu setelah PIC + Tanggal terisi)

Request AJAX ke endpoint baru, kembalikan daftar `sesi_mou` yang **boleh dipilih** untuk kombinasi (PIC Mitra terpilih, Tanggal terpilih, dan PIC Pengaju pengajuan ini) — **sesi dikecualikan** kalau salah satu benar:

1. **Semua meja di semua ruang pada sesi itu sudah penuh** — tidak ada baris `pertemuan_mou` dengan `idtanggal_mou`+`idsesi_mou` itu yang `idpengajuan_mou IS NULL` (di ruang mana pun).
2. **PIC Pengaju** (dari pengajuan ini, `idpic_institusi_pengaju`) sudah terdaftar (sebagai `idpic_institusi_pengaju` **atau** `idpic_institusi_mitra` pada **pengajuan lain mana pun**) di `pertemuan_mou` dengan `idtanggal_mou`+`idsesi_mou` yang sama (meja/ruang mana pun) — satu orang tidak bisa di 2 meja pada sesi bersamaan.
3. **PIC Mitra** (yang baru dipilih di select §5.1) — cek yang sama seperti poin 2.

Query-nya kira-kira: ambil semua `idsesi_mou` yang punya **minimal 1 slot kosong** (`pertemuan_mou` dengan `idtanggal_mou` ini, `idpengajuan_mou IS NULL`) **dan** `idsesi_mou` itu **tidak** muncul di hasil join `pertemuan_mou`→`pengajuan_mou` yang `idtanggal_mou` sama **dan** (`idpic_institusi_pengaju` IN (PIC Pengaju, PIC Mitra terpilih) **atau** `idpic_institusi_mitra` IN (PIC Pengaju, PIC Mitra terpilih)) — set difference dari 2 query itu.

### 5.3 Select Sesi

- Diisi dari hasil §5.2 (AJAX), tampilkan label `jam_mulai`-`jam_akhir` (format jam:menit).
- Tombol submit **aktif setelah PIC + Tanggal + Sesi semuanya terisi**.

### 5.4 Submit — race condition aman

- **Ruang dan meja ditentukan sistem**, bukan dipilih mitra (sesuai instruksi developer) — mitra cuma memilih Sesi (dan tanggal, PIC).
- Server harus **mengklaim satu slot** (`pertemuan_mou` dengan `idtanggal_mou`+`idsesi_mou` terpilih, `idpengajuan_mou IS NULL`, **ruang/meja bebas**) secara **atomik**, aman dari race condition kalau 2 pengajuan berebut sesi yang sama bersamaan. **[USULAN AI]** pola implementasi: dalam `DB::transaction`, `SELECT idpertemuan_mou FROM pertemuan_mou WHERE idtanggal_mou=? AND idsesi_mou=? AND idpengajuan_mou IS NULL LIMIT 1 FOR UPDATE SKIP LOCKED`, lalu `UPDATE` baris itu set `idpengajuan_mou`. Kalau tidak ada baris ter-lock (hasil query kosong) → race kalah, slot sudah diambil pihak lain barusan.
- **Kalau race kalah** (slot habis tepat saat submit): **batalkan submit**, beri notifikasi jelas ("Meja pada sesi ini baru saja penuh, silakan ulangi proses penerimaan dari awal"). **Dikonfirmasi developer**: modal **ditutup**, halaman kembali ke tampilan awal (tombol "Respon Ajuan") — karena status belum sempat berubah (`1 Ajuan` tetap), ini aman: mitra klik "Respon Ajuan" lagi dan mengulang seluruhnya dari Tab 1 (termasuk bisa pilih PIC/tanggal/sesi lain).
- **Kalau berhasil**: dalam transaksi yang sama — update `pengajuan_mou` (`status_ajuan = 2`, `idpic_institusi_mitra` = PIC terpilih), insert `log_status_mou` (`status = 2`), update baris `pertemuan_mou` yang diklaim (`idpengajuan_mou` terisi). Modal ditutup, halaman detail reload — badge status jadi "Temu Diskusi", "Waktu dan Lokasi" terisi.

## 6. Tabel yang terlibat

| Tabel | Peran |
|---|---|
| `pengajuan_mou` | Update `status_ajuan` (ke `2` atau `3`) dan `idpic_institusi_mitra` (saat Temu Diskusi berhasil submit). |
| `log_status_mou` | Insert baris baru tiap transisi status (`2` atau `3`). |
| `pertemuan_mou` | Baca (cek ketersediaan §5.2) dan update (klaim slot §5.4) — **tidak pernah insert baris baru** di sini (beda dari F24 "Sesuaikan Slot" yang insert; F21 cuma mengisi `idpengajuan_mou` pada baris yang sudah ada). |
| `tanggal_mou` | Sumber opsi select Tanggal (§5.1). |
| `sesi_mou` | Sumber label sesi di select Sesi (§5.3). |
| `pengguna` / `peserta` | Sumber opsi select PIC Mitra (§5.1), lewat `pesertaAktifQuery()`. |

## 7. Keputusan yang sudah dikonfirmasi developer

1. **(§4)** Status baru berubah ke `2 Temu Diskusi` setelah Tab 2 berhasil submit (bukan saat klik "Temu Diskusi").
2. **(§5.1)** Select Tanggal hanya menampilkan tanggal yang `status` aktif di `tanggal_mou`.
3. **(§5.4)** Saat race kalah: modal ditutup, reset total ke tombol "Respon Ajuan" — mitra mengulang dari Tab 1.
4. **(§5.1)** PIC Mitra boleh memilih peserta yang sedang login sendiri (sama seperti aturan PIC di F20).

## 8. Di luar cakupan (dokumen ini)

- F22 (Petugas Ruang MoU mencatat kehadiran) — dibahas terpisah.
- F23 (rekap Admin) — dibahas terpisah.
- Mengubah/membatalkan jadwal pertemuan yang sudah terbentuk (reschedule) — belum dibahas developer.
