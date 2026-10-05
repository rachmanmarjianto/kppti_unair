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
| `pameran` | **Satu baris = satu pengajuan pameran** milik satu institusi — **dikonfirmasi developer: satu institusi hanya boleh punya satu pengajuan pameran**. Kolom: `abstract`, `tema` (varchar 255, dari `kppti_16.sql`), `nomor_stand`, `idinstitusi_asal`, `idpeserta_PIC` (PIC, FK ke `peserta.idpeserta`, dari `kppti_15.sql`), `direview_oleh` (**kolom baru**, dari `kppti_17.sql`, FK ke `pengguna.idpengguna` — SC yang mengklaim pengajuan ini; `NULL` berarti belum diklaim siapa pun, lihat §5), dan `status_ajuan` (char 1) — **cache/denormalisasi** dari status baris `review_pameran` **terakhir**, supaya query daftar tidak perlu join+agregat setiap saat (dikonfirmasi developer). **Catatan teknis**: nama kolom PIC persis `idpeserta_PIC` (huruf besar di akhir) — di PostgreSQL ini identifier yang di-quote, jadi penulisannya di kode (migrasi, query builder) harus **sama persis hurufnya** di setiap tempat, kalau tidak Postgres akan mencari kolom `idpeserta_pic` (huruf kecil) dan gagal ditemukan. |
| `review_pameran` | **Riwayat historis** proses pengajuan — relasi **one-to-many** dari `pameran` (satu pameran punya banyak baris riwayat). Tiap baris = satu "giliran bicara" peserta: `status_ajuan`, `catatan`, `file_path` (portofolio — **dikonfirmasi developer, cukup di sini**, karena yang direview memang tiap baris `review_pameran`, bukan field tunggal di `pameran`), `created_by`, `created_at`. **Revisi desain (dikonfirmasi developer)**: baris ini **hanya pernah dibuat oleh peserta** (saat submit/revisi) — SC **tidak pernah insert baris baru**; SC mengisi penilaiannya ke `isi_review_pameran` (lihat baris di bawah) dan **meng-update `status_ajuan` baris yang sama** ini saat memberi keputusan (Revisi/Diterima/Ditolak). Lihat §5/§8. |
| `topik_review` | **Data master, sudah ada di live DB & seeder** (`TopikReviewSeeder`) — 4 kriteria penilaian tetap: "Sudah Diimplementasikan", "Memiliki Dampak Yang Terukur", "Dapat direplikasi oleh PT/Masyarakat", "Keterlibatan Mitra" (lihat §7). Kolom `status` (boolean) menandai kriteria masih aktif dipakai atau tidak, `petunjuk` (HTML) berisi panduan penilaian per kriteria. **Dikonfirmasi developer: tidak perlu halaman admin untuk mengelola ini** — cukup lewat seeder/DB langsung untuk saat ini. |
| `isi_review_pameran` | **Isi penilaian SC per kriteria, per giliran review** — relasi many-to-one ke `review_pameran` (`idreview`) **dan** `topik_review` (`idtopik_review`). Kolom `isi_review` (catatan SC untuk kriteria itu) dan `memenuhi` (boolean, lolos/tidak kriteria itu). Lihat §7. |
| `pengguna` (role SC, `idrole=4`) | Reviewer — siapa pun dengan role SC aktif bisa **melihat** daftar pengajuan yang masuk (termasuk riwayat lengkap, **dikonfirmasi developer: semua SC bisa lihat read-only**, §5), tapi cuma **satu** yang akhirnya bisa memberi keputusan per pengajuan. |
| `tagihan` / `pembayaran` | Tagihan VA BNI untuk pengajuan ini — `tagihan.idpameran` sudah ada sebagai FK, dipakai sebagai gerbang pembayaran sebelum pengajuan tampil ke SC (§4). Kerangkanya dibangun di versi awal; proses request VA ke BNI & callback-nya fungsi kosong dulu. |

## 3. Status pengajuan (6 nilai, sama seperti di `PRD.md` §6.2)

| id | Nama | Giliran siapa | Bisa dilihat siapa |
|---|---|---|---|
| 1 | Draft | Peserta (sedang menyusun, belum dikirim) | Hanya peserta/sesama kontingen — **SC belum bisa lihat isinya** |
| 2 | Pengajuan | Menunggu SC (peserta sudah kirim) — **termasuk selagi sudah diklaim tapi belum ada draf review tersimpan**, lihat catatan di bawah | Peserta (read-only) + semua SC (daftar antrean, **kalau tagihan sudah lunas** — §4) |
| 3 | Review | SC yang mengklaim (sedang menyusun keputusan — sudah pernah "Simpan Draft Review" minimal sekali, belum final) | Hanya SC yang mengklaim yang bisa **mengubah**; SC lain + peserta read-only (belum lihat skor, §6) |
| 4 | Revisi | Peserta (SC minta perbaikan) | Peserta (bisa edit lagi) + semua SC (read-only, riwayat) |
| 5 | Diterima | — (alur selesai) | Peserta + semua SC (riwayat, read-only) |
| 6 | Ditolak | — (alur selesai) | Peserta + semua SC (riwayat, read-only) |

**Alur** (direvisi developer — lihat §5/§8 untuk mekanisme klaim/penilaian terbaru):

```
1 Draft → 2 Pengajuan → 3 Review → 4 Revisi → 2 Pengajuan → 3 Review → ... → 5 Diterima / 6 Ditolak
          (peserta)      (SC)        (SC)        (peserta)
```

> **Catatan (revisi developer)**: baris `review_pameran` dibuat peserta berstatus `2` begitu diajukan. Saat SC **mengklaim** (§5), **cuma `pameran.direview_oleh` yang terisi** — baris itu masih `2` (ada jeda sempit "sudah diklaim tapi belum ada draf tersimpan"). Begitu SC **menyimpan draf penilaian pertama kalinya** ("Simpan Draft Review"), baris `review_pameran` **dan** `pameran` sama-sama pindah ke `3 Review`, dan SC bisa terus menyimpan ulang draf itu (skor 4 kriteria + catatan) sepanjang masih `3` — baru berubah jadi `4`/`5`/`6` saat SC mengirim keputusan final. Beda dari desain lama: baris `3` ini **bukan baris baru**, tetap baris yang sama yang dibuat peserta (lihat §8).

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
- **Bug UI yang diperbaiki (ditemukan developer)**: badge status utama di halaman peserta **harus selalu menampilkan nama status mentah** (`status_ajuan`, 6 nilai persis §3) — sebelumnya status `2` ditampilkan sebagai "Menunggu Pembayaran / Antrean Review", mencampur status pengajuan dengan status tagihan. Status pembayaran sekarang **komponen terpisah** (badge sendiri, dari `tagihan.status`: Tertagih/Terbayar Sebagian/Lunas/Batal), dan konfirmasi dialog tombol "Ajukan" **cuma menyinggung pembayaran kalau ini submission pertama** (tagihan belum ada) — siklus Revisi→Pengajuan ulang tidak lagi menampilkan peringatan pembayaran karena tagihan yang sama (sudah lunas) dipakai ulang, bukan ditagih lagi.
- **Bug lain yang diperbaiki**: tombol "Ajukan" dulu mengharuskan klik "Simpan Draft" dulu (gagal 422 "Tidak ada draf yang bisa diajukan" kalau langsung diklik dari status Revisi tanpa simpan draf dulu) — sekarang "Ajukan" otomatis menyimpan draf (abstrak + portofolio) dulu di belakang layar sebelum mengajukan, jadi bisa langsung diklik tanpa langkah simpan draf terpisah.

## 5. Klaim review oleh SC — race condition lewat `pameran.direview_oleh` (direvisi developer)

- **Semua SC bisa melihat** daftar pengajuan yang **sudah lunas** dan berstatus `2 Pengajuan` (§4).
- **Siapa pun SC yang pertama mengklaim** yang berhak memberi keputusan untuk pengajuan itu — **tidak ada penjadwalan/penugasan manual**, murni race condition: siapa cepat dia dapat.
- **Implementasi klaim (direvisi developer)**: klaim **hanya mengisi kolom `pameran.direview_oleh`**, tidak membuat baris `review_pameran` baru dan tidak mengubah `status_ajuan` di tabel mana pun — `UPDATE pameran SET direview_oleh = ? WHERE idpameran = ? AND status_ajuan = '2' AND direview_oleh IS NULL` (conditional update). Kalau baris ter-update (`affected rows > 0`), SC itu berhasil klaim. Kalau 0 baris (SC lain sudah klaim duluan), tampilkan pesan "Pengajuan ini sudah diambil SC lain". Ini levelnya "race condition saja" sesuai arahan developer — SC tetap berkoordinasi manual di luar sistem kalau perlu.
- Sekali diklaim (`direview_oleh` terisi), SC lain **tidak bisa lagi mengubah** pengajuan itu (baik mengisi `isi_review_pameran` maupun mengirim keputusan), tapi **tetap bisa melihat riwayatnya (read-only)** — **dikonfirmasi developer: semua SC bisa melihat read-only**, bukan cuma SC yang mengklaim + peserta. Lihat §6 untuk apa yang disembunyikan selama diklaim.
- Begitu SC menyimpan draf penilaian pertamanya lewat "Simpan Draft Review", `status_ajuan` baris `review_pameran` (dan `pameran`) berubah jadi `3 Review` — SC bisa terus menyimpan ulang draf itu berkali-kali selama masih `3`, sampai akhirnya mengirim satu dari 3 keputusan (§7/§8).
- **`direview_oleh` dikosongkan lagi** (`NULL`) begitu keputusan **Revisi** dikirim — supaya giliran revisi berikutnya bisa diklaim SC mana pun lagi (termasuk SC yang berbeda dari sebelumnya). Untuk keputusan **Diterima**/**Ditolak**, `direview_oleh` **tetap** terisi (jadi catatan permanen "SC mana yang memutuskan").

## 6. Riwayat (`review_pameran`) & visibilitas

- Tiap transisi status yang **final untuk giliran saat itu** (Pengajuan, Revisi, Diterima, Ditolak) menghasilkan **satu baris baru** di `review_pameran`, **dibuat oleh peserta** — riwayat lengkap percakapan peserta ⇄ SC, berurutan berdasarkan `created_at`. SC tidak pernah menambah baris; SC mengisi `isi_review_pameran` untuk baris yang sudah ada dan mengubah `status_ajuan`-nya saat memberi keputusan (direvisi developer, §5/§8).
- **UI daftar dulu, detail/riwayat kemudian** (dikonfirmasi developer): baik di sisi peserta maupun SC, yang tampil pertama adalah **daftar pengajuan** (ringkas: tema, status, tanggal terakhir) — klik satu baris/tombol "Lihat Detail" menampilkan **riwayat lengkap** (semua `review_pameran` milik pengajuan itu, urut waktu, termasuk skor 4 kriteria per giliran SC — §7) di halaman detail terpisah, tersusun 2 card: data pengajuan (`pameran`) dan riwayat review (`review_pameran`, accordion). Tombol "Beri Review" ditaruh di item accordion baris yang sedang aktif direview, bukan di header card.
- **Aturan tampil isi terbaru** (direvisi developer):
  - Status **Draft** → isi (abstrak/portofolio draft) hanya terlihat peserta; SC belum bisa lihat sama sekali (baris ini belum pernah mencapai status Pengajuan).
  - Baris berstatus **Pengajuan (`2`) yang sudah diklaim** atau **Review (`3`)** → isi draf penilaian SC (`isi_review_pameran`, belum final) hanya terlihat SC yang mengklaim (`direview_oleh` cocok dengan SC yang login); peserta dan SC lain cuma lihat badge "Sedang Direview", belum ada skor yang tampil ke mereka.
  - Status lain (Pengajuan yang belum diklaim, Revisi, Diterima, Ditolak) → riwayat sampai baris terakhir (termasuk skor 4 kriteria giliran itu) boleh dilihat **semua pihak** — peserta + SC mana pun (dikonfirmasi developer, §5).

## 7. Form penilaian SC — 4 kriteria terstruktur (`topik_review` / `isi_review_pameran`)

SC tidak cuma menulis catatan bebas, tapi menilai pengajuan lewat **4 kriteria tetap**, masing-masing dengan catatan dan status lolos/tidak.

- **`topik_review`** — data master 4 kriteria (sudah ditarik dari live DB, migrasi + `TopikReviewSeeder` sudah dibuat):

  | id | nama_topik | Ringkasan `petunjuk` |
  |---|---|---|
  | 1 | Sudah Diimplementasikan | Tujuan, diterapkan di lingkungan nyata, before-after, dokumen implementasi |
  | 2 | Memiliki Dampak Yang Terukur | Output (prototype/produk/program) & outcome (akademik/ekonomi/sosial/institusional/lingkungan) |
  | 3 | Dapat direplikasi oleh PT/Masyarakat | Mudah dipelajari, terdokumentasi, adaptif, biaya, ketergantungan |
  | 4 | Keterlibatan Mitra | Kesiapan modul/SOP/perangkat, peluang kolaborasi, kesiapan mentor/TOT, potensi kemitraan |

  Kolom `status` (boolean) menandai kriteria aktif/tidak dipakai lagi — query form penilaian harus menyaring `status = true` saja. **Tidak ada halaman admin untuk kelola kriteria ini** (dikonfirmasi developer) — cukup lewat seeder/DB.

- **`isi_review_pameran`** — isian SC per kriteria, **terikat ke satu baris `review_pameran`** (`idreview`) tertentu — artinya tiap **giliran SC** (satu putaran review yang berakhir dengan Revisi/Diterima/Ditolak) punya **set skor sendiri** (sampai 4 baris `isi_review_pameran`, satu per `topik_review` aktif). Kolom: `isi_review` (catatan SC khusus kriteria itu — **HTML rich-text**, lihat di bawah), `memenuhi` (boolean, lolos/tidak), `created_by` (SC yang mengisi), `created_at`.

  **Konsekuensi**: kalau sebuah pengajuan melalui beberapa putaran review (Revisi berkali-kali), peserta bisa melihat **riwayat skor per kriteria dari tiap putaran** — bukan cuma skor terakhir — selaras dengan §6.

- **Halaman tersendiri untuk mengisi penilaian (direvisi developer)**: form penilaian **bukan modal**, melainkan halaman terpisah (`GET /sc/pameran/review?token=...`, route `sc.pameran.review`, dibuka dari tombol "Beri Review" di accordion §6) — alasannya SC mengisi `isi_review` lewat **WYSIWYG editor (Quill)** untuk tiap kriteria, dan 4 editor penuh lebih leluasa di halaman sendiri dibanding dipaksakan ke modal (toolbar Quill rawan terpotong overflow modal).
- **Nilai awal editor (dikonfirmasi developer)**: kalau SC **belum pernah menyimpan** isi untuk kriteria tertentu, editor WYSIWYG-nya **diisi otomatis dari `topik_review.petunjuk`** sebagai starting point — membantu SC supaya tidak mengetik dari kosong; SC bebas mengedit atau menghapusnya sama sekali. Kalau sudah pernah tersimpan, editor diisi dari `isi_review` yang tersimpan itu (bukan `petunjuk` lagi).
- **Sanitasi HTML (konsekuensi teknis, sama pola dengan `pameran.abstract`)**: karena `isi_review` sekarang HTML dari WYSIWYG dan dirender mentah (`{!! !!}`) di halaman riwayat peserta & SC, isinya **disaring lewat `sanitizeRichText()`** (base `Controller.php`) sebelum disimpan — membuang tag/atribut berbahaya (`<script>`, `onerror`, `javascript:` href, dst.), karena field hidden form bisa saja diisi langsung lewat devtools, bukan hanya lewat toolbar Quill.
- **Dikonfirmasi developer**: SC **wajib mengisi keempat kriteria lengkap** (catatan + lolos/tidak) untuk **setiap** keputusan — Revisi, Diterima, **maupun** Ditolak. Tidak ada keputusan yang boleh dikirim tanpa skor lengkap.
- **Dikonfirmasi developer**: **peserta boleh melihat breakdown skor per kriteria** (catatan + lolos/tidak masing-masing dari 4 kriteria), bukan cuma catatan umum `review_pameran.catatan` — berlaku di semua giliran yang sudah final (ikut aturan visibilitas §6).

## 8. Draft/Review: update baris yang sama, bukan tambah baris baru (usulan AI, diambil sebagai default)

**[USULAN AI]** — developer bilang "pada status draft dan review alur tidak berpindah, masih tetap pada masing-masing". Untuk menghindari riwayat penuh sampah dari autosave berulang, diusulkan:

- Saat peserta klik **"Simpan Draft"** untuk **pertama kali** pada pengajuan baru (atau mulai revisi baru setelah status Revisi), sistem **insert satu baris baru** `review_pameran` berstatus `1 Draft`, `created_by` = PIC/peserta yang mengedit — **dikonfirmasi developer**: baris `pameran` juga baru dibuat di titik ini (klik "Simpan Draft"), bukan sejak form dibuka.
- Selama masih Draft, **simpan ulang/autosave meng-update baris Draft yang sama itu** (bukan insert baris baru tiap kali disimpan) — baris ini "milik" giliran peserta saat ini.
- Begitu peserta klik **"Ajukan"**, baris yang sama itu **berubah status jadi `2 Pengajuan`** (masih baris yang sama, bukan baris baru) — inilah yang jadi catatan permanen "peserta mengajukan pada waktu X".
- **Direvisi developer** — SC **tidak** membuat baris baru saat mengklaim ataupun saat menilai. Klaim (§5) hanya mengisi `pameran.direview_oleh`; baris `review_pameran` yang sudah dibuat peserta tetap itu-itu saja, masih berstatus `2`. Begitu SC klik **"Simpan Draft Review"** untuk **pertama kalinya**, baris itu (dan `pameran`) **berubah status jadi `3 Review`**, sekaligus SC **meng-upsert `isi_review_pameran`** (sampai 4 baris, satu per kriteria aktif). Selama masih `3`, SC bisa klik "Simpan Draft Review" berkali-kali — baris `review_pameran` dan isi `isi_review_pameran` itu di-update terus di tempat (bukan insert baris/baris baru), persis pola yang sama seperti Draft di sisi peserta. Begitu SC klik salah satu dari 3 tombol keputusan (Revisi/Diterima/Ditolak), **baris `review_pameran` yang sama itu** di-update `status_ajuan`-nya jadi final.
- **Konsekuensi**: satu baris `review_pameran` sekarang mewakili **seluruh siklus hidup satu giliran peserta** — dari saat diajukan (`2`), lewat jeda sempit "sudah diklaim, belum ada draf" (`2` + `direview_oleh` terisi), selagi SC aktif menilai (`3`), sampai keputusan final (`4`/`5`/`6`). `pameran.status_ajuan` selalu disinkronkan ke status baris terakhir ini (dikonfirmasi developer, §2).

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
- Migrasi `add_direview_oleh_to_pameran_table` (kolom `pameran.direview_oleh`, FK ke `pengguna`, dari `kppti_17.sql`, §5) dan `add_foreign_key_created_by_to_isi_review_pameran_table` (FK `isi_review_pameran.created_by` → `pengguna`, ketinggalan dari migrasi awal, ternyata sudah ada di live DB) — keduanya juga sudah ada di live DB, migrasi ditandai *applied*, diverifikasi dengan cara yang sama.
- `TopikReviewSeeder` — isi 4 baris kriteria (§7), ditarik persis dari data live (ejaan "Dapat" sudah dibetulkan developer langsung di database, seeder disesuaikan mengikuti), pola `insertOrIgnore` + `syncSequence` seperti seeder lain, didaftarkan di `DatabaseSeeder`.
- Migrasi `add_idpeserta_pic_to_pameran_table` — kolom `idpeserta_PIC` (FK ke `peserta.idpeserta`) sudah ada di live DB (dari `kppti_15.sql`), **ditandai *applied***, diverifikasi sama persis lewat migrasi fresh (termasuk nama kolom dengan huruf besar di akhir).
- Migrasi `add_tema_to_pameran_table` — kolom `tema` (varchar 255) sudah ada di live DB (dari `kppti_16.sql`), **ditandai *applied***, diverifikasi sama persis lewat migrasi fresh.

Dokumen ini **siap dijadikan acuan implementasi**.
