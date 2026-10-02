# F09 — Manajemen Acara/Sesi oleh Admin

> Melengkapi F09 di `PRD.md` ("Manajemen acara/sesi (bertingkat, per hari dan jam) oleh admin").
> `[TBD]` = perlu jawaban/keputusan developer. `[USULAN AI]` = ide tambahan AI, menunggu konfirmasi.
> Status: **spesifikasi lengkap** (semua pertanyaan terbuka sudah dijawab, lihat §8) — menunggu kata "mulai" dari developer sebelum coding dimulai.

## 1. Tujuan

Admin mengelola daftar acara/sesi KPPTI 2026 lewat tabel `acara` yang **bertingkat** (self-referencing lewat `idparent_acara`): satu acara bisa jadi **payung/sesi paralel** yang menaungi beberapa **acara anak** (pilihan di dalamnya, berlangsung bersamaan di tempat/topik berbeda).

**Dikonfirmasi developer**: makna hierarki adalah **"acara induk = sesi paralel/payung, acara anak = pilihan-pilihan di dalamnya"** — contoh: "Sesi Paralel 1 (13:00–15:00)" sebagai induk, dengan beberapa anak acara yang berlangsung bersamaan di ruangan berbeda, masing-masing anak punya tema/narasumber sendiri. Field `hari_ke`/`jam_mulai`/`jam_akhir` diisi di level mana pun yang relevan (induk maupun anak bisa punya jam sendiri — tidak dipaksa kosong di salah satu level).

## 2. Skema tabel (sudah ada, tidak ada migrasi skema baru untuk fitur ini)

Tabel `acara` (migrasi awal `2025_01_01_000011_create_acara_table`, ditambah kolom lewat beberapa migrasi baru — semua sudah ada di database live, migrasi ditandai *applied*, bukan dijalankan ulang: `2026_10_01_094404_add_status_to_acara_table`, `2026_10_01_224932_add_ruang_to_acara_table`, `2026_10_02_035742_add_opsi_pilih_to_acara_table`):

| Kolom | Tipe | Keterangan |
|---|---|---|
| `idacara` | bigint, PK | |
| `has_child` | boolean, nullable | **Dikonfirmasi developer: dihitung otomatis oleh sistem**, bukan diisi manual — lihat §4. |
| `idparent_acara` | bigint, nullable, FK → `acara.idacara` | Null = acara tingkat atas (bisa jadi payung atau acara mandiri tanpa anak). |
| `tema` | text, nullable | Judul/tema acara. |
| `ruang` | varchar(100), nullable, **baru** | Nama ruang/lokasi acara berlangsung — diisi manual oleh admin, teks bebas. |
| `opsi_pilih` | char(1), nullable, **baru** | **Dikonfirmasi developer** — menentukan apakah acara ini bisa dipilih peserta (relevan untuk **F10**, "peserta memilih acara"): `1` = tidak bisa dipilih (none), `2` = opsional, `3` = wajib dipilih. Wajib diisi admin saat tambah/edit (select, default `1`). |
| `speaker` | text, nullable | Nama pembicara **tetap/fixed**, diisi manual oleh admin — **hanya dipakai kalau `perlu_narsum = false`** (lihat §3.1). |
| `hari_ke` | smallint, nullable | Hari ke berapa (1, 2, 3, dst). |
| `jam_mulai` / `jam_akhir` | time, nullable | |
| `perlu_narsum` | boolean, nullable | **Menentukan sumber nama pembicara** — lihat §3.1: `false` = pembicara tetap (isi `speaker` manual), `true` = pembicara berasal dari alur pengajuan narasumber (F05/F06), lewat tabel penghubung `narasumber_acara` (lihat §2.2). |
| `status` | boolean, nullable, **baru** | **Dikonfirmasi developer**: dipakai untuk **soft delete** — `true`/`null` = aktif (tampil normal), `false` = "dihapus" (disembunyikan dari tampilan normal, datanya tetap ada). Sama semangatnya dengan `pengguna.is_deleted`, hanya polaritasnya dibalik. |

> **Riwayat skema**: sempat ada kolom `acara.idnarasumber` (FK tunggal ke `narasumber`) yang ditambahkan lalu **dihapus lagi** (migrasi `2026_10_01_095744_add_idnarasumber_to_acara_table` ditimpa oleh `2026_10_02_005748_drop_idnarasumber_from_acara_table`), digantikan skema many-to-many di §2.2 begitu diketahui satu acara bisa punya **lebih dari satu** narasumber sekaligus.

### 2.1 `perlu_narsum`: dua model pembicara (dikonfirmasi developer)

- **`perlu_narsum = false`** — acara dengan pembicara **tetap/fixed**, bukan hasil pengajuan. Admin mengetik nama pembicara langsung ke kolom `speaker` (teks bebas) lewat form F09 ini.
- **`perlu_narsum = true`** — pembicara **berasal dari tabel `narasumber`** yang statusnya **diterima** (`narasumber.status_ajuan = 5`), dihubungkan lewat tabel `narasumber_acara` (§2.2) — **bisa lebih dari satu narasumber untuk satu acara**, masing-masing dengan sub-temanya sendiri (`narasumber.subtema`). Penghubungan ini bagian dari alur **F06** (SC menerima pengajuan narasumber) — **di luar cakupan F09**. Di halaman F09, field ini ditampilkan **read-only**: daftar nama + sub-tema tiap narasumber yang sudah diterima untuk acara ini, atau keterangan "Menunggu hasil review narasumber" kalau belum ada. Admin **tidak bisa mengetik/memilih/menautkan** narasumber manual untuk acara jenis ini di F09.

### 2.2 Tabel `narasumber_acara` (baru, migrasi `2026_10_02_005750_create_narasumber_acara_table`) & `narasumber.subtema` (baru, migrasi `2026_10_02_005749_add_subtema_to_narasumber_table`)

Laporan dari unit kerja terkait: **ada acara yang punya 3 pembicara sekaligus, masing-masing dengan sub-tema sendiri** — satu `idnarasumber` tunggal per acara tidak cukup, sehingga dibuat tabel penghubung many-to-many:

| Tabel/Kolom | Tipe | Keterangan |
|---|---|---|
| `narasumber_acara.idnarasumber_acara` | integer, PK | |
| `narasumber_acara.idacara` | bigint, nullable, FK → `acara.idacara` | |
| `narasumber_acara.idnarasumber` | integer, nullable, FK → `narasumber.idnarasumber` | |
| `narasumber_acara.status` | boolean, default `true` | Menandai apakah tautan ini masih aktif (dikelola oleh F06, bukan F09). |
| `narasumber.subtema` | text, nullable | Sub-tema/topik spesifik milik narasumber tsb dalam acara itu (berbeda dari `acara.tema` yang jadi payung bersama). |

F09 **hanya membaca** data ini (join `narasumber_acara` → `narasumber` → `pengguna`, filter `narasumber_acara.status = true` dan `narasumber.status_ajuan = 5`) untuk ditampilkan di tabel & modal — **tidak** membuat/mengubah baris di `narasumber_acara` maupun `narasumber.subtema` (itu wewenang F06).

## 3. Di luar cakupan (out of scope)

- **Pengajuan & review narasumber sungguhan** (tabel `narasumber`, `review_narasumber` — alur draft→pengajuan→review→revisi→diterima/ditolak, termasuk pengisian `narasumber_acara` saat SC menerima pengajuan) adalah **F05/F06**, fitur terpisah. F09 hanya **membaca** `narasumber_acara`/`narasumber.subtema` (read-only, lihat §2.1–§2.2) dan mengelola `speaker`/`perlu_narsum`/`ruang` di tabel `acara` — **tidak** membuat/mengubah baris di tabel `narasumber`/`narasumber_acara`/`review_narasumber`.
- **Peserta memilih acara** (tabel `peserta_acara`) adalah **F10**, terpisah.
- Tidak ada perubahan ke `review_narasumber`/`narasumber`/`peserta_acara` di fitur ini.

## 4. `has_child` — dihitung otomatis

**Dikonfirmasi developer**: dihitung dari anak yang **aktif saja**. Server yang menjaga nilai ini tetap sinkron (admin tidak pernah mengisinya langsung lewat form):
- Saat acara anak baru ditambahkan (aktif) dengan `idparent_acara = X` → set `acara.has_child = true` pada baris `X`.
- Saat acara anak di bawah `X` dihapus (soft delete, status jadi `false`) atau dipindah parent-nya → hitung ulang: `has_child = (jumlah anak dengan status aktif pada X) > 0`.

## 5. Hapus acara: tolak kalau masih ada anak aktif, tapi soft delete

**Dikonfirmasi developer**:
1. **Soft delete**, bukan `DELETE` SQL — set `status = false`, data tetap ada di database.
2. **Tolak** aksi hapus kalau acara tersebut **masih punya sub-acara (anak) yang aktif** (anak yang sudah di-soft-delete tidak dihitung, boleh lanjut hapus induknya) — pesan jelas, mis. "Acara ini masih punya N sub-acara aktif, hapus/pindahkan dulu semua sub-acaranya."
3. Semua query tampilan (`index`, dropdown pilih parent, dst.) **menyaring `status` aktif**, sama seperti pola `pengguna.is_deleted` yang sudah ada.

## 6. Alur & UI

**Dikonfirmasi developer** (setuju dengan usulan):
- Halaman baru di area Admin: `resources/views/admin/acara.blade.php`, controller baru **`AcaraController`** (dedicated, mengikuti pola `PesertaController` — bukan ditumpuk ke `AdminController` yang sudah besar), rute di `routes/admin.php` dengan middleware `akses:1` (**hanya Admin** — dikonfirmasi developer, SC belum dibahas, akses SC menyusul kalau diperlukan nanti).
- **Tampilan**: daftar acara tingkat atas (`idparent_acara IS NULL`) sebagai baris utama, bisa di-expand (ikon panah, pola accordion/collapse Bootstrap) untuk menampilkan anak-anaknya secara nested, dikelompokkan/diurutkan per `hari_ke` lalu `jam_mulai`.
- **Tambah/Edit acara** lewat modal (pola sama seperti `admin-users.blade.php`/`sekontingen.blade.php`):
  - Field selalu ada: `tema`, `ruang`, `opsi_pilih` (select: Tidak Bisa Dipilih/Opsional/Wajib, wajib diisi, default "Tidak Bisa Dipilih"), `hari_ke`, `jam_mulai`, `jam_akhir`, `perlu_narsum` (toggle/checkbox), `idparent_acara` (select, hanya untuk acara baru yang jadi anak — lihat §7).
  - **Field dinamis mengikuti `perlu_narsum`** (lihat §2.1): `perlu_narsum = false` → tampilkan input teks `speaker` (wajib diisi kalau opsi ini dipilih). `perlu_narsum = true` → `speaker` disembunyikan, diganti tampilan read-only **daftar** narasumber (nama + sub-tema, bisa lebih dari satu — join `narasumber_acara` → `narasumber` → `pengguna.nama`), atau teks "Menunggu hasil review narasumber" kalau belum ada yang diterima.
- **Hapus** lewat tombol + **SweetAlert2 konfirmasi** (bukan modal teks — data acara, bukan data pribadi peserta), ditolak di server kalau masih punya anak aktif (§5).
- Validasi server: `jam_akhir` harus setelah `jam_mulai` (kalau keduanya diisi), `hari_ke` berupa angka positif, `speaker` wajib kalau `perlu_narsum = false`.

## 7. Kedalaman hierarki: 2 level

**Dikonfirmasi developer**: dibatasi **2 level saja** — acara tingkat atas → anak langsung, anak **tidak boleh** punya anak lagi. Di form tambah/edit, pilihan `idparent_acara` hanya menampilkan acara yang **tidak** punya `idparent_acara` sendiri (acara tingkat atas), supaya kedalaman otomatis terjaga tanpa perlu pengecekan rekursif.

## 8. Status keputusan

Semua poin yang sebelumnya terbuka **sudah diputuskan** developer:

- **`has_child`** (§4): dihitung otomatis dari anak **aktif saja**.
- **Hapus** (§5): soft delete (`status = false`), ditolak kalau masih ada anak **aktif**.
- **Kedalaman** (§7): dibatasi 2 level.
- **UI** (§6): sesuai usulan (accordion per acara tingkat atas, dikelompokkan per hari+jam).
- **Akses** (§6): hanya Admin (`akses:1`) untuk saat ini.
- **Model pembicara** (§2.1–§2.2): `perlu_narsum=false` → `speaker` teks manual; `perlu_narsum=true` → daftar narasumber (bisa banyak, tiap orang punya sub-tema sendiri) lewat `narasumber_acara`, read-only di F09, diisi otomatis lewat alur F06.

Dokumen ini siap dijadikan acuan implementasi.
