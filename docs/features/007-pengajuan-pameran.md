# F07/F08 — Pengajuan Pameran & Review oleh SC

> Melengkapi F07 ("Pengajuan pameran (alur status yang sama) dan penetapan nomor stand") dan F08 ("Review pameran oleh SC") di `PRD.md`.
> `[TBD]` = perlu jawaban/keputusan developer, termasuk perubahan skema DB (AI tidak boleh menebak/mengubah skema sendiri). `[USULAN AI]` = ide tambahan AI, menunggu konfirmasi.
> Status: **spesifikasi lengkap** — semua pertanyaan terbuka sudah dijawab developer (§10 cuma menyisakan usulan AI kecil yang diambil sebagai default). Siap masuk tahap perencanaan implementasi.

## 1. Tujuan

Peserta (lewat satu PIC yang ditunjuk) mengajukan pameran untuk institusinya: isi tema, abstrak, unggah portofolio (PDF/DOC/DOCX), bayar lewat VA BNI, lalu diulas oleh SC sampai diterima/ditolak — dengan alur revisi bolak-balik di antaranya. SC menilai tiap pengajuan lewat **4 kriteria terstruktur** (§7), bukan cuma catatan bebas. **Kerangka tagihan+gerbang pembayaran tetap dibangun di versi awal** (dikonfirmasi developer, §4) — cuma proses request VA ke bank BNI dan verifikasi callback-nya yang dikosongkan dulu (fungsi kosong, diisi developer sendiri belakangan); sampai itu diisi, status lunas diubah manual lewat admin/DB. Pola alur statusnya **sama persis** dengan rencana F05/F06 (pengajuan narasumber) — tabel `narasumber`/`review_narasumber` punya bentuk identik dengan `pameran`/`review_pameran`, jadi keputusan desain di dokumen ini kemungkinan jadi acuan juga saat F05/F06 digarap.

## 2. Tabel yang terlibat (sudah ada di DB)

| Tabel | Peran |
|---|---|
| `peserta` | Sumber pilihan PIC — **dikonfirmasi developer: PIC harus peserta dari institusi (kontingen) yang sama** dengan yang mengajukan (§9). |
| `pameran` | **Satu baris = satu pengajuan pameran** milik satu institusi — **dikonfirmasi developer: satu institusi hanya boleh punya satu pengajuan pameran**. Kolom: `abstract`, `tema` (varchar 255, **kolom baru**, dari `kppti_16.sql`), `nomor_stand`, `idinstitusi_asal`, `idpeserta_PIC` (PIC, **kolom baru**, FK ke `peserta.idpeserta`, dari `kppti_15.sql`), dan `status_ajuan` (char 1) — **cache/denormalisasi** dari status baris `review_pameran` **terakhir**, supaya query daftar tidak perlu join+agregat setiap saat (dikonfirmasi developer). **Catatan teknis**: nama kolom PIC persis `idpeserta_PIC` (huruf besar di akhir) — di PostgreSQL ini identifier yang di-quote, jadi penulisannya di kode (migrasi, query builder) harus **sama persis hurufnya** di setiap tempat, kalau tidak Postgres akan mencari kolom `idpeserta_pic` (huruf kecil) dan gagal ditemukan. |
| `review_pameran` | **Riwayat historis** proses pengajuan — relasi **one-to-many** dari `pameran` (satu pameran punya banyak baris riwayat). Tiap baris = satu "giliran bicara" (peserta submit, atau SC memutuskan): `status_ajuan`, `catatan`, `file_path` (portofolio — **dikonfirmasi developer, cukup di sini**, karena yang direview memang tiap baris `review_pameran`, bukan field tunggal di `pameran`), `created_by` (pengguna yang membuat baris itu — bisa PIC peserta atau SC), `created_at`. **Peserta dan SC "berkomunikasi" lewat riwayat ini** — baik peserta maupun SC bisa melihat seluruh riwayat (dengan aturan visibilitas per status, lihat §6). |
| `topik_review` | **Data master, sudah ada di live DB & seeder** (`TopikReviewSeeder`) — 4 kriteria penilaian tetap: "Sudah Diimplementasikan", "Memiliki Dampak Yang Terukur", "Dapat direplikasi oleh PT/Masyarakat", "Keterlibatan Mitra" (lihat §7). Kolom `status` (boolean) menandai kriteria masih aktif dipakai atau tidak, `petunjuk` (HTML) berisi panduan penilaian per kriteria. **Dikonfirmasi developer: tidak perlu halaman admin untuk mengelola ini** — cukup lewat seeder/DB langsung untuk saat ini. |
| `isi_review_pameran` | **Isi penilaian SC per kriteria, per giliran review** — relasi many-to-one ke `review_pameran` (`idreview`) **dan** `topik_review` (`idtopik_review`). Kolom `isi_review` (catatan SC untuk kriteria itu) dan `memenuhi` (boolean, lolos/tidak kriteria itu). Lihat §7. |
| `pengguna` (role SC, `idrole=4`) | Reviewer — siapa pun dengan role SC aktif bisa **melihat** daftar pengajuan yang masuk (termasuk riwayat lengkap, **dikonfirmasi developer: semua SC bisa lihat read-only**, §5), tapi cuma **satu** yang akhirnya bisa memberi keputusan per pengajuan. |
| `tagihan` / `pembayaran` | Tagihan VA BNI untuk pengajuan ini — `tagihan.idpameran` sudah ada sebagai FK, dipakai sebagai gerbang pembayaran sebelum pengajuan tampil ke SC (§4). Kerangkanya dibangun di versi awal; proses request VA ke BNI & callback-nya fungsi kosong dulu. |

## 3. Status pengajuan (6 nilai, sama seperti di `PRD.md` §6.2)

| id | Nama | Giliran siapa | Bisa dilihat siapa |
|---|---|---|---|
| 1 | Draft | Peserta (sedang menyusun, belum dikirim) | Hanya peserta/sesama kontingen — **SC belum bisa lihat isinya** |
| 2 | Pengajuan | Menunggu SC (peserta sudah kirim) | Peserta (read-only) + semua SC (daftar antrean, **kalau tagihan sudah lunas** — §4) |
| 3 | Review | SC (sedang menyusun keputusan, belum final) | Hanya SC yang mengklaim yang bisa **mengubah**; SC lain + peserta read-only riwayat (§5/§6) |
| 4 | Revisi | Peserta (SC minta perbaikan) | Peserta (bisa edit lagi) + semua SC (read-only, riwayat) |
| 5 | Diterima | — (alur selesai) | Peserta + semua SC (riwayat, read-only) |
| 6 | Ditolak | — (alur selesai) | Peserta + semua SC (riwayat, read-only) |

**Alur** (dikonfirmasi developer, sama seperti `PRD.md` §6.2):

```
1 Draft → 2 Pengajuan → 3 Review → 4 Revisi → 2 Pengajuan → 3 Review → ... → 5 Diterima / 6 Ditolak
          (peserta)      (SC)       (SC)       (peserta)
```

- Draft ⇄ Pengajuan dan Review ⇄ Revisi adalah **transisi**, bukan status yang sama — begitu peserta submit dari Draft, statusnya jadi **Pengajuan** (giliran pindah ke SC). Begitu SC memutuskan "revisi", statusnya jadi **Revisi** (giliran pindah ke peserta); peserta memperbaiki lalu submit ulang → status balik jadi **Pengajuan** (bukan kembali ke Revisi), masuk antrean SC lagi.
- **Draft dan Review tidak memindahkan giliran** — selama masih berstatus Draft, itu tetap "punya" peserta (belum dikirim); selama masih Review, itu tetap "punya" SC yang mengklaim (belum ada keputusan final). Lihat §8 soal bagaimana ini direpresentasikan di `review_pameran` (update baris yang sama vs baris baru).
- Berhenti hanya di **Diterima** atau **Ditolak** — tidak ada siklus lagi setelah itu.
- Nilai `0: penugasan` yang ada di komentar kolom `review_pameran.status_ajuan` (DB) **diabaikan** — dikonfirmasi developer tidak dipakai di alur ini, cukup 1-6.

## 4. Pembayaran VA BNI — gerbang sebelum SC bisa melihat (dikonfirmasi developer — **Opsi B**)

- Begitu peserta **submit pertama kali** (Draft → Pengajuan), sistem menerbitkan tagihan VA BNI (`tagihan` + `idpameran` terisi).
- **Pengajuan baru tampil di halaman SC setelah pembayaran diterima** — sebelum lunas, statusnya tetap `2 Pengajuan` di tabel tapi **disembunyikan dari antrean SC** (query SC: `status_ajuan = '2' AND` tagihan terkait sudah lunas).
- **Dikonfirmasi developer (Opsi B)**: kerangka tagihan + gerbang ini **tetap dibangun sekarang** — cuma **proses request VA ke bank BNI dan verifikasi callback-nya dikosongkan dulu** (fungsi kosong, mis. `BniVirtualAccountService::requestVa()`, route callback `POST /callback/bni-va` — isi logic sungguhan menyusul diisi developer sendiri). Karena belum ada integrasi nyata, **status lunas untuk sementara diubah manual** (lewat admin/DB) sampai integrasi BNI selesai.
- Nominal tagihan pameran — belum ditentukan (tetap untuk semua institusi atau beda per jenis), tidak menghambat pembangunan kerangka ini karena nominal tinggal diisi/diubah kapan saja di kode/konfigurasi.
- **[USULAN AI, diambil sebagai default]** Pembayaran hanya ditagih **sekali** di submission pertama — siklus Revisi → Pengajuan berikutnya **tidak** menagih ulang (tagihan yang sama, sudah lunas, tetap berlaku).

## 5. Klaim review oleh SC — race condition sederhana (dikonfirmasi developer)

- **Semua SC bisa melihat** daftar pengajuan yang **sudah lunas** dan berstatus `2 Pengajuan` (§4).
- **Siapa pun SC yang pertama mengklaim** (membuka dan mulai mengerjakan review) yang berhak memberi keputusan untuk pengajuan itu — **tidak ada penjadwalan/penugasan manual**, murni race condition: siapa cepat dia dapat.
- **[USULAN AI]** Implementasi klaim: `UPDATE pameran SET status_ajuan = '3' WHERE idpameran = ? AND status_ajuan = '2'` (conditional update) — kalau baris ter-update (`affected rows > 0`), SC itu berhasil klaim (lanjut buka form review). Kalau 0 baris (SC lain sudah klaim duluan), tampilkan pesan "Pengajuan ini sudah diambil SC lain" dan redirect balik ke daftar. Ini levelnya "race condition saja" sesuai arahan developer — SC tetap berkoordinasi manual di luar sistem kalau perlu.
- Sekali diklaim (status `3 Review`), SC lain **tidak bisa lagi mengubah** pengajuan itu, tapi **tetap bisa melihat riwayatnya (read-only)** — **dikonfirmasi developer: semua SC bisa melihat read-only**, bukan cuma SC yang mengklaim + peserta.

## 6. Riwayat (`review_pameran`) & visibilitas

- Tiap transisi status yang **final untuk giliran saat itu** (Pengajuan, Revisi, Diterima, Ditolak) menghasilkan **satu baris baru** di `review_pameran` — riwayat lengkap percakapan peserta ⇄ SC, berurutan berdasarkan `created_at`.
- **UI daftar dulu, detail/riwayat kemudian** (dikonfirmasi developer): baik di sisi peserta maupun SC, yang tampil pertama adalah **daftar pengajuan** (ringkas: tema, status, tanggal terakhir) — klik satu baris baru menampilkan **riwayat lengkap** (semua `review_pameran` milik pengajuan itu, urut waktu, termasuk skor 4 kriteria per giliran SC — §7) di halaman/modal detail.
- **Aturan tampil isi terbaru** (dikonfirmasi developer, §3 tabel kolom terakhir):
  - Status **Draft** → isi (abstrak/portofolio draft) hanya terlihat peserta; SC belum bisa lihat sama sekali (baris ini belum pernah mencapai status Pengajuan).
  - Status **Review** → isi draf keputusan SC (catatan & skor kriteria yang sedang diisi, belum disimpan final) hanya terlihat SC yang mengklaim; peserta dan SC lain yang lihat daftar hanya tahu "sedang direview", belum ada catatan/skor baru yang tampil ke mereka.
  - Status lain (Pengajuan, Revisi, Diterima, Ditolak) → riwayat sampai baris terakhir (termasuk skor 4 kriteria giliran itu) boleh dilihat **semua pihak** — peserta + SC mana pun (dikonfirmasi developer, §5).

## 7. Form penilaian SC — 4 kriteria terstruktur (`topik_review` / `isi_review_pameran`)

SC tidak cuma menulis catatan bebas, tapi menilai pengajuan lewat **4 kriteria tetap**, masing-masing dengan catatan dan status lolos/tidak.

- **`topik_review`** — data master 4 kriteria (sudah ditarik dari live DB, migrasi + `TopikReviewSeeder` sudah dibuat):

  | id | nama_topik | Ringkasan `petunjuk` |
  |---|---|---|
  | 1 | Sudah Diimplementasikan | Tujuan, diterapkan di lingkungan nyata, before-after, dokumen implementasi |
  | 2 | Memiliki Dampak Yang Terukur | Output (prototype/produk/program) & outcome (akademik/ekonomi/sosial/institusional/lingkungan) |
  | 3 | Dapat direplikasi oleh PT/Masyarakat | Mudah dipelajari, terdokumentasi, adaptif, biaya, ketergantungan |
  | 4 | Keterlibatan Mitra | Kesiapan modul/SOP/perangkat, peluang kolaborasi, kesiapan mentor/TOT, potensi kemitraan |

  Kolom `status` (boolean) menandai kriteria aktif/tidak dipakai lagi — query form penilaian harus menyaring `status = true` saja. `petunjuk` (HTML list) ditampilkan sebagai panduan di sebelah tiap kriteria saat SC mengisi. **Tidak ada halaman admin untuk kelola kriteria ini** (dikonfirmasi developer) — cukup lewat seeder/DB.

- **`isi_review_pameran`** — isian SC per kriteria, **terikat ke satu baris `review_pameran`** (`idreview`) tertentu — artinya tiap **giliran SC** (satu putaran review yang berakhir dengan Revisi/Diterima/Ditolak) punya **set skor sendiri** (sampai 4 baris `isi_review_pameran`, satu per `topik_review` aktif). Kolom: `isi_review` (catatan SC khusus kriteria itu), `memenuhi` (boolean, lolos/tidak), `created_by` (SC yang mengisi), `created_at`.

  **Konsekuensi**: kalau sebuah pengajuan melalui beberapa putaran review (Revisi berkali-kali), peserta bisa melihat **riwayat skor per kriteria dari tiap putaran** — bukan cuma skor terakhir — selaras dengan §6.

- **Dikonfirmasi developer**: SC **wajib mengisi keempat kriteria lengkap** (catatan + lolos/tidak) untuk **setiap** keputusan — Revisi, Diterima, **maupun** Ditolak. Tidak ada keputusan yang boleh dikirim tanpa skor lengkap.
- **Dikonfirmasi developer**: **peserta boleh melihat breakdown skor per kriteria** (catatan + lolos/tidak masing-masing dari 4 kriteria), bukan cuma catatan umum `review_pameran.catatan` — berlaku di semua giliran yang sudah final (ikut aturan visibilitas §6).

## 8. Draft/Review: update baris yang sama, bukan tambah baris baru (usulan AI, diambil sebagai default)

**[USULAN AI]** — developer bilang "pada status draft dan review alur tidak berpindah, masih tetap pada masing-masing". Untuk menghindari riwayat penuh sampah dari autosave berulang, diusulkan:

- Saat peserta klik **"Simpan Draft"** untuk **pertama kali** pada pengajuan baru (atau mulai revisi baru setelah status Revisi), sistem **insert satu baris baru** `review_pameran` berstatus `1 Draft`, `created_by` = PIC/peserta yang mengedit — **dikonfirmasi developer**: baris `pameran` juga baru dibuat di titik ini (klik "Simpan Draft"), bukan sejak form dibuka.
- Selama masih Draft, **simpan ulang/autosave meng-update baris Draft yang sama itu** (bukan insert baris baru tiap kali disimpan) — baris ini "milik" giliran peserta saat ini.
- Begitu peserta klik **"Ajukan"**, baris yang sama itu **berubah status jadi `2 Pengajuan`** (masih baris yang sama, bukan baris baru) — inilah yang jadi catatan permanen "peserta mengajukan pada waktu X".
- Pola yang sama untuk SC: saat SC mengklaim (§5), sistem **insert baris baru** berstatus `3 Review` (giliran baru punya baris baru, konsisten dengan pola "satu baris per giliran" — baris Pengajuan milik giliran peserta tetap apa adanya sebagai riwayat). Selama SC menyimpan draf keputusan (termasuk draf skor 4 kriteria — `isi_review_pameran` ikut di-update/dihapus-isi-ulang selama masih Review), baris itu di-update terus; begitu SC klik "Kirim Keputusan" (Revisi/Diterima/Ditolak), baris `review_pameran` dan ke-4 baris `isi_review_pameran`-nya berubah jadi final.
- **Konsekuensi**: `review_pameran` tidak pernah punya dua baris berurutan dengan status yang sama persis dalam satu giliran — satu baris per giliran bicara, isinya "final" di titik itu. `pameran.status_ajuan` selalu disinkronkan ke status baris terakhir ini (dikonfirmasi developer, §2).

Diambil sebagai default (§10.2) — kalau ternyata maunya tiap simpan tetap insert baris baru (histori lebih mendetail, termasuk draf-demi-draf), tinggal beri tahu supaya desainnya disesuaikan.

## 9. Siapa yang bisa jadi PIC dan siapa yang bisa mengajukan/mengedit

- **PIC dipilih dari peserta, harus dari institusi (kontingen) yang sama** dengan yang mengajukan (dikonfirmasi developer) — kolom `pameran.idpeserta_PIC` sudah dibuat, validasi PIC lewat `findPesertaInOwnInstitusi` (pola yang sama seperti F03).
- Siapa pun anggota kontingen (bukan cuma PIC yang tercatat) boleh membuka/melanjutkan draft atau mengisi revisi — konsisten pola F03 (anggota kontingen saling membantu mengisi data peserta lain). PIC cuma field "kontak resmi yang ditunjuk", bukan pembatas siapa yang boleh mengedit (diambil sebagai default, §10.1).

## 10. Usulan AI yang diambil sebagai default (belum dibantah, boleh dikoreksi kapan saja)

Poin-poin berikut diambil sebagai default karena tidak dibantah developer saat ditawarkan — tetap bisa dikoreksi kalau ternyata tidak sesuai maksud:

1. **(§9)** Siapa pun anggota kontingen boleh mengedit draft/revisi, bukan cuma PIC yang tercatat — PIC cuma field "kontak resmi", bukan pembatas siapa yang boleh mengedit.
2. **(§8)** Draft/Review meng-update baris `review_pameran` yang sama selama belum final (bukan insert baris baru tiap kali simpan) — baris baru cuma dibuat saat transisi status yang sesungguhnya (Pengajuan/Revisi/Diterima/Ditolak).
3. **(§4)** Pembayaran ditagih sekali di submission pertama saja — siklus Revisi→Pengajuan berikutnya tidak menagih ulang, tagihan yang sama (sudah lunas) tetap berlaku.

**Validasi file portofolio** (dikonfirmasi developer): jenis file **PDF, DOC, dan DOCX** diterima; ukuran maksimum **5 MB** per berkas — cukup sepadan dengan dokumen portofolio berisi teks + beberapa gambar/ilustrasi tanpa membebani storage, konsisten dengan validasi berkas lain di aplikasi (foto peserta `max:10240` KB/10 MB untuk gambar resolusi tinggi; 5 MB untuk dokumen portofolio sudah cukup longgar).

**Penetapan nomor stand** (dikonfirmasi developer): diberikan setelah pengajuan dinyatakan "Diterima" — **detail metode dan alur prosesnya ditangguhkan dulu**, developer sendiri belum mendapat alur detailnya dari panitia. Dibangun belakangan setelah jelas.

**Notifikasi WA** ke peserta saat status berubah (dikonfirmasi developer): **untuk saat ini cukup dilihat manual lewat halaman**, belum perlu notifikasi WA otomatis — developer menyimpan ide ini untuk kemungkinan ditambahkan nanti.

## 11. Di luar cakupan (untuk versi awal)

- **Implementasi nyata** request VA BNI ke bank dan verifikasi callback-nya — disiapkan kerangka/fungsi kosong saja (§4), diisi developer sendiri belakangan. Kerangka tagihan+gerbang "harus lunas" sendiri **tetap dibangun**, bukan di luar cakupan.
- Nominal tagihan pameran yang pasti — belum ditentukan, bisa diisi/diubah kapan saja setelah kerangka jadi.
- Detail alur penetapan nomor stand — ditangguhkan (§10), menunggu alur dari panitia.
- Notifikasi WA otomatis saat status berubah — ditangguhkan (§10), cukup manual untuk sekarang.
- Halaman admin kelola `topik_review` — tidak dibangun, cukup seeder/DB (§7).
- F12 (Petugas jaga stand pameran) — fitur terpisah, dibangun setelah F07/F08 selesai.
- Dashboard/rekap jumlah pengajuan pameran (kemungkinan bagian F13) — tidak dibahas di sini.

## 12. Migrasi & seeder yang sudah dibuat

- Migrasi `create_topik_review_table` dan `create_isi_review_pameran_table` — kedua tabel sudah ada di live DB (dari `kppti_14.sql`), migrasi **ditandai *applied*** (insert manual ke tabel `migrations`), bukan dijalankan ulang. Diverifikasi lewat migrasi fresh di database sementara, strukturnya sama persis dengan live DB (kolom, tipe, FK).
- `TopikReviewSeeder` — isi 4 baris kriteria (§7), ditarik persis dari data live (ejaan "Dapat" sudah dibetulkan developer langsung di database, seeder disesuaikan mengikuti), pola `insertOrIgnore` + `syncSequence` seperti seeder lain, didaftarkan di `DatabaseSeeder`.
- Migrasi `add_idpeserta_pic_to_pameran_table` — kolom `idpeserta_PIC` (FK ke `peserta.idpeserta`) sudah ada di live DB (dari `kppti_15.sql`), **ditandai *applied***, diverifikasi sama persis lewat migrasi fresh (termasuk nama kolom dengan huruf besar di akhir).
- Migrasi `add_tema_to_pameran_table` — kolom `tema` (varchar 255) sudah ada di live DB (dari `kppti_16.sql`), **ditandai *applied***, diverifikasi sama persis lewat migrasi fresh.

Dokumen ini **siap dijadikan acuan implementasi**.
