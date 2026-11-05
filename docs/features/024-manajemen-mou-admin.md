# F24 — Manajemen MoU oleh Admin (menu "Pengajuan MoU")

> Melengkapi F24 di `PRD.md` §5, bagian "Sisi Admin (F24)" di §6.4.
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide/asumsi AI, menunggu konfirmasi.
> **Status: spesifikasi lengkap** — semua pertanyaan terbuka sudah dijawab developer. Siap masuk tahap perencanaan implementasi.

## 1. Menu & role

Role **Admin** (`idrole` 1), menu baru **"Pengajuan MoU"** dengan 4 submenu: **Sesi MoU**, **Ruang MoU**, **Tanggal MoU**, **Pertemuan MoU**.

## 2. Submenu "Sesi MoU" — lihat saja

Halaman menampilkan isi tabel `sesi_mou` (`idsesi_mou`, `jam_mulai`, `jam_akhir`). **View only** — developer secara eksplisit hanya minta "melihat", tidak ada tambah/edit/hapus di submenu ini.

## 3. Submenu "Ruang MoU" — lihat saja

Halaman menampilkan isi tabel `ruang_mou` (`idruang_mou`, `nama_ruang`, `kapasitas`). **View only**, sama seperti Sesi MoU.

## 4. Submenu "Tanggal MoU" — lihat, tambah, soft delete

- Halaman menampilkan isi tabel `tanggal_mou` (`idtanggal_mou`, `tanggal`, `status`).
- Admin bisa **menambah tanggal baru** (form input tanggal → insert `status = true`).
- Admin bisa **soft delete** — memakai kolom `status` yang sudah ada di tabel ini (set `false`), **bukan** menghapus baris secara fisik. Tanggal yang di-nonaktifkan otomatis tidak lagi dipakai `GenerateSlotPertemuanMou` (yang memfilter `where('status', true)`, lihat `app/Console/Commands/GenerateSlotPertemuanMou.php`).
- **Dikonfirmasi developer**: tanggal yang `status = false` **tetap ditampilkan** di tabel dengan badge "Nonaktif", dengan tombol **"Aktifkan Lagi"** untuk mengembalikan `status = true`.
- **Dikonfirmasi developer**: soft delete **diblokir total** kalau tanggal itu masih punya `pertemuan_mou` dengan booking aktif (`idpengajuan_mou` terisi) — tampilkan pesan jelas kenapa ditolak (mis. "Tidak bisa dinonaktifkan, masih ada N pertemuan terjadwal di tanggal ini."). Tombol nonaktifkan baru bisa dipakai setelah semua booking di tanggal itu selesai/dibatalkan.
- **Dikonfirmasi developer**: `tanggal` **harus unik** — submit tanggal yang sudah ada di tabel (termasuk yang statusnya nonaktif) ditolak dengan pesan jelas (409).

## 5. Submenu "Pertemuan MoU" — matrix slot (paling kompleks)

### 5.1 Filter

- **Filter 1 — Tanggal MoU**: select, hanya tanggal yang `status` aktif, **wajib pilih satu**.
- **Filter 2 — Ruang**: select, **satu ruang spesifik** — **tidak ada opsi "Semua Ruang"** (ditegaskan developer secara eksplisit).
- Matrix baru ditampilkan setelah kedua filter terisi.

### 5.2 Tampilan matrix

- **Kolom** = nomor meja, diambil dari `pertemuan_mou.isi_ke` (rentang `1..kapasitas` ruang yang dipilih).
- **Baris** = `sesi_mou`, label `jam_mulai`–`jam_akhir` ditampilkan **jam:menit saja** (`substr(..., 0, 5)`, bukan termasuk detik) — pola sama seperti kolom "Waktu dan Lokasi" di `peserta/mou-pengajuan.blade.php`.
- **Isi sel** (kombinasi tanggal+ruang+sesi+meja) — **dikonfirmasi developer**:
  - **Available** (`idpengajuan_mou IS NULL`, baris sudah ada) → tampil badge hijau "Kosong".
  - **Terisi** (`idpengajuan_mou` terisi) → tampil badge merah + **nama institusi Pengaju, nama institusi Mitra, beserta PIC masing-masing** (dari `pengajuan_mou` + join `pengguna` untuk PIC) — cukup ringkas untuk dibaca langsung di sel tanpa klik, mirip data yang sudah ditampilkan di `peserta/mou-pengajuan-detail.blade.php`.
  - **Belum ada baris sama sekali** di `pertemuan_mou` untuk kombinasi itu → sel kosong/strip (`-`) — inilah yang nanti diisi oleh tombol "Sesuaikan Slot" (§5.3).

### 5.3 Tombol "Sesuaikan Slot"

Di atas matrix.

- Reuse logika yang sama dengan Artisan command `GenerateSlotPertemuanMou` (sudah ada), tapi **dipersempit** ke tanggal+ruang yang sedang difilter saja (bukan generate semua tanggal+ruang sekaligus seperti command-nya) — kemungkinan diekstrak jadi method/service bersama supaya tidak duplikasi logika antara command dan controller admin.
- Untuk setiap `sesi_mou` (semua sesi — filter halaman ini cuma tanggal+ruang, bukan sesi), tambahkan baris `pertemuan_mou` yang belum ada sampai jumlah baris per (tanggal, ruang, sesi) = `kapasitas` ruang tersebut.
- **Idempoten** — kombinasi yang sudah ada dilewati (tidak insert ulang, dan **tidak pernah menghapus/mengubah** baris yang sudah terisi booking).
- Setelah proses: tampilkan notifikasi (SweetAlert2) **jumlah slot yang ditambahkan** — bisa **0** kalau sudah lengkap/sesuai. Matrix di-refresh (reload data) setelah proses selesai.

## 6. Tabel yang terlibat (sudah ada di DB, migrasi sudah dibuat)

| Tabel | Peran |
|---|---|
| `sesi_mou` | Data master jam sesi — submenu Sesi MoU (lihat saja). |
| `ruang_mou` | Data master ruang + kapasitas meja — submenu Ruang MoU (lihat saja), dan penentu jumlah kolom matrix di Pertemuan MoU. |
| `tanggal_mou` | Data master tanggal — submenu Tanggal MoU (lihat, tambah, soft delete via kolom `status`), dan penentu baris mana yang bisa dipilih di filter Pertemuan MoU. |
| `pertemuan_mou` | Slot pertemuan (tanggal+sesi+ruang+meja/`isi_ke`) — kosong (`idpengajuan_mou IS NULL`) berarti available, terisi berarti sudah dibooking peserta (F21, di luar cakupan dokumen ini). Diisi/dilengkapi lewat tombol "Sesuaikan Slot" §5.3. |

## 7. Validasi

- Tambah tanggal MoU: `tanggal` wajib diisi (`required`, `date`).
- Filter Ruang di submenu Pertemuan MoU: wajib pilih satu (`required`), tidak ada nilai "semua".
- Tombol "Sesuaikan Slot": tidak boleh menghapus/mengubah baris yang sudah punya `idpengajuan_mou` terisi — hanya menambah baris baru untuk slot yang belum ada.

## 8. Keputusan yang sudah dikonfirmasi developer

1. **(§4)** Tanggal yang di-soft-delete tetap tampil di tabel dengan badge "Nonaktif" + tombol "Aktifkan Lagi".
2. **(§4)** Soft delete tanggal yang masih punya booking aktif **diblokir total** — bukan diperingatkan, bukan diizinkan.
3. **(§4)** `tanggal` harus **unik** di tabel `tanggal_mou`.
4. **(§5.2)** Sel matrix yang terisi booking menampilkan nama institusi Pengaju, nama institusi Mitra, **dan PIC masing-masing**.
5. Submenu "Pertemuan MoU" ini **khusus untuk Admin** (kelola slot/kapasitas) — **F22 (Petugas Ruang MoU) akan punya halaman terpisah** untuk mencatat kehadiran, bukan reuse halaman ini.

## 9. Di luar cakupan (dokumen ini)

- Proses booking pertemuan oleh peserta (F21) — peserta-side, dibahas terpisah.
- Edit/hapus data `sesi_mou` dan `ruang_mou` — developer hanya minta "lihat" untuk 2 submenu ini; kalau nanti perlu diedit, itu perubahan terpisah yang perlu dikonfirmasi dulu (termasuk dampaknya ke slot yang sudah digenerate).
- Halaman Petugas Ruang MoU (F22) — role dan halaman terpisah, dibahas tersendiri nanti (dikonfirmasi §8 poin 5).

Dokumen ini **siap dijadikan acuan implementasi**.
