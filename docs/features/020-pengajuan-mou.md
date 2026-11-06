# F20 — Pengajuan MoU Antar Institusi

> Melengkapi F20 ("Pengajuan MoU antar institusi") di `PRD.md` §5, alur bisnis §6.4.
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide/asumsi AI, menunggu konfirmasi.
> **Status: spesifikasi sedang disusun bertahap** — dokumen ini mencakup istilah baku, dan halaman sisi Peserta: menu "Pengajuan MoU" > submenu **"Pengajuan"** (daftar + form pengajuan baru). Bagian lain (respon Mitra atas ajuan, penjadwalan pertemuan — F21, Petugas Ruang MoU — F22, rekap Admin — F23) menyusul didiskusikan terpisah.

## 1. Istilah baku (disepakati developer)

Dipakai konsisten di seluruh dokumen/kode mulai sekarang:

- **Pengaju** — institusi yang **mengajukan** MoU (`pengajuan_mou.idinstitusi_pengaju`).
- **Mitra** — institusi yang **menerima** pengajuan MoU (`pengajuan_mou.idinstitusi_mitra`).
- Satu institusi bisa berperan sebagai Pengaju pada satu pengajuan, dan sebagai Mitra pada pengajuan lain — peran ini melekat **per baris `pengajuan_mou`**, bukan sifat tetap institusi.
- Peserta selalu bertindak **sebagai perwakilan institusinya** — MoU terjadi antar institusi (`institusi_asal`), individu peserta cuma pemegang peran "PIC" di satu sisi.

## 2. Tabel yang terlibat

Semua sudah ada di DB, migrasi sudah dibuat menyusul (`database/migrations/2026_11_05_*_create_*_mou_table.php`):

| Tabel | Peran |
|---|---|
| `pengajuan_mou` | Satu baris = satu pengajuan MoU antara dua institusi. Kolom kunci: `status_ajuan` (§3), `idinstitusi_pengaju`/`idinstitusi_mitra` (FK `institusi_asal`), `idpic_institusi_pengaju`/`idpic_institusi_mitra` (FK `pengguna` — **bukan** FK `peserta`), `pic_pengaju_hadir_at`/`pic_mitra_hadir_at` + `pic_pengaju_stamp_by`/`pic_mitra_stamp_by` (dipakai nanti di F22, Petugas Ruang MoU mencatat kehadiran). |
| `log_status_mou` | Riwayat perubahan `status_ajuan` — `done_at`, `done_by` (FK `pengguna`), `status`, `idpengajuan_mou`. Satu baris per perubahan status (audit trail, bukan dipakai untuk render detail seperti `review_pameran`). |
| `lampiran_mou` | Lampiran pendukung pengajuan — `jenis_lampiran` (1: file, 2: catatan), `file_path`, `catatan`, `idpengajuan_mou`, `dikirim_oleh` (`idinstitusi_asal` pihak yang mengirim). **Relasi (dikonfirmasi developer, §4):** satu pengajuan boleh punya **maksimal 1 baris catatan** (`jenis_lampiran = 2`) dan **banyak baris file** (`jenis_lampiran = 1`). |
| `ruang_mou` / `sesi_mou` / `tanggal_mou` / `pertemuan_mou` | Dipakai di F21 (penjadwalan pertemuan) — di luar cakupan dokumen ini, disebut di kolom "Waktu dan Lokasi" (§3) karena datanya bisa sudah ada saat pengajuan sudah dijadwalkan. |

## 3. Halaman Peserta: menu "Pengajuan MoU" > submenu "Pengajuan" (daftar)

Menggantikan placeholder "coming soon" yang sudah ada (`peserta/mou-pengajuan.blade.php`).

### 3.1 Isi tabel

Satu baris = satu `pengajuan_mou` di mana institusi peserta yang login terlibat (sebagai Pengaju **atau** Mitra). DataTable dengan kolom:

| Kolom | Sumber | Keterangan |
|---|---|---|
| PIC MoU | `pengguna` sisi institusi peserta yang login (nama + no. WA) | Kalau institusi login berperan Pengaju pada baris itu → ambil dari `idpic_institusi_pengaju`; kalau berperan Mitra → ambil dari `idpic_institusi_mitra`. |
| Instansi Mitra | `institusi_asal` sisi **lawan** | Kebalikan dari baris PIC MoU — kalau institusi login adalah Pengaju, "Instansi Mitra" di sini menunjuk ke `idinstitusi_mitra` (lawan bicaranya), dan sebaliknya. **Catatan penamaan:** ini memakai kata "mitra" secara umum (lawan bicara), bukan selalu berarti institusi itu berperan sebagai "Mitra" di §1 — perannya yang sebenarnya tercermin di kolom "Posisi". |
| PIC Mitra | `pengguna` sisi lawan | Pasangan dari kolom "Instansi Mitra" di atas. |
| Jenis Institusi | `jenis_institusi` milik institusi lawan | Untuk filter §3.2. |
| Posisi | **Diturunkan**, bukan kolom DB | `"Pengaju"` kalau institusi peserta login = `idinstitusi_pengaju` baris itu, `"Penerima"` kalau = `idinstitusi_mitra`. |
| Status Ajuan | `status_ajuan` | Label dari 5 nilai §1 PRD (`1 Ajuan`, `2 Temu diskusi`, `3 Tunda lain waktu`, `4 Terjalin`, `5 Dibatalkan`). |
| Waktu dan Lokasi | `pertemuan_mou` (gabungan tanggal + sesi + nama ruang) milik pengajuan ini, kalau sudah ada | `"-"` kalau belum pernah dijadwalkan (F21, belum dibahas). |
| Aksi | — | `[TBD]` — isi tombolnya menyusul (kemungkinan "Lihat Detail", dan tombol respon "Temu Diskusi"/"Tunda" khusus untuk Mitra selagi status masih `1 Ajuan` — ini bagian dari pembahasan lanjutan, belum dirinci developer). |

### 3.2 Filter

Di atas tabel, dua filter (client-side, pola `DataTables column().search()` seperti `peserta/mou-list-peserta.blade.php`):

1. **Jenis Institusi** — filter berdasarkan kolom "Jenis Institusi" (jenis institusi lawan).
2. **PIC MoU** — filter berdasarkan kolom "PIC MoU" (nama PIC dari institusi peserta login sendiri) — berguna kalau satu institusi punya beberapa peserta yang masing-masing jadi PIC di pengajuan berbeda.

### 3.3 Tombol "Ajukan MoU Baru"

Tombol di atas tabel, mengarahkan peserta ke **halaman baru** (bukan modal) untuk memulai pengajuan — lihat §4.

## 4. Halaman "Ajukan MoU Baru" (form pengajuan)

### 4.1 Card 1 — Pilih Mitra

Card pertama yang tampil saat halaman dibuka. Berisi tombol **"Pilih Mitra"**.

- Klik tombol → modal **extra large** (`modal-xl`) terbuka, isinya:
  1. **Select 1 — Jenis Institusi**: daftar `jenis_institusi`.
  2. **Select 2 — Institusi** (select2 atau sejenisnya, dependent): opsinya mengikuti pilihan Select 1 — daftar `institusi_asal` dengan `idjenis_institusi` yang cocok, **dikecualikan**:
     - Institusi peserta yang login sendiri (**dikonfirmasi developer**) — institusi tidak bisa mengajukan MoU ke dirinya sendiri.
     - Institusi yang sudah punya `pengajuan_mou` dengan institusi peserta login — **dalam arah mana pun** (institusi itu sebagai Pengaju maupun Mitra terhadap institusi login) — selama `status_ajuan` baris itu **bukan `5` (Dibatalkan)** (**dikonfirmasi developer**, lihat validasi submit di §4.4/§6). Begitu pengajuan lama berstatus Dibatalkan, institusi itu muncul lagi sebagai opsi Mitra.
- Setelah Mitra dipilih dan modal ditutup, Card 1 menampilkan nama institusi Mitra yang terpilih, dan tombol berubah jadi **"Ganti Mitra"** — klik lagi membuka modal yang sama untuk memilih ulang, selama form belum disubmit (**dikonfirmasi developer**).

### 4.2 Pilih PIC (institusi sendiri) — **dikonfirmasi developer**

Berbeda dari asumsi sebelumnya (PIC Pengaju otomatis = pengguna yang submit) — **PIC dipilih manual**, lewat mekanisme yang sama polanya dengan "Pilih Mitra" (§4.1), tapi sumber datanya peserta **institusi sendiri** (bukan institusi lawan):

- Tombol **"Pilih PIC"** (di Card 1 yang sama, atau card terpisah — `[TBD]`).
- Klik tombol → modal **extra large** (`modal-xl`) terbuka, isinya **tabel** daftar peserta dari **institusi yang sama** dengan peserta yang login (pola query `pesertaAktifQuery($idInstitusiAsalLogin)`, sama seperti `peserta/mou-list-peserta.blade.php`). Kolom tabel:

  | Kolom | Sumber |
  |---|---|
  | Nama | `pengguna.nama` |
  | Jabatan | `jabatan.nama_jabatan` (lewat `peserta.idjabatan`) |
  | Aksi | Tombol **"Pilih PIC"** per baris |

- Klik tombol "Pilih PIC" pada salah satu baris → modal tertutup, Card 1 menampilkan nama PIC yang terpilih (`idpic_institusi_pengaju` = `pengguna.idpengguna` peserta itu), dan tombol berubah jadi **"Ganti PIC"** — klik lagi membuka modal yang sama untuk memilih ulang, selama form belum disubmit (**dikonfirmasi developer**, sama pola dengan §4.1).
- **Dikonfirmasi developer**: peserta yang login (pelaku submit) **boleh memilih dirinya sendiri** sebagai PIC — tetap tampil sebagai salah satu baris di tabel modal ini (tidak dikecualikan).
- **Dikonfirmasi developer**: selain tombol "Pilih PIC" di tabel, sediakan juga tombol **"Saya Sendiri"** (di modal, di luar tabel — mis. di atas tabel atau footer modal) — diklik langsung mengisi PIC dengan pengguna yang sedang login tanpa perlu mencari barisnya di tabel.
- **Catatan lingkup**: PIC dari sisi **Mitra** (`idpic_institusi_mitra`) **tidak** dipilih di halaman ini — itu ditentukan nanti di tahap institusi Mitra merespons ajuan (di luar cakupan dokumen ini, lihat §6 poin 2 dan §7).

### 4.3 Menambahkan Catatan dan/atau File

Setelah Mitra dipilih, peserta bisa melampirkan catatan dan/atau file pendukung:

- **Catatan** (maksimal 1 per pengajuan, sesuai §2 `lampiran_mou`): menambahkan card baru berisi **WYSIWYG editor** (pola Quill, sama seperti `isi_review_pameran.isi_review` di F07/F08) untuk mengisi `catatan`.
- **File** (boleh berulang, banyak per pengajuan): menambahkan card baru berisi field teks **"Tujuan File"** (keterangan/judul lampiran) + field unggah file. Validasi: **PDF atau DOCX**, maksimal **5 MB** per berkas.

`[TBD]` mekanisme UI tepatnya menambahkan card-card ini — asumsi **[USULAN AI]**: dua tombol terpisah di bawah Card 1, **"+ Tambah Catatan"** (hilang/disabled setelah dipakai sekali, karena maksimal 1) dan **"+ Tambah File"** (tetap bisa diklik berulang, tiap klik menambah satu card file baru yang bisa dihapus individual sebelum submit).

### 4.4 Submit

Saat form disubmit, dalam satu `DB::transaction` (CONVENTIONS.md §2):

1. Insert satu baris `pengajuan_mou` — `status_ajuan = 1` (Ajuan), `idinstitusi_pengaju` = institusi peserta yang login, `idinstitusi_mitra` = pilihan §4.1, `idpic_institusi_pengaju` = pilihan §4.2, `idpic_institusi_mitra` masih `NULL` (baru terisi nanti saat Mitra merespons — di luar cakupan dokumen ini).
2. Insert satu baris `log_status_mou` — `status = 1`, `idpengajuan_mou` = baris di atas, `done_by` = pengguna yang login, `done_at` = `now()`.
3. Insert baris `lampiran_mou` — satu baris `jenis_lampiran = 2` kalau catatan diisi (isi `catatan` disaring lewat `sanitizeRichText()`, pola F07/F08 §7 CONVENTIONS.md), dan satu baris `jenis_lampiran = 1` per file yang diunggah (`file_path` hasil `Storage::put(...)` di disk non-publik, sesuai CONVENTIONS.md §7). `dikirim_oleh` = institusi peserta yang login.

**Validasi sebelum insert (dikonfirmasi developer)** — cek ulang di server (bukan cuma mengandalkan opsi yang sudah difilter di §4.1, karena opsi itu bisa basi/berubah antara modal dibuka dan form disubmit): tolak submit dengan pesan jelas ("Sudah terdapat pengajuan MoU dengan mitra yang sama.") kalau sudah ada baris `pengajuan_mou` lain antara institusi peserta login dan Mitra yang dipilih — **dalam arah mana pun** (`idinstitusi_pengaju`/`idinstitusi_mitra` tertukar dihitung sama) — dengan `status_ajuan` **selain `5` (Dibatalkan)**. Ini berlaku dua arah: mencegah institusi A mengajukan ke B kalau B→A sudah ada (dan belum dibatalkan), **maupun** A→B diajukan dua kali.

## 5. Validasi

- File lampiran: **tipe PDF atau DOCX**, maksimal **5 MB** per berkas (`mimes:pdf,docx`, `max:5120` di `$request->validate`).
- Mitra wajib dipilih sebelum submit (tidak bisa mengajukan MoU tanpa Mitra).
- Duplikat pasangan institusi (lihat §4.4) — ditolak kalau ada pengajuan lama yang belum Dibatalkan.
- **Dikonfirmasi developer**: Catatan dan file keduanya **opsional** — pengajuan tetap valid hanya dengan Mitra + PIC terisi, tanpa catatan maupun file.

## 6. Pertanyaan terbuka / asumsi AI menunggu konfirmasi

1. **(§4.3)** `idpic_institusi_mitra` diisi **saat Mitra merespons** ajuan (pengguna dari institusi Mitra yang merespons otomatis jadi PIC Mitra, atau dipilih manual seperti §4.2 — belum ditentukan) — perlu dikonfirmasi saat membahas F21/respon Mitra.
2. **(§3.1)** Isi kolom "Aksi" di tabel daftar — tombol apa saja (lihat detail, respon ajuan, batalkan, dst).

## 7. Di luar cakupan (dokumen ini)

- Respon Mitra terhadap ajuan (pilih "Temu Diskusi"/"Tunda lain waktu") — menyusul.
- F21 (penjadwalan pertemuan: tanggal/sesi/ruang) — menyusul.
- F22 (Petugas Ruang MoU, konfirmasi kehadiran) — menyusul.
- F23 (rekap Admin) — menyusul.
- Halaman detail satu pengajuan MoU (riwayat, lampiran) — menyusul.
