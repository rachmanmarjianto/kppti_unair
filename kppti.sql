/*
 Navicat Premium Data Transfer

 Source Server         : local_postgresql
 Source Server Type    : PostgreSQL
 Source Server Version : 140005 (140005)
 Source Host           : localhost:5432
 Source Catalog        : kppti_unair
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 140005 (140005)
 File Encoding         : 65001

 Date: 18/09/2026 11:06:55
*/


-- ----------------------------
-- Sequence structure for acara_idacara_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."acara_idacara_seq";
CREATE SEQUENCE "public"."acara_idacara_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for institusi_asal_idinstitusi_asal_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."institusi_asal_idinstitusi_asal_seq";
CREATE SEQUENCE "public"."institusi_asal_idinstitusi_asal_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for jabatan_idjabatan_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."jabatan_idjabatan_seq";
CREATE SEQUENCE "public"."jabatan_idjabatan_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for jenis_institusi_idjenis_institusi_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."jenis_institusi_idjenis_institusi_seq";
CREATE SEQUENCE "public"."jenis_institusi_idjenis_institusi_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for jenis_transport_idjenis_transport_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."jenis_transport_idjenis_transport_seq";
CREATE SEQUENCE "public"."jenis_transport_idjenis_transport_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for kelompok_jabatan_idkelompok_jabatan_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."kelompok_jabatan_idkelompok_jabatan_seq";
CREATE SEQUENCE "public"."kelompok_jabatan_idkelompok_jabatan_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for lldikti_idlldikti_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."lldikti_idlldikti_seq";
CREATE SEQUENCE "public"."lldikti_idlldikti_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for log_institusi_idlog_institusi_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."log_institusi_idlog_institusi_seq";
CREATE SEQUENCE "public"."log_institusi_idlog_institusi_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for narasumber_idnarasumber_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."narasumber_idnarasumber_seq";
CREATE SEQUENCE "public"."narasumber_idnarasumber_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pameran_idpameran_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pameran_idpameran_seq";
CREATE SEQUENCE "public"."pameran_idpameran_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pembayaran_idpembayaran_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pembayaran_idpembayaran_seq";
CREATE SEQUENCE "public"."pembayaran_idpembayaran_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for pengguna_idpengguna_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."pengguna_idpengguna_seq";
CREATE SEQUENCE "public"."pengguna_idpengguna_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for peserta_acara_idpeserta_acara_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."peserta_acara_idpeserta_acara_seq";
CREATE SEQUENCE "public"."peserta_acara_idpeserta_acara_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for peserta_idpeserta_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."peserta_idpeserta_seq";
CREATE SEQUENCE "public"."peserta_idpeserta_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for petugas_jaga_idpetugas_jaga_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."petugas_jaga_idpetugas_jaga_seq";
CREATE SEQUENCE "public"."petugas_jaga_idpetugas_jaga_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for review_narasumber_idreview_narasumber_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."review_narasumber_idreview_narasumber_seq";
CREATE SEQUENCE "public"."review_narasumber_idreview_narasumber_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for review_pameran_idreview_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."review_pameran_idreview_seq";
CREATE SEQUENCE "public"."review_pameran_idreview_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for role_idrole_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."role_idrole_seq";
CREATE SEQUENCE "public"."role_idrole_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for tagihan_idtagihan_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."tagihan_idtagihan_seq";
CREATE SEQUENCE "public"."tagihan_idtagihan_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for universitas_iduniversitas_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."universitas_iduniversitas_seq";
CREATE SEQUENCE "public"."universitas_iduniversitas_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for acara
-- ----------------------------
DROP TABLE IF EXISTS "public"."acara";
CREATE TABLE "public"."acara" (
  "idacara" int8 NOT NULL DEFAULT nextval('acara_idacara_seq'::regclass),
  "has_child" bool,
  "idparent_acara" int8,
  "tema" text COLLATE "pg_catalog"."default",
  "speaker" text COLLATE "pg_catalog"."default",
  "hari_ke" int2,
  "jam_mulai" time(6),
  "jam_akhir" time(6),
  "perlu_narsum" bool
)
;

-- ----------------------------
-- Records of acara
-- ----------------------------

-- ----------------------------
-- Table structure for institusi_asal
-- ----------------------------
DROP TABLE IF EXISTS "public"."institusi_asal";
CREATE TABLE "public"."institusi_asal" (
  "idinstitusi_asal" int4 NOT NULL DEFAULT nextval('institusi_asal_idinstitusi_asal_seq'::regclass),
  "idjenis_institusi" int4,
  "ptn_pts" char(1) COLLATE "pg_catalog"."default",
  "nama_institusi" varchar(255) COLLATE "pg_catalog"."default",
  "tabel_ref_institusi" varchar(255) COLLATE "pg_catalog"."default",
  "idref_institusi" int8,
  "idlldikti" int4,
  "kode_kontingen" varchar(5) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6)
)
;
COMMENT ON COLUMN "public"."institusi_asal"."idjenis_institusi" IS '1: PTN / PTS
2: asosiasi
3: lembaga akreditasi
4: Pemerhati Pendidikan
5: LL Dikti
6: Lainnya';
COMMENT ON COLUMN "public"."institusi_asal"."ptn_pts" IS '1: PTN; 2:PTS';
COMMENT ON COLUMN "public"."institusi_asal"."kode_kontingen" IS 'XXZZZ

XX: tanggal 2 digit
ZZZ: urutan dihari itu ';

-- ----------------------------
-- Records of institusi_asal
-- ----------------------------

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS "public"."jabatan";
CREATE TABLE "public"."jabatan" (
  "idjabatan" int4 NOT NULL DEFAULT nextval('jabatan_idjabatan_seq'::regclass),
  "nama_jabatan" varchar(255) COLLATE "pg_catalog"."default",
  "idkelompok_jabatan" int4
)
;

-- ----------------------------
-- Records of jabatan
-- ----------------------------
INSERT INTO "public"."jabatan" VALUES (1, 'Rektor', 1);
INSERT INTO "public"."jabatan" VALUES (2, 'Wakil Rektor', 1);
INSERT INTO "public"."jabatan" VALUES (3, 'Dosen', 1);
INSERT INTO "public"."jabatan" VALUES (4, 'Mahasiswa', 1);
INSERT INTO "public"."jabatan" VALUES (5, 'Tenaga Kependidikan', 1);
INSERT INTO "public"."jabatan" VALUES (6, 'Direktur', 2);
INSERT INTO "public"."jabatan" VALUES (7, 'Wakil Direktur', 2);
INSERT INTO "public"."jabatan" VALUES (8, 'Staff', 2);
INSERT INTO "public"."jabatan" VALUES (9, 'Ketua', 3);
INSERT INTO "public"."jabatan" VALUES (10, 'Wakil Ketua', 3);
INSERT INTO "public"."jabatan" VALUES (11, 'Staff', 3);

-- ----------------------------
-- Table structure for jenis_institusi
-- ----------------------------
DROP TABLE IF EXISTS "public"."jenis_institusi";
CREATE TABLE "public"."jenis_institusi" (
  "idjenis_institusi" int4 NOT NULL DEFAULT nextval('jenis_institusi_idjenis_institusi_seq'::regclass),
  "nama_jenis_institusi" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of jenis_institusi
-- ----------------------------
INSERT INTO "public"."jenis_institusi" VALUES (1, 'Perguruan Tinggi');
INSERT INTO "public"."jenis_institusi" VALUES (2, 'Lembaga Akreditasi');
INSERT INTO "public"."jenis_institusi" VALUES (3, 'Asosiasi');
INSERT INTO "public"."jenis_institusi" VALUES (4, 'LLDikti');
INSERT INTO "public"."jenis_institusi" VALUES (5, 'Pemerhati Pendidikan');
INSERT INTO "public"."jenis_institusi" VALUES (6, 'Lainnya');

-- ----------------------------
-- Table structure for jenis_institusi_jabatan
-- ----------------------------
DROP TABLE IF EXISTS "public"."jenis_institusi_jabatan";
CREATE TABLE "public"."jenis_institusi_jabatan" (
  "idjenis_institusi" int4,
  "idkelompok_jabatan" int4
)
;

-- ----------------------------
-- Records of jenis_institusi_jabatan
-- ----------------------------
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (1, 1);
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (2, 2);
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (3, 2);
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (4, 3);
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (5, 2);
INSERT INTO "public"."jenis_institusi_jabatan" VALUES (6, 2);

-- ----------------------------
-- Table structure for jenis_transport
-- ----------------------------
DROP TABLE IF EXISTS "public"."jenis_transport";
CREATE TABLE "public"."jenis_transport" (
  "idjenis_transport" int4 NOT NULL DEFAULT nextval('jenis_transport_idjenis_transport_seq'::regclass),
  "nama_jenis_transport" varchar(255) COLLATE "pg_catalog"."default",
  "status" bool DEFAULT true
)
;
COMMENT ON COLUMN "public"."jenis_transport"."nama_jenis_transport" IS '1: pesawat
2: kereta
3: bus umum
4: bus pariwisata
5: minibus
6: kendaraan pribadi';

-- ----------------------------
-- Records of jenis_transport
-- ----------------------------
INSERT INTO "public"."jenis_transport" VALUES (1, 'Pesawat', 't');
INSERT INTO "public"."jenis_transport" VALUES (2, 'Kereta', 't');
INSERT INTO "public"."jenis_transport" VALUES (3, 'Bus', 't');
INSERT INTO "public"."jenis_transport" VALUES (4, 'Minibus', 't');
INSERT INTO "public"."jenis_transport" VALUES (5, 'Kendaraan Pribadi', 't');
INSERT INTO "public"."jenis_transport" VALUES (6, 'Kendaraan Pribadi', 'f');

-- ----------------------------
-- Table structure for kelompok_jabatan
-- ----------------------------
DROP TABLE IF EXISTS "public"."kelompok_jabatan";
CREATE TABLE "public"."kelompok_jabatan" (
  "idkelompok_jabatan" int4 NOT NULL DEFAULT nextval('kelompok_jabatan_idkelompok_jabatan_seq'::regclass),
  "nama_kelompok_jabatan" varchar(100) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of kelompok_jabatan
-- ----------------------------
INSERT INTO "public"."kelompok_jabatan" VALUES (1, 'Perguruan Tinggi');
INSERT INTO "public"."kelompok_jabatan" VALUES (2, 'asosiasi, lembaga akre, pemerhati pendidikan, lainnya');
INSERT INTO "public"."kelompok_jabatan" VALUES (3, 'lldikti');

-- ----------------------------
-- Table structure for lldikti
-- ----------------------------
DROP TABLE IF EXISTS "public"."lldikti";
CREATE TABLE "public"."lldikti" (
  "idlldikti" int4 NOT NULL DEFAULT nextval('lldikti_idlldikti_seq'::regclass),
  "nomor_lldikti" varchar(5) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of lldikti
-- ----------------------------
INSERT INTO "public"."lldikti" VALUES (1, 'I');
INSERT INTO "public"."lldikti" VALUES (2, 'II');
INSERT INTO "public"."lldikti" VALUES (3, 'III');
INSERT INTO "public"."lldikti" VALUES (4, 'IV');
INSERT INTO "public"."lldikti" VALUES (5, 'V');
INSERT INTO "public"."lldikti" VALUES (6, 'VI');
INSERT INTO "public"."lldikti" VALUES (7, 'VII');
INSERT INTO "public"."lldikti" VALUES (8, 'VIII');
INSERT INTO "public"."lldikti" VALUES (9, 'IX');
INSERT INTO "public"."lldikti" VALUES (10, 'X');
INSERT INTO "public"."lldikti" VALUES (11, 'XI');
INSERT INTO "public"."lldikti" VALUES (12, 'XII');
INSERT INTO "public"."lldikti" VALUES (13, 'XIII');
INSERT INTO "public"."lldikti" VALUES (14, 'XIV');
INSERT INTO "public"."lldikti" VALUES (15, 'XV');
INSERT INTO "public"."lldikti" VALUES (16, 'XVI');
INSERT INTO "public"."lldikti" VALUES (17, 'XVII');

-- ----------------------------
-- Table structure for log_institusi
-- ----------------------------
DROP TABLE IF EXISTS "public"."log_institusi";
CREATE TABLE "public"."log_institusi" (
  "idlog_institusi" int8 NOT NULL DEFAULT nextval('log_institusi_idlog_institusi_seq'::regclass),
  "done_at" timestamp(6),
  "done_by" int8,
  "aktifitas" varchar(1000) COLLATE "pg_catalog"."default",
  "idinstitusi_asal" int4
)
;

-- ----------------------------
-- Records of log_institusi
-- ----------------------------

-- ----------------------------
-- Table structure for narasumber
-- ----------------------------
DROP TABLE IF EXISTS "public"."narasumber";
CREATE TABLE "public"."narasumber" (
  "idnarasumber" int4 NOT NULL DEFAULT nextval('narasumber_idnarasumber_seq'::regclass),
  "idacara" int8,
  "abstract" text COLLATE "pg_catalog"."default",
  "status_ajuan" char(1) COLLATE "pg_catalog"."default",
  "idpengguna" int4,
  "iduniversitas" int8
)
;
COMMENT ON COLUMN "public"."narasumber"."status_ajuan" IS '1: draft
2: pengajuan
3: review
4: revisi
5: Diterima
6: Ditolak';

-- ----------------------------
-- Records of narasumber
-- ----------------------------

-- ----------------------------
-- Table structure for pameran
-- ----------------------------
DROP TABLE IF EXISTS "public"."pameran";
CREATE TABLE "public"."pameran" (
  "idpameran" int4 NOT NULL DEFAULT nextval('pameran_idpameran_seq'::regclass),
  "abstract" text COLLATE "pg_catalog"."default",
  "status_ajuan" char(1) COLLATE "pg_catalog"."default",
  "nomor_stand" varchar(5) COLLATE "pg_catalog"."default",
  "idinstitusi_asal" int4
)
;
COMMENT ON COLUMN "public"."pameran"."status_ajuan" IS '1: draft
2: pengajuan
3: review
4: revisi
5: Diterima
6: Ditolak';

-- ----------------------------
-- Records of pameran
-- ----------------------------

-- ----------------------------
-- Table structure for pembayaran
-- ----------------------------
DROP TABLE IF EXISTS "public"."pembayaran";
CREATE TABLE "public"."pembayaran" (
  "idpembayaran" int4 NOT NULL DEFAULT nextval('pembayaran_idpembayaran_seq'::regclass),
  "idtagihan" int4,
  "trx_amount" int4,
  "datetime_payment" timestamp(6),
  "payment_ntb" varchar(255) COLLATE "pg_catalog"."default",
  "cumulative_payment_amount" int4
)
;

-- ----------------------------
-- Records of pembayaran
-- ----------------------------

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS "public"."pengguna";
CREATE TABLE "public"."pengguna" (
  "idpengguna" int4 NOT NULL DEFAULT nextval('pengguna_idpengguna_seq'::regclass),
  "nama" varchar(1000) COLLATE "pg_catalog"."default",
  "email" varchar(500) COLLATE "pg_catalog"."default",
  "no_wa" varchar(30) COLLATE "pg_catalog"."default",
  "idrole" int4,
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "idinstitusi_asal" int4
)
;

-- ----------------------------
-- Records of pengguna
-- ----------------------------

-- ----------------------------
-- Table structure for peserta
-- ----------------------------
DROP TABLE IF EXISTS "public"."peserta";
CREATE TABLE "public"."peserta" (
  "idpeserta" int8 NOT NULL DEFAULT nextval('peserta_idpeserta_seq'::regclass),
  "idinstitusi_asal" int4,
  "idjenis_transportasi_kedatangan" int4,
  "stasiun_kedatangan" varchar(255) COLLATE "pg_catalog"."default",
  "tanggal_kedatangan" date,
  "jam_kedatangan" time(6),
  "idjenis_transportasi_kepulangan" int4,
  "stasiun_kepulangan" varchar(255) COLLATE "pg_catalog"."default",
  "tanggal_kepulangan" date,
  "jam_kepulangan" time(6),
  "nama_hotel" varchar(255) COLLATE "pg_catalog"."default",
  "city_tour" bool DEFAULT false,
  "idpengguna" int4,
  "idjabatan" int4
)
;

-- ----------------------------
-- Records of peserta
-- ----------------------------

-- ----------------------------
-- Table structure for peserta_acara
-- ----------------------------
DROP TABLE IF EXISTS "public"."peserta_acara";
CREATE TABLE "public"."peserta_acara" (
  "idpeserta_acara" int8 NOT NULL DEFAULT nextval('peserta_acara_idpeserta_acara_seq'::regclass),
  "idpeserta" int8,
  "idacara" int8
)
;

-- ----------------------------
-- Records of peserta_acara
-- ----------------------------

-- ----------------------------
-- Table structure for petugas_jaga
-- ----------------------------
DROP TABLE IF EXISTS "public"."petugas_jaga";
CREATE TABLE "public"."petugas_jaga" (
  "idpetugas_jaga" int4 NOT NULL DEFAULT nextval('petugas_jaga_idpetugas_jaga_seq'::regclass),
  "idpameran" int4,
  "idpeserta" int8
)
;

-- ----------------------------
-- Records of petugas_jaga
-- ----------------------------

-- ----------------------------
-- Table structure for review_narasumber
-- ----------------------------
DROP TABLE IF EXISTS "public"."review_narasumber";
CREATE TABLE "public"."review_narasumber" (
  "idreview_narasumber" int4 NOT NULL DEFAULT nextval('review_narasumber_idreview_narasumber_seq'::regclass),
  "idnarasumber" int4,
  "file_path" varchar(255) COLLATE "pg_catalog"."default",
  "status_ajuan" char(1) COLLATE "pg_catalog"."default",
  "catatan" text COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "created_by" int4
)
;

-- ----------------------------
-- Records of review_narasumber
-- ----------------------------

-- ----------------------------
-- Table structure for review_pameran
-- ----------------------------
DROP TABLE IF EXISTS "public"."review_pameran";
CREATE TABLE "public"."review_pameran" (
  "idreview" int4 NOT NULL DEFAULT nextval('review_pameran_idreview_seq'::regclass),
  "idpameran" int4,
  "file_path" varchar(255) COLLATE "pg_catalog"."default",
  "status_ajuan" char(1) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "catatan" text COLLATE "pg_catalog"."default",
  "created_by" int4
)
;

-- ----------------------------
-- Records of review_pameran
-- ----------------------------

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS "public"."role";
CREATE TABLE "public"."role" (
  "idrole" int4 NOT NULL DEFAULT nextval('role_idrole_seq'::regclass),
  "nama_role" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO "public"."role" VALUES (1, 'admin');
INSERT INTO "public"."role" VALUES (2, 'Peserta');
INSERT INTO "public"."role" VALUES (3, 'Nara Sumber');
INSERT INTO "public"."role" VALUES (4, 'SC');

-- ----------------------------
-- Table structure for tagihan
-- ----------------------------
DROP TABLE IF EXISTS "public"."tagihan";
CREATE TABLE "public"."tagihan" (
  "idtagihan" int4 NOT NULL DEFAULT nextval('tagihan_idtagihan_seq'::regclass),
  "idinstitusi_asal" int4,
  "created_at" timestamp(6),
  "created_by" int8,
  "va" varchar(50) COLLATE "pg_catalog"."default",
  "status" int2,
  "tagihan" int4,
  "sisa_tagihan" int4,
  "expired_date" date,
  "billing_type" char(1) COLLATE "pg_catalog"."default",
  "customer_email" varchar(500) COLLATE "pg_catalog"."default",
  "payment_ntb" varchar(100) COLLATE "pg_catalog"."default",
  "va_status" char(1) COLLATE "pg_catalog"."default",
  "idpameran" int4
)
;
COMMENT ON COLUMN "public"."tagihan"."status" IS '1: tertagih;
2: terbayar sebagian
3: lunas
4: batal';
COMMENT ON COLUMN "public"."tagihan"."va_status" IS '1: aktif; 2: non aktif';

-- ----------------------------
-- Records of tagihan
-- ----------------------------

-- ----------------------------
-- Table structure for universitas
-- ----------------------------
DROP TABLE IF EXISTS "public"."universitas";
CREATE TABLE "public"."universitas" (
  "iduniversitas" int8 NOT NULL DEFAULT nextval('universitas_iduniversitas_seq'::regclass),
  "kode_universitas" int4,
  "nama_universitas" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of universitas
-- ----------------------------
INSERT INTO "public"."universitas" VALUES (85953, 16794, 'Universitas Pekalongan');
INSERT INTO "public"."universitas" VALUES (85954, 16816, 'Universitas Islam Malang');
INSERT INTO "public"."universitas" VALUES (85955, 16841, 'Universitas Respati Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85956, 16864, 'Universitas Wijayakusuma Purwokerto');
INSERT INTO "public"."universitas" VALUES (85957, 16876, 'Universitas Boyolali');
INSERT INTO "public"."universitas" VALUES (85958, 16998, 'Universitas Islam Majapahit');
INSERT INTO "public"."universitas" VALUES (85960, 17005, 'Universitas Abdurachman Saleh Situbondo');
INSERT INTO "public"."universitas" VALUES (85961, 17025, 'Universitas PGRI Semarang');
INSERT INTO "public"."universitas" VALUES (85963, 17097, 'Politeknik Negeri Media Kreatif');
INSERT INTO "public"."universitas" VALUES (85964, 17117, 'Universitas Sahid Surakarta');
INSERT INTO "public"."universitas" VALUES (85965, 17130, 'Universitas Bale Bandung');
INSERT INTO "public"."universitas" VALUES (85966, 17175, 'Politeknik Negeri Lampung');
INSERT INTO "public"."universitas" VALUES (85968, 17229, 'Universitas Islam 45 Bekasi');
INSERT INTO "public"."universitas" VALUES (85969, 17272, 'Universitas Pembangunan Jaya');
INSERT INTO "public"."universitas" VALUES (85970, 17311, 'Universitas Balikpapan');
INSERT INTO "public"."universitas" VALUES (85971, 17327, 'Universitas Islam Lamongan');
INSERT INTO "public"."universitas" VALUES (85972, 17350, 'Bali Tourism Institute Sekolah Tinggi Pariwisata Nusa Dua Bali');
INSERT INTO "public"."universitas" VALUES (85973, 17420, 'Universitas Putera Batam');
INSERT INTO "public"."universitas" VALUES (85974, 17432, 'Universitas Suryakancana');
INSERT INTO "public"."universitas" VALUES (85975, 17478, 'Universitas Merdeka Surabaya');
INSERT INTO "public"."universitas" VALUES (85976, 17535, 'Universitas Kanjuruhan Malang');
INSERT INTO "public"."universitas" VALUES (85978, 17591, 'Universitas Atma Jaya Makassar');
INSERT INTO "public"."universitas" VALUES (85979, 17791, 'Universitas Pawyatan Daha');
INSERT INTO "public"."universitas" VALUES (85980, 17825, 'Sekolah Tinggi Teknik PLN');
INSERT INTO "public"."universitas" VALUES (85981, 18028, 'Universitas Muhammadiyah Metro');
INSERT INTO "public"."universitas" VALUES (85982, 18038, 'Universitas Yudharta Pasuruan');
INSERT INTO "public"."universitas" VALUES (85983, 18095, 'Universitas Galuh');
INSERT INTO "public"."universitas" VALUES (85984, 18107, 'Universitas Bhayangkara Surabaya');
INSERT INTO "public"."universitas" VALUES (85986, 18258, 'Universitas Jabal Ghafur');
INSERT INTO "public"."universitas" VALUES (85987, 18380, 'Universitas Darma Agung');
INSERT INTO "public"."universitas" VALUES (85988, 18386, 'Universitas Tamansiswa Padang');
INSERT INTO "public"."universitas" VALUES (85989, 18386, 'Universitas Malahayati');
INSERT INTO "public"."universitas" VALUES (85990, 18455, 'Universitas Muhammadiyah Sukabumi');
INSERT INTO "public"."universitas" VALUES (85992, 18581, 'Universitas Serang Raya');
INSERT INTO "public"."universitas" VALUES (85993, 18690, 'Universitas 17 Agustus 1945 Banyuwangi');
INSERT INTO "public"."universitas" VALUES (85995, 18736, 'Universitas Madura');
INSERT INTO "public"."universitas" VALUES (85997, 18919, 'Universitas Purwakarta');
INSERT INTO "public"."universitas" VALUES (85998, 18937, 'Universitas AKI');
INSERT INTO "public"."universitas" VALUES (86000, 18993, 'Universitas Bhayangkara Jakarta Raya');
INSERT INTO "public"."universitas" VALUES (86002, 19075, 'Universitas Widya Dharma');
INSERT INTO "public"."universitas" VALUES (86003, 19092, 'Universitas Tribhuwana Tunggadewi');
INSERT INTO "public"."universitas" VALUES (86005, 19185, 'Universitas Krisnadwipayana');
INSERT INTO "public"."universitas" VALUES (86006, 19192, 'Sekolah Tinggi Agama Islam Negeri Purwokerto');
INSERT INTO "public"."universitas" VALUES (86007, 19195, 'Universitas Satya Negara Indonesia');
INSERT INTO "public"."universitas" VALUES (86008, 19207, 'Universitas 17 Agustus 1945');
INSERT INTO "public"."universitas" VALUES (86009, 19222, 'Universitas Muhammadiyah Cirebon');
INSERT INTO "public"."universitas" VALUES (86010, 19235, 'Universitas Dehasen Bengkulu');
INSERT INTO "public"."universitas" VALUES (86011, 19257, 'Universitas Islam Djakarta');
INSERT INTO "public"."universitas" VALUES (86012, 19401, 'Universitas Klabat');
INSERT INTO "public"."universitas" VALUES (86013, 19413, 'Universitas Tunas Pembangunan');
INSERT INTO "public"."universitas" VALUES (86014, 19522, 'Universitas Widya Mandala Madiun');
INSERT INTO "public"."universitas" VALUES (86015, 19537, 'Universitas Islam Syekh Yusuf Tangerang');
INSERT INTO "public"."universitas" VALUES (86016, 19542, 'Universitas Tama Jagakarsa');
INSERT INTO "public"."universitas" VALUES (86017, 19566, 'Universitas Internasional Batam');
INSERT INTO "public"."universitas" VALUES (86018, 19578, 'Universitas Islam Kadiri');
INSERT INTO "public"."universitas" VALUES (86020, 19665, 'Universitas Kristen Immanuel');
INSERT INTO "public"."universitas" VALUES (86021, 19709, 'Universitas Islam Batik');
INSERT INTO "public"."universitas" VALUES (86023, 19893, 'Universitas Cenderawasih');
INSERT INTO "public"."universitas" VALUES (86024, 19904, 'Institut Ilmu Sosial dan Ilmu Politik Jakarta');
INSERT INTO "public"."universitas" VALUES (86025, 19920, 'Universitas Kristen Indonesia Toraja');
INSERT INTO "public"."universitas" VALUES (86026, 20044, 'Universitas Bung Karno');
INSERT INTO "public"."universitas" VALUES (86027, 20076, 'Universitas Samudra Langsa');
INSERT INTO "public"."universitas" VALUES (86028, 20116, 'Universitas Teuku Umar Meulaboh');
INSERT INTO "public"."universitas" VALUES (86029, 20127, 'Sekolah Tinggi Manajemen Informatika dan Komputer');
INSERT INTO "public"."universitas" VALUES (86030, 20142, 'Universitas Muhammadiyah Pontianak');
INSERT INTO "public"."universitas" VALUES (86031, 20177, 'Universitas Islam Kalimantan Banjarmasin');
INSERT INTO "public"."universitas" VALUES (86032, 20187, 'Universitas Nusa Bangsa');
INSERT INTO "public"."universitas" VALUES (86033, 20213, 'Sekolah Tinggi Ilmu Ekonomi Kesuma Negara');
INSERT INTO "public"."universitas" VALUES (86034, 20252, 'Politeknik Negeri Ambon');
INSERT INTO "public"."universitas" VALUES (86035, 20296, 'Universitas Kristen Surakarta');
INSERT INTO "public"."universitas" VALUES (86036, 20318, 'Universitas Garut');
INSERT INTO "public"."universitas" VALUES (86037, 20395, 'Universitas Wiraraja');
INSERT INTO "public"."universitas" VALUES (86038, 20404, 'Teknologi Pendidikan Universitas Negeri Malang');
INSERT INTO "public"."universitas" VALUES (86039, 20437, 'Universitas Wisnuwardhana Malang');
INSERT INTO "public"."universitas" VALUES (86040, 20488, 'Universitas Cokroaminoto Yogyakarta');
INSERT INTO "public"."universitas" VALUES (86042, 20492, 'Universitas Islam Darul Ulum');
INSERT INTO "public"."universitas" VALUES (86043, 20498, 'Universitas Swadaya Gunung Djati');
INSERT INTO "public"."universitas" VALUES (86044, 20513, 'Universitas Tidar Magelang');
INSERT INTO "public"."universitas" VALUES (86045, 20520, 'Universitas Borobudur');
INSERT INTO "public"."universitas" VALUES (86046, 20524, 'Universitas Batanghari');
INSERT INTO "public"."universitas" VALUES (86047, 20547, 'Universitas Muhammadiyah Sumatera Barat');
INSERT INTO "public"."universitas" VALUES (86048, 20597, 'Universitas Kadiri');
INSERT INTO "public"."universitas" VALUES (86049, 20730, 'Universitas Suryadarma');
INSERT INTO "public"."universitas" VALUES (86050, 20769, 'Universitas Islam Madura');
INSERT INTO "public"."universitas" VALUES (86051, 20773, 'Universitas Hindu Indonesia');
INSERT INTO "public"."universitas" VALUES (86053, 20895, 'Universitas Islam Indragiri');
INSERT INTO "public"."universitas" VALUES (86054, 20896, 'Universitas Dwijendra');
INSERT INTO "public"."universitas" VALUES (86055, 20919, 'Politeknik Seni Yogyakarta');
INSERT INTO "public"."universitas" VALUES (86057, 20993, 'Universitas Ekasakti');
INSERT INTO "public"."universitas" VALUES (86058, 21031, 'Universitas Darul Ulum');
INSERT INTO "public"."universitas" VALUES (86059, 21070, 'Universitas Al Washliyah Medan');
INSERT INTO "public"."universitas" VALUES (86060, 21161, 'Universitas Nasional PASIM');
INSERT INTO "public"."universitas" VALUES (86061, 21169, 'Universitas Baturaja');
INSERT INTO "public"."universitas" VALUES (86062, 21179, 'Universitas Prof Dr Hazairin SH');
INSERT INTO "public"."universitas" VALUES (86063, 21189, 'Universitas Prima Indonesia');
INSERT INTO "public"."universitas" VALUES (86064, 21205, 'Universitas Timbul Nusantara');
INSERT INTO "public"."universitas" VALUES (86065, 21216, 'Universitas Putra Indonesia YPTK Padang');
INSERT INTO "public"."universitas" VALUES (86066, 21220, 'Universitas Widya Mataram');
INSERT INTO "public"."universitas" VALUES (86067, 21254, 'Universitas Satyagama');
INSERT INTO "public"."universitas" VALUES (86068, 21265, 'Universitas Abulyatama');
INSERT INTO "public"."universitas" VALUES (86069, 21294, 'Sekolah Tinggi Manajemen Informatika & Komputer TIME Medan');
INSERT INTO "public"."universitas" VALUES (86070, 21306, 'Universitas MPU Tantular');
INSERT INTO "public"."universitas" VALUES (86071, 21326, 'Universitas Wiraswasta Indonesia');
INSERT INTO "public"."universitas" VALUES (86072, 21329, 'Universitas Pandanaran');
INSERT INTO "public"."universitas" VALUES (86073, 21407, 'Universitas Ngurah Rai');
INSERT INTO "public"."universitas" VALUES (86075, 21443, 'Universitas Mahaputra Muhammad Yamin');
INSERT INTO "public"."universitas" VALUES (86076, 21470, 'Universitas Trilogi');
INSERT INTO "public"."universitas" VALUES (86077, 21477, 'Universitas Islam Attahiriyah');
INSERT INTO "public"."universitas" VALUES (86078, 21510, 'Universitas Sintuwu Maroso');
INSERT INTO "public"."universitas" VALUES (86079, 21585, 'Sekolah Tinggi Kesehatan Banten');
INSERT INTO "public"."universitas" VALUES (86080, 21589, 'Sekolah Tinggi Agama Islam Negeri Parepare');
INSERT INTO "public"."universitas" VALUES (86081, 21661, 'Universitas PGRI Ronggolawe');
INSERT INTO "public"."universitas" VALUES (86082, 21745, 'Universitas Katolik Darma Cendika');
INSERT INTO "public"."universitas" VALUES (86083, 21774, 'Universitas Nurtario Bandung');
INSERT INTO "public"."universitas" VALUES (86084, 21814, 'Universitas Kader Bangsa Palembang');
INSERT INTO "public"."universitas" VALUES (86085, 21819, 'Universitas Informatika Dan Bisnis Indonesia');
INSERT INTO "public"."universitas" VALUES (86086, 21855, 'Universitas Islam Makassar');
INSERT INTO "public"."universitas" VALUES (86087, 21884, 'Universitas Muhammadiyah Mataram');
INSERT INTO "public"."universitas" VALUES (86088, 21906, 'Universitas Indo Global Mandiri');
INSERT INTO "public"."universitas" VALUES (86089, 21927, 'Universitas Batam');
INSERT INTO "public"."universitas" VALUES (86090, 21959, 'Sekolah Tinggi Teknologi Jakarta');
INSERT INTO "public"."universitas" VALUES (86091, 21986, 'Universitas Bangun Nusantara Sukoharjo');
INSERT INTO "public"."universitas" VALUES (86092, 21996, 'Universitas Bojonegoro');
INSERT INTO "public"."universitas" VALUES (86093, 22024, 'Universitas Kutai Kartanegara');
INSERT INTO "public"."universitas" VALUES (86094, 22057, 'Universitas Simalungun');
INSERT INTO "public"."universitas" VALUES (86095, 22123, 'Universitas Islam As Syafiiyah');
INSERT INTO "public"."universitas" VALUES (86096, 22152, 'Universitas HKBP Nommensen');
INSERT INTO "public"."universitas" VALUES (86097, 22227, 'Universitas Nahdlatul Ulama');
INSERT INTO "public"."universitas" VALUES (86099, 22363, 'Universitas Tridinanti');
INSERT INTO "public"."universitas" VALUES (86100, 22373, 'Universitas Mahasaraswati Mataram');
INSERT INTO "public"."universitas" VALUES (86101, 22423, 'Universitas Mathla''ul Anwar');
INSERT INTO "public"."universitas" VALUES (86102, 22506, 'Universitas Halmahera');
INSERT INTO "public"."universitas" VALUES (86103, 22506, 'Universitas Muara Bungo');
INSERT INTO "public"."universitas" VALUES (86104, 22511, 'Manajemen Informatika Universitas Muhammadiyah Metro');
INSERT INTO "public"."universitas" VALUES (86105, 22560, 'Universitas Muhammadiyah Palangka Raya');
INSERT INTO "public"."universitas" VALUES (86106, 22591, 'Universitas Soerjo');
INSERT INTO "public"."universitas" VALUES (86107, 22605, 'Universitas Bosowa');
INSERT INTO "public"."universitas" VALUES (86108, 22684, 'Fakultas Hukum Universitas Panji Sakti');
INSERT INTO "public"."universitas" VALUES (86110, 22713, 'Universitas Palembang');
INSERT INTO "public"."universitas" VALUES (86111, 22724, 'Universitas Gunung Rinjani');
INSERT INTO "public"."universitas" VALUES (86112, 22736, 'Universitas Pembinaan Masyarakat Indonesia');
INSERT INTO "public"."universitas" VALUES (86113, 22758, 'Universitas Katolik Santo Thomas');
INSERT INTO "public"."universitas" VALUES (86114, 22771, 'Universitas Sangga Buana');
INSERT INTO "public"."universitas" VALUES (86115, 22790, 'Universitas Winaya Mukti');
INSERT INTO "public"."universitas" VALUES (86116, 22807, 'Universitas Muhammadiyah Gorontalo');
INSERT INTO "public"."universitas" VALUES (86117, 22892, 'Universitas Ibnu Chaldun');
INSERT INTO "public"."universitas" VALUES (86118, 22937, 'Universitas Darwan Ali');
INSERT INTO "public"."universitas" VALUES (86119, 22939, 'Universitas Subang');
INSERT INTO "public"."universitas" VALUES (86120, 22958, 'Universitas Ichsan Gorontalo');
INSERT INTO "public"."universitas" VALUES (86121, 22962, 'Universitas W R Supratman');
INSERT INTO "public"."universitas" VALUES (86122, 22974, 'Universitas 45 Surabaya');
INSERT INTO "public"."universitas" VALUES (86123, 22981, 'Universitas Al-Ghifari');
INSERT INTO "public"."universitas" VALUES (86124, 22994, 'Universitas Cokroaminoto Makassar');
INSERT INTO "public"."universitas" VALUES (86125, 23017, 'Universitas Tulungagung');
INSERT INTO "public"."universitas" VALUES (86126, 23028, 'Universitas Al Washliyah Labuhan Batu');
INSERT INTO "public"."universitas" VALUES (86127, 23063, 'Universitas 17 Agustus 1945 Cirebon');
INSERT INTO "public"."universitas" VALUES (86128, 23097, 'Universitas Muhammadiyah Buton');
INSERT INTO "public"."universitas" VALUES (86129, 23106, 'Universitas Sultan Fatah');
INSERT INTO "public"."universitas" VALUES (86130, 23117, 'Universitas Sembilanbelas November');
INSERT INTO "public"."universitas" VALUES (86131, 23130, 'Universitas Islam Blitar');
INSERT INTO "public"."universitas" VALUES (86132, 23168, 'Universitas Nusa Nipa');
INSERT INTO "public"."universitas" VALUES (86133, 23221, 'Universitas Amir Hamzah');
INSERT INTO "public"."universitas" VALUES (86134, 23226, 'Universitas Islam Al-azhar Mataram');
INSERT INTO "public"."universitas" VALUES (86135, 23256, 'Universitas Moch Sroedji Jember');
INSERT INTO "public"."universitas" VALUES (86136, 23268, 'Universitas Flores');
INSERT INTO "public"."universitas" VALUES (86137, 23306, 'Universitas Kapuas Sintang');
INSERT INTO "public"."universitas" VALUES (86138, 23309, 'Universitas Gorontalo');
INSERT INTO "public"."universitas" VALUES (86139, 23316, 'Universitas Tompotika');
INSERT INTO "public"."universitas" VALUES (86140, 23325, 'Universitas Sawerigading Makassar');
INSERT INTO "public"."universitas" VALUES (86141, 23331, 'Universitas Dayanu Ikhsanuddin');
INSERT INTO "public"."universitas" VALUES (86142, 23331, 'Universitas Bandung Raya');
INSERT INTO "public"."universitas" VALUES (86143, 23346, 'Universitas Nahdlatul Wathan');
INSERT INTO "public"."universitas" VALUES (86144, 23381, 'Universitas Kristen Indonesia Tomohon');
INSERT INTO "public"."universitas" VALUES (86145, 23389, 'Universitas Sunan Giri');
INSERT INTO "public"."universitas" VALUES (86146, 23411, 'Fakultas Kesehatan Masyarakat Universitas Nusa Tenggara Barat');
INSERT INTO "public"."universitas" VALUES (86147, 23430, 'Universitas Gresik');
INSERT INTO "public"."universitas" VALUES (86148, 23430, 'Universitas Merdeka Pasuruan');
INSERT INTO "public"."universitas" VALUES (86149, 23479, 'Universitas Alkhairaat');
INSERT INTO "public"."universitas" VALUES (86150, 23489, 'Universitas Muhammadiyah Parepare');
INSERT INTO "public"."universitas" VALUES (86151, 23494, 'Universitas Asahan');
INSERT INTO "public"."universitas" VALUES (86152, 23540, 'Universitas Tri Tunggal');
INSERT INTO "public"."universitas" VALUES (86153, 23574, 'Universitas Kristen Indonesia Maluku');
INSERT INTO "public"."universitas" VALUES (86154, 23581, 'Universitas Surapati');
INSERT INTO "public"."universitas" VALUES (86155, 23587, 'Universitas Sains dan Teknologi Jayapura');
INSERT INTO "public"."universitas" VALUES (86156, 23605, 'Universitas Pramita Indonesia');
INSERT INTO "public"."universitas" VALUES (86157, 23609, 'Universitas Muhammadiyah Lampung');
INSERT INTO "public"."universitas" VALUES (86158, 23618, 'Politeknik Katolik Saint Paul Sorong');
INSERT INTO "public"."universitas" VALUES (86159, 23618, 'Universitas Sang Bumi Ruwa Jurai');
INSERT INTO "public"."universitas" VALUES (86160, 23625, 'Universitas Teknologi Sulawesi');
INSERT INTO "public"."universitas" VALUES (86161, 23642, 'Universitas Al Asyariah Mandar');
INSERT INTO "public"."universitas" VALUES (86162, 23651, 'Universitas Dian Nusantara');
INSERT INTO "public"."universitas" VALUES (86163, 23693, 'Universitas Sjakhyakirti');
INSERT INTO "public"."universitas" VALUES (86164, 23742, 'Universitas PGRI Banyuwangi');
INSERT INTO "public"."universitas" VALUES (86165, 23758, 'Universitas Veteran Republik Indonesia Makassar');
INSERT INTO "public"."universitas" VALUES (86166, 23767, 'Universitas Yos Soedarso');
INSERT INTO "public"."universitas" VALUES (86167, 23856, 'Universitas Iqra Buru');
INSERT INTO "public"."universitas" VALUES (86168, 23856, 'Universitas Karimun');
INSERT INTO "public"."universitas" VALUES (86169, 23856, 'Universitas Gajah Putih');
INSERT INTO "public"."universitas" VALUES (86170, 23856, 'Universitas Muhammadiyah Tapanuli Selatan');
INSERT INTO "public"."universitas" VALUES (85689, 763, 'Universitas Indonesia');
INSERT INTO "public"."universitas" VALUES (85690, 801, 'Institute of Technology Bandung');
INSERT INTO "public"."universitas" VALUES (85691, 807, 'Universitas Gadjah Mada');
INSERT INTO "public"."universitas" VALUES (85692, 1448, 'Universitas Diponegoro');
INSERT INTO "public"."universitas" VALUES (85693, 1508, 'Universitas Riau');
INSERT INTO "public"."universitas" VALUES (85696, 1719, 'Universitas Padjadjaran');
INSERT INTO "public"."universitas" VALUES (85697, 2072, 'Universitas Sebelas Maret');
INSERT INTO "public"."universitas" VALUES (85698, 2157, 'Universitas Syiah Kuala');
INSERT INTO "public"."universitas" VALUES (85700, 2428, 'Universitas Hasanuddin');
INSERT INTO "public"."universitas" VALUES (85701, 2479, 'Universitas Airlangga');
INSERT INTO "public"."universitas" VALUES (85702, 2556, 'Universitas Udayana');
INSERT INTO "public"."universitas" VALUES (85703, 2642, 'Universitas Mercu Buana');
INSERT INTO "public"."universitas" VALUES (85704, 2657, 'Universitas Negeri Semarang');
INSERT INTO "public"."universitas" VALUES (85705, 2829, 'Universitas Muhammadiyah Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85706, 2863, 'Universitas Negeri Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85707, 2887, 'Universitas Ahmad Dahlan Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85708, 2887, 'Universitas Sumatera Utara');
INSERT INTO "public"."universitas" VALUES (85710, 2972, 'Institut Agama Islam Negeri Walisongo Semarang');
INSERT INTO "public"."universitas" VALUES (85711, 3030, 'Universitas Andalas');
INSERT INTO "public"."universitas" VALUES (85712, 3093, 'Universitas Islam Indonesia');
INSERT INTO "public"."universitas" VALUES (85713, 3148, 'Universitas Trisakti');
INSERT INTO "public"."universitas" VALUES (85714, 3155, 'Universitas Katolik Indonesia Atma Jaya');
INSERT INTO "public"."universitas" VALUES (85715, 3158, 'Universitas Lampung');
INSERT INTO "public"."universitas" VALUES (85716, 3204, 'Universitas Terbuka');
INSERT INTO "public"."universitas" VALUES (85718, 3304, 'Universitas Tadulako');
INSERT INTO "public"."universitas" VALUES (96769, 1015, 'UNIVERSITAS MULAWARMAN');
INSERT INTO "public"."universitas" VALUES (85720, 3504, 'Universitas Esa Unggul (Universitas Indonusa)');
INSERT INTO "public"."universitas" VALUES (85721, 3506, 'Universitas Bengkulu');
INSERT INTO "public"."universitas" VALUES (85722, 3549, 'Universitas Jambi');
INSERT INTO "public"."universitas" VALUES (85723, 3561, 'Universitas Muhammadiyah Sumatera Utara');
INSERT INTO "public"."universitas" VALUES (85724, 3596, 'Universitas Jember');
INSERT INTO "public"."universitas" VALUES (85726, 3667, 'Universitas Katolik Parahyangan');
INSERT INTO "public"."universitas" VALUES (85727, 3676, 'Universitas Pattimura');
INSERT INTO "public"."universitas" VALUES (85728, 3694, 'Universitas 17 Agustus 1945 Samarinda');
INSERT INTO "public"."universitas" VALUES (85729, 3724, 'Universitas Pelita Harapan');
INSERT INTO "public"."universitas" VALUES (85730, 3835, 'Universitas Pendikan Indonesia / Indonesia University of Education');
INSERT INTO "public"."universitas" VALUES (85731, 3973, 'Universitas Jenderal Soedirman');
INSERT INTO "public"."universitas" VALUES (85734, 4034, 'Universitas Narotama');
INSERT INTO "public"."universitas" VALUES (85736, 4122, 'Universitas Islam Bandung');
INSERT INTO "public"."universitas" VALUES (85737, 4129, 'Universitas Islam Negeri Syarif Hidayatullah Jakarta');
INSERT INTO "public"."universitas" VALUES (85738, 4170, 'Universitas Sriwijaya');
INSERT INTO "public"."universitas" VALUES (85739, 4246, 'Universitas Islam Negeri Sunan Ampel Surabaya');
INSERT INTO "public"."universitas" VALUES (85742, 4396, 'Universitas Negeri Medan');
INSERT INTO "public"."universitas" VALUES (85743, 4403, 'Universitas Bakrie');
INSERT INTO "public"."universitas" VALUES (85744, 4403, 'Universitas Mahammadiyah Purwokerto');
INSERT INTO "public"."universitas" VALUES (85745, 4467, 'Politeknik Negeri Samarinda');
INSERT INTO "public"."universitas" VALUES (85746, 4523, 'Universitas Sam Ratulangi');
INSERT INTO "public"."universitas" VALUES (85747, 4595, 'Institut Teknologi Nasional');
INSERT INTO "public"."universitas" VALUES (85748, 4595, 'Universitas Surabaya');
INSERT INTO "public"."universitas" VALUES (85749, 4606, 'Universitas Dian Nuswantoro');
INSERT INTO "public"."universitas" VALUES (85751, 4784, 'Universitas Muslim Nusantara Al Washliyah');
INSERT INTO "public"."universitas" VALUES (85752, 4882, 'Akademi Telkom Jakarta');
INSERT INTO "public"."universitas" VALUES (85753, 4886, 'Universitas Islam Negeri Sunan Kalijaga Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85754, 5004, 'Sekolah Tinggi Manajemen Informatika dan Komputer Jakarta');
INSERT INTO "public"."universitas" VALUES (85755, 5013, 'Universitas Negeri Makassar');
INSERT INTO "public"."universitas" VALUES (85756, 5062, 'Universitas Nusa Cendana');
INSERT INTO "public"."universitas" VALUES (85757, 5077, 'Universitas Negeri Gorontalo');
INSERT INTO "public"."universitas" VALUES (85758, 5097, 'Universitas Negeri Malang');
INSERT INTO "public"."universitas" VALUES (85759, 5166, 'Universitas Pendidikan Ganesha');
INSERT INTO "public"."universitas" VALUES (85760, 5193, 'Universitas Islam Negeri Maulana Malik Ibrahim Malang');
INSERT INTO "public"."universitas" VALUES (85761, 5207, 'STIKOM Surabaya');
INSERT INTO "public"."universitas" VALUES (85762, 5353, 'Electronic Engineering Polytechnic Institute of Surabaya');
INSERT INTO "public"."universitas" VALUES (85764, 5435, 'Universitas Muhammadiyah Surakarta');
INSERT INTO "public"."universitas" VALUES (85765, 5446, 'Universitas Sultan Ageng Tirtayasa');
INSERT INTO "public"."universitas" VALUES (85766, 5560, 'Universitas Islam Negeri Sultan Syarif Kasim');
INSERT INTO "public"."universitas" VALUES (85767, 5573, 'Universitas Islam Negeri Sunan Gunung Djati Bandung');
INSERT INTO "public"."universitas" VALUES (85768, 5597, 'Politeknik Negeri Sriwijaya');
INSERT INTO "public"."universitas" VALUES (85769, 5662, 'Universitas Islam Riau');
INSERT INTO "public"."universitas" VALUES (85770, 5727, 'Universitas Tanjungpura');
INSERT INTO "public"."universitas" VALUES (85771, 5753, 'Universitas Muhammadiyah Palembang');
INSERT INTO "public"."universitas" VALUES (85772, 5804, 'Universitas Sanata Dharma');
INSERT INTO "public"."universitas" VALUES (85774, 5906, 'Universitas Pembangunan Nasional Veteran Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85775, 5917, 'Universitas Atma Jaya Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85776, 6044, 'Universitas Sains Al Quran');
INSERT INTO "public"."universitas" VALUES (85777, 6072, 'Universitas Malikussaleh');
INSERT INTO "public"."universitas" VALUES (85778, 6123, 'Universitas Kristen Satya Wacana');
INSERT INTO "public"."universitas" VALUES (85779, 6155, 'Universitas Lancang Kuning');
INSERT INTO "public"."universitas" VALUES (85780, 6161, 'Universitas Kristen Duta Wacana');
INSERT INTO "public"."universitas" VALUES (85781, 6271, 'Universitas Widyatama');
INSERT INTO "public"."universitas" VALUES (85782, 6282, 'Universitas Negeri Padang');
INSERT INTO "public"."universitas" VALUES (85783, 6410, 'Universitas Muhammadiyah Sidoarjo');
INSERT INTO "public"."universitas" VALUES (85784, 6736, 'Universitas Muria Kudus');
INSERT INTO "public"."universitas" VALUES (85786, 6863, 'Universitas Negeri Jakarta');
INSERT INTO "public"."universitas" VALUES (85787, 6928, 'Universitas Kristen Maranatha');
INSERT INTO "public"."universitas" VALUES (85788, 7056, 'Universitas PGRI Palembang');
INSERT INTO "public"."universitas" VALUES (85789, 7081, 'Universitas Trunojoyo');
INSERT INTO "public"."universitas" VALUES (85790, 7159, 'Universitas Medan Area');
INSERT INTO "public"."universitas" VALUES (85791, 7332, 'Universitas Mulawarman');
INSERT INTO "public"."universitas" VALUES (85792, 7379, 'Universitas Mataram');
INSERT INTO "public"."universitas" VALUES (85793, 7405, 'Universitas Muhammadiyah Malang');
INSERT INTO "public"."universitas" VALUES (85794, 7438, 'Politeknik Negeri Bandung');
INSERT INTO "public"."universitas" VALUES (85795, 7579, 'Universitas Islam Negeri Alauddin Makassar');
INSERT INTO "public"."universitas" VALUES (85796, 7741, 'Politeknik Negeri Manado');
INSERT INTO "public"."universitas" VALUES (85797, 7759, 'Universitas Ibn Khaldun Bogor');
INSERT INTO "public"."universitas" VALUES (85798, 7759, 'Universitas Muhammadiyah Semarang');
INSERT INTO "public"."universitas" VALUES (85799, 7798, 'Universitas IBA Palembang');
INSERT INTO "public"."universitas" VALUES (85800, 7882, 'Sekolah Tinggi Informatika dan Komputer Indonesia');
INSERT INTO "public"."universitas" VALUES (85801, 7963, 'Universitas Katolik Soegijapranata');
INSERT INTO "public"."universitas" VALUES (85802, 8016, 'Sekolah Tinggi Teknologi Garut');
INSERT INTO "public"."universitas" VALUES (85803, 8184, 'Universitas Pasundan');
INSERT INTO "public"."universitas" VALUES (85806, 8415, 'Universitas Muhammadiyah Luwuk Banggai');
INSERT INTO "public"."universitas" VALUES (85807, 8424, 'Universitas Pembangunan Nasional Veteran Jawa Timur');
INSERT INTO "public"."universitas" VALUES (85808, 8493, 'Universitas Almuslim');
INSERT INTO "public"."universitas" VALUES (85809, 8603, 'Universitas Bina Darma');
INSERT INTO "public"."universitas" VALUES (85811, 8650, 'Politeknik Negeri Pontianak');
INSERT INTO "public"."universitas" VALUES (85812, 8689, 'Universitas Muhammadiyah Riau');
INSERT INTO "public"."universitas" VALUES (85813, 8750, 'Universitas Darussalam Ambon');
INSERT INTO "public"."universitas" VALUES (85814, 8954, 'Universitas Pancasakti Tegal');
INSERT INTO "public"."universitas" VALUES (85815, 8963, 'Universitas Mercu Buana Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85816, 9103, 'Universitas Lambung Mangkurat');
INSERT INTO "public"."universitas" VALUES (85818, 9210, 'Universitas Halu Oleo');
INSERT INTO "public"."universitas" VALUES (85819, 9355, 'Universitas Djuanda');
INSERT INTO "public"."universitas" VALUES (85820, 9480, 'Universitas Singaperbangsa');
INSERT INTO "public"."universitas" VALUES (85821, 9613, 'Universitas Pembangunan Nasional Veteran Jakarta');
INSERT INTO "public"."universitas" VALUES (85822, 9716, 'Universitas Azzahra');
INSERT INTO "public"."universitas" VALUES (85823, 9725, 'Universitas Negeri Surabaya');
INSERT INTO "public"."universitas" VALUES (85824, 9798, 'Universitas Pendidikan Nasional');
INSERT INTO "public"."universitas" VALUES (85825, 9908, 'Universitas Panca Marga');
INSERT INTO "public"."universitas" VALUES (85826, 10023, 'Universitas Negeri Papua');
INSERT INTO "public"."universitas" VALUES (85828, 10119, 'Universitas Stikubank Semarang');
INSERT INTO "public"."universitas" VALUES (85829, 10154, 'Institut Teknologi Adhi Tama Surabaya');
INSERT INTO "public"."universitas" VALUES (85830, 10173, 'Universitas Budi Luhur');
INSERT INTO "public"."universitas" VALUES (85832, 10206, 'Universitas Darma Persada');
INSERT INTO "public"."universitas" VALUES (85833, 10225, 'Universitas Pancasila');
INSERT INTO "public"."universitas" VALUES (85834, 10242, 'Universitas Islam Nusantara');
INSERT INTO "public"."universitas" VALUES (85835, 10419, 'Universitas Al Azhar Indonesia');
INSERT INTO "public"."universitas" VALUES (85836, 10419, 'Universitas Muhammadiyah Prof Dr Hamka');
INSERT INTO "public"."universitas" VALUES (85837, 10469, 'Universitas Setia Budi Surakarta');
INSERT INTO "public"."universitas" VALUES (85838, 10772, 'Universitas Widya Kartika');
INSERT INTO "public"."universitas" VALUES (85839, 10786, 'Universitas Pesantren Darul Ulum');
INSERT INTO "public"."universitas" VALUES (85840, 10826, 'Universitas Warmadewa');
INSERT INTO "public"."universitas" VALUES (85841, 10887, 'Universitas Muhammadiyah Aceh');
INSERT INTO "public"."universitas" VALUES (85842, 10910, 'Politeknik Negeri Padang (previously Politeknik Universitas Andalas)');
INSERT INTO "public"."universitas" VALUES (85843, 10935, 'Universitas Nasional Jakarta');
INSERT INTO "public"."universitas" VALUES (85844, 11031, 'Teknologi Pendidikan Universitas Negeri Surabaya');
INSERT INTO "public"."universitas" VALUES (85845, 11098, 'Universitas Multimedia Nusantara');
INSERT INTO "public"."universitas" VALUES (85846, 11277, 'Sekolah Tinggi Seni Indonesia Bandung');
INSERT INTO "public"."universitas" VALUES (85848, 11477, 'Sekolah Tinggi Akuntansi Negara');
INSERT INTO "public"."universitas" VALUES (85849, 11599, 'Universitas Wijaya Putra');
INSERT INTO "public"."universitas" VALUES (85850, 11705, 'Universitas Borneo Tarakan');
INSERT INTO "public"."universitas" VALUES (85851, 11754, 'STIE Perbanas Surabaya');
INSERT INTO "public"."universitas" VALUES (85852, 11787, 'Universitas Muhammadiyah Purworejo');
INSERT INTO "public"."universitas" VALUES (85853, 11878, 'Universitas Pakuan');
INSERT INTO "public"."universitas" VALUES (85854, 11888, 'Universitas Riau Kepulauan');
INSERT INTO "public"."universitas" VALUES (85855, 11888, 'Universitas Ciputra');
INSERT INTO "public"."universitas" VALUES (85856, 11918, 'Universitas Yarsi');
INSERT INTO "public"."universitas" VALUES (85857, 11948, 'Universitas Bandar Lampung');
INSERT INTO "public"."universitas" VALUES (85858, 12056, 'Universitas Muhammadiyah Ponorogo');
INSERT INTO "public"."universitas" VALUES (85859, 12064, 'Politeknik Negeri Semarang / Semarang State Polytechnic');
INSERT INTO "public"."universitas" VALUES (85860, 12110, 'Universitas Kristen Indonesia Paulus');
INSERT INTO "public"."universitas" VALUES (85861, 12162, 'Universitas Kuningan');
INSERT INTO "public"."universitas" VALUES (85862, 12184, 'Universitas Muhammadiyah Jember');
INSERT INTO "public"."universitas" VALUES (85863, 12321, 'Universitas Tarumanagara');
INSERT INTO "public"."universitas" VALUES (85865, 12378, 'Universitas Respati');
INSERT INTO "public"."universitas" VALUES (85866, 12383, 'Universitas Kristen Krida Wacana');
INSERT INTO "public"."universitas" VALUES (85867, 12383, 'Universitas Hang Tuah');
INSERT INTO "public"."universitas" VALUES (85868, 12488, 'Politeknik Negeri Malang');
INSERT INTO "public"."universitas" VALUES (85869, 12585, 'Universitas Siliwangi');
INSERT INTO "public"."universitas" VALUES (85871, 12603, 'Universitas Kristen Indonesia');
INSERT INTO "public"."universitas" VALUES (85873, 12638, 'Universitas Bung Hatta');
INSERT INTO "public"."universitas" VALUES (85874, 12670, 'Universitas Musamus Merauke');
INSERT INTO "public"."universitas" VALUES (85875, 12695, 'Universitas Bangka Belitung');
INSERT INTO "public"."universitas" VALUES (85876, 12716, 'Universitas Samawa');
INSERT INTO "public"."universitas" VALUES (85877, 12858, 'Sekolah Tinggi Teknik Surabaya');
INSERT INTO "public"."universitas" VALUES (85878, 12872, 'Universitas Negeri Manado');
INSERT INTO "public"."universitas" VALUES (85879, 12876, 'Universitas Maritim Raja Ali Haji');
INSERT INTO "public"."universitas" VALUES (85880, 12980, 'Politeknik Negeri Jakarta');
INSERT INTO "public"."universitas" VALUES (85881, 12985, 'Politeknik Negeri Batam / Batam State Polytechnic');
INSERT INTO "public"."universitas" VALUES (85882, 12995, 'Universitas Muhammadiyah Jakarta');
INSERT INTO "public"."universitas" VALUES (85883, 13010, 'Sekolah Tinggi Manajemen Risiko Dan Asuransi');
INSERT INTO "public"."universitas" VALUES (85884, 13104, 'Universitas Paramadina');
INSERT INTO "public"."universitas" VALUES (85886, 13192, 'Universitas Semarang');
INSERT INTO "public"."universitas" VALUES (85887, 13230, 'Universitas Mahasaraswati Denpasar');
INSERT INTO "public"."universitas" VALUES (85888, 13230, 'Universitas PGRI Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85889, 13245, 'Universitas Wijaya Kusuma Surabaya');
INSERT INTO "public"."universitas" VALUES (85891, 13478, 'Universitas Jenderal Achmad Yani');
INSERT INTO "public"."universitas" VALUES (85893, 13591, 'Universitas Nusantara PGRI Kediri');
INSERT INTO "public"."universitas" VALUES (85894, 13600, 'Bandung Polytechnic for Manufacturing');
INSERT INTO "public"."universitas" VALUES (85895, 13640, 'Universitas Dharmawangsa');
INSERT INTO "public"."universitas" VALUES (85896, 13809, 'Universitas Palangka Raya');
INSERT INTO "public"."universitas" VALUES (85897, 13829, 'Universitas 17 Agustus 1945 Surabaya');
INSERT INTO "public"."universitas" VALUES (85898, 13986, 'Institut Teknologi Nasional Malang');
INSERT INTO "public"."universitas" VALUES (85899, 13986, 'Universitas Advent Indonesia');
INSERT INTO "public"."universitas" VALUES (85901, 14002, 'Politeknik Perkapalan Negeri Surabaya');
INSERT INTO "public"."universitas" VALUES (85902, 14034, 'Universitas Pembangunan Panca Budi Medan');
INSERT INTO "public"."universitas" VALUES (85903, 14118, 'Institut Agama Islam Negeri IAIN Salatiga');
INSERT INTO "public"."universitas" VALUES (85905, 14269, 'Universitas PGRI Adi Buana Surabaya');
INSERT INTO "public"."universitas" VALUES (85906, 14314, 'Universitas Wiralodra Indramayu');
INSERT INTO "public"."universitas" VALUES (85907, 14338, 'Universitas Langlangbuana');
INSERT INTO "public"."universitas" VALUES (85908, 14344, 'Universitas Wahid Hasyim');
INSERT INTO "public"."universitas" VALUES (85909, 14344, 'Politeknik Negeri Ujung Pandang');
INSERT INTO "public"."universitas" VALUES (85910, 14352, 'Universitas Ma Chung');
INSERT INTO "public"."universitas" VALUES (85911, 14358, 'Yayasan Administrasi Indonesia (Universitas Persada)');
INSERT INTO "public"."universitas" VALUES (85912, 14371, 'Sekolah Tinggi Manajemen Informatika dan Teknik Komputer Bali');
INSERT INTO "public"."universitas" VALUES (85913, 14454, 'Universitas Muhammadiyah Bengkulu');
INSERT INTO "public"."universitas" VALUES (85915, 14579, 'University Dr Soetomo Surabaya');
INSERT INTO "public"."universitas" VALUES (85916, 14636, 'Politeknik Negeri Jember');
INSERT INTO "public"."universitas" VALUES (85917, 14736, 'Universitas Sarjanawiyata Tamansiswa');
INSERT INTO "public"."universitas" VALUES (85918, 14749, 'Ubudiyah Indonesia University / Universitas UBudiyah Indonesia');
INSERT INTO "public"."universitas" VALUES (85919, 14749, 'Universitas Bunda Mulia Jakarta');
INSERT INTO "public"."universitas" VALUES (85920, 14922, 'Universitas Muhammadiyah Surabaya');
INSERT INTO "public"."universitas" VALUES (85921, 14986, 'Politeknik Negeri Medan');
INSERT INTO "public"."universitas" VALUES (85922, 14994, 'TAIN Kudus Sekolah Tinggi Agama Islam Negeri Kudus');
INSERT INTO "public"."universitas" VALUES (85923, 15021, 'Universitas 17 Agustus 1945 Semarang');
INSERT INTO "public"."universitas" VALUES (85924, 15037, 'Universitas Timor');
INSERT INTO "public"."universitas" VALUES (85925, 15087, 'Universitas Muhammadiyah Magelang');
INSERT INTO "public"."universitas" VALUES (85926, 15194, 'Universitas Pamulang');
INSERT INTO "public"."universitas" VALUES (85928, 15498, 'Universitas Janabadra');
INSERT INTO "public"."universitas" VALUES (85929, 15525, 'Universitas Khairun');
INSERT INTO "public"."universitas" VALUES (85930, 15607, 'Politeknik Negeri Lhokseumawe');
INSERT INTO "public"."universitas" VALUES (85932, 15675, 'Universitas Islam Sumatera Utara');
INSERT INTO "public"."universitas" VALUES (85933, 15678, 'Universitas Muhammadiyah Makassar');
INSERT INTO "public"."universitas" VALUES (85935, 15930, 'Institut Kesenian Jakarta');
INSERT INTO "public"."universitas" VALUES (85936, 15942, 'Universitas Serambi Mekkah');
INSERT INTO "public"."universitas" VALUES (85937, 15966, 'Universitas Teknologi Yogyakarta');
INSERT INTO "public"."universitas" VALUES (85938, 15995, 'Politeknik Informatika Del');
INSERT INTO "public"."universitas" VALUES (85939, 16017, 'Universitas Prof Dr Moestopo');
INSERT INTO "public"."universitas" VALUES (85940, 16017, 'Universitas Muhammadiyah Gresik');
INSERT INTO "public"."universitas" VALUES (85941, 16045, 'Universitas Katolik Widya Mandira');
INSERT INTO "public"."universitas" VALUES (85942, 16056, 'Politeknik Negeri Banjarmasin');
INSERT INTO "public"."universitas" VALUES (85945, 16277, 'Universitas Sahid Lokasi');
INSERT INTO "public"."universitas" VALUES (85947, 16357, 'Universitas Muslim Indonesia');
INSERT INTO "public"."universitas" VALUES (85948, 16416, 'Politeknik Negeri Bali');
INSERT INTO "public"."universitas" VALUES (85950, 16494, 'Universitas Nusantara');
INSERT INTO "public"."universitas" VALUES (85951, 16539, 'Universitas Fajar');
INSERT INTO "public"."universitas" VALUES (85952, 16565, 'Universitas Indraprasta');
INSERT INTO "public"."universitas" VALUES (95841, 32008, 'Institut Sains Dan Teknologi Al-Kamal');
INSERT INTO "public"."universitas" VALUES (96221, 71085, 'Universitas Darussalam Gontor');
INSERT INTO "public"."universitas" VALUES (95481, 91034, 'Universitas Indonesia Timur');
INSERT INTO "public"."universitas" VALUES (95482, 33073, 'Sekolah Tinggi Ilmu Hukum IBLAM');
INSERT INTO "public"."universitas" VALUES (95961, 99015, 'Institut Ilmu Kesehatan Bhakti Wiyata');
INSERT INTO "public"."universitas" VALUES (95521, NULL, 'INSTITUT TEKNOLOGI BANDUNG');
INSERT INTO "public"."universitas" VALUES (95522, NULL, 'UNIVERSITAS INDONESIA');
INSERT INTO "public"."universitas" VALUES (95523, NULL, 'UNIVERSITAS GADJAH MADA');
INSERT INTO "public"."universitas" VALUES (95524, NULL, 'INSTITUT PERTANIAN BOGOR');
INSERT INTO "public"."universitas" VALUES (95525, NULL, 'INSTITUT TEKNOLOGI SEPULUH NOPEMBER');
INSERT INTO "public"."universitas" VALUES (95526, NULL, 'UNIVERSITAS DIPONEGORO');
INSERT INTO "public"."universitas" VALUES (95527, NULL, 'UNIVERSITAS BRAWIJAYA');
INSERT INTO "public"."universitas" VALUES (95528, NULL, 'UNIVERSITAS PADJAJARAN');
INSERT INTO "public"."universitas" VALUES (95529, NULL, 'UNIVERSITAS NEGERI SEBELAS MARET');
INSERT INTO "public"."universitas" VALUES (95530, NULL, 'UNIVERSITAS SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (95531, NULL, 'UNIVERSITAS HASANUDDIN');
INSERT INTO "public"."universitas" VALUES (95532, NULL, 'UNIVERSITAS AIRLANGGA');
INSERT INTO "public"."universitas" VALUES (95533, NULL, 'UNIVERSITAS BINA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (95534, NULL, 'UNIVERSITAS ANDALAS');
INSERT INTO "public"."universitas" VALUES (96303, 73001, 'Sekolah Tinggi Ilmu Ekonomi Indonesia Surabaya');
INSERT INTO "public"."universitas" VALUES (95483, 93065, 'Sekolah Tinggi Ilmu Manajemen Nitro Makassar');
INSERT INTO "public"."universitas" VALUES (95484, 405027, 'Poltekkes Kemenkes Makassar');
INSERT INTO "public"."universitas" VALUES (88078, 945, 'Universiti Tenaga Nasional');
INSERT INTO "public"."universitas" VALUES (88116, 8689, 'Politeknik Seberang Perai');
INSERT INTO "public"."universitas" VALUES (88133, 11670, 'Politeknik Tuanku Syed Sirajuddin');
INSERT INTO "public"."universitas" VALUES (88139, 12826, 'Politeknik Jeli');
INSERT INTO "public"."universitas" VALUES (88143, 13084, 'Politeknik Port Dickson');
INSERT INTO "public"."universitas" VALUES (88147, 13657, 'Politeknik Kuching Sarawak');
INSERT INTO "public"."universitas" VALUES (88150, 13720, 'Politeknik Ungku Omar');
INSERT INTO "public"."universitas" VALUES (88151, 13759, 'Politeknik Merlimau');
INSERT INTO "public"."universitas" VALUES (88154, 14235, 'Politeknik Sultan Salahuddin Abdul Aziz Shah');
INSERT INTO "public"."universitas" VALUES (88156, 14406, 'Politeknik Sultan Abdul Halim');
INSERT INTO "public"."universitas" VALUES (88157, 14429, 'Politeknik Melaka');
INSERT INTO "public"."universitas" VALUES (88158, 14579, 'Politeknik Kota Bharu');
INSERT INTO "public"."universitas" VALUES (88159, 14714, 'Politeknik Sultan Haji Ahmad Shah');
INSERT INTO "public"."universitas" VALUES (88162, 15096, 'Politeknik Tuanku Sultanah Bahiyah');
INSERT INTO "public"."universitas" VALUES (88163, 15138, 'Politeknik Sultan Idris Shah');
INSERT INTO "public"."universitas" VALUES (88165, 15303, 'GlobalNxt University (Universitas 21 Global)');
INSERT INTO "public"."universitas" VALUES (88172, 15823, 'Politeknik Mukah Sarawak');
INSERT INTO "public"."universitas" VALUES (88174, 15870, 'Politeknik Sultan Azlan Shah');
INSERT INTO "public"."universitas" VALUES (88180, 16494, 'Politeknik Nilai');
INSERT INTO "public"."universitas" VALUES (88181, 16578, 'Politeknik Sultan Mizan Zainal Abidin');
INSERT INTO "public"."universitas" VALUES (88185, 16762, 'Politeknik Ibrahim Sultan');
INSERT INTO "public"."universitas" VALUES (88196, 17898, 'Politeknik Balik Pulau');
INSERT INTO "public"."universitas" VALUES (88197, 17941, 'Politeknik Hulu Terengganu');
INSERT INTO "public"."universitas" VALUES (88198, 17941, 'Politeknik Muadzam Shah');
INSERT INTO "public"."universitas" VALUES (88200, 18190, 'Politeknik Sandakan');
INSERT INTO "public"."universitas" VALUES (88205, 18866, 'Politeknik Banting');
INSERT INTO "public"."universitas" VALUES (88220, 20133, 'Politeknik Metro Kuala Lumpur');
INSERT INTO "public"."universitas" VALUES (88222, 20401, 'Politeknik Mersing Johor');
INSERT INTO "public"."universitas" VALUES (88225, 20530, 'Politeknik Metro Kuantan');
INSERT INTO "public"."universitas" VALUES (88228, 20851, 'Politeknik Kuala Terengganu');
INSERT INTO "public"."universitas" VALUES (88246, 22440, 'Politeknik Metro Betong');
INSERT INTO "public"."universitas" VALUES (88249, 22546, 'Politeknik Metro Johor Bahru');
INSERT INTO "public"."universitas" VALUES (88261, 23115, 'Politeknik Metro Tasek Gelugor');
INSERT INTO "public"."universitas" VALUES (96522, 10, 'universitas DSI');
INSERT INTO "public"."universitas" VALUES (97464, 25008, 'POLITEKNIK GAJAH SAKTI');
INSERT INTO "public"."universitas" VALUES (97465, 25009, 'POLITEKNIK MUARA DUA');
INSERT INTO "public"."universitas" VALUES (97466, 25010, 'POLITEKNIK PALCOMTECH');
INSERT INTO "public"."universitas" VALUES (97467, 25011, 'POLITEKNIK AKAMIGAS PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97468, 25012, 'POLITEKNIK SEKAYU');
INSERT INTO "public"."universitas" VALUES (97469, 25013, 'POLITEKNIK DARMA GANESHA');
INSERT INTO "public"."universitas" VALUES (97470, 26001, 'AKADEMI KOMUNITAS PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97471, 26002, 'AKADEMI KOMUNITAS DHARMA BHAKTI BANGKA');
INSERT INTO "public"."universitas" VALUES (97472, 26003, 'AKADEMI KOMUNITAS INDUSTRI PERTAMBANGAN BUKIT ASAM');
INSERT INTO "public"."universitas" VALUES (97473, 31001, 'UNIVERSITAS IBNU CHALDUN');
INSERT INTO "public"."universitas" VALUES (97474, 31003, 'UNIVERSITAS ISLAM JAKARTA');
INSERT INTO "public"."universitas" VALUES (97475, 31005, 'UNIVERSITAS JAKARTA');
INSERT INTO "public"."universitas" VALUES (97476, 31006, 'UNIVERSITAS JAYABAYA');
INSERT INTO "public"."universitas" VALUES (97477, 31007, 'UNIVERSITAS KATOLIK INDONESIA ATMA JAYA');
INSERT INTO "public"."universitas" VALUES (97478, 31008, 'UNIVERSITAS KRISNADWIPAYANA');
INSERT INTO "public"."universitas" VALUES (97479, 31009, 'UNIVERSITAS KRISTEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97480, 31010, 'UNIVERSITAS KRISTEN KRIDA WACANA');
INSERT INTO "public"."universitas" VALUES (97481, 31011, 'UNIVERSITAS MUHAMMADIYAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97482, 31012, 'UNIVERSITAS NASIONAL');
INSERT INTO "public"."universitas" VALUES (97483, 31013, 'UNIVERSITAS PANCASILA');
INSERT INTO "public"."universitas" VALUES (97484, 31014, 'UNIVERSITAS PROF DR MOESTOPO (BERAGAMA)');
INSERT INTO "public"."universitas" VALUES (97485, 31015, 'UNIVERSITAS TARUMANAGARA');
INSERT INTO "public"."universitas" VALUES (97486, 31016, 'UNIVERSITAS TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97487, 31017, 'UNIVERSITAS 17 AGUSTUS 1945 JAKARTA');
INSERT INTO "public"."universitas" VALUES (97488, 31018, 'UNIVERSITAS BOROBUDUR');
INSERT INTO "public"."universitas" VALUES (97489, 31019, 'UNIVERSITAS MERCU BUANA');
INSERT INTO "public"."universitas" VALUES (97490, 31020, 'UNIVERSITAS PERSADA INDONESIA YAI');
INSERT INTO "public"."universitas" VALUES (97491, 31021, 'UNIVERSITAS ISLAM AS-SYAFIIYAH');
INSERT INTO "public"."universitas" VALUES (97492, 31022, 'UNIVERSITAS WIRASWASTA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97493, 31023, 'UNIVERSITAS DARMA PERSADA');
INSERT INTO "public"."universitas" VALUES (97494, 31024, 'UNIVERSITAS MPU TANTULAR');
INSERT INTO "public"."universitas" VALUES (97495, 31025, 'UNIVERSITAS SATYA NEGARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97496, 31026, 'UNIVERSITAS YARSI');
INSERT INTO "public"."universitas" VALUES (97497, 31027, 'UNIVERSITAS RESPATI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97498, 31029, 'UNIVERSITAS SURAPATI');
INSERT INTO "public"."universitas" VALUES (97499, 31030, 'UNIVERSITAS SAHID');
INSERT INTO "public"."universitas" VALUES (97500, 31031, 'UNIVERSITAS SATYAGAMA');
INSERT INTO "public"."universitas" VALUES (97501, 31032, 'UNIVERSITAS ISLAM ATTAHIRIYAH');
INSERT INTO "public"."universitas" VALUES (97502, 31033, 'UNIVERSITAS ESA UNGGUL');
INSERT INTO "public"."universitas" VALUES (97503, 31034, 'UNIVERSITAS PELITA HARAPAN');
INSERT INTO "public"."universitas" VALUES (97504, 31035, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97505, 31036, 'UNIVERSITAS BHAYANGKARA JAKARTA RAYA');
INSERT INTO "public"."universitas" VALUES (97506, 31037, 'UNIVERSITAS GUNADARMA');
INSERT INTO "public"."universitas" VALUES (97507, 31039, 'UNIVERSITAS MUHAMMADIYAH PROF DR HAMKA');
INSERT INTO "public"."universitas" VALUES (97508, 31040, 'UNIVERSITAS AZZAHRA');
INSERT INTO "public"."universitas" VALUES (97509, 31041, 'UNIVERSITAS PARAMADINA');
INSERT INTO "public"."universitas" VALUES (97510, 31042, 'UNIVERSITAS BUNG KARNO');
INSERT INTO "public"."universitas" VALUES (97511, 31043, 'UNIVERSITAS DIRGANTARA MARSEKAL SURYADARMA');
INSERT INTO "public"."universitas" VALUES (97512, 31044, 'UNIVERSITAS AL-AZHAR INDONESIA');
INSERT INTO "public"."universitas" VALUES (97513, 31045, 'UNIVERSITAS BUDI LUHUR');
INSERT INTO "public"."universitas" VALUES (97514, 31047, 'UNIVERSITAS KEJUANGAN 45 JAKARTA');
INSERT INTO "public"."universitas" VALUES (97515, 31048, 'UNIVERSITAS BUNDA MULIA');
INSERT INTO "public"."universitas" VALUES (97516, 31049, 'UNIVERSITAS INDRAPRASTA PGRI');
INSERT INTO "public"."universitas" VALUES (97517, 31050, 'UNIVERSITAS TAMA JAGAKARSA');
INSERT INTO "public"."universitas" VALUES (97518, 31051, 'UNIVERSITAS MULTIMEDIA NUSANTARA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97519, 31052, 'UNIVERSITAS TIMBUL NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97520, 31053, 'UNIVERSITAS BAKRIE');
INSERT INTO "public"."universitas" VALUES (97521, 31054, 'UNIVERSITAS TANRI ABENG');
INSERT INTO "public"."universitas" VALUES (97522, 31055, 'UNIVERSITAS TRILOGI');
INSERT INTO "public"."universitas" VALUES (97523, 31056, 'UNIVERSITAS SAMPOERNA');
INSERT INTO "public"."universitas" VALUES (97524, 31057, 'UNIVERSITAS AGUNG PODOMORO');
INSERT INTO "public"."universitas" VALUES (97525, 31059, 'UNIVERSITAS MOHAMMAD HUSNI THAMRIN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97526, 31060, 'UNIVERSITAS MATANA');
INSERT INTO "public"."universitas" VALUES (97527, 31061, 'UNIVERSITAS NAHDLATUL ULAMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97528, 31062, 'UNIVERSITAS PERTAMINA');
INSERT INTO "public"."universitas" VALUES (97529, 31063, 'UNIVERSITAS PRASETIYA MULYA');
INSERT INTO "public"."universitas" VALUES (97530, 31064, 'UNIVERSITAS BINAWAN');
INSERT INTO "public"."universitas" VALUES (97531, 31065, 'UNIVERSITAS BINA SARANA INFORMATIKA');
INSERT INTO "public"."universitas" VALUES (97532, 31066, 'UNIVERSITAS DIAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97533, 31067, 'UNIVERSITAS PRADITA');
INSERT INTO "public"."universitas" VALUES (97534, 31068, 'UNIVERSITAS SIBER ASIA');
INSERT INTO "public"."universitas" VALUES (97535, 32002, 'INSTITUT KESENIAN JAKARTA - LPKJ');
INSERT INTO "public"."universitas" VALUES (97536, 32004, 'INSTITUT SAINS DAN TEKNOLOGI NASIONAL');
INSERT INTO "public"."universitas" VALUES (97537, 32005, 'INSTITUT ILMU SOSIAL DAN ILMU POLITIK JAKARTA');
INSERT INTO "public"."universitas" VALUES (97538, 32006, 'INSTITUT TEKNOLOGI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97539, 32007, 'INSTITUT TEKNOLOGI BUDI UTOMO');
INSERT INTO "public"."universitas" VALUES (97540, 32009, 'INSTITUT BISNIS DAN INFORMATIKA KWIK KIAN GIE');
INSERT INTO "public"."universitas" VALUES (97541, 32011, 'INSTITUT KEUANGAN-PERBANKAN DAN INFORMATIKA ASIA PERBANAS');
INSERT INTO "public"."universitas" VALUES (97542, 32012, 'INSTITUT BISNIS NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97543, 32013, 'INSTITUT TEKNOLOGI DAN BISNIS KALBIS');
INSERT INTO "public"."universitas" VALUES (97544, 32014, 'INSTITUT BISNIS DAN MULTIMEDIA ASMI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97545, 32015, 'INSTITUT BISNIS DAN INFORMATIKA (IBI) KOSGORO 1957');
INSERT INTO "public"."universitas" VALUES (97546, 32016, 'INSTITUT BIO SCIENTIA INTERNASIONAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97547, 32017, 'INSTITUT ILMU SOSIAL DAN MANAJEMEN STIAMI');
INSERT INTO "public"."universitas" VALUES (97548, 32018, 'INSTITUT KESEHATAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97549, 32019, 'INSTITUT SAINS DAN TEKNOLOGI PRADITA');
INSERT INTO "public"."universitas" VALUES (97550, 32020, 'INSTITUT TRANSPORTASI DAN LOGISTIK TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97551, 32021, 'INSTITUT TEKNOLOGI CALVIN');
INSERT INTO "public"."universitas" VALUES (97552, 32022, 'INSTITUT TEKNOLOGI DAN BISNIS BANK RAKYAT INDONESIA');
INSERT INTO "public"."universitas" VALUES (97553, 32023, 'INSTITUT TEKNOLOGI DAN BISNIS AHMAD DAHLAN');
INSERT INTO "public"."universitas" VALUES (97554, 32024, 'INSTITUT TEKNOLOGI DAN KESEHATAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97555, 32025, 'INSTITUT KOMUNIKASI DAN BISNIS LSPR');
INSERT INTO "public"."universitas" VALUES (97556, 32026, 'INSTITUT TEKNOLOGI PERUSAHAAN LISTRIK NEGARA');
INSERT INTO "public"."universitas" VALUES (97557, 32027, 'INSTITUT TEKNOLOGI DAN BISNIS SWADHARMA');
INSERT INTO "public"."universitas" VALUES (97558, 33001, 'SEKOLAH TINGGI FILSAFAT DRIYARKARA');
INSERT INTO "public"."universitas" VALUES (97559, 33004, 'STISIP WIDURI');
INSERT INTO "public"."universitas" VALUES (97560, 33006, 'SEKOLAH TINGGI TEKNOLOGI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97992, 43034, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN PASUNDAN');
INSERT INTO "public"."universitas" VALUES (97993, 43035, 'SEKOLAH TINGGI BAHASA ASING YAPARI');
INSERT INTO "public"."universitas" VALUES (97994, 43036, 'STKIP PGRI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (97995, 43038, 'SEKOLAH TINGGI SAINS DAN TEKNOLOGI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97996, 43040, 'SEKOLAH TINGGI TEKNOLOGI MANDALA');
INSERT INTO "public"."universitas" VALUES (97997, 43041, 'STKIP SILIWANGI');
INSERT INTO "public"."universitas" VALUES (97998, 43042, 'SEKOLAH TINGGI ILMU ADMINISTRASI BAGASASI');
INSERT INTO "public"."universitas" VALUES (97999, 43043, 'SEKOLAH TINGGI ILMU EKONOMI PASUNDAN');
INSERT INTO "public"."universitas" VALUES (98000, 43044, 'SEKOLAH TINGGI TEKNOLOGI BINA TUNGGAL');
INSERT INTO "public"."universitas" VALUES (98001, 43045, 'SEKOLAH TINGGI ILMU KOMUNIKASI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98002, 43046, 'SEKOLAH TINGGI PERTANIAN JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (98003, 43049, 'SEKOLAH TINGGI TEKNOLOGI MINERAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (98004, 43050, 'SEKOLAH TINGGI TEKNOLOGI CIREBON');
INSERT INTO "public"."universitas" VALUES (98005, 43051, 'SEKOLAH TINGGI TEKNOLOGI GARUT');
INSERT INTO "public"."universitas" VALUES (98006, 43053, 'STISI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98007, 43056, 'SEKOLAH TINGGI ILMU EKONOMI PARIWISATA YAPARI');
INSERT INTO "public"."universitas" VALUES (98008, 43057, 'SEKOLAH TINGGI MATEMATIKA & ILMU PENGETAHUAN ALAM');
INSERT INTO "public"."universitas" VALUES (98009, 43059, 'SEKOLAH TINGGI TEKNOLOGI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98010, 43061, 'SEKOLAH TINGGI ILMU EKONOMI BINANIAGA');
INSERT INTO "public"."universitas" VALUES (98011, 43063, 'STMIK BANDUNG');
INSERT INTO "public"."universitas" VALUES (98012, 43064, 'SEKOLAH TINGGI ILMU EKONOMI LA TANSA MASHIRO');
INSERT INTO "public"."universitas" VALUES (98013, 43069, 'SEKOLAH TINGGI TEKNOLOGI YBS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98014, 43071, 'STMIK LIKMI');
INSERT INTO "public"."universitas" VALUES (98015, 43072, 'SEKOLAH TINGGI ILMU BAHASA BANTEN RAYA');
INSERT INTO "public"."universitas" VALUES (98016, 43073, 'STMIK IM');
INSERT INTO "public"."universitas" VALUES (98017, 43074, 'SEKOLAH TINGGI ILMU EKONOMI YASA ANGGANA');
INSERT INTO "public"."universitas" VALUES (98018, 43075, 'SEKOLAH TINGGI ILMU EKONOMI TRIGUNA');
INSERT INTO "public"."universitas" VALUES (98019, 43078, 'SEKOLAH TINGGI PARIWISATA ARS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98020, 43079, 'SEKOLAH TINGGI DESAIN INDONESIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98021, 43081, 'SEKOLAH TINGGI ILMU EKONOMI SEBELAS APRIL');
INSERT INTO "public"."universitas" VALUES (98022, 43082, 'SEKOLAH TINGGI ILMU EKONOMI PENGUJI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98023, 43083, 'SEKOLAH TINGGI ILMU EKONOMI BUDHI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98024, 43084, 'SEKOLAH TINGGI ILMU EKONOMI PGRI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98025, 43085, 'STISIP YUPENTEK TANGERANG');
INSERT INTO "public"."universitas" VALUES (98026, 43086, 'STMIK JABAR');
INSERT INTO "public"."universitas" VALUES (98027, 43088, 'SEKOLAH TINGGI ILMU EKONOMI MIFTAHUL HUDA SUBANG');
INSERT INTO "public"."universitas" VALUES (98028, 43089, 'SEKOLAH TINGGI ILMU EKONOMI MULIA PRATAMA');
INSERT INTO "public"."universitas" VALUES (98029, 43090, 'SEKOLAH TINGGI ILMU ADMINISTRASI SEBELAS APRIL');
INSERT INTO "public"."universitas" VALUES (98030, 43091, 'SEKOLAH TINGGI TEKNOLOGI MUTU MUHAMMADIYAH');
INSERT INTO "public"."universitas" VALUES (98031, 43093, 'SEKOLAH TINGGI ILMU EKONOMI YP-KARYA');
INSERT INTO "public"."universitas" VALUES (98032, 43094, 'SEKOLAH TINGGI ILMU EKONOMI CIREBON');
INSERT INTO "public"."universitas" VALUES (98033, 43096, 'SEKOLAH TINGGI ILMU EKONOMI TRI BHAKTI');
INSERT INTO "public"."universitas" VALUES (98034, 43097, 'SEKOLAH TINGGI ILMU EKONOMI KESATUAN');
INSERT INTO "public"."universitas" VALUES (98035, 43100, 'SEKOLAH TINGGI TEKNOLOGI CIPASUNG');
INSERT INTO "public"."universitas" VALUES (98036, 43102, 'STMIK BUDHI');
INSERT INTO "public"."universitas" VALUES (98037, 43103, 'STISIP WIDYAPURI MANDIRI');
INSERT INTO "public"."universitas" VALUES (98038, 43104, 'STMIK TULUS CENDEKIA');
INSERT INTO "public"."universitas" VALUES (98039, 43105, 'STMIK MIKAR');
INSERT INTO "public"."universitas" VALUES (98040, 43106, 'SEKOLAH TINGGI ILMU HUKUM GUNUNG JATI');
INSERT INTO "public"."universitas" VALUES (98041, 43107, 'SEKOLAH TINGGI TEKNOLOGI TEXMACO');
INSERT INTO "public"."universitas" VALUES (98042, 43108, 'STMIK BANI SALEH');
INSERT INTO "public"."universitas" VALUES (98043, 43109, 'STMIK PRANATA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98044, 43110, 'STISIP TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (98045, 43111, 'STKIP ARRAHMANIYAH');
INSERT INTO "public"."universitas" VALUES (98046, 43112, 'STMIK BANTEN JAYA');
INSERT INTO "public"."universitas" VALUES (98047, 43113, 'SEKOLAH TINGGI TEKNOLOGI JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (98048, 43114, 'SEKOLAH TINGGI ILMU EKONOMI YASMI');
INSERT INTO "public"."universitas" VALUES (98049, 43115, 'SEKOLAH TINGGI FARMASI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98050, 43118, 'STMIK DCI');
INSERT INTO "public"."universitas" VALUES (98051, 43119, 'SEKOLAH TINGGI ILMU EKONOMI SUTAATMADJA');
INSERT INTO "public"."universitas" VALUES (98052, 43120, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER CIC');
INSERT INTO "public"."universitas" VALUES (98053, 43121, 'STMIK CILEGON');
INSERT INTO "public"."universitas" VALUES (98054, 43122, 'STMIK SUBANG');
INSERT INTO "public"."universitas" VALUES (98055, 43123, 'STKIP SUBANG');
INSERT INTO "public"."universitas" VALUES (98056, 43127, 'SEKOLAH TINGGI ILMU EKONOMI FAJAR');
INSERT INTO "public"."universitas" VALUES (98057, 43128, 'SEKOLAH TINGGI ILMU EKONOMI GEMA WIDYA BANGSA');
INSERT INTO "public"."universitas" VALUES (98058, 43130, 'SEKOLAH TINGGI ILMU EKONOMI CIPASUNG');
INSERT INTO "public"."universitas" VALUES (98059, 43131, 'SEKOLAH TINGGI BAHASA ASING JIA');
INSERT INTO "public"."universitas" VALUES (98060, 43132, 'SEKOLAH TINGGI TEKNOLOGI INDUSTRI DAN FARMASI BOGOR');
INSERT INTO "public"."universitas" VALUES (98061, 43134, 'SEKOLAH TINGGI ILMU EKONOMI YPN');
INSERT INTO "public"."universitas" VALUES (98062, 43135, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (98063, 43137, 'STMIK AMIK BANDUNG');
INSERT INTO "public"."universitas" VALUES (98064, 43139, 'STMIK ROSMA');
INSERT INTO "public"."universitas" VALUES (98065, 43140, 'STKIP YASIKA');
INSERT INTO "public"."universitas" VALUES (98066, 43141, 'SEKOLAH TINGGI ILMU ADMINISTRASI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98067, 43142, 'STMIK SUMEDANG');
INSERT INTO "public"."universitas" VALUES (98068, 43144, 'STMIK PAMITRAN');
INSERT INTO "public"."universitas" VALUES (98069, 43145, 'STMIK KHARISMA KARAWANG');
INSERT INTO "public"."universitas" VALUES (98070, 43148, 'STISIP SYAMSUL ULUM');
INSERT INTO "public"."universitas" VALUES (98071, 43149, 'SEKOLAH TINGGI ILMU EKONOMI PANDU MADANIA');
INSERT INTO "public"."universitas" VALUES (98072, 43153, 'SEKOLAH TINGGI ILMU EKONOMI STAN IM');
INSERT INTO "public"."universitas" VALUES (98073, 43154, 'SEKOLAH TINGGI ILMU EKONOMI ADHY NIAGA');
INSERT INTO "public"."universitas" VALUES (98074, 43155, 'SEKOLAH TINGGI ILMU EKONOMI STMY');
INSERT INTO "public"."universitas" VALUES (98075, 43156, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA AGUNG BANDUNG');
INSERT INTO "public"."universitas" VALUES (98076, 43165, 'SEKOLAH TINGGI BAHASA ASING SEBELAS APRIL SUMEDANG');
INSERT INTO "public"."universitas" VALUES (98077, 43166, 'STKIP PERSATUAN ISLAM');
INSERT INTO "public"."universitas" VALUES (98078, 43167, 'SEKOLAH TINGGI TEKNOLOGI WASTUKANCANA');
INSERT INTO "public"."universitas" VALUES (98079, 43169, 'SEKOLAH TINGGI ILMU EKONOMI PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (98080, 43170, 'SEKOLAH TINGGI ILMU EKONOMI LATIFAH MUBAROKIYAH');
INSERT INTO "public"."universitas" VALUES (98081, 43171, 'SEKOLAH TINGGI ILMU EKONOMI DEWANTARA');
INSERT INTO "public"."universitas" VALUES (98082, 43172, 'SEKOLAH TINGGI ILMU EKONOMI WIBAWA KARTA RAHARJA');
INSERT INTO "public"."universitas" VALUES (98083, 43173, 'SEKOLAH TINGGI ILMU KESEHATAN FALETEHAN');
INSERT INTO "public"."universitas" VALUES (98084, 43175, 'STMIK RAHARJA');
INSERT INTO "public"."universitas" VALUES (98085, 43176, 'SEKOLAH TINGGI ILMU EKONOMI KALPATARU');
INSERT INTO "public"."universitas" VALUES (98086, 43177, 'SEKOLAH TINGGI ILMU KOMPUTER POLTEK CIREBON');
INSERT INTO "public"."universitas" VALUES (98087, 43178, 'SEKOLAH TINGGI ILMU KESEHATAN CIREBON');
INSERT INTO "public"."universitas" VALUES (98088, 43180, 'SEKOLAH TINGGI ILMU EKONOMI BISMA LEPISI');
INSERT INTO "public"."universitas" VALUES (98089, 43181, 'SEKOLAH TINGGI ILMU EKONOMI TRIBUANA');
INSERT INTO "public"."universitas" VALUES (98090, 43182, 'SEKOLAH TINGGI ILMU TEKNIK BINA PUTRA');
INSERT INTO "public"."universitas" VALUES (98091, 43183, 'STISIP BINA PUTERA BANJAR');
INSERT INTO "public"."universitas" VALUES (98092, 43185, 'STMIK IKMI CIREBON');
INSERT INTO "public"."universitas" VALUES (98093, 43186, 'SEKOLAH TINGGI KESEHATAN INDONESIA WIRAUTAMA');
INSERT INTO "public"."universitas" VALUES (98094, 43187, 'SEKOLAH TINGGI SENI MUSIK BANDUNG');
INSERT INTO "public"."universitas" VALUES (98095, 43188, 'SEKOLAH TINGGI ILMU KESEHATAN BINA PUTERA BANJAR');
INSERT INTO "public"."universitas" VALUES (98096, 43189, 'SEKOLAH TINGGI TEKNOLOGI DR KH EZ MUTTAQIEN');
INSERT INTO "public"."universitas" VALUES (98097, 43191, 'SEKOLAH TINGGI FARMASI INDONESIA');
INSERT INTO "public"."universitas" VALUES (98098, 43192, 'SEKOLAH TINGGI TEKNOLOGI INFORMATIKA SONY SUGEMA');
INSERT INTO "public"."universitas" VALUES (98099, 43193, 'SEKOLAH TINGGI ILMU EKONOMI INSAN PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (98100, 43194, 'SEKOLAH TINGGI ILMU EKONOMI PPI');
INSERT INTO "public"."universitas" VALUES (98101, 43195, 'SEKOLAH TINGGI ILMU EKONOMI PARIPURNA');
INSERT INTO "public"."universitas" VALUES (98102, 43196, 'SEKOLAH TINGGI BAHASA ASING TECHNOCRAT');
INSERT INTO "public"."universitas" VALUES (98103, 43197, 'SEKOLAH TINGGI ILMU EKONOMI AL-KHAIRIYAH');
INSERT INTO "public"."universitas" VALUES (98104, 43198, 'STMIK GANESHA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98105, 43199, 'SEKOLAH TINGGI ILMU EKONOMI DR KH EZ MUTAQIEN');
INSERT INTO "public"."universitas" VALUES (98106, 43200, 'STMIK TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (98107, 43201, 'SEKOLAH TINGGI FARMASI YPIB CIREBON');
INSERT INTO "public"."universitas" VALUES (98108, 43203, 'SEKOLAH TINGGI ILMU KESEHATAN BHAKTI KENCANA');
INSERT INTO "public"."universitas" VALUES (98109, 43204, 'SEKOLAH TINGGI TEKNOLOGI BANTEN JAYA');
INSERT INTO "public"."universitas" VALUES (98110, 43205, 'SEKOLAH TINGGI ILMU KESEHATAN IMMANUEL BANDUNG');
INSERT INTO "public"."universitas" VALUES (98111, 43207, 'SEKOLAH TINGGI ILMU MANAJEMEN BUDI BAKTI');
INSERT INTO "public"."universitas" VALUES (98112, 43208, 'SEKOLAH TINGGI TEKNOLOGI NASIONAL BANDUNG');
INSERT INTO "public"."universitas" VALUES (98113, 43209, 'SEKOLAH TINGGI TEKNIK CIKARANG');
INSERT INTO "public"."universitas" VALUES (98114, 43211, 'SEKOLAH TINGGI ILMU KESEHATAN GARUT');
INSERT INTO "public"."universitas" VALUES (98115, 43212, 'SEKOLAH TINGGI ILMU KESEHATAN DHARMA HUSADA');
INSERT INTO "public"."universitas" VALUES (98116, 43213, 'SEKOLAH TINGGI ILMU KESEHATAN INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98117, 43214, 'SEKOLAH TINGGI ILMU ADMINISTRASI SANDIKTA');
INSERT INTO "public"."universitas" VALUES (98118, 43215, 'SEKOLAH TINGGI ILMU ADMINISTRASI BANTEN');
INSERT INTO "public"."universitas" VALUES (98119, 43216, 'SEKOLAH TINGGI ILMU KESEHATAN MAHARDIKA CIREBON');
INSERT INTO "public"."universitas" VALUES (98120, 43217, 'SEKOLAH TINGGI TEKNIK KARAWANG');
INSERT INTO "public"."universitas" VALUES (98121, 43218, 'SEKOLAH TINGGI TEKNOLOGI FATAHILLAH CILEGON');
INSERT INTO "public"."universitas" VALUES (98122, 43219, 'SEKOLAH TINGGI ILMU KESEHATAN JENDERAL ACHMAD YANI');
INSERT INTO "public"."universitas" VALUES (98123, 43220, 'SEKOLAH TINGGI ILMU KESEHATAN RESPATI');
INSERT INTO "public"."universitas" VALUES (98124, 43222, 'STIKES MUHAMMADIYAH TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (98125, 43223, 'STKIP SETIABUDHI');
INSERT INTO "public"."universitas" VALUES (98126, 43224, 'STMIK TRIGUNA UTAMA');
INSERT INTO "public"."universitas" VALUES (98127, 43225, 'STMIK INSAN PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (98128, 43226, 'SEKOLAH TINGGI TEKNOLOGI TELEMATIKA CAKRAWALA');
INSERT INTO "public"."universitas" VALUES (98129, 43227, 'SEKOLAH TINGGI ILMU EKONOMI BII BEKASI');
INSERT INTO "public"."universitas" VALUES (98130, 43229, 'SEKOLAH TINGGI TEKNOLOGI MITRA KARYA');
INSERT INTO "public"."universitas" VALUES (98131, 43231, 'SEKOLAH TINGGI ILMU KESEHATAN BANTEN');
INSERT INTO "public"."universitas" VALUES (98132, 43232, 'STMIK MERCUSUAR');
INSERT INTO "public"."universitas" VALUES (98133, 43233, 'STMIK DHARMA PUTRA');
INSERT INTO "public"."universitas" VALUES (98134, 43234, 'SEKOLAH TINGGI TEKNIK ILMU KOMPUTER INSAN UNGGUL');
INSERT INTO "public"."universitas" VALUES (98135, 43236, 'SEKOLAH TINGGI ILMU EKONOMI BUDI PERTIWI');
INSERT INTO "public"."universitas" VALUES (98136, 43238, 'STMIK MIC CIKARANG');
INSERT INTO "public"."universitas" VALUES (98137, 43239, 'STISIP BANTEN RAYA');
INSERT INTO "public"."universitas" VALUES (98138, 43240, 'SEKOLAH TINGGI TEKNOLOGI BANTEN');
INSERT INTO "public"."universitas" VALUES (98139, 43241, 'SEKOLAH TINGGI ILMU SOSIAL DAN ILMU POLITIK BEKASI');
INSERT INTO "public"."universitas" VALUES (98140, 43242, 'STMIK PGRI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98141, 43243, 'STMIK LPKIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98142, 43244, 'SEKOLAH TINGGI ILMU KESEHATAN BAKTI TUNAS HUSADA');
INSERT INTO "public"."universitas" VALUES (98143, 43246, 'SEKOLAH TINGGI BAHASA ASING CIPTO HADI PRANOTO');
INSERT INTO "public"."universitas" VALUES (98144, 43247, 'SEKOLAH TINGGI ILMU HUKUM DHARMA ANDHIGA');
INSERT INTO "public"."universitas" VALUES (98145, 43248, 'SEKOLAH TINGGI ILMU KOMPUTER BINANIAGA');
INSERT INTO "public"."universitas" VALUES (98146, 43249, 'SEKOLAH TINGGI TEKNIK MULTIMEDIA CENDIKIA ABDITAMA');
INSERT INTO "public"."universitas" VALUES (98147, 43250, 'SEKOLAH TINGGI ILMU EKONOMI ISLAMIYAH');
INSERT INTO "public"."universitas" VALUES (98148, 43251, 'STMIK MASA DEPAN');
INSERT INTO "public"."universitas" VALUES (98149, 43252, 'STISIP SETIA BUDHI');
INSERT INTO "public"."universitas" VALUES (98150, 43253, 'SEKOLAH TINGGI TEKNOLOGI MUHAMMADIYAH CILEUNGSI');
INSERT INTO "public"."universitas" VALUES (98151, 43254, 'STMIK CIKARANG');
INSERT INTO "public"."universitas" VALUES (98152, 43255, 'SEKOLAH TINGGI ILMU ADMINISTRASI CIMAHI');
INSERT INTO "public"."universitas" VALUES (98153, 43256, 'SEKOLAH TINGGI ILMU KESEHATAN BAKTI INDONESIA');
INSERT INTO "public"."universitas" VALUES (98154, 43257, 'SEKOLAH TINGGI ILMU BAHASA ASING INVADA');
INSERT INTO "public"."universitas" VALUES (98155, 43258, 'SEKOLAH TINGGI ILMU KOMUNIKASI WANGSA JAYA');
INSERT INTO "public"."universitas" VALUES (98156, 43259, 'SEKOLAH TINGGI ANALIS KIMIA CILEGON');
INSERT INTO "public"."universitas" VALUES (98157, 43260, 'SEKOLAH TINGGI TEKNOLOGI GEUSAN ULUN');
INSERT INTO "public"."universitas" VALUES (98158, 43261, 'SEKOLAH TINGGI ILMU KESEHATAN YPIB');
INSERT INTO "public"."universitas" VALUES (98159, 43262, 'SEKOLAH TINGGI TEKNOLOGI PRATAMA ADI');
INSERT INTO "public"."universitas" VALUES (98160, 43263, 'STMIK BINA INSANI');
INSERT INTO "public"."universitas" VALUES (98161, 43264, 'SEKOLAH TINGGI TEKNOLOGI PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (97561, 33009, 'SEKOLAH TINGGI FILSAFAT THEOLOGI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97562, 33011, 'STKIP PURNAMA');
INSERT INTO "public"."universitas" VALUES (97563, 33012, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97564, 33014, 'STKIP KUSUMANEGARA');
INSERT INTO "public"."universitas" VALUES (97565, 33015, 'SEKOLAH TINGGI ILMU EKONOMI SWADAYA');
INSERT INTO "public"."universitas" VALUES (97566, 33016, 'SEKOLAH TINGGI ILMU EKONOMI PERBANAS');
INSERT INTO "public"."universitas" VALUES (97567, 33019, 'SEKOLAH TINGGI ILMU ADMINISTRASI YAPANN');
INSERT INTO "public"."universitas" VALUES (97568, 33022, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER JAKARTA STI&K');
INSERT INTO "public"."universitas" VALUES (97569, 33024, 'SEKOLAH TINGGI ILMU EKONOMI YAI');
INSERT INTO "public"."universitas" VALUES (97570, 33025, 'SEKOLAH TINGGI ILMU EKONOMI KAMPUS UNGU');
INSERT INTO "public"."universitas" VALUES (97571, 33028, 'SEKOLAH TINGGI ILMU ADMINISTRASI YPIAMI');
INSERT INTO "public"."universitas" VALUES (97572, 33029, 'SEKOLAH TINGGI MANAJEMEN TRANSPORTASI TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97573, 33031, 'STMIK INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97574, 33032, 'SEKOLAH TINGGI ILMU EKONOMI KUSUMA NEGARA');
INSERT INTO "public"."universitas" VALUES (97575, 33034, 'STMIK KUWERA');
INSERT INTO "public"."universitas" VALUES (97576, 33036, 'SEKOLAH TINGGI ILMU EKONOMI DAN KEUANGAN DAN PERBANKAN');
INSERT INTO "public"."universitas" VALUES (97577, 33037, 'SEKOLAH TINGGI ILMU ADMINISTRASI MANDALA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97578, 33038, 'SEKOLAH TINGGI ILMU EKONOMI BHAKTI PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (97579, 33040, 'SEKOLAH TINGGI ILMU EKONOMI TRI DHARMA WIDYA');
INSERT INTO "public"."universitas" VALUES (97580, 33041, 'SEKOLAH TINGGI KEUANGAN NIAGA & NEGARA PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (97581, 33044, 'SEKOLAH TINGGI ILMU EKONOMI NASIONAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97582, 33046, 'SEKOLAH TINGGI TEKNOLOGI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97583, 33047, 'SEKOLAH TINGGI MANAJEMEN INDUSTRI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97584, 33049, 'SEKOLAH TINGGI TEKNOLOGI KELAUTAN HATAWANA');
INSERT INTO "public"."universitas" VALUES (97585, 33050, 'SEKOLAH TINGGI ILMU ADMINISTRASI KAWULA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97586, 33051, 'SEKOLAH TINGGI ILMU EKONOMI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97587, 33052, 'STISIP PUSAKA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97588, 33054, 'SEKOLAH TINGGI ILMU MANAJEMEN KOSGORO');
INSERT INTO "public"."universitas" VALUES (97589, 33059, 'SEKOLAH TINGGI ILMU EKONOMI JAYAKARTA');
INSERT INTO "public"."universitas" VALUES (97590, 33060, 'SEKOLAH TINGGI ILMU EKONOMI BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97591, 33061, 'SEKOLAH TINGGI HUKUM INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97592, 33062, 'SEKOLAH TINGGI ILMU EKONOMI GOTONG ROYONG');
INSERT INTO "public"."universitas" VALUES (97593, 33063, 'STMIK SWADHARMA');
INSERT INTO "public"."universitas" VALUES (97594, 33064, 'SEKOLAH TINGGI MANAJEMEN LABORA');
INSERT INTO "public"."universitas" VALUES (97595, 33066, 'SEKOLAH TINGGI ILMU EKONOMI TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97596, 33067, 'SEKOLAH TINGGI MANAJEMEN PRASETIYA MULYA');
INSERT INTO "public"."universitas" VALUES (97597, 33068, 'SEKOLAH TINGGI MANAJEMEN IPMI');
INSERT INTO "public"."universitas" VALUES (97598, 33069, 'SEKOLAH TINGGI MANAJEMEN PPM');
INSERT INTO "public"."universitas" VALUES (97599, 33070, 'SEKOLAH TINGGI PENERBANGAN AVIASI');
INSERT INTO "public"."universitas" VALUES (97600, 33072, 'SEKOLAH TINGGI ILMU EKONOMI IGI');
INSERT INTO "public"."universitas" VALUES (97601, 33074, 'SEKOLAH TINGGI ILMU EKONOMI IPWI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97602, 33075, 'SEKOLAH TINGGI MANAJEMEN IMNI');
INSERT INTO "public"."universitas" VALUES (97603, 33076, 'SEKOLAH TINGGI ILMU EKONOMI GANESHA');
INSERT INTO "public"."universitas" VALUES (97604, 33077, 'SEKOLAH TINGGI MANAJEMEN IMMI');
INSERT INTO "public"."universitas" VALUES (97605, 33078, 'SEKOLAH TINGGI ILMU EKONOMI SUPRA');
INSERT INTO "public"."universitas" VALUES (97606, 33080, 'STMIK JAYAKARTA');
INSERT INTO "public"."universitas" VALUES (97607, 33082, 'STIE JAKARTA INTERNATIONAL COLLEGE');
INSERT INTO "public"."universitas" VALUES (97608, 33083, 'SEKOLAH TINGGI TEKNIK INFORMATIK BENARIF INDONESIA');
INSERT INTO "public"."universitas" VALUES (97609, 33084, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA JAYAKARTA');
INSERT INTO "public"."universitas" VALUES (97610, 33085, 'SEKOLAH TINGGI ILMU MANAJEMEN LPMI');
INSERT INTO "public"."universitas" VALUES (97611, 33086, 'SEKOLAH TINGGI ILMU EKONOMI TAMAN SISWA');
INSERT INTO "public"."universitas" VALUES (97612, 33087, 'SEKOLAH TINGGI ILMU EKONOMI TRIANANDRA');
INSERT INTO "public"."universitas" VALUES (97613, 33088, 'STMIK MUHAMMADIYAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97614, 33092, 'STKIP ALBANA');
INSERT INTO "public"."universitas" VALUES (97615, 33093, 'SEKOLAH TINGGI ILMU EKONOMI MOH HUSNI THAMRIN');
INSERT INTO "public"."universitas" VALUES (97616, 33094, 'SEKOLAH TINGGI PERPAJAKAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97617, 33095, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA RAYA');
INSERT INTO "public"."universitas" VALUES (97618, 33096, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97619, 33099, 'SEKOLAH TINGGI ILMU EKONOMI DR MOECHTAR TALIB');
INSERT INTO "public"."universitas" VALUES (97620, 33101, 'STMIK SATYAGAMA');
INSERT INTO "public"."universitas" VALUES (97621, 33103, 'SEKOLAH TINGGI ILMU EKONOMI AHMAD DAHLAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97622, 33104, 'SEKOLAH TINGGI TEKNIK YPLN');
INSERT INTO "public"."universitas" VALUES (97623, 33105, 'SEKOLAH TINGGI ILMU EKONOMI TRIGUNA');
INSERT INTO "public"."universitas" VALUES (97624, 33106, 'SEKOLAH TINGGI ILMU KOMUNIKASI INTER STUDI');
INSERT INTO "public"."universitas" VALUES (97625, 33107, 'SEKOLAH TINGGI ILMU EKONOMI TUNAS NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97626, 33109, 'SEKOLAH TINGGI ILMU EKONOMI ISM');
INSERT INTO "public"."universitas" VALUES (97627, 33110, 'STMIK BINA MULYA');
INSERT INTO "public"."universitas" VALUES (97628, 33111, 'SEKOLAH TINGGI BAHASA ASING LIA');
INSERT INTO "public"."universitas" VALUES (97629, 33112, 'SEKOLAH TINGGI ILMU KOMUNIKASI LSPR');
INSERT INTO "public"."universitas" VALUES (97630, 33114, 'SEKOLAH TINGGI PARIWISATA TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97631, 33115, 'STIE PENGEMBANGAN BISNIS DAN MANAJEMEN');
INSERT INTO "public"."universitas" VALUES (97632, 33116, 'SEKOLAH TINGGI BAHASA ASING PERTIWI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97633, 33117, 'SEKOLAH TINGGI ILMU KESEHATAN SINT CAROLUS');
INSERT INTO "public"."universitas" VALUES (97634, 33119, 'SEKOLAH TINGGI ILMU EKONOMI JAYAKUSUMA');
INSERT INTO "public"."universitas" VALUES (97635, 33120, 'SEKOLAH TINGGI ILMU EKONOMI KASIH BANGSA');
INSERT INTO "public"."universitas" VALUES (97636, 33121, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA BUMI PUTRA');
INSERT INTO "public"."universitas" VALUES (97637, 33122, 'SEKOLAH TINGGI ILMU ADMINISTRASI & SEKRETARI ASMI');
INSERT INTO "public"."universitas" VALUES (97638, 33123, 'SEKOLAH TINGGI MANAJEMEN YAKSI');
INSERT INTO "public"."universitas" VALUES (97639, 33124, 'SEKOLAH TINGGI ILMU EKONOMI SAILENDRA');
INSERT INTO "public"."universitas" VALUES (97640, 33125, 'SEKOLAH TINGGI ILMU EKONOMI MAIJI');
INSERT INTO "public"."universitas" VALUES (97641, 33126, 'SEKOLAH TINGGI ILMU EKONOMI WIYATAMANDALA');
INSERT INTO "public"."universitas" VALUES (97642, 33127, 'STMIK MUHAMMAD HUSNI THAMRIN');
INSERT INTO "public"."universitas" VALUES (97643, 33128, 'SEKOLAH TINGGI ILMU EKONOMI YPBI');
INSERT INTO "public"."universitas" VALUES (97644, 33129, 'SEKOLAH TINGGI ILMU KESEHATAN INDONESIA MAJU');
INSERT INTO "public"."universitas" VALUES (97645, 33131, 'SEKOLAH TINGGI ILMU EKONOMI WIRA BAKTI');
INSERT INTO "public"."universitas" VALUES (97646, 33132, 'STIE PARIWISATA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97647, 33133, 'STIAS BUNDA HATI KUDUS');
INSERT INTO "public"."universitas" VALUES (97648, 33134, 'SEKOLAH TINGGI PARIWISATA SAHID');
INSERT INTO "public"."universitas" VALUES (97649, 33135, 'SEKOLAH TINGGI ILMU KESEHATAN BINAWAN');
INSERT INTO "public"."universitas" VALUES (97650, 33136, 'SEKOLAH TINGGI TEKNOLOGI 10 NOVEMBER');
INSERT INTO "public"."universitas" VALUES (97651, 33137, 'SEKOLAH TINGGI BAHASA ASING IEC JAKARTA');
INSERT INTO "public"."universitas" VALUES (97652, 33138, 'SEKOLAH TINGGI ILMU MARITIM AMI');
INSERT INTO "public"."universitas" VALUES (97653, 33139, 'SEKOLAH TINGGI ILMU KESEHATAN PAMENTAS');
INSERT INTO "public"."universitas" VALUES (97654, 33140, 'STMIK WIDURI');
INSERT INTO "public"."universitas" VALUES (97655, 33143, 'SEKOLAH TINGGI MANAJEMEN TRANSPORTASI MALAHAYATI');
INSERT INTO "public"."universitas" VALUES (97656, 33147, 'SEKOLAH TINGGI ILMU KESEHATAN ISTARA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97657, 33149, 'STMIK JIBES');
INSERT INTO "public"."universitas" VALUES (97658, 33150, 'ST ILMU KOMPUTER CIPTA KARYA INFORMATIKA');
INSERT INTO "public"."universitas" VALUES (97659, 33151, 'SEKOLAH TINGGI ILMU KOMUNIKASI ITKP');
INSERT INTO "public"."universitas" VALUES (97660, 33152, 'SEKOLAH TINGGI MANAJEMEN ASURANSI TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97661, 33154, 'SEKOLAH TINGGI ILMU KOMUNIKASI PROFESI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97662, 33156, 'SEKOLAH TINGGI ILMU KESEHATAN MEDISTRA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97663, 33157, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA PERSADA');
INSERT INTO "public"."universitas" VALUES (97664, 33158, 'SEKOLAH TINGGI ILMU EKONOMI GANDHI');
INSERT INTO "public"."universitas" VALUES (97665, 33159, 'STKIP SULUH BANGSA');
INSERT INTO "public"."universitas" VALUES (97666, 33160, 'SEKOLAH TINGGI TEKNOLOGI SAPTA TARUNA');
INSERT INTO "public"."universitas" VALUES (97667, 33162, 'STMIK JAKARTA INSTITUTE OF TECHNOLOGY');
INSERT INTO "public"."universitas" VALUES (97668, 33163, 'SEKOLAH TINGGI ILMU KOMUNIKASI INDONESIA MAJU');
INSERT INTO "public"."universitas" VALUES (97669, 33164, 'STMIK MAHAKARYA');
INSERT INTO "public"."universitas" VALUES (97670, 33165, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER NUSA MANDIRI');
INSERT INTO "public"."universitas" VALUES (97671, 33167, 'STIKES KESETIAKAWANAN SOSIAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97672, 33168, 'STIE INDONESIA BANKING SCHOOL');
INSERT INTO "public"."universitas" VALUES (97673, 33170, 'STIKES PERSADA HUSADA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97674, 33171, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA RIA HUSADA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97675, 33172, 'STIKES MOHAMMAD HUSNI THAMRIN');
INSERT INTO "public"."universitas" VALUES (97676, 33173, 'SEKOLAH TINGGI ILMU KESEHATAN ABDI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97677, 33175, 'SEKOLAH TINGGI TEKNOLOGI INFORMASI NIIT');
INSERT INTO "public"."universitas" VALUES (96770, 1016, 'UNIVERSITAS MATARAM');
INSERT INTO "public"."universitas" VALUES (97678, 33176, 'SEKOLAH TINGGI MANAJEMEN RISIKO DAN ASURANSI');
INSERT INTO "public"."universitas" VALUES (97679, 33177, 'SEKOLAH TINGGI ILMU PEMERINTAHAN ABDI NEGARA');
INSERT INTO "public"."universitas" VALUES (97680, 33178, 'STMIK JAYABAYA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97681, 33179, 'SEKOLAH TINGGI ILMU KESEHATAN JAYAKARTA');
INSERT INTO "public"."universitas" VALUES (97682, 33180, 'STIMIK SUPRA');
INSERT INTO "public"."universitas" VALUES (97683, 33181, 'STMIK INOVASI SAINS TEKNOLOGI BISNIS');
INSERT INTO "public"."universitas" VALUES (97684, 33182, 'STIBA INDONESIA LPI');
INSERT INTO "public"."universitas" VALUES (97685, 33183, 'SEKOLAH TINGGI ILMU EKONOMI SANTA URSULA');
INSERT INTO "public"."universitas" VALUES (97686, 33184, 'SEKOLAH TINGGI DESAIN INTERSTUDI');
INSERT INTO "public"."universitas" VALUES (97687, 33185, 'SEKOLAH TINGGI PARIWISATA PELITA HARAPAN');
INSERT INTO "public"."universitas" VALUES (97688, 33186, 'STIE BAKRIE SCHOOL OF MANAGEMENT');
INSERT INTO "public"."universitas" VALUES (97689, 33187, 'STMIK BIDAKARA');
INSERT INTO "public"."universitas" VALUES (97690, 33188, 'STIE UNISADHUGUNA');
INSERT INTO "public"."universitas" VALUES (97691, 33189, 'SEKOLAH TINGGI INTERNASIONAL KONSERVATORI MUSIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (97692, 33190, 'SEKOLAH TINGGI ILMU KESEHATAN PERTAMEDIKA');
INSERT INTO "public"."universitas" VALUES (97693, 33192, 'SEKOLAH TINGGI ILMU KESEHATAN SISMADI');
INSERT INTO "public"."universitas" VALUES (97694, 33193, 'STKIP KEBANGKITAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (97695, 33194, 'STIKS TARAKANITA');
INSERT INTO "public"."universitas" VALUES (97696, 33195, 'SEKOLAH TINGGI MEDIA KOMUNIKASI TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97697, 33196, 'STMIK ERESHA');
INSERT INTO "public"."universitas" VALUES (97698, 33197, 'STIE MANAJEMEN BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97699, 33198, 'STMIK ISLAM INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97700, 33199, 'SEKOLAH TINGGI DESAIN LASALLE');
INSERT INTO "public"."universitas" VALUES (97701, 33200, 'STIKES BHAKTI PERTIWI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97702, 33201, 'STIKES KHARISMA PERSADA');
INSERT INTO "public"."universitas" VALUES (97703, 33202, 'SEKOLAH TINGGI ILMU EKONOMI PUTERA SAMPOERNA');
INSERT INTO "public"."universitas" VALUES (97704, 33203, 'SEKOLAH TINGGI ILMU EKONOMI BPKP');
INSERT INTO "public"."universitas" VALUES (97705, 33204, 'STIE PRASETIYA MULYA');
INSERT INTO "public"."universitas" VALUES (97706, 33205, 'SEKOLAH TINGGI KEPEMERINTAHAN DAN KEBIJAKAN PUBLIK');
INSERT INTO "public"."universitas" VALUES (97707, 33206, 'SEKOLAH TINGGI ILMU MANAJEMEN DAN ILMU KOMPUTER ESQ');
INSERT INTO "public"."universitas" VALUES (97708, 33207, 'SEKOLAH TINGGI MUSIK BASUKI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97709, 33208, 'STIH INDONESIA JENTERA');
INSERT INTO "public"."universitas" VALUES (97710, 33209, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA KELUARGA');
INSERT INTO "public"."universitas" VALUES (97711, 33210, 'STIH LITIGASI');
INSERT INTO "public"."universitas" VALUES (97712, 33211, 'SEKOLAH TINGGI ILMU MANAJEMEN SAINT MARY');
INSERT INTO "public"."universitas" VALUES (97713, 33212, 'SEKOLAH TINGGI ILMU EKONOMI MEDIA NUSANTARA CITRA');
INSERT INTO "public"."universitas" VALUES (97714, 33213, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN MEDIA NUSANTARA CITRA');
INSERT INTO "public"."universitas" VALUES (97715, 33214, 'SEKOLAH TINGGI ILMU KESEHATAN TARUMANAGARA');
INSERT INTO "public"."universitas" VALUES (97716, 33215, 'SEKOLAH TINGGI ILMU KESEHATAN BUDI KEMULIAAN');
INSERT INTO "public"."universitas" VALUES (97717, 33216, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER INDO DAYA SUVANA');
INSERT INTO "public"."universitas" VALUES (97718, 33217, 'SEKOLAH TINGGI ILMU KESEHATAN RS HUSADA');
INSERT INTO "public"."universitas" VALUES (97719, 33218, 'SEKOLAH TINGGI ILMU EKONOMI DARUNNAJAH');
INSERT INTO "public"."universitas" VALUES (97720, 33219, 'SEKOLAH TINGGI ILMU KESEHATAN IKIFA');
INSERT INTO "public"."universitas" VALUES (97721, 33220, 'SEKOLAH TINGGI ILMU KESEHATAN RSPAD GATOT SOEBROTO');
INSERT INTO "public"."universitas" VALUES (97722, 34004, 'AKADEMI AKUNTANSI BOROBUDUR');
INSERT INTO "public"."universitas" VALUES (97723, 34006, 'AKADEMI AKUNTANSI ARTAWIYATA INDO-LPI');
INSERT INTO "public"."universitas" VALUES (97724, 34008, 'AKADEMI AKUNTANSI JAYABAYA');
INSERT INTO "public"."universitas" VALUES (97725, 34009, 'AKADEMI AKUNTANSI NASIONAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (97726, 34011, 'AKADEMI AKUNTANSI YAI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97727, 34013, 'AKADEMI BAHASA ASING BOROBUDUR');
INSERT INTO "public"."universitas" VALUES (97728, 34018, 'AKADEMI KEUANGAN DAN PERBANKAN YPK');
INSERT INTO "public"."universitas" VALUES (97729, 34019, 'AKADEMI KEUANGAN DAN PERBANKAN LPI');
INSERT INTO "public"."universitas" VALUES (97730, 34024, 'AKADEMI TEKNOLOGI GRAFIKA INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97731, 34030, 'AKADEMI MARITIM NASIONAL JAYA');
INSERT INTO "public"."universitas" VALUES (97732, 34032, 'AKADEMI MANAJEMEN PERUSAHAAN JAYABAYA');
INSERT INTO "public"."universitas" VALUES (97733, 34033, 'AKADEMI KEUANGAN DAN PERBANKAN BOROBUDUR');
INSERT INTO "public"."universitas" VALUES (97734, 34036, 'AKADEMI PERAWATAN RS PGI CIKINI');
INSERT INTO "public"."universitas" VALUES (97735, 34050, 'AKADEMI BAHASA ASING NASIONAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (97736, 34058, 'AKADEMI MARITIM DJADAJAT');
INSERT INTO "public"."universitas" VALUES (97737, 34060, 'AKADEMI SEKRETARI DAN MANAJEMEN PURNAMA');
INSERT INTO "public"."universitas" VALUES (97738, 34061, 'AKADEMI PARIWISATA NASIONAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (97739, 34062, 'AKADEMI PARIWISATA INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97740, 34075, 'AKADEMI TEKNOLOGI GRAFIKA TRISAKTI');
INSERT INTO "public"."universitas" VALUES (97741, 34079, 'AKADEMI SEKRETARI DAN MANAJEMEN SAINT MARY');
INSERT INTO "public"."universitas" VALUES (97742, 34081, 'AKADEMI LITIGASI INDONESIA PENGAYOMAN');
INSERT INTO "public"."universitas" VALUES (97743, 34083, 'AKADEMI SENI RUPA DAN DESAIN ISWI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97744, 34084, 'AKADEMI PARIWISATA TRIDAYA');
INSERT INTO "public"."universitas" VALUES (97745, 34086, 'AKADEMI AKUNTANSI SYAFA AT INDONESIA');
INSERT INTO "public"."universitas" VALUES (97746, 34089, 'AKADEMI SEKRETARIS ISWI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97747, 34090, 'AMIK ANDALAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97748, 34091, 'AKADEMI BAHASA ASING SAINT MARY');
INSERT INTO "public"."universitas" VALUES (97749, 34093, 'AKADEMI PERBANKAN YUKI');
INSERT INTO "public"."universitas" VALUES (97750, 34095, 'AKADEMI KIMIA ANALIS CARAKA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97751, 34099, 'AKADEMI BAHASA ASING SANTA URSULA');
INSERT INTO "public"."universitas" VALUES (97752, 34102, 'AKADEMI PARIWISATA NUSANTARA JAYA');
INSERT INTO "public"."universitas" VALUES (97753, 34103, 'AKADEMI PARIWISATA PARAMITHA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97754, 34104, 'AKADEMI SEKRETARI BUDI LUHUR');
INSERT INTO "public"."universitas" VALUES (97755, 34105, 'AKADEMI SEKRETARI DAN MANAJEMEN DON BOSCO');
INSERT INTO "public"."universitas" VALUES (97756, 34106, 'AKADEMI PARIWISATA JAKARTA INTERNATIONAL HOTEL');
INSERT INTO "public"."universitas" VALUES (97757, 34109, 'AKADEMI PARIWISATA PATRIA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97758, 34110, 'AMIK BSI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97759, 34112, 'AKADEMI KOMUNIKASI MEDIA RADIO DAN TV JAKARTA');
INSERT INTO "public"."universitas" VALUES (97760, 34117, 'AKADEMI AKUNTANSI BENTARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97761, 34118, 'AKADEMI TELEVISI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97762, 34119, 'AKADEMI TELEKOMUNIKASI INDONESIA GEMILANG');
INSERT INTO "public"."universitas" VALUES (97763, 34120, 'AKADEMI PARIWISATA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97764, 34121, 'AKADEMI MARITIM PEMBANGUNAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97765, 34124, 'AKADEMI PARIWISATA PERTIWI');
INSERT INTO "public"."universitas" VALUES (97766, 34125, 'AKADEMI BAHASA ASING PRAWIRA MARTA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97767, 34128, 'AKADEMI PARIWISATA MATOA');
INSERT INTO "public"."universitas" VALUES (97768, 34129, 'AMIK MPU TANTULAR');
INSERT INTO "public"."universitas" VALUES (97769, 34130, 'AKADEMI PARIWISATA GSP INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97770, 34131, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER YAPRI');
INSERT INTO "public"."universitas" VALUES (97771, 34134, 'AKADEMI PARIWISATA SAINT MARY');
INSERT INTO "public"."universitas" VALUES (97772, 34135, 'AKADEMI SEKRETARI INTERSTUDI');
INSERT INTO "public"."universitas" VALUES (97773, 34136, 'AKADEMI SEKRETARI & MANAJEMEN DHARMA BUDHI BHAKTI');
INSERT INTO "public"."universitas" VALUES (97774, 34137, 'AKADEMI SEKRETARI DAN MANAJEMEN BSI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97775, 34138, 'AKADEMI SEKRETARI DAN MANAJEMEN PITALOKA');
INSERT INTO "public"."universitas" VALUES (97776, 34139, 'AKADEMI KEBIDANAN KERIS HUSADA');
INSERT INTO "public"."universitas" VALUES (97777, 34140, 'AKADEMI KEPERAWATAN KERIS HUSADA');
INSERT INTO "public"."universitas" VALUES (97778, 34141, 'AMIK LAKSI-31');
INSERT INTO "public"."universitas" VALUES (97779, 34142, 'AKADEMI KEBIDANAN AL-FATHONAH');
INSERT INTO "public"."universitas" VALUES (97780, 34145, 'AKADEMI SEKRETARI SAINT THERESIA');
INSERT INTO "public"."universitas" VALUES (97781, 34147, 'AKADEMI TEKNIK INFORMATIKA TUNAS BANGSA');
INSERT INTO "public"."universitas" VALUES (97782, 34149, 'AKADEMI TEKNIK TELEKOMUNIKASI SANDHY PUTRA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97783, 34150, 'AKADEMI PARIWISATA KRISANTI WIDYA MANDIRI');
INSERT INTO "public"."universitas" VALUES (97784, 34151, 'AKADEMI PARIWISATA BUNDA MULIA');
INSERT INTO "public"."universitas" VALUES (97785, 34154, 'AKADEMI KEBIDANAN PELITA PERSADA');
INSERT INTO "public"."universitas" VALUES (97786, 34156, 'AKADEMI BAHASA ASING BSI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97787, 34157, 'AKADEMI KEBIDANAN SULUH BANGSA');
INSERT INTO "public"."universitas" VALUES (97788, 34159, 'AKADEMI KEBIDANAN KARTIKA MITRA HUSADA');
INSERT INTO "public"."universitas" VALUES (97789, 34160, 'AKADEMI KEBIDANAN SISMADI');
INSERT INTO "public"."universitas" VALUES (97790, 34161, 'AKADEMI KEBIDANAN WIDYA KARSA JAYAKARTA');
INSERT INTO "public"."universitas" VALUES (97791, 34162, 'AKADEMI KOMUNIKASI BSI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97792, 34163, 'AKADEMI KEBIDANAN YPDR');
INSERT INTO "public"."universitas" VALUES (97793, 34167, 'AKADEMI KEBIDANAN PRESTASI AGUNG');
INSERT INTO "public"."universitas" VALUES (97794, 34168, 'AKADEMI KOMUNIKASI SAE INDONESIA');
INSERT INTO "public"."universitas" VALUES (97795, 34169, 'AKADEMI KEBIDANAN MITRA PERSAHABATAN');
INSERT INTO "public"."universitas" VALUES (97796, 34170, 'AKADEMI KEBIDANAN YASPEN TUGU IBU');
INSERT INTO "public"."universitas" VALUES (97797, 34171, 'AKADEMI KEPERAWATAN YAYASAN JALAN KIMIA');
INSERT INTO "public"."universitas" VALUES (97798, 34172, 'AKADEMI SEKRETARIS DAN MANAJEMEN LAKSI-31');
INSERT INTO "public"."universitas" VALUES (97799, 34173, 'AKADEMI KEPERAWATAN RUMAH SAKIT JAKARTA');
INSERT INTO "public"."universitas" VALUES (97800, 34174, 'AKADEMI KEPERAWATAN AS-SYAFI IYAH BEKASI');
INSERT INTO "public"."universitas" VALUES (97801, 34175, 'AKADEMI KEBIDANAN FARAMA MULYA');
INSERT INTO "public"."universitas" VALUES (97802, 34177, 'AKADEMI KEPERAWATAN HANG TUAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97803, 34178, 'AKADEMI KEPERAWATAN PASAR REBO JAKARTA');
INSERT INTO "public"."universitas" VALUES (97804, 34179, 'AKADEMI KEPERAWATAN YASPEN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97805, 34180, 'AKADEMI KEPERAWATAN RSP TNI-AU JAKARTA');
INSERT INTO "public"."universitas" VALUES (97806, 34181, 'AKADEMI KEPERAWATAN ROYHAN');
INSERT INTO "public"."universitas" VALUES (97807, 34182, 'AKADEMI FARMASI HANG TUAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97808, 34183, 'AKADEMI TEKNIK GIGI HANG TUAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97809, 34186, 'AKADEMI KEPERAWATAN HERMINA MANGGALA HUSADA');
INSERT INTO "public"."universitas" VALUES (97810, 34187, 'AKADEMI KEPERAWATAN BERKALA WIDYA HUSADA');
INSERT INTO "public"."universitas" VALUES (97811, 34190, 'AKADEMI KEPERAWATAN RSU FK-UKI');
INSERT INTO "public"."universitas" VALUES (97812, 34191, 'AKADEMI KEPERAWATAN HARUM');
INSERT INTO "public"."universitas" VALUES (97813, 34194, 'AKADEMI PARIWISATA SINAR SURYA');
INSERT INTO "public"."universitas" VALUES (97814, 34195, 'AKADEMI PEREKAM MEDIS DAN INFOKES BHUMI HUSADA');
INSERT INTO "public"."universitas" VALUES (97815, 34196, 'AKADEMI KESEHATAN SWAKARSA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97816, 34197, 'AKADEMI FARMASI BHUMI HUSADA');
INSERT INTO "public"."universitas" VALUES (97817, 34198, 'AKADEMI KEBIDANAN BHINNEKA JAKARTA SATU');
INSERT INTO "public"."universitas" VALUES (97818, 34199, 'AKADEMI REFRAKSI OPTISI KARTIKA INDERA PERSADA');
INSERT INTO "public"."universitas" VALUES (97819, 34200, 'AKADEMI KEBIDANAN JAKARTA MITRA SEJAHTERA');
INSERT INTO "public"."universitas" VALUES (97820, 34201, 'AKADEMI KEBIDANAN YAYASAN RUMAH SAKIT JAKARTA');
INSERT INTO "public"."universitas" VALUES (97821, 34202, 'AKADEMI FARMASI MAHADHIKA');
INSERT INTO "public"."universitas" VALUES (97822, 34204, 'AKADEMI KEPERAWATAN RS HUSADA');
INSERT INTO "public"."universitas" VALUES (97823, 34205, 'AKADEMI MANAJEMEN KEUANGAN BSI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97824, 34206, 'AKADEMI AUDIOLOGI INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97825, 34207, 'AKADEMI KEBIDANAN JAYAKARTA SEHAT');
INSERT INTO "public"."universitas" VALUES (97826, 34208, 'AKADEMI TERAPI WICARA');
INSERT INTO "public"."universitas" VALUES (97827, 34209, 'AKADEMI KEPERAWATAN BINA INSAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97828, 34210, 'AKADEMI KEPERAWATAN POLRI');
INSERT INTO "public"."universitas" VALUES (97829, 34211, 'AKADEMI KEPERAWATAN HUSADA KARYA JAYA');
INSERT INTO "public"."universitas" VALUES (97830, 34212, 'AKADEMI KEBIDANAN KARTINI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97831, 34213, 'AKADEMI PARIWISATA BHAKTI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97832, 34214, 'AKADEMI KEPERAWATAN FATMAWATI');
INSERT INTO "public"."universitas" VALUES (97833, 34215, 'AKADEMI KEPERAWATAN MITRA KELUARGA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97834, 34216, 'AKADEMI KEPERAWATAN UPN VETERAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97835, 34217, 'AKADEMI FISIOTERAPI UPN VETERAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (97836, 34218, 'AKADEMI KEPERAWATAN SUMBER WARAS');
INSERT INTO "public"."universitas" VALUES (97837, 34219, 'AKADEMI KEBIDANAN BUDI KEMULIAAN');
INSERT INTO "public"."universitas" VALUES (97838, 34220, 'AKADEMI KEBIDANAN RSPAD GATOT SOEBROTO');
INSERT INTO "public"."universitas" VALUES (97839, 34221, 'AKADEMI FARMASI IKIFA');
INSERT INTO "public"."universitas" VALUES (97840, 34223, 'AKADEMI KEPERAWATAN PELNI');
INSERT INTO "public"."universitas" VALUES (97841, 34224, 'AKADEMI KEPERAWATAN RSPAD GATOT SUBROTO');
INSERT INTO "public"."universitas" VALUES (97842, 34225, 'AKADEMI KESEHATAN GIGI DITKESAD JAKARTA');
INSERT INTO "public"."universitas" VALUES (97843, 34226, 'AKADEMI KEPERAWATAN ANDALUSIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97844, 34227, 'AKADEMI KESEHATAN LINGKUNGAN ANDALUSIA');
INSERT INTO "public"."universitas" VALUES (97845, 34228, 'AKADEMI GIZI ANDALUSIA');
INSERT INTO "public"."universitas" VALUES (97846, 34229, 'AKADEMI KEPERAWATAN YPDR');
INSERT INTO "public"."universitas" VALUES (97847, 34230, 'AKADEMI REFRAKSI OPTISI DAN OPTOMETRY GAPOPIN');
INSERT INTO "public"."universitas" VALUES (97848, 34231, 'AKADEMI KEPERAWATAN ANTARIKSA');
INSERT INTO "public"."universitas" VALUES (97849, 34232, 'AKADEMI KEPERAWATAN YAYASAN PERGURUAN DJUBLEG RANUATMADJA');
INSERT INTO "public"."universitas" VALUES (97850, 34234, 'AKADEMI TEKNIK RADIODIAGNOSTIK DAN RADIOTERAPI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97851, 34235, 'AKADEMI KEPERAWATAN YAYASAN DHARMA BHAKTI JAKARTA');
INSERT INTO "public"."universitas" VALUES (97852, 34236, 'AKADEMI FISIOTERAPI UNIVERSITAS KRISTEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97853, 34237, 'AKADEMI REFRAKSI OPTISI LEPRINDO JAKARTA');
INSERT INTO "public"."universitas" VALUES (97854, 34238, 'DJUBLEG RANUATMADJA');
INSERT INTO "public"."universitas" VALUES (97855, 34239, 'AKADEMI KEPERAWATAN ANDAKARA');
INSERT INTO "public"."universitas" VALUES (97856, 34240, 'AKADEMI TEKNIK ELEKTROMEDIK ANDAKARA');
INSERT INTO "public"."universitas" VALUES (97857, 34241, 'AKADEMI BAKTI KEMANUSIAAN PALANG MERAH INDONESIA');
INSERT INTO "public"."universitas" VALUES (97858, 34242, 'AKADEMI OLAHRAGA PRESTASI NASIONAL');
INSERT INTO "public"."universitas" VALUES (97859, 34243, 'AKADEMI KESEHATAN YAYASAN RUMAH SAKIT JAKARTA');
INSERT INTO "public"."universitas" VALUES (97860, 35001, 'POLITEKNIK BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97861, 35002, 'POLITEKNIK SWADHARMA');
INSERT INTO "public"."universitas" VALUES (97862, 35003, 'POLITEKNIK MANUFAKTUR ASTRA');
INSERT INTO "public"."universitas" VALUES (97863, 35004, 'POLITEKNIK BUNDA KANDUNG');
INSERT INTO "public"."universitas" VALUES (97864, 35006, 'POLITEKNIK TUGU JAKARTA');
INSERT INTO "public"."universitas" VALUES (97865, 35007, 'POLITEKNIK TRISILA DHARMA');
INSERT INTO "public"."universitas" VALUES (97866, 35008, 'POLITEKNIK LP3I JAKARTA');
INSERT INTO "public"."universitas" VALUES (97867, 35009, 'POLITEKNIK GLOBAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97868, 35010, 'POLITEKNIK KARYA HUSADA');
INSERT INTO "public"."universitas" VALUES (97869, 35011, 'AKADEMI KESEHATAN LINGKUNGAN ANDALUSIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (97870, 35012, 'POLITEKNIK SOCA');
INSERT INTO "public"."universitas" VALUES (97871, 35013, 'POLITEKNIK ORANG TUA');
INSERT INTO "public"."universitas" VALUES (97872, 35014, 'POLITEKNIK BENTARA CITRA BANGSA');
INSERT INTO "public"."universitas" VALUES (97873, 35015, 'POLITEKNIK BISNIS DAN PASAR MODAL');
INSERT INTO "public"."universitas" VALUES (97874, 35016, 'POLITEKNIK SAHID');
INSERT INTO "public"."universitas" VALUES (97875, 35017, 'POLITEKNIK HANG TUAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (97876, 35018, 'POLITEKNIK JAKARTA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97877, 35019, 'POLITEKNIK KESEHATAN HERMINA');
INSERT INTO "public"."universitas" VALUES (97878, 36001, 'AKADEMI KOMUNITAS KOSMETIK RISTRA');
INSERT INTO "public"."universitas" VALUES (97879, 41001, 'UNIVERSITAS IBN KHALDUN');
INSERT INTO "public"."universitas" VALUES (97880, 41002, 'UNIVERSITAS ISLAM BANDUNG');
INSERT INTO "public"."universitas" VALUES (97881, 41003, 'UNIVERSITAS ISLAM NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97882, 41004, 'UNIVERSITAS PAKUAN');
INSERT INTO "public"."universitas" VALUES (97883, 41005, 'UNIVERSITAS ISLAM SYEKH-YUSUF');
INSERT INTO "public"."universitas" VALUES (97884, 41006, 'UNIVERSITAS KATOLIK PARAHYANGAN');
INSERT INTO "public"."universitas" VALUES (97885, 41007, 'UNIVERSITAS KRISTEN MARANATHA');
INSERT INTO "public"."universitas" VALUES (97886, 41008, 'UNIVERSITAS PASUNDAN');
INSERT INTO "public"."universitas" VALUES (97887, 41009, 'UNIVERSITAS SWADAYA GUNUNG DJATI');
INSERT INTO "public"."universitas" VALUES (97888, 41010, 'UNIVERSITAS 17 AGUSTUS 1945 CIREBON');
INSERT INTO "public"."universitas" VALUES (97889, 41011, 'UNIVERSITAS ADVENT INDONESIA');
INSERT INTO "public"."universitas" VALUES (97890, 41012, 'UNIVERSITAS SILIWANGI');
INSERT INTO "public"."universitas" VALUES (97891, 41014, 'UNIVERSITAS WIRALODRA');
INSERT INTO "public"."universitas" VALUES (97892, 41015, 'UNIVERSITAS LANGLANG BUANA');
INSERT INTO "public"."universitas" VALUES (97893, 41016, 'UNIVERSITAS BANDUNG RAYA');
INSERT INTO "public"."universitas" VALUES (97894, 41017, 'UNIVERSITAS SINGAPERBANGSA KARAWANG');
INSERT INTO "public"."universitas" VALUES (97895, 41018, 'UNIVERSITAS ISLAM 45');
INSERT INTO "public"."universitas" VALUES (97896, 41019, 'UNIVERSITAS DJUANDA');
INSERT INTO "public"."universitas" VALUES (97897, 41020, 'UNIVERSITAS NUSA BANGSA');
INSERT INTO "public"."universitas" VALUES (97898, 41021, 'UNIVERSITAS JENDERAL ACHMAD YANI');
INSERT INTO "public"."universitas" VALUES (97899, 41022, 'UNIVERSITAS WINAYA MUKTI');
INSERT INTO "public"."universitas" VALUES (97900, 41023, 'UNIVERSITAS GALUH');
INSERT INTO "public"."universitas" VALUES (97901, 41024, 'UNIVERSITAS GARUT');
INSERT INTO "public"."universitas" VALUES (97902, 41025, 'UNIVERSITAS NURTANIO');
INSERT INTO "public"."universitas" VALUES (97903, 41026, 'UNIVERSITAS SWISS GERMAN');
INSERT INTO "public"."universitas" VALUES (97904, 41027, 'UNIVERSITAS KOMPUTER INDONESIA');
INSERT INTO "public"."universitas" VALUES (97905, 41028, 'UNIVERSITAS ARS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97906, 41029, 'UNIVERSITAS MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (97907, 41030, 'UNIVERSITAS SURYAKANCANA');
INSERT INTO "public"."universitas" VALUES (97908, 41031, 'UNIVERSITAS NASIONAL PASIM');
INSERT INTO "public"."universitas" VALUES (97909, 41032, 'UNIVERSITAS MATHLA UL ANWAR');
INSERT INTO "public"."universitas" VALUES (97910, 41033, 'UNIVERSITAS PAMULANG');
INSERT INTO "public"."universitas" VALUES (97911, 41034, 'UNIVERSITAS WIDYATAMA');
INSERT INTO "public"."universitas" VALUES (97912, 41035, 'UNIVERSITAS PUTRA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97913, 41036, 'UNIVERSITAS KEBANGSAAN');
INSERT INTO "public"."universitas" VALUES (97914, 41037, 'UNIVERSITAS AL-GHIFARI');
INSERT INTO "public"."universitas" VALUES (97915, 41038, 'UNIVERSITAS KUNINGAN');
INSERT INTO "public"."universitas" VALUES (97916, 41039, 'UNIVERSITAS PRAMITA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97917, 41040, 'UNIVERSITAS MUHAMMADIYAH SUKABUMI');
INSERT INTO "public"."universitas" VALUES (97918, 41041, 'UNIVERSITAS PRESIDEN');
INSERT INTO "public"."universitas" VALUES (97919, 41042, 'UNIVERSITAS SUBANG');
INSERT INTO "public"."universitas" VALUES (97920, 41043, 'UNIVERSITAS MAJALENGKA');
INSERT INTO "public"."universitas" VALUES (97921, 41044, 'UNIVERSITAS SANGGA BUANA');
INSERT INTO "public"."universitas" VALUES (97922, 41045, 'UNIVERSITAS PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (97923, 41046, 'UNIVERSITAS INFORMATIKA DAN BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97924, 41047, 'UNIVERSITAS WANITA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97925, 41048, 'UNIVERSITAS BALE BANDUNG');
INSERT INTO "public"."universitas" VALUES (97926, 41049, 'UNIVERSITAS SERANG RAYA');
INSERT INTO "public"."universitas" VALUES (97927, 41050, 'UNIVERSITAS TEKNOLOGI NUSANTARA CILEGON');
INSERT INTO "public"."universitas" VALUES (97928, 41051, 'UNIVERSITAS MUHAMMADIYAH TANGERANG');
INSERT INTO "public"."universitas" VALUES (97929, 41052, 'UNIVERSITAS BSI');
INSERT INTO "public"."universitas" VALUES (97930, 41053, 'UNIVERSITAS PEMBANGUNAN JAYA');
INSERT INTO "public"."universitas" VALUES (97931, 41054, 'UNIVERSITAS NAHDLATUL ULAMA CIREBON');
INSERT INTO "public"."universitas" VALUES (97932, 41055, 'UNIVERSITAS BANTEN JAYA');
INSERT INTO "public"."universitas" VALUES (97933, 41056, 'UNIVERSITAS SURYA');
INSERT INTO "public"."universitas" VALUES (97934, 41057, 'UNIVERSITAS TELKOM');
INSERT INTO "public"."universitas" VALUES (97935, 41058, 'UNIVERSITAS LINTAS INTERNASIONAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97936, 41059, 'UNIVERSITAS ISLAM AL-IHYA KUNINGAN');
INSERT INTO "public"."universitas" VALUES (97937, 41060, 'UNIVERSITAS BUDDHI DHARMA');
INSERT INTO "public"."universitas" VALUES (97938, 41061, 'UNIVERSITAS MUHAMMADIYAH TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (97939, 41062, 'UNIVERSITAS BUANA PERJUANGAN KARAWANG');
INSERT INTO "public"."universitas" VALUES (97940, 41063, 'UNIVERSITAS PERJUANGAN TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (97941, 41064, 'UNIVERSITAS MUHAMMADIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (97942, 41065, 'UNIVERSITAS BINA BANGSA');
INSERT INTO "public"."universitas" VALUES (97943, 41066, 'UNIVERSITAS HALIM SANUSI');
INSERT INTO "public"."universitas" VALUES (97944, 41067, 'UNIVERSITAS NUSA PUTRA');
INSERT INTO "public"."universitas" VALUES (97945, 41068, 'UNIVERSITAS BHAKTI KENCANA');
INSERT INTO "public"."universitas" VALUES (97946, 41069, 'UNIVERSITAS MITRA KARYA');
INSERT INTO "public"."universitas" VALUES (97947, 41070, 'UNIVERSITAS FALETEHAN');
INSERT INTO "public"."universitas" VALUES (97948, 41071, 'UNIVERSITAS RAHARJA');
INSERT INTO "public"."universitas" VALUES (97949, 41072, 'UNIVERSITAS PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (97950, 41073, 'UNIVERSITAS MA''SOEM');
INSERT INTO "public"."universitas" VALUES (97951, 41074, 'UNIVERSITAS BINA INSANI');
INSERT INTO "public"."universitas" VALUES (97952, 41075, 'UNIVERSITAS CATUR INSAN CENDEKIA');
INSERT INTO "public"."universitas" VALUES (97953, 41076, 'UNIVERSITAS KARTAMULIA PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (97954, 41077, 'UNIVERSITAS ADHIRAJASA RESWARA SANJAYA');
INSERT INTO "public"."universitas" VALUES (97955, 41078, 'UNIVERSITAS PANCA SAKTI BEKASI');
INSERT INTO "public"."universitas" VALUES (97956, 41079, 'UNIVERSITAS PRIMAGRAHA');
INSERT INTO "public"."universitas" VALUES (97957, 41081, 'UNIVERSITAS BINANIAGA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97958, 41082, 'UNIVERSITAS GLOBAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (97959, 41083, 'UNIVERSITAS PERSATUAN ISLAM');
INSERT INTO "public"."universitas" VALUES (97960, 41084, 'UNIVERSITAS INSAN CENDEKIA MANDIRI');
INSERT INTO "public"."universitas" VALUES (97961, 41085, 'UNIVERSITAS TANGERANG RAYA');
INSERT INTO "public"."universitas" VALUES (97962, 42001, 'INSTITUT MANAJEMEN KOPERASI INDONESIA');
INSERT INTO "public"."universitas" VALUES (97963, 42002, 'INSTITUT TEKNOLOGI NASIONAL BANDUNG');
INSERT INTO "public"."universitas" VALUES (97964, 42005, 'INSTITUT TEKNOLOGI SAINS BANDUNG');
INSERT INTO "public"."universitas" VALUES (97965, 42006, 'INSTITUT TEKNOLOGI HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (97966, 42008, 'INSTITUT TEKNOLOGI TELKOM');
INSERT INTO "public"."universitas" VALUES (97967, 42009, 'INSTITUT MANAJEMEN TELKOM');
INSERT INTO "public"."universitas" VALUES (97968, 42010, 'INSTITUT BISNIS MUHAMMADIYAH BEKASI');
INSERT INTO "public"."universitas" VALUES (97969, 42011, 'INSTITUT MANAJEMEN WIYATA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97970, 42012, 'INSTITUT KEGURUAN DAN ILMU PENDIDIKAN SILIWANGI');
INSERT INTO "public"."universitas" VALUES (97971, 42013, 'INSTITUT PENDIDIKAN INDONESIA GARUT');
INSERT INTO "public"."universitas" VALUES (97972, 42014, 'INSTITUT MEDIKA DRG. SUHERMAN');
INSERT INTO "public"."universitas" VALUES (97973, 42015, 'INSTITUT TEKNOLOGI TANGERANG SELATAN');
INSERT INTO "public"."universitas" VALUES (97974, 42016, 'INSTITUT BISNIS DAN INFORMATIKA KESATUAN');
INSERT INTO "public"."universitas" VALUES (97975, 42017, 'INSTITUT KESEHATAN RAJAWALI');
INSERT INTO "public"."universitas" VALUES (97976, 43001, 'SEKOLAH TINGGI HUKUM BANDUNG');
INSERT INTO "public"."universitas" VALUES (97977, 43002, 'SEKOLAH TINGGI HUKUM GALUNGGUNG');
INSERT INTO "public"."universitas" VALUES (97978, 43003, 'SEKOLAH TINGGI HUKUM PASUNDAN');
INSERT INTO "public"."universitas" VALUES (97979, 43010, 'SEKOLAH TINGGI ILMU ADMINISTRASI MAULANA YUSUF BANTEN');
INSERT INTO "public"."universitas" VALUES (97980, 43014, 'SEKOLAH TINGGI ILMU ADMINISTRASI YPPT TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (97981, 43018, 'SEKOLAH TINGGI ILMU EKONOMI TRIDHARMA');
INSERT INTO "public"."universitas" VALUES (97982, 43019, 'STKIP SEBELAS APRIL');
INSERT INTO "public"."universitas" VALUES (97983, 43021, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA MEMBANGUN (INABA)');
INSERT INTO "public"."universitas" VALUES (97984, 43022, 'SEKOLAH TINGGI ILMU EKONOMI EKUITAS');
INSERT INTO "public"."universitas" VALUES (97985, 43024, 'SEKOLAH TINGGI ILMU EKONOMI PERTIWI');
INSERT INTO "public"."universitas" VALUES (97986, 43026, 'SEKOLAH TINGGI ILMU EKONOMI STEMBI');
INSERT INTO "public"."universitas" VALUES (97987, 43027, 'STMIK MARDIRA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97988, 43028, 'SEKOLAH TINGGI TEKNOLOGI YUPENTEK');
INSERT INTO "public"."universitas" VALUES (97989, 43029, 'SEKOLAH TINGGI HUKUM GARUT');
INSERT INTO "public"."universitas" VALUES (97990, 43030, 'STKIP GARUT');
INSERT INTO "public"."universitas" VALUES (97991, 43033, 'SEKOLAH TINGGI ILMU ADMINISTRASI MENARA SISWA');
INSERT INTO "public"."universitas" VALUES (96762, 1007, 'UNIVERSITAS PADJADJARAN');
INSERT INTO "public"."universitas" VALUES (96763, 1009, 'UNIVERSITAS SRIWIJAYA');
INSERT INTO "public"."universitas" VALUES (96764, 1010, 'UNIVERSITAS LAMBUNG MANGKURAT');
INSERT INTO "public"."universitas" VALUES (96765, 1011, 'UNIVERSITAS SYIAH KUALA');
INSERT INTO "public"."universitas" VALUES (96766, 1012, 'UNIVERSITAS SAM RATULANGI');
INSERT INTO "public"."universitas" VALUES (96767, 1013, 'UNIVERSITAS UDAYANA');
INSERT INTO "public"."universitas" VALUES (96768, 1014, 'UNIVERSITAS NUSA CENDANA');
INSERT INTO "public"."universitas" VALUES (96771, 1017, 'UNIVERSITAS RIAU');
INSERT INTO "public"."universitas" VALUES (96772, 1018, 'UNIVERSITAS CENDERAWASIH');
INSERT INTO "public"."universitas" VALUES (96773, 1020, 'UNIVERSITAS JAMBI');
INSERT INTO "public"."universitas" VALUES (96774, 1021, 'UNIVERSITAS PATTIMURA');
INSERT INTO "public"."universitas" VALUES (96775, 1022, 'UNIVERSITAS TANJUNGPURA');
INSERT INTO "public"."universitas" VALUES (96776, 1023, 'UNIVERSITAS JENDERAL SOEDIRMAN');
INSERT INTO "public"."universitas" VALUES (96777, 1024, 'UNIVERSITAS PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (96778, 1025, 'UNIVERSITAS JEMBER');
INSERT INTO "public"."universitas" VALUES (96779, 1026, 'UNIVERSITAS LAMPUNG');
INSERT INTO "public"."universitas" VALUES (96780, 1027, 'UNIVERSITAS SEBELAS MARET');
INSERT INTO "public"."universitas" VALUES (96781, 1028, 'UNIVERSITAS TADULAKO');
INSERT INTO "public"."universitas" VALUES (96782, 1029, 'UNIVERSITAS HALU OLEO');
INSERT INTO "public"."universitas" VALUES (96783, 1030, 'UNIVERSITAS BENGKULU');
INSERT INTO "public"."universitas" VALUES (96784, 1031, 'UNIVERSITAS TERBUKA');
INSERT INTO "public"."universitas" VALUES (96785, 1032, 'UNIVERSITAS NEGERI PADANG');
INSERT INTO "public"."universitas" VALUES (96786, 1033, 'UNIVERSITAS NEGERI MALANG');
INSERT INTO "public"."universitas" VALUES (96787, 1034, 'UNIVERSITAS PENDIDIKAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (96788, 1035, 'UNIVERSITAS NEGERI MANADO');
INSERT INTO "public"."universitas" VALUES (96789, 1036, 'UNIVERSITAS NEGERI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (96790, 1037, 'UNIVERSITAS NEGERI JAKARTA');
INSERT INTO "public"."universitas" VALUES (96791, 1038, 'UNIVERSITAS NEGERI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (96792, 1039, 'UNIVERSITAS NEGERI SURABAYA');
INSERT INTO "public"."universitas" VALUES (96793, 1040, 'UNIVERSITAS NEGERI MEDAN');
INSERT INTO "public"."universitas" VALUES (96794, 1041, 'UNIVERSITAS NEGERI SEMARANG');
INSERT INTO "public"."universitas" VALUES (96795, 1042, 'UNIVERSITAS SULTAN AGENG TIRTAYASA');
INSERT INTO "public"."universitas" VALUES (96796, 1043, 'UNIVERSITAS TRUNOJOYO');
INSERT INTO "public"."universitas" VALUES (96797, 1044, 'UNIVERSITAS KHAIRUN');
INSERT INTO "public"."universitas" VALUES (96798, 1045, 'UNIVERSITAS PAPUA');
INSERT INTO "public"."universitas" VALUES (96799, 1046, 'UNIVERSITAS MALIKUSSALEH');
INSERT INTO "public"."universitas" VALUES (96800, 1047, 'UNIVERSITAS NEGERI GORONTALO');
INSERT INTO "public"."universitas" VALUES (96801, 1048, 'UNIVERSITAS PENDIDIKAN GANESHA');
INSERT INTO "public"."universitas" VALUES (96802, 1049, 'UNIVERSITAS BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (96803, 1050, 'UNIVERSITAS BORNEO TARAKAN');
INSERT INTO "public"."universitas" VALUES (96804, 1051, 'UNIVERSITAS MUSAMUS MERAUKE');
INSERT INTO "public"."universitas" VALUES (96805, 1052, 'UNIVERSITAS MARITIM RAJA ALI HAJI (UMRAH)');
INSERT INTO "public"."universitas" VALUES (96806, 1053, 'UNIVERSITAS SAMUDRA');
INSERT INTO "public"."universitas" VALUES (96807, 1054, 'UNIVERSITAS SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (96808, 1055, 'UNIVERSITAS SEMBILANBELAS NOVEMBER KOLAKA');
INSERT INTO "public"."universitas" VALUES (96809, 1056, 'UNIVERSITAS TIDAR');
INSERT INTO "public"."universitas" VALUES (96810, 1057, 'UNIVERSITAS SILIWANGI');
INSERT INTO "public"."universitas" VALUES (96811, 1058, 'UNIVERSITAS TEUKU UMAR');
INSERT INTO "public"."universitas" VALUES (96812, 1059, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (96813, 1060, 'UNIVERSITAS TIMOR');
INSERT INTO "public"."universitas" VALUES (96814, 1061, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (96815, 1062, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (96816, 1063, 'UNIVERSITAS SINGAPERBANGSA KARAWANG');
INSERT INTO "public"."universitas" VALUES (96817, 2005, 'INSTITUT SENI INDONESIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (96818, 2007, 'INSTITUT SENI INDONESIA DENPASAR');
INSERT INTO "public"."universitas" VALUES (96819, 2008, 'INSTITUT SENI INDONESIA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (96820, 2009, 'INSTITUT SENI INDONESIA PADANG PANJANG');
INSERT INTO "public"."universitas" VALUES (96821, 2010, 'INSTITUT SENI BUDAYA INDONESIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (96822, 2011, 'INSTITUT SENI BUDAYA INDONESIA ACEH');
INSERT INTO "public"."universitas" VALUES (96823, 2012, 'INSTITUT SENI BUDAYA INDONESIA TANAH PAPUA');
INSERT INTO "public"."universitas" VALUES (96824, 2013, 'INSTITUT TEKNOLOGI KALIMANTAN');
INSERT INTO "public"."universitas" VALUES (96825, 2014, 'INSTITUT TEKNOLOGI SUMATERA');
INSERT INTO "public"."universitas" VALUES (96826, 3002, 'SEKOLAH TINGGI SENI INDONESIA PADANG PANJANG');
INSERT INTO "public"."universitas" VALUES (96827, 3004, 'SEKOLAH TINGGI SENI INDONESIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (96828, 5001, 'POLITEKNIK MANUFAKTUR BANDUNG');
INSERT INTO "public"."universitas" VALUES (96829, 5002, 'POLITEKNIK NEGERI JAKARTA');
INSERT INTO "public"."universitas" VALUES (96830, 5003, 'POLITEKNIK NEGERI MEDAN');
INSERT INTO "public"."universitas" VALUES (96831, 5004, 'POLITEKNIK NEGERI BANDUNG');
INSERT INTO "public"."universitas" VALUES (96832, 5005, 'POLITEKNIK NEGERI SEMARANG');
INSERT INTO "public"."universitas" VALUES (96833, 5006, 'POLITEKNIK NEGERI SRIWIJAYA');
INSERT INTO "public"."universitas" VALUES (96834, 5007, 'POLITEKNIK NEGERI LAMPUNG');
INSERT INTO "public"."universitas" VALUES (96835, 5008, 'POLITEKNIK NEGERI AMBON');
INSERT INTO "public"."universitas" VALUES (96836, 5009, 'POLITEKNIK NEGERI PADANG');
INSERT INTO "public"."universitas" VALUES (96837, 5010, 'POLITEKNIK NEGERI BALI');
INSERT INTO "public"."universitas" VALUES (96838, 5011, 'POLITEKNIK NEGERI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (96839, 5012, 'POLITEKNIK NEGERI UJUNG PANDANG');
INSERT INTO "public"."universitas" VALUES (96840, 5013, 'POLITEKNIK NEGERI MANADO');
INSERT INTO "public"."universitas" VALUES (96841, 5014, 'POLITEKNIK PERKAPALAN NEGERI SURABAYA');
INSERT INTO "public"."universitas" VALUES (96842, 5015, 'POLITEKNIK NEGERI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (96843, 5016, 'POLITEKNIK NEGERI LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (96844, 5017, 'POLITEKNIK NEGERI KUPANG');
INSERT INTO "public"."universitas" VALUES (96845, 5018, 'POLITEKNIK ELEKTRONIKA NEGERI SURABAYA');
INSERT INTO "public"."universitas" VALUES (96846, 5019, 'POLITEKNIK NEGERI JEMBER');
INSERT INTO "public"."universitas" VALUES (96847, 5020, 'POLITEKNIK PERTANIAN NEGERI PANGKAJENE KEPULAUAN');
INSERT INTO "public"."universitas" VALUES (96848, 5021, 'POLITEKNIK PERTANIAN NEGERI KUPANG');
INSERT INTO "public"."universitas" VALUES (96849, 5022, 'POLITEKNIK PERIKANAN NEGERI TUAL');
INSERT INTO "public"."universitas" VALUES (96850, 5023, 'POLITEKNIK NEGERI MALANG');
INSERT INTO "public"."universitas" VALUES (96851, 5024, 'POLITEKNIK PERTANIAN NEGERI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (96852, 5025, 'POLITEKNIK PERTANIAN NEGERI PAYAKUMBUH');
INSERT INTO "public"."universitas" VALUES (96853, 5026, 'POLITEKNIK NEGERI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (96854, 5027, 'POLITEKNIK NEGERI MEDIA KREATIF');
INSERT INTO "public"."universitas" VALUES (96855, 5028, 'POLITEKNIK MANUFAKTUR NEGERI BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (96856, 5029, 'POLITEKNIK NEGERI BATAM');
INSERT INTO "public"."universitas" VALUES (96857, 5030, 'POLITEKNIK NEGERI NUSA UTARA');
INSERT INTO "public"."universitas" VALUES (96858, 5031, 'POLITEKNIK NEGERI BENGKALIS');
INSERT INTO "public"."universitas" VALUES (96859, 5032, 'POLITEKNIK NEGERI BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (96860, 5033, 'POLITEKNIK NEGERI MADURA');
INSERT INTO "public"."universitas" VALUES (96861, 5034, 'POLITEKNIK MARITIM NEGERI INDONESIA');
INSERT INTO "public"."universitas" VALUES (96862, 5035, 'POLITEKNIK NEGERI BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (96863, 5036, 'POLITEKNIK NEGERI MADIUN');
INSERT INTO "public"."universitas" VALUES (96864, 5037, 'POLITEKNIK NEGERI FAKFAK');
INSERT INTO "public"."universitas" VALUES (96865, 5038, 'POLITEKNIK NEGERI SAMBAS');
INSERT INTO "public"."universitas" VALUES (96866, 5039, 'POLITEKNIK NEGERI TANAH LAUT');
INSERT INTO "public"."universitas" VALUES (96867, 5040, 'POLITEKNIK NEGERI SUBANG');
INSERT INTO "public"."universitas" VALUES (96868, 5041, 'POLITEKNIK NEGERI KETAPANG');
INSERT INTO "public"."universitas" VALUES (96869, 5042, 'POLITEKNIK NEGERI CILACAP');
INSERT INTO "public"."universitas" VALUES (96870, 5043, 'POLITEKNIK NEGERI INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (96871, 6001, 'AKADEMI KOMUNITAS NEGERI PACITAN');
INSERT INTO "public"."universitas" VALUES (96872, 6002, 'AKADEMI KOMUNITAS NEGERI PUTRA SANG FAJAR BLITAR');
INSERT INTO "public"."universitas" VALUES (96873, 6003, 'AKADEMI KOMUNITAS NEGERI ACEH BARAT');
INSERT INTO "public"."universitas" VALUES (96874, 6004, 'AKADEMI KOMUNITAS NEGERI REJANG LEBONG');
INSERT INTO "public"."universitas" VALUES (96875, 1001, 'UNIVERSITAS INSAN CENDEKIA MANDIRI');
INSERT INTO "public"."universitas" VALUES (96876, 11001, 'UNIVERSITAS ISLAM SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96877, 11002, 'UNIVERSITAS HKBP NOMMENSEN');
INSERT INTO "public"."universitas" VALUES (96878, 11003, 'UNIVERSITAS MUHAMMADIYAH SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96879, 11004, 'UNIVERSITAS PEMBANGUNAN PANCA BUDI');
INSERT INTO "public"."universitas" VALUES (96880, 11005, 'UNIVERSITAS SIMALUNGUN');
INSERT INTO "public"."universitas" VALUES (96881, 11006, 'UNIVERSITAS METHODIST INDONESIA');
INSERT INTO "public"."universitas" VALUES (96882, 11007, 'UNIVERSITAS DARMA AGUNG');
INSERT INTO "public"."universitas" VALUES (96883, 11008, 'UNIVERSITAS MEDAN AREA');
INSERT INTO "public"."universitas" VALUES (96884, 11009, 'UNIVERSITAS KATOLIK SANTO THOMAS');
INSERT INTO "public"."universitas" VALUES (96885, 11010, 'UNIVERSITAS AMIR HAMZAH');
INSERT INTO "public"."universitas" VALUES (96886, 11011, 'UNIVERSITAS SISINGAMANGARAJA XII');
INSERT INTO "public"."universitas" VALUES (96887, 11012, 'UNIVERSITAS DHARMAWANGSA');
INSERT INTO "public"."universitas" VALUES (96888, 11014, 'UNIVERSITAS MUHAMMADIYAH TAPANULI SELATAN');
INSERT INTO "public"."universitas" VALUES (96889, 11015, 'UNIVERSITAS GRAHA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (96890, 11016, 'UNIVERSITAS ASAHAN');
INSERT INTO "public"."universitas" VALUES (96891, 11017, 'UNIVERSITAS ALWASHLIYAH');
INSERT INTO "public"."universitas" VALUES (96892, 11018, 'UNIVERSITAS SISINGAMANGARAJA XII TAPANULI UTARA');
INSERT INTO "public"."universitas" VALUES (96893, 11019, 'UNIVERSITAS SAMUDRA LANGSA');
INSERT INTO "public"."universitas" VALUES (96894, 11025, 'UNIVERSITAS PEMBINAAN MASYARAKAT INDONESIA');
INSERT INTO "public"."universitas" VALUES (96895, 11026, 'UNIVERSITAS AL-AZHAR');
INSERT INTO "public"."universitas" VALUES (96896, 11027, 'UNIVERSITAS MUSLIM NUSANTARA AL-WASHLIYAH');
INSERT INTO "public"."universitas" VALUES (96897, 11028, 'UNIVERSITAS ISLAM LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (96898, 11029, 'UNIVERSITAS TJUT NYAK DHIEN');
INSERT INTO "public"."universitas" VALUES (96899, 11033, 'UNIVERSITAS PRIMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (96900, 11035, 'UNIVERSITAS PRESTON INDONESIA');
INSERT INTO "public"."universitas" VALUES (96901, 11036, 'UNIVERSITAS DIAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (96902, 11037, 'UNIVERSITAS SETIA BUDI MANDIRI');
INSERT INTO "public"."universitas" VALUES (96903, 11038, 'UNIVERSITAS AL WASHLIYAH');
INSERT INTO "public"."universitas" VALUES (96904, 11040, 'UNIVERSITAS QUALITY');
INSERT INTO "public"."universitas" VALUES (96905, 11041, 'UNIVERSITAS SUTOMO');
INSERT INTO "public"."universitas" VALUES (96906, 11042, 'UNIVERSITAS PELITA HARAPAN MEDAN');
INSERT INTO "public"."universitas" VALUES (96907, 11044, 'UNIVERSITAS EFARINA');
INSERT INTO "public"."universitas" VALUES (96908, 11045, 'UNIVERSITAS SARI MUTIARA INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (96909, 11046, 'UNIVERSITAS POTENSI UTAMA');
INSERT INTO "public"."universitas" VALUES (96910, 11047, 'UNIVERSITAS NAHDLATUL ULAMA SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96911, 11048, 'UNIVERSITAS QUALITY BERASTAGI');
INSERT INTO "public"."universitas" VALUES (96912, 11049, 'UNIVERSITAS HARAPAN MEDAN');
INSERT INTO "public"."universitas" VALUES (96913, 11050, 'UNIVERSITAS HKBP NOMMENSEN PEMATANGSIANTAR');
INSERT INTO "public"."universitas" VALUES (96914, 11051, 'UNIVERSITAS AUFA ROYHAN');
INSERT INTO "public"."universitas" VALUES (96915, 11052, 'UNIVERSITAS LABUHANBATU');
INSERT INTO "public"."universitas" VALUES (96916, 11053, 'UNIVERSITAS AUDI INDONESIA');
INSERT INTO "public"."universitas" VALUES (96917, 11054, 'UNIVERSITAS IMELDA MEDAN');
INSERT INTO "public"."universitas" VALUES (96918, 11055, 'UNIVERSITAS BATUTA');
INSERT INTO "public"."universitas" VALUES (96919, 11056, 'UNIVERSITAS BUDI DARMA');
INSERT INTO "public"."universitas" VALUES (96920, 11057, 'UNIVERSITAS HAJI SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96921, 11058, 'UNIVERSITAS IBBI');
INSERT INTO "public"."universitas" VALUES (96922, 12001, 'IKIP GUNUNG SITOLI');
INSERT INTO "public"."universitas" VALUES (96923, 12003, 'INSTITUT TEKNOLOGI MEDAN');
INSERT INTO "public"."universitas" VALUES (96924, 12004, 'INSTITUT SAINS DAN TEKNOLOGI TD PARDEDE');
INSERT INTO "public"."universitas" VALUES (96925, 12005, 'INSTITUT TEKNOLOGI DEL');
INSERT INTO "public"."universitas" VALUES (96926, 12006, 'INSTITUT KESEHATAN HELVETIA');
INSERT INTO "public"."universitas" VALUES (96927, 12007, 'INSTITUT KESEHATAN DELI HUSADA DELI TUA');
INSERT INTO "public"."universitas" VALUES (96928, 12008, 'INSTITUT KESEHATAN MEDISTRA LUBUK PAKAM');
INSERT INTO "public"."universitas" VALUES (96929, 12009, 'INSTITUT PENDIDIKAN TAPANULI SELATAN');
INSERT INTO "public"."universitas" VALUES (96930, 12010, 'INSTITUT BISNIS INFORMASI TEKNOLOGI DAN BISNIS');
INSERT INTO "public"."universitas" VALUES (96931, 12011, 'INSTITUT TEKNOLOGI DAN BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (96932, 12012, 'INSTITUT TEKNOLOGI DAN BISNIS SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96933, 12013, 'INSTITUT KESEHATAN SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96934, 12014, 'INSTITUT TEKNOLOGI DAN KESEHATAN SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96935, 13001, 'SEKOLAH TINGGI HUKUM YNI');
INSERT INTO "public"."universitas" VALUES (96936, 13002, 'STKIP RIAMA');
INSERT INTO "public"."universitas" VALUES (96937, 13003, 'SEKOLAH TINGGI ILMU EKONOMI SWADAYA');
INSERT INTO "public"."universitas" VALUES (96938, 13004, 'SEKOLAH TINGGI BAHASA ASING SWADAYA MEDAN');
INSERT INTO "public"."universitas" VALUES (96939, 13005, 'SEKOLAH TINGGI ILMU HUKUM SWADAYA');
INSERT INTO "public"."universitas" VALUES (96940, 13009, 'SEKOLAH TINGGI ILMU EKONOMI HARAPAN');
INSERT INTO "public"."universitas" VALUES (96941, 13010, 'SEKOLAH TINGGI BAHASA ASING HARAPAN');
INSERT INTO "public"."universitas" VALUES (96942, 13011, 'SEKOLAH TINGGI TEKNIK HARAPAN');
INSERT INTO "public"."universitas" VALUES (96943, 13020, 'SEKOLAH TINGGI ILMU HUKUM BENTENG HURABA');
INSERT INTO "public"."universitas" VALUES (96944, 13022, 'SEKOLAH TINGGI ILMU EKONOMI NUSA BANGSA');
INSERT INTO "public"."universitas" VALUES (96945, 13024, 'SEKOLAH TINGGI OLAHRAGA DAN KESEHATAN BINA GUNA');
INSERT INTO "public"."universitas" VALUES (96946, 13026, 'SEKOLAH TINGGI TEOLOGI HKBP');
INSERT INTO "public"."universitas" VALUES (96947, 13027, 'SEKOLAH TINGGI ILMU EKONOMI PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (96948, 13028, 'STKIP PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (96949, 13029, 'STKIP BUDIDAYA');
INSERT INTO "public"."universitas" VALUES (96950, 13030, 'SEKOLAH TINGGI ILMU EKONOMI AL-WASHLIYAH');
INSERT INTO "public"."universitas" VALUES (96951, 13031, 'STKIP TAPANULI SELATAN');
INSERT INTO "public"."universitas" VALUES (96952, 13036, 'SEKOLAH TINGGI PERTANIAN BENTENG HURABA');
INSERT INTO "public"."universitas" VALUES (96953, 13037, 'SEKOLAH TINGGI ILMU MANAJEMEN MEDAN');
INSERT INTO "public"."universitas" VALUES (96954, 13041, 'SEKOLAH TINGGI TEKNOLOGI IMMANUEL');
INSERT INTO "public"."universitas" VALUES (96955, 13042, 'SEKOLAH TINGGI ILMU KOMUNIKASI PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (96956, 13043, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH ASAHAN');
INSERT INTO "public"."universitas" VALUES (96957, 13046, 'SEKOLAH TINGGI TEKNIK PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (96958, 13047, 'SEKOLAH TINGGI ILMU EKONOMI MARS');
INSERT INTO "public"."universitas" VALUES (96959, 13051, 'SEKOLAH TINGGI ILMU EKONOMI SURYA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (96960, 13053, 'SEKOLAH TINGGI PERTANIAN GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (96961, 13060, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMADIYAH KISARAN');
INSERT INTO "public"."universitas" VALUES (96962, 13061, 'STMIK BUDI DARMA');
INSERT INTO "public"."universitas" VALUES (96963, 13063, 'STMIK MIKROSKIL');
INSERT INTO "public"."universitas" VALUES (96964, 13064, 'SEKOLAH TINGGI ILMU EKONOMI TRICOM');
INSERT INTO "public"."universitas" VALUES (96965, 13066, 'SEKOLAH TINGGI ILMU EKONOMI AL-HIKMAH');
INSERT INTO "public"."universitas" VALUES (96966, 13067, 'SEKOLAH TINGGI ILMU EKONOMI EKA PRASETYA');
INSERT INTO "public"."universitas" VALUES (96967, 13068, 'SEKOLAH TINGGI ILMU EKONOMI GRAHA KIRANA');
INSERT INTO "public"."universitas" VALUES (96968, 13069, 'SEKOLAH TINGGI ILMU HUKUM GRAHA KIRANA');
INSERT INTO "public"."universitas" VALUES (96969, 13070, 'SEKOLAH TINGGI ILMU HUKUM AL-HIKMAH');
INSERT INTO "public"."universitas" VALUES (96970, 13071, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (96971, 13072, 'STMIK SISINGAMANGARAJA XII');
INSERT INTO "public"."universitas" VALUES (96972, 13073, 'SEKOLAH TINGGI ILMU EKONOMI LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (96973, 13074, 'SEKOLAH TINGGI ILMU EKONOMI IBBI');
INSERT INTO "public"."universitas" VALUES (96974, 13076, 'SEKOLAH TINGGI ILMU EKONOMI Y P KAMPUS');
INSERT INTO "public"."universitas" VALUES (96975, 13077, 'SEKOLAH TINGGI ILMU EKONOMI LMII');
INSERT INTO "public"."universitas" VALUES (96976, 13079, 'SEKOLAH TINGGI TEKNIK GRAHA KIRANA');
INSERT INTO "public"."universitas" VALUES (96977, 13081, 'SEKOLAH TINGGI ILMU EKONOMI RIAMA');
INSERT INTO "public"."universitas" VALUES (96978, 13082, 'STKIP LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (96979, 13083, 'SEKOLAH TINGGI ILMU PERTANIAN LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (96980, 13084, 'SEKOLAH TINGGI ILMU HUKUM LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (96981, 13085, 'SEKOLAH TINGGI ILMU MANAJEMEN SUKMA');
INSERT INTO "public"."universitas" VALUES (96982, 13088, 'SEKOLAH TINGGI ILMU EKONOMI SULTAN AGUNG');
INSERT INTO "public"."universitas" VALUES (96983, 13089, 'SEKOLAH TINGGI ILMU EKONOMI PEMBANGUNAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (96984, 13090, 'SEKOLAH TINGGI FILSAFAT THEOLOGI S NUSANTARA');
INSERT INTO "public"."universitas" VALUES (96985, 13091, 'SEKOLAH TINGGI ILMU EKONOMI ITMI MEDAN');
INSERT INTO "public"."universitas" VALUES (96986, 13092, 'SEKOLAH TINGGI ILMU EKONOMI GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (96987, 13093, 'SEKOLAH TINGGI ILMU KESEHATAN MUTIARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (96988, 13094, 'STKIP GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (96989, 13095, 'SEKOLAH TINGGI PERIKANAN SIBOLGA');
INSERT INTO "public"."universitas" VALUES (96990, 13097, 'SEKOLAH TINGGI ILMU EKONOMI BINA KARYA');
INSERT INTO "public"."universitas" VALUES (96991, 13098, 'SEKOLAH TINGGI ILMU BAHASA ASING ITMI MEDAN');
INSERT INTO "public"."universitas" VALUES (96992, 13099, 'STIE IBMI MEDAN');
INSERT INTO "public"."universitas" VALUES (96993, 13100, 'SEKOLAH TINGGI KELAUTAN DAN PERIKANAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (96994, 13101, 'SEKOLAH TINGGI ILMU KESEHATAN HELVETIA');
INSERT INTO "public"."universitas" VALUES (96995, 13102, 'SEKOLAH TINGGI ILMU KESEHATAN MEDISTRA');
INSERT INTO "public"."universitas" VALUES (96996, 13104, 'SEKOLAH TINGGI ILMU KESEHATAN DELI HUSADA');
INSERT INTO "public"."universitas" VALUES (96997, 13105, 'STMIK TIME');
INSERT INTO "public"."universitas" VALUES (96998, 13108, 'SEKOLAH TINGGI ILMU KESEHATAN SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (96999, 13109, 'STMIK LOGIKA');
INSERT INTO "public"."universitas" VALUES (97000, 13113, 'SEKOLAH TINGGI TEKNIK POLIPROFESI');
INSERT INTO "public"."universitas" VALUES (97001, 13115, 'STMIK IBBI');
INSERT INTO "public"."universitas" VALUES (97002, 13117, 'STMIK POTENSI UTAMA');
INSERT INTO "public"."universitas" VALUES (97003, 13118, 'STMIK KAPUTAMA');
INSERT INTO "public"."universitas" VALUES (97004, 13119, 'SEKOLAH TINGGI TEKNOLOGI SINAR HUSNI');
INSERT INTO "public"."universitas" VALUES (97005, 13122, 'SEKOLAH TINGGI ILMU KESEHATAN BINALITA SUDAMA');
INSERT INTO "public"."universitas" VALUES (97006, 13123, 'SEKOLAH TINGGI ILMU TEKNIK GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (97007, 13130, 'STMIK ITMI MEDAN');
INSERT INTO "public"."universitas" VALUES (97008, 13131, 'STIPER AGROBISNIS PERKEBUNAN');
INSERT INTO "public"."universitas" VALUES (97009, 13134, 'STIE AKUNTANSI DAN BISNIS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (97010, 13140, 'STIKES SANTA ELISABETH MEDAN');
INSERT INTO "public"."universitas" VALUES (97011, 13141, 'STIKES PUTRA ABADI LANGKAT');
INSERT INTO "public"."universitas" VALUES (97012, 13142, 'STIE INFORMASI TEKNOLOGI DAN BISNIS');
INSERT INTO "public"."universitas" VALUES (97013, 13147, 'STMIK PELITA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97014, 13148, 'SEKOLAH TINGGI ILMU KOMPUTER MEDAN');
INSERT INTO "public"."universitas" VALUES (97015, 13150, 'STIE NIAS SELATAN');
INSERT INTO "public"."universitas" VALUES (97016, 13151, 'STKIP NIAS SELATAN');
INSERT INTO "public"."universitas" VALUES (97017, 13155, 'STMIK KRISTEN NEUMANN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97018, 13157, 'STMIK TRIGUNA DHARMA');
INSERT INTO "public"."universitas" VALUES (97019, 13158, 'STBA PERSAHABATAN INTERNASIONAL ASIA');
INSERT INTO "public"."universitas" VALUES (97020, 13161, 'SEKOLAH TINGGI ILMU KESEHATAN RS HAJI MEDAN');
INSERT INTO "public"."universitas" VALUES (97021, 13162, 'SEKOLAH TINGGI ILMU KESEHATAN FLORA');
INSERT INTO "public"."universitas" VALUES (97022, 13163, 'STIE PROFESSIONAL MANAJEMEN COLLEGE INDONESIA');
INSERT INTO "public"."universitas" VALUES (97023, 13165, 'STIE MIKROSKIL');
INSERT INTO "public"."universitas" VALUES (97024, 13167, 'STIKES ADIWANGSA TEBING TINGGI');
INSERT INTO "public"."universitas" VALUES (97025, 13168, 'STIKES NAULI HUSADA');
INSERT INTO "public"."universitas" VALUES (97026, 13171, 'STKIP BARUS TAPANULI TENGAH');
INSERT INTO "public"."universitas" VALUES (97027, 13172, 'STIKES AUFA ROYHAN');
INSERT INTO "public"."universitas" VALUES (97028, 13173, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER ROYAL');
INSERT INTO "public"."universitas" VALUES (97029, 13175, 'STIKES WIDYA HUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97030, 13176, 'SEKOLAH TINGGI ILMU KESEHATAN IMELDA');
INSERT INTO "public"."universitas" VALUES (97031, 13177, 'STIKES SYUHADA DI PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (97032, 13178, 'SEKOLAH TINGGI ILMU HUKUM NIAS SELATAN');
INSERT INTO "public"."universitas" VALUES (97033, 13179, 'S.T. MANAJEMEN BISNIS MULTI SARANA MANAJEMEN ADMINISTRASI DAN REKAYASA TEKNOLOGI');
INSERT INTO "public"."universitas" VALUES (97034, 13180, 'STIKES NURLIANA MEDAN');
INSERT INTO "public"."universitas" VALUES (97035, 13181, 'STIKOM TUNAS BANGSA');
INSERT INTO "public"."universitas" VALUES (97036, 13182, 'STMIK METHODIST BINJAI');
INSERT INTO "public"."universitas" VALUES (97037, 13183, 'STIKES SAKINAH HUSADA TANJUNG BALAI');
INSERT INTO "public"."universitas" VALUES (97038, 13184, 'STIKES DARMAIS PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (97039, 13185, 'STIKES SENIOR MEDAN');
INSERT INTO "public"."universitas" VALUES (97040, 13186, 'STIKES SITI HAJAR');
INSERT INTO "public"."universitas" VALUES (97041, 13187, 'SEKOLAH TINGGI ILMU EKONOMI PROFESIONAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97042, 13188, 'STKIP PANGERAN ANTASARI');
INSERT INTO "public"."universitas" VALUES (97043, 13189, 'STIKES MURNI TEGUH');
INSERT INTO "public"."universitas" VALUES (97044, 13190, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA HUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97045, 13191, 'SEKOLAH TINGGI ILMU KESEHATAN AUDI HUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97046, 13192, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN AL MAKSUM');
INSERT INTO "public"."universitas" VALUES (97047, 13193, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN PADANG LAWAS');
INSERT INTO "public"."universitas" VALUES (97048, 13194, 'STIKES NAMIRA MADINA');
INSERT INTO "public"."universitas" VALUES (97049, 13195, 'STMIK CITRA MANDIRI PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (97050, 13196, 'SEKOLAH TINGGI PERIKANAN DAN KELAUTAN MATAULI');
INSERT INTO "public"."universitas" VALUES (97051, 13197, 'SEKOLAH TINGGI AKUNTANSI DAN MANAJEMEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97052, 13198, 'STIKES AS SYIFA');
INSERT INTO "public"."universitas" VALUES (97053, 13199, 'STKIP ASY-SYAFI IYAH INTERNASIONAL MEDAN');
INSERT INTO "public"."universitas" VALUES (97054, 13200, 'SEKOLAH TINGGI ILMU HUKUM ASY-SYAFI IYAH MEDAN');
INSERT INTO "public"."universitas" VALUES (97055, 13201, 'SEKOLAH TINGGI ILMU KESEHATAN INDAH MEDAN');
INSERT INTO "public"."universitas" VALUES (97056, 13202, 'SEKOLAH TINGGI ILMU HUKUM DELI SUMATERA');
INSERT INTO "public"."universitas" VALUES (97057, 13203, 'SEKOLAH TINGGI ILMU EKONOMI DELI SUMATERA');
INSERT INTO "public"."universitas" VALUES (97058, 13204, 'SEKOLAH TINGGI ILMU KESEHATAN ARJUNA');
INSERT INTO "public"."universitas" VALUES (97059, 13205, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN AMAL BAKTI');
INSERT INTO "public"."universitas" VALUES (97060, 13206, 'SEKOLAH TINGGI ILMU KESEHATAN KESEHATAN BARU');
INSERT INTO "public"."universitas" VALUES (97061, 13207, 'SEKOLAH TINGGI ILMU KESEHATAN SEHAT MEDAN');
INSERT INTO "public"."universitas" VALUES (97062, 13208, 'SEKOLAH TINGGI ILMU KESEHATAN ARTA KABANJAHE');
INSERT INTO "public"."universitas" VALUES (97063, 13209, 'SEKOLAH TINGGI ILMU EKONOMI MAHKOTA TRICOM UNGGUL');
INSERT INTO "public"."universitas" VALUES (97064, 14001, 'AKADEMI PERNIAGAAN DAN PERUSAHAAN APIPSU MEDAN');
INSERT INTO "public"."universitas" VALUES (97065, 14002, 'AKADEMI BANK DAN KEUANGAN SWADAYA');
INSERT INTO "public"."universitas" VALUES (97066, 14003, 'AKADEMI PERTANIAN GUNUNG SITOLI');
INSERT INTO "public"."universitas" VALUES (97067, 14005, 'AKADEMI MARITIM INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (97068, 14006, 'AKADEMI AKUNTANSI YPK MEDAN');
INSERT INTO "public"."universitas" VALUES (97069, 14008, 'AKADEMI PARIWISATA DAN PERHOTELAN DARMA AGUNG');
INSERT INTO "public"."universitas" VALUES (97070, 14010, 'AKADEMI SEKRETARI MANAJEMEN MARIA GORETI');
INSERT INTO "public"."universitas" VALUES (97071, 14013, 'AKADEMI TEKNIK INDONESIA CUT MEUTIA');
INSERT INTO "public"."universitas" VALUES (97072, 14015, 'AKADEMI MANAJEMEN GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (97073, 14020, 'AKADEMI MARITIM BELAWAN');
INSERT INTO "public"."universitas" VALUES (97074, 14021, 'AKADEMI TEKNOLOGI LORENA');
INSERT INTO "public"."universitas" VALUES (97075, 14027, 'AKADEMI SEKRETARI MANAJEMEN CENDANA');
INSERT INTO "public"."universitas" VALUES (97076, 14028, 'AKADEMI SEKRETARI MANAJEMEN LANCANG KUNING');
INSERT INTO "public"."universitas" VALUES (97077, 14029, 'AKADEMI PARIWISATA TAMAN HARAPAN');
INSERT INTO "public"."universitas" VALUES (97078, 14030, 'AKADEMI TEKNOLOGI INDUSTRI IMMANUEL');
INSERT INTO "public"."universitas" VALUES (97079, 14036, 'AMIK MEDAN BUSINESS POLYTECHNIC');
INSERT INTO "public"."universitas" VALUES (97080, 14037, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER ITMI');
INSERT INTO "public"."universitas" VALUES (97081, 14039, 'AKADEMI PARIWISATA NUSANTARA MEDAN');
INSERT INTO "public"."universitas" VALUES (97082, 14040, 'AMIK PARBINA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97083, 14041, 'AKADEMI FARMASI INDAH DELI SERDANG');
INSERT INTO "public"."universitas" VALUES (97084, 14042, 'AKADEMI KEBIDANAN NUSANTARA 2000');
INSERT INTO "public"."universitas" VALUES (97085, 14043, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER UNIVERSAL');
INSERT INTO "public"."universitas" VALUES (97086, 14044, 'AMIK WIDYA LOKA MEDAN');
INSERT INTO "public"."universitas" VALUES (97087, 14045, 'AMIK LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (97088, 14046, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER LOGIKA');
INSERT INTO "public"."universitas" VALUES (97089, 14047, 'AKADEMI KEBIDANAN SARI MUTIARA');
INSERT INTO "public"."universitas" VALUES (97090, 14052, 'AKADEMI TEKNIK DELI SERDANG LUBUK PAKAM');
INSERT INTO "public"."universitas" VALUES (97091, 14053, 'AKADEMI KEBIDANAN HELVETIA MEDAN');
INSERT INTO "public"."universitas" VALUES (97092, 14054, 'AKADEMI KEBIDANAN KHOLISATUR RAHMI BINJAI');
INSERT INTO "public"."universitas" VALUES (97093, 14056, 'AKADEMI KEBIDANAN IMELDA');
INSERT INTO "public"."universitas" VALUES (100887, 212033, 'INSTITUT AGAMA ISLAM BANTEN');
INSERT INTO "public"."universitas" VALUES (97094, 14057, 'AKADEMI KEBIDANAN BAKTI INANG PERSADA');
INSERT INTO "public"."universitas" VALUES (97095, 14058, 'AMIK POLIBISNIS MEDAN');
INSERT INTO "public"."universitas" VALUES (97096, 14059, 'AKADEMI KEBIDANAN BINA HUSADA TEBING TINGGI');
INSERT INTO "public"."universitas" VALUES (97097, 14060, 'AKADEMI KEBIDANAN HENDERSON');
INSERT INTO "public"."universitas" VALUES (97098, 14061, 'AMIK STIEKOM SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (97099, 14062, 'AKADEMI KEBIDANAN DARMO MEDAN');
INSERT INTO "public"."universitas" VALUES (97100, 14067, 'AKADEMI KEPERAWATAN SURYA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97101, 14068, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER MULTICOM');
INSERT INTO "public"."universitas" VALUES (97102, 14069, 'AKADEMI KEPERAWATAN TELADAN BAHAGIA');
INSERT INTO "public"."universitas" VALUES (97103, 14070, 'AKADEMI KEBIDANAN SEHAT MEDAN');
INSERT INTO "public"."universitas" VALUES (97104, 14072, 'AKADEMI KEBIDANAN WIDYA HUSADA');
INSERT INTO "public"."universitas" VALUES (97105, 14117, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER MEDAN');
INSERT INTO "public"."universitas" VALUES (97106, 14118, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER ROYAL');
INSERT INTO "public"."universitas" VALUES (97107, 14119, 'AKADEMI KEPERAWATAN INDAH');
INSERT INTO "public"."universitas" VALUES (97108, 14120, 'AKADEMI KEBIDANAN INDAH');
INSERT INTO "public"."universitas" VALUES (97109, 14121, 'AMIK INTEL COM GLOBAL INDO KISARAN');
INSERT INTO "public"."universitas" VALUES (97110, 14122, 'AKADEMI KEBIDANAN LANGKAT');
INSERT INTO "public"."universitas" VALUES (97111, 14123, 'AMIK TUNAS BANGSA');
INSERT INTO "public"."universitas" VALUES (97112, 14124, 'AKADEMI KEBIDANAN JAYA WIJAYA');
INSERT INTO "public"."universitas" VALUES (97113, 14125, 'AKADEMI KEBIDANAN SENTRAL');
INSERT INTO "public"."universitas" VALUES (97114, 14126, 'AKADEMI INFORMATIKA DAN KOMPUTER MEDICOM');
INSERT INTO "public"."universitas" VALUES (97115, 14127, 'AKADEMI KEBIDANAN AGATHA');
INSERT INTO "public"."universitas" VALUES (97116, 14128, 'AKADEMI KEPERAWATAN PEMKAB TAPANULI UTARA');
INSERT INTO "public"."universitas" VALUES (97117, 14129, 'AKADEMI KEBIDANAN SENIOR');
INSERT INTO "public"."universitas" VALUES (97118, 14132, 'AKADEMI KESEHATAN LINGKUNGAN BINALITA SUDAMA');
INSERT INTO "public"."universitas" VALUES (97119, 14133, 'AKADEMI REFRAKSI OPTISI BINALITA SUDAMA');
INSERT INTO "public"."universitas" VALUES (97120, 14134, 'AKADEMI KEPERAWATAN BINALITA SUDAMA');
INSERT INTO "public"."universitas" VALUES (97121, 14135, 'AKADEMI TEKNIK ELEKTRO MEDIK BINALITA SUDAMA');
INSERT INTO "public"."universitas" VALUES (97122, 14137, 'AKADEMI KEBIDANAN DEWI MAYA');
INSERT INTO "public"."universitas" VALUES (97123, 14138, 'AKADEMI KEBIDANAN ARTA KABANJAHE');
INSERT INTO "public"."universitas" VALUES (97124, 14140, 'AKADEMI PARIWISATA MEDAN HOTEL SCHOOL');
INSERT INTO "public"."universitas" VALUES (97125, 14141, 'AKADEMI KEBIDANAN HISARMA MEDAN');
INSERT INTO "public"."universitas" VALUES (97126, 14142, 'AKADEMI KEPERAWATAN HELVETIA MEDAN');
INSERT INTO "public"."universitas" VALUES (97127, 14143, 'AKADEMI KEBIDANAN CIPTO MEDAN');
INSERT INTO "public"."universitas" VALUES (97128, 14145, 'AKADEMI KEBIDANAN HARAPAN MAMA DELI SERDANG');
INSERT INTO "public"."universitas" VALUES (97129, 14147, 'AKADEMI KEPERAWATAN DARMO MEDAN');
INSERT INTO "public"."universitas" VALUES (97130, 14148, 'AKADEMI KEPERAWATAN IMELDA MEDAN');
INSERT INTO "public"."universitas" VALUES (97131, 14150, 'AKADEMI KEBIDANAN YYS PENDIDIKAN DR RUSDI MEDAN');
INSERT INTO "public"."universitas" VALUES (97132, 14152, 'AKADEMI KEBIDANAN MITRA HUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97133, 14153, 'AKADEMI KEBIDANAN HAFSYAH MEDAN');
INSERT INTO "public"."universitas" VALUES (97134, 14154, 'AKADEMI KEBIDANAN IKA BINA LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (97135, 14157, 'AKADEMI KEBIDANAN BUDI MULIA');
INSERT INTO "public"."universitas" VALUES (97136, 14158, 'AKADEMI KEBIDANAN SEHATI');
INSERT INTO "public"."universitas" VALUES (97137, 14160, 'AKADEMI KEBIDANAN KESEHATAN BARU');
INSERT INTO "public"."universitas" VALUES (97138, 14163, 'AKPER GITA MATURA ABADI KISARAN');
INSERT INTO "public"."universitas" VALUES (97139, 14165, 'AMIK HARAPAN MEDAN');
INSERT INTO "public"."universitas" VALUES (97140, 14166, 'AKADEMIK KEBIDANAN ARMINA CENTRE PANYABUNGAN');
INSERT INTO "public"."universitas" VALUES (97141, 14167, 'AKADEMI KEBIDANAN MATORKIS');
INSERT INTO "public"."universitas" VALUES (97142, 14168, 'AKADEMI KEUANGAN DAN PERBANKAN ICM CANTRIKA MITRA');
INSERT INTO "public"."universitas" VALUES (97143, 14171, 'AKADEMI KEBIDANAN TAKASIMA KABANJAHE');
INSERT INTO "public"."universitas" VALUES (97144, 14172, 'AKADEMI KEBIDANAN MITRA SYUHADA PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (97145, 14173, 'AKADEMI KEBIDANAN NAMIRA MADINA PANYABUNGAN');
INSERT INTO "public"."universitas" VALUES (97146, 14174, 'AKADEMI KEBIDANAN DARMAIS PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (97147, 14175, 'AKADEMI KEBIDANAN MADINA HUSADA');
INSERT INTO "public"."universitas" VALUES (97148, 14176, 'AKADEMI KEBIDANAN IBTISAM AULIA');
INSERT INTO "public"."universitas" VALUES (97149, 14177, 'AKADEMI KEBIDANAN BINA DAYA HUSADA');
INSERT INTO "public"."universitas" VALUES (97150, 14178, 'AKADEMI KEBIDANAN DELIMA');
INSERT INTO "public"."universitas" VALUES (97151, 14180, 'AKADEMI KEBIDANAN BARUNA HUSADA SIBUHUAN');
INSERT INTO "public"."universitas" VALUES (97152, 14181, 'AKADEMI KEBIDANAN EUNICE RAJAWALI BINJAI');
INSERT INTO "public"."universitas" VALUES (97153, 14183, 'AKADEMI KEBIDANAN AS-SYIFA KISARAN');
INSERT INTO "public"."universitas" VALUES (97154, 14184, 'AKADEMI KEBIDANAN HARAPAN KELUARGA');
INSERT INTO "public"."universitas" VALUES (97155, 14186, 'AKADEMI KEBIDANAN SARI HUSADA');
INSERT INTO "public"."universitas" VALUES (97156, 14187, 'AKADEMI AKUNTANSI PROFESIONAL INDONESIA');
INSERT INTO "public"."universitas" VALUES (97157, 14188, 'AKADEMI KEPERAWATAN ARTA KABAN JAHE');
INSERT INTO "public"."universitas" VALUES (97158, 14191, 'AKPER TENAGA PEMBANGUNAN ARJUNA LAGUBOTI');
INSERT INTO "public"."universitas" VALUES (97159, 14192, 'AKADEMI KEBIDANAN PALAPA HUSADA');
INSERT INTO "public"."universitas" VALUES (97160, 14195, 'AKADEMI PEREKAM MEDIK DAN INFOKES IMELDA');
INSERT INTO "public"."universitas" VALUES (97161, 14196, 'AKADEMI KEPERAWATAN HARAPAN MAMA DELI SERDANG');
INSERT INTO "public"."universitas" VALUES (97162, 14198, 'AKADEMI KEBIDANAN PALUTA HUSADA');
INSERT INTO "public"."universitas" VALUES (97163, 14199, 'AKADEMI KEPERAWATAN COLUMBIA ASIA');
INSERT INTO "public"."universitas" VALUES (97164, 14200, 'AKADEMI KEPERAWATAN BINA HUSADA TEBING TINGGI');
INSERT INTO "public"."universitas" VALUES (97165, 14204, 'AKADEMI KEPERAWATAN SEHAT BINJAI');
INSERT INTO "public"."universitas" VALUES (97166, 14205, 'AKADEMI KEPERAWATAN MALAHAYATI MEDAN');
INSERT INTO "public"."universitas" VALUES (97167, 14207, 'AKADEMI KEBIDANAN KHARISMA HUSADA BINJAI');
INSERT INTO "public"."universitas" VALUES (97168, 14209, 'AKADEMI KEBIDANAN SIFRA HUSADA');
INSERT INTO "public"."universitas" VALUES (97169, 14213, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER IMELDA');
INSERT INTO "public"."universitas" VALUES (97170, 14214, 'AKADEMI KEPERAWATAN TAKASIMA KABANJAHE');
INSERT INTO "public"."universitas" VALUES (97171, 14215, 'AKADEMI KEBIDANAN AUDI HUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97172, 14216, 'AKADEMI KEPERAWATAN RSU HERNA');
INSERT INTO "public"."universitas" VALUES (97173, 14217, 'AKADEMI FISIOTERAPI SITI HAJAR MEDAN');
INSERT INTO "public"."universitas" VALUES (97174, 14219, 'AKADEMI KEBIDANAN BINA SEJAHTERA AMETA');
INSERT INTO "public"."universitas" VALUES (97175, 14220, 'AKADEMI KEPERAWATAN ABDI FLORENSIA');
INSERT INTO "public"."universitas" VALUES (97176, 14222, 'AKADEMI KEPERAWATAN KESDAM I/BUKIT BARISAN PEMATANG SIANTAR');
INSERT INTO "public"."universitas" VALUES (97177, 14223, 'AKADEMI KEPERAWATAN KESDAM I/BUKIT BARISAN BINJAI');
INSERT INTO "public"."universitas" VALUES (97178, 14224, 'AKADEMI KEPERAWATAN KESDAM I/BUKIT BARISAN MEDAN');
INSERT INTO "public"."universitas" VALUES (97179, 14227, 'AKADEMI FARMASI YAYASAN TENAGA PEMBANGUNAN ARJUNA LAGUBOTI');
INSERT INTO "public"."universitas" VALUES (97180, 14228, 'AKADEMI KEPERAWATAN SARI MUTIARA MEDAN');
INSERT INTO "public"."universitas" VALUES (97181, 14229, 'AKADEMI ANALIS KESEHATAN SARI MUTIARA');
INSERT INTO "public"."universitas" VALUES (97182, 14231, 'AKADEMI ANALIS FARMASI DAN MAKANAN SARI MUTIARA (ALIH BINA');
INSERT INTO "public"."universitas" VALUES (97183, 14232, 'AKADEMI KEPERAWATAN SYUHADA PADANGSIDEMPUAN');
INSERT INTO "public"."universitas" VALUES (97184, 14234, 'AKADEMI KEPERAWATAN HKBP BALIGE');
INSERT INTO "public"."universitas" VALUES (97185, 14236, 'AKADEMI KEPERAWATAN WIRAHUSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (97186, 14238, 'AKADEMI KEBIDANAN DELI HUSADA DELITUA MEDAN');
INSERT INTO "public"."universitas" VALUES (97187, 14239, 'AKADEMI KEPERAWATAN DELI HUSADA DELITUA MEDAN');
INSERT INTO "public"."universitas" VALUES (97188, 14240, 'AKADEMI KEPERAWATAN MEDISTRA LUBUK PAKAM');
INSERT INTO "public"."universitas" VALUES (97189, 14241, 'AKADEMI KEBIDANAN MEDISTRA LUBUK PAKAM');
INSERT INTO "public"."universitas" VALUES (97190, 14246, 'AKADEMI KEPERAWATAN BAS BALIMBINGAN PEMATANG SIANTAR');
INSERT INTO "public"."universitas" VALUES (97191, 14248, 'ATRO YAYASAN AMAL BHAKTI MEDAN');
INSERT INTO "public"."universitas" VALUES (97192, 14249, 'AKADEMI PENDIDIKAN KESEHATAN TALITAKUM');
INSERT INTO "public"."universitas" VALUES (97193, 14250, 'AKADEMI KEPERAWATAN RSU HISARMA MEDAN');
INSERT INTO "public"."universitas" VALUES (97194, 14251, 'AKADEMI PARIWISATA ULCLA');
INSERT INTO "public"."universitas" VALUES (97195, 15002, 'POLITEKNIK INFORMATIKA DEL TOBA SAMOSIR');
INSERT INTO "public"."universitas" VALUES (97196, 15003, 'POLITEKNIK UNGGUL LP3M');
INSERT INTO "public"."universitas" VALUES (97197, 15004, 'POLITEKNIK GANESHA');
INSERT INTO "public"."universitas" VALUES (97198, 15005, 'POLITEKNIK MANDIRI BINA PRESTASI');
INSERT INTO "public"."universitas" VALUES (97199, 15007, 'POLITEKNIK PROFESIONAL MANDIRI');
INSERT INTO "public"."universitas" VALUES (97200, 15008, 'POLITEKNIK POLIPROFESI MEDAN');
INSERT INTO "public"."universitas" VALUES (97201, 15009, 'POLITEKNIK LP3I MEDAN');
INSERT INTO "public"."universitas" VALUES (97202, 15010, 'POLITEKNIK TUGU 45 MEDAN');
INSERT INTO "public"."universitas" VALUES (97203, 15011, 'POLITEKNIK SANTO THOMAS');
INSERT INTO "public"."universitas" VALUES (97204, 15012, 'POLITEKNIK TRIJAYA KRAMA');
INSERT INTO "public"."universitas" VALUES (97205, 15013, 'POLITEKNIK YANADA');
INSERT INTO "public"."universitas" VALUES (97206, 15015, 'POLITEKNIK TANJUNGBALAI');
INSERT INTO "public"."universitas" VALUES (97207, 15016, 'POLITEKNIK KESEHATAN YRSU DR RUSDI');
INSERT INTO "public"."universitas" VALUES (97208, 15017, 'POLITEKNIK IT&B MEDAN');
INSERT INTO "public"."universitas" VALUES (97209, 15021, 'POLITEKNIK BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97210, 15022, 'POLITEKNIK GIHON');
INSERT INTO "public"."universitas" VALUES (97211, 15023, 'POLITEKNIK WILMAR BISNIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (97212, 15024, 'POLITEKNIK ADIGUNA MARITIM INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (97213, 15025, 'POLITEKNIK CENDANA');
INSERT INTO "public"."universitas" VALUES (97214, 21001, 'UNIVERSITAS MUHAMMADIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97215, 21002, 'UNIVERSITAS MUHAMMADIYAH LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97216, 21003, 'UNIVERSITAS SANG BUMI RUWA JURAI');
INSERT INTO "public"."universitas" VALUES (97217, 21004, 'UNIVERSITAS MUHAMMADIYAH METRO');
INSERT INTO "public"."universitas" VALUES (97218, 21005, 'UNIVERSITAS PROF DR HAZAIRIN SH');
INSERT INTO "public"."universitas" VALUES (97219, 21006, 'UNIVERSITAS PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97220, 21007, 'UNIVERSITAS IBA');
INSERT INTO "public"."universitas" VALUES (97221, 21008, 'UNIVERSITAS TRIDINANTI');
INSERT INTO "public"."universitas" VALUES (97222, 21009, 'UNIVERSITAS MALAHAYATI');
INSERT INTO "public"."universitas" VALUES (97223, 21010, 'UNIVERSITAS MUHAMMADIYAH BENGKULU');
INSERT INTO "public"."universitas" VALUES (97224, 21011, 'UNIVERSITAS TAMANSISWA');
INSERT INTO "public"."universitas" VALUES (97225, 21012, 'UNIVERSITAS BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97226, 21013, 'UNIVERSITAS SJAKHYAKIRTI');
INSERT INTO "public"."universitas" VALUES (97227, 21014, 'UNIVERSITAS TULANG BAWANG');
INSERT INTO "public"."universitas" VALUES (97228, 21015, 'UNIVERSITAS BATURAJA');
INSERT INTO "public"."universitas" VALUES (97229, 21016, 'UNIVERSITAS PGRI PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97230, 21017, 'UNIVERSITAS KADER BANGSA');
INSERT INTO "public"."universitas" VALUES (97231, 21018, 'UNIVERSITAS RATU SAMBAN');
INSERT INTO "public"."universitas" VALUES (97232, 21019, 'UNIVERSITAS BINA DARMA');
INSERT INTO "public"."universitas" VALUES (97233, 21020, 'UNIVERSITAS BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (97234, 21021, 'UNIVERSITAS MEGOU PAK TULANG BAWANG');
INSERT INTO "public"."universitas" VALUES (97235, 21022, 'UNIVERSITAS ISLAM OGAN KOMERING ILIR KAYUAGUNG');
INSERT INTO "public"."universitas" VALUES (97236, 21023, 'UNIVERSITAS DEHASEN BENGKULU');
INSERT INTO "public"."universitas" VALUES (97237, 21024, 'UNIVERSITAS INDO GLOBAL MANDIRI');
INSERT INTO "public"."universitas" VALUES (97238, 21025, 'UNIVERSITAS MUSI RAWAS');
INSERT INTO "public"."universitas" VALUES (97239, 21026, 'UNIVERSITAS NAHDLATUL ULAMA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97240, 21027, 'UNIVERSITAS KATOLIK MUSI CHARITAS');
INSERT INTO "public"."universitas" VALUES (97241, 21028, 'UNIVERSITAS TEKNOKRAT INDONESIA');
INSERT INTO "public"."universitas" VALUES (97242, 21029, 'UNIVERSITAS MITRA INDONESIA');
INSERT INTO "public"."universitas" VALUES (97243, 21030, 'UNIVERSITAS SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (97244, 21031, 'UNIVERSITAS AISYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97245, 21032, 'UNIVERSITAS BINA INSAN');
INSERT INTO "public"."universitas" VALUES (97246, 21033, 'UNIVERSITAS PAT PETULAI');
INSERT INTO "public"."universitas" VALUES (97247, 21034, 'UNIVERSITAS MUHAMMADIYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97248, 21035, 'UNIVERSITAS MUHAMMADIYAH KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97249, 21036, 'UNIVERSITAS MUHAMMADIYAH BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (97250, 22001, 'INSTITUT INFORMATIKA DAN BISNIS DARMAJAYA');
INSERT INTO "public"."universitas" VALUES (97251, 22002, 'INSTITUT SAINS DAN BISNIS ATMA LUHUR');
INSERT INTO "public"."universitas" VALUES (97252, 22003, 'INSTITUT TEKNOLOGI DAN BISNIS DINIYYAH LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97253, 22004, 'INSTITUT TEKNOLOGI DAN BISNIS MESUJI');
INSERT INTO "public"."universitas" VALUES (97254, 23001, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97255, 23002, 'STKIP PGRI LUBUK LINGGAU');
INSERT INTO "public"."universitas" VALUES (97256, 23003, 'SEKOLAH TINGGI ILMU PERTANIAN SURYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97257, 23004, 'SEKOLAH TINGGI ILMU ADMINISTRASI BENGKULU');
INSERT INTO "public"."universitas" VALUES (97258, 23005, 'STISIPOL CANDRADIMUKA');
INSERT INTO "public"."universitas" VALUES (97259, 23006, 'SEKOLAH TINGGI ILMU PERTANIAN DHARMA WACANA');
INSERT INTO "public"."universitas" VALUES (97260, 23008, 'STKIP PGRI METRO');
INSERT INTO "public"."universitas" VALUES (97261, 23009, 'SEKOLAH TINGGI ILMU EKONOMI PERTIBA');
INSERT INTO "public"."universitas" VALUES (97262, 23010, 'STKIP MUHAMMADIYAH KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97263, 23011, 'STKIP MUHAMMADIYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97264, 23012, 'SEKOLAH TINGGI ILMU HUKUM PERTIBA PANGKALPINANG');
INSERT INTO "public"."universitas" VALUES (97265, 23013, 'STKIP PGRI BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97266, 23014, 'SEKOLAH TINGGI TEKNIK MUSI');
INSERT INTO "public"."universitas" VALUES (97267, 23016, 'SEKOLAH TINGGI ILMU EKONOMI RAGAM TUNAS');
INSERT INTO "public"."universitas" VALUES (97268, 23017, 'SEKOLAH TINGGI ILMU PERTANIAN SRIWIGAMA');
INSERT INTO "public"."universitas" VALUES (97269, 23019, 'SEKOLAH TINGGI ILMU EKONOMI APRIN');
INSERT INTO "public"."universitas" VALUES (97270, 23020, 'SEKOLAH TINGGI ILMU MANAJEMEN AMKOP');
INSERT INTO "public"."universitas" VALUES (97271, 23021, 'STISIPOL DHARMA WACANA');
INSERT INTO "public"."universitas" VALUES (97272, 23022, 'SEKOLAH TINGGI PERKEBUNAN LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97273, 23023, 'SEKOLAH TINGGI ILMU EKONOMI SERASAN MUARA ENIM');
INSERT INTO "public"."universitas" VALUES (97274, 23024, 'SEKOLAH TINGGI ILMU HUKUM SUMPAH PEMUDA');
INSERT INTO "public"."universitas" VALUES (97275, 23025, 'SEKOLAH TINGGI ILMU EKONOMI SERELO LAHAT');
INSERT INTO "public"."universitas" VALUES (97276, 23026, 'SEKOLAH TINGGI TEKNOLOGI NUSANTARA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97277, 23027, 'SEKOLAH TINGGI ILMU EKONOMI TRISNA NEGARA');
INSERT INTO "public"."universitas" VALUES (97278, 23030, 'STKIP DHARMA WACANA');
INSERT INTO "public"."universitas" VALUES (97279, 23031, 'SEKOLAH TINGGI BAHASA ASING YUNISLA BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97280, 23033, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH KALIANDA');
INSERT INTO "public"."universitas" VALUES (97281, 23036, 'STMIK TUNAS BANGSA');
INSERT INTO "public"."universitas" VALUES (97282, 23037, 'SEKOLAH TINGGI ILMU HUKUM SERASAN MUARA ENIM');
INSERT INTO "public"."universitas" VALUES (97283, 23038, 'SEKOLAH TINGGI ILMU TEKNIK SERASAN');
INSERT INTO "public"."universitas" VALUES (97284, 23039, 'SEKOLAH TINGGI ILMU EKONOMI PRASETIYA MANDIRI LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97285, 23041, 'STIPSI WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97286, 23042, 'SEKOLAH TINGGI ILMU EKONOMI MULIA DARMA PRATAMA');
INSERT INTO "public"."universitas" VALUES (97287, 23043, 'SEKOLAH TINGGI ILMU EKONOMI DWI SAKTI BATURAJA');
INSERT INTO "public"."universitas" VALUES (97288, 23044, 'SEKOLAH TINGGI ILMU EKONOMI RAHMANIYAH');
INSERT INTO "public"."universitas" VALUES (97289, 23045, 'SEKOLAH TINGGI ILMU EKONOMI MUSI RAWAS');
INSERT INTO "public"."universitas" VALUES (97290, 23046, 'SEKOLAH TINGGI ILMU EKONOMI SATU NUSA');
INSERT INTO "public"."universitas" VALUES (97291, 23047, 'SEKOLAH TINGGI BAHASA ASING METHODIST');
INSERT INTO "public"."universitas" VALUES (97292, 23048, 'SEKOLAH TINGGI ILMU EKONOMI MUSI');
INSERT INTO "public"."universitas" VALUES (97293, 23049, 'SEKOLAH TINGGI BAHASA ASING TEKNOKRAT');
INSERT INTO "public"."universitas" VALUES (97294, 23050, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMADIYAH KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97295, 23051, 'STIKESMAS WIDYA DHARMA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97296, 23052, 'SEKOLAH TINGGI ILMU ADMINISTRASI SATYA NEGARA');
INSERT INTO "public"."universitas" VALUES (97297, 23053, 'SEKOLAH TINGGI BAHASA ASING WIDYA DHARMA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97298, 23055, 'SEKOLAH TINGGI ILMU HUKUM RAHMANIYAH');
INSERT INTO "public"."universitas" VALUES (97299, 23057, 'SEKOLAH TINGGI ILMU KESEHATAN BINA HUSADA');
INSERT INTO "public"."universitas" VALUES (97300, 23059, 'SEKOLAH TINGGI ILMU EKONOMI PRABUMULIH');
INSERT INTO "public"."universitas" VALUES (97301, 23060, 'STIE IBEK PANGKALPINANG BANGKA');
INSERT INTO "public"."universitas" VALUES (97302, 23061, 'STKIP MUHAMMADIYAH PAGARALAM');
INSERT INTO "public"."universitas" VALUES (97303, 23062, 'SEKOLAH TINGGI ILMU EKONOMI LEMBAH DEMPO');
INSERT INTO "public"."universitas" VALUES (97304, 23063, 'STMIK SURYA INTAN');
INSERT INTO "public"."universitas" VALUES (97305, 23064, 'STMIK DHARMA WACANA');
INSERT INTO "public"."universitas" VALUES (97306, 23065, 'STIKESMAS NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97307, 23066, 'STMIK PRABUMULIH');
INSERT INTO "public"."universitas" VALUES (97308, 23067, 'SEKOLAH TINGGI ILMU TEKNIK PRABUMULIH');
INSERT INTO "public"."universitas" VALUES (97309, 23068, 'SEKOLAH TINGGI ILMU EKONOMI ABDI NUSA');
INSERT INTO "public"."universitas" VALUES (97310, 23069, 'STIKESMAS ABDI NUSA');
INSERT INTO "public"."universitas" VALUES (97311, 23071, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMADIYAH KALIANDA');
INSERT INTO "public"."universitas" VALUES (97312, 23073, 'SEKOLAH TINGGI ILMU EKONOMI MITRA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97313, 23074, 'SEKOLAH TINGGI ILMU PERTANIAN BELITANG');
INSERT INTO "public"."universitas" VALUES (97314, 23075, 'STMIK MITRA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97315, 23076, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97316, 23077, 'STIKES TRI MANDIRI SAKTI BENGKULU');
INSERT INTO "public"."universitas" VALUES (97317, 23078, 'STIPSI ABDI NUSA');
INSERT INTO "public"."universitas" VALUES (97318, 23079, 'SEKOLAH TINGGI ILMU KESEHATAN ABDI NUSA');
INSERT INTO "public"."universitas" VALUES (97319, 23080, 'SEKOLAH TINGGI ILMU KESEHATAN AL MA ARIF');
INSERT INTO "public"."universitas" VALUES (97320, 23081, 'SEKOLAH TINGGI ILMU MARITIM MUTIARA JAYA');
INSERT INTO "public"."universitas" VALUES (97321, 23083, 'SEKOLAH TINGGI ILMU FARMASI BHAKTI PERTIWI');
INSERT INTO "public"."universitas" VALUES (97322, 23084, 'STMIK GLOBAL INFORMATIKA MDP');
INSERT INTO "public"."universitas" VALUES (97323, 23085, 'STKIP SERA');
INSERT INTO "public"."universitas" VALUES (97324, 23086, 'STMIK TEKNOKRAT');
INSERT INTO "public"."universitas" VALUES (97325, 23087, 'SEKOLAH TINGGI ILMU EKONOMI LANTIM WAY JEPARA');
INSERT INTO "public"."universitas" VALUES (97326, 23088, 'SEKOLAH TINGGI ILMU TEKNIK TRISULA');
INSERT INTO "public"."universitas" VALUES (97327, 23089, 'STIKES BHAKTI HUSADA BENGKULU');
INSERT INTO "public"."universitas" VALUES (97328, 23092, 'SEKOLAH TINGGI ILMU PERTANIAN REJANG LEBONG');
INSERT INTO "public"."universitas" VALUES (97329, 23094, 'STMIK MUARA DUA');
INSERT INTO "public"."universitas" VALUES (97330, 23095, 'STIA & PEMERINTAHAN ANNISA DWI SALFARIZI');
INSERT INTO "public"."universitas" VALUES (97331, 23096, 'STMIK MUSI RAWAS');
INSERT INTO "public"."universitas" VALUES (97332, 23097, 'SEKOLAH TINGGI ILMU KESEHATAN SITI KHADIJAH');
INSERT INTO "public"."universitas" VALUES (97333, 23098, 'STIKES PEMBINA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97334, 23099, 'SEKOLAH TINGGI ILMU KESEHATAN FITRAH ALDAR');
INSERT INTO "public"."universitas" VALUES (97335, 23100, 'SEKOLAH TINGGI ILMU EKONOMI GENTIARAS');
INSERT INTO "public"."universitas" VALUES (97336, 23101, 'SEKOLAH TINGGI ILMU KESEHATAN PERDHAKI CHARITAS');
INSERT INTO "public"."universitas" VALUES (97337, 23102, 'SEKOLAH TINGGI TEKNOLOGI PAGARALAM');
INSERT INTO "public"."universitas" VALUES (97338, 23103, 'STMIK PALCOMTECH');
INSERT INTO "public"."universitas" VALUES (97339, 23105, 'STIKES MUHAMMADIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97340, 23106, 'STISIPOL PAHLAWAN 12');
INSERT INTO "public"."universitas" VALUES (97341, 23107, 'STMIK BINA NUSANTARA JAYA LUBUK LINGGAU');
INSERT INTO "public"."universitas" VALUES (97342, 23108, 'STKIP NURUL HUDA DI SUKARAJA');
INSERT INTO "public"."universitas" VALUES (97343, 23109, 'STMIK PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97344, 23110, 'SEKOLAH TINGGI ILMU KESEHATAN DEHASEN');
INSERT INTO "public"."universitas" VALUES (97345, 23111, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA ADIGUNA');
INSERT INTO "public"."universitas" VALUES (97346, 23112, 'STMIK DIAN CIPTA CENDIKIA KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97347, 23113, 'STIE MULTI DATA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97348, 23114, 'STIKES MUHAMMADIYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97349, 23115, 'SEKOLAH TINGGI ILMU KESEHATAN PERMATA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97350, 23116, 'STIKES AISYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97351, 23117, 'STIKES CITRA DELIMA BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (97352, 23118, 'STMIK ATMA LUHUR');
INSERT INTO "public"."universitas" VALUES (97353, 23119, 'STKIP AL ISLAM TUNAS BANGSA');
INSERT INTO "public"."universitas" VALUES (97354, 23120, 'STKIP MUHAMMADIYAH BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (97355, 23121, 'STIE PRAKARTI MULYA');
INSERT INTO "public"."universitas" VALUES (97356, 23122, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN KUMALA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97357, 23123, 'STISIP BINA MARTA');
INSERT INTO "public"."universitas" VALUES (97358, 23124, 'STIKES AISYIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97359, 23125, 'STMIK MBC PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97360, 23126, 'STKIP TUNAS PALAPA');
INSERT INTO "public"."universitas" VALUES (97361, 23127, 'STIA BALA PUTRA DEWA');
INSERT INTO "public"."universitas" VALUES (97362, 23128, 'SEKOLAH TINGGI ILMU EKONOMI KRAKATAU');
INSERT INTO "public"."universitas" VALUES (97363, 23129, 'SEKOLAH TINGGI TEKNOLOGI BENGKULU');
INSERT INTO "public"."universitas" VALUES (97364, 23130, 'SEKOLAH TINGGI ILMU EKONOMI AL-MADANI');
INSERT INTO "public"."universitas" VALUES (97365, 23131, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER KALIREJO LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97366, 23132, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN ROSALIA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97367, 23133, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER LEMBAH DEMPO');
INSERT INTO "public"."universitas" VALUES (97368, 23134, 'SEKOLAH TINGGI ILMU KESEHATAN ABDURAHMAN PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97369, 23135, 'STIKES ADILA');
INSERT INTO "public"."universitas" VALUES (97370, 23136, 'SEKOLAH TINGGI TEKNOLOGI AISYAH');
INSERT INTO "public"."universitas" VALUES (97371, 23137, 'SEKOLAH TINGGI ILMU EKONOMI DAN BISNIS PRANA PUTRA');
INSERT INTO "public"."universitas" VALUES (97372, 23138, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN MUHAMMADIYAH OKU TIMUR');
INSERT INTO "public"."universitas" VALUES (97373, 23139, 'SEKOLAH TINGGI ILMU KESEHATAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (97374, 23140, 'SEKOLAH TINGGI ILMU KESEHATAN SAPTA BAKTI');
INSERT INTO "public"."universitas" VALUES (97375, 23141, 'SEKOLAH TINGGI KESEHATAN AL-FATAH BENGKULU');
INSERT INTO "public"."universitas" VALUES (97376, 23142, 'SEKOLAH TINGGI PONDOK PESANTREN ASSANADIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97377, 24003, 'AKADEMI AKUNTANSI SJAKHYAKIRTI');
INSERT INTO "public"."universitas" VALUES (97378, 24006, 'AKADEMI SEKRETARI DAN MANAJEMEN SRIWIJAYA');
INSERT INTO "public"."universitas" VALUES (97379, 24007, 'AMIK SIGMA');
INSERT INTO "public"."universitas" VALUES (97380, 24008, 'AKADEMI PARIWISATA SATU NUSA');
INSERT INTO "public"."universitas" VALUES (97381, 24009, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER STARTECK');
INSERT INTO "public"."universitas" VALUES (97382, 24010, 'AKADEMI AKUNTANSI LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97383, 24012, 'AMIK MITRA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97384, 24014, 'AKADEMI AKUNTANSI UNGGULAN SMB PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97385, 24015, 'AKADEMI PERIKANAN BHIMA SAKTI');
INSERT INTO "public"."universitas" VALUES (97386, 24017, 'AKADEMI BAHASA ASING DIAN CIPTA CENDIKIA');
INSERT INTO "public"."universitas" VALUES (97387, 24018, 'AKADEMI AKUNTANSI BHAKTI');
INSERT INTO "public"."universitas" VALUES (97388, 24027, 'AKADEMI PARIWISATA WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97389, 24029, 'AKADEMI AKUNTANSI DAN MANAJEMEN MITRA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97390, 24030, 'AMIK MASTER LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97391, 24032, 'AKADEMI ANALIS KESEHATAN WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97392, 24033, 'AMIK DIAN CIPTA CENDIKIA');
INSERT INTO "public"."universitas" VALUES (97393, 24034, 'APIKES WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97394, 24035, 'AKADEMI KEUANGAN DAN BANK MULIA DARMA PRATAMA');
INSERT INTO "public"."universitas" VALUES (97395, 24036, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97396, 24038, 'AKADEMI SAINS DAN TEKNOLOGI PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (97397, 24039, 'AMIK TEKNOKRAT');
INSERT INTO "public"."universitas" VALUES (97398, 24040, 'AKD TEKNIK RADIODIAG. DAN RADIOTERAPI WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (97399, 24042, 'AKADEMI MANAJEMEN BELITUNG');
INSERT INTO "public"."universitas" VALUES (97400, 24043, 'AMIK LEMBAH DEMPO');
INSERT INTO "public"."universitas" VALUES (97401, 24044, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER MDP');
INSERT INTO "public"."universitas" VALUES (97402, 24050, 'AKADEMI BAHASA ASING BINA INSAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (97403, 24053, 'AKADEMI PERIKANAN WACHYUNI MANDIRA');
INSERT INTO "public"."universitas" VALUES (97404, 24063, 'AMIK AKMI');
INSERT INTO "public"."universitas" VALUES (97405, 24083, 'AKADEMI PERPAJAKAN TRIDARMA');
INSERT INTO "public"."universitas" VALUES (97406, 24084, 'AKADEMI KEBIDANAN WIRA BUANA');
INSERT INTO "public"."universitas" VALUES (97407, 24085, 'AKADEMI ANALIS KESEHATAN HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (97408, 24086, 'AKADEMI KEBIDANAN AISYIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97409, 24087, 'AKADEMI KEBIDANAN BUDI MULIA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97410, 24088, 'AKADEMI MARITIM BINA BAHARI');
INSERT INTO "public"."universitas" VALUES (97411, 24089, 'AKADEMI KEBIDANAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (97412, 24090, 'AKTEK RADIODIAGNOSTIK & RADIOTERAPI PATRIOT BANGSA');
INSERT INTO "public"."universitas" VALUES (97413, 24091, 'AKADEMI KEBIDANAN HEPPY ZAL');
INSERT INTO "public"."universitas" VALUES (97414, 24092, 'AKADEMI TEKNOLOGI PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97415, 24093, 'AKADEMI KEBIDANAN PATRIOT BANGSA HUSADA');
INSERT INTO "public"."universitas" VALUES (97416, 24095, 'AKADEMI KEBIDANAN NUSANTARA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97417, 24096, 'AKADEMI KEBIDANAN HAMPAR BAIDURI');
INSERT INTO "public"."universitas" VALUES (97418, 24098, 'AKADEMI KEPERAWATAN MALAHAYATI BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97419, 24099, 'AKADEMI KEPERAWATAN BAITUL HIKMAH');
INSERT INTO "public"."universitas" VALUES (97420, 24100, 'AKADEMI KEPERAWATAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (97421, 24101, 'AKADEMI KEPERAWATAN DHARMA WACANA');
INSERT INTO "public"."universitas" VALUES (97422, 24102, 'AKADEMI KEPERAWATAN BUNDA DELIMA');
INSERT INTO "public"."universitas" VALUES (97423, 24103, 'AKADEMI KEBIDANAN AL-SUA IBAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97424, 24104, 'AKADEMI KEBIDANAN ADILA');
INSERT INTO "public"."universitas" VALUES (97425, 24105, 'AKADEMI KEBIDANAN WAHANA HUSADA BANDAR JAYA');
INSERT INTO "public"."universitas" VALUES (97426, 24107, 'AKADEMI KEBIDANAN PERSADA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97427, 24108, 'AKBID GEMILANG HUSADA KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97428, 24109, 'AKADEMI KEBIDANAN BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (97429, 24110, 'AKADEMI KEBIDANAN RIZKI PATYA');
INSERT INTO "public"."universitas" VALUES (97430, 24111, 'AKADEMI KEBIDANAN MANNA');
INSERT INTO "public"."universitas" VALUES (97431, 24113, 'AKADEMI KEBIDANAN ABDURAHMAN');
INSERT INTO "public"."universitas" VALUES (97432, 24114, 'AKADEMI KEBIDANAN TUNAS HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (97433, 24115, 'AKADEMI KEBIDANAN AN-NUR HUSADA WALISONGO');
INSERT INTO "public"."universitas" VALUES (97434, 24116, 'AKADEMI KEBIDANAN NUSANTARA INDONESIA LUBUKLINGGAU');
INSERT INTO "public"."universitas" VALUES (97435, 24117, 'AKADEMI KEBIDANAN ALIFA PRINGSEWU LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97436, 24118, 'AKADEMI FARMASI YAYASAN AL-FATAH');
INSERT INTO "public"."universitas" VALUES (97437, 24119, 'AKADEMI KEBIDANAN SUNGAILIAT BANGKA');
INSERT INTO "public"."universitas" VALUES (97438, 24120, 'AMIK BINA SRIWIJAYA');
INSERT INTO "public"."universitas" VALUES (97439, 24121, 'AKADEMI KEBIDANAN DEHASEN BENGKULU');
INSERT INTO "public"."universitas" VALUES (97440, 24122, 'AKADEMI KEBIDANAN BUNGA BANGSAKU BANGKA');
INSERT INTO "public"."universitas" VALUES (97441, 24123, 'AKADEMI BAHASA ASING DIAN CIPTA CENDIKIA KOTABUMI');
INSERT INTO "public"."universitas" VALUES (97442, 24124, 'AKADEMI KEBIDANAN RANGGA HUSADA PRABUMULIH');
INSERT INTO "public"."universitas" VALUES (97443, 24125, 'AKADEMI KEBIDANAN PONDOK PESANTREN ASSANADIYAH');
INSERT INTO "public"."universitas" VALUES (97444, 24126, 'AKADEMI KESEHATAN YAYASAN SAPTA BAKTI BENGKULU');
INSERT INTO "public"."universitas" VALUES (97445, 24127, 'AKADEMI KEPERAWATAN SAPTA KARYA');
INSERT INTO "public"."universitas" VALUES (97446, 24128, 'AKADEMI KEBIDANAN SAPTA KARYA');
INSERT INTO "public"."universitas" VALUES (97447, 24129, 'AKADEMI KEBIDANAN NADIRA');
INSERT INTO "public"."universitas" VALUES (97448, 24130, 'AKADEMI KEBIDANAN BUDI MULIA PRABUMULIH');
INSERT INTO "public"."universitas" VALUES (97449, 24132, 'AKADEMI KEPERAWATAN PANGKALPINANG');
INSERT INTO "public"."universitas" VALUES (97450, 24133, 'AMIK DIAN CIPTA CENDIKIA PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (97451, 24134, 'AKADEMI KEPERAWATAN KESDAM II SRIWIJAYA');
INSERT INTO "public"."universitas" VALUES (97452, 24135, 'AKADEMI KEPERAWATAN AISYIYAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97453, 24136, 'AKADEMI KEBIDANAN AGUNG HUSADA');
INSERT INTO "public"."universitas" VALUES (97454, 24137, 'AKAFARMA PUTRA INDONESIA LAMPUNG');
INSERT INTO "public"."universitas" VALUES (97455, 24138, 'AKADEMI KEPERAWATAN AL MA ARIF');
INSERT INTO "public"."universitas" VALUES (97456, 24139, 'AKADEMI KEPERAWATAN PEMBINA');
INSERT INTO "public"."universitas" VALUES (97457, 24140, 'AKADEMI KEBIDANAN MEDICA BAKTI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (97458, 24142, 'AKADEMI FARMASI CENDIKIA FARMA HUSADA');
INSERT INTO "public"."universitas" VALUES (97459, 25001, 'POLITEKNIK MANUFAKTUR TIMAH');
INSERT INTO "public"."universitas" VALUES (97460, 25002, 'POLITEKNIK ANIKA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (97461, 25004, 'POLITEKNIK DARUSSALAM');
INSERT INTO "public"."universitas" VALUES (97462, 25006, 'POLITEKNIK YPPB BELITANG');
INSERT INTO "public"."universitas" VALUES (97463, 25007, 'POLITEKNIK RAFLESIA');
INSERT INTO "public"."universitas" VALUES (99407, 82004, 'IKIP MUHAMMADIYAH MAUMERE');
INSERT INTO "public"."universitas" VALUES (99408, 82005, 'INSTITUT KEGURUAN DAN TEKNOLOGI LARANTUKA');
INSERT INTO "public"."universitas" VALUES (99409, 82006, 'INSTITUT ILMU SOSIAL DAN ILMU BUDAYA SAMAWA REA');
INSERT INTO "public"."universitas" VALUES (99410, 82007, 'INSTITUT ILMU KESEHATAN MEDIKA PERSADA BALI');
INSERT INTO "public"."universitas" VALUES (99411, 82008, 'INSTITUT PENDIDIKAN NUSANTARA GLOBAL');
INSERT INTO "public"."universitas" VALUES (99412, 82009, 'INSTITUT TEKNOLOGI DAN KESEHATAN BALI');
INSERT INTO "public"."universitas" VALUES (99413, 82010, 'INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI');
INSERT INTO "public"."universitas" VALUES (99414, 82011, 'INSTITUT SAINS DAN TEKNOLOGI NAHDLATUL ULAMA BALI');
INSERT INTO "public"."universitas" VALUES (99415, 82012, 'INSTITUT KEGURUAN DAN ILMU PENDIDIKAN MATARAM');
INSERT INTO "public"."universitas" VALUES (99416, 82013, 'INSTITUT PARIWISATA DAN BISNIS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99417, 82014, 'INSTITUT TEKNOLOGI ALBERTH FOENAY');
INSERT INTO "public"."universitas" VALUES (99418, 82015, 'INSTITUT DESAIN DAN BISNIS BALI');
INSERT INTO "public"."universitas" VALUES (99419, 83001, 'SEKOLAH TINGGI ILMU ADMINISTRASI DENPASAR');
INSERT INTO "public"."universitas" VALUES (99420, 83002, 'SEKOLAH TINGGI ILMU MANAJEMEN INDONESIA HANDAYANI');
INSERT INTO "public"."universitas" VALUES (99421, 83003, 'SEKOLAH TINGGI ILMU SOSIAL POLITIK WIRA BHAKTI');
INSERT INTO "public"."universitas" VALUES (99422, 83004, 'STKIP AGAMA HINDU SINGARAJA');
INSERT INTO "public"."universitas" VALUES (99423, 83005, 'STISIP MARGARANA');
INSERT INTO "public"."universitas" VALUES (99424, 83006, 'STKIP AGAMA HINDU AMLAPURA');
INSERT INTO "public"."universitas" VALUES (99425, 83007, 'SEKOLAH TINGGI MANAJEMEN TAMAN PENDIDIKAN 45');
INSERT INTO "public"."universitas" VALUES (99426, 83008, 'SEKOLAH TINGGI ILMU EKONOMI SATYA DHARMA');
INSERT INTO "public"."universitas" VALUES (99427, 83009, 'SEKOLAH TINGGI ILMU EKONOMI TRIATMA MULYA');
INSERT INTO "public"."universitas" VALUES (99428, 83010, 'STIE BALI INTERNASIONAL INSTITUTE OF TOURISM MANAGEMENT');
INSERT INTO "public"."universitas" VALUES (99429, 83011, 'SEKOLAH TINGGI ILMU MANAJEMEN DYANA PURA');
INSERT INTO "public"."universitas" VALUES (99430, 83012, 'STKIP BIMA');
INSERT INTO "public"."universitas" VALUES (99431, 83013, 'STKIP HAMZANWADI');
INSERT INTO "public"."universitas" VALUES (99432, 83014, 'SEKOLAH TINGGI ILMU ADMINISTRASI MUHAMMADIYAH SELONG');
INSERT INTO "public"."universitas" VALUES (99433, 83015, 'SEKOLAH TINGGI ILMU SOSIAL DAN POLITIK MBOJO');
INSERT INTO "public"."universitas" VALUES (99434, 83016, 'SEKOLAH TINGGI ILMU EKONOMI 45 MATARAM');
INSERT INTO "public"."universitas" VALUES (99435, 83017, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMADIYAH BIMA');
INSERT INTO "public"."universitas" VALUES (99436, 83018, 'SEKOLAH TINGGI ILMU ADMINISTRASI MATARAM');
INSERT INTO "public"."universitas" VALUES (99437, 83019, 'STMIK BUMI GORA');
INSERT INTO "public"."universitas" VALUES (99438, 83020, 'SEKOLAH TINGGI ILMU EKONOMI NASIONAL');
INSERT INTO "public"."universitas" VALUES (99439, 83021, 'SEKOLAH TINGGI ILMU EKONOMI YAPIS');
INSERT INTO "public"."universitas" VALUES (99440, 83022, 'SEKOLAH TINGGI ILMU KESEHATAN MATARAM');
INSERT INTO "public"."universitas" VALUES (99441, 83023, 'SEKOLAH TINGGI FILSAFAT KATOLIK LEDALERO');
INSERT INTO "public"."universitas" VALUES (99442, 83024, 'STKIP SANTU PAULUS');
INSERT INTO "public"."universitas" VALUES (99443, 83025, 'SEKOLAH TINGGI ILMU MANAJEMEN KUPANG');
INSERT INTO "public"."universitas" VALUES (99444, 83026, 'SEKOLAH TINGGI ILMU EKONOMI WIRAWACANA');
INSERT INTO "public"."universitas" VALUES (99445, 83027, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA KOMPUTER UYELINDO KUPANG');
INSERT INTO "public"."universitas" VALUES (99446, 83028, 'SEKOLAH TINGGI ILMU EKONOMI OEMATHONIS');
INSERT INTO "public"."universitas" VALUES (99447, 83029, 'SEKOLAH TINGGI PEMBANGUNAN MASYARAKAT SANTA URSULA');
INSERT INTO "public"."universitas" VALUES (99448, 83030, 'STMIK - STIKOM');
INSERT INTO "public"."universitas" VALUES (99449, 83031, 'SEKOLAH TINGGI BAHASA ASING CAKRAWALA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99450, 83032, 'SEKOLAH TINGGI ILMU BAHASA (STIBA) HITA WIDYA SINGARAJA');
INSERT INTO "public"."universitas" VALUES (99451, 83033, 'SEKOLAH TINGGI BAHASA ASING SARASWATI');
INSERT INTO "public"."universitas" VALUES (99452, 83034, 'SEKOLAH TINGGI ILMU EKONOMI BIMA');
INSERT INTO "public"."universitas" VALUES (99453, 83035, 'SEKOLAH TINGGI BAHASA ASING MENTARI KUPANG');
INSERT INTO "public"."universitas" VALUES (99454, 83036, 'STMIK BANDUNG BALI');
INSERT INTO "public"."universitas" VALUES (99455, 83037, 'SEKOLAH TINGGI ILMU EKONOMI PUTRA TIMOR');
INSERT INTO "public"."universitas" VALUES (99456, 83038, 'SEKOLAH TINGGI ILMU TEKNIK JEMBRANA');
INSERT INTO "public"."universitas" VALUES (99457, 83039, 'SEKOLAH TINGGI ILMU TEKNOLOGI KELAUTAN');
INSERT INTO "public"."universitas" VALUES (99458, 83040, 'SEKOLAH TINGGI ILMU SOSIAL DAN POLITIK FAJAR TIMUR');
INSERT INTO "public"."universitas" VALUES (99459, 83041, 'STMIK LOMBOK');
INSERT INTO "public"."universitas" VALUES (99460, 83042, 'SEKOLAH TINGGI ILMU KESEHATAN BALI');
INSERT INTO "public"."universitas" VALUES (99461, 83043, 'SEKOLAH TINGGI ILMU EKONOMI AMM');
INSERT INTO "public"."universitas" VALUES (99462, 83044, 'STIMIK KUPANG');
INSERT INTO "public"."universitas" VALUES (99463, 83045, 'SEKOLAH TINGGI TEKNIK LINGKUNGAN MATARAM');
INSERT INTO "public"."universitas" VALUES (99464, 83046, 'STMIK DENPASAR');
INSERT INTO "public"."universitas" VALUES (99465, 83047, 'STIKES YARSI MATARAM');
INSERT INTO "public"."universitas" VALUES (99466, 83048, 'STMIK SYAIKH ZAINUDDIN NAHDLATUL WATHAN');
INSERT INTO "public"."universitas" VALUES (99467, 83049, 'STIKES QAMARUL HUDA');
INSERT INTO "public"."universitas" VALUES (99468, 83050, 'STIKES BINA USADA BALI');
INSERT INTO "public"."universitas" VALUES (99469, 83051, 'STKIP TAMAN SISWA BIMA');
INSERT INTO "public"."universitas" VALUES (99470, 83052, 'SEKOLAH TINGGI PARIWISATA BALI INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99471, 83053, 'SEKOLAH TINGGI INFORMATIKA KOMPUTER ARTHA BUANA');
INSERT INTO "public"."universitas" VALUES (99472, 83054, 'STIKES WIRA MEDIKA BALI');
INSERT INTO "public"."universitas" VALUES (99473, 83055, 'SEKOLAH TINGGI ILMU KESEHATAN JEMBRANA');
INSERT INTO "public"."universitas" VALUES (99474, 83056, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER STIKOM INDONESIA');
INSERT INTO "public"."universitas" VALUES (99475, 83058, 'SEKOLAH TINGGI PARIWISATA TRIATMA JAYA');
INSERT INTO "public"."universitas" VALUES (99476, 83059, 'STKIP INDONESIA KUPANG');
INSERT INTO "public"."universitas" VALUES (99477, 83060, 'SEKOLAH TINGGI ILMU KESEHATAN MAJAPAHIT SINGARAJA');
INSERT INTO "public"."universitas" VALUES (99478, 83061, 'STIKES CITRA HUSADA MANDIRI');
INSERT INTO "public"."universitas" VALUES (99479, 83062, 'STKIP YAPIS DOMPU');
INSERT INTO "public"."universitas" VALUES (99480, 83063, 'STKIP SUAR BANGLI');
INSERT INTO "public"."universitas" VALUES (99481, 83064, 'SEKOLAH TINGGI TEKNIK BIMA');
INSERT INTO "public"."universitas" VALUES (99482, 83065, 'STIKES ADVAITA MEDIKA TABANAN');
INSERT INTO "public"."universitas" VALUES (99483, 83066, 'STKIP AL AMIN DOMPU');
INSERT INTO "public"."universitas" VALUES (99484, 83067, 'STIKES HAMZAR MEMBEN LOMBOK TIMUR');
INSERT INTO "public"."universitas" VALUES (99485, 83068, 'STIKES YAHYA BIMA');
INSERT INTO "public"."universitas" VALUES (99486, 83069, 'STIKES MARANATHA KUPANG');
INSERT INTO "public"."universitas" VALUES (99487, 83070, 'SEKOLAH TINGGI ILMU KESEHATAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99488, 83071, 'STKIP HAMZAR');
INSERT INTO "public"."universitas" VALUES (99489, 83072, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN CITRA BAKTI');
INSERT INTO "public"."universitas" VALUES (99490, 83073, 'STKIP QAMARUL HUDA');
INSERT INTO "public"."universitas" VALUES (99491, 83074, 'STKIP NUSA BUNGA FLORESTA');
INSERT INTO "public"."universitas" VALUES (99492, 83075, 'SEKOLAH TINGGI DESAIN BALI');
INSERT INTO "public"."universitas" VALUES (100826, 203011, 'STAIN PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100827, 203012, 'STAIN SJECH M. DJAMIL DJAMBEK BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100828, 203013, 'STAIN SULTAN QAIMUDDIN KENDARI');
INSERT INTO "public"."universitas" VALUES (100829, 203014, 'STAIN SYAIKH ABDURRAHMAN SIDDIK BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (100830, 203015, 'STAIN TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (100831, 203016, 'STAIN SALATIGA');
INSERT INTO "public"."universitas" VALUES (100832, 203017, 'STAIN KUDUS');
INSERT INTO "public"."universitas" VALUES (100833, 203018, 'STAIN MALIKUSSALEH');
INSERT INTO "public"."universitas" VALUES (100834, 203019, 'STAIN AL-FATAH JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100835, 203020, 'STAIN ZAWIYAH COT KALA LANGSA');
INSERT INTO "public"."universitas" VALUES (100836, 203021, 'STAIN CURUP');
INSERT INTO "public"."universitas" VALUES (100837, 203022, 'STAIN TERNATE');
INSERT INTO "public"."universitas" VALUES (100838, 203023, 'STAIN WATAMPONE');
INSERT INTO "public"."universitas" VALUES (100839, 203024, 'STAIN DATOKARAMA PALU');
INSERT INTO "public"."universitas" VALUES (100840, 203025, 'STAIN PALANGKARAYA');
INSERT INTO "public"."universitas" VALUES (100841, 203026, 'STAIN SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100842, 203027, 'STAIN KERINCI');
INSERT INTO "public"."universitas" VALUES (100843, 203028, 'STAIN JURAI SIWO METRO');
INSERT INTO "public"."universitas" VALUES (100844, 203029, 'STAIN JEMBER');
INSERT INTO "public"."universitas" VALUES (100845, 203030, 'STAIN KEDIRI');
INSERT INTO "public"."universitas" VALUES (100846, 203031, 'STAIN PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (100847, 203032, 'STAIN SORONG');
INSERT INTO "public"."universitas" VALUES (100848, 203033, 'STAIN GAJAH PUTIH TAKENGON ACEH TENGAH');
INSERT INTO "public"."universitas" VALUES (100849, 203034, 'STAIN TENGKU DIRUNDENG MEULABOH');
INSERT INTO "public"."universitas" VALUES (100850, 203035, 'STAIN BENGKALIS');
INSERT INTO "public"."universitas" VALUES (100851, 203036, 'SEKOLAH TINGGI AGAMA ISLAM NEGERI MAJENE');
INSERT INTO "public"."universitas" VALUES (100852, 203037, 'SEKOLAH TINGGI AGAMA ISLAM NEGERI MANDAILING NATAL');
INSERT INTO "public"."universitas" VALUES (100853, 203038, 'SEKOLAH TINGGI AGAMA ISLAM NEGERI SULTAN ABDURRAHMAN KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (100854, 211001, 'UNIVERSITAS ISLAM ZAINUL HASAN GENGGONG PROBOLINGGO');
INSERT INTO "public"."universitas" VALUES (100855, 212001, 'INSTITUT STUDI ISLAM FAHMINA (ISIF)');
INSERT INTO "public"."universitas" VALUES (100856, 212002, 'INSTITUT ILMU AL-QUR`AN JANNATU ADNIN KENDARI, SULAWESI TENG');
INSERT INTO "public"."universitas" VALUES (100857, 212003, 'INSTITUT AGAMA ISLAM LATIFAH MUBAROKIYAH (IAILM) SURYALAYA TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (100858, 212004, 'INSTITUT AGAMA ISLAM CIPASUNG (IAIC) CIPASUNG, SINGAPARNA, TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (100859, 212005, 'INSTITUT AGAMA ISLAM DARUSSALAM (IAID) CIAMIS JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (100860, 212006, 'INSTITUT AGAMA ISLAM HAMZANWADI NW PANCOR LOMBOK TIMUR');
INSERT INTO "public"."universitas" VALUES (100861, 212007, 'INSTITUT AGAMA ISLAM IBRAHIMY (IAII) SUKOREJO SITUBONDO');
INSERT INTO "public"."universitas" VALUES (100862, 212008, 'INSTITUT AGAMA ISLAM NURUL JADID PAITON PROBOLINGGO (IAINJ)');
INSERT INTO "public"."universitas" VALUES (100863, 212009, 'INSTITUT AGAMA ISLAM QOMARUL HUDA BAGU PARINGGATA LOMBOK TENGAH');
INSERT INTO "public"."universitas" VALUES (100864, 212010, 'INSTITUT AGAMA ISLAM RIYADLATUL MUJAHIDIN NGABAR (IAIRM) PONOROGO');
INSERT INTO "public"."universitas" VALUES (100865, 212011, 'INSTITUT AGAMA ISLAM SUNAN GIRI (INSURI) PONOROGO');
INSERT INTO "public"."universitas" VALUES (100866, 212012, 'INSTITUT AGAMA ISLAM TRIBAKTI (IAIT) KEDIRI');
INSERT INTO "public"."universitas" VALUES (100867, 212013, 'INSTITUT DIROSAT ISLAMIYAH AL-AMIEN PRENDUAN SUMENEP');
INSERT INTO "public"."universitas" VALUES (100868, 212014, 'INSTITUT ILMU KEISLAMAN ANNUQAYAH (INSTIKA) GULUK-GULUK SUMENEP');
INSERT INTO "public"."universitas" VALUES (100869, 212015, 'INSTITUT KEISLAMAN ABDULLAH FAQIH MANYAR GRESIK');
INSERT INTO "public"."universitas" VALUES (100870, 212016, 'INSTITUT KEISLAMAN HASYIM AS`ARI (IKAHA) TEBUIRENG JOMBANG');
INSERT INTO "public"."universitas" VALUES (100871, 212017, 'INSTITUT STUDI ISLAM DARUSSALAM (ISID) GONTOR PONOROGO');
INSERT INTO "public"."universitas" VALUES (100872, 212018, 'INSTITUT AGAMA ISLAM DAAR AL-ULUM (IAIDU) ASAHAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (100873, 212019, 'INSTITUT AGAMA ISLAM IMAM GHOZALI (IAIIG) CILACAP');
INSERT INTO "public"."universitas" VALUES (100874, 212020, 'INSTITUT ISLAM NAHDLATUL ULAMA JEPARA (INISNU), JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (100875, 212021, 'INSTITUT AGAMA ISLAM HAMZANWADI NW LOMBOK TIMUR');
INSERT INTO "public"."universitas" VALUES (100876, 212022, 'INSTITUT AGAMA ISLAM AL-GHURABA RAWAMANGUN JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (100877, 212023, 'INSTITUT AGAMA ISLAM JAMI`AT KHAIR JAKARTA PUSAT');
INSERT INTO "public"."universitas" VALUES (100878, 212024, 'INSTITUT AGAMA ISLAM SHALAHUDDIN AL-AYYUBI (INISA) TAMBUN BEKASI');
INSERT INTO "public"."universitas" VALUES (100879, 212025, 'INSTITUT ILMU AL-QUR`AN (IIQ) JAKARTA, JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (100880, 212026, 'INSTITUT PEMBINA ROHANI ISLAM (IPRIJA) JAKARTA, CIRACAS, JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (100881, 212027, 'INSTITUT PTIQ JAKARTA, JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (100882, 212028, 'INSTITUT AGAMA ISLAM AZ-ZAYTUN INDONESIA');
INSERT INTO "public"."universitas" VALUES (100883, 212029, 'INSTITUT AGAMA ISLAM DARULLUGHAH WADDA''WAH BANGIL, PASURUAN');
INSERT INTO "public"."universitas" VALUES (100884, 212030, 'INSTITUT AGAMA ISLAM MA''ARIF NU (IAIMNU) METRO LAMPUNG');
INSERT INTO "public"."universitas" VALUES (100885, 212031, 'INSTITUT AGAMA ISLAM NAHDLATUL ULAMA (IAI NU) KEBUMEN');
INSERT INTO "public"."universitas" VALUES (100886, 212032, 'INSTITUT AGAMA ISLAM ALMUSLIM ACEH');
INSERT INTO "public"."universitas" VALUES (100888, 212034, 'INSTITUT AGAMA ISLAM DARUL DA''WAH WAL IRSYAD POLEWALI MANDAR');
INSERT INTO "public"."universitas" VALUES (100889, 212035, 'INSTITUT AGAMA ISLAM (IAI) BANI FATTAH JOMBANG');
INSERT INTO "public"."universitas" VALUES (100890, 212036, 'INSTITUT AGAMA ISLAM (IAI) PANGERAN DIPONEGORO NGANJUK');
INSERT INTO "public"."universitas" VALUES (100891, 212037, 'INSTITUT AGAMA ISLAM (IAI) SYARIFUDDIN WONOREJO LUMAJANG');
INSERT INTO "public"."universitas" VALUES (100892, 212038, 'INSTITUT AGAMA ISLAM (IAI) AL-AZIZIYAH SAMALANGA BIREUEN ACEH');
INSERT INTO "public"."universitas" VALUES (100893, 212039, 'INSTITUT AGAMA ISLAM (IAI) AL-AZHAAR LUBUKLINGGAU');
INSERT INTO "public"."universitas" VALUES (100894, 212040, 'INSTITUT AGAMA ISLAM (IAI) NURUL HAKIM KEDIRI LOMBOK BARAT NTB');
INSERT INTO "public"."universitas" VALUES (100895, 212041, 'INSTITUT AGAMA ISLAM SUNAN GIRI BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (100896, 212042, 'INSTITUT AGAMA ISLAM TAFAQQUH FIDDIN DUMAI');
INSERT INTO "public"."universitas" VALUES (100897, 212043, 'INSTITUT AGAMA ISLAM QOMARUDDIN GRESIK');
INSERT INTO "public"."universitas" VALUES (100898, 212044, 'INSTITUT AGAMA ISLAM (IAI) AL-QOLAM');
INSERT INTO "public"."universitas" VALUES (102051, 273013, 'SEKOLAH TINGGI PASTORAL REINHA LARANTUKA');
INSERT INTO "public"."universitas" VALUES (102052, 273014, 'STKPK BINA INSAN');
INSERT INTO "public"."universitas" VALUES (102053, 273015, 'STPAK ST. YOHANES PENGINJIL AMBON');
INSERT INTO "public"."universitas" VALUES (102054, 273016, 'STP DON BOSCO TOMOHON');
INSERT INTO "public"."universitas" VALUES (102055, 273017, 'STP ST. BONAVENTURA DELITUA MEDAN');
INSERT INTO "public"."universitas" VALUES (102056, 273018, 'STIPAS TAHASAK DANUM PAMBELUM KEUSKUPAN PALANGKARAYA');
INSERT INTO "public"."universitas" VALUES (102057, 273019, 'STFK LEDALERO NITA MAUMERE');
INSERT INTO "public"."universitas" VALUES (102058, 273020, 'STK TOUYE PAAPAA DEIYAI KEUSKUPAN TIMIKA');
INSERT INTO "public"."universitas" VALUES (102059, 274001, 'STIKAS SANTO YOHANES SALIB');
INSERT INTO "public"."universitas" VALUES (102060, 283001, 'SEKOLAH TINGGI AGAMA BUDDHA NEGERI SRIWIJAYA TANGERANG');
INSERT INTO "public"."universitas" VALUES (102061, 283002, 'SEKOLAH TINGGI AGAMA BUDDHA NEGERI RADEN WIJAYA');
INSERT INTO "public"."universitas" VALUES (102062, 292001, 'INSTITUTE AGAMA BUDDHA NASIONAL DIVYARAJYA');
INSERT INTO "public"."universitas" VALUES (102063, 293001, 'SEKOLAH TINGGI AGAMA BUDDHA DUTAVIRA');
INSERT INTO "public"."universitas" VALUES (102064, 293002, 'SEKOLAH TINGGI AGAMA BUDDHA DHARMA WIDYA');
INSERT INTO "public"."universitas" VALUES (102065, 293003, 'SEKOLAH TINGGI AGAMA BUDDHA SAMANTABADRA - NSI');
INSERT INTO "public"."universitas" VALUES (102066, 293004, 'SEKOLAH TINGGI AGAMA BUDDHA BODHI DHARMA');
INSERT INTO "public"."universitas" VALUES (102067, 293005, 'SEKOLAH TINGGI ILMU AGAMA BUDDHA JINARAKKHITA');
INSERT INTO "public"."universitas" VALUES (102068, 293006, 'SEKOLAH TINGGI AGAMA BUDDHA MAHA PRAJNA JAKARTA');
INSERT INTO "public"."universitas" VALUES (102069, 293007, 'SEKOLAH TINGGI AGAMA BUDDHA MAITREYAWIRA');
INSERT INTO "public"."universitas" VALUES (102070, 293008, 'SEKOLAH TINGGI AGAMA BUDDHA NALANDA');
INSERT INTO "public"."universitas" VALUES (102071, 293009, 'SEKOLAH TINGGI AGAMA BUDDHA SYAILENDRA');
INSERT INTO "public"."universitas" VALUES (102072, 293010, 'SEKOLAH TINGGI AGAMA BUDDHA DHARMADUTA MAHAYANA TANAH SUCI INDONESIA');
INSERT INTO "public"."universitas" VALUES (102073, 293011, 'SEKOLAH TINGGI ILMU AGAMA BUDDHA SMARATUNGGA');
INSERT INTO "public"."universitas" VALUES (102074, 293012, 'SEKOLAH TINGGI AGAMA BUDDHA KERTARAJASA');
INSERT INTO "public"."universitas" VALUES (102075, 303001, 'SEKOLAH TINGGI METEOROLOGI KLIMATOLOGI DAN GEOFISIKA');
INSERT INTO "public"."universitas" VALUES (102076, 304001, 'AKADEMI METEOROLOGI KLIMATOLOGI DAN GEOFISIKA');
INSERT INTO "public"."universitas" VALUES (102077, 313001, 'SEKOLAH TINGGI PERTANAHAN NASIONAL YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102078, 323001, 'SEKOLAH TINGGI TEKNOLOGI NUKLIR YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102079, 333001, 'SEKOLAH TINGGI ILMU STATISTIK');
INSERT INTO "public"."universitas" VALUES (102080, 335001, 'POLITEKNIK STATISTIKA STIS');
INSERT INTO "public"."universitas" VALUES (102081, 342001, 'INSTITUT PEMERINTAHAN DALAM NEGERI');
INSERT INTO "public"."universitas" VALUES (102082, 344001, 'AKADEMI KEPERAWATAN PEMKAB ACEH UTARA');
INSERT INTO "public"."universitas" VALUES (102083, 344002, 'AKADEMI KEPERAWATAN PEMKAB PIDIE DI SIGLI');
INSERT INTO "public"."universitas" VALUES (102084, 344003, 'AKADEMI KEPERAWATAN PEMKAB ACEH SELATAN');
INSERT INTO "public"."universitas" VALUES (102085, 344004, 'AKADEMI KEPERAWATAN TJOET NYA'' DHIEN BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (102086, 344005, 'AKADEMI KEPERAWATAN PEMKAB ACEH TENGGARA');
INSERT INTO "public"."universitas" VALUES (102087, 344006, 'AKADEMI KEBIDANAN PEMKAB ACEH UTARA LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (102088, 344007, 'AKADEMI KEBIDANAN PEMKAB ACEH TENGAH TAKENGON');
INSERT INTO "public"."universitas" VALUES (102089, 344008, 'AKADEMI ANALIS KESEHATAN PEMERINTAH ACEH');
INSERT INTO "public"."universitas" VALUES (102090, 344009, 'AKADEMI FARMASI NAD');
INSERT INTO "public"."universitas" VALUES (102091, 344010, 'AKADEMI KEPERAWATAN PEMKAB LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (102092, 344011, 'AKADEMI KEPERAWATAN PEMKAB DAIRI');
INSERT INTO "public"."universitas" VALUES (102093, 344012, 'AKADEMI KEPERAWATAN PEMKAB LANGKAT');
INSERT INTO "public"."universitas" VALUES (102094, 344013, 'AKPER PEMKOT TANJUNG BALAI');
INSERT INTO "public"."universitas" VALUES (102095, 344014, 'AKADEMI KEBIDANAN TARUTUNG PEMKAB TAPANULI UTARA');
INSERT INTO "public"."universitas" VALUES (102096, 344015, 'AKADEMI KEBIDANAN PEMKAB KARO KABANJAHE');
INSERT INTO "public"."universitas" VALUES (102097, 344016, 'AKADEMI KEBIDANAN PEMKOT TEBING TINGGI');
INSERT INTO "public"."universitas" VALUES (102098, 344017, 'AKADEMI KEPERAWATAN GUNUNGSITOLI PEMERINTAH KABUPATEN NIAS');
INSERT INTO "public"."universitas" VALUES (102099, 344018, 'AKADEMI KEPERAWATAN PEMKAB ASAHAN KISARAN');
INSERT INTO "public"."universitas" VALUES (102100, 344019, 'AKADEMI KEPERAWATAN PEMKAB TAPANULI TENGAH');
INSERT INTO "public"."universitas" VALUES (102101, 344020, 'AKADEMI KEPERAWATAN PEMKAB PADANG PARIAMAN');
INSERT INTO "public"."universitas" VALUES (102102, 344021, 'AKADEMI KESEHATAN PROVINSI RIAU');
INSERT INTO "public"."universitas" VALUES (102103, 344022, 'AKADEMI ANALIS KESEHATAN PROVINSI JAMBI');
INSERT INTO "public"."universitas" VALUES (102104, 344023, 'AKADEMI FARMASI PROPINSI JAMBI');
INSERT INTO "public"."universitas" VALUES (102105, 344024, 'AKADEMI KEPERAWATAN PEMKAB LAHAT');
INSERT INTO "public"."universitas" VALUES (102106, 344025, 'AKADEMI KEPERAWATAN PEMKAB MUSI BANYUASIN');
INSERT INTO "public"."universitas" VALUES (102107, 344026, 'AKADEMI KEBIDANAN PEMKAB MUARA ENIM');
INSERT INTO "public"."universitas" VALUES (102108, 344027, 'AKADEMI KESEHATAN LINGKUNGAN PEMPROV SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (102109, 344028, 'AKADEMI KEPERAWATAN PEMPROV BENGKULU');
INSERT INTO "public"."universitas" VALUES (102110, 344029, 'AKADEMI KEBIDANAN PEMPROV BENGKULU');
INSERT INTO "public"."universitas" VALUES (102111, 344030, 'AKADEMI KEPERAWATAN JAYAKARTA PROV DKI JAKARTA');
INSERT INTO "public"."universitas" VALUES (102112, 344031, 'AKADEMI KEPERAWATAN PEMKAB SUMEDANG');
INSERT INTO "public"."universitas" VALUES (102113, 344032, 'AKADEMI KEPERAWATAN PEMKAB INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (102114, 344033, 'AKADEMI KEPERAWATAN PEMKAB GARUT');
INSERT INTO "public"."universitas" VALUES (102115, 344034, 'AKADEMI KEPERAWATAN PEMKAB SUBANG');
INSERT INTO "public"."universitas" VALUES (102116, 344035, 'AKADEMI KEPERAWATAN PEMKAB CIANJUR');
INSERT INTO "public"."universitas" VALUES (102117, 344036, 'AKADEMI KEPERAWATAN PEMPROV JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (102118, 344037, 'AKADEMI KEPERAWATAN PEMKOT TEGAL');
INSERT INTO "public"."universitas" VALUES (102119, 344038, 'AKADEMI KEBIDANAN PEMKAB KUDUS');
INSERT INTO "public"."universitas" VALUES (102120, 344039, 'AKADEMI KEBIDANAN PEMKAB KENDAL');
INSERT INTO "public"."universitas" VALUES (102121, 344040, 'AKADEMI KEPERAWATAN PEMKAB PONOROGO');
INSERT INTO "public"."universitas" VALUES (102122, 344041, 'AKADEMI KEPERAWATAN PEMKAB TRENGGALEK');
INSERT INTO "public"."universitas" VALUES (102123, 344042, 'AKADEMI KEPERAWATAN PEMKAB LUMAJANG');
INSERT INTO "public"."universitas" VALUES (102124, 344043, 'AKADEMI KEPERAWATAN PEMKAB LAMONGAN');
INSERT INTO "public"."universitas" VALUES (102125, 344044, 'AKADEMI KEPERAWATAN PEMKAB GRESIK');
INSERT INTO "public"."universitas" VALUES (102126, 344045, 'AKADEMI KEPERAWATAN PEMKAB PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (102127, 344046, 'AKADEMI KEPERAWATAN PEMKOT PASURUAN');
INSERT INTO "public"."universitas" VALUES (102128, 344047, 'AKADEMI KEPERAWATAN DR. SOEDONO MADIUN PROV. JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (99493, 83076, 'STKIP PARACENDEKIA N W SUMBAWA');
INSERT INTO "public"."universitas" VALUES (99494, 83077, 'STKIP SOE');
INSERT INTO "public"."universitas" VALUES (99495, 83078, 'STT HAMZANWADI');
INSERT INTO "public"."universitas" VALUES (99496, 83079, 'STKIP SINAR PANCASILA');
INSERT INTO "public"."universitas" VALUES (99497, 83080, 'STMIK PRIMAKARA');
INSERT INTO "public"."universitas" VALUES (99498, 83081, 'STIKES SANTU PAULUS RUTENG');
INSERT INTO "public"."universitas" VALUES (99499, 83082, 'STKIP WEETEBULA');
INSERT INTO "public"."universitas" VALUES (99500, 83083, 'STKIP CITRA BINA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99501, 83084, 'STKIP NUSA TIMOR');
INSERT INTO "public"."universitas" VALUES (99502, 83085, 'STKIP SIMBIOSIS');
INSERT INTO "public"."universitas" VALUES (99503, 83086, 'STIKES PANCA ATMA JAYA');
INSERT INTO "public"."universitas" VALUES (99504, 83087, 'STKIP MUHAMMADIYAH KALABAHI');
INSERT INTO "public"."universitas" VALUES (99505, 83088, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA KOMPUTER STELLA MARIS SUMBA');
INSERT INTO "public"."universitas" VALUES (99506, 83089, 'SEKOLAH TINGGI ILMU KESEHATAN BULELENG');
INSERT INTO "public"."universitas" VALUES (99507, 83090, 'STIBA BUMI GORA MATARAM');
INSERT INTO "public"."universitas" VALUES (99508, 83091, 'STKIP HARAPAN BIMA');
INSERT INTO "public"."universitas" VALUES (99509, 83092, 'SEKOLAH TINGGI ILMU EKONOMI KARYA');
INSERT INTO "public"."universitas" VALUES (99510, 83093, 'STKIP JEMBRANA');
INSERT INTO "public"."universitas" VALUES (99511, 83094, 'STIKES GRIYA HUSADA SUMBAWA');
INSERT INTO "public"."universitas" VALUES (99512, 83095, 'SEKOLAH TINGGI FARMASI MAHAGANESHA');
INSERT INTO "public"."universitas" VALUES (99513, 83096, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA KOMPUTER MATARAM');
INSERT INTO "public"."universitas" VALUES (99514, 83099, 'SEKOLAH TINGGI PARIWISATA MATARAM');
INSERT INTO "public"."universitas" VALUES (99515, 83101, 'SEKOLAH TINGGI ILMU HUKUM CENDANA WANGI');
INSERT INTO "public"."universitas" VALUES (99516, 83102, 'SEKOLAH TINGGI ILMU HUKUM PROF. DR. YOHANES USFUNAN, SH, MH');
INSERT INTO "public"."universitas" VALUES (99517, 83103, 'SEKOLAH TINGGI PARIWISATA SOROMANDI BIMA');
INSERT INTO "public"."universitas" VALUES (99518, 83104, 'STIKES RANA WIJAYA');
INSERT INTO "public"."universitas" VALUES (99519, 83106, 'SEKOLAH TINGGI BISNIS PUTRA HARAPAN');
INSERT INTO "public"."universitas" VALUES (99520, 83107, 'STIKES KUSUMA BANGSA');
INSERT INTO "public"."universitas" VALUES (99521, 83108, 'SEKOLAH TINGGI ILMU KESEHATAN BALI WISNU DHARMA DENPASAR');
INSERT INTO "public"."universitas" VALUES (99522, 83109, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN SURYA KASIH');
INSERT INTO "public"."universitas" VALUES (99523, 83110, 'SEKOLAH TINGGI ILMU KESEHATAN KESDAM IX/UDAYANA');
INSERT INTO "public"."universitas" VALUES (99524, 83111, 'SEKOLAH TINGGI PERTANIAN FLORES BAJAWA');
INSERT INTO "public"."universitas" VALUES (99525, 84001, 'AKADEMI AKUNTANSI DENPASAR');
INSERT INTO "public"."universitas" VALUES (99526, 84002, 'AKADEMI PARIWISATA DENPASAR');
INSERT INTO "public"."universitas" VALUES (99527, 84003, 'AKADEMI KEUANGAN DAN PERBANKAN DENPASAR');
INSERT INTO "public"."universitas" VALUES (99528, 84010, 'AKADEMI PARIWISATA MATARAM');
INSERT INTO "public"."universitas" VALUES (99529, 84011, 'AKADEMI SEKRETARI DAN MANAJEMEN MATARAM');
INSERT INTO "public"."universitas" VALUES (99530, 84012, 'AKADEMI BAHASA ASING BUMI GORA MATARAM');
INSERT INTO "public"."universitas" VALUES (99531, 84013, 'AKADEMI TEKNIK BIMA');
INSERT INTO "public"."universitas" VALUES (99532, 84014, 'AKADEMI TEKNIK KUPANG');
INSERT INTO "public"."universitas" VALUES (99533, 84018, 'AKADEMI KEUANGAN DAN PERBANKAN EFFATA KUPANG');
INSERT INTO "public"."universitas" VALUES (99534, 84019, 'AKADEMI PEKERJAAN SOSIAL KUPANG');
INSERT INTO "public"."universitas" VALUES (99535, 84020, 'AKADEMI PARIWISATA KUPANG');
INSERT INTO "public"."universitas" VALUES (99536, 84021, 'AKADEMI KOPERASI INDONESIA RATU JELITA');
INSERT INTO "public"."universitas" VALUES (99537, 84022, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER MATARAM');
INSERT INTO "public"."universitas" VALUES (99538, 84023, 'AKADEMI BAHASA ASING SANTA MARY ENDE');
INSERT INTO "public"."universitas" VALUES (99539, 84024, 'AKADEMI KEPERAWATAN SAMAWA');
INSERT INTO "public"."universitas" VALUES (99540, 84025, 'AKADEMI KEPERAWATAN MARANATHA GROUPS');
INSERT INTO "public"."universitas" VALUES (99541, 84026, 'AKADEMI KEBIDANAN KARTINI BALI');
INSERT INTO "public"."universitas" VALUES (99542, 84027, 'AKADEMI KEBIDANAN KESATRIA PRAYA');
INSERT INTO "public"."universitas" VALUES (99543, 84028, 'AKADEMI KEBIDANAN ANUGRAH ABADI');
INSERT INTO "public"."universitas" VALUES (99544, 84029, 'AKADEMI KEBIDANAN HARAPAN BUNDA BIMA');
INSERT INTO "public"."universitas" VALUES (99545, 84030, 'AKADEMI KEBIDANAN BALI WISNU DHARMA');
INSERT INTO "public"."universitas" VALUES (99546, 84031, 'AKADEMI KEBIDANAN BHAKTI KENCANA');
INSERT INTO "public"."universitas" VALUES (99547, 84033, 'AKADEMI KEPERAWATAN MANDIRI');
INSERT INTO "public"."universitas" VALUES (99548, 84034, 'AKTEK RADIODIAGNOSTIK DAN RADIOTERAPI BALI');
INSERT INTO "public"."universitas" VALUES (99549, 84035, 'AKADEMI KEBIDANAN SURYA MANDIRI KOTA BIMA');
INSERT INTO "public"."universitas" VALUES (99550, 84036, 'AKADEMI KESEHATAN GIGI KARYA ADI HUSADA MATARAM');
INSERT INTO "public"."universitas" VALUES (99551, 84037, 'AMIK NEW MEDIA');
INSERT INTO "public"."universitas" VALUES (99552, 84038, 'AKADEMI BAHASA ASING NEW MEDIA');
INSERT INTO "public"."universitas" VALUES (99553, 84039, 'AKADEMI KEPERAWATAN KESDAM IX/UDAYANA');
INSERT INTO "public"."universitas" VALUES (99554, 84040, 'AKADEMI FARMASI SARASWATI DENPASAR');
INSERT INTO "public"."universitas" VALUES (99555, 84041, 'AKADEMI KEPERAWATAN ST ELISABETH LELA');
INSERT INTO "public"."universitas" VALUES (99556, 84042, 'AKADEMI KEBIDANAN SANTA ELISABETH KEFAMENANU');
INSERT INTO "public"."universitas" VALUES (99557, 84043, 'AKADEMI FARMASI SANTO FRANSISKUS XAVERIUS');
INSERT INTO "public"."universitas" VALUES (99558, 84044, 'AKADEMI ADMINISTRASI RUMAH SAKIT MATARAM');
INSERT INTO "public"."universitas" VALUES (99559, 84045, 'AKADEMI KESEHATAN BINTANG PERSADA');
INSERT INTO "public"."universitas" VALUES (99560, 84046, 'AKADEMI ILMU PELAYARAN NUSA TENGGARA SELONG');
INSERT INTO "public"."universitas" VALUES (99561, 85001, 'POLITEKNIK NASIONAL');
INSERT INTO "public"."universitas" VALUES (99562, 85002, 'POLITEKNIK ST WILHELMUS');
INSERT INTO "public"."universitas" VALUES (99563, 85003, 'POLITEKNIK GANESHA GURU');
INSERT INTO "public"."universitas" VALUES (99564, 85004, 'POLITEKNIK WIDYA DHARMA BALI');
INSERT INTO "public"."universitas" VALUES (99565, 85005, 'POLITEKNIK MEDICA FARMA HUSADA MATARAM');
INSERT INTO "public"."universitas" VALUES (99566, 85006, 'POLITEKNIK INTERNASIONAL BALI');
INSERT INTO "public"."universitas" VALUES (99567, 85007, 'POLITEKNIK ELBAJO COMMODUS');
INSERT INTO "public"."universitas" VALUES (99568, 85008, 'POLITEKNIK KESEHATAN KARTINI BALI');
INSERT INTO "public"."universitas" VALUES (99569, 85009, 'POLITEKNIK CRISTO RE');
INSERT INTO "public"."universitas" VALUES (99570, 86001, 'AKADEMI KOMUNITAS MANAJEMEN PERHOTELAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99571, 86002, 'AKADEMI KOMUNITAS OLAT MARAS');
INSERT INTO "public"."universitas" VALUES (99572, 91001, 'UNIVERSITAS VETERAN REPUBLIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (99573, 91002, 'UNIVERSITAS MUSLIM INDONESIA');
INSERT INTO "public"."universitas" VALUES (99574, 91003, 'UNIVERSITAS KRISTEN INDONESIA PAULUS');
INSERT INTO "public"."universitas" VALUES (99575, 91004, 'UNIVERSITAS MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99576, 91005, 'UNIVERSITAS KRISTEN INDONESIA TOMOHON');
INSERT INTO "public"."universitas" VALUES (99577, 91006, 'UNIVERSITAS DAYANU IKHSANUDDIN');
INSERT INTO "public"."universitas" VALUES (99578, 91007, 'UNIVERSITAS KLABAT');
INSERT INTO "public"."universitas" VALUES (99579, 91008, 'UNIVERSITAS PEPABRI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99580, 91009, 'UNIVERSITAS ATMA JAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99581, 91010, 'UNIVERSITAS 45 MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99582, 91011, 'UNIVERSITAS MUHAMMADIYAH PALU');
INSERT INTO "public"."universitas" VALUES (99583, 91012, 'UNIVERSITAS SINTUWU MAROSO POSO');
INSERT INTO "public"."universitas" VALUES (100899, 212046, 'INSTITUT AGAMA ISLAM (IAI) AL-KHOZINY');
INSERT INTO "public"."universitas" VALUES (100900, 212047, 'INSTITUT AGAMA ISLAM SULTAN MUHAMMAD SYAFIUDDIN SAMBAS');
INSERT INTO "public"."universitas" VALUES (100901, 212048, 'INSTITUT AGAMA ISLAM DARUSSALAM BLOKAGUNG BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (100902, 212049, 'INSTITUT SAINS AL-QUR''AN SYEKH IBRAHIM PASIR PANGARAIAN ROKAN HULU');
INSERT INTO "public"."universitas" VALUES (100903, 212050, 'INSTITUT PESANTREN KH. ABDUL CHALIM PACET MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (100904, 212051, 'INSTITUT ILMU KEISLAMAN ZAINUL HASAN GENGGONG');
INSERT INTO "public"."universitas" VALUES (100905, 212052, 'INSTITUT PESANTREN SUNAN DRAJAT LAMONGAN');
INSERT INTO "public"."universitas" VALUES (100906, 212053, 'INSTITUT AGAMA ISLAM ULUWIYAH MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (100907, 212054, 'INSTITUT AGAMA ISLAM MUHAMMADIYAH BIMA');
INSERT INTO "public"."universitas" VALUES (100908, 212055, 'INSTITUT AGAMA ISLAM IBRAHIMY GENTENG BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (100909, 212056, 'INSTITUT AGAMA ISLAM BUNGA BANGSA CIREBON');
INSERT INTO "public"."universitas" VALUES (100910, 212057, 'INSTITUT AGAMA ISLAM SAHID');
INSERT INTO "public"."universitas" VALUES (100911, 212058, 'INSTITUT PESANTREN MATHALIUL FALAH PATI JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (100912, 212059, 'INSTITUT AGAMA ISLAM MUHAMMADIYAH SINJAI');
INSERT INTO "public"."universitas" VALUES (100913, 212060, 'INSTITUT ISLAM MAMBAUL ULUM SURAKARTA');
INSERT INTO "public"."universitas" VALUES (100914, 212061, 'INSTITUT AGAMA ISLAM NGAWI JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (100915, 212062, 'INSTITUT PARAHIKMA INDONESIA, GOWA SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (100916, 212063, 'INSTITUT AGAMA ISLAM AZMI KOTAMOBAGU SULAWESI UTARA');
INSERT INTO "public"."universitas" VALUES (100917, 212064, 'INSTITUT AGAMA ISLAM TARBIYATUT THOLABAH LAMONGAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (100918, 212066, 'INSTITUT AGAMA ISLAM NASIONAL LAA ROIBA BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (100919, 212067, 'INSTITUT AGAMA ISLAM MUHAMMADIYAH KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (100920, 212068, 'INSTITUT AGAMA ISLAM PELALAWAN RIAU');
INSERT INTO "public"."universitas" VALUES (100921, 212069, 'INSTITUT ILMU AL QUR''AN AN-NUR YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (100922, 212070, 'INSTITUT AGAMA ISLAM SUKABUMI');
INSERT INTO "public"."universitas" VALUES (100923, 212071, 'INSTITUT AGAMA ISLAM AS''ADIYAH SENGKANG');
INSERT INTO "public"."universitas" VALUES (100924, 212072, 'INSTITUT AGAMA ISLAM DARUSSALAM MARTAPURA KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (100925, 212073, 'INSTITUT AGAMA ISLAM AN NUR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (100926, 212074, 'INSTITUT AGAMA ISLAM SUNAN KALIJOGO MALANG JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (100927, 212075, 'INSTITUT AGAMA ISLAM AL-FALAH AS-SUNNIYAH KENCONG JEMBER JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (100928, 212076, 'INSTITUT AGAMA ISLAM AL-KHAIRAT PAMEKASAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (100929, 212077, 'INSTITUT AGAMA ISLAM ABDULLAH SAID BATAM');
INSERT INTO "public"."universitas" VALUES (100930, 212078, 'INSTITUT AGAMA ISLAM BAKTI NEGARA TEGAL');
INSERT INTO "public"."universitas" VALUES (100931, 212079, 'INSTITUT AGAMA ISLAM SUMBAR');
INSERT INTO "public"."universitas" VALUES (100932, 212080, 'SEKOLAH TINGGI ILMU TARBIYAH ASSA''IDIYYAH CIPANAS CIANJUR');
INSERT INTO "public"."universitas" VALUES (100933, 212081, 'INSTITUT AGAMA ISLAM KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (100934, 212082, 'INSTITUT AGAMA ISLAM WIDYA DHARMA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (100935, 212083, 'INSTITUT AGAMA ISLAM FAQIH ASY''ARI KEDIRI');
INSERT INTO "public"."universitas" VALUES (100936, 212084, 'INSTITUT AGAMA ISLAM AL-QODIRI JEMBER');
INSERT INTO "public"."universitas" VALUES (100937, 212085, 'INSTITUT AGAMA ISLAM TAZKIA');
INSERT INTO "public"."universitas" VALUES (100938, 212086, 'INSTITUT AGAMA ISLAM NAHDLATUL ULAMA TUBAN');
INSERT INTO "public"."universitas" VALUES (100939, 212087, 'INSTITUT AGAMA ISLAM NUSANTARA BATANG HARI');
INSERT INTO "public"."universitas" VALUES (100940, 212088, 'INSTITUT AGAMA ISLAM YASNI BUNGO');
INSERT INTO "public"."universitas" VALUES (100941, 212089, 'INSTITUT DAARUL QUR''AN JAKARTA');
INSERT INTO "public"."universitas" VALUES (100942, 212090, 'INSTITUT STUDI ISLAM SUNAN DOE');
INSERT INTO "public"."universitas" VALUES (100943, 212091, 'INSTITUT AGAMA ISLAM CIREBON');
INSERT INTO "public"."universitas" VALUES (100944, 212092, 'INSTITUT AGAMA ISLAM AR-RISALAH INHIL RIAU');
INSERT INTO "public"."universitas" VALUES (100945, 212093, 'INSTITUT AGAMA ISLAM AL-HIKMAH TUBAN');
INSERT INTO "public"."universitas" VALUES (100946, 212094, 'INSTITUT ISLAM STUDIES MUHAMMADIYAH PACITAN');
INSERT INTO "public"."universitas" VALUES (100947, 212095, 'INSTITUT ELKATARI');
INSERT INTO "public"."universitas" VALUES (100948, 212096, 'INSTITUT KARIMAN WIRAYUDHA SUMENEP MADURA');
INSERT INTO "public"."universitas" VALUES (100949, 212097, 'INSTITUT AGAMA ISLAM TEBO');
INSERT INTO "public"."universitas" VALUES (100950, 213001, 'STAI AL-AZIZIYAH SAMALANGA BIREUN NAD');
INSERT INTO "public"."universitas" VALUES (100951, 213003, 'STAI DARUL HIKMAH ACEH BARAT');
INSERT INTO "public"."universitas" VALUES (100952, 213004, 'STAI TAPAKTUAN ACEH SELATAN');
INSERT INTO "public"."universitas" VALUES (100953, 213005, 'STIT MUHAMMADIYAH ACEH BARAT DAYA');
INSERT INTO "public"."universitas" VALUES (100954, 213006, 'STAI DENPASAR BALI');
INSERT INTO "public"."universitas" VALUES (100955, 213007, 'STAI ISTIQLAL BULELENG BALI');
INSERT INTO "public"."universitas" VALUES (100956, 213008, 'STES ISLAMIC VILLAGE TANGERANG');
INSERT INTO "public"."universitas" VALUES (100957, 213009, 'STAI NURUL HIDAYAH LEBAK BANTEN');
INSERT INTO "public"."universitas" VALUES (100958, 213010, 'STIT AL-AMIN KREO TANGERANG');
INSERT INTO "public"."universitas" VALUES (100959, 213011, 'STIT DARUL FATAH TANGERANG BANTEN');
INSERT INTO "public"."universitas" VALUES (100960, 213012, 'STAI MIFTAHUL ULUM MUKOMUKO');
INSERT INTO "public"."universitas" VALUES (100961, 213013, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM AL-MUHSIN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (100962, 213014, 'STAI TERPADU YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (100963, 213015, 'STEI TIARA RAWAMANGUN');
INSERT INTO "public"."universitas" VALUES (100964, 213016, 'STAI ACPRILESMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100965, 213017, 'STAI AHSANTA JAMBI');
INSERT INTO "public"."universitas" VALUES (100966, 213018, 'STAI AL-ANWAR KUALA TUNGKAL JAMBI');
INSERT INTO "public"."universitas" VALUES (100967, 213019, 'STAI MA`ARIF SAROLANGUN');
INSERT INTO "public"."universitas" VALUES (100968, 213020, 'STAI MAU`IZHAH TANJUNG JABUNG BARAT');
INSERT INTO "public"."universitas" VALUES (100969, 213021, 'STAI BHAKTI PERSADA MAJALAYA BANDUNG');
INSERT INTO "public"."universitas" VALUES (100970, 213022, 'STIES INDONESIA PURWAKARTA, JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (100971, 213023, 'STAI DUTA BANGSA BEKASI');
INSERT INTO "public"."universitas" VALUES (100972, 213024, 'STAI IMAM SYAFI`I CIANJUR');
INSERT INTO "public"."universitas" VALUES (100973, 213025, 'STAI MUHAMMADIYAH GARUT');
INSERT INTO "public"."universitas" VALUES (100974, 213026, 'STAI NAHDLATUL ULAMA (STAINU) TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (100975, 213027, 'STAI NURUL IMAN PARUNG, BOGOR');
INSERT INTO "public"."universitas" VALUES (100976, 213028, 'STAI TERPADU MODERN SAHID BOGOR');
INSERT INTO "public"."universitas" VALUES (100977, 213029, 'STAI AL-MA`ARIF CIAMIS');
INSERT INTO "public"."universitas" VALUES (100978, 213030, 'STID AL-BIRUNI BABAKAN CIWARINGIN');
INSERT INTO "public"."universitas" VALUES (102129, 344048, 'AKADEMI KEBIDANAN PEMKAB BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (102130, 344049, 'AKADEMI GIZI SURABAYA');
INSERT INTO "public"."universitas" VALUES (102131, 344050, 'AKADEMI KEBIDANAN PEMPROV BALI SINGARAJA');
INSERT INTO "public"."universitas" VALUES (102132, 344051, 'AKADEMI PERAWAT KESEHATAN PROVINSI NTB');
INSERT INTO "public"."universitas" VALUES (102133, 344052, 'AKADEMI KEPERAWATAN PEMKAB BELU');
INSERT INTO "public"."universitas" VALUES (102134, 344053, 'AKADEMI KEPERAWATAN WAIKABUBAK PEMDA SUMBA BARAT');
INSERT INTO "public"."universitas" VALUES (102135, 344054, 'AKADEMI KEPERAWATAN PEMPROV KALBAR DI SINTANG');
INSERT INTO "public"."universitas" VALUES (102136, 344055, 'AKADEMI KEPERAWATAN PEMKAB KETAPANG');
INSERT INTO "public"."universitas" VALUES (102137, 344056, 'AKADEMI KEPERAWATAN PEMKAB KAPUAS');
INSERT INTO "public"."universitas" VALUES (102138, 344057, 'AKADEMI KEPERAWATAN MURAKATA BARABAI');
INSERT INTO "public"."universitas" VALUES (102139, 344058, 'AKADEMI KEPERAWATAN PEMPROV KALTIM');
INSERT INTO "public"."universitas" VALUES (102140, 344059, 'AKADEMI KEPERAWATAN PEMKAB BULUKUMBA');
INSERT INTO "public"."universitas" VALUES (102141, 344060, 'AKADEMI KEPERAWATAN PEMKAB WAJO PROV. SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (102142, 344061, 'AKADEMI KEPERAWATAN ANGING MAMMIRI PEMPROV SULSEL');
INSERT INTO "public"."universitas" VALUES (102143, 344062, 'AKADEMI KEPERAWATAN PEMKAB BUTON');
INSERT INTO "public"."universitas" VALUES (102144, 344063, 'AKADEMI KEPERAWATAN PEMKAB KOLAKA');
INSERT INTO "public"."universitas" VALUES (102145, 344064, 'AKADEMI KEPERAWATAN PEMKAB MUNA');
INSERT INTO "public"."universitas" VALUES (102146, 344065, 'AKADEMI KEPERAWATAN PEMKAB KONAWE');
INSERT INTO "public"."universitas" VALUES (102147, 344066, 'AKADEMI KEPERAWATAN PEMKAB DONGGALA');
INSERT INTO "public"."universitas" VALUES (102148, 344067, 'AKADEMI KEPERAWATAN LUWUK');
INSERT INTO "public"."universitas" VALUES (102149, 344068, 'AKADEMI KEPERAWATAN PEMDA TOLI-TOLI');
INSERT INTO "public"."universitas" VALUES (102150, 344069, 'AKADEMI KEPERAWATAN PEMKAB BELITUNG');
INSERT INTO "public"."universitas" VALUES (102151, 344070, 'AKADEMI KEPERAWATAN PEMDA KABUPATEN SERANG');
INSERT INTO "public"."universitas" VALUES (102152, 344071, 'AKADEMI KEPERAWATAN PEMKAB KOTAWARINGIN TIMUR KALTENG');
INSERT INTO "public"."universitas" VALUES (102153, 345001, 'POLITEKNIK KESEHATAN PROVINSI BENGKULU');
INSERT INTO "public"."universitas" VALUES (102154, 353001, 'SEKOLAH TINGGI ENERGI DAN MINERAL');
INSERT INTO "public"."universitas" VALUES (102155, 354001, 'AKADEMI MINYAK DAN GAS BUMI (STEM)');
INSERT INTO "public"."universitas" VALUES (102156, 355001, 'POLITEKNIK ENERGI DAN MINERAL AKAMIGAS');
INSERT INTO "public"."universitas" VALUES (102157, 355002, 'POLITEKNIK ENERGI DAN PERTAMBANGAN BANDUNG');
INSERT INTO "public"."universitas" VALUES (102158, 364001, 'AKADEMI ILMU PEMASYARAKATAN');
INSERT INTO "public"."universitas" VALUES (102159, 365001, 'POLITEKNIK ILMU PEMASYARAKATAN');
INSERT INTO "public"."universitas" VALUES (102160, 365002, 'POLITEKNIK IMIGRASI');
INSERT INTO "public"."universitas" VALUES (102161, 373001, 'SEKOLAH TINGGI MULTI MEDIA "MMTC" YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102162, 383001, 'SEKOLAH TINGGI PARIWISATA NUSA DUA BALI');
INSERT INTO "public"."universitas" VALUES (102163, 383002, 'SEKOLAH TINGGI PARIWISATA BANDUNG');
INSERT INTO "public"."universitas" VALUES (102164, 383003, 'AKADEMI PARIWISATA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102165, 383004, 'AKADEMI PARIWISATA MEDAN');
INSERT INTO "public"."universitas" VALUES (102166, 385001, 'POLITEKNIK PARIWISATA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102167, 385002, 'POLITEKNIK PARIWISATA MEDAN');
INSERT INTO "public"."universitas" VALUES (102168, 385003, 'POLITEKNIK PARIWISATA LOMBOK');
INSERT INTO "public"."universitas" VALUES (102169, 385004, 'POLITEKNIK PARIWISATA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (102170, 385005, 'POLITEKNIK PARIWISATA BALI');
INSERT INTO "public"."universitas" VALUES (102171, 393001, 'SEKOLAH TINGGI PERIKANAN');
INSERT INTO "public"."universitas" VALUES (102172, 394002, 'AKADEMI PERIKANAN BITUNG');
INSERT INTO "public"."universitas" VALUES (102173, 394003, 'AKADEMI PERIKANAN SIDOARJO');
INSERT INTO "public"."universitas" VALUES (102174, 394004, 'AKADEMI PERIKANAN SORONG');
INSERT INTO "public"."universitas" VALUES (102175, 395001, 'POLITEKNIK KELAUTAN DAN PERIKANAN SORONG');
INSERT INTO "public"."universitas" VALUES (102176, 395002, 'POLITEKNIK KELAUTAN DAN PERIKANAN BITUNG');
INSERT INTO "public"."universitas" VALUES (102177, 395003, 'POLITEKNIK KELAUTAN DAN PERIKANAN SIDOARJO');
INSERT INTO "public"."universitas" VALUES (102178, 395004, 'POLITEKNIK KELAUTAN DAN PERIKANAN KARAWANG');
INSERT INTO "public"."universitas" VALUES (102179, 395005, 'POLITEKNIK KELAUTAN DAN PERIKANAN BONE');
INSERT INTO "public"."universitas" VALUES (102180, 395006, 'POLITEKNIK KELAUTAN DAN PERIKANAN KUPANG');
INSERT INTO "public"."universitas" VALUES (102181, 395007, 'POLITEKNIK KELAUTAN DAN PERIKANAN DUMAI');
INSERT INTO "public"."universitas" VALUES (102182, 395008, 'POLITEKNIK KELAUTAN DAN PERIKANAN PANGANDARAN');
INSERT INTO "public"."universitas" VALUES (102183, 395009, 'POLITEKNIK KELAUTAN DAN PERIKANAN JEMBRANA');
INSERT INTO "public"."universitas" VALUES (102184, 395010, 'POLITEKNIK AHLI USAHA PERIKANAN');
INSERT INTO "public"."universitas" VALUES (102185, 396001, 'AKADEMI KOMUNITAS KELAUTAN DAN PERIKANAN WAKATOBI');
INSERT INTO "public"."universitas" VALUES (102186, 405001, 'POLTEKKES KEMENKES ACEH');
INSERT INTO "public"."universitas" VALUES (102187, 405002, 'POLTEKKES KEMENKES MEDAN');
INSERT INTO "public"."universitas" VALUES (102188, 405003, 'POLTEKKES KEMENKES RIAU');
INSERT INTO "public"."universitas" VALUES (102189, 405004, 'POLTEKKES KEMENKES PADANG');
INSERT INTO "public"."universitas" VALUES (102190, 405005, 'POLTEKKES KEMENKES JAMBI');
INSERT INTO "public"."universitas" VALUES (102191, 405006, 'POLTEKKES KEMENKES BENGKULU');
INSERT INTO "public"."universitas" VALUES (102192, 405007, 'POLTEKKES KEMENKES PALEMBANG');
INSERT INTO "public"."universitas" VALUES (102193, 405008, 'POLTEKKES KEMENKES JAKARTA I');
INSERT INTO "public"."universitas" VALUES (102194, 405009, 'POLTEKKES KEMENKES JAKARTA II');
INSERT INTO "public"."universitas" VALUES (102195, 405010, 'POLTEKKES KEMENKES JAKARTA III');
INSERT INTO "public"."universitas" VALUES (102196, 405011, 'POLTEKKES KEMENKES BANDUNG');
INSERT INTO "public"."universitas" VALUES (102197, 405012, 'POLTEKKES KEMENKES TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (102198, 405013, 'POLTEKKES KEMENKES SEMARANG');
INSERT INTO "public"."universitas" VALUES (102199, 405014, 'POLTEKKES KEMENKES SURAKARTA');
INSERT INTO "public"."universitas" VALUES (102200, 405015, 'POLTEKKES KEMENKES YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102201, 405016, 'POLTEKKES KEMENKES SURABAYA');
INSERT INTO "public"."universitas" VALUES (102202, 405017, 'POLTEKKES KEMENKES MALANG');
INSERT INTO "public"."universitas" VALUES (102203, 405018, 'POLTEKKES KEMENKES DENPASAR');
INSERT INTO "public"."universitas" VALUES (102204, 405019, 'POLTEKKES KEMENKES MATARAM');
INSERT INTO "public"."universitas" VALUES (102205, 405020, 'POLTEKKES KEMENKES KUPANG');
INSERT INTO "public"."universitas" VALUES (102206, 405021, 'POLTEKKES KEMENKES PONTIANAK');
INSERT INTO "public"."universitas" VALUES (102207, 405022, 'POLTEKKES KEMENKES BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (102208, 405023, 'POLTEKKES KEMENKES PALANGKARAYA');
INSERT INTO "public"."universitas" VALUES (102209, 405024, 'POLTEKKES KEMENKES KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (102210, 405025, 'POLTEKKES KEMENKES MANADO');
INSERT INTO "public"."universitas" VALUES (102211, 405026, 'POLTEKKES KEMENKES PALU');
INSERT INTO "public"."universitas" VALUES (102212, 405028, 'POLTEKKES KEMENKES KENDARI');
INSERT INTO "public"."universitas" VALUES (102213, 405029, 'POLTEKKES KEMENKES MALUKU');
INSERT INTO "public"."universitas" VALUES (102214, 405030, 'POLTEKKES KEMENKES TERNATE');
INSERT INTO "public"."universitas" VALUES (102215, 405031, 'POLTEKKES KEMENKES JAYAPURA');
INSERT INTO "public"."universitas" VALUES (102216, 405032, 'POLTEKKES KEMENKES GORONTALO');
INSERT INTO "public"."universitas" VALUES (102217, 405033, 'POLTEKKES KEMENKES BANTEN');
INSERT INTO "public"."universitas" VALUES (102218, 405034, 'POLTEKKES KEMENKES TANJUNG KARANG');
INSERT INTO "public"."universitas" VALUES (98162, 43265, 'SEKOLAH TINGGI ILMU KESEHATAN CIKARANG');
INSERT INTO "public"."universitas" VALUES (98163, 43266, 'SEKOLAH TINGGI ILMU EKONOMI BANTEN');
INSERT INTO "public"."universitas" VALUES (98164, 43268, 'STMIK DHARMA NEGARA');
INSERT INTO "public"."universitas" VALUES (98165, 43269, 'STIE DHARMA NEGARA');
INSERT INTO "public"."universitas" VALUES (98166, 43270, 'STIKES WIJAYA HUSADA BOGOR');
INSERT INTO "public"."universitas" VALUES (98167, 43271, 'SEKOLAH TINGGI FARMASI MUHAMMADIYAH TANGERANG');
INSERT INTO "public"."universitas" VALUES (98168, 43272, 'SEKOLAH TINGGI BAHASA ASING BINA DINAMIKA CIANJUR');
INSERT INTO "public"."universitas" VALUES (98169, 43273, 'SEKOLAH TINGGI ILMU EKONOMI GICI');
INSERT INTO "public"."universitas" VALUES (98170, 43274, 'SEKOLAH TINGGI BAHASA ASING BUDDHI');
INSERT INTO "public"."universitas" VALUES (98171, 43275, 'SEKOLAH TINGGI ILMU EKONOMI KRIDATAMA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98172, 43276, 'SEKOLAH TINGGI ILMU KESEHATAN YATSI');
INSERT INTO "public"."universitas" VALUES (98173, 43277, 'STIKES MUHAMMADIYAH CIAMIS');
INSERT INTO "public"."universitas" VALUES (98174, 43278, 'SEKOLAH TINGGI ILMU KOMPUTER AL-KHAIRIYAH');
INSERT INTO "public"."universitas" VALUES (98175, 43279, 'SEKOLAH TINGGI ILMU KESEHATAN MITRA KENCANA');
INSERT INTO "public"."universitas" VALUES (98176, 43280, 'STIKES SEBELAS APRIL SUMEDANG');
INSERT INTO "public"."universitas" VALUES (98177, 43282, 'STIKES WIDYA DHARMA HUSADA TANGERANG');
INSERT INTO "public"."universitas" VALUES (98178, 43283, 'STMIK BINA SARANA GLOBAL');
INSERT INTO "public"."universitas" VALUES (98179, 43284, 'SEKOLAH TINGGI ILMU KESEHATAN BUDHI LUHUR CIMAHI');
INSERT INTO "public"."universitas" VALUES (98180, 43285, 'SEKOLAH TINGGI BAHASA ASING CIREBON');
INSERT INTO "public"."universitas" VALUES (98181, 43286, 'SEKOLAH TINGGI ILMU KESEHATAN SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98182, 43288, 'SEKOLAH TINGGI ILMU KESEHATAN KUNINGAN');
INSERT INTO "public"."universitas" VALUES (98183, 43289, 'STKIP BANTEN');
INSERT INTO "public"."universitas" VALUES (98184, 43290, 'SEKOLAH TINGGI TEKNOLOGI DUTA BANGSA');
INSERT INTO "public"."universitas" VALUES (98185, 43291, 'STMIK WIT CIREBON');
INSERT INTO "public"."universitas" VALUES (98186, 43292, 'STIKES FAATHIR HUSADA');
INSERT INTO "public"."universitas" VALUES (98187, 43293, 'SEKOLAH TINGGI TEKNOLOGI MUHAMMADIYAH KARAWANG');
INSERT INTO "public"."universitas" VALUES (98188, 43295, 'SEKOLAH TINGGI ILMU KESEHATAN BANI SALEH');
INSERT INTO "public"."universitas" VALUES (98189, 43296, 'SEKOLAH TINGGI ILMU EKONOMI HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (98190, 43297, 'STMIK NUSA MANDIRI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98191, 43298, 'STIKES KARSA HUSADA GARUT');
INSERT INTO "public"."universitas" VALUES (98192, 43300, 'SEKOLAH TINGGI ILMU BAHASA ASING NUSA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98193, 43301, 'SEKOLAH TINGGI ILMU KESEHATAN SANTO BORROMEUS');
INSERT INTO "public"."universitas" VALUES (98194, 43302, 'SEKOLAH TINGGI TEKNOLOGI NUSA PUTRA');
INSERT INTO "public"."universitas" VALUES (98195, 43304, 'SEKOLAH TINGGI ILMU EKONOMI BINA BANGSA');
INSERT INTO "public"."universitas" VALUES (98196, 43305, 'STMIK PASIM SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98197, 43306, 'STIE PASIM SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98198, 43307, 'SEKOLAH TINGGI ILMU KESEHATAN RAJAWALI');
INSERT INTO "public"."universitas" VALUES (98199, 43308, 'SEKOLAH TINGGI ILMU EKONOMI PRIMA GRAHA');
INSERT INTO "public"."universitas" VALUES (98200, 43309, 'STMIK MUHAMMADIYAH BANTEN');
INSERT INTO "public"."universitas" VALUES (98201, 43310, 'SEKOLAH TINGGI ILMU EKONOMI HIDAYATULLAH DEPOK');
INSERT INTO "public"."universitas" VALUES (98202, 43311, 'STMIK ANTAR BANGSA');
INSERT INTO "public"."universitas" VALUES (98203, 43312, 'SEKOLAH TINGGI BAHASA ASING IEC BEKASI');
INSERT INTO "public"."universitas" VALUES (98204, 43313, 'STIKES KHARISMA KARAWANG');
INSERT INTO "public"."universitas" VALUES (98205, 43314, 'STIKES ICHSAN MEDICAL CENTRE BINTARO');
INSERT INTO "public"."universitas" VALUES (98206, 43315, 'SEKOLAH TINGGI ILMU KEPERAWATAN PPNI JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (98207, 43316, 'SEKOLAH TINGGI ILMU EKONOMI DWIMULYA');
INSERT INTO "public"."universitas" VALUES (98208, 43317, 'SEKOLAH TINGGI ANALIS BAKTI ASIH');
INSERT INTO "public"."universitas" VALUES (98209, 43318, 'STIEB PERDANA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98210, 43319, 'SEKOLAH TINGGI PARIWISATA BOGOR');
INSERT INTO "public"."universitas" VALUES (98211, 43320, 'STKIP PANCA SAKTI BEKASI');
INSERT INTO "public"."universitas" VALUES (98212, 43321, 'STKIP SURYA');
INSERT INTO "public"."universitas" VALUES (98213, 43322, 'STKIP MUHAMMADIYAH BOGOR');
INSERT INTO "public"."universitas" VALUES (98214, 43323, 'STKIP MUHAMMADIYAH KUNINGAN');
INSERT INTO "public"."universitas" VALUES (98215, 43324, 'STISI TELKOM');
INSERT INTO "public"."universitas" VALUES (98216, 43325, 'SEKOLAH TINGGI TEKNOLOGI YBS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98217, 43326, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN BINA MUTIARA');
INSERT INTO "public"."universitas" VALUES (98218, 43327, 'STISIP GUNA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98219, 43328, 'STIKES BINA PERMATA MEDIKA');
INSERT INTO "public"."universitas" VALUES (98220, 43329, 'SEKOLAH TINGGI ILMU HUKUM PAINAN');
INSERT INTO "public"."universitas" VALUES (98221, 43330, 'SEKOLAH TINGGI ILMU KESEHATAN ''AISYIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (98222, 43331, 'SEKOLAH TINGGI TEKNOLOGI TERPADU NURUL FIKRI');
INSERT INTO "public"."universitas" VALUES (98223, 43332, 'SEKOLAH TINGGI ILMU KESEHATAN HOLISTIK');
INSERT INTO "public"."universitas" VALUES (98224, 43333, 'STKIP MUTIARA BANTEN');
INSERT INTO "public"."universitas" VALUES (98225, 43334, 'STKIP NAHDLATUL ULAMA INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98226, 43335, 'STKIP PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (98227, 43336, 'STKIP PANGERAN DHARMA KUSUMA SEGERAN JUNTINYUAT INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98228, 43337, 'SEKOLAH TINGGI MANAJEMEN LOGISTIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (98229, 43338, 'STKIP ARASTAMAR DI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98230, 43339, 'STKIP SITUS BANTEN DI SERANG');
INSERT INTO "public"."universitas" VALUES (98231, 43340, 'STKIP PANCAKARYA');
INSERT INTO "public"."universitas" VALUES (98232, 43341, 'STISIP TRIMASDA CILEGON');
INSERT INTO "public"."universitas" VALUES (98233, 43342, 'STIE ISM');
INSERT INTO "public"."universitas" VALUES (98234, 43343, 'STKIP PELITA PRATAMA');
INSERT INTO "public"."universitas" VALUES (98235, 43344, 'STKIP SYEKH MANSHUR');
INSERT INTO "public"."universitas" VALUES (98236, 43345, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN INVADA CIREBON');
INSERT INTO "public"."universitas" VALUES (98237, 43346, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN AL-AMIN INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98238, 43347, 'STIKES AN NASHER CIREBON');
INSERT INTO "public"."universitas" VALUES (98239, 43348, 'STIKES PRIMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98240, 43349, 'SEKOLAH TINGGI ILMU EKONOMI EKADHARMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98241, 43350, 'STKIP BABUNNAJAH PANDEGLANG');
INSERT INTO "public"."universitas" VALUES (98242, 43351, 'STIKES RAFLESIA');
INSERT INTO "public"."universitas" VALUES (98243, 43352, 'SEKOLAH TINGGI TEKNOLOGI KREATIF BINA NUSANTARA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98244, 43353, 'SEKOLAH TINGGI ILMU HUKUM BINA BANGSA');
INSERT INTO "public"."universitas" VALUES (98245, 43354, 'STKIP SERA');
INSERT INTO "public"."universitas" VALUES (98246, 43355, 'SEKOLAH TINGGI FARMASI MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (98247, 43356, 'STIKES MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (98248, 43357, 'SEKOLAH TINGGI KOMPUTER AL MA SOEM');
INSERT INTO "public"."universitas" VALUES (98249, 43358, 'SEKOLAH TINGGI ILMU KESEHATAN SALSABILA SERANG');
INSERT INTO "public"."universitas" VALUES (98250, 43359, 'SEKOLAH TINGGI ILMU KOMPUTER EL RAHMA');
INSERT INTO "public"."universitas" VALUES (98251, 43360, 'STKIP SINAR CENDEKIA');
INSERT INTO "public"."universitas" VALUES (99584, 91013, 'UNIVERSITAS SAWERIGADING MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99585, 91014, 'UNIVERSITAS DUMOGA KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (99586, 91015, 'UNIVERSITAS SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (99587, 91016, 'UNIVERSITAS SATRIA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99588, 91017, 'UNIVERSITAS PANCASAKTI');
INSERT INTO "public"."universitas" VALUES (99589, 91018, 'UNIVERSITAS ALKHAIRAAT');
INSERT INTO "public"."universitas" VALUES (99590, 91019, 'UNIVERSITAS COKROAMINOTO MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99591, 91020, 'UNIVERSITAS KRISTEN INDONESIA TORAJA');
INSERT INTO "public"."universitas" VALUES (99592, 91021, 'UNIVERSITAS LAKIDENDE UNAAHA');
INSERT INTO "public"."universitas" VALUES (99593, 91022, 'UNIVERSITAS NUSANTARA MANADO');
INSERT INTO "public"."universitas" VALUES (99594, 91023, 'UNIVERSITAS ANDI DJEMMA PALOPO');
INSERT INTO "public"."universitas" VALUES (99595, 91024, 'UNIVERSITAS MUHAMMADIYAH PARE-PARE');
INSERT INTO "public"."universitas" VALUES (99596, 91025, 'UNIVERSITAS MUHAMMADIYAH LUWUK BANGGAI');
INSERT INTO "public"."universitas" VALUES (99597, 91026, 'UNIVERSITAS TOMPOTIKA LUWUK BANGGAI');
INSERT INTO "public"."universitas" VALUES (99598, 91027, 'UNIVERSITAS SARI PUTRA INDONESIA TOMOHON');
INSERT INTO "public"."universitas" VALUES (99599, 91028, 'UNIVERSITAS ISLAM MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99600, 91029, 'UNIVERSITAS KATOLIK DE LA SALLE');
INSERT INTO "public"."universitas" VALUES (99601, 91030, 'UNIVERSITAS PEMBANGUNAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99602, 91031, 'UNIVERSITAS GORONTALO');
INSERT INTO "public"."universitas" VALUES (99603, 91032, 'UNIVERSITAS MUHAMMADIYAH BUTON');
INSERT INTO "public"."universitas" VALUES (99604, 91033, 'UNIVERSITAS ICHSAN GORONTALO');
INSERT INTO "public"."universitas" VALUES (99605, 91035, 'UNIVERSITAS MADAKO TOLITOLI');
INSERT INTO "public"."universitas" VALUES (99606, 91036, 'UNIVERSITAS MUHAMMADIYAH KENDARI');
INSERT INTO "public"."universitas" VALUES (99607, 91037, 'UNIVERSITAS AL ASYARIAH MANDAR');
INSERT INTO "public"."universitas" VALUES (99608, 91038, 'UNIVERSITAS 19 NOVEMBER KOLAKA');
INSERT INTO "public"."universitas" VALUES (99609, 91039, 'UNIVERSITAS COKROAMINOTO PALOPO');
INSERT INTO "public"."universitas" VALUES (99610, 91040, 'UNIVERSITAS TEKNOLOGI SULAWESI');
INSERT INTO "public"."universitas" VALUES (99611, 91041, 'UNIVERSITAS TEKNOLOGI SULAWESI UTARA');
INSERT INTO "public"."universitas" VALUES (99612, 91042, 'UNIVERSITAS KRISTEN TENTENA');
INSERT INTO "public"."universitas" VALUES (99613, 91043, 'UNIVERSITAS SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (99614, 91044, 'UNIVERSITAS MUHAMMADIYAH GORONTALO');
INSERT INTO "public"."universitas" VALUES (99615, 91045, 'UNIVERSITAS FAJAR');
INSERT INTO "public"."universitas" VALUES (99616, 91046, 'UNIVERSITAS TOMAKAKA');
INSERT INTO "public"."universitas" VALUES (99617, 91047, 'UNIVERSITAS PATRIA ARTHA');
INSERT INTO "public"."universitas" VALUES (99618, 91048, 'UNIVERSITAS PEJUANG REPUBLIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (99619, 91049, 'UNIVERSITAS BOSOWA');
INSERT INTO "public"."universitas" VALUES (99620, 91050, 'UNIVERSITAS NAHDLATUL ULAMA SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (99621, 91051, 'UNIVERSITAS KARYA DHARMA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99622, 91052, 'UNIVERSITAS PRISMA');
INSERT INTO "public"."universitas" VALUES (99623, 91053, 'UNIVERSITAS MUSLIM MAROS');
INSERT INTO "public"."universitas" VALUES (99624, 91054, 'UNIVERSITAS NAHDLATUL ULAMA GORONTALO');
INSERT INTO "public"."universitas" VALUES (99625, 91055, 'UNIVERSITAS POHUWATO');
INSERT INTO "public"."universitas" VALUES (99626, 91056, 'UNIVERSITAS MEGAREZKY');
INSERT INTO "public"."universitas" VALUES (99627, 91057, 'UNIVERSITAS PUANGRIMAGGALATUNG');
INSERT INTO "public"."universitas" VALUES (99628, 91058, 'UNIVERSITAS MUHAMMADIYAH SIDENRENG RAPPANG');
INSERT INTO "public"."universitas" VALUES (99629, 91059, 'UNIVERSITAS MUHAMMADIYAH PALOPO');
INSERT INTO "public"."universitas" VALUES (99630, 91060, 'UNIVERSITAS TRINITA');
INSERT INTO "public"."universitas" VALUES (99631, 91061, 'UNIVERSITAS MUHAMMADIYAH BULUKUMBA');
INSERT INTO "public"."universitas" VALUES (99632, 91062, 'UNIVERSITAS MUSLIM BUTON');
INSERT INTO "public"."universitas" VALUES (99633, 91063, 'UNIVERSITAS BINA MANDIRI GORONTALO');
INSERT INTO "public"."universitas" VALUES (99634, 91064, 'UNIVERSITAS MUHAMMADIYAH SINJAI');
INSERT INTO "public"."universitas" VALUES (99635, 91065, 'UNIVERSITAS MUHAMMADIYAH ENREKANG');
INSERT INTO "public"."universitas" VALUES (99636, 91066, 'UNIVERSITAS PARNA RAYA');
INSERT INTO "public"."universitas" VALUES (99637, 91067, 'UNIVERSITAS MEGA BUANA PALOPO');
INSERT INTO "public"."universitas" VALUES (99638, 92001, 'INSTITUT SAINS DAN TEKNOLOGI PEMBANGUNAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99639, 92002, 'INSTITUT TEKNOLOGI MINAESA');
INSERT INTO "public"."universitas" VALUES (99640, 92003, 'INSTITUT KESENIAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99641, 92004, 'INSTITUT TEKNOLOGI DAN KESEHATAN AVICENNA');
INSERT INTO "public"."universitas" VALUES (99642, 92005, 'INSTITUT BISNIS DAN KEUANGAN NITRO');
INSERT INTO "public"."universitas" VALUES (99643, 92006, 'INSTITUT TEKNOLOGI DAN BISNIS KALLA');
INSERT INTO "public"."universitas" VALUES (99644, 92007, 'INSTITUT TEKNOLOGI DAN BISNIS MUHAMMADIYAH POLEWALI MANDAR');
INSERT INTO "public"."universitas" VALUES (99645, 92008, 'INSTITUT KESEHATAN DAN BISNIS ST. FATIMAH MAMUJU');
INSERT INTO "public"."universitas" VALUES (99646, 92009, 'INSTITUT TEKNOLOGI PERTANIAN');
INSERT INTO "public"."universitas" VALUES (99647, 92010, 'INSTITUT TEKNOLOGI DAN KESEHATAN TRI TUNAS NASIONAL');
INSERT INTO "public"."universitas" VALUES (99648, 92011, 'INSTITUT TEKNOLOGI DAN KESEHATAN PERMATA ILMU MAROS');
INSERT INTO "public"."universitas" VALUES (99649, 93001, 'STKIP MUHAMMADIYAH BONE');
INSERT INTO "public"."universitas" VALUES (99650, 93002, 'STKIP MUHAMMADIYAH BULUKUMBA');
INSERT INTO "public"."universitas" VALUES (99651, 93003, 'STKIP MUHAMMADIYAH ENREKANG');
INSERT INTO "public"."universitas" VALUES (99652, 93004, 'STKIP MUHAMMADIYAH RAPPANG');
INSERT INTO "public"."universitas" VALUES (99653, 93005, 'SEKOLAH TINGGI ILMU ADMINISTRASI AL GAZALI BARRU');
INSERT INTO "public"."universitas" VALUES (99654, 93006, 'STISIP 17-8-1945 MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99655, 93008, 'STKIP COKROAMINOTO PINRANG');
INSERT INTO "public"."universitas" VALUES (99656, 93009, 'STKIP YPUP MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99657, 93010, 'STKIP MUHAMMADIYAH BARRU');
INSERT INTO "public"."universitas" VALUES (99658, 93011, 'SEKOLAH TINGGI ILMU ADMINISTRASI AL GAZALI SOPPENG');
INSERT INTO "public"."universitas" VALUES (99659, 93012, 'SEKOLAH TINGGI ILMU HUKUM AL GAZALI SOPPENG');
INSERT INTO "public"."universitas" VALUES (99660, 93015, 'SEKOLAH TINGGI FILSAFAT JAFFRAY MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99661, 93016, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99662, 93017, 'STISIP VETERAN PALOPO');
INSERT INTO "public"."universitas" VALUES (99663, 93018, 'STKIP VETERAN SIDRAP');
INSERT INTO "public"."universitas" VALUES (99664, 93019, 'SEKOLAH TINGGI ILMU EKONOMI YPUP MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99665, 93020, 'SEKOLAH TINGGI ILMU ADMINISTRASI YAPPI MAKASSA');
INSERT INTO "public"."universitas" VALUES (99666, 93021, 'STISIP MERDEKA MANADO');
INSERT INTO "public"."universitas" VALUES (99667, 93023, 'STITEK DHARMA YADI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99668, 93025, 'STIA PUANGRIMAGGALATUNG');
INSERT INTO "public"."universitas" VALUES (99669, 93026, 'STKIP PUANGRIMAGGALATUNG SENGKANG');
INSERT INTO "public"."universitas" VALUES (99670, 93027, 'SEKOLAH TINGGI ILMU EKONOMI MAKASSAR BONGAYA');
INSERT INTO "public"."universitas" VALUES (99671, 93028, 'SEKOLAH TINGGI ILMU ADMINISTRASI PANCAMARGA PALU');
INSERT INTO "public"."universitas" VALUES (99672, 93029, 'STISIP PANCA BHAKTI PALU');
INSERT INTO "public"."universitas" VALUES (99673, 93030, 'SEKOLAH TINGGI ILMU EKONOMI PANCA BHAKTI PALU');
INSERT INTO "public"."universitas" VALUES (99674, 93031, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH PALOPO');
INSERT INTO "public"."universitas" VALUES (100979, 213031, 'STIT AL-AZAMI CIANJUR');
INSERT INTO "public"."universitas" VALUES (100980, 213032, 'STIT AT-TAQWA GEGERKALONG BANDUNG');
INSERT INTO "public"."universitas" VALUES (100981, 213033, 'SEKOLAH TINGGI ILMU AL-QUR`AN (STIQ) ISLAMIC CENTER DEMAK');
INSERT INTO "public"."universitas" VALUES (100982, 213034, 'SEKOLAH TINGGI ILMU AL-QUR`AN (STIQ) ISY KARIMA KARANGANYAR');
INSERT INTO "public"."universitas" VALUES (100983, 213035, 'SEKOLAH TINGGI ISLAM AL-MUKMIN NGRUKI CEMANI SUKOHARJO');
INSERT INTO "public"."universitas" VALUES (100984, 213036, 'STAI AL-ANWAR SARANG REMBANG');
INSERT INTO "public"."universitas" VALUES (100985, 213037, 'STAI AL-HIKMAH 2');
INSERT INTO "public"."universitas" VALUES (100986, 213038, 'STAI AL-KAMAL SARANG REMBANG, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (100987, 213039, 'STAI GROBOGAN JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (100988, 213040, 'STAI KI AGENG PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (100989, 213041, 'STAI MATHALI`UL FALAH KAJEN MARGOYOSO PATI');
INSERT INTO "public"."universitas" VALUES (100990, 213042, 'STAI SUFYAN TSAURI MAJENANG');
INSERT INTO "public"."universitas" VALUES (100991, 213043, 'STIS KEBUMEN JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (100992, 213044, 'SEKOLAH TINGGI ILMU TARBIYAH (STIT) AL-KARIMIYYAH SUMENEP');
INSERT INTO "public"."universitas" VALUES (100993, 213045, 'SEKOLAH TINGGI ISLAM BANI FATAH TAMBAKBERAS JOMBANG');
INSERT INTO "public"."universitas" VALUES (100994, 213046, 'STAI AL-FITHRAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (100995, 213047, 'STAI AL-HIKMAH TUBAN');
INSERT INTO "public"."universitas" VALUES (100996, 213048, 'STAI AL-YASINI PASURUAN');
INSERT INTO "public"."universitas" VALUES (100997, 213049, 'STAI ALI BIN ABI THALIB SURABAYA');
INSERT INTO "public"."universitas" VALUES (100998, 213050, 'STAI AN NAJAH INDONESIA MANDIRI SIDOARJO');
INSERT INTO "public"."universitas" VALUES (100999, 213051, 'STAI AT-TAHDZIB REJOAGUNG NGORO JOMBANG');
INSERT INTO "public"."universitas" VALUES (101000, 213052, 'STAI AT-TANWIR BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (101001, 213053, 'STAI BADRUS SHOLEH PURWOASRI KEDIRI');
INSERT INTO "public"."universitas" VALUES (101002, 213054, 'STAI HASAN JUFRI BAWEAN');
INSERT INTO "public"."universitas" VALUES (101003, 213055, 'STAI CENDEKIA INSANI SITUBONDO');
INSERT INTO "public"."universitas" VALUES (101004, 213056, 'STAI DARUL ULUM BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (101005, 213057, 'STAI DARUSSALAM NGANJUK');
INSERT INTO "public"."universitas" VALUES (101006, 213058, 'SEKOLAH TINGGI DIRASAT ISLAMIYAH IMAM SYAFI`I JEMBER');
INSERT INTO "public"."universitas" VALUES (101007, 213059, 'STAI MA`ARIF MAGETAN');
INSERT INTO "public"."universitas" VALUES (101008, 213060, 'STAI MA`ARIF SAMPANG MADURA, JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101009, 213061, 'STAI MIFTAHUL ULUM TARATE PANDIAN SUMENEP');
INSERT INTO "public"."universitas" VALUES (101010, 213062, 'STAI NAHDLATUL ULAMA (STAINU) MADIUN');
INSERT INTO "public"."universitas" VALUES (101011, 213063, 'STAI NAHDLATUL ULAMA (STAINU) MALANG');
INSERT INTO "public"."universitas" VALUES (101012, 213064, 'STAI NGAWI JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101013, 213065, 'STAI NURUL HUDA KAPONGAN SITUBONDO');
INSERT INTO "public"."universitas" VALUES (101014, 213066, 'STAI PANGERAN DIPONEGORO NGANJUK JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101015, 213067, 'STAI RADEN QOSIM LAMONGAN');
INSERT INTO "public"."universitas" VALUES (101016, 213068, 'STIT AL-IBROHIMY BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101017, 213069, 'STIT MANHALUL MA`ARIF PRAYA LOMBOK TENGAH');
INSERT INTO "public"."universitas" VALUES (101018, 213070, 'STAI MEMPAWAH PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101019, 213071, 'STAI AL-MA`ARIF BUNTOK');
INSERT INTO "public"."universitas" VALUES (101020, 213072, 'STAI SANGATTA');
INSERT INTO "public"."universitas" VALUES (101021, 213073, 'STIT BALIKPAPAN (STITBA)');
INSERT INTO "public"."universitas" VALUES (101022, 213074, 'STIT SYAMSUL MA`ARIF BONTANG');
INSERT INTO "public"."universitas" VALUES (101023, 213075, 'STAI BAHRIYATUL ULUM PANDAN');
INSERT INTO "public"."universitas" VALUES (101024, 213076, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) AL-MA`ARIF WAY KANAN');
INSERT INTO "public"."universitas" VALUES (101025, 213077, 'STAI MA`ARIF KALIREJO LAMPUNG TENGAH');
INSERT INTO "public"."universitas" VALUES (101026, 213078, 'STAI TULANG BAWANG, LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101027, 213079, 'STAI YASBA KALIANDA LAMPUNG SELATAN');
INSERT INTO "public"."universitas" VALUES (101028, 213080, 'STAINU KOTABUMI LAMPUNG UTARA');
INSERT INTO "public"."universitas" VALUES (101029, 213081, 'STIT BUSTANUL `ULUM LAMPUNG TENGAH');
INSERT INTO "public"."universitas" VALUES (101030, 213082, 'STIT PRINGSEWU LAMPUNG SELATAN');
INSERT INTO "public"."universitas" VALUES (101031, 213083, 'STAI AL-KHAIRAAT HALMAHERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101032, 213084, 'STAI BABUSSALAM SULA MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (101033, 213085, 'STES HARAPAN BIMA NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (101034, 213086, 'STAI SULTAN ABDUL KAHIR BIMA');
INSERT INTO "public"."universitas" VALUES (101035, 213087, 'STIT AL-AZIZIYAH KAPEK GUNUNGSARI LOMBOK BARAT NUSA TENGGARA');
INSERT INTO "public"."universitas" VALUES (101036, 213088, 'STIT PALAPA NUSANTARA LOMBOK NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (101037, 213089, 'STITNU AL-MAHSUNI');
INSERT INTO "public"."universitas" VALUES (101038, 213090, 'STAI AL-IKHLAS SIDIKALANG, DAIRI, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101039, 213091, 'STAI AL-AZHAR GOWA, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101040, 213092, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) POSO');
INSERT INTO "public"."universitas" VALUES (101041, 213093, 'STAI AL-MUNAWWAROH TOLITOLI');
INSERT INTO "public"."universitas" VALUES (101042, 213094, 'STAI AL-MAWADDAH WARRAHMAH KOLAKA');
INSERT INTO "public"."universitas" VALUES (101043, 213095, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) WAKATOBI');
INSERT INTO "public"."universitas" VALUES (101044, 213096, 'STAI DARUL QUR`AN PAYAKUMBUH');
INSERT INTO "public"."universitas" VALUES (101045, 213097, 'STAI AL-AZHAR LUBUKLINGGAU, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101046, 213098, 'STAI AS-SUNNAH DELI SERDANG SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101047, 213099, 'STAI BARUMUN RAYA SIBUHUAN');
INSERT INTO "public"."universitas" VALUES (101048, 213100, 'STAI NIAS');
INSERT INTO "public"."universitas" VALUES (101049, 213101, 'STAI PANCA BUDI MEDAN');
INSERT INTO "public"."universitas" VALUES (101050, 213102, 'STIT AL-HIKMAH TEBING TINGGI SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101051, 213103, 'STIT AR-RAUDHAH');
INSERT INTO "public"."universitas" VALUES (101052, 213104, 'STEI AL-ISHLAH BOBOS DUKUPUNTANG CIREBON');
INSERT INTO "public"."universitas" VALUES (101053, 213105, 'STAI AL-ANDINA SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101054, 213106, 'STAI AL-AULIA BOGOR');
INSERT INTO "public"."universitas" VALUES (101055, 213107, 'STAI AL-BAROKAH SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101056, 213108, 'STAI AL-FALAH CICALENGKA, BANDUNG');
INSERT INTO "public"."universitas" VALUES (101057, 213109, 'STAI AL-FATAH CILEUNGSI BOGOR');
INSERT INTO "public"."universitas" VALUES (101058, 213110, 'STAI AL-MUHAJIRIN PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (101059, 213111, 'STAI AL-MUSDARIYAH CIMAHI');
INSERT INTO "public"."universitas" VALUES (101060, 213112, 'STAI ASSHIDDIQIYAH KARAWANG');
INSERT INTO "public"."universitas" VALUES (101061, 213113, 'STAI AZZAKIYAH UJUNGBERUNG BANDUNG');
INSERT INTO "public"."universitas" VALUES (101062, 213114, 'STAI DARUL FALAH CILILIN CIHAMPELAS BANDUNG BARAT');
INSERT INTO "public"."universitas" VALUES (101063, 213115, 'STAI DAARUSSALAM SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101064, 213116, 'STAI KH. ABDUL KABIER SERANG');
INSERT INTO "public"."universitas" VALUES (101065, 213117, 'STAI LAA ROIBA BOGOR');
INSERT INTO "public"."universitas" VALUES (101066, 213118, 'STAI MADINATUL ILMI DEPOK');
INSERT INTO "public"."universitas" VALUES (101067, 213119, 'STAI MA''HAD ALI CIREBON');
INSERT INTO "public"."universitas" VALUES (101068, 213120, 'STAI MIFTAHUL HUDA AL-AZHAR BANJAR');
INSERT INTO "public"."universitas" VALUES (102219, 405035, 'POLTEKKES KEMENKES PANGKAL PINANG');
INSERT INTO "public"."universitas" VALUES (102220, 405036, 'POLTEKKES KEMENKES TANJUNG PINANG');
INSERT INTO "public"."universitas" VALUES (102221, 405037, 'POLTEKKES KEMENKES MAMUJU');
INSERT INTO "public"."universitas" VALUES (102222, 405038, 'POLTEKKES KEMENKES SORONG');
INSERT INTO "public"."universitas" VALUES (102223, 413001, 'SEKOLAH TINGGI AKUNTANSI NEGARA');
INSERT INTO "public"."universitas" VALUES (102224, 415001, 'POLITEKNIK KEUANGAN NEGARA STAN');
INSERT INTO "public"."universitas" VALUES (102225, 423001, 'SEKOLAH TINGGI ILMU PELAYARAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (102226, 423002, 'SEKOLAH TINGGI PENERBANGAN INDONESIA CURUG');
INSERT INTO "public"."universitas" VALUES (102227, 423003, 'SEKOLAH TINGGI TRANSPORTASI DARAT BEKASI');
INSERT INTO "public"."universitas" VALUES (102228, 424004, 'AKADEMI TEKNIK DAN KESELAMATAN PENERBANGAN MEDAN');
INSERT INTO "public"."universitas" VALUES (102229, 424005, 'AKADEMI TEKNIK DAN KESELAMATAN PENERBANGAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102230, 424006, 'AKADEMI TEKNIK DAN KESELAMATAN PENERBANGAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (102231, 424007, 'AKADEMI PERKERETAAPIAN INDONESIA MADIUN');
INSERT INTO "public"."universitas" VALUES (102232, 424008, 'POLITEKNIK PELAYARAN BAROMBONG');
INSERT INTO "public"."universitas" VALUES (102233, 424009, 'AKADEMI PENERBANG INDONESIA BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (102234, 425006, 'POLITEKNIK KESELAMATAN TRANSPORTASI JALAN');
INSERT INTO "public"."universitas" VALUES (102235, 425007, 'POLITEKNIK ILMU PELAYARAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102236, 425008, 'POLITEKNIK ILMU PELAYARAN SEMARANG');
INSERT INTO "public"."universitas" VALUES (102237, 425009, 'POLITEKNIK PELAYARAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (102238, 425010, 'POLITEKNIK PENERBANGAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (102239, 425011, 'POLITEKNIK PELAYARAN SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (102240, 425012, 'POLITEKNIK TRANSPORTASI SUNGAI DANAU DAN PENYEBERANGAN');
INSERT INTO "public"."universitas" VALUES (102241, 425013, 'POLITEKNIK PELAYARAN BANTEN');
INSERT INTO "public"."universitas" VALUES (102242, 425014, 'POLITEKNIK TRANSPORTASI DARAT BALI');
INSERT INTO "public"."universitas" VALUES (102243, 425015, 'POLITEKNIK PELAYARAN SORONG');
INSERT INTO "public"."universitas" VALUES (102244, 425016, 'POLITEKNIK PELAYARAN MALAHAYATI');
INSERT INTO "public"."universitas" VALUES (102245, 425017, 'POLITEKNIK PERKERETAAPIAN INDONESIA MADIUN');
INSERT INTO "public"."universitas" VALUES (102246, 425018, 'POLITEKNIK PENERBANGAN INDONESIA CURUG');
INSERT INTO "public"."universitas" VALUES (102247, 425019, 'POLITEKNIK PENERBANGAN PALEMBANG');
INSERT INTO "public"."universitas" VALUES (102248, 425020, 'POLITEKNIK PENERBANGAN JAYAPURA');
INSERT INTO "public"."universitas" VALUES (102249, 425021, 'POLITEKNIK PENERBANGAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102250, 425022, 'POLITEKNIK PENERBANGAN MEDAN');
INSERT INTO "public"."universitas" VALUES (102251, 433001, 'SEKOLAH TINGGI MANAJEMEN INDUSTRI');
INSERT INTO "public"."universitas" VALUES (102252, 433002, 'SEKOLAH TINGGI TEKNOLOGI TEKSTIL BANDUNG');
INSERT INTO "public"."universitas" VALUES (102253, 434003, 'AKADEMI KIMIA ANALISIS');
INSERT INTO "public"."universitas" VALUES (102254, 434004, 'AKADEMI PIMPINAN PERUSAHAAN');
INSERT INTO "public"."universitas" VALUES (102255, 434005, 'AKADEMI TEKNIK INDUSTRI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102256, 434006, 'AKADEMI TEKNOLOGI INDUSTRI PADANG');
INSERT INTO "public"."universitas" VALUES (102257, 434007, 'AKADEMI TEKNOLOGI KULIT YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102258, 434008, 'AKADEMI TEKNOLOGI KIMIA INDUSTRI MEDAN');
INSERT INTO "public"."universitas" VALUES (102259, 434009, 'AKADEMI KOMUNITAS INDUSTRI TEKSTIL DAN PRODUK TEKSTIL SURAKARTA');
INSERT INTO "public"."universitas" VALUES (102260, 435001, 'POLITEKNIK TEKNOLOGI KIMIA INDUSTRI MEDAN');
INSERT INTO "public"."universitas" VALUES (102261, 435002, 'POLITEKNIK STMI JAKARTA');
INSERT INTO "public"."universitas" VALUES (102262, 435003, 'POLITEKNIK ATI PADANG');
INSERT INTO "public"."universitas" VALUES (102263, 435004, 'POLITEKNIK STTT BANDUNG');
INSERT INTO "public"."universitas" VALUES (102264, 435005, 'POLITEKNIK AKA BOGOR');
INSERT INTO "public"."universitas" VALUES (102265, 435006, 'POLITEKNIK APP JAKARTA');
INSERT INTO "public"."universitas" VALUES (102266, 435007, 'POLITEKNIK ATK YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (102267, 435008, 'POLITEKNIK ATI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102268, 435009, 'POLITEKNIK INDUSTRI LOGAM MOROWALI');
INSERT INTO "public"."universitas" VALUES (102269, 435010, 'POLITEKNIK INDUSTRI FURNITUR DAN PENGOLAHAN KAYU');
INSERT INTO "public"."universitas" VALUES (102270, 436001, 'AKADEMI KOMUNITAS INDUSTRI MANUFAKTUR BANTAENG');
INSERT INTO "public"."universitas" VALUES (102271, 443001, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN (STPP) MAGELANG');
INSERT INTO "public"."universitas" VALUES (102272, 443002, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN BOGOR');
INSERT INTO "public"."universitas" VALUES (102273, 443003, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN GOWA');
INSERT INTO "public"."universitas" VALUES (102274, 443004, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN MALANG');
INSERT INTO "public"."universitas" VALUES (102275, 443005, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN MEDAN');
INSERT INTO "public"."universitas" VALUES (102276, 443006, 'SEKOLAH TINGGI PENYULUHAN PERTANIAN MANOKWARI');
INSERT INTO "public"."universitas" VALUES (102277, 445001, 'POLITEKNIK PEMBANGUNAN PERTANIAN MALANG');
INSERT INTO "public"."universitas" VALUES (102278, 445002, 'POLITEKNIK PEMBANGUNAN PERTANIAN MANOKWARI');
INSERT INTO "public"."universitas" VALUES (102279, 445003, 'POLITEKNIK PEMBANGUNAN PERTANIAN MEDAN');
INSERT INTO "public"."universitas" VALUES (102280, 445004, 'POLITEKNIK PEMBANGUNAN PERTANIAN YOGYAKARTA - MAGELANG');
INSERT INTO "public"."universitas" VALUES (102281, 445005, 'POLITEKNIK PEMBANGUNAN PERTANIAN GOWA');
INSERT INTO "public"."universitas" VALUES (102282, 445006, 'POLITEKNIK PEMBANGUNAN PERTANIAN BOGOR');
INSERT INTO "public"."universitas" VALUES (102283, 445007, 'POLITEKNIK ENJINIRING PERTANIAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (102284, 453001, 'SEKOLAH TINGGI KESEJAHTERAAN SOSIAL (STKS)');
INSERT INTO "public"."universitas" VALUES (102285, 455001, 'POLITEKNIK KESEJAHTERAAN SOSIAL BANDUNG');
INSERT INTO "public"."universitas" VALUES (102286, 463001, 'SEKOLAH TINGGI SANDI NEGARA');
INSERT INTO "public"."universitas" VALUES (102287, 465001, 'POLITEKNIK SIBER DAN SANDI NEGARA');
INSERT INTO "public"."universitas" VALUES (102288, 471001, 'UNIVERSITAS PERTAHANAN');
INSERT INTO "public"."universitas" VALUES (102289, 473001, 'SEKOLAH TINGGI TEKNOLOGI ANGKATAN LAUT');
INSERT INTO "public"."universitas" VALUES (102290, 473003, 'SEKOLAH TINGGI HUKUM MILITER AHM - PTHM');
INSERT INTO "public"."universitas" VALUES (102291, 474001, 'AKADEMI MILITER MAGELANG');
INSERT INTO "public"."universitas" VALUES (102292, 474002, 'AKADEMI ANGKATAN UDARA (AAU)');
INSERT INTO "public"."universitas" VALUES (102293, 474003, 'AKADEMI ANGKATAN LAUT SURABAYA');
INSERT INTO "public"."universitas" VALUES (102294, 475001, 'POLITEKNIK ANGKATAN DARAT');
INSERT INTO "public"."universitas" VALUES (102295, 475002, 'POLITEKNIK ANGKATAN LAUT');
INSERT INTO "public"."universitas" VALUES (102296, 483001, 'SEKOLAH TINGGI ILMU KEPOLISIAN');
INSERT INTO "public"."universitas" VALUES (102297, 484001, 'AKADEMI KEPOLISIAN (AKPOL)');
INSERT INTO "public"."universitas" VALUES (102298, 493001, 'STIA-LEMBAGA ADMINISTRASI NEGARA BANDUNG');
INSERT INTO "public"."universitas" VALUES (102299, 493002, 'STIA-LEMBAGA ADMINISTRASI NEGARA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102300, 493003, 'STIA-LEMBAGA ADMINISTRASI NEGARA JAKARTA');
INSERT INTO "public"."universitas" VALUES (102301, 495001, 'POLITEKNIK STIA LAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (102302, 495002, 'POLITEKNIK STIA LAN BANDUNG');
INSERT INTO "public"."universitas" VALUES (98252, 43361, 'STIKES MUHAMMADIYAH KUNINGAN');
INSERT INTO "public"."universitas" VALUES (98253, 43362, 'STKIP LA TANSA MASHIRO');
INSERT INTO "public"."universitas" VALUES (98254, 43363, 'SEKOLAH TINGGI ILMU EKONOMI JIU');
INSERT INTO "public"."universitas" VALUES (98255, 43364, 'SEKOLAH TINGGI ILMU HUKUM DAN POLITIK PELOPOR BANGSA');
INSERT INTO "public"."universitas" VALUES (98256, 43365, 'SEKOLAH TINGGI ILMU KESEHATAN BOGOR HUSADA');
INSERT INTO "public"."universitas" VALUES (98257, 43366, 'SEKOLAH TINGGI ILMU KESEHATAN KHAS KEMPEK');
INSERT INTO "public"."universitas" VALUES (98258, 43367, 'STISIP SAMUDERA INDONESIA SELATAN');
INSERT INTO "public"."universitas" VALUES (98259, 43368, 'SEKOLAH TINGGI PENDIDIKAN HOLISTIK BERBASIS KAREKTER');
INSERT INTO "public"."universitas" VALUES (98260, 43369, 'SEKOLAH TINGGI BAHASA ASING JIU');
INSERT INTO "public"."universitas" VALUES (98261, 44001, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER YASIKA');
INSERT INTO "public"."universitas" VALUES (98262, 44002, 'AKADEMI AKUNTANSI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98263, 44003, 'AKADEMI AKUNTANSI BINA INSANI');
INSERT INTO "public"."universitas" VALUES (98264, 44004, 'AKADEMI SEKRETARI DAN MANAJEMEN BINA INSANI');
INSERT INTO "public"."universitas" VALUES (98265, 44006, 'AKADEMI SEKRETARI DAN MANAJEMEN BHAKTI');
INSERT INTO "public"."universitas" VALUES (98266, 44008, 'AKADEMI BAHASA ASING YPKK TANGERANG');
INSERT INTO "public"."universitas" VALUES (98267, 44009, 'AMIK WIRA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98268, 44022, 'AKADEMI SEKRETARI MANAJEMEN TARUNA BAKTI');
INSERT INTO "public"."universitas" VALUES (98269, 44028, 'AKADEMI MANAJEMEN KESATUAN BOGOR');
INSERT INTO "public"."universitas" VALUES (98270, 44033, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER HASS');
INSERT INTO "public"."universitas" VALUES (98271, 44035, 'AKADEMI MARITIM SUAKA BAHARI');
INSERT INTO "public"."universitas" VALUES (98272, 44038, 'AKADEMI SEKRETARI & MANAJEMEN INDUSTRI BUDHI');
INSERT INTO "public"."universitas" VALUES (98273, 44041, 'AKADEMI PARIWISATA ARS INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98274, 44045, 'AMIK BUMI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98275, 44049, 'AKADEMI SEKRETARIS DAN MANAJEMEN KENCANA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98276, 44050, 'AKADEMI PARIWISATA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98277, 44051, 'AKADEMI PERDAGANGAN BANDUNG');
INSERT INTO "public"."universitas" VALUES (98278, 44052, 'AKADEMI MARITIM CIREBON');
INSERT INTO "public"."universitas" VALUES (98279, 44054, 'AKADEMI KESENIAN BOGOR');
INSERT INTO "public"."universitas" VALUES (98280, 44055, 'AKADEMI TEKNOLOGI PATRIOT');
INSERT INTO "public"."universitas" VALUES (98281, 44056, 'AKADEMI PARIWISATA YASMI');
INSERT INTO "public"."universitas" VALUES (98282, 44060, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER SERANG');
INSERT INTO "public"."universitas" VALUES (98283, 44062, 'AKADEMI SEKRETARI DAN MANAJEMEN TUNAS HARAPAN');
INSERT INTO "public"."universitas" VALUES (98284, 44064, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER GARUT');
INSERT INTO "public"."universitas" VALUES (98285, 44065, 'AKADEMI PARIWISATA SILIWANGI');
INSERT INTO "public"."universitas" VALUES (98286, 44066, 'AKADEMI BAHASA ASING BUDHI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98287, 44068, 'AMIK SULTAN AGUNG');
INSERT INTO "public"."universitas" VALUES (98288, 44069, 'AKADEMI SEKRETARI TRIGUNA');
INSERT INTO "public"."universitas" VALUES (98289, 44070, 'AKADEMI SEKRETARI DAN MANAJEMEN LEPISI');
INSERT INTO "public"."universitas" VALUES (98290, 44071, 'AKADEMI SEKRETARI DAN MANAJEMEN ARIYANTI');
INSERT INTO "public"."universitas" VALUES (98291, 44072, 'AKADEMI TATA BOGA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98292, 44074, 'AKADEMI TEKNOLOGI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98293, 44075, 'AKADEMI INDUSTRI TEKSTIL BANDUNG');
INSERT INTO "public"."universitas" VALUES (98294, 44077, 'AKADEMI KOMUNIKASI RADIO DAN TELEVISI HUTAMA');
INSERT INTO "public"."universitas" VALUES (98295, 44078, 'AKADEMI TEKNOLOGI BOGOR');
INSERT INTO "public"."universitas" VALUES (98296, 44081, 'AMIK AL-MA SOEM');
INSERT INTO "public"."universitas" VALUES (98297, 44082, 'AKADEMI PARIWISATA SANDHY PUTRA');
INSERT INTO "public"."universitas" VALUES (98298, 44089, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER YPAT');
INSERT INTO "public"."universitas" VALUES (98299, 44090, 'AMIK RAHARJA INFORMATIKA');
INSERT INTO "public"."universitas" VALUES (98300, 44092, 'AKADEMI TEKNOLOGI AERONAUTIKA SILIWANGI');
INSERT INTO "public"."universitas" VALUES (98301, 44093, 'AKADEMI PARIWISATA NASIONAL INDONESIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98302, 44094, 'AKADEMI AKUNTANSI KEUANGAN DAN PERBANKAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (98303, 44098, 'AKADEMI SEKRETARI DAN MANAJEMEN INSULINDO');
INSERT INTO "public"."universitas" VALUES (98304, 44102, 'AMIK PURNAMA NIAGA');
INSERT INTO "public"."universitas" VALUES (98305, 44105, 'AKADEMI TELEKOMUNIKASI BOGOR');
INSERT INTO "public"."universitas" VALUES (98306, 44107, 'AKADEMI PARIWISATA CITRA BUANA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98307, 44108, 'AMIK CITRA BUANA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98308, 44109, 'AKADEMI PEREKAM MEDIS & INFORMATIKA KESEHATAN BANDUNG');
INSERT INTO "public"."universitas" VALUES (98309, 44110, 'AMIK WAHANA MANDIRI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98310, 44111, 'AKADEMI PARIWISATA NHI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98311, 44112, 'AMIK PGRI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98312, 44114, 'AKADEMI FISIOTERAPI RUMAH SAKIT DUSTIRA');
INSERT INTO "public"."universitas" VALUES (98313, 44116, 'AKADEMI KEBIDANAN YAYASAN HUSADA MADANI');
INSERT INTO "public"."universitas" VALUES (98314, 44118, 'AKADEMI MINYAK DAN GAS BALONGAN');
INSERT INTO "public"."universitas" VALUES (98315, 44122, 'AMIK AL-MUSLIM BEKASI');
INSERT INTO "public"."universitas" VALUES (98316, 44123, 'AMIK PAKARTI LUHUR');
INSERT INTO "public"."universitas" VALUES (98317, 44124, 'AKADEMI KEUANGAN DAN BISNIS INDONESIA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98318, 44125, 'AKMI GUNA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98319, 44126, 'AKADEMI TELEKOMUNIKASI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98320, 44127, 'AKADEMI KEBIDANAN BINA HUSADA TANGERANG');
INSERT INTO "public"."universitas" VALUES (98321, 44129, 'AKADEMI KEBIDANAN ASSYIFA TANGERANG');
INSERT INTO "public"."universitas" VALUES (98322, 44130, 'AKADEMI KEBIDANAN AL-ISHLAH CILEGON');
INSERT INTO "public"."universitas" VALUES (98323, 44131, 'AMIK BSI BEKASI');
INSERT INTO "public"."universitas" VALUES (98324, 44132, 'AKADEMI ANALISI KESEHATAN AN-NASHER');
INSERT INTO "public"."universitas" VALUES (98325, 44133, 'AKADEMI BAHASA ASING INTERNASIONAL BANDUNG');
INSERT INTO "public"."universitas" VALUES (98326, 44134, 'AKADEMI KEBIDANAN KARYA BUNDA HUSADA');
INSERT INTO "public"."universitas" VALUES (98327, 44135, 'AKADEMI KEBIDANAN SALSABILA');
INSERT INTO "public"."universitas" VALUES (98328, 44136, 'AKADEMI TEKNIK MESIN INDUSTRI CIKARANG');
INSERT INTO "public"."universitas" VALUES (98329, 44137, 'AKADEMI KEBIDANAN AISYIYAH SERANG');
INSERT INTO "public"."universitas" VALUES (98330, 44142, 'AKADEMI KEPERAWATAN AISYIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (98331, 44143, 'AKADEMI KEPERAWATAN KEBONJATI');
INSERT INTO "public"."universitas" VALUES (98332, 44149, 'AKADEMI KEPERAWATAN BHAKTI HUSADA CIKARANG');
INSERT INTO "public"."universitas" VALUES (98333, 44152, 'AKADEMI KEPERAWATAN YPIB MAJALENGKA');
INSERT INTO "public"."universitas" VALUES (98334, 44154, 'AKADEMI KEPERAWATAN RS DUSTIRA');
INSERT INTO "public"."universitas" VALUES (98335, 44155, 'AKADEMI KEPERAWATAN RAFLESIA');
INSERT INTO "public"."universitas" VALUES (98336, 44156, 'AKADEMI KEPERAWATAN SAIFUDDIN ZUHRI');
INSERT INTO "public"."universitas" VALUES (98337, 44157, 'AKADEMI KEPERAWATAN MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (98338, 44160, 'AKADEMI KEPERAWATAN BUNTET PESANTREN');
INSERT INTO "public"."universitas" VALUES (99675, 93032, 'SEKOLAH TINGGI FILSAFAT SEMINARI PINELENG');
INSERT INTO "public"."universitas" VALUES (99676, 93033, 'SEKOLAH TINGGI ILMU EKONOMI AMSIR PARE-PARE');
INSERT INTO "public"."universitas" VALUES (99677, 93034, 'STKIP YAPTI JENEPONTO');
INSERT INTO "public"."universitas" VALUES (99678, 93035, 'SEKOLAH TINGGI ILMU KESEJAHTERAAN SOSIAL MANADO');
INSERT INTO "public"."universitas" VALUES (99679, 93036, 'SEKOLAH TINGGI ILMU KOMUNIKASI MANADO');
INSERT INTO "public"."universitas" VALUES (99680, 93037, 'STKIP PEMBANGUNAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99681, 93038, 'SEKOLAH TINGGI ILMU EKONOMI PEMBANGUNAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99682, 93039, 'SEKOLAH TINGGI ILMU EKONOMI SULAWESI UTARA');
INSERT INTO "public"."universitas" VALUES (99683, 93041, 'STKIP YAPIM MAROS');
INSERT INTO "public"."universitas" VALUES (99684, 93043, 'SEKOLAH TINGGI ILMU EKONOMI BAJIMINASA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99685, 93044, 'STIKS TAMALANREA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99686, 93045, 'STIM LPI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99687, 93046, 'SEKOLAH TINGGI ILMU MANAJEMEN INDONESIA YAPMI');
INSERT INTO "public"."universitas" VALUES (99688, 93047, 'SEKOLAH TINGGI ILMU EKONOMI BUDI UTOMO MANADO');
INSERT INTO "public"."universitas" VALUES (99689, 93048, 'SEKOLAH TINGGI ILMU EKONOMI LPI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99690, 93049, 'SEKOLAH TINGGI ILMU PERTANIAN WUNA RAHA');
INSERT INTO "public"."universitas" VALUES (99691, 93050, 'SEKOLAH TINGGI ILMU EKONOMI YAPMAN MAJENE');
INSERT INTO "public"."universitas" VALUES (99692, 93051, 'SEKOLAH TINGGI ILMU EKONOMI EBEN HAEZER MANADO');
INSERT INTO "public"."universitas" VALUES (99693, 93052, 'STMIK DIPANEGARA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99694, 93053, 'SEKOLAH TINGGI ILMU EKONOMI NUSANTARA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99695, 93054, 'SEKOLAH TINGGI ILMU EKONOMI EL FATAH MANADO');
INSERT INTO "public"."universitas" VALUES (99696, 93055, 'SEKOLAH TINGGI ILMU PERTANIAN MUJAHIDIN TOLI-TOLI');
INSERT INTO "public"."universitas" VALUES (99697, 93056, 'STMIK MANADO');
INSERT INTO "public"."universitas" VALUES (99698, 93057, 'STKIP PGRI MANADO');
INSERT INTO "public"."universitas" VALUES (99699, 93058, 'STISIP PETTA BARINGENG SOPPENG');
INSERT INTO "public"."universitas" VALUES (99700, 93059, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA BARATA KENDARI');
INSERT INTO "public"."universitas" VALUES (99701, 93060, 'SEKOLAH TINGGI ILMU EKONOMI ENAM ENAM KENDARI');
INSERT INTO "public"."universitas" VALUES (99702, 93061, 'SEKOLAH TINGGI ILMU EKONOMI YAPTI JENEPONTO');
INSERT INTO "public"."universitas" VALUES (99703, 93062, 'SEKOLAH TINGGI ILMU HUKUM DAMARICA PALOPO');
INSERT INTO "public"."universitas" VALUES (99704, 93063, 'SEKOLAH TINGGI ILMU PERTANIAN KENDARI');
INSERT INTO "public"."universitas" VALUES (99705, 93064, 'SEKOLAH TINGGI ILMU EKONOMI AMKOP MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99706, 93066, 'SEKOLAH TINGGI ILMU KESEHATAN TAMALATEA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99707, 93068, 'SEKOLAH TINGGI ILMU EKONOMI PIONER MANADO');
INSERT INTO "public"."universitas" VALUES (99708, 93069, 'STMIK HANDAYANI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99709, 93072, 'SEKOLAH TINGGI ILMU MANAJEMEN YAPIM MAROS');
INSERT INTO "public"."universitas" VALUES (99710, 93074, 'SEKOLAH TINGGI THEOLOGIA INTIM MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99711, 93075, 'SEKOLAH TINGGI ILMU PERTANIAN PUANGRIMANGGALATUNG');
INSERT INTO "public"."universitas" VALUES (99712, 93076, 'SEKOLAH TINGGI ILMU EKONOMI RIZKY');
INSERT INTO "public"."universitas" VALUES (98447, 45048, 'POLITEKNIK INDUSTRI ATMI');
INSERT INTO "public"."universitas" VALUES (99713, 93077, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH MAMUJU');
INSERT INTO "public"."universitas" VALUES (99714, 93078, 'SEKOLAH TINGGI ILMU EKONOMI PETRA');
INSERT INTO "public"."universitas" VALUES (99715, 93079, 'SEKOLAH TINGGI ILMU EKONOMI SWADAYA MANADO');
INSERT INTO "public"."universitas" VALUES (99716, 93080, 'SEKOLAH TINGGI ILMU KESEHATAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99717, 93081, 'SEKOLAH TINGGI ILMU EKONOMI MAKASSAR MAJU');
INSERT INTO "public"."universitas" VALUES (99718, 93082, 'SEKOLAH TINGGI ILMU EKONOMI TRI DHARMA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99719, 93083, 'SEKOLAH TINGGI ILMU ADMINISTRASI BINA TARUNA');
INSERT INTO "public"."universitas" VALUES (99720, 93084, 'STIE NOBEL INDONESIA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99721, 93085, 'SEKOLAH TINGGI ILMU EKONOMI PARIWISATA');
INSERT INTO "public"."universitas" VALUES (99722, 93086, 'SEKOLAH TINGGI ILMU EKONOMI PATRIA ARTHA');
INSERT INTO "public"."universitas" VALUES (99723, 93087, 'SEKOLAH TINGGI ILMU FARMASI DAN PENGETAHUAN ALAM PELITA MAS PALU');
INSERT INTO "public"."universitas" VALUES (99724, 93088, 'SEKOLAH TINGGI ILMU KESEHATAN INDONESIA JAYA');
INSERT INTO "public"."universitas" VALUES (99725, 93089, 'SEKOLAH TINGGI ILMU BAHASA ASING BUMI BERINGIN');
INSERT INTO "public"."universitas" VALUES (99726, 93090, 'SEKOLAH TINGGI ILMU HUKUM PENGAYOMAN');
INSERT INTO "public"."universitas" VALUES (99727, 93091, 'SEKOLAH TINGGI ILMU MANAJEMEN PUBLIK MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99728, 93092, 'STITEK BINA TARUNA');
INSERT INTO "public"."universitas" VALUES (99729, 93093, 'STMIK KHARISMA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99730, 93094, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER ICHSAN GORONTALO');
INSERT INTO "public"."universitas" VALUES (99731, 93095, 'SEKOLAH TINGGI ILMU EKONOMI ICHSAN POHUWATO');
INSERT INTO "public"."universitas" VALUES (99732, 93096, 'STISIP MUHAMMADIYAH RAPPANG');
INSERT INTO "public"."universitas" VALUES (99733, 93097, 'STKIP ANDI MATTAPPA');
INSERT INTO "public"."universitas" VALUES (99734, 93098, 'SEKOLAH TINGGI ILMU HUKUM LAMADDUKELLENG');
INSERT INTO "public"."universitas" VALUES (99735, 93099, 'SEKOLAH TINGGI ILMU EKONOMI LAMADDUKELLENG');
INSERT INTO "public"."universitas" VALUES (99736, 93100, 'SEKOLAH TINGGI ILMU EKONOMI WIRA BHAKTI');
INSERT INTO "public"."universitas" VALUES (99737, 93101, 'SEKOLAH TINGGI TEKNIK BARAMULI');
INSERT INTO "public"."universitas" VALUES (99738, 93102, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA DARMA KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (99739, 93103, 'STMIK BINA MULIA');
INSERT INTO "public"."universitas" VALUES (99740, 93104, 'SEKOLAH TINGGI ILMU EKONOMI LAMAPPAPOLEONRO SOPPENG');
INSERT INTO "public"."universitas" VALUES (99741, 93105, 'SEKOLAH TINGGI TEKNOLOGI DIRGANTARA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99742, 93106, 'SEKOLAH TINGGI ILMU ADMINISTRASI PEMBANGUNAN PALU');
INSERT INTO "public"."universitas" VALUES (99743, 93107, 'SEKOLAH TINGGI ILMU HUKUM AMSIR');
INSERT INTO "public"."universitas" VALUES (99744, 93108, 'SEKOLAH TINGGI ILMU EKONOMI YAPI BONE');
INSERT INTO "public"."universitas" VALUES (99745, 93109, 'SEKOLAH TINGGI ILMU PERTANIAN YAPI BONE');
INSERT INTO "public"."universitas" VALUES (99746, 93110, 'SEKOLAH TINGGI ILMU ADMINISTRASI PUANGRIMAGGALATUNG');
INSERT INTO "public"."universitas" VALUES (99747, 93111, 'STMIK ADHI GUNA');
INSERT INTO "public"."universitas" VALUES (99748, 93112, 'SEKOLAH TINGGI ILMU KESEHATAN AVICENNA');
INSERT INTO "public"."universitas" VALUES (99749, 93113, 'SEKOLAH TINGGI ILMU KEPERAWATAN FAMIKA');
INSERT INTO "public"."universitas" VALUES (99750, 93114, 'STIM LASHARAN JAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99751, 93115, 'SEKOLAH TINGGI TEKNOLOGI KELAUTAN');
INSERT INTO "public"."universitas" VALUES (99752, 93116, 'STMIK PARNARAYA');
INSERT INTO "public"."universitas" VALUES (99753, 93117, 'STISIP SWADAYA');
INSERT INTO "public"."universitas" VALUES (99754, 93118, 'SEKOLAH TINGGI ILMU HUKUM COKROAMINOTO');
INSERT INTO "public"."universitas" VALUES (101069, 213121, 'STAI MIFTAHUL ULUM TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (101070, 213122, 'STAI MUHAMMADIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (101071, 213123, 'SEKOLAH TINGGI AGAMA ISLAM PANGERAN DHARMA KUSUMA SEGERAN INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (101072, 213124, 'STAI PELABUHAN RATU, SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101073, 213125, 'STAI PERSIS BANDUNG');
INSERT INTO "public"."universitas" VALUES (101074, 213126, 'STAI PERSIS GARUT');
INSERT INTO "public"."universitas" VALUES (101075, 213127, 'STAI PUI MAJALENGKA');
INSERT INTO "public"."universitas" VALUES (101076, 213128, 'STAI PUTRA GALUH CIAMIS');
INSERT INTO "public"."universitas" VALUES (101077, 213129, 'STAI SABILI BANDUNG');
INSERT INTO "public"."universitas" VALUES (101078, 213130, 'STAI SAYID SABIQ INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (101079, 213131, 'STAI SEBELAS APRIL SUMEDANG');
INSERT INTO "public"."universitas" VALUES (101080, 213132, 'STAI SILIWANGI BANDUNG');
INSERT INTO "public"."universitas" VALUES (101081, 213133, 'STAI SYAMSUL ULUM GUNUNG PUYUH');
INSERT INTO "public"."universitas" VALUES (101082, 213134, 'STAI TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (101083, 213135, 'STIT AL-AMIN INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (101084, 213136, 'STIT AT-TAQWA CIPARAY BANDUNG');
INSERT INTO "public"."universitas" VALUES (101085, 213137, 'STIT MUHAMMADIYAH BANJAR');
INSERT INTO "public"."universitas" VALUES (101086, 213138, 'STIT NURUL HIKMAH CIANJUR');
INSERT INTO "public"."universitas" VALUES (101087, 213139, 'STAI HAJI AGUS SALIM CIKARANG BEKASI');
INSERT INTO "public"."universitas" VALUES (101088, 213140, 'STAI LA TANSA MASHIRO RANGKASBITUNG LEBAK');
INSERT INTO "public"."universitas" VALUES (101089, 213141, 'STAI MIFTAHUL HUDA PAMANUKAN SUBANG');
INSERT INTO "public"."universitas" VALUES (101090, 213142, 'STAI NIDA EL ADABI PARUNG PANJANG BOGOR');
INSERT INTO "public"."universitas" VALUES (101091, 213143, 'STAI RIYADHUL JANNAH SUBANG');
INSERT INTO "public"."universitas" VALUES (101092, 213144, 'STAI SILIWANGI GARUT');
INSERT INTO "public"."universitas" VALUES (101093, 213145, 'STAI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101094, 213146, 'STAI SYEKH MANSHUR PANDEGLANG');
INSERT INTO "public"."universitas" VALUES (101095, 213147, 'STIT TARBIYATUN NISA SENTUL-BOGOR');
INSERT INTO "public"."universitas" VALUES (101096, 213148, 'STAI AL-AZHARY CIANJUR, JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101097, 213149, 'STAI YAMISA SOREANG');
INSERT INTO "public"."universitas" VALUES (101098, 213150, 'STAI YAPATA AL-JAWAMI BANDUNG');
INSERT INTO "public"."universitas" VALUES (101099, 213151, 'STAI YAPERI CIBINONG');
INSERT INTO "public"."universitas" VALUES (101100, 213152, 'STIT AL-KHAIRIYAH CITANGKIL CILEGON');
INSERT INTO "public"."universitas" VALUES (101101, 213153, 'STIT SIROJUL FALAH BOGOR');
INSERT INTO "public"."universitas" VALUES (101102, 213154, 'STAI AL-HIDAYAH BOGOR');
INSERT INTO "public"."universitas" VALUES (101103, 213155, 'STAI AL-IHYA KUNINGAN');
INSERT INTO "public"."universitas" VALUES (101104, 213156, 'STAI AL-KARIMIYAH SAWANGAN DEPOK');
INSERT INTO "public"."universitas" VALUES (101105, 213157, 'STAI AL-MAS`UDIYAH, SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101106, 213158, 'STAI AL-MUKHLISIN BOGOR');
INSERT INTO "public"."universitas" VALUES (101107, 213159, 'STAI BABUNNAJAH PANDEGLANG, BANTEN');
INSERT INTO "public"."universitas" VALUES (101108, 213160, 'STAI BAITUL ARQOM AL-ISLAMI CIPARAY BANDUNG');
INSERT INTO "public"."universitas" VALUES (101109, 213161, 'STAI BUNGA BANGSA CIREBON');
INSERT INTO "public"."universitas" VALUES (101110, 213162, 'STAI CIREBON');
INSERT INTO "public"."universitas" VALUES (101111, 213163, 'STAI DARUL ARQAM MUHAMMADIYAH GARUT');
INSERT INTO "public"."universitas" VALUES (101112, 213164, 'STAI FATAHILLAH SERPONG, TANGERANG');
INSERT INTO "public"."universitas" VALUES (101113, 213165, 'STIT AL-HIDAYAH TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (101114, 213166, 'STIS NAHDLATUL ULAMA CIANJUR');
INSERT INTO "public"."universitas" VALUES (101115, 213167, 'STIBA AR RAAYAH');
INSERT INTO "public"."universitas" VALUES (101116, 213168, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) LPPM');
INSERT INTO "public"."universitas" VALUES (101117, 213169, 'STEI BINA CIPTA MADANI');
INSERT INTO "public"."universitas" VALUES (101118, 213170, 'STAI DR. KH. EZ. MUTTAQIEN PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (101119, 213171, 'STIT SERANG');
INSERT INTO "public"."universitas" VALUES (101120, 213172, 'SEKOLAH TINGGI FILSAFAT ISLAM (STFI) SADRA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101121, 213173, 'STAI AL-AQIDAH AL-HASYIMIYAH JAKARTA, JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (101122, 213174, 'STAI ALHIKMAH JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (101123, 213175, 'STAI BANI SALEH BEKASI');
INSERT INTO "public"."universitas" VALUES (101124, 213176, 'STAI NAHDLATUL ULAMA (STAINU) JAKARTA');
INSERT INTO "public"."universitas" VALUES (101125, 213177, 'STIT ISLAMIC VILLAGE TANGERANG BANTEN');
INSERT INTO "public"."universitas" VALUES (101126, 213178, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) TAZKIA, BOGOR');
INSERT INTO "public"."universitas" VALUES (101127, 213179, 'STAI ASSALAMIYAH CURUGSARI JAWILAN SERANG');
INSERT INTO "public"."universitas" VALUES (101128, 213180, 'STAI WASHILATUL FALAH, RANGKASBITUNG, LEBAK');
INSERT INTO "public"."universitas" VALUES (101129, 213181, 'STIT INSAN KAMIL BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101130, 213182, 'STAI KH ABDUL KABIER');
INSERT INTO "public"."universitas" VALUES (101131, 213183, 'SEKOLAH TINGGI KULLIYATUL QUR''AN AL-HIKAM DEPOK');
INSERT INTO "public"."universitas" VALUES (101132, 213184, 'STAI KHARISMA CICURUG, SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101133, 213185, 'SEKOLAH TINGGI EKONOMI ISLAM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101134, 213186, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) HAMFARA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101135, 213187, 'SEKOLAH TINGGI ILMU AL-QUR`AN (STIQ) AN-NUR YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101136, 213188, 'SEKOLAH TINGGI PENDIDIKAN ISLAM (STPI) BINA INSAN MULIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101137, 213189, 'STAI ALMA ATA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101138, 213190, 'STAI MASJID SYUHADA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101139, 213191, 'STAI SUNAN PANDANARAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101140, 213192, 'STAI YOGYAKARTA WONOSARI, GUNUNG KIDUL');
INSERT INTO "public"."universitas" VALUES (101141, 213193, 'STIT MUHAMMADIYAH WATES, KULONPROGO');
INSERT INTO "public"."universitas" VALUES (101142, 213194, 'STEI HAMZAR LOMBOK TIMUR');
INSERT INTO "public"."universitas" VALUES (101143, 213195, 'STIPI KHADIDJAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (101144, 213196, 'STAI AL-AMIN GERSIK KEDIRI LOMBOK BARAT');
INSERT INTO "public"."universitas" VALUES (101145, 213197, 'SEKOLAH TINGGI AGAMA ISLAM AL-AMIN DOMPU NTB');
INSERT INTO "public"."universitas" VALUES (101146, 213198, 'STAI AL-AZHAR MENGANTI GRESIK');
INSERT INTO "public"."universitas" VALUES (101147, 213199, 'STAI AL-FALAH AS-SUNNIYAH KENCONG JEMBER');
INSERT INTO "public"."universitas" VALUES (101148, 213200, 'STAI AL-FATTAH (STAIFA) PACITAN');
INSERT INTO "public"."universitas" VALUES (101149, 213201, 'STAI AL-HAMIDIYAH BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101150, 213202, 'STAI AL-KHAIRAT PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101151, 213203, 'STAI AL-KHOZINY BUDURAN SIDOARJO');
INSERT INTO "public"."universitas" VALUES (101152, 213204, 'STAI AL-QODIRI JEMBER');
INSERT INTO "public"."universitas" VALUES (101153, 213205, 'STAI AL-QOLAM GONDANGLEGI MALANG');
INSERT INTO "public"."universitas" VALUES (101154, 213206, 'STAI AR-ROSYID SURABAYA');
INSERT INTO "public"."universitas" VALUES (101155, 213207, 'STAI AT-TAQWA BONDOWOSO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101156, 213208, 'STAI BAHRUL ULUM TAMBAKBERAS, JOMBANG');
INSERT INTO "public"."universitas" VALUES (101157, 213209, 'SEKOLAH TINGGI ISLAM BLAMBANGAN BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (101158, 213210, 'STAI BUSTANUL ULUM KRAI, LUMAJANG');
INSERT INTO "public"."universitas" VALUES (101159, 213211, 'STAI DARUL HIKMAH BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101160, 213212, 'STAI DARUL KAMAL NW KEMBANG KERANG NTB');
INSERT INTO "public"."universitas" VALUES (102303, 495003, 'POLITEKNIK STIA LAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (102304, 504001, 'AKADEMI METROLOGI DAN INSTRUMENTASI');
INSERT INTO "public"."universitas" VALUES (102305, 513001, 'SEKOLAH TINGGI INTELIJEN NEGARA');
INSERT INTO "public"."universitas" VALUES (102306, 525001, 'POLITEKNIK PEKERJAAN UMUM');
INSERT INTO "public"."universitas" VALUES (102307, 535001, 'POLITEKNIK KETENAGAKERJAAN');
INSERT INTO "public"."universitas" VALUES (102308, NULL, 'UNIVERSITAS PGRI KANJURUHAN MALANG');
INSERT INTO "public"."universitas" VALUES (102309, 43376, 'Sekolah Tinggi Teknologi Industri Garut');
INSERT INTO "public"."universitas" VALUES (98339, 44161, 'AKADEMI KEBIDANAN BHAKTI BANGSA');
INSERT INTO "public"."universitas" VALUES (98340, 44162, 'AMIK BSI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98341, 44163, 'AMIK BSI BOGOR');
INSERT INTO "public"."universitas" VALUES (98342, 44164, 'AMIK BSI TANGERANG');
INSERT INTO "public"."universitas" VALUES (98343, 44165, 'AKADEMI KEBIDANAN YPSDMI');
INSERT INTO "public"."universitas" VALUES (98344, 44168, 'AKADEMI SEKRETARI DAN MANAJEMEN BSI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98345, 44169, 'AMIK BSI TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (98346, 44170, 'AKADEMI KEBIDANAN TRI DHARMA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98347, 44172, 'AKADEMI KEPERAWATAN YATNA YUANA LEBAK');
INSERT INTO "public"."universitas" VALUES (98348, 44173, 'AKADEMI KEPERAWATAN ISLAMIC VILLAGE');
INSERT INTO "public"."universitas" VALUES (98349, 44174, 'AKADEMI KEBIDANAN ISMA HUSADA CIREBON');
INSERT INTO "public"."universitas" VALUES (98350, 44175, 'AKADEMI KEBIDANAN BHAKTI ASIH PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (98351, 44176, 'AKADEMI PERPAJAKAN MARIA MEDIATRIX');
INSERT INTO "public"."universitas" VALUES (98352, 44177, 'AKADEMI KEBIDANAN BHAKTI HUSADA CIKARANG');
INSERT INTO "public"."universitas" VALUES (98353, 44180, 'AKADEMI KEPERAWATAN BHAKTI KENCANA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98354, 44182, 'AKADEMI KEBIDANAN GEMA NUSANTARA BEKASI');
INSERT INTO "public"."universitas" VALUES (98355, 44184, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER BOGOR');
INSERT INTO "public"."universitas" VALUES (98356, 44185, 'AKADEMI KEPERAWATAN DHARMA HUSADA CIREBON');
INSERT INTO "public"."universitas" VALUES (98357, 44186, 'AKADEMI FARMASI AL-ISHLAH CILEGON');
INSERT INTO "public"."universitas" VALUES (98358, 44187, 'AKADEMI RADIOGNOSTIK DAN RADIOTERAPI YAPENPERNUS');
INSERT INTO "public"."universitas" VALUES (98359, 44188, 'AKADEMI KEBIDANAN AR-RAHMAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (98360, 44189, 'AKADEMI PARIWISATA BOGOR BHI');
INSERT INTO "public"."universitas" VALUES (98361, 44190, 'AKADEMI KEBIDANAN BHAKTI PURNA HUSADA');
INSERT INTO "public"."universitas" VALUES (98362, 44191, 'AKADEMI KEBIDANAN PELITA ILMU DEPOK');
INSERT INTO "public"."universitas" VALUES (98363, 44192, 'AKADEMI KEBIDANAN LA TANSA MASHIRO');
INSERT INTO "public"."universitas" VALUES (98364, 44193, 'AKADEMI KEBIDANAN CIANJUR');
INSERT INTO "public"."universitas" VALUES (98365, 44194, 'AKADEMI REFRAKSI OPTISI POLYCORE INDONESIA');
INSERT INTO "public"."universitas" VALUES (98366, 44195, 'AKADEMI KEBIDANAN MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (98367, 44196, 'AKADEMI KEBIDANAN PRIMA HUSADA');
INSERT INTO "public"."universitas" VALUES (98368, 44197, 'AKADEMI KEBIDANAN CITAMA RAYA DEPOK');
INSERT INTO "public"."universitas" VALUES (98369, 44198, 'AKADEMI KEBIDANAN BHAKTI MITRA HUSADA');
INSERT INTO "public"."universitas" VALUES (98370, 44199, 'AKADEMI KEBIDANAN SUKA WANGI BEKASI');
INSERT INTO "public"."universitas" VALUES (98371, 44200, 'AKADEMI KEBIDANAN SYAHIDA KOMUNIKA');
INSERT INTO "public"."universitas" VALUES (98372, 44201, 'AKADEMI KEBIDANAN BHAKTI NUGRAHA');
INSERT INTO "public"."universitas" VALUES (98373, 44202, 'AKADEMI KEBIDANAN WIJAYA HUSADA BOGOR');
INSERT INTO "public"."universitas" VALUES (98374, 44203, 'AKADEMI PARIWISATA NUSANTARA TANGERANG');
INSERT INTO "public"."universitas" VALUES (98375, 44204, 'AKADEMI KEBIDANAN BUNDA AUNI BOGOR');
INSERT INTO "public"."universitas" VALUES (98376, 44205, 'AKADEMI PERDAGANGAN CATUR INSAN CENDEKIA');
INSERT INTO "public"."universitas" VALUES (98377, 44206, 'AKADEMI KEBIDANAN PRIMA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98378, 44207, 'AKADEMI KEPERAWATAN AL-IKHLAS CISARUA');
INSERT INTO "public"."universitas" VALUES (98379, 44208, 'AKADEMI KEBIDANAN AL-IKHLAS CISARUA');
INSERT INTO "public"."universitas" VALUES (98380, 44210, 'AKADEMI FARMASI MUHAMMADIYAH CIREBON');
INSERT INTO "public"."universitas" VALUES (98381, 44211, 'AKADEMI KEBIDANAN BAKTI INDONESIA BOGOR');
INSERT INTO "public"."universitas" VALUES (98382, 44214, 'AKADEMI KEBIDANAN BOGOR HUSADA');
INSERT INTO "public"."universitas" VALUES (98383, 44215, 'AKADEMI KEBIDANAN SENTRA BINA YUDISTIRA TANGERANG');
INSERT INTO "public"."universitas" VALUES (98384, 44216, 'AKADEMI KEBIDANAN AISYIYAH BANDUNG');
INSERT INTO "public"."universitas" VALUES (98385, 44217, 'AKADEMI KEBIDANAN DEWI SARTIKA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98386, 44219, 'AKADEMI KEBIDANAN BINA HUSADA SERANG');
INSERT INTO "public"."universitas" VALUES (98387, 44220, 'AKADEMI KEBIDANAN TIARA BUNDA');
INSERT INTO "public"."universitas" VALUES (98388, 44221, 'AKADEMI KEBIDANAN RESPATI');
INSERT INTO "public"."universitas" VALUES (98389, 44222, 'AMIK BSI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98390, 44223, 'AKADEMI KEBIDANAN SAYID SABIQ INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98391, 44224, 'AKADEMI KEBIDANAN MEDICA OBGIN');
INSERT INTO "public"."universitas" VALUES (98392, 44225, 'AKADEMI KEBIDANAN GRAHA HUSADA CIREBON');
INSERT INTO "public"."universitas" VALUES (98393, 44226, 'AKADEMI KEBIDANAN WIJAYA HUSADA');
INSERT INTO "public"."universitas" VALUES (98394, 44227, 'AKADEMI FARMASI MUHAMMADIYAH KABUPATEN KUNINGAN');
INSERT INTO "public"."universitas" VALUES (98395, 44228, 'AKADEMI KEBIDANAN BANDUNG');
INSERT INTO "public"."universitas" VALUES (98396, 44229, 'AKADEMI KEBIDANAN BHAKTI ASIH CILEDUK');
INSERT INTO "public"."universitas" VALUES (98397, 44230, 'AKADEMI KEPERAWATAN RS EFARINA');
INSERT INTO "public"."universitas" VALUES (98398, 44231, 'AKADEMI KEBIDANAN CIPTA DAYA HUSADA');
INSERT INTO "public"."universitas" VALUES (98399, 44232, 'AMIK BSI KARAWANG');
INSERT INTO "public"."universitas" VALUES (98400, 44233, 'AMIK MAPAN TANGERANG');
INSERT INTO "public"."universitas" VALUES (98401, 44234, 'AKADEMI KEPERAWATAN BIDARA MUKTI');
INSERT INTO "public"."universitas" VALUES (98402, 44235, 'AKADEMI PERPAJAKAN PADANG (AKAP) BEKASI');
INSERT INTO "public"."universitas" VALUES (98403, 44236, 'AKADEMI PARIWISATA (AKPAR) BINA SARANA INFORMATIKA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98404, 44237, 'AKADEMI AKUNTANSI KEUANGAN DAN PERBANKAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (98405, 44238, 'AKADEMI FARMASI YPF');
INSERT INTO "public"."universitas" VALUES (98406, 44239, 'AKADEMI FARMASI BUMI SILIWANGI');
INSERT INTO "public"."universitas" VALUES (98407, 44240, 'AKADEMI MANAJEMEN BISNIS BINA DARMA SWAKARYA');
INSERT INTO "public"."universitas" VALUES (98408, 44241, 'AKADEMI KEBIDANAN ANNISA JAYA');
INSERT INTO "public"."universitas" VALUES (98409, 44242, 'AKADEMI MANAJEMEN GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (98410, 45002, 'POLITEKNIK PAJAJARAN INSAN CINTA BANGSA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98411, 45003, 'POLITEKNIK GAJAH TUNGGAL');
INSERT INTO "public"."universitas" VALUES (98412, 45004, 'POLITEKNIK BINA BUDAYA CIPTA');
INSERT INTO "public"."universitas" VALUES (98413, 45006, 'POLITEKNIK KRAKATAU');
INSERT INTO "public"."universitas" VALUES (98414, 45008, 'POLITEKNIK KOMPUTER NIAGA LPKIA');
INSERT INTO "public"."universitas" VALUES (98415, 45009, 'POLITEKNIK POS INDONESIA');
INSERT INTO "public"."universitas" VALUES (98416, 45010, 'POLITEKNIK PIKSI INPUT SERANG');
INSERT INTO "public"."universitas" VALUES (98417, 45011, 'POLITEKNIK MANUFAKTUR IGASA PINDAD');
INSERT INTO "public"."universitas" VALUES (98418, 45012, 'POLITEKNIK TRI MITRA KARYA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98419, 45013, 'POLITEKNIK LP3I BANDUNG');
INSERT INTO "public"."universitas" VALUES (98420, 45016, 'POLITEKNIK TEDC');
INSERT INTO "public"."universitas" VALUES (98421, 45018, 'POLITEKNIK PRAKTISI BANDUNG');
INSERT INTO "public"."universitas" VALUES (98422, 45019, 'POLITEKNIK GUNAKARYA INDONESIA BEKASI');
INSERT INTO "public"."universitas" VALUES (98423, 45020, 'POLITEKNIK SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98424, 45021, 'POLITEKNIK MITRA KUSUMA');
INSERT INTO "public"."universitas" VALUES (98425, 45022, 'POLITEKNIK AGROINDUSTRI');
INSERT INTO "public"."universitas" VALUES (98426, 45023, 'POLITEKNIK PERDANA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98427, 45025, 'POLITEKNIK KENT');
INSERT INTO "public"."universitas" VALUES (99755, 93120, 'STISIPOL MUJAHIDIN');
INSERT INTO "public"."universitas" VALUES (99756, 93121, 'SEKOLAH TINGGI ILMU EKONOMI MUJAHIDIN');
INSERT INTO "public"."universitas" VALUES (99757, 93122, 'STIMIK BINA BANGSA');
INSERT INTO "public"."universitas" VALUES (99758, 93123, 'SEKOLAH TINGGI ILMU PERTANIAN MUHAMMADIYAH SINJAI');
INSERT INTO "public"."universitas" VALUES (99759, 93124, 'SEKOLAH TINGGI TEKNOLOGI MEKONGGA');
INSERT INTO "public"."universitas" VALUES (99760, 93125, 'STMIK CATUR SAKTI KENDARI');
INSERT INTO "public"."universitas" VALUES (99761, 93126, 'STIKES GEMA INSAN AKADEMIK');
INSERT INTO "public"."universitas" VALUES (99762, 93127, 'SEKOLAH TINGGI ILMU PERTANIAN YAPIM MAROS');
INSERT INTO "public"."universitas" VALUES (99763, 93128, 'STISIP MUHAMMADIYAH SINJAI');
INSERT INTO "public"."universitas" VALUES (99764, 93129, 'STIMED NUSA PALAPA');
INSERT INTO "public"."universitas" VALUES (99765, 93130, 'SEKOLAH TINGGI PARIWISATA TAMALATEA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99766, 93131, 'STMIK SAMUDRA BITUNG');
INSERT INTO "public"."universitas" VALUES (99767, 93132, 'STMIK MULTICOM BOLAAN MONGONDOW');
INSERT INTO "public"."universitas" VALUES (99768, 93133, 'SEKOLAH TINGGI ILMU PARIWISATA MANADO');
INSERT INTO "public"."universitas" VALUES (99769, 93134, 'SEKOLAH TINGGI ILMU KESEHATAN YAPIKA');
INSERT INTO "public"."universitas" VALUES (99770, 93135, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA KOMPUTER LAMAPPAPOLEONRO SOPPENG');
INSERT INTO "public"."universitas" VALUES (99771, 93137, 'SEKOLAH TINGGI PERIKANAN DAN KELAUTAN PALU');
INSERT INTO "public"."universitas" VALUES (99772, 93138, 'SEKOLAH TINGGI ILMU KESEHATAN NANI HASANUDDIN');
INSERT INTO "public"."universitas" VALUES (99773, 93139, 'SEKOLAH TINGGI ILMU ADMINISTRASI ABDUL HARIS');
INSERT INTO "public"."universitas" VALUES (99774, 93140, 'SEKOLAH TINGGI ILMU KESEHATAN BINA BANGSA MAJENE');
INSERT INTO "public"."universitas" VALUES (99775, 93141, 'SEKOLAH TINGGI ILMU KESEHATAN BARAMULI');
INSERT INTO "public"."universitas" VALUES (99776, 93142, 'SEKOLAH TINGGI TEKNOLOGI NUSANTARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (99777, 93143, 'SEKOLAH TINGGI ILMU FARMASI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99778, 93144, 'SEKOLAH TINGGI ILMU KESEHATAN TANA TORAJA');
INSERT INTO "public"."universitas" VALUES (99779, 93145, 'SEKOLAH TINGGI ILMU KESEHATAN MEGA REZKY');
INSERT INTO "public"."universitas" VALUES (99780, 93146, 'SEKOLAH TINGGI ILMU KEPERAWATAN GUNUNG SARI');
INSERT INTO "public"."universitas" VALUES (99781, 93147, 'SEKOLAH TINGGI ILMU KESEHATAN MANDALA WALUYA KENDARI');
INSERT INTO "public"."universitas" VALUES (99782, 93148, 'STIKES TANAWALI TAKALAR');
INSERT INTO "public"."universitas" VALUES (99783, 93149, 'STIKES BHAKTI PERTIWI LUWU RAYA');
INSERT INTO "public"."universitas" VALUES (99784, 93150, 'STIKES BINA GENERASI POLEWALI MANDAR');
INSERT INTO "public"."universitas" VALUES (99785, 93151, 'STIKES KURNIA JAYA PERSADA');
INSERT INTO "public"."universitas" VALUES (99786, 93152, 'STIKES PANAKKUKANG');
INSERT INTO "public"."universitas" VALUES (99787, 93153, 'STKIP DARUD DA WAH WAL IRSYAD MAMUJU');
INSERT INTO "public"."universitas" VALUES (99788, 93154, 'STKIP DARUD DA WAH WAL IRSYAD PINRANG');
INSERT INTO "public"."universitas" VALUES (99789, 93155, 'STIKES LAKIPADADA');
INSERT INTO "public"."universitas" VALUES (99790, 93156, 'STIKES GRAHA EDUKASI');
INSERT INTO "public"."universitas" VALUES (99791, 93157, 'SEKOLAH TINGGI ILMU KESEHATAN STELLA MARIS MAKASAR');
INSERT INTO "public"."universitas" VALUES (99792, 93158, 'STIKES NUSANTARA LASINRANG');
INSERT INTO "public"."universitas" VALUES (99793, 93159, 'STIKES RSU DAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99794, 93160, 'SEKOLAH TINGGI ILMU KOMPUTER RAJAWALI');
INSERT INTO "public"."universitas" VALUES (99795, 93161, 'STIKES MARENDENG MAJENE');
INSERT INTO "public"."universitas" VALUES (99796, 93163, 'SEKOLAH TINGGI ILMU KESEHATAN ST FATIMAH');
INSERT INTO "public"."universitas" VALUES (99797, 93164, 'SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH MANADO');
INSERT INTO "public"."universitas" VALUES (99798, 93165, 'SEKOLAH TINGGI ILMU MANAJEMEN DAN BISNIS GORONTALO');
INSERT INTO "public"."universitas" VALUES (99799, 93166, 'STMIK AKBA');
INSERT INTO "public"."universitas" VALUES (99800, 93167, 'SEKOLAH TINGGI ILMU EKONOMI PELITA BUANA');
INSERT INTO "public"."universitas" VALUES (99801, 93168, 'STISIP BINA GENERASI POLEWALI');
INSERT INTO "public"."universitas" VALUES (99802, 93169, 'STIKES ANDINI PERSADA');
INSERT INTO "public"."universitas" VALUES (99803, 93170, 'SEKOLAH TINGGI ILMU KESEHATAN WIDYA NUSANTARA PALU');
INSERT INTO "public"."universitas" VALUES (99804, 93171, 'STIKES AMANAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99805, 93172, 'SEKOLAH TINGGI ILMU KESEHATAN PANRITA HUSADA');
INSERT INTO "public"."universitas" VALUES (99806, 93173, 'STIKES PUANGRIMANGGALATUNG');
INSERT INTO "public"."universitas" VALUES (99807, 93174, 'STIKES MEGA BUANA PALOPO');
INSERT INTO "public"."universitas" VALUES (99808, 93175, 'STIKES MUHAMMADIYAH SIDRAP');
INSERT INTO "public"."universitas" VALUES (99809, 93176, 'STIKES IST BUTON');
INSERT INTO "public"."universitas" VALUES (99810, 93177, 'STMIK PROFESIONAL MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99811, 93178, 'STIKES BATARAGURU SOROAKA');
INSERT INTO "public"."universitas" VALUES (99812, 93179, 'SEKOLAH TINGGI ILMU HUKUM DAN HAM');
INSERT INTO "public"."universitas" VALUES (99813, 93180, 'STIKES GRAHA MEDIKA');
INSERT INTO "public"."universitas" VALUES (99814, 93181, 'SEKOLAH TINGGI ILMU KESEHATAN KARYA KESEHATAN');
INSERT INTO "public"."universitas" VALUES (99815, 93182, 'SEKOLAH TINGGI ILMU KESEHATAN HUSADA MANDIRI POSO');
INSERT INTO "public"."universitas" VALUES (99816, 93183, 'STIKES NUSANTARA JAYA');
INSERT INTO "public"."universitas" VALUES (99817, 93184, 'STIM BOALEMO');
INSERT INTO "public"."universitas" VALUES (99818, 93185, 'STIKES BINA MANDIRI GORONTALO');
INSERT INTO "public"."universitas" VALUES (99819, 93186, 'STIKES BAKTI NUSANTARA GORONTALO');
INSERT INTO "public"."universitas" VALUES (99820, 93187, 'SEKOLAH TINGGI BISNIS DAN MANAJEMEN DUA SAUDARA');
INSERT INTO "public"."universitas" VALUES (99821, 93188, 'STKIP MEGA REZKY');
INSERT INTO "public"."universitas" VALUES (99822, 93189, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER BINA ADINATA');
INSERT INTO "public"."universitas" VALUES (99823, 93190, 'SEKOLAH TINGGI ILMU KESEHATAN PELAMONIA KESDAM VII WIRABUANA');
INSERT INTO "public"."universitas" VALUES (99824, 93191, 'STIK TRINITA MANADO');
INSERT INTO "public"."universitas" VALUES (99825, 93192, 'SEKOLAH TINGGI ILMU KESEHATAN BUDI MULIA');
INSERT INTO "public"."universitas" VALUES (99826, 93193, 'STMIK HASAN SULUR WONOMULYO');
INSERT INTO "public"."universitas" VALUES (99827, 93194, 'STKIP PELITA NUSANTARA BUTON');
INSERT INTO "public"."universitas" VALUES (99828, 93195, 'SEKOLAH TINGGI ILMU HUKUM DAN POLITIK PALU');
INSERT INTO "public"."universitas" VALUES (99829, 93196, 'SEKOLAH TINGGI ILMU KESEHATAN SALEWANGANG MAROS');
INSERT INTO "public"."universitas" VALUES (99830, 93197, 'STKIP MUHAMMADIYAH PALOPO');
INSERT INTO "public"."universitas" VALUES (99831, 93198, 'STIK IMANUEL INDONESIA');
INSERT INTO "public"."universitas" VALUES (99832, 93199, 'SEKOLAH TINGGI ILMU MARITIM MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99833, 93200, 'SEKOLAH TINGGI ILMU KESEHATAN DATU KAMANRE');
INSERT INTO "public"."universitas" VALUES (99834, 93201, 'STKIP TOMAKAKA TIWIKRAMA');
INSERT INTO "public"."universitas" VALUES (99835, 93202, 'STKIP DAMPAL SELATAN');
INSERT INTO "public"."universitas" VALUES (99836, 93203, 'SEKOLAH TINGGI ILMU KESEHATAN TRINITA');
INSERT INTO "public"."universitas" VALUES (99837, 93204, 'SEKOLAH TINGGI ILMU KESEHATAN SURIFATRI KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (99838, 93205, 'SEKOLAH TINGGI ILMU KOMPUTER 22 JANUARI KENDARI');
INSERT INTO "public"."universitas" VALUES (99839, 93206, 'STIKES SHINTA JAYA MAMUJU');
INSERT INTO "public"."universitas" VALUES (99840, 93207, 'STIKES PELITA IBU');
INSERT INTO "public"."universitas" VALUES (99841, 93208, 'SEKOLAH TINGGI ILMU KESEHATAN GUNUNG SARI');
INSERT INTO "public"."universitas" VALUES (101161, 213213, 'STAI DARULLUGHAH WADDA''WAH BANGIL, PASURUAN');
INSERT INTO "public"."universitas" VALUES (101162, 213214, 'STAI DARUSSALAM (STAIDA) BLOKAGUNG TEGALSARI BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (101163, 213215, 'SEKOLAH TINGGI AGAMA ISLAM DARUTTAQWA MANYAR GRESIK');
INSERT INTO "public"."universitas" VALUES (101164, 213216, 'STAI DIPONEGORO TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (101165, 213217, 'STAI HASANUDDIN PARE KEDIRI');
INSERT INTO "public"."universitas" VALUES (101166, 213218, 'STAI IBRAHIMY GENTENG BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (101167, 213219, 'STAI IHYAUL ULUM GRESIK');
INSERT INTO "public"."universitas" VALUES (101168, 213220, 'STAI LUQMAN AL-HAKIM (STAIL) SURABAYA');
INSERT INTO "public"."universitas" VALUES (101169, 213221, 'STAI MADIUN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101170, 213222, 'STAI MA`HAD ALY AL-HIKAM MALANG');
INSERT INTO "public"."universitas" VALUES (101171, 213223, 'STAI MIFTAHUL ULA NGLAWAK KERTOSONO, NGANJUK');
INSERT INTO "public"."universitas" VALUES (101172, 213224, 'STAI MIFTAHUL ULUM PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101173, 213225, 'STAI MUHAMMADIYAH (STAIM) BIMA');
INSERT INTO "public"."universitas" VALUES (101174, 213226, 'STAI MUHAMMADIYAH PACIRAN, LAMONGAN');
INSERT INTO "public"."universitas" VALUES (101175, 213227, 'STAI MUHAMMADIYAH PROBOLINGGO');
INSERT INTO "public"."universitas" VALUES (101176, 213228, 'STAI MUHAMMADIYAH TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (101177, 213229, 'STAI NAHDLATUL ULAMA (STAINU) PACITAN');
INSERT INTO "public"."universitas" VALUES (101178, 213230, 'STAI NAHDLATUL WATHAN SAMAWA SUMBAWA BESAR NTB');
INSERT INTO "public"."universitas" VALUES (101179, 213231, 'STAI NAZHATUT THULLAB SAMPANG MADURA');
INSERT INTO "public"."universitas" VALUES (101180, 213232, 'STAI NURUL HAKIM KEDIRI LOMBOK BARAT NTB');
INSERT INTO "public"."universitas" VALUES (101181, 213233, 'STAI PANCAWAHANA (STAIPANA) BANGIL, PASURUAN');
INSERT INTO "public"."universitas" VALUES (101182, 213234, 'STAI QOMARUDDIN GRESIK');
INSERT INTO "public"."universitas" VALUES (101183, 213235, 'STAI RADEN RAHMAT KEPANJEN MALANG');
INSERT INTO "public"."universitas" VALUES (101184, 213236, 'SEKOLAH TINGGI AGAMA ISLAM SALAHUDDIN (STAIS) PASURUAN');
INSERT INTO "public"."universitas" VALUES (101185, 213237, 'STAI SUNAN DRAJAT LAMONGAN');
INSERT INTO "public"."universitas" VALUES (101186, 213238, 'STAI SUNAN GIRI BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (101187, 213239, 'STAI SYAICHONA MOH. CHOLIL BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101188, 213240, 'STAI SYARIFUDDIN (STAIS) LUMAJANG JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101189, 213241, 'STAI TARUNA SURABAYA');
INSERT INTO "public"."universitas" VALUES (101190, 213242, 'STAI TASWIRUL AFKAR SURABAYA');
INSERT INTO "public"."universitas" VALUES (101191, 213243, 'STAI YPBWI SURABAYA');
INSERT INTO "public"."universitas" VALUES (101192, 213244, 'STAI ZAINUL HASAN GENGGONG KRAKSAN PROBOLINGGO');
INSERT INTO "public"."universitas" VALUES (101193, 213245, 'STID AL-HADID SURABAYA');
INSERT INTO "public"."universitas" VALUES (101194, 213246, 'STID MUSTAFA IBRAHIM AL-ISHLAHUDDINY KEDIRI LOMBOK BARAT NTB');
INSERT INTO "public"."universitas" VALUES (101195, 213247, 'STIS AL-ITTIHAD BIMA YAYASAN PENDIDIKAN AL-ITIHAD BIMA NTB');
INSERT INTO "public"."universitas" VALUES (101196, 213248, 'STIS AL-WAHIDIYAH KEDIRI JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101197, 213249, 'STIS SENTRA BISNIS ISLAMI SURABAYA');
INSERT INTO "public"."universitas" VALUES (101198, 213250, 'STIT AL-AZHAR SIDOARJO');
INSERT INTO "public"."universitas" VALUES (101199, 213251, 'SEKOLAH TINGGI ILMU TARBIYAH AL-FATTAH SIMAN LAMONGAN');
INSERT INTO "public"."universitas" VALUES (101200, 213252, 'STIT AL-ISHLAH BONDOWOSO');
INSERT INTO "public"."universitas" VALUES (101201, 213253, 'STIT AL-MUSLIHUN TLOGO KANAIGORO BLITAR');
INSERT INTO "public"."universitas" VALUES (101202, 213254, 'STIT AL-URWATUL WUTSQO JOMBANG');
INSERT INTO "public"."universitas" VALUES (101203, 213255, 'SEKOLAH TINGGI IILMU TARBIYAH AQIDAH USYMUNI SUMENEP');
INSERT INTO "public"."universitas" VALUES (101204, 213256, 'STIT DARUSSALIMIN NAHDLATUL WATHAN PRAYA LOMBOK TENGAH NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (101205, 213257, 'STIT IBNU SINA MALANG');
INSERT INTO "public"."universitas" VALUES (101206, 213258, 'STIT ISLAMIYAH KARYA PEMBANGUNAN PARON NGAWI');
INSERT INTO "public"."universitas" VALUES (101207, 213259, 'STIT JEMBRANA BALI');
INSERT INTO "public"."universitas" VALUES (101208, 213260, 'STIT MAKHDUM IBRAHIM (STITMA) TUBAN');
INSERT INTO "public"."universitas" VALUES (101209, 213261, 'STIT MASKUMAMBANG GRESIK');
INSERT INTO "public"."universitas" VALUES (101210, 213262, 'STIT MIFTAHUL ULUM BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101211, 213263, 'STIT MUHAMMADIYAH BANGIL, PASURUAN');
INSERT INTO "public"."universitas" VALUES (101212, 213264, 'STIT MUHAMMADIYAH BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (101213, 213265, 'STIT MUHAMMADIYAH KEDIRI');
INSERT INTO "public"."universitas" VALUES (101214, 213266, 'STIT MUHAMMADIYAH LUMAJANG');
INSERT INTO "public"."universitas" VALUES (101215, 213267, 'STIT MUHAMMADIYAH MOJOSARI MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (101216, 213268, 'STIT MUHAMMADIYAH PACITAN');
INSERT INTO "public"."universitas" VALUES (101217, 213269, 'STIT MUHAMMADIYAH TEMPUREJO NGAWI');
INSERT INTO "public"."universitas" VALUES (101218, 213270, 'STIT MUHAMMADIYAH TRENGGALEK');
INSERT INTO "public"."universitas" VALUES (101219, 213271, 'STIT PGRI PASURUAN');
INSERT INTO "public"."universitas" VALUES (101220, 213272, 'STIT RADEN SANTRI GRESIK');
INSERT INTO "public"."universitas" VALUES (101221, 213273, 'STIT RADEN WIJAYA MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (101222, 213274, 'STIT SUNAN GIRI BIMA, NTB');
INSERT INTO "public"."universitas" VALUES (101223, 213275, 'STIT SUNAN GIRI TRENGGALEK');
INSERT INTO "public"."universitas" VALUES (101224, 213276, 'STIT ULUWIYAH MOJOSARI MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (101225, 213277, 'STAI ALMUSLIM BIREUN');
INSERT INTO "public"."universitas" VALUES (101226, 213278, 'STAI AL-WASHLIYAH BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (101227, 213279, 'STAI AR-RAHMAN ACEH SELATAN');
INSERT INTO "public"."universitas" VALUES (101228, 213280, 'STAI NUSANTARA KOTA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (101229, 213281, 'SEKOLAH TINGGI AGAMA ISLAM PERGURUAN TINGGI ILMU AL-QUR''AN (STAI-PTIQ) ACEH');
INSERT INTO "public"."universitas" VALUES (101230, 213282, 'STAI SEPAKAT SEGENEP KUTACANE ACEH TENGGARA');
INSERT INTO "public"."universitas" VALUES (101231, 213283, 'STAI SYEKH ABDUR RAUF SINGKIL');
INSERT INTO "public"."universitas" VALUES (101232, 213284, 'STAI TEUNGKU DIRUNDENG MEULABOH ACEH BARAT');
INSERT INTO "public"."universitas" VALUES (101233, 213285, 'STAI TGK. CHIK PANTE KULU KOTA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (101234, 213286, 'STIS AL-HILAL SIGLI KAB. PIDIE');
INSERT INTO "public"."universitas" VALUES (101235, 213287, 'STAI JAMIATUT TARBIYAH LHOKSUKON ACEH UTARA');
INSERT INTO "public"."universitas" VALUES (101236, 213288, 'STIT PTI AL-HILAL SIGLI KAB. PIDIE');
INSERT INTO "public"."universitas" VALUES (101237, 213289, 'STAI AL-HIKMAH PARIANGAN BATUSANGKAR, TANAH DATAR');
INSERT INTO "public"."universitas" VALUES (101238, 213290, 'STAI MADRASAH `ARABIYAH (STAIMA) BAYANG, PESISIR SELATAN, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101239, 213291, 'STAI PENGEMBANGAN ILMU AL-QUR`AN (STAIPIQ), KOTA PADANG, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101240, 213292, 'STAI SOLOK NAN INDAH, KOTA PADANG');
INSERT INTO "public"."universitas" VALUES (101241, 213293, 'STAI UMAR BIN KHATTAB DI UJUNGGADING, PASAMAN BARAT, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101242, 213294, 'STAI BALAISELASA YPPTI PESISIR SELATAN, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (98428, 45027, 'POLITEKNIK PIKSI GANESHA');
INSERT INTO "public"."universitas" VALUES (98429, 45028, 'POLITEKNIK PGRI BANTEN');
INSERT INTO "public"."universitas" VALUES (98430, 45029, 'POLITENIK KESEHATAN YAPKESBI SUKABUMI');
INSERT INTO "public"."universitas" VALUES (98431, 45030, 'POLITEKNIK AL-ISLAM BANDUNG');
INSERT INTO "public"."universitas" VALUES (98432, 45031, 'POLITEKNIK KRIDATAMA BANDUNG');
INSERT INTO "public"."universitas" VALUES (98433, 45032, 'POLITEKNIK KELAPA SAWIT CITRA WIDYA EDUKASI');
INSERT INTO "public"."universitas" VALUES (98434, 45033, 'POLITEKNIK KESEHATAN BHAKTI PERTIWI HUSADA');
INSERT INTO "public"."universitas" VALUES (98435, 45034, 'POLITEKNIK KESEHATAN TNI-AU CIUMBULEUIT');
INSERT INTO "public"."universitas" VALUES (98436, 45035, 'POLITEKNIK TELKOM');
INSERT INTO "public"."universitas" VALUES (98437, 45036, 'POLITEKNIK GEOLOGI DAN PERTAMBANGAN AGP');
INSERT INTO "public"."universitas" VALUES (98438, 45037, 'POLITEKNIK TRIGUNA TASIKMALAYA');
INSERT INTO "public"."universitas" VALUES (98439, 45038, 'POLITEKNIK INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (98440, 45041, 'POLITEKNIK TUNAS PEMUDA');
INSERT INTO "public"."universitas" VALUES (98441, 45042, 'POLITEKNIK ENJINERING INDORAMA');
INSERT INTO "public"."universitas" VALUES (98442, 45043, 'POLITEKNIK META INDUSTRI CIKARANG');
INSERT INTO "public"."universitas" VALUES (98443, 45044, 'POLITEKNIK PARIWISATA PRIMA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (98444, 45045, 'POLITEKNIK KESEHATAN AISYIYAH BANTEN');
INSERT INTO "public"."universitas" VALUES (98445, 45046, 'POLITEKNIK BHAKTI ASIH PURWAKARTA');
INSERT INTO "public"."universitas" VALUES (98446, 45047, 'POLITEKNIK SAINS SENI REKAKRESI');
INSERT INTO "public"."universitas" VALUES (98448, 45049, 'POLITEKNIK TIARA BUNDA');
INSERT INTO "public"."universitas" VALUES (98449, 45050, 'POLITEKNIK BHAKTI KARTINI');
INSERT INTO "public"."universitas" VALUES (98450, 45051, 'POLITEKNIK KESEHATAN GENESIS MEDICARE');
INSERT INTO "public"."universitas" VALUES (98451, 46001, 'AKADEMI KOMUNITAS MULTISTRADA');
INSERT INTO "public"."universitas" VALUES (98452, 46002, 'AKADEMI KOMUNITAS TOYOTA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98453, 46003, 'AKADEMI KOMUNITAS PRESIDEN');
INSERT INTO "public"."universitas" VALUES (98454, 46004, 'AKADEMI KOMUNITAS INSAN TAZAKKA');
INSERT INTO "public"."universitas" VALUES (98455, 46005, 'AKADEMI KOMUNITAS QURROTA A''YUN');
INSERT INTO "public"."universitas" VALUES (98456, 51001, 'UNIVERSITAS ISLAM INDONESIA');
INSERT INTO "public"."universitas" VALUES (98457, 51002, 'UNIVERSITAS SARJANAWIYATA TAMANSISWA');
INSERT INTO "public"."universitas" VALUES (98458, 51003, 'UNIVERSITAS JANABADRA');
INSERT INTO "public"."universitas" VALUES (98459, 51004, 'UNIVERSITAS PROKLAMASI 45');
INSERT INTO "public"."universitas" VALUES (98460, 51005, 'UNIVERSITAS ATMA JAYA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98461, 51006, 'UNIVERSITAS COKROAMINOTO');
INSERT INTO "public"."universitas" VALUES (98462, 51007, 'UNIVERSITAS MUHAMMADIYAH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98463, 51008, 'UNIVERSITAS WIDYA MATARAM');
INSERT INTO "public"."universitas" VALUES (98464, 51010, 'UNIVERSITAS KRISTEN IMMANUEL');
INSERT INTO "public"."universitas" VALUES (98465, 51011, 'UNIVERSITAS KRISTEN DUTA WACANA');
INSERT INTO "public"."universitas" VALUES (98466, 51012, 'UNIVERSITAS SANATA DHARMA');
INSERT INTO "public"."universitas" VALUES (98467, 51013, 'UNIVERSITAS AHMAD DAHLAN');
INSERT INTO "public"."universitas" VALUES (98468, 51014, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN');
INSERT INTO "public"."universitas" VALUES (98469, 51015, 'UNIVERSITAS PGRI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98470, 51017, 'UNIVERSITAS GUNUNG KIDUL');
INSERT INTO "public"."universitas" VALUES (98471, 51018, 'UNIVERSITAS TEKNOLOGI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98472, 51019, 'UNIVERSITAS MERCU BUANA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98473, 51020, 'UNIVERSITAS RESPATI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98474, 51021, 'UNIVERSITAS ALMA ATA');
INSERT INTO "public"."universitas" VALUES (98475, 51022, 'UNIVERSITAS AISYIYAH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98476, 51023, 'UNIVERSITAS NAHDLATUL ULAMA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98477, 51024, 'UNIVERSITAS AMIKOM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98478, 51025, 'UNIVERSITAS JENDERAL ACHMAD YANI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98479, 51026, 'UNIVERSITAS MAHAKARYA ASIA');
INSERT INTO "public"."universitas" VALUES (98480, 52001, 'IKIP PGRI WATES');
INSERT INTO "public"."universitas" VALUES (98481, 52002, 'INSTITUT PERTANIAN (INTAN) YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98482, 52003, 'INSTITUT SAINS DAN TEKNOLOGI AKPRIND');
INSERT INTO "public"."universitas" VALUES (98483, 52004, 'INSTITUT PERTANIAN STIPER');
INSERT INTO "public"."universitas" VALUES (98484, 52005, 'INSTITUT TEKNOLOGI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98485, 52006, 'INSTITUT TEKNOLOGI NASIONAL YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98486, 53001, 'STIKIP CATUR SAKTI');
INSERT INTO "public"."universitas" VALUES (98487, 53002, 'SEKOLAH TINGGI TEKNOLOGI NASIONAL');
INSERT INTO "public"."universitas" VALUES (98488, 53003, 'SEKOLAH TINGGI ILMU EKONOMI YKPN');
INSERT INTO "public"."universitas" VALUES (98489, 53004, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA WIWAHA');
INSERT INTO "public"."universitas" VALUES (98490, 53005, 'SEKOLAH TINGGI ILMU EKONOMI NUSA MEGAR KENCANA');
INSERT INTO "public"."universitas" VALUES (98491, 53006, 'STISIP KARTIKA BANGSA');
INSERT INTO "public"."universitas" VALUES (98492, 53007, 'SEKOLAH TINGGI TEKNIK LINGKUNGAN');
INSERT INTO "public"."universitas" VALUES (98493, 53008, 'SEKOLAH TINGGI ILMU EKONOMI KERJA SAMA');
INSERT INTO "public"."universitas" VALUES (98494, 53009, 'SEKOLAH TINGGI PEMBANGUNAN MASYARAKAT DESA APMD');
INSERT INTO "public"."universitas" VALUES (98495, 53010, 'STMIK AKAKOM');
INSERT INTO "public"."universitas" VALUES (98496, 53012, 'SEKOLAH TINGGI ILMU EKONOMI SBI');
INSERT INTO "public"."universitas" VALUES (98497, 53013, 'SEKOLAH TINGGI ILMU EKONOMI MITRA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98498, 53014, 'SEKOLAH TINGGI ILMU EKONOMI BISNIS DAN PERBANKAN');
INSERT INTO "public"."universitas" VALUES (98499, 53015, 'SEKOLAH TINGGI ILMU EKONOMI YKP');
INSERT INTO "public"."universitas" VALUES (98500, 53017, 'SEKOLAH TINGGI ILMU EKONOMI ISTI EKATANA UPAWEDA');
INSERT INTO "public"."universitas" VALUES (98501, 53018, 'SEKOLAH TINGGI TEKNOLOGI KEDIRGANTARAAN');
INSERT INTO "public"."universitas" VALUES (98502, 53019, 'SEKOLAH TINGGI ILMU ADMINISTRASI AAN');
INSERT INTO "public"."universitas" VALUES (98503, 53020, 'SEKOLAH TINGGI PARIWISATA AMPTA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98504, 53021, 'STMIK AMIKOM');
INSERT INTO "public"."universitas" VALUES (98505, 53022, 'SEKOLAH TINGGI ILMU EKONOMI PARIWISATA API');
INSERT INTO "public"."universitas" VALUES (98506, 53023, 'SEKOLAH TINGGI BAHASA ASING LIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98507, 53024, 'SEKOLAH TINGGI TEKNOLOGI ADISUTJIPTO');
INSERT INTO "public"."universitas" VALUES (98508, 53025, 'STMIK EL RAHMA');
INSERT INTO "public"."universitas" VALUES (98509, 53026, 'STMIK PROACTIVE');
INSERT INTO "public"."universitas" VALUES (98510, 53027, 'SEKOLAH TINGGI ILMU KESEHATAN WIRA HUSADA');
INSERT INTO "public"."universitas" VALUES (98511, 53028, 'SEKOLAH TINGGI PSIKOLOGI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98512, 53029, 'STMIK PELITA NUSANTARA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98513, 53030, 'SEKOLAH TINGGI ILMU KESEHATAN SURYA GLOBAL');
INSERT INTO "public"."universitas" VALUES (98514, 53031, 'SEKOLAH TINGGI TEKNOLOGI INFORMASI RESPATI');
INSERT INTO "public"."universitas" VALUES (98515, 53032, 'SEKOLAH TINGGI ILMU KESEHATAN RESPATI');
INSERT INTO "public"."universitas" VALUES (98516, 53033, 'SEKOLAH TINGGI ILMU KESEHATAN AISYIYAH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98517, 53034, 'SEKOLAH TINGGI ILMU MANAJEMEN YKPN');
INSERT INTO "public"."universitas" VALUES (99842, 93209, 'SEKOLAH TINGGI ILMU EKONOMI ICHSAN SIDENRENG RAPPANG');
INSERT INTO "public"."universitas" VALUES (99843, 93210, 'SEKOLAH TINGGI ILMU EKONOMI DAN BISNIS INSAN MADANI MANDAR');
INSERT INTO "public"."universitas" VALUES (99844, 93211, 'SEKOLAH TINGGI ILMU EKONOMI CIPUTRA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99845, 94001, 'AKADEMI BAHASA ASING UMI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99846, 94002, 'AKADEMI MARITIM INDONESIA AIPI');
INSERT INTO "public"."universitas" VALUES (99847, 94003, 'AKADEMI MANAJEMEN PERPAJAKAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99848, 94004, 'AKADEMI BAHASA ASING ATMAJAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99849, 94005, 'AKADEMI ILMU GIZI YPAG MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99850, 94006, 'AKADEMI PARIWISATA YPAG MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99851, 94007, 'AKADEMI SEKRETARI MANAJEMEN INDONESIA PUBLIK');
INSERT INTO "public"."universitas" VALUES (99852, 94008, 'AKADEMI MARITIM INDONESIA VETERAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99853, 94010, 'AKADEMI SEKRETARI MANAJEMEN ATMAJAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99854, 94011, 'AKADEMI PARIWISATA MANADO');
INSERT INTO "public"."universitas" VALUES (99855, 94012, 'AKADEMI TEKNIK KENDARI');
INSERT INTO "public"."universitas" VALUES (99856, 94013, 'AKADEMI MARITIM INDONESIA BITUNG');
INSERT INTO "public"."universitas" VALUES (99857, 94014, 'AMIK RIZKY MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99858, 94015, 'AKADEMI KEPERAWATAN MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99859, 94018, 'AKADEMI TEKNIK SOROAKO');
INSERT INTO "public"."universitas" VALUES (99860, 94019, 'AMIK TRI DHARMA PALU');
INSERT INTO "public"."universitas" VALUES (99861, 94020, 'AKADEMI PARIWISATA AIR MADIDI');
INSERT INTO "public"."universitas" VALUES (99862, 94021, 'AKADEMI KEUANGAN PERBANKAN TAHUNA');
INSERT INTO "public"."universitas" VALUES (99863, 94022, 'AMIK MILAN KENDARI');
INSERT INTO "public"."universitas" VALUES (99864, 94023, 'AKADEMI SEKRETARI MANAJEMEN INDONESIA KLABAT');
INSERT INTO "public"."universitas" VALUES (99865, 94024, 'AMIK YAPENAS KENDARI');
INSERT INTO "public"."universitas" VALUES (99866, 94025, 'AMIK IBNU KHALDUN PALOPO');
INSERT INTO "public"."universitas" VALUES (99867, 94026, 'AMIK CATUR SAKTI KENDARI');
INSERT INTO "public"."universitas" VALUES (99868, 94027, 'AMIK MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99869, 94029, 'AKADEMI SEKRETARI MANAJEMEN INDONESIA LPI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99870, 94030, 'AKADEMI SEKRETARI MANAJEMEN AMSIR PARE-PARE');
INSERT INTO "public"."universitas" VALUES (99871, 94031, 'AKADEMI TEKNIK PRATAMA MAKALE');
INSERT INTO "public"."universitas" VALUES (99872, 94032, 'AMIK PROFESIONAL MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99873, 94034, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER GLOBAL');
INSERT INTO "public"."universitas" VALUES (99874, 94036, 'AKADEMI HIPERKES MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99875, 94037, 'AMIK PARNARAYA MANADO');
INSERT INTO "public"."universitas" VALUES (99876, 94038, 'AKADEMI TEKNOLOGI INDUSTRI DEWANTARA PALOPO');
INSERT INTO "public"."universitas" VALUES (101291, 213344, 'STAI DDI PINRANG, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (99877, 94040, 'AKADEMI KETATALAKSANAAN PELAYARAN NIAGA DAN KEPELABUHAN KENDARI');
INSERT INTO "public"."universitas" VALUES (99878, 94041, 'AMIK LAMAPPAPOLEONRO SOPPENG');
INSERT INTO "public"."universitas" VALUES (99879, 94042, 'AKADEMI BAHASA ASING BARAKATI KENDARI');
INSERT INTO "public"."universitas" VALUES (99880, 94043, 'AKADEMI ANALIS KIMIA YAPIKA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99881, 94046, 'AKADEMI PERTAMBANGAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99882, 94047, 'AMIK TOMAKAKA');
INSERT INTO "public"."universitas" VALUES (99883, 94048, 'AMIK MIKENIUM KOLAKA');
INSERT INTO "public"."universitas" VALUES (99884, 94049, 'AKADEMI FARMASI BINA HUSADA KENDARI');
INSERT INTO "public"."universitas" VALUES (99885, 94050, 'AKADEMI KEPERAWATAN YAPENAS 21 MAROS');
INSERT INTO "public"."universitas" VALUES (99886, 94051, 'AKADEMI KEBIDANAN SALEWANGAN MAROS');
INSERT INTO "public"."universitas" VALUES (99887, 94052, 'AKADEMI KEPERAWATAN NUSANTARA JAYA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99888, 94053, 'ASMI SHITA PALU');
INSERT INTO "public"."universitas" VALUES (99889, 94054, 'AKADEMI KOMPUTER MALL CENDIKIA');
INSERT INTO "public"."universitas" VALUES (99890, 94055, 'AKADEMI TEKNIK OTOMOTIVE MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99891, 94056, 'AMIK LUWUK BANGGAI');
INSERT INTO "public"."universitas" VALUES (99892, 94057, 'AKADEMI KEPERAWATAN BARAMULI');
INSERT INTO "public"."universitas" VALUES (99893, 94058, 'AKADEMI KEBIDANAN BINA SEJAHTERA');
INSERT INTO "public"."universitas" VALUES (99894, 94059, 'AKADEMI KEPERAWATAN YPPP WONOMULYO');
INSERT INTO "public"."universitas" VALUES (99895, 94060, 'AKADEMI PARAWISATA KENDARI');
INSERT INTO "public"."universitas" VALUES (99896, 94061, 'AKADEMI KEPERAWATAN KAMANRE');
INSERT INTO "public"."universitas" VALUES (99897, 94062, 'AKADEMI KEPERAWATAN KHARISMA GOWA RAYA');
INSERT INTO "public"."universitas" VALUES (99898, 94063, 'AKADEMI KEPERAWATAN BATARI TOJA');
INSERT INTO "public"."universitas" VALUES (99899, 94064, 'AKADEMI KEPERAWATAN REFORMASI');
INSERT INTO "public"."universitas" VALUES (99900, 94065, 'AKADEMI KEBIDANAN SANDI KARSA');
INSERT INTO "public"."universitas" VALUES (99901, 94066, 'AKADEMI KEPERAWATAN SANDI KARSA');
INSERT INTO "public"."universitas" VALUES (99902, 94067, 'AKADEMI KEPERAWATAN PUTRA PERTIWI');
INSERT INTO "public"."universitas" VALUES (99903, 94068, 'AKADEMI KEPERAWATAN YAPI');
INSERT INTO "public"."universitas" VALUES (99904, 94069, 'AKADEMI KEPERAWATAN RANTEPAO');
INSERT INTO "public"."universitas" VALUES (99905, 94070, 'AKADEMI KEPERAWATAN FATIMA MAMUJU');
INSERT INTO "public"."universitas" VALUES (99906, 94071, 'AKADEMI KEPERAWATAN MAKASAR');
INSERT INTO "public"."universitas" VALUES (99907, 94072, 'AKADEMI KEBIDANAN MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99908, 94073, 'AKADEMI KEBIDANAN PALU SULAWESI TENGAH');
INSERT INTO "public"."universitas" VALUES (99909, 94074, 'AKADEMI KEPERAWATAN AL-HAMBRA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99910, 94075, 'AKADEMI KEBIDANAN PELITA IBU KENDARI');
INSERT INTO "public"."universitas" VALUES (99911, 94076, 'AKADEMI KEPERAWATAN TOTABUAN KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (99912, 94077, 'AKADEMI KEBIDANAN YAPMA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99913, 94078, 'AKADEMI KEBIDANAN BAKTI NUSANTARA RANTEPAO');
INSERT INTO "public"."universitas" VALUES (99914, 94079, 'AKADEMI ANALIS KESEHATAN KENDARI');
INSERT INTO "public"."universitas" VALUES (99915, 94080, 'AKADEMI KEBIDANAN KAMANRE PALOPO');
INSERT INTO "public"."universitas" VALUES (99916, 94081, 'AKADEMI KEBIDANAN SYEKH YUSUF GOWA');
INSERT INTO "public"."universitas" VALUES (99917, 94082, 'AKADEMI KEBIDANAN MINASA UPA');
INSERT INTO "public"."universitas" VALUES (99918, 94083, 'AKADEMI KEBIDANAN MADANI SINJAI');
INSERT INTO "public"."universitas" VALUES (99919, 94084, 'AKADEMI KEBIDANAN KONAWE');
INSERT INTO "public"."universitas" VALUES (99920, 94085, 'AKADEMI KEBIDANAN MUHAMMADIYAH PALOPO');
INSERT INTO "public"."universitas" VALUES (99921, 94086, 'AKADEMI KEPERAWATAN SAWERIGADING PEMDA LUWU');
INSERT INTO "public"."universitas" VALUES (99922, 94090, 'AKADEMI KEPERAWATAN FATIMA PARE-PARE');
INSERT INTO "public"."universitas" VALUES (99923, 94091, 'AKADEMI KEPERAWATAN GUNUNG MARIA');
INSERT INTO "public"."universitas" VALUES (99924, 94092, 'AKADEMI TEKNIK ELEKTROMEDIK MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99925, 94094, 'AKADEMI FARMASI KEBANGSAAN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99926, 94095, 'AKTEK RADIODIAGNOSTIK & RADIOTERAPI MUHAMMADIYAH');
INSERT INTO "public"."universitas" VALUES (99927, 94096, 'AKADEMI KEPERAWATAN KABUPATEN WAJO SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (99928, 94097, 'AKADEMI KESEHATAN LINGKUNGAN MANDALA WALUYA');
INSERT INTO "public"."universitas" VALUES (99929, 94098, 'AKPER PUTRA PERTIWI WATANSOPPENG');
INSERT INTO "public"."universitas" VALUES (101243, 213295, 'STAI YAYASAN KEBANGKITAN ISLAM (YKI) SUMATERA BARAT, PADANG');
INSERT INTO "public"."universitas" VALUES (101244, 213296, 'STAI YAYASAN TARBIYAH ISLAMIYAH (YASTIS) LUBUK BAGALUNG PADANG');
INSERT INTO "public"."universitas" VALUES (101245, 213297, 'STAI YDI LUBUK SIKAPING, PASAMAN, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101246, 213298, 'STAI YPI AL-IKHLAS PAINAN, PESISIR SELATAN, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101247, 213299, 'STAI YPK IMAM BONJOL PADANG PANJANG, SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101248, 213301, 'STIT ADZKIA PADANG');
INSERT INTO "public"."universitas" VALUES (101249, 213302, 'STIT AHLUSSUNNAH BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (101250, 213303, 'STIT DINIYYAH PUTERI RAHMAH EL-YUNUSIYYAH KOTA PADANG PANJANG');
INSERT INTO "public"."universitas" VALUES (101251, 213304, 'STIT SYEKH BURHANUDDIN PARIAMAN');
INSERT INTO "public"."universitas" VALUES (101252, 213305, 'STAI YAPTIP SIMPANG EMPAT PASAMAN BARAT');
INSERT INTO "public"."universitas" VALUES (101253, 213306, 'STIT YPI AL-YAQIN MUARO SIJUNJUNG, SAWAHLUNTO');
INSERT INTO "public"."universitas" VALUES (101254, 213307, 'STIT YPI PAYAKUMBUH');
INSERT INTO "public"."universitas" VALUES (101255, 213308, 'STAI AN-NUR LAMPUNG SELATAN');
INSERT INTO "public"."universitas" VALUES (101256, 213309, 'SEKOLAH TINGGI AGAMA ISLAM ASH-SHIDDIQIYAH LEMPUING JAYA OKI');
INSERT INTO "public"."universitas" VALUES (101257, 213310, 'STAI BUMI SILAMPARI LUBUK LINGGAU, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101258, 213311, 'STAI MA`ARIF METRO, KOTA METRO, LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101259, 213312, 'STAI RAHMANIYAH (STAIR) SEKAYU, MUSI BANYUASIN, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101260, 213313, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) BATURAJA');
INSERT INTO "public"."universitas" VALUES (101261, 213314, 'STIS DARUSSALAM, LAMPUNG SELATAN, LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101262, 213315, 'IAI AGUS SALIM METRO LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101263, 213316, 'STIT AL-QURANIYAH, MANNA, BENGKULU SELATAN');
INSERT INTO "public"."universitas" VALUES (101264, 213317, 'STIT AL-QUR`AN AL-ITTIFAQIAH (STITQI) OGAN ILIR SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101265, 213318, 'STIT DARUL FATTAH BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101266, 213319, 'STAI DARUSSALAM LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101267, 213320, 'STIT IBNU RUSYD KOTA BUMI LAMPUNG UTARA');
INSERT INTO "public"."universitas" VALUES (101268, 213321, 'STIT MISBAHUL ULUM GUMAWANG BELITANG OKU TIMUR, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101269, 213322, 'STIT MUARA ENIM, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101270, 213323, 'STIT NURUL HUDA SUKARAJA OKU TIMUR, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101271, 213324, 'STIT PAGAR ALAM, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101272, 213325, 'STIT RAUDHATUL ULUM, SAKATIGA INDRALAYA, KOTA PALEMBANG, SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101273, 213326, 'STIT YPI LAHAT');
INSERT INTO "public"."universitas" VALUES (101274, 213327, 'STAI AL-AMANAH JENEPONTO, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101275, 213328, 'STAI AL-AZHARY MAMUJU, SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (101276, 213329, 'STAI AL-FURQAN MAKASSAR, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101277, 213330, 'STAI AL-GAZALI BONE, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101278, 213331, 'STAI AL-GHAZALI BARRU, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101279, 213332, 'STAI AL-GAZALI BULUKUMBA, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101280, 213333, 'STAI AL-GAZALI SOPPENG, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101281, 213334, 'STAI AL-MAHDI FAKFAK');
INSERT INTO "public"."universitas" VALUES (101282, 213335, 'STAI AL-MARDHIYAH MAJENE');
INSERT INTO "public"."universitas" VALUES (101283, 213336, 'STAI ASY-SYAFI`IYAH NABIRE');
INSERT INTO "public"."universitas" VALUES (101284, 213337, 'STAI AS`ADIYAH SENGKANG WAJO');
INSERT INTO "public"."universitas" VALUES (101285, 213338, 'STAI DDI JENEPONTO, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101286, 213339, 'STAI DDI KOTA MAKASSAR, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101287, 213340, 'STAI DDI MAJENE');
INSERT INTO "public"."universitas" VALUES (101288, 213341, 'STAI DDI MAROS, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101289, 213342, 'STAI DDI PANGKEP, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101290, 213343, 'STAI DDI PAREPARE, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101292, 213345, 'STAI DDI POLMAN, SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (101293, 213346, 'STAI DDI SIDRAP, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101294, 213347, 'STAI MUHAMMADIYAH SINJAI');
INSERT INTO "public"."universitas" VALUES (101295, 213348, 'STAI SAID PERINTAH MASOHI, MALUKU TENGAH, MALUKU');
INSERT INTO "public"."universitas" VALUES (101296, 213349, 'STAI SERAM TIMUR GESER, MALUKU');
INSERT INTO "public"."universitas" VALUES (101297, 213350, 'STAI SYARIF MUHAMMAD RAHA, MUNA, SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (101298, 213351, 'STAI YAMRA MERAUKE, PAPUA');
INSERT INTO "public"."universitas" VALUES (101299, 213352, 'STIT YAPIS MANOKWARI');
INSERT INTO "public"."universitas" VALUES (101300, 213353, 'STAI YAPIS TAKALAR, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101301, 213354, 'STAI YAPNAS JENEPONTO, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101302, 213355, 'STAI YPIQ BAUBAU, SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (101303, 213356, 'STAI DDI MANGKOSO, BARRU, SULAWESI SELATAN');
INSERT INTO "public"."universitas" VALUES (101304, 213357, 'STIS MUHAMMADIYAH TOLITOLI, SULAWESI TENGAH');
INSERT INTO "public"."universitas" VALUES (101305, 213358, 'STIT AS-SALAMA TUAL MALUKU TENGGARA, MALUKU');
INSERT INTO "public"."universitas" VALUES (101306, 213359, 'STIT DDI PASANGKAYU, MAMUJU, SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (101307, 213360, 'STAI AL-HIKMAH MEDAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101308, 213361, 'STAI AL-HIKMAH, TANJUNG BALAI, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101309, 213362, 'STIT AL-WASHLIYAH BINJAI');
INSERT INTO "public"."universitas" VALUES (101310, 213363, 'STAI DARUL ARAFAH (STAIDA) LAU BAKERI DELI SERDANG, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101311, 213364, 'STAI HIKMATUL FADHILAH MEDAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101312, 213365, 'STAI JAM`IYAH MAHMUDIYAH LANGKAT');
INSERT INTO "public"."universitas" VALUES (101313, 213366, 'STAI MADINA (STAIM) PANYABUNGAN, MANDAILING NATAL, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101314, 213367, 'STAI PERTINU PADANGSIDIMPUAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101315, 213368, 'STAI RAUDHATUL AKMAL, DELI SERDANG, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101316, 213369, 'STAI SAMORA PEMATANG SIANTAR, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101317, 213370, 'STAI SERDANG LUBUK PAKAM, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101318, 213371, 'STAI SUMATERA (STAIS) MEDAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (98518, 53035, 'SEKOLAH TINGGI ILMU KESEHATAN JENDERAL ACHMAD YANI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98519, 53036, 'SEKOLAH TINGGI ILMU KESEHATAN ALMA ATA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98520, 53037, 'SEKOLAH TINGGI PARIWISATA AMBARRUKMO YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98521, 53038, 'STMIK JENDERAL ACHMAD YANI');
INSERT INTO "public"."universitas" VALUES (98522, 53039, 'SEKOLAH TINGGI SENI RUPA DAN DESAIN VISI INDONESIA');
INSERT INTO "public"."universitas" VALUES (98523, 53040, 'SEKOLAH TINGGI ILMU KESEHATAN BETHESDA YAKKUM');
INSERT INTO "public"."universitas" VALUES (98524, 53041, 'STIKES YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98525, 53042, 'STIKES GUNA BANGSA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98526, 53043, 'STIKES AL-ISLAM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98527, 53044, 'SEKOLAH TINGGI ILMU KESEHATAN MADANI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98528, 53045, 'SEKOLAH TINGGI ILMU KESEHATAN PANTI RAPIH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98529, 53046, 'SEKOLAH TINGGI ILMU KESEHATAN AKBIDYO');
INSERT INTO "public"."universitas" VALUES (98530, 53047, 'SEKOLAH TINGGI ILMU KOMUNIKASI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98531, 53048, 'SEKOLAH TINGGI ILMU KESEHATAN NOTOKUSUMO YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98532, 53049, 'SEKOLAH TINGGI MARITIM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98533, 53050, 'SEKOLAH TINGGI ARSITEKTUR YKPN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98534, 53051, 'SEKOLAH TINGGI ILMU KESEHATAN JOGJA');
INSERT INTO "public"."universitas" VALUES (98535, 54001, 'AKADEMI AKUNTANSI YKPN');
INSERT INTO "public"."universitas" VALUES (98536, 54002, 'AKADEMI KESEJAHTERAAN SOSIAL TARAKANITA');
INSERT INTO "public"."universitas" VALUES (98537, 54003, 'AKADEMI BAHASA ASING YIPK YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98538, 54004, 'AKADEMI KEUANGAN DAN PERBANKAN YIPK');
INSERT INTO "public"."universitas" VALUES (98539, 54005, 'AKADEMI TEKNIK YKPN');
INSERT INTO "public"."universitas" VALUES (98540, 54006, 'AKADEMI MANAJEMEN PUTRA JAYA');
INSERT INTO "public"."universitas" VALUES (98541, 54007, 'AKADEMI KESEJAHTERAAN SOSIAL AKK');
INSERT INTO "public"."universitas" VALUES (98542, 54009, 'AKADEMI SEKRETARI DAN MANAJEMEN INDONESIA BANTUL');
INSERT INTO "public"."universitas" VALUES (98543, 54010, 'AKADEMI PARIWISATA BUANA WISATA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98544, 54011, 'AKADEMI PETERNAKAN BRAHMA PUTRA');
INSERT INTO "public"."universitas" VALUES (98545, 54012, 'AKADEMI MARITIM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98546, 54013, 'AKADEMI KOMUNIKASI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98547, 54014, 'AKADEMI KETATALAKSANAAN PELAYARAN NIAGA BAHTERA');
INSERT INTO "public"."universitas" VALUES (98548, 54015, 'AKADEMI PERTANIAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98549, 54016, 'ASM MARSUDIRINI SANTA MARIA');
INSERT INTO "public"."universitas" VALUES (98550, 54017, 'AKADEMI PERIKANAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98551, 54018, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER ASTER');
INSERT INTO "public"."universitas" VALUES (98552, 54020, 'AKADEMI PARIWISATA INDRAPRASTA');
INSERT INTO "public"."universitas" VALUES (98553, 54021, 'AMIK WIRA SETYA MULYA');
INSERT INTO "public"."universitas" VALUES (98554, 54022, 'AKADEMI SEKRETARI DAN MANAJEMEN DESANTA');
INSERT INTO "public"."universitas" VALUES (98555, 54023, 'AKADEMI TEKNIK PIRI');
INSERT INTO "public"."universitas" VALUES (98556, 54024, 'AKADEMI TELEKOMUNIKASI INDONESIA SLEMAN');
INSERT INTO "public"."universitas" VALUES (98557, 54025, 'AKADEMI AKUNTANSI SAPTA WIDYA TAMA');
INSERT INTO "public"."universitas" VALUES (98558, 54026, 'AKADEMI PARIWISATA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98559, 54027, 'AKADEMI KOMUNIKASI INDONESIA YPK');
INSERT INTO "public"."universitas" VALUES (98560, 54028, 'AKADEMI PARIWISATA DHARMA NUSANTARA SAKTI');
INSERT INTO "public"."universitas" VALUES (98561, 54029, 'AKADEMI TEKNOLOGI OTOMOTIF NASIONAL');
INSERT INTO "public"."universitas" VALUES (98562, 54030, 'AKADEMI PARIWISATA STIPARY');
INSERT INTO "public"."universitas" VALUES (98563, 54031, 'AKADEMI MARITIM GANESHA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98564, 54035, 'AKADEMI KOMUNIKASI RADYA BINATAMA');
INSERT INTO "public"."universitas" VALUES (98565, 54036, 'AKADEMI SENI RUPA DAN DESAIN AKSERI');
INSERT INTO "public"."universitas" VALUES (98566, 54039, 'AKADEMI MANAJEMEN ADMINISTRASI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98567, 54041, 'AKADEMI SENI RUPA DAN DESAIN MSD');
INSERT INTO "public"."universitas" VALUES (98568, 54043, 'AKADEMI MANAJEMEN ADMINISTRASI YPK YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98569, 54044, 'AKADEMI FISIOTERAPI YAB YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98570, 54046, 'AKADEMI MANAJEMEN ADMINISTRASI DHARMALA');
INSERT INTO "public"."universitas" VALUES (98571, 54047, 'AMIK BSI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98572, 54048, 'AKADEMI ANALIS FARMASI AL-ISLAM');
INSERT INTO "public"."universitas" VALUES (98573, 54050, 'AKADEMI KEBIDANAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98574, 54055, 'AKADEMI KEPERAWATAN YKY YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98575, 54056, 'AKADEMI PARIWISATA BSI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98576, 54057, 'AKADEMI KEPERAWATAN PANTI RAPIH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98577, 54060, 'AKADEMI KEPERAWATAN NOTOKUSUMO');
INSERT INTO "public"."universitas" VALUES (98578, 54061, 'AKADEMI ANALIS KESEHATAN MANGGALA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98579, 54062, 'AKADEMI KEBIDANAN UMMI KHASANAH');
INSERT INTO "public"."universitas" VALUES (98580, 54063, 'AKADEMI PERAWATAN KARYA BAKTI HUSADA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98581, 54064, 'AKADEMI KEBIDANAN NYAI AHMAD DAHLAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98582, 54065, 'AKADEMI BAHASA ASING SINEMA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98583, 54066, 'AKADEMI KESEHATAN KARYA HUSADA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98584, 54067, 'AKADEMI FARMASI INDONESIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98585, 54068, 'AKADEMI TEKNIK RADIODIAGNOSTIK DAN RADIOTERAPI (ATRO)');
INSERT INTO "public"."universitas" VALUES (98586, 54069, 'AKADEMI FILM YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98587, 54070, 'AKADEMI KEBIDANAN MULIA MADANI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98588, 55001, 'POLITEKNIK API YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98589, 55002, 'POLITEKNIK LPP YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98590, 55003, 'POLITEKNIK PPKP');
INSERT INTO "public"."universitas" VALUES (98591, 55004, 'POLITEKNIK YDHI');
INSERT INTO "public"."universitas" VALUES (98592, 55006, 'POLITEKNIK SENI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98593, 55007, 'POLITEKNIK MUHAMMADIYAH YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98594, 55008, 'POLITEKNIK KESEHATAN BHAKTI SETYA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98595, 55009, 'POLITEKNIK KESEHATAN PERMATA INDONESIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98596, 55010, 'POLITEKNIK MEKATRONIKA SANATA DHARMA');
INSERT INTO "public"."universitas" VALUES (98597, 55011, 'POLITEKNIK KESEHATAN TNI AU ADISUTJIPTO');
INSERT INTO "public"."universitas" VALUES (98598, 55012, 'POLITEKNIK KESEHATAN KARYA HUSADA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98599, 56001, 'AKADEMI KOMUNITAS PERKEBUNAN YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (98600, 61001, 'UNIVERSITAS KRISTEN SATYA WACANA');
INSERT INTO "public"."universitas" VALUES (98601, 61002, 'UNIVERSITAS ISLAM SULTAN AGUNG');
INSERT INTO "public"."universitas" VALUES (99930, 94099, 'AKADEMI KEPERAWATAN LAPATAU BONE');
INSERT INTO "public"."universitas" VALUES (99931, 94100, 'AKADEMI KEPERAWATAN BETHESDA TOMOHON');
INSERT INTO "public"."universitas" VALUES (99932, 94101, 'AKADEMI KEPERAWATAN PPNI KENDARI');
INSERT INTO "public"."universitas" VALUES (99933, 94102, 'AKADEMI KEPERAWATAN JUSTITIA');
INSERT INTO "public"."universitas" VALUES (99934, 94103, 'AKADEMI FARMASI MEDIKA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99935, 94104, 'AKADEMI KEBIDANAN NUSANTARA JAYA');
INSERT INTO "public"."universitas" VALUES (99936, 94105, 'AKADEMI KEBIDANAN BATARI TOJA');
INSERT INTO "public"."universitas" VALUES (99937, 94106, 'AKADEMI KEBIDANAN BUNDA KOTAMOBAGU');
INSERT INTO "public"."universitas" VALUES (99938, 94107, 'AKADEMI KEBIDANAN LAPATAU BONE');
INSERT INTO "public"."universitas" VALUES (99939, 94108, 'AKADEMI KESEHATAN GIGI KENDARI');
INSERT INTO "public"."universitas" VALUES (99940, 94109, 'AKADEMI KEBIDANAN PERSADA WAJO');
INSERT INTO "public"."universitas" VALUES (99941, 94110, 'AKADEMI ANALIS KESEHATAN MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99942, 94111, 'AKADEMI KEBIDANAN BINA SEHAT NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99943, 94112, 'AKADEMI KEBIDANAN ANDI MAKKASAU');
INSERT INTO "public"."universitas" VALUES (99944, 94113, 'AKADEMI FARMASI SANDI KARSA');
INSERT INTO "public"."universitas" VALUES (99945, 94114, 'AKADEMI KESEHATAN LINGKUNGAN MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99946, 94115, 'AKADEMI KEBIDANAN DIAN HARAPAN');
INSERT INTO "public"."universitas" VALUES (99947, 94116, 'AKADEMI KEBIDANAN INAU');
INSERT INTO "public"."universitas" VALUES (99948, 94117, 'AKADEMI KEBIDANAN SINAR KASIH TORAJA');
INSERT INTO "public"."universitas" VALUES (99949, 94118, 'AKADEMI KEBIDANAN SUMBER KASIH ENREKANG');
INSERT INTO "public"."universitas" VALUES (99950, 94119, 'AKADEMI KEBIDANAN TRINITA MANADO');
INSERT INTO "public"."universitas" VALUES (99951, 94120, 'AKADEMI KEPERAWATAN TORAYA');
INSERT INTO "public"."universitas" VALUES (99952, 94121, 'AKADEMI KEBIDANAN PRIMA SENGKANG');
INSERT INTO "public"."universitas" VALUES (99953, 94122, 'AKADEMI KEBIDANAN TAHIRAH AL BAETI BULUKUMBA');
INSERT INTO "public"."universitas" VALUES (99954, 94123, 'AKADEMI KEBIDANAN MASAMBA');
INSERT INTO "public"."universitas" VALUES (99955, 94124, 'AKADEMI KEBIDANAN MAYAPADA GADING PERSADA');
INSERT INTO "public"."universitas" VALUES (99956, 94125, 'AKADEMI KEBIDANAN GRAHA ANANDA');
INSERT INTO "public"."universitas" VALUES (99957, 94126, 'AKADEMI KEBIDANAN MENARA PRIMADANI');
INSERT INTO "public"."universitas" VALUES (99958, 94127, 'AKADEMI KEBIDANAN PELAMONIA KESDAM VIIWIRABUANA');
INSERT INTO "public"."universitas" VALUES (99959, 94128, 'AKADEMI KEBIDANAN HAJI AMIRULLAH');
INSERT INTO "public"."universitas" VALUES (99960, 94129, 'AKADEMI KEBIDANAN MENARA BUNDA');
INSERT INTO "public"."universitas" VALUES (99961, 94130, 'AKADEMI KEPERAWATAN METUARI WAYA MANADO');
INSERT INTO "public"."universitas" VALUES (99962, 94131, 'AKADEMI KEBIDANAN YAYASAN KESEHATAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (99963, 94132, 'AKADEMI KEBIDANAN PARAMATA RAHA');
INSERT INTO "public"."universitas" VALUES (99964, 94133, 'AKADEMI KEBIDANAN BAMBAPUANG PRIMA PERSADA');
INSERT INTO "public"."universitas" VALUES (99965, 94134, 'AKADEMI KEBIDANAN AISYAH KABUPATEN PANGKEP');
INSERT INTO "public"."universitas" VALUES (99966, 94135, 'AKADEMI KEBIDANAN BUTON RAYA');
INSERT INTO "public"."universitas" VALUES (99967, 94136, 'AKADEMI KEBIDANAN REFORMASI');
INSERT INTO "public"."universitas" VALUES (99968, 94137, 'AKADEMI KEBIDANAN GRAHA RABITA ANUGERAH');
INSERT INTO "public"."universitas" VALUES (99969, 94138, 'AKADEMI KEPERAWATAN RUMKIT TINGKAT III MANADO');
INSERT INTO "public"."universitas" VALUES (99970, 94139, 'AKADEMI KEPERAWATAN PELAMONIA KESDAM VII/ WIRABUANA');
INSERT INTO "public"."universitas" VALUES (99971, 94140, 'AKADEMI KEPERAWATAN BALA KESELAMATAN');
INSERT INTO "public"."universitas" VALUES (99972, 94141, 'AKADEMI FARMASI TADULAKO FARMA');
INSERT INTO "public"."universitas" VALUES (99973, 94142, 'AKADEMI FARMASI YAMASI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99974, 94143, 'AKPER MAPPA OUDANG MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99975, 94144, 'AKADEMI FISIOTERAPI ST LUKAS TOMOHON');
INSERT INTO "public"."universitas" VALUES (99976, 94145, 'AKADEMI KEBIDANAN GUNUNG SARI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99977, 94146, 'AKADEMI FARMASI TORAJA');
INSERT INTO "public"."universitas" VALUES (99978, 94147, 'AKADEMI FARMASI BINA FARMASI');
INSERT INTO "public"."universitas" VALUES (99979, 94148, 'AKADEMI TENAGA KESEHATAN BAUBAU');
INSERT INTO "public"."universitas" VALUES (99980, 94149, 'AKADEMI KEPERAWATAN SYEKH YUSUF GOWA');
INSERT INTO "public"."universitas" VALUES (99981, 94150, 'AKADEMI MARITIM PALOPO');
INSERT INTO "public"."universitas" VALUES (99982, 95001, 'POLITEKNIK INTERNASIONAL INDONESIA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99983, 95002, 'POLITEKNIK INFORMATIKA NASIONAL');
INSERT INTO "public"."universitas" VALUES (99984, 95003, 'POLITEKNIK NUSA UTARA');
INSERT INTO "public"."universitas" VALUES (99985, 95004, 'POLITEKNIK GORONTALO');
INSERT INTO "public"."universitas" VALUES (99986, 95005, 'POLITEKNIK PALU');
INSERT INTO "public"."universitas" VALUES (99987, 95006, 'POLITEKNIK INDOTEC KENDARI');
INSERT INTO "public"."universitas" VALUES (99988, 95007, 'POLITEKNIK BOSOWA');
INSERT INTO "public"."universitas" VALUES (99989, 95008, 'POLITEKNIK MARITIM AMI MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99990, 95009, 'POLITEKNIK BAUBAU');
INSERT INTO "public"."universitas" VALUES (99991, 95010, 'POLITEKNIK BINA HUSADA KENDARI');
INSERT INTO "public"."universitas" VALUES (99992, 95011, 'POLITEKNIK KESEHATAN MUHAMMADIYAH MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99993, 95012, 'POLITEKNIK SANDI KARSA');
INSERT INTO "public"."universitas" VALUES (99994, 95013, 'POLITEKNIK NUSANTARA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (99995, 95014, 'POLITEKNIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (99996, 95015, 'POLITEKNIK KARYA PERSADA MUNA');
INSERT INTO "public"."universitas" VALUES (99997, 96001, 'AKADEMI KOMUNITAS DEWINATALIA');
INSERT INTO "public"."universitas" VALUES (99998, 96002, 'AKADEMI KOMUNITAS MAPANAWANG MANADO');
INSERT INTO "public"."universitas" VALUES (99999, 101001, 'UNIVERSITAS BUNG HATTA');
INSERT INTO "public"."universitas" VALUES (100000, 101002, 'UNIVERSITAS MUHAMMADIYAH SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100001, 101003, 'UNIVERSITAS EKASAKTI');
INSERT INTO "public"."universitas" VALUES (100002, 101004, 'UNIVERSITAS MAHAPUTRA MUHAMMAD YAMIN');
INSERT INTO "public"."universitas" VALUES (100003, 101005, 'UNIVERSITAS TAMANSISWA');
INSERT INTO "public"."universitas" VALUES (100004, 101006, 'UNIVERSITAS ISLAM RIAU');
INSERT INTO "public"."universitas" VALUES (100005, 101007, 'UNIVERSITAS LANCANG KUNING');
INSERT INTO "public"."universitas" VALUES (100006, 101008, 'UNIVERSITAS BATANGHARI JAMBI');
INSERT INTO "public"."universitas" VALUES (100007, 101009, 'UNIVERSITAS BAITURRAHMAH');
INSERT INTO "public"."universitas" VALUES (100008, 101010, 'UNIVERSITAS BATAM');
INSERT INTO "public"."universitas" VALUES (100009, 101011, 'UNIVERSITAS INTERNASIONAL BATAM');
INSERT INTO "public"."universitas" VALUES (100010, 101012, 'UNIVERSITAS PUTRA INDONESIA YPTK PADANG');
INSERT INTO "public"."universitas" VALUES (100011, 101013, 'UNIVERSITAS ABDURRAB');
INSERT INTO "public"."universitas" VALUES (100012, 101014, 'UNIVERSITAS RIAU KEPULAUAN');
INSERT INTO "public"."universitas" VALUES (100013, 101015, 'UNIVERSITAS MARITIM RAJA ALI HAJI');
INSERT INTO "public"."universitas" VALUES (100014, 101016, 'UNIVERSITAS MUARA BUNGO');
INSERT INTO "public"."universitas" VALUES (100015, 101017, 'UNIVERSITAS ISLAM INDRAGIRI');
INSERT INTO "public"."universitas" VALUES (100016, 101018, 'UNIVERSITAS MUHAMMADIYAH RIAU');
INSERT INTO "public"."universitas" VALUES (100017, 101019, 'UNIVERSITAS PUTERA BATAM');
INSERT INTO "public"."universitas" VALUES (100018, 101020, 'UNIVERSITAS KARIMUN');
INSERT INTO "public"."universitas" VALUES (100019, 101021, 'UNIVERSITAS PASIR PENGARAIAN');
INSERT INTO "public"."universitas" VALUES (100020, 101022, 'UNIVERSITAS ISLAM SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100021, 101023, 'UNIVERSITAS ISLAM KUANTAN SINGINGI');
INSERT INTO "public"."universitas" VALUES (100022, 101024, 'UNIVERSITAS DHARMA ANDALAS');
INSERT INTO "public"."universitas" VALUES (101319, 213372, 'STAI SYEKH H. ABDUL HALIM HASAN AL-ISLAHIYAH BINJAI, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101320, 213373, 'STAI TAPANULI (STAITA) PADANGSIDEMPUAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101321, 213374, 'STAI TEBING TINGGI DELI, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101322, 213375, 'STAI UISU, PEMATANG SIANTAR, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101323, 213376, 'STIT GUNUNG TUA, PADANG LAWAS UTARA, TAPANULI SELATAN, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101324, 213377, 'STIT HAMZAH AL-FANSURI SIBOLGA BARUS (STIT HASIBA) TAPANULI TENGAH, SUMATERA UTA');
INSERT INTO "public"."universitas" VALUES (101325, 213378, 'STIT MUHAMMADIYAH SIBOLGA, TAPANULI TENGAH, SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101326, 213379, 'SEKOLAH TINGGI ILMU DAKWAH SURAKARTA (STIDS)');
INSERT INTO "public"."universitas" VALUES (101327, 213380, 'SEKOLAH TINGGI ISLAM KENDAL (STIK)');
INSERT INTO "public"."universitas" VALUES (101328, 213381, 'STAI AL-HUSAIN MAGELANG (STI AIH), JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101329, 213382, 'STAI AL-MUHAMMAD CEPU');
INSERT INTO "public"."universitas" VALUES (101330, 213383, 'STAI AN-NAWAWI PURWOREJO');
INSERT INTO "public"."universitas" VALUES (101331, 213384, 'STAI BAKTI NEGARA TEGAL');
INSERT INTO "public"."universitas" VALUES (101332, 213385, 'STAI BREBES, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101333, 213386, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) KHOZINATUL ULUM, BLORA, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101334, 213387, 'STAI MAMBA`UL ULUM SURAKARTA (STAIMUS)');
INSERT INTO "public"."universitas" VALUES (101335, 213388, 'STAI MUHAMMADIYAH (STAIM) BLORA, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101336, 213389, 'STAI MUHAMMADIYAH (STAIM) KLATEN, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101337, 213390, 'STAI NAHDLATUL ULAMA (STAINU) KEBUMEN, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101338, 213391, 'STAI NAHDLATUL ULAMA PURWOREJO');
INSERT INTO "public"."universitas" VALUES (101339, 213392, 'STAI NAHDLATUL ULAMA (STAINU), TEMANGGUNG, JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101340, 213393, 'STAI PATI (STAIP), JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101341, 213394, 'STAI WALISEMBILAN SEMARANG (SETIAWS), JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101342, 213395, 'STIT MUHAMMADIYAH KENDAL');
INSERT INTO "public"."universitas" VALUES (101343, 213396, 'STIT PEMALANG');
INSERT INTO "public"."universitas" VALUES (101344, 213397, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) MADANI BANJARMASIN, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101345, 213398, 'SEKOLAH TINGGI ILMU QUR`AN (STIQ) AMUNTAI, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101346, 213399, 'STAI AL-FALAH BANJARBARU, BANJARMASIN KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101347, 213400, 'STAI AL-HAUDL KETAPANG, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101348, 213401, 'STAI AL-JAMI BANJARMASIN, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101349, 213402, 'STAI AL-WASHLIYAH BARABAI');
INSERT INTO "public"."universitas" VALUES (101350, 213403, 'STAI BALIKPAPAN, KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101351, 213404, 'STIT DARUL HIJRAH MARTAPURA');
INSERT INTO "public"."universitas" VALUES (101352, 213405, 'STAI DARUL ULUM KANDANGAN, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101353, 213406, 'STAI DARUSSALAM MARTAPURA, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101354, 213407, 'STAI KUALA KAPUAS, KALIMANTAN TENGAH');
INSERT INTO "public"."universitas" VALUES (101355, 213408, 'STAI MA`ARIF SINTANG, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101356, 213409, 'STAI RASYIDIYAH KHALIDIYAH (RAKHA) AMUNTAI, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101357, 213410, 'STAI SITI KHADIJAH MUARA TEWEH BARITO UTARA, KALIMANTAN TENGAH');
INSERT INTO "public"."universitas" VALUES (101358, 213411, 'STAI SULTHAN M. SYAFI`UDDIN SAMBAS, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101359, 213412, 'STIS HIDAYATULLAH BALIKPAPAN, KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101360, 213413, 'STIS SAMARINDA, KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101361, 213414, 'STIS SYARIF ABDURRAHMAN PONTIANAK, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101362, 213415, 'STIT DARUL ULUM KOTABARU, KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101363, 213416, 'SEKOLAH TINGGI ILMU TARBIYAH IBNU KHALDUN');
INSERT INTO "public"."universitas" VALUES (101364, 213417, 'STIT IBNU RUSYD GROGOT PASER, KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101365, 213418, 'STIT IQRA` KAPUAS HULU, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101366, 213420, 'STIT MUHAMMADIYAH TANJUNG REDEP, BERAU, KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101367, 213421, 'STIT SYARIF ABDURRAHMAN SINGKAWANG, KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101368, 213422, 'STIT AL FALAH');
INSERT INTO "public"."universitas" VALUES (101369, 213423, 'STAI AN-NADWAH KUALA TUNGKAL, JAMBI');
INSERT INTO "public"."universitas" VALUES (101370, 213424, 'STAI MA`ARIF JAMBI');
INSERT INTO "public"."universitas" VALUES (101371, 213425, 'STAI MUARA BULIAN BATANGHARI, JAMBI');
INSERT INTO "public"."universitas" VALUES (101372, 213426, 'STAI SYEKH MAULANA QORI (SMQ) BANGKO, JAMBI');
INSERT INTO "public"."universitas" VALUES (101373, 213427, 'SEKOLAH TINGGI AGAMA ISLAM YASNI MUARA BUNGO');
INSERT INTO "public"."universitas" VALUES (101374, 213428, 'STIT AL-AZHAR DINIYYAH (STITAD) MUARO BUNGO, JAMBI');
INSERT INTO "public"."universitas" VALUES (101375, 213429, 'STIT AL-FALAH RIMBO BUJANG, TEBO, JAMBI');
INSERT INTO "public"."universitas" VALUES (101376, 213430, 'STIT DARUL ULUM, SAROLANGUN, JAMBI');
INSERT INTO "public"."universitas" VALUES (101377, 213431, 'STIT YAPIMA MUARA BUNGO');
INSERT INTO "public"."universitas" VALUES (101378, 213432, 'STIT YPI KERINCI');
INSERT INTO "public"."universitas" VALUES (101379, 213433, 'STITNU AL HIKMAH MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (101380, 213434, 'STAI MA`ARIF KENDAL NGAWI');
INSERT INTO "public"."universitas" VALUES (101381, 213435, 'STIU AL-MUJTAMA PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101382, 213436, 'STEI WALISONGO SAMPANG');
INSERT INTO "public"."universitas" VALUES (101383, 213437, 'STIS FAQIH ASY`ARI');
INSERT INTO "public"."universitas" VALUES (101384, 213438, 'STIT MUHAMMADIYAH PACIRAN');
INSERT INTO "public"."universitas" VALUES (101385, 213439, 'STIT MADINA SRAGEN');
INSERT INTO "public"."universitas" VALUES (101386, 213440, 'SEKOLAH TINGGI ILMU SYARI`AH MIFTAHUL ULUM LUMAJANG');
INSERT INTO "public"."universitas" VALUES (101387, 213441, 'SEKOLAH TINGGI ILMU TARBIYAH KUPANG');
INSERT INTO "public"."universitas" VALUES (101388, 213442, 'STAI NURUL FALAH AIRMOLEK');
INSERT INTO "public"."universitas" VALUES (101389, 213443, 'STAI AL-AZHAR PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101390, 213444, 'STAI YPPTIPS BALAISELASA');
INSERT INTO "public"."universitas" VALUES (101391, 213445, 'STIT BUSTANUL ARIFIN');
INSERT INTO "public"."universitas" VALUES (101392, 213446, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH BENGKALIS');
INSERT INTO "public"."universitas" VALUES (101393, 213447, 'STIT AD-DA`WAH RANGKASBITUNG');
INSERT INTO "public"."universitas" VALUES (101394, 213448, 'STITNU SAKINAH DHARMASRAYA');
INSERT INTO "public"."universitas" VALUES (101395, 213449, 'STAI IBNU SINA BATAM');
INSERT INTO "public"."universitas" VALUES (98602, 61003, 'UNIVERSITAS 17 AGUSTUS 1945 SEMARANG');
INSERT INTO "public"."universitas" VALUES (98603, 61004, 'UNIVERSITAS MUHAMMADIYAH MAGELANG');
INSERT INTO "public"."universitas" VALUES (98604, 61005, 'UNIVERSITAS TIDAR MAGELANG');
INSERT INTO "public"."universitas" VALUES (98605, 61006, 'UNIVERSITAS SLAMET RIYADI');
INSERT INTO "public"."universitas" VALUES (98606, 61007, 'UNIVERSITAS WIJAYA KUSUMA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98607, 61008, 'UNIVERSITAS MUHAMMADIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98608, 61009, 'UNIVERSITAS MURIA KUDUS');
INSERT INTO "public"."universitas" VALUES (98609, 61010, 'UNIVERSITAS TUNAS PEMBANGUNAN SURAKARTA (UTP)');
INSERT INTO "public"."universitas" VALUES (98610, 61011, 'UNIVERSITAS PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98611, 61012, 'UNIVERSITAS KATOLIK SOEGIJAPRANATA');
INSERT INTO "public"."universitas" VALUES (98612, 61013, 'UNIVERSITAS PANCASAKTI TEGAL');
INSERT INTO "public"."universitas" VALUES (98613, 61014, 'UNIVERSITAS DARUL ULUM ISLAMIC CENTRE SUDIRMAN');
INSERT INTO "public"."universitas" VALUES (98614, 61015, 'UNIVERSITAS ISLAM BATIK');
INSERT INTO "public"."universitas" VALUES (98615, 61016, 'UNIVERSITAS VETERAN BANGUN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98616, 61017, 'UNIVERSITAS SEMARANG');
INSERT INTO "public"."universitas" VALUES (98617, 61018, 'UNIVERSITAS WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (98618, 61019, 'UNIVERSITAS MUHAMMADIYAH PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98619, 61020, 'UNIVERSITAS KRISTEN SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98620, 61021, 'UNIVERSITAS PANDANARAN');
INSERT INTO "public"."universitas" VALUES (98621, 61022, 'UNIVERSITAS SETIA BUDI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98622, 61024, 'UNIVERSITAS SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98623, 61025, 'UNIVERSITAS MUHAMMADIYAH PURWOREJO');
INSERT INTO "public"."universitas" VALUES (98624, 61026, 'UNIVERSITAS MUHAMMADIYAH SEMARANG');
INSERT INTO "public"."universitas" VALUES (98625, 61027, 'UNIVERSITAS WAHID HASYIM');
INSERT INTO "public"."universitas" VALUES (98626, 61028, 'UNIVERSITAS NAHDLATUL ULAMA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98627, 61029, 'UNIVERSITAS STIKUBANK');
INSERT INTO "public"."universitas" VALUES (98628, 61030, 'UNIVERSITAS SAINS ALQUR AN');
INSERT INTO "public"."universitas" VALUES (98629, 61031, 'UNIVERSITAS DIAN NUSWANTORO');
INSERT INTO "public"."universitas" VALUES (98630, 61032, 'UNIVERSITAS SULTAN FATAH');
INSERT INTO "public"."universitas" VALUES (98631, 61033, 'UNIVERSITAS SAHID SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98632, 61034, 'UNIVERSITAS AKI');
INSERT INTO "public"."universitas" VALUES (98633, 61035, 'UNIVERSITAS BOYOLALI');
INSERT INTO "public"."universitas" VALUES (98634, 61036, 'UNIVERSITAS MUHADI SETIABUDI');
INSERT INTO "public"."universitas" VALUES (98635, 61037, 'UNIVERSITAS ISLAM NAHDLATUL ULAMA JEPARA');
INSERT INTO "public"."universitas" VALUES (98636, 61038, 'UNIVERSITAS PGRI SEMARANG');
INSERT INTO "public"."universitas" VALUES (98637, 61040, 'UNIVERSITAS MA''ARIF NAHDLATUL ULAMA KEBUMEN');
INSERT INTO "public"."universitas" VALUES (98638, 61041, 'UNIVERSITAS NAHDLATUL ULAMA AL GHAZALI CILACAP');
INSERT INTO "public"."universitas" VALUES (98639, 61042, 'UNIVERSITAS PERADABAN');
INSERT INTO "public"."universitas" VALUES (98640, 61043, 'UNIVERSITAS SELAMAT SRI');
INSERT INTO "public"."universitas" VALUES (98641, 61044, 'UNIVERSITAS NGUDI WALUYO');
INSERT INTO "public"."universitas" VALUES (98642, 61045, 'UNIVERSITAS NAHDLATUL ULAMA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98643, 61046, 'UNIVERSITAS NASIONAL KARANGTURI SEMARANG');
INSERT INTO "public"."universitas" VALUES (98644, 61047, 'UNIVERSITAS DUTA BANGSA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98645, 61048, 'UNIVERSITAS HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (98646, 61049, 'UNIVERSITAS IVET');
INSERT INTO "public"."universitas" VALUES (98647, 61050, 'UNIVERSITAS MUHAMMADIYAH KUDUS');
INSERT INTO "public"."universitas" VALUES (98648, 61051, 'UNIVERSITAS PERWIRA PURBALINGGA');
INSERT INTO "public"."universitas" VALUES (98649, 61052, 'UNIVERSITAS MUHAMMADIYAH PEKAJANGAN PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98650, 61053, 'UNIVERSITAS AN NUUR');
INSERT INTO "public"."universitas" VALUES (98651, 61054, 'UNIVERSITAS AMIKOM PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98652, 61055, 'UNIVERSITAS KUSUMA HUSADA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98653, 61056, 'UNIVERSITAS MARITIM AMNI');
INSERT INTO "public"."universitas" VALUES (98654, 61057, 'UNIVERSITAS ''AISYIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98655, 61058, 'UNIVERSITAS SAINS DAN TEKNOLOGI KOMPUTER');
INSERT INTO "public"."universitas" VALUES (98656, 61059, 'UNIVERSITAS WIDYA HUSADA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98657, 62001, 'IKIP VETERAN JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (98658, 62002, 'IKIP PGRI SEMARANG');
INSERT INTO "public"."universitas" VALUES (98659, 62003, 'INSTITUT TEKNOLOGI TELKOM PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98660, 62004, 'INSTITUT TEKNOLOGI DAN SAINS NAHDLATUL ULAMA PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98661, 62005, 'INSTITUT TEKNOLOGI SAINS DAN KESEHATAN PKU MUHAMMADIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98662, 62006, 'INSTITUT TEKNOLOGI DAN BISNIS KRISTEN BUKIT PENGHARAPAN');
INSERT INTO "public"."universitas" VALUES (98663, 62007, 'INSTITUT TEKNOLOGI DAN BISNIS SEMARANG');
INSERT INTO "public"."universitas" VALUES (98664, 62008, 'INSTITUT TEKNOLOGI BISNIS AAS INDONESIA');
INSERT INTO "public"."universitas" VALUES (98665, 63001, 'SEKOLAH TINGGI ILMU KOMUNIKASI');
INSERT INTO "public"."universitas" VALUES (98666, 63003, 'SEKOLAH TINGGI ILMU EKONOMI ANINDYAGUNA');
INSERT INTO "public"."universitas" VALUES (98667, 63004, 'SEKOLAH TINGGI ILMU EKONOMI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98668, 63005, 'SEKOLAH TINGGI ILMU EKONOMI SATRIA');
INSERT INTO "public"."universitas" VALUES (98669, 63006, 'SEKOLAH TINGGI ILMU EKONOMI ATMA BHAKTI');
INSERT INTO "public"."universitas" VALUES (98670, 63007, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA MANGGALA');
INSERT INTO "public"."universitas" VALUES (98671, 63008, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA PUTRA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98672, 63009, 'SEKOLAH TINGGI ILMU PERTANIAN FARMING');
INSERT INTO "public"."universitas" VALUES (98673, 63010, 'SEKOLAH TINGGI ILMU EKONOMI PARIWISATA INDONESIA');
INSERT INTO "public"."universitas" VALUES (98674, 63011, 'SEKOLAH TINGGI ILMU EKONOMI CENDEKIA KARYA UTAMA');
INSERT INTO "public"."universitas" VALUES (98675, 63012, 'SEKOLAH TINGGI ILMU EKONOMI ST PIGNATELLI');
INSERT INTO "public"."universitas" VALUES (98676, 63013, 'SEKOLAH TINGGI ILMU EKONOMI BANK BPD JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (98677, 63014, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA MANGGALIA');
INSERT INTO "public"."universitas" VALUES (98678, 63015, 'SEKOLAH TINGGI ILMU EKONOMI NAHDLATUL ULAMA');
INSERT INTO "public"."universitas" VALUES (98679, 63016, 'SEKOLAH TINGGI ILMU EKONOMI TRIANANDRA');
INSERT INTO "public"."universitas" VALUES (98680, 63017, 'SEKOLAH TINGGI BAHASA ASING SATYA WACANA');
INSERT INTO "public"."universitas" VALUES (98681, 63018, 'SEKOLAH TINGGI ILMU EKONOMI SWASTA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98682, 63020, 'STMIK WIDYA UTAMA');
INSERT INTO "public"."universitas" VALUES (98683, 63021, 'STMIK BINA PATRIA');
INSERT INTO "public"."universitas" VALUES (98684, 63022, 'SEKOLAH TINGGI ILMU EKONOMI AMA');
INSERT INTO "public"."universitas" VALUES (98685, 63024, 'SEKOLAH TINGGI ILMU EKONOMI ADI UNGGUL BHIRAWA');
INSERT INTO "public"."universitas" VALUES (98686, 63025, 'SEKOLAH TINGGI ILMU EKONOMI SEMARANG');
INSERT INTO "public"."universitas" VALUES (98687, 63026, 'SEKOLAH TINGGI ILMU EKONOMI TOTALWIN');
INSERT INTO "public"."universitas" VALUES (98688, 63027, 'SEKOLAH TINGGI ILMU EKONOMI WIJAYA MULYA');
INSERT INTO "public"."universitas" VALUES (100023, 101025, 'UNIVERSITAS UNIVERSAL');
INSERT INTO "public"."universitas" VALUES (100024, 101026, 'UNIVERSITAS MOHAMMAD NATSIR BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100025, 101027, 'UNIVERSITAS DHARMAS INDONESIA');
INSERT INTO "public"."universitas" VALUES (100026, 101028, 'UNIVERSITAS NAHDLATUL ULAMA SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100027, 101029, 'UNIVERSITAS PAHLAWAN TUANKU TAMBUSAI');
INSERT INTO "public"."universitas" VALUES (100028, 101030, 'UNIVERSITAS ADIWANGSA JAMBI');
INSERT INTO "public"."universitas" VALUES (100029, 101031, 'UNIVERSITAS MUHAMMADIYAH JAMBI');
INSERT INTO "public"."universitas" VALUES (100030, 101032, 'UNIVERSITAS FORT DE KOCK');
INSERT INTO "public"."universitas" VALUES (100031, 101033, 'UNIVERSITAS IBNU SINA');
INSERT INTO "public"."universitas" VALUES (100032, 101034, 'UNIVERSITAS DINAMIKA BANGSA');
INSERT INTO "public"."universitas" VALUES (100033, 102001, 'INSTITUT SAINS DAN TEKNOLOGI PEMBANGUNAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100034, 102002, 'INSTITUT TEKNOLOGI PADANG');
INSERT INTO "public"."universitas" VALUES (100035, 102003, 'INSTITUT TEKNOLOGI BATAM');
INSERT INTO "public"."universitas" VALUES (100036, 102004, 'INSTITUT KESEHATAN PRIMA NUSANTARA BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100037, 102005, 'INSTITUT BISNIS DAN TEKNOLOGI PELITA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100038, 102006, 'INSTITUT KESEHATAN MITRA BUNDA');
INSERT INTO "public"."universitas" VALUES (100039, 103001, 'STKIP YAYASAN ABDI PENDIDIKAN');
INSERT INTO "public"."universitas" VALUES (100040, 103002, 'STKIP AHLUSSUNNAH');
INSERT INTO "public"."universitas" VALUES (100041, 103003, 'STKIP PGRI SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100042, 103004, 'STKIP YDB LUBUK ALUNG');
INSERT INTO "public"."universitas" VALUES (100043, 103005, 'SEKOLAH TINGGI ILMU HUKUM PAINAN');
INSERT INTO "public"."universitas" VALUES (100044, 103006, 'SEKOLAH TINGGI ILMU HUKUM LUBUK SIKAPING');
INSERT INTO "public"."universitas" VALUES (100045, 103007, 'SEKOLAH TINGGI ILMU MANAJEMEN SUMBAR');
INSERT INTO "public"."universitas" VALUES (100046, 103008, 'SEKOLAH TINGGI ILMU EKONOMI HAJI AGUS SALIM');
INSERT INTO "public"."universitas" VALUES (100047, 103009, 'SEKOLAH TINGGI ILMU EKONOMI KBP');
INSERT INTO "public"."universitas" VALUES (100048, 103010, 'SEKOLAH TINGGI ILMU EKONOMI PASAMAN');
INSERT INTO "public"."universitas" VALUES (100049, 103011, 'SEKOLAH TINGGI ILMU EKONOMI SUMBAR');
INSERT INTO "public"."universitas" VALUES (100050, 103012, 'SEKOLAH TINGGI ILMU ADMINISTRASI ADABIAH');
INSERT INTO "public"."universitas" VALUES (100051, 103013, 'SEKOLAH TINGGI BAHASA ASING PRAYOGA');
INSERT INTO "public"."universitas" VALUES (100052, 103014, 'SEKOLAH TINGGI ILMU ADMINISTRASI LPPN');
INSERT INTO "public"."universitas" VALUES (100053, 103015, 'STISIP IMAM BONJOL');
INSERT INTO "public"."universitas" VALUES (100054, 103016, 'STISIP PADANG');
INSERT INTO "public"."universitas" VALUES (100055, 103017, 'SEKOLAH TINGGI TEKNOLOGI INDUSTRI PADANG');
INSERT INTO "public"."universitas" VALUES (100056, 103018, 'SEKOLAH TINGGI ILMU EKONOMI PERDAGANGAN');
INSERT INTO "public"."universitas" VALUES (100057, 103019, 'STISIP PANCASAKTI');
INSERT INTO "public"."universitas" VALUES (100058, 103020, 'STKIP YPM BANGKO');
INSERT INTO "public"."universitas" VALUES (100059, 103021, 'STIP GRAHA KARYA');
INSERT INTO "public"."universitas" VALUES (100060, 103022, 'STKIP MUHAMMADIYAH SUNGAI PENUH');
INSERT INTO "public"."universitas" VALUES (100061, 103025, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA ANDALAS');
INSERT INTO "public"."universitas" VALUES (100062, 103027, 'SEKOLAH TINGGI ILMU EKONOMI JAMBI');
INSERT INTO "public"."universitas" VALUES (100063, 103028, 'SEKOLAH TINGGI ILMU EKONOMI IBNUSINA');
INSERT INTO "public"."universitas" VALUES (100064, 103029, 'SEKOLAH TINGGI ILMU EKONOMI PURNA GRAHA');
INSERT INTO "public"."universitas" VALUES (100065, 103030, 'STMIK NURDIN HAMZAH');
INSERT INTO "public"."universitas" VALUES (100066, 103031, 'STMIK AMIK RIAU');
INSERT INTO "public"."universitas" VALUES (100067, 103032, 'SEKOLAH TINGGI ILMU EKONOMI RIAU');
INSERT INTO "public"."universitas" VALUES (100068, 103033, 'SEKOLAH TINGGI FARMASI INDONESIA PERINTIS PADANG');
INSERT INTO "public"."universitas" VALUES (100069, 103035, 'STISIPOL RAJA HAJI');
INSERT INTO "public"."universitas" VALUES (100070, 103036, 'SEKOLAH TINGGI ILMU EKONOMI INDRAGIRI RENGAT');
INSERT INTO "public"."universitas" VALUES (100071, 103037, 'SEKOLAH TINGGI ILMU ADMINISTRASI LANCANG KUNING');
INSERT INTO "public"."universitas" VALUES (100072, 103038, 'SEKOLAH TINGGI ILMU EKONOMI BANGKINANG');
INSERT INTO "public"."universitas" VALUES (100073, 103039, 'SEKOLAH TINGGI ILMU ADMINISTRASI PAGARUYUNG');
INSERT INTO "public"."universitas" VALUES (100074, 103040, 'SEKOLAH TINGGI ILMU HUKUM PADANG');
INSERT INTO "public"."universitas" VALUES (100075, 103041, 'SEKOLAH TINGGI ILMU KESEHATAN HARAPAN IBU JAMBI');
INSERT INTO "public"."universitas" VALUES (100076, 103042, 'SEKOLAH TINGGI ILMU EKONOMI PERBANKAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (100077, 103043, 'SEKOLAH TINGGI ILMU EKONOMI PAGARUYUNG');
INSERT INTO "public"."universitas" VALUES (100078, 103044, 'SEKOLAH TINGGI ILMU EKONOMI SAKTI ALAM KERINCI');
INSERT INTO "public"."universitas" VALUES (100079, 103045, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA PUTRA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100080, 103046, 'STISIP PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100081, 103047, 'SEKOLAH TINGGI ILMU EKONOMI PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100082, 103048, 'STIA BINA NUSANTARA MANDIRI PARIAMAN');
INSERT INTO "public"."universitas" VALUES (100083, 103049, 'STIE GRAHA KARYA MUARA BULIAN');
INSERT INTO "public"."universitas" VALUES (100084, 103050, 'SEKOLAH TINGGI ILMU EKONOMI BENTARA PERSADA BATAM');
INSERT INTO "public"."universitas" VALUES (100085, 103051, 'SEKOLAH TINGGI TEKNIK BENTARA PERSADA BATAM');
INSERT INTO "public"."universitas" VALUES (100086, 103052, 'SEKOLAH TINGGI TEKNOLOGI UNGGULAN SWARNA DWIPA');
INSERT INTO "public"."universitas" VALUES (100087, 103053, 'SEKOLAH TINGGI ILMU PERTANIAN SWARNA DWIPA');
INSERT INTO "public"."universitas" VALUES (100088, 103054, 'STMIK INDONESIA PADANG');
INSERT INTO "public"."universitas" VALUES (100089, 103055, 'SEKOLAH TINGGI TEKNIK IBNU SINA');
INSERT INTO "public"."universitas" VALUES (100090, 103056, 'SEKOLAH TINGGI ILMU KOMPUTER DINAMIKA BANGSA');
INSERT INTO "public"."universitas" VALUES (100091, 103057, 'STMIK JAYA NUSA');
INSERT INTO "public"."universitas" VALUES (100092, 103058, 'SEKOLAH TINGGI ILMU FARMASI RIAU');
INSERT INTO "public"."universitas" VALUES (100093, 103059, 'STMIK PUTERA BATAM');
INSERT INTO "public"."universitas" VALUES (100094, 103060, 'STKIP AISYIYAH RIAU');
INSERT INTO "public"."universitas" VALUES (100095, 103061, 'SEKOLAH TINGGI ILMU KESEHATAN HANG TUAH');
INSERT INTO "public"."universitas" VALUES (100096, 103063, 'STIPER SAWAHLUNTO SIJUNJUNG');
INSERT INTO "public"."universitas" VALUES (100097, 103064, 'SEKOLAH TINGGI ILMU KESEHATAN CERIA BUANA');
INSERT INTO "public"."universitas" VALUES (100098, 103065, 'SEKOLAH TINGGI TEKNOLOGI DURI');
INSERT INTO "public"."universitas" VALUES (100099, 103066, 'SEKOLAH TINGGI PARIWISATA RIAU');
INSERT INTO "public"."universitas" VALUES (100100, 103067, 'SEKOLAH TINGGI TEKNOLOGI NASIONAL');
INSERT INTO "public"."universitas" VALUES (100101, 103068, 'SEKOLAH TINGGI TEKNOLOGI DUMAI');
INSERT INTO "public"."universitas" VALUES (100102, 103069, 'SEKOLAH TINGGI ILMU ADMINISTRASI SETIH SETIO');
INSERT INTO "public"."universitas" VALUES (100103, 103070, 'SEKOLAH TINGGI ILMU KOMPUTER PELITA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100104, 103071, 'SEKOLAH TINGGI TEKNOLOGI PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100105, 103072, 'SEKOLAH TINGGI BAHASA ASING PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100106, 103073, 'SEKOLAH TINGGI ILMU KESEHATAN FORT DE KOCK');
INSERT INTO "public"."universitas" VALUES (100107, 103074, 'STISIP NURDIN HAMZAH');
INSERT INTO "public"."universitas" VALUES (100108, 103075, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH JAMBI');
INSERT INTO "public"."universitas" VALUES (100109, 103076, 'SEKOLAH TINGGI ILMU KESEHATAN ALIFAH PADANG');
INSERT INTO "public"."universitas" VALUES (101396, 213450, 'STEI IQRA ANNISA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101397, 213451, 'STIT SYEKHSAMAN AL-HASAN');
INSERT INTO "public"."universitas" VALUES (101398, 213452, 'STAI MIFTAHUL ULUM TANJUNG PINANG');
INSERT INTO "public"."universitas" VALUES (101399, 213453, 'STAI DINIYAH PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101400, 213454, 'STAI HUBBULWATHAN DURI');
INSERT INTO "public"."universitas" VALUES (101401, 213455, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) HUSNAYAIN JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (101402, 213456, 'SEKOLAH TINGGI EKONOMI ISLAM SEBI (STEI SEBI) CIPUTAT TANGERANG');
INSERT INTO "public"."universitas" VALUES (101403, 213458, 'STAI AL-HAMIDIYAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (101404, 213460, 'STAI ASY-SYUKRIYYAH TANGERANG');
INSERT INTO "public"."universitas" VALUES (101405, 213461, 'STAI AT-TAQWA BEKASI');
INSERT INTO "public"."universitas" VALUES (101406, 213462, 'STAI AZZIYADAH KLENDER, JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (101407, 213463, 'STAI BINAMADANI TANGERANG');
INSERT INTO "public"."universitas" VALUES (101408, 213464, 'STAI DARUL MA`ARIF, CIPETE JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (101409, 213465, 'STAI DARUL QALAM TANGERANG');
INSERT INTO "public"."universitas" VALUES (101410, 213466, 'SEKOLAH TINGGI AGAMA ISLAM DARUNNAJAH JAKARTA');
INSERT INTO "public"."universitas" VALUES (101411, 213467, 'STAI IMAM SYAFI`I TOMANG JAKBAR');
INSERT INTO "public"."universitas" VALUES (101412, 213468, 'SEKOLAH TINGGI AGAMA ISLAM INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101413, 213469, 'SEKOLAH TINGGI ILMU TARBIYAH INSIDA');
INSERT INTO "public"."universitas" VALUES (101414, 213470, 'STAI LAN TABOER PONDOK GEDE, JAKARTA TIMUR');
INSERT INTO "public"."universitas" VALUES (101415, 213472, 'STAI NUR EL GHAZY BEKASI');
INSERT INTO "public"."universitas" VALUES (101416, 213473, 'STAI PTDII JAKARTA');
INSERT INTO "public"."universitas" VALUES (101417, 213474, 'STAI PUBLISISTIK THAWALIB JAKARTA');
INSERT INTO "public"."universitas" VALUES (101418, 213475, 'STAI SHALAHUDDIN AL-AYYUBI JAKARTA UTARA');
INSERT INTO "public"."universitas" VALUES (101419, 213476, 'STID DIROSAT ISLAMIYAH AL-HIKMAH MAMPANG JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (101420, 213477, 'STID MOHAMMAD NATSIR BEKASI');
INSERT INTO "public"."universitas" VALUES (101421, 213478, 'STIT AL-MARHALAH AL-`ULYA BEKASI');
INSERT INTO "public"."universitas" VALUES (101422, 213479, 'STIT MUSLIM ASIA AFRIKA, TANGERANG');
INSERT INTO "public"."universitas" VALUES (101423, 213480, 'STIT TANGERANG RAYA YAYASAN PURGANTORIO');
INSERT INTO "public"."universitas" VALUES (101424, 213481, 'STIT YA`MAL TANGERANG');
INSERT INTO "public"."universitas" VALUES (101425, 213482, 'STIU AL-HIKMAH MAMPANG JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (101426, 213483, 'STIU DARUL HIKMAH BEKASI');
INSERT INTO "public"."universitas" VALUES (101427, 213484, 'STIU DIROSAT ISLAMIYAH AL-HIKMAH JAKARTA SELATAN');
INSERT INTO "public"."universitas" VALUES (101428, 213485, 'STIE SYARI`AH AL-MUJADDID');
INSERT INTO "public"."universitas" VALUES (101429, 213486, 'STAI AL-MUSADDADIYAH GARUT');
INSERT INTO "public"."universitas" VALUES (101430, 213487, 'SEKOLAH TINGGI EKONOMI DAN PERBANKAN ISLAM MR. SJAFRUDDIN PRAWIRANEGARA');
INSERT INTO "public"."universitas" VALUES (101431, 213488, 'STIT KABUPATEN TEBO');
INSERT INTO "public"."universitas" VALUES (101432, 213489, 'SEKOLAH TINGGI ILMU ISLAM DAN BAHASA ARAB (STIBA) MAKASSAR');
INSERT INTO "public"."universitas" VALUES (101433, 213490, 'STAI PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (101434, 213491, 'STAI AL-KAUTSAR');
INSERT INTO "public"."universitas" VALUES (101435, 213492, 'STAI AL-MASTHURIYAH SUKABUMI');
INSERT INTO "public"."universitas" VALUES (101436, 213493, 'STAI AL-QUDWAH DEPOK');
INSERT INTO "public"."universitas" VALUES (101437, 213494, 'STAI AR-RIDHO ROKAN HILIR RIAU');
INSERT INTO "public"."universitas" VALUES (101438, 213495, 'STAI AULIAURRASYIDIN');
INSERT INTO "public"."universitas" VALUES (101439, 213497, 'STAI H.M. LUKMAN EDY PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101440, 213498, 'STAI KUANSING');
INSERT INTO "public"."universitas" VALUES (101441, 213499, 'STAI MADINATUN NAJAH');
INSERT INTO "public"."universitas" VALUES (101442, 213500, 'STAI NATUNA');
INSERT INTO "public"."universitas" VALUES (101443, 213501, 'STAI NURUL HIDAYAH');
INSERT INTO "public"."universitas" VALUES (101444, 213503, 'STAI ROKAN');
INSERT INTO "public"."universitas" VALUES (101445, 213504, 'STAI SULTAN ABDURRAHMAN KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (101446, 213505, 'SEKOLAH TINGGI AGAMA ISLAM (STAI) SULTHAN SYARIF HASYIM SIAK SRI INDRAPURA RIAU');
INSERT INTO "public"."universitas" VALUES (101447, 213506, 'STAI TAFAQQUHFIDDIN DUMAI');
INSERT INTO "public"."universitas" VALUES (101448, 213507, 'STAI TUANKU TAMBUSAI');
INSERT INTO "public"."universitas" VALUES (101449, 213508, 'STEI AR - RACHMAN');
INSERT INTO "public"."universitas" VALUES (101450, 213509, 'STI EKONOMI SYARI`AH BAKTIYA ACEH UTARA');
INSERT INTO "public"."universitas" VALUES (101451, 213510, 'STIDKI AL-AZIZ BATAM');
INSERT INTO "public"."universitas" VALUES (101452, 213511, 'STIQ KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (101453, 213512, 'SEKOLAH TINGGI ILMU TARBIYYAH (STIT) AR - RISALAH INHIL RIAU');
INSERT INTO "public"."universitas" VALUES (101454, 213513, 'STIT BABUSSALAM, ACEH TENGGARA');
INSERT INTO "public"."universitas" VALUES (101455, 213514, 'STIT DAR ASWAJA ROKAN HILIR');
INSERT INTO "public"."universitas" VALUES (101456, 213516, 'STIT MULTAZAM');
INSERT INTO "public"."universitas" VALUES (101457, 213517, 'SEKOLAH TINGGI EKONOMI DAN BISNIS SYARIAH (STEBIS) INDO GLOBAL MANDIRI');
INSERT INTO "public"."universitas" VALUES (101458, 213518, 'SEKOLAH TINGGI ILMU TARBIYAH (STIT) AL-CHAERIYAH MAMUJU SULAWESI BARAT');
INSERT INTO "public"."universitas" VALUES (101459, 213519, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) AL-MANAR');
INSERT INTO "public"."universitas" VALUES (101460, 213520, 'SEKOLAH TINGGI ILMU SYARIAH NAHDLATUL ULAMA (STISNU) NUSANTARA TANGERANG');
INSERT INTO "public"."universitas" VALUES (101461, 213521, 'SEKOLAH TINGGI ILMU AL-QUR''AN (STIQ) BIMA');
INSERT INTO "public"."universitas" VALUES (101462, 213522, 'SEKOLAH TINGGI ILMU TARBIYAH (STIT) ISLAMIYAH NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (101463, 213523, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) DAYAH AMAL');
INSERT INTO "public"."universitas" VALUES (101464, 213524, 'SEKOLAH TINGGI ILMU AL-QUR''AN NURUL ISLAM');
INSERT INTO "public"."universitas" VALUES (101465, 213525, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) AL-AZIZIYAH SABANG');
INSERT INTO "public"."universitas" VALUES (101466, 213526, 'SEKOLAH TINGGI ILMU SYARIAH WAL AQIDAH ASH-SHOFA MANONJAYA');
INSERT INTO "public"."universitas" VALUES (101467, 213527, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) DARUL QUR''AN MINAK SELEBAH');
INSERT INTO "public"."universitas" VALUES (101468, 213528, 'SEKOLAH TINGGI ILMU DAKWAH SIRNARASA');
INSERT INTO "public"."universitas" VALUES (101469, 213529, 'SEKOLAH TINGGI ILMU AL-QURAN (STIQ) AN-NUR LEMPUING OKI');
INSERT INTO "public"."universitas" VALUES (101470, 213530, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) NURUD DHALAM');
INSERT INTO "public"."universitas" VALUES (101471, 213531, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) UMMUL AYMAN PIDIE JAYA');
INSERT INTO "public"."universitas" VALUES (101472, 213532, 'SEKOLAH TINGGI ILMU SYARI''AH (STIS) NAHDLATUL ULAMA ACEH');
INSERT INTO "public"."universitas" VALUES (101473, 213533, 'SEKOLAH TINGGI ILMU SYARI''AH (STIS) MUHAMMADIYAH PRINGSEWU');
INSERT INTO "public"."universitas" VALUES (101474, 213534, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM (STEBIS) NUR ILMI AL-ISMAILIYUN');
INSERT INTO "public"."universitas" VALUES (101475, 213535, 'SEKOLAH TINGGI EKONOMI MANAJEMEN BISNIS ISLAM (STEMBI) BANDUNG');
INSERT INTO "public"."universitas" VALUES (98689, 63028, 'SEKOLAH TINGGI ILMU EKONOMI PELITA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98690, 63030, 'SEKOLAH TINGGI ILMU EKONOMI ASSHOLEH');
INSERT INTO "public"."universitas" VALUES (98691, 63031, 'SEKOLAH TINGGI ILMU EKONOMI YPPI');
INSERT INTO "public"."universitas" VALUES (98692, 63032, 'SEKOLAH TINGGI ILMU FARMASI YAYASAN PHARMASI');
INSERT INTO "public"."universitas" VALUES (98693, 63036, 'SEKOLAH TINGGI ILMU KESEHATAN NGUDI WALUYO');
INSERT INTO "public"."universitas" VALUES (98694, 63037, 'SEKOLAH TINGGI ILMU EKONOMI PUTRA BANGSA');
INSERT INTO "public"."universitas" VALUES (98695, 63038, 'SEKOLAH TINGGI ILMU PERIKANAN KALINYAMAT');
INSERT INTO "public"."universitas" VALUES (98696, 63039, 'SEKOLAH TINGGI ILMU EKONOMI RAJAWALI');
INSERT INTO "public"."universitas" VALUES (98697, 63040, 'STMIK SINAR NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98698, 63041, 'STIMIK BANJARNEGARA');
INSERT INTO "public"."universitas" VALUES (98699, 63042, 'STMIK AUB SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98700, 63043, 'STMIK WIDYA PRATAMA');
INSERT INTO "public"."universitas" VALUES (98701, 63044, 'SEKOLAH TINGGI TEKNIK WIWOROTOMO');
INSERT INTO "public"."universitas" VALUES (98702, 63045, 'SEKOLAH TINGGI ILMU ADMINISTRASI MADANI');
INSERT INTO "public"."universitas" VALUES (98703, 63046, 'SEKOLAH TINGGI ILMU KESEHATAN HARAPAN BANGSA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98704, 63047, 'STMIK HIMSYA');
INSERT INTO "public"."universitas" VALUES (98705, 63048, 'SEKOLAH TINGGI TEKNOLOGI MUHAMMADIYAH KEBUMEN');
INSERT INTO "public"."universitas" VALUES (98706, 63049, 'SEKOLAH TINGGI ELEKTRONIKA & KOMPUTER (STEKOM)');
INSERT INTO "public"."universitas" VALUES (98707, 63051, 'SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH GOMBONG');
INSERT INTO "public"."universitas" VALUES (98708, 63052, 'SEKOLAH TINGGI TEKNOLOGI RONGGOLAWE');
INSERT INTO "public"."universitas" VALUES (98709, 63053, 'SEKOLAH TINGGI ILMU KESEHATAN HAKLI');
INSERT INTO "public"."universitas" VALUES (98710, 63054, 'STMIK AKI PATI');
INSERT INTO "public"."universitas" VALUES (98711, 63055, 'STIKES AL-IRSYAD AL-ISLAMIYYAH');
INSERT INTO "public"."universitas" VALUES (98712, 63056, 'SEKOLAH TINGGI ILMU EKONOMI TAMANSISWA');
INSERT INTO "public"."universitas" VALUES (98713, 63057, 'SEKOLAH TINGGI ILMU KESEHATAN CENDEKIA UTAMA');
INSERT INTO "public"."universitas" VALUES (98714, 63058, 'STIMIK PRO VISI');
INSERT INTO "public"."universitas" VALUES (98715, 63059, 'STMIK DUTA BANGSA');
INSERT INTO "public"."universitas" VALUES (98716, 63060, 'SEKOLAH TINGGI ILMU KESEHATAN KENDAL');
INSERT INTO "public"."universitas" VALUES (98717, 63061, 'STMIK YMI TEGAL');
INSERT INTO "public"."universitas" VALUES (98718, 63062, 'STIE MUHAMMADIYAH PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98719, 63063, 'SEKOLAH TINGGI TEKNOLOGI & DESAIN NAHDLATUL ULAMA');
INSERT INTO "public"."universitas" VALUES (98720, 63064, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH CILACAP');
INSERT INTO "public"."universitas" VALUES (98721, 63065, 'STMIK AMIKOM PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98722, 63066, 'SEKOLAH TINGGI ILMU KESEHATAN ''AISYIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98723, 63067, 'STIMIK TUNAS BANGSA BANJARNEGARA');
INSERT INTO "public"."universitas" VALUES (98724, 63068, 'STIKES MUHAMMADIYAH PEKAJANGAN');
INSERT INTO "public"."universitas" VALUES (98725, 63069, 'SEKOLAH TINGGI KESEHATAN BINA CIPTA HUSADA');
INSERT INTO "public"."universitas" VALUES (98726, 63070, 'SEKOLAH TINGGI ILMU KESEHATAN DUTA GAMA KLATEN');
INSERT INTO "public"."universitas" VALUES (98727, 63071, 'STIKES BHAKTI MANDALA HUSADA SLAWI');
INSERT INTO "public"."universitas" VALUES (98728, 63072, 'STIKES MUHAMMADIYAH KLATEN');
INSERT INTO "public"."universitas" VALUES (98729, 63073, 'SEKOLAH TINGGI ILMU KOMPUTER YOS SUDARSO');
INSERT INTO "public"."universitas" VALUES (98730, 63074, 'STIKES KARYA HUSADA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98731, 63075, 'SEKOLAH TINGGI PARIWISATA SAHID SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98732, 63076, 'STIKES AN-NUR PURWODADI');
INSERT INTO "public"."universitas" VALUES (98733, 63077, 'SEKOLAH TINGGI TEKNOLOGI YPT PURBALINGGA');
INSERT INTO "public"."universitas" VALUES (98734, 63078, 'SEKOLAH TINGGI ILMU KESEHATAN WIDYA HUSADA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98735, 63079, 'STIKES TELOGOREJO SEMARANG');
INSERT INTO "public"."universitas" VALUES (98736, 63080, 'SEKOLAH TINGGI MARITIM DAN TRANSPOR AMNI');
INSERT INTO "public"."universitas" VALUES (98737, 63081, 'SEKOLAH TINGGI ILMU KESEHATAN ELISABETH SEMARANG');
INSERT INTO "public"."universitas" VALUES (98738, 63082, 'STIA ASUH MITRA SOLO');
INSERT INTO "public"."universitas" VALUES (98739, 63083, 'STKIP ISLAM BUMI AYU');
INSERT INTO "public"."universitas" VALUES (98740, 63084, 'SEKOLAH TINGGI ILMU EKONOMI AKA');
INSERT INTO "public"."universitas" VALUES (98741, 63085, 'STIKES MUHAMMADIYAH KUDUS');
INSERT INTO "public"."universitas" VALUES (98742, 63086, 'STIKES KUSUMA HUSADA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98743, 63087, 'STIKES AL IRSYAD AL ISLAMIYYAH CILACAP');
INSERT INTO "public"."universitas" VALUES (98744, 63088, 'STIE ISLAM BUMIAYU');
INSERT INTO "public"."universitas" VALUES (98745, 63089, 'STIKES PKU MUHAMMADIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98746, 63090, 'SEKOLAH TINGGI TEKNOLOGI TELEMATIKA TELKOM');
INSERT INTO "public"."universitas" VALUES (98747, 63091, 'SEKOLAH TINGGI ILMU EKONOMI SELAMAT SRI KENDAL');
INSERT INTO "public"."universitas" VALUES (98748, 63092, 'SEKOLAH TINGGI TEKNOLOGI TELEKOMUNIKASI PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98749, 63093, 'SEKOLAH TINGGI ILMU EKONOMI AAS');
INSERT INTO "public"."universitas" VALUES (98750, 63094, 'STIKES PAGUWARMAS MAOS');
INSERT INTO "public"."universitas" VALUES (98751, 63095, 'STKIP DARUSSALAM CILACAP');
INSERT INTO "public"."universitas" VALUES (98752, 63096, 'STIKES MITRA HUSADA KARANGANYAR');
INSERT INTO "public"."universitas" VALUES (98753, 63097, 'STKIP MAJENANG');
INSERT INTO "public"."universitas" VALUES (98754, 63098, 'STIKES ESTU UTOMO');
INSERT INTO "public"."universitas" VALUES (98755, 63099, 'SEKOLAH TINGGI ILMU KESEHATAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (98756, 63100, 'STKIP NAHDLATUL ULAMA KABUPATEN TEGAL');
INSERT INTO "public"."universitas" VALUES (98757, 63101, 'STMIK MUHAMMADIYAH PAGUYANGAN BREBES');
INSERT INTO "public"."universitas" VALUES (98758, 63102, 'STIKES IBNU SINA AJIBARANG');
INSERT INTO "public"."universitas" VALUES (98759, 63103, 'STT MINYAK DAN GAS CILACAP');
INSERT INTO "public"."universitas" VALUES (98760, 63104, 'STIKES MAMBA UL ULUM SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98761, 63105, 'STKIP MUHAMMADIYAH BLORA');
INSERT INTO "public"."universitas" VALUES (98762, 63106, 'SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH KENDAL');
INSERT INTO "public"."universitas" VALUES (98763, 63107, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER KOMPUTAMA MAJENANG');
INSERT INTO "public"."universitas" VALUES (98764, 63108, 'SEKOLAH TINGGI ILMU KESEHATAN UNISKA');
INSERT INTO "public"."universitas" VALUES (98765, 63109, 'SEKOLAH TINGGI TEKNIK PATI');
INSERT INTO "public"."universitas" VALUES (98766, 63110, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER AMIKOM SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98767, 63111, 'STIKES MUHAMMADIYAH TEGAL');
INSERT INTO "public"."universitas" VALUES (98768, 63112, 'SEKOLAH TINGGI ILMU KESEHATAN BAKTI UTAMA PATI');
INSERT INTO "public"."universitas" VALUES (100451, 114063, 'ASMI AIRLANGGA BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (98769, 63113, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN MUHAMMADIYAH BATANG');
INSERT INTO "public"."universitas" VALUES (98770, 63114, 'SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH WONOSOBO');
INSERT INTO "public"."universitas" VALUES (98771, 63115, 'SEKOLAH TINGGI ILMU KESEHATAN AR-RUM');
INSERT INTO "public"."universitas" VALUES (98772, 63116, 'SEKOLAH TINGGI ILMU KESEHATAN TUJUH BELAS');
INSERT INTO "public"."universitas" VALUES (98773, 63117, 'SEKOLAH TINGGI ILMU KESEHATAN PANTI WILASA');
INSERT INTO "public"."universitas" VALUES (100110, 103077, 'SEKOLAH TINGGI ILMU KESEHATAN BAITURRAHIM');
INSERT INTO "public"."universitas" VALUES (100111, 103078, 'STIA NUSANTARA SAKTI SUNGAI PENUH');
INSERT INTO "public"."universitas" VALUES (100112, 103079, 'STMIK DUMAI');
INSERT INTO "public"."universitas" VALUES (100113, 103080, 'SEKOLAH TINGGI TEKNOLOGI PAYAKUMBUH');
INSERT INTO "public"."universitas" VALUES (100114, 103081, 'SEKOLAH TINGGI ILMU FARMASI PADANG');
INSERT INTO "public"."universitas" VALUES (100115, 103082, 'STIKES MERCUBAKTIJAYA PADANG');
INSERT INTO "public"."universitas" VALUES (100116, 103083, 'STIKES TUANKU TAMBUSAI');
INSERT INTO "public"."universitas" VALUES (100117, 103084, 'STIKES PERINTIS PADANG');
INSERT INTO "public"."universitas" VALUES (100118, 103085, 'STIKES PIALA SAKTI PARIAMAN');
INSERT INTO "public"."universitas" VALUES (100119, 103086, 'STIKES TENGKU MAHARATU');
INSERT INTO "public"."universitas" VALUES (100120, 103087, 'SEKOLAH TINGGI ILMU HUKUM PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100121, 103088, 'SEKOLAH TINGGI ILMU KESEHATAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (100122, 103089, 'SEKOLAH TINGGI ILMU KESEHATAN YPAK PADANG');
INSERT INTO "public"."universitas" VALUES (100123, 103090, 'STMIK DHARMAPALA RIAU');
INSERT INTO "public"."universitas" VALUES (100124, 103091, 'STIKES DHARMASRAYA');
INSERT INTO "public"."universitas" VALUES (100125, 103092, 'SEKOLAH TINGGI ILMU EKONOMI PELITA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100126, 103093, 'STIKES HANG TUAH TANJUNG PINANG');
INSERT INTO "public"."universitas" VALUES (100127, 103094, 'STIKES PURNA BHAKTI HUSADA BATUSANGKAR');
INSERT INTO "public"."universitas" VALUES (100128, 103095, 'SEKOLAH TINGGI ILMU KESEHATAN IBNU SINA BATAM');
INSERT INTO "public"."universitas" VALUES (100129, 103096, 'SEKOLAH TINGGI ILMU KESEHATAN PAYUNG NEGERI');
INSERT INTO "public"."universitas" VALUES (100130, 103097, 'STMIK DHARMASRAYA');
INSERT INTO "public"."universitas" VALUES (100131, 103098, 'STIKES YARSI SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100132, 103099, 'STIE PEMBANGUNAN TANJUNGPINANG');
INSERT INTO "public"."universitas" VALUES (100133, 103100, 'SEKOLAH TINGGI ILMU KOMUNIKASI INTERNASIONAL GURINDAM ARCHIPELAGO');
INSERT INTO "public"."universitas" VALUES (100134, 103101, 'SEKOLAH TINGGI ILMU EKONOMI CAKRAWALA');
INSERT INTO "public"."universitas" VALUES (100135, 103102, 'SEKOLAH TINGGI TEKNOLOGI INDONESIA TANJUNG PINANG');
INSERT INTO "public"."universitas" VALUES (100136, 103103, 'SEKOLAH TINGGI ILMU KESEHATAN SYEDZA SAINTIKA');
INSERT INTO "public"."universitas" VALUES (100137, 103104, 'STIKES RANAH MINANG');
INSERT INTO "public"."universitas" VALUES (100138, 103105, 'SEKOLAH TINGGI TEKNOLOGI INDRAGIRI');
INSERT INTO "public"."universitas" VALUES (100139, 103106, 'SEKOLAH TINGGI ILMU EKONOMI EL HAKIM');
INSERT INTO "public"."universitas" VALUES (100140, 103107, 'STKIP AL AZHAR DINIYYAH JAMBI');
INSERT INTO "public"."universitas" VALUES (100141, 103109, 'SEKOLAH TINGGI ILMU KESEHATAN KARIMUN');
INSERT INTO "public"."universitas" VALUES (100142, 103110, 'STIKES DHARMA LANDBOUW');
INSERT INTO "public"."universitas" VALUES (100143, 103111, 'STBA HAJI AGUS SALIM');
INSERT INTO "public"."universitas" VALUES (100144, 103112, 'STKIP ADZKIA');
INSERT INTO "public"."universitas" VALUES (100145, 103113, 'STKIP WIDYASWARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100146, 103114, 'STIE WIDYASWARA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100147, 103115, 'STIKES AWAL BROS BATAM');
INSERT INTO "public"."universitas" VALUES (100148, 103116, 'STIKES PEKANBARU MEDICAL CENTER');
INSERT INTO "public"."universitas" VALUES (100149, 103117, 'STKIP INSAN MADANI AIRMOLEK');
INSERT INTO "public"."universitas" VALUES (100150, 103118, 'STIKES AL-INSYIRAH PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100151, 103119, 'STKIP NASIONAL');
INSERT INTO "public"."universitas" VALUES (100152, 103120, 'STIKES NAN TONGGA');
INSERT INTO "public"."universitas" VALUES (100153, 103121, 'STIKES PRIMA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100154, 103122, 'STIKES MITRA BUNDA PERSADA');
INSERT INTO "public"."universitas" VALUES (100155, 103123, 'STMIK HANG TUAH PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100156, 103124, 'SEKOLAH TINGGI ILMU KESEHATAN PRIMA');
INSERT INTO "public"."universitas" VALUES (100157, 103126, 'SEKOLAH TINGGI PERTANIAN HAJI AGUS SALIM');
INSERT INTO "public"."universitas" VALUES (100158, 103127, 'SEKOLAH TINGGI ILMU KESEHATAN MERANGIN');
INSERT INTO "public"."universitas" VALUES (100159, 103128, 'STKIP DHARMASRAYA');
INSERT INTO "public"."universitas" VALUES (100160, 103129, 'STKIP PAHLAWAN TUANKU TAMBUSAI');
INSERT INTO "public"."universitas" VALUES (100161, 103131, 'STIE PRAKARTI MULYA');
INSERT INTO "public"."universitas" VALUES (100162, 103133, 'SEKOLAH TINGGI ILMU KESEHATAN (STIKES) LENGGOGENI PADANG');
INSERT INTO "public"."universitas" VALUES (100163, 103134, 'STIE MAHAPUTRA RIAU');
INSERT INTO "public"."universitas" VALUES (100164, 103135, 'STISIP BUNDA TANAH MELAYU');
INSERT INTO "public"."universitas" VALUES (100165, 103136, 'SEKOLAH TINGGI ILMU KOMPUTER MUHAMMADIYAH BATAM');
INSERT INTO "public"."universitas" VALUES (100166, 103137, 'STIA INDRAGIRI');
INSERT INTO "public"."universitas" VALUES (100167, 103138, 'STKIP PESISIR SELATAN');
INSERT INTO "public"."universitas" VALUES (100168, 103139, 'STIE NAGOYA INDONESIA');
INSERT INTO "public"."universitas" VALUES (100169, 103140, 'STIH PUTRI MAHARAJA');
INSERT INTO "public"."universitas" VALUES (100170, 103141, 'STKIP ROKANIA');
INSERT INTO "public"."universitas" VALUES (100171, 103142, 'STKIP MUHAMMADIYAH MUARA BUNGO');
INSERT INTO "public"."universitas" VALUES (100172, 103143, 'STMIK INDRAGIRI');
INSERT INTO "public"."universitas" VALUES (100173, 103144, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN MERANTI');
INSERT INTO "public"."universitas" VALUES (100174, 103145, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER GICI');
INSERT INTO "public"."universitas" VALUES (100175, 103146, 'SEKOLAH TINGGI TEKNOLOGI PELALAWAN');
INSERT INTO "public"."universitas" VALUES (100176, 103147, 'SEKOLAH TINGGI ILMU EKONOMI GALILEO');
INSERT INTO "public"."universitas" VALUES (100177, 103148, 'STIKES AWAL BROS PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100178, 103149, 'SEKOLAH TINGGI ILMU HUKUM RIAU');
INSERT INTO "public"."universitas" VALUES (100179, 103150, 'SEKOLAH TINGGI ILMU HUKUM YPM');
INSERT INTO "public"."universitas" VALUES (100180, 103151, 'STIE HARAPAN DURI');
INSERT INTO "public"."universitas" VALUES (100181, 103152, 'SEKOLAH TINGGI TEKNIK NUSANTARA MANDIRI');
INSERT INTO "public"."universitas" VALUES (100182, 103153, 'STIE YA BANGKO');
INSERT INTO "public"."universitas" VALUES (100183, 103154, 'SEKOLAH TINGGI ILMU EKONOMI TUAH NEGERI');
INSERT INTO "public"."universitas" VALUES (100184, 103155, 'SEKOLAH TINGGI ILMU KESEHATAN SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100185, 103156, 'SEKOLAH TINGGI ILMU KESEHATAN HAR-KAUSYAR');
INSERT INTO "public"."universitas" VALUES (100186, 103157, 'SEKOLAH TINGGI ILMU KESEHATAN KELUARGA BUNDA JAMBI');
INSERT INTO "public"."universitas" VALUES (100187, 104001, 'AKADEMI PEMBANGUNAN PERTANIAN LUBUK ALUNG');
INSERT INTO "public"."universitas" VALUES (100188, 104002, 'AKADEMI PARIWISATA BUNDA PADANG');
INSERT INTO "public"."universitas" VALUES (100189, 104003, 'AKADEMI ILMU KOMUNIKASI PADANG');
INSERT INTO "public"."universitas" VALUES (100190, 104004, 'AKADEMI KEUANGAN DAN PERBANKAN PADANG');
INSERT INTO "public"."universitas" VALUES (100191, 104005, 'AKADEMI AKUNTANSI INDONESIA PADANG');
INSERT INTO "public"."universitas" VALUES (100192, 104006, 'AKADEMI KOPERASI SUMBAR');
INSERT INTO "public"."universitas" VALUES (100193, 104007, 'AKADEMI SEKRETARI DAN MANAJEMEN INDONESIA PADANG');
INSERT INTO "public"."universitas" VALUES (100194, 104012, 'AKADEMI PARIWISATA ENGKU PUTRI HAMIDAH');
INSERT INTO "public"."universitas" VALUES (100195, 104015, 'AKADEMI MANAJEMEN KOPERASI GRAHA KARYA');
INSERT INTO "public"."universitas" VALUES (100196, 104016, 'AKADEMI SEKRETARI DAN MANAJEMEN JAMBI');
INSERT INTO "public"."universitas" VALUES (100197, 104017, 'AKADEMI KEUANGAN DAN PERBANKAN RIAU');
INSERT INTO "public"."universitas" VALUES (100198, 104018, 'AKADEMI AKUNTANSI RIAU');
INSERT INTO "public"."universitas" VALUES (100199, 104019, 'AKADEMI SEKRETARI DAN MANAJEMEN PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100200, 104024, 'AKADEMI AKUNTANSI MAHAPUTRA RIAU');
INSERT INTO "public"."universitas" VALUES (100201, 104025, 'AKADEMI KEPERAWATAN BAITURRAHMAH');
INSERT INTO "public"."universitas" VALUES (100202, 104026, 'AKADEMI TEKNOLOGI PRATAMA');
INSERT INTO "public"."universitas" VALUES (101476, 213536, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH (STIES) SAYAGA SANISKARA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (101477, 213538, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM (STEBIS) PAGARALAM');
INSERT INTO "public"."universitas" VALUES (101478, 213539, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM (STEBIS) MUHAMMADIYAH SUMEDANG');
INSERT INTO "public"."universitas" VALUES (101479, 213540, 'SEKOLAH TINGGI ILMU TARBIYAH (STIT) BAHANA SUMBAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101480, 213541, 'SEKOLAH TINGGI ILMU SYARIAH (STIS) DARUL ULUM LAMPUNG TIMUR');
INSERT INTO "public"."universitas" VALUES (101481, 213542, 'SEKOLAH TINGGI ILMU TARBIYAH NAHDLATUL ULAMA (STITNU) AL-FARABI PANGANDARAN');
INSERT INTO "public"."universitas" VALUES (101482, 213543, 'SEKOLAH TINGGI ILMU DAKWAH DAN KOMUNIKASI AL-HAMIDY PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101483, 213544, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM SYAIKHONA KHOLIL SIDOGIRI PASURUAN');
INSERT INTO "public"."universitas" VALUES (101484, 213545, 'SEKOLAH TINGGI ILMU DAKWAH DAN KOMUNIKASI ISLAM AR-RAHMAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (101485, 213546, 'SEKOLAH TINGGI ILMU AL-QUR''AN ASH-SHIDDIQ ACEH BESAR');
INSERT INTO "public"."universitas" VALUES (101486, 213547, 'STEBI GLOBAL MULIA CIKARANG');
INSERT INTO "public"."universitas" VALUES (101487, 213548, 'STIS AS-SA''ADAH SUKASARI SUMEDANG');
INSERT INTO "public"."universitas" VALUES (101488, 213549, 'SEKOLAH TINGGI ILMU PERBANKAN SYARIAH AL-MA''SOEM BANDUNG');
INSERT INTO "public"."universitas" VALUES (101489, 213550, 'STIT DARUSSALAM LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (101490, 213551, 'SEKOLAH TINGGI SAINS ISLAM BINA CENDEKIA UTAMA CIREBON');
INSERT INTO "public"."universitas" VALUES (101491, 213552, 'STEBIS AL-ULUM TERPADU MEDAN');
INSERT INTO "public"."universitas" VALUES (101492, 213553, 'STIT AL-ANSHAR TANJUNG SELOR BULUNGAN');
INSERT INTO "public"."universitas" VALUES (101493, 213554, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH IMAM ASY SYAFII PEKANBARU RIAU');
INSERT INTO "public"."universitas" VALUES (101494, 213555, 'STIS DARUL FALAH PAGUTAN MATARAM NTB');
INSERT INTO "public"."universitas" VALUES (101495, 213556, 'STIQ MIFTAHUL HUDA RAWALO BANYUMAS JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101496, 213557, 'STIES AL-FALAH PANCENG GRESIK JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101497, 213558, 'SEKOLAH TINGGI ILMU FIQIH SYEIKH NAWAWI TANARA BANTEN');
INSERT INTO "public"."universitas" VALUES (101498, 213559, 'SEKOLAH TINGGI ILMU TARBIYAH LINGGA KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (101499, 213560, 'SEKOLAH TINGGI ILMU TARBIYAH SIMEULUE ACEH');
INSERT INTO "public"."universitas" VALUES (101500, 213561, 'SEKOLAH TINGGI ILMU BUDAYA ISLAM SYEKH JANGKUNG PATI');
INSERT INTO "public"."universitas" VALUES (101501, 213562, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH NAHDLATUL ULAMA BENGKULU');
INSERT INTO "public"."universitas" VALUES (101502, 213563, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM TANGGAMUS LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101503, 213564, 'SEKOLAH TINGGI ILMU AL-QUR''AN AL-LATHIFIYYAH PALEMBANG SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101504, 213565, 'SEKOLAH TINGGI ILMU USHULUDDIN DARUSSALAM, BANGKALAN, JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101505, 213566, 'SEKOLAH TINGGI ILMU SYARIAH AS SALAFIYAH SUMBER DUKO, PAMEKASAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101506, 213567, 'SEKOLAH TINGGI EKONOMI SYARIAH IHYA ULUMIDDIN, BANYUWANGI JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101507, 213568, 'SEKOLAH TINGGI EKONOMI ISLAM MASYARAKAT MADANI, PAMEKASAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101508, 213569, 'SEKOLAH TINGGI ILMU TARBIYAH BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (101509, 213570, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH DARUL HUDA MESUJI LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101510, 213571, 'SEKOLAH TINGGI AGAMA ISLAM IBNU RUSYD');
INSERT INTO "public"."universitas" VALUES (101511, 213572, 'STEI AL AMAR SUBANG JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101512, 213573, 'STEI AR RISALAH CIAMIS JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101513, 213574, 'STIT HAMZAH FANSURI SUBULUSSALAM ACEH');
INSERT INTO "public"."universitas" VALUES (101514, 213575, 'STIT DARUL ULUM KUBU RAYA KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (101515, 213576, 'SEKOLAH TINGGI ILMU BAHASA DAN DAKWAH MASJID AGUNG SUNAN AMPEL SURABAYA JATIM');
INSERT INTO "public"."universitas" VALUES (101516, 213577, 'SEKOLAH TINGGI AGAMA ISLAM ACEH TAMIANG');
INSERT INTO "public"."universitas" VALUES (101517, 213578, 'SEKOLAH TINGGI ILMU BAHASA ARAB DARUL ULUM BANYUANYAR PAMEKASAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101518, 213579, 'SEKOLAH TINGGI EKONOMI ISLAM KANJENG SEPUH GRESIK JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101519, 213580, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM PERSATUAN UMMAT ISLAM BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101520, 213581, 'SEKOLAH TINGGI ILMU AL-QUR''AN DAN SAINS AL-ISHLAH LAMONGAN JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101521, 213582, 'SEKOLAH TINGGI ILMU TARBIYAH AR-RAUDLATUL HASANAH MEDAN SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101522, 213583, 'SEKOLAH TINGGI PESANTREN DARUNNA''IM LEBAK BANTEN');
INSERT INTO "public"."universitas" VALUES (101523, 213584, 'INSTITUT UMMUL QURO AL-ISLAMI BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101524, 213585, 'SEKOLAH TINGGI EKONOMI SYARIAH MANNA WA SALWA TANAH DATAR SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101525, 213586, 'SEKOLAH TINGGI ILMU DAKWAH RAUDLATUL IMAN SUMENEP JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101526, 213587, 'SEKOLAH TINGGI AGAMA ISLAM AL-MUJTAHADAH PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101527, 213588, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM DARUSSALAM OGAN KOMERING ILIR SUMSEL');
INSERT INTO "public"."universitas" VALUES (101528, 213589, 'SEKOLAH TINGGI ILMU TARBIYAH AL BUKHARY LABUHAN BATU');
INSERT INTO "public"."universitas" VALUES (101529, 213590, 'SEKOLAH TINGGI ILMU TARBIYAH BATUBARA');
INSERT INTO "public"."universitas" VALUES (101530, 213591, 'SEKOLAH TINGGI ILMU TARBIYAH HIDAYATULLAH BATAM KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (101531, 213592, 'SEKOLAH TINGGI EKONOMI ISLAM BINA MUDA BANDUNG');
INSERT INTO "public"."universitas" VALUES (101532, 213593, 'SEKOLAH TINGGI ILMU TARBIYAH NUSANTARA BEKASI');
INSERT INTO "public"."universitas" VALUES (101533, 213594, 'SEKOLAH TINGGI ILMU TARBIYAH MAMBA''UL ULUM JAMBI');
INSERT INTO "public"."universitas" VALUES (98774, 63118, 'SEKOLAH TINGGI ILMU KESEHATAN YLPP PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98775, 63119, 'SEKOLAH TINGGI ILMU KESEHATAN SERULINGMAS');
INSERT INTO "public"."universitas" VALUES (98776, 63120, 'SEKOLAH TINGGI ILMU KESEHATAN BREBES');
INSERT INTO "public"."universitas" VALUES (98777, 63121, 'SEKOLAH TINGGI TEKNOLOGI "WARGA" SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98778, 63122, 'SEKOLAH TINGGI ILMU FARMASI NUSAPUTERA');
INSERT INTO "public"."universitas" VALUES (98779, 63123, 'SEKOLAH TINGGI ILMU KESEHATAN PANTI KOSALA');
INSERT INTO "public"."universitas" VALUES (98780, 63124, 'SEKOLAH TINGGI ILMU KESEHATAN NGESTI WALUYO');
INSERT INTO "public"."universitas" VALUES (98781, 64002, 'AKADEMI BAHASA 17 AGUSTUS 1945 SEMARANG');
INSERT INTO "public"."universitas" VALUES (98782, 64003, 'AKADEMI TEKNIK MESIN INDUSTRI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98783, 64004, 'AKADEMI PELAYARAN NIAGA INDONESIA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98784, 64006, 'AKADEMI TEKNOLOGI SEMARANG');
INSERT INTO "public"."universitas" VALUES (98785, 64007, 'AKADEMI SEKRETARI MARSUDIRINI SANTA MARIA');
INSERT INTO "public"."universitas" VALUES (98786, 64009, 'AKADEMI BAHASA ASING IEC SEMARANG');
INSERT INTO "public"."universitas" VALUES (98787, 64010, 'AKADEMI KESEJAHTERAAN SOSIAL IBU KARTINI');
INSERT INTO "public"."universitas" VALUES (98788, 64011, 'AKADEMI PERTANIAN HKTI BANYUMAS');
INSERT INTO "public"."universitas" VALUES (98789, 64012, 'AKADEMI PETERNAKAN KARANGANYAR');
INSERT INTO "public"."universitas" VALUES (98790, 64013, 'AKADEMI BAHASA ASING ST PIGNATELLI');
INSERT INTO "public"."universitas" VALUES (98791, 64014, 'AKADEMI KIMIA INDUSTRI SANTO PAULUS SEMARANG');
INSERT INTO "public"."universitas" VALUES (98792, 64016, 'AKADEMI PERTANIAN MUHAMMADIYAH PEMALANG');
INSERT INTO "public"."universitas" VALUES (98793, 64018, 'AKADEMI MARITIM NUSANTARA CILACAP');
INSERT INTO "public"."universitas" VALUES (98794, 64020, 'AKADEMI MANAJEMEN INDUSTRI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98795, 64021, 'AMIK VETERAN PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98796, 64022, 'AKADEMI PERTANIAN PRAGOLAPATI');
INSERT INTO "public"."universitas" VALUES (98797, 64024, 'AMIK HARAPAN BANGSA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98798, 64025, 'AKADEMI STATISTIKA MUHAMMADIYAH SEMARANG');
INSERT INTO "public"."universitas" VALUES (98799, 64026, 'AKADEMI TEKNOLOGI WARGA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98800, 64027, 'AKADEMI PARIWISATA WIDYA NUSANTARA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98801, 64028, 'AMIK YMI TEGAL');
INSERT INTO "public"."universitas" VALUES (98802, 64033, 'AKADEMI PERTANIAN PGRI WONOSOBO');
INSERT INTO "public"."universitas" VALUES (98803, 64037, 'AMIK PGRI KEBUMEN');
INSERT INTO "public"."universitas" VALUES (98804, 64039, 'AKADEMI TEKNIK PERKAPALAN VETERAN');
INSERT INTO "public"."universitas" VALUES (98805, 64040, 'AKADEMI PARIWISATA MANDALA BHAKTI');
INSERT INTO "public"."universitas" VALUES (98806, 64042, 'AKADEMI TEKNIK FAJAR INDONESIA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98807, 64044, 'AKADEMI TEKNOLOGI ARIE LASUT');
INSERT INTO "public"."universitas" VALUES (98808, 64045, 'AKADEMI PARIWISATA EKA SAKTI');
INSERT INTO "public"."universitas" VALUES (98809, 64046, 'AKADEMI AKUNTANSI MUHAMMADIYAH KLATEN');
INSERT INTO "public"."universitas" VALUES (98810, 64049, 'AMIK CIPTA DARMA');
INSERT INTO "public"."universitas" VALUES (98811, 64050, 'AKADEMI DESAIN SURAKARTA');
INSERT INTO "public"."universitas" VALUES (99234, 73181, 'STIKES ADI HUSADA');
INSERT INTO "public"."universitas" VALUES (98812, 64051, 'AKADEMI TEKNIK WACANA MANUNGGAL SEMARANG');
INSERT INTO "public"."universitas" VALUES (98813, 64052, 'AKADEMI PERIKANAN DAN KELAUTAN SRI MUKTI');
INSERT INTO "public"."universitas" VALUES (98814, 64053, 'AKADEMI MANAJEMEN INDONESIA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98815, 64055, 'AKADEMI AKUNTANSI EFFENDI HARAHAP');
INSERT INTO "public"."universitas" VALUES (98816, 64057, 'AKADEMI SENI DAN DESAIN INDONESIA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98817, 64059, 'AKADEMI SEKRETARI DAN MANAJEMEN SANTA ANNA');
INSERT INTO "public"."universitas" VALUES (98818, 64061, 'AKADEMI TEKNIK TIRTA WIYATA');
INSERT INTO "public"."universitas" VALUES (98819, 64062, 'AKADEMI ANALIS KESEHATAN PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98820, 64063, 'AKADEMI BAHASA ASING HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (98821, 64064, 'AKADEMI PERIKANAN BARUNA');
INSERT INTO "public"."universitas" VALUES (98822, 64065, 'AKADEMI KEBIDANAN MAMBA UL ULUM SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98823, 64066, 'AMIK JAKARTA TEKNOLOGI CIPTA');
INSERT INTO "public"."universitas" VALUES (98824, 64069, 'AKADEMI KEPERAWATAN BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (98825, 64070, 'AKADEMI FARMASI BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (98826, 64071, 'AKADEMI KEBIDANAN ESTU UTOMO');
INSERT INTO "public"."universitas" VALUES (98827, 64072, 'AKADEMI KEBIDANAN NGUDI WALUYO');
INSERT INTO "public"."universitas" VALUES (98828, 64073, 'AKADEMI BAHASA ASING PRAWIRA MARTHA SUKOHARJO');
INSERT INTO "public"."universitas" VALUES (98829, 64074, 'AKADEMI KEBIDANAN AN-NUR PURWODADI');
INSERT INTO "public"."universitas" VALUES (98830, 64075, 'AKADEMI KEBIDANAN GIRI SATRIA HUSADA');
INSERT INTO "public"."universitas" VALUES (98831, 64076, 'AKADEMI TEKNOLOGI AUB');
INSERT INTO "public"."universitas" VALUES (98832, 64077, 'AKADEMI BAHASA ASING IEC PUTRA BANGSA TEGAL');
INSERT INTO "public"."universitas" VALUES (98833, 64078, 'AKADEMI TEKNIK TELEKOMUNIKASI');
INSERT INTO "public"."universitas" VALUES (98834, 64079, 'AKADEMI KEBIDANAN YLPP PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98835, 64080, 'AKADEMI BAHASA ASING RA KARTINI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98836, 64083, 'APIKES BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (98837, 64087, 'AKADEMI KEBIDANAN PAGUWARMAS MAOS');
INSERT INTO "public"."universitas" VALUES (98838, 64088, 'AKADEMI PEREKAM MEDIK & INFO KES CITRA MEDIKA');
INSERT INTO "public"."universitas" VALUES (98839, 64089, 'AKADEMI KEBIDANAN KARSA MULIA');
INSERT INTO "public"."universitas" VALUES (98840, 64090, 'AKADEMI KEPERAWATAN YAPPI SRAGEN');
INSERT INTO "public"."universitas" VALUES (98841, 64091, 'AKADEMI KEBIDANAN ABDI HUSADA');
INSERT INTO "public"."universitas" VALUES (98842, 64092, 'AKADEMI KEUANGAN PERBANKAN WIDYA BUANA');
INSERT INTO "public"."universitas" VALUES (98843, 64093, 'AKADEMI MANAJEMEN RUMAH SAKIT KUSUMA HUSADA');
INSERT INTO "public"."universitas" VALUES (98844, 64094, 'AKADEMI PEREKAM MEDIK DAN INFOKES MITRA HUSADA');
INSERT INTO "public"."universitas" VALUES (98845, 64095, 'AKADEMI KEBIDANAN MITRA HUSADA KARANGANYAR');
INSERT INTO "public"."universitas" VALUES (98846, 64096, 'AKADEMI KEPERAWATAN AL-HIKMAH 2 BREBES');
INSERT INTO "public"."universitas" VALUES (98847, 64097, 'AKADEMI PELAYARAN NASIONAL SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98848, 64099, 'AKADEMI FARMASI NASIONAL SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98849, 64100, 'AKADEMI KEPERAWATAN PANTI KOSALA');
INSERT INTO "public"."universitas" VALUES (98850, 64101, 'AKADEMI KEBIDANAN MARDI RAHAYU');
INSERT INTO "public"."universitas" VALUES (98851, 64102, 'AKADEMI KEPERAWATAN PEMERINTAH KAB PURWOREJO');
INSERT INTO "public"."universitas" VALUES (98852, 64103, 'AKADEMI KEBIDANAN BAKTI UTAMA PATI');
INSERT INTO "public"."universitas" VALUES (98853, 64104, 'AKADEMI KEBIDANAN ISLAM AL-HIKMAH');
INSERT INTO "public"."universitas" VALUES (98854, 64105, 'AKADEMI KEBIDANAN DUTA DHARMA PATI');
INSERT INTO "public"."universitas" VALUES (98855, 64106, 'AKADEMI KEPERAWATAN YAKPERMAS BANYUMAS');
INSERT INTO "public"."universitas" VALUES (98856, 64107, 'AKADEMI KEPERAWATAN MAMBA UL ULUM SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98857, 64108, 'AKADEMI FARMASI KUSUMA HUSADA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98858, 64109, 'AKADEMI SENI MANGKUNEGARAN SURAKARTA');
INSERT INTO "public"."universitas" VALUES (100203, 104027, 'AKADEMI MARITIM SAPTA SAMUDRA');
INSERT INTO "public"."universitas" VALUES (100204, 104030, 'AKADEMI MANAJEMEN INFORMATIKA & KOMPUTER JAYA NUSA');
INSERT INTO "public"."universitas" VALUES (100205, 104032, 'AKADEMI BAHASA ASING PERSADA BUNDA');
INSERT INTO "public"."universitas" VALUES (100206, 104039, 'AKADEMI TEKNIK TAMAN SISWA');
INSERT INTO "public"."universitas" VALUES (100207, 104040, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER DUMAI');
INSERT INTO "public"."universitas" VALUES (100208, 104041, 'AKADEMI BAHASA ASING ALASKA PADANG');
INSERT INTO "public"."universitas" VALUES (100209, 104042, 'APIKES IRIS');
INSERT INTO "public"."universitas" VALUES (100210, 104043, 'AKADEMI TEKNIK ADIKARYA');
INSERT INTO "public"."universitas" VALUES (100211, 104044, 'AKADEMI TELEKOMUNIKASI INDONESIA JAMBI');
INSERT INTO "public"."universitas" VALUES (100212, 104045, 'AKADEMI KESEHATAN FISIOTERAPI');
INSERT INTO "public"."universitas" VALUES (100213, 104047, 'AKADEMI FARMASI DWI FARMA');
INSERT INTO "public"."universitas" VALUES (100214, 104048, 'AMIK BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100215, 104049, 'AKADEMI BAHASA ASING TANJUNG PINANG');
INSERT INTO "public"."universitas" VALUES (100216, 104050, 'AMIK DATUK PARPATIAH NAN SABATANG');
INSERT INTO "public"."universitas" VALUES (100217, 104051, 'AMIK MITRA GAMA');
INSERT INTO "public"."universitas" VALUES (100218, 104052, 'AKADEMI KEBIDANAN ALIFAH PADANG');
INSERT INTO "public"."universitas" VALUES (100219, 104053, 'AKADEMI PERPAJAKAN YPKM');
INSERT INTO "public"."universitas" VALUES (100220, 104056, 'AKADEMI KEBIDANAN DHARMA HUSADA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100221, 104057, 'AKADEMI KEPERAWATAN DHARMA HUSADA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100222, 104058, 'AKADEMI BAHASA ASING NURDIN HAMZAH');
INSERT INTO "public"."universitas" VALUES (100223, 104059, 'AMIK MAHAPUTRA RIAU');
INSERT INTO "public"."universitas" VALUES (100224, 104062, 'AKADEMI KEBIDANAN PRIMA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100225, 104065, 'AMIK TRI DHARMA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100226, 104066, 'AKADEMI PARIWISATA PARAMITHA BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100227, 104067, 'AKADEMI KESENIAN MELAYU RIAU');
INSERT INTO "public"."universitas" VALUES (100228, 104068, 'AKADEMI KEBIDANAN DAYANG SURI');
INSERT INTO "public"."universitas" VALUES (100229, 104069, 'AKADEMI KEPERAWATAN JAMBI');
INSERT INTO "public"."universitas" VALUES (100230, 104071, 'AKADEMI KEBIDANAN MERANGIN');
INSERT INTO "public"."universitas" VALUES (100231, 104072, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER KOSGORO');
INSERT INTO "public"."universitas" VALUES (100232, 104074, 'AKADEMI FARMASI RANAH MINANG');
INSERT INTO "public"."universitas" VALUES (100233, 104075, 'AMIK SELAT PANJANG');
INSERT INTO "public"."universitas" VALUES (100234, 104076, 'AKADEMI AKUNTANSI (AKTAN) BOEKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100235, 104077, 'AKADEMI KEPERAWATAN SRI BUNGA TANJUNG');
INSERT INTO "public"."universitas" VALUES (100236, 104078, 'AMIK DEPATI PARBO KERINCI');
INSERT INTO "public"."universitas" VALUES (100237, 104080, 'AKADEMI KEPERAWATAN BINA INSANI SAKTI');
INSERT INTO "public"."universitas" VALUES (100238, 104081, 'AKADEMI KEBIDANAN TUANKU TAMBUSAI');
INSERT INTO "public"."universitas" VALUES (100239, 104082, 'AKADEMI KEPERAWATAN NABILA');
INSERT INTO "public"."universitas" VALUES (100240, 104083, 'AKADEMI KEBIDANAN INTERNASIONAL PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100241, 104084, 'AKADEMI KEPERAWATAN PRIMA JAMBI');
INSERT INTO "public"."universitas" VALUES (100242, 104085, 'AKADEMI KEBIDANAN PRIMA JAMBI');
INSERT INTO "public"."universitas" VALUES (100243, 104088, 'AKADEMI ANALIS KESEHATAN PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100244, 104089, 'AKADEMI KEPERAWATAN YPTK SOLOK');
INSERT INTO "public"."universitas" VALUES (100245, 104090, 'AKADEMI KEBIDANAN SEMPENA NEGERI PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100246, 104091, 'AKADEMI KEBIDANAN HELVETIA PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100247, 104093, 'AKADEMI KEPERAWATAN SETIH SETIO');
INSERT INTO "public"."universitas" VALUES (100248, 104096, 'AKADEMI KEBIDANAN HUSADA GEMILANG');
INSERT INTO "public"."universitas" VALUES (100249, 104097, 'AKADEMI KEBIDANAN BAITURRAHIM JAMBI');
INSERT INTO "public"."universitas" VALUES (100250, 104098, 'AKADEMI KEBIDANAN LAKSAMANA');
INSERT INTO "public"."universitas" VALUES (100251, 104100, 'AKADEMI KEBIDANAN BUNDA SERUMPUN');
INSERT INTO "public"."universitas" VALUES (100252, 104101, 'AKADEMI KEPERAWATAN AISYIYAH PADANG');
INSERT INTO "public"."universitas" VALUES (100253, 104102, 'AKADEMI KEBIDANAN TUTI RAHAYU');
INSERT INTO "public"."universitas" VALUES (100254, 104103, 'AKADEMI KEBIDANAN BINA NUSANTARA MANDIRI');
INSERT INTO "public"."universitas" VALUES (100255, 104104, 'AKADEMI KEPERAWATAN PURNA BHAKTI HUSADA');
INSERT INTO "public"."universitas" VALUES (100256, 104105, 'AKADEMI KEBIDANAN PUTERI ANDALAS');
INSERT INTO "public"."universitas" VALUES (100257, 104106, 'AKADEMI KEBIDANAN WIDYA HUSADA');
INSERT INTO "public"."universitas" VALUES (100258, 104108, 'AKADEMI KEBIDANAN MITRA HUSADA PADANG');
INSERT INTO "public"."universitas" VALUES (100259, 104109, 'AKADEMI KEBIDANAN PETRO MANDAU HUSADA');
INSERT INTO "public"."universitas" VALUES (100260, 104110, 'AKADEMI KEBIDANAN UMI BAGAN BATU');
INSERT INTO "public"."universitas" VALUES (100261, 104111, 'AKADEMI KEBIDANAN AMANAH MUARA BUNGO');
INSERT INTO "public"."universitas" VALUES (100262, 104112, 'AKADEMI KEBIDANAN KELUARGA BUNDA JAMBI');
INSERT INTO "public"."universitas" VALUES (100263, 104113, 'AKADEMI ANALIS KESEHATAN PUTRA JAYA BATAM');
INSERT INTO "public"."universitas" VALUES (100264, 104114, 'AKADEMI AKUNTANSI DAN MANAJEMEN PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (100265, 104115, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER GICI');
INSERT INTO "public"."universitas" VALUES (100266, 104116, 'AKADEMI BAHASA ASING PERMATA HARAPAN');
INSERT INTO "public"."universitas" VALUES (100267, 104117, 'AKADEMI AKUNTANSI PERMATA HARAPAN BATAM');
INSERT INTO "public"."universitas" VALUES (100268, 104118, 'AKADEMI KEBIDANAN PELITA ANDALAS');
INSERT INTO "public"."universitas" VALUES (100269, 104119, 'AKADEMI KEBIDANAN ANUGERAH BINTAN');
INSERT INTO "public"."universitas" VALUES (100270, 104120, 'AKADEMI KEBIDANAN SATU ENAM LIMA');
INSERT INTO "public"."universitas" VALUES (100271, 104122, 'AKADEMI KEBIDANAN SALMA');
INSERT INTO "public"."universitas" VALUES (100272, 104123, 'AKADEMI KEBIDANAN IMAM BONJOL');
INSERT INTO "public"."universitas" VALUES (100273, 104124, 'AKADEMI TEKNIK GIGI YLPTK PADANG');
INSERT INTO "public"."universitas" VALUES (100274, 104125, 'AKADEMI KEBIDANAN SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (100275, 104126, 'AKADEMI KEBIDANAN PAYUNG PELALAWAN');
INSERT INTO "public"."universitas" VALUES (100276, 104127, 'AKADEMI KEBIDANAN PUTRA JAYA MANDIRI BATAM');
INSERT INTO "public"."universitas" VALUES (100277, 104128, 'AKADEMI KEBIDANAN PASAMAN BARAT');
INSERT INTO "public"."universitas" VALUES (100278, 104129, 'AKADEMI KEBIDANAN BUDI MULIA');
INSERT INTO "public"."universitas" VALUES (100279, 104130, 'AKADEMI KEPERAWATAN YPSBR MUARA BULIAN');
INSERT INTO "public"."universitas" VALUES (100280, 104131, 'AKADEMI FARMASI PRAYOGA PADANG');
INSERT INTO "public"."universitas" VALUES (100281, 104132, 'AKADEMI KEBIDANAN PUTRI BANGSA PARIAMAN');
INSERT INTO "public"."universitas" VALUES (100282, 104133, 'AKADEMI KEBIDANAN HANG JEBAT');
INSERT INTO "public"."universitas" VALUES (100283, 104134, 'AKADEMI REFRAKSI OPTISI YLPTK');
INSERT INTO "public"."universitas" VALUES (100284, 104135, 'AKADEMI KEPERAWATAN KESDAM I/BUKIT BARISAN PADANG');
INSERT INTO "public"."universitas" VALUES (100285, 104136, 'AKADEMI KEBIDANAN INDRAGIRI');
INSERT INTO "public"."universitas" VALUES (100286, 104137, 'AKADEMI FARMASI IMAM BONJOL');
INSERT INTO "public"."universitas" VALUES (100287, 104138, 'AKADEMI KEBIDANAN JAKARTA MITRA SEJAHTERA');
INSERT INTO "public"."universitas" VALUES (100288, 104139, 'AKADEMI KEPERAWATAN GARUDA PUTIH JAMBI');
INSERT INTO "public"."universitas" VALUES (100289, 104140, 'AKADEMI KESEHATAN JOHN PAUL II PEKANBARU');
INSERT INTO "public"."universitas" VALUES (100290, 104141, 'AKADEMI AKUNTANSI DAN KOMPUTER STEPHEN JAMBI');
INSERT INTO "public"."universitas" VALUES (101534, 213595, 'SEKOLAH TINGGI ILMU DAKWAH DAN KOMUNIKASI ISLAM AL MARDLIYYAH PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101535, 213596, 'SEKOLAH TINGGI EKONOMI ISLAM HAJI ABDUL MALIK CIKARANG BARAT');
INSERT INTO "public"."universitas" VALUES (101536, 213597, 'SEKOLAH TINGGI ILMU TARBIYAH AL-KIFAYAH RIAU');
INSERT INTO "public"."universitas" VALUES (101537, 213598, 'SEKOLAH TINGGI ILMU TARBIYAH MAKRIFATUL ILMI BENGKULU SELATAN');
INSERT INTO "public"."universitas" VALUES (101538, 213599, 'SEKOLAH TINGGI ILMU TARBIYAH TOGO AMBARSARI BONDOWOSO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101539, 213601, 'SEKOLAH TINGGI ILMU TARBIYAH NAHDLATUL ULAMA SUMBER AGUNG OKU TIMUR');
INSERT INTO "public"."universitas" VALUES (101540, 213602, 'SEKOLAH TINGGI ILMU AL QURAN WALI SONGO SITUBONDO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101541, 213603, 'SEKOLAH TINGGI ILMU SYARIAH SAYID MOHAMMAD ALAWI AL MALIKI BONDOWOSO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101542, 213604, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH RIYADLUL JANNAH MOJOKERTO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101543, 213605, 'INSTITUT AGAMA ISLAM AS SIDDIQ KIE RAHA MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (101544, 213606, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101545, 213607, 'SEKOLAH TINGGI ILMU TARBIYAH AL-IHSAN BALEENDAH BANDUNG JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101546, 213608, 'SEKOLAH TINGGI ILMU TARBIYAH ISPINI TANAH BUMBU KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (101547, 213609, 'SEKOLAH TINGGI ILMU SYARIAH HAJI ABDUL RASYID LOMBOK TENGAH');
INSERT INTO "public"."universitas" VALUES (101548, 213610, 'SEKOLAH TINGGI ILMU SYARIAH HUSNUL KHOTIMAH (STISHK) KUNINGAN');
INSERT INTO "public"."universitas" VALUES (101549, 213611, 'SEKOLAH TINGGI ILMU TARBIYAH RAKEYAN SANTANG KARAWANG JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101550, 213612, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM AL JABAR BANDUNG JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101551, 213613, 'SEKOLAH TINGGI ILMU TARBIYAH DARUSSALAMAH PIDIE BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (101552, 213614, 'SEKOLAH TINGGI ILMU TARBIYAH SYAMSUDDHUHA ACEH UTARA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (101553, 213615, 'SEKOLAH TINGGI ILMU AL QUR''AN AR-RAHMAN');
INSERT INTO "public"."universitas" VALUES (101554, 213616, 'SEKOLAH TINGGI ILMU TARBIYAH AL-ITTIHADIYAH LABUHAN BATU UTARA SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101555, 213618, 'SEKOLAH TINGGI ILMU TARBIYAH MADANI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101556, 213619, 'SEKOLAH TINGGI ILMU SYARIAH ABU ZAIRI BONDOWOSO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101557, 213620, 'SEKOLAH TINGGI ILMU AL-QUR''AN DARUSSALAM LHOKSEUMAWE ACEH');
INSERT INTO "public"."universitas" VALUES (101558, 213621, 'SEKOLAH TINGGI ILMU EKONOM SYARI''AH MITRA KARYA BEKASI JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101559, 213622, 'SEKOLAH TINGGI ILMU TARBIYAH TUNAS BANGSA BANJARNEGARA JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101560, 213623, 'SEKOLAH TINGGI ILMU USHULUDDIN MASJID AL AKBAR SURABAYA JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101561, 213624, 'SEKOLAH TINGGI ILMU USHULUDDIN WADI MUBARAK BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101562, 213625, 'SEKOLAH TINGGI ILMU SYARI''AH DARUL FALAH BONDOWOSO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101563, 213626, 'SEKOLAH TINGGI ILMU EKONOMI SYARIAH PUTERA BANGSA TEGAL JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101564, 213627, 'SEKOLAH TINGGI AGAMA ISLAM SABILUL MUTTAQQIN MOJOKERTO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101565, 213628, 'SEKOLAH TINGGI AGAMA ISLAM MULIA ASTUTI WONOGIRI JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (101566, 213629, 'SEKOLAH TINGGI AGAMA ISLAM MINHAAJURROOSYIDIIN');
INSERT INTO "public"."universitas" VALUES (101567, 213630, 'SEKOLAH TINGGI ILMU SYARIAH DARUSY SYAFA''AH LAMPUNG TENGAH');
INSERT INTO "public"."universitas" VALUES (101568, 213631, 'SEKOLAH TINGGI ILMU TARBIYAH BOLAANG MONGONDOW KOTAMOBAGU SULAWESI UTARA');
INSERT INTO "public"."universitas" VALUES (101569, 213632, 'SEKOLAH TINGGI AGAMA ISLAM AL HIKMAH GLOBAL CENDIKIA KOTA DEPOK JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101570, 213633, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM MUARA ENIM SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101571, 213634, 'SEKOLAH TINGGI ILMU SYARI''AH DARUSSALAM BERMI');
INSERT INTO "public"."universitas" VALUES (101572, 213635, 'SEKOLAH TINGGI ILMU DAKWAH DAN KOMUNIKASI ISLAM BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101573, 213637, 'STAI RAWA AOPA KONAWE SELATAN');
INSERT INTO "public"."universitas" VALUES (101574, 213638, 'SEKOLAH TINGGI ILMU TARBIYAH INDAH MEDAN');
INSERT INTO "public"."universitas" VALUES (101575, 213639, 'SEKOLAH TINGGI ILMU SYARI''AH SULTAN FATAH');
INSERT INTO "public"."universitas" VALUES (101576, 213640, 'SEKOLAH TINGGI ILMU TARBIYAH AL MUBAROK BANDAR MATARAM');
INSERT INTO "public"."universitas" VALUES (101577, 213641, 'SEKOLAH TINGGI ILMU TARBIYAH AL HIKMAH BUMI AGUNG WAY KANAN');
INSERT INTO "public"."universitas" VALUES (101578, 213642, 'STAI DARUNNAJAH BOGOR');
INSERT INTO "public"."universitas" VALUES (101579, 213643, 'SEKOLAH TINGGI ILMU TARBIYAH SYEKH MUHAMMAD NAFIS');
INSERT INTO "public"."universitas" VALUES (101580, 213644, 'SEKOLAH TINGGI EKONOMI SYARI''AH BHAKTI NUGRAHA');
INSERT INTO "public"."universitas" VALUES (101581, 213645, 'SEKOLAH TINGGI ILMU DAKWAH DAN KOMUNIKASI ISLAM NAHDLATUL ULAMA INDRAMAYU');
INSERT INTO "public"."universitas" VALUES (101582, 213646, 'SEKOLAH TINGGI ILMU SHUFFAH AL-QUR''AN ABDULLAH BIN MAS''UD ONLINE LAMPUNG SELATAN');
INSERT INTO "public"."universitas" VALUES (101583, 213647, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM AL ROSYID BOJONEGORO JAWA TIMUR');
INSERT INTO "public"."universitas" VALUES (101584, 213648, 'SEKOLAH TINGGI ILMU TARBIYAH BUNTET PESANTREN CIREBON JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101585, 213649, 'SEKOLAH TINGGI EKONOMI ISLAM NAHDLATUL ULAMA SUBANG JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101586, 213650, 'SEKOLAH TINGGI EKONOMI SYARIAH TUNAS PALAPA LAMPUNG TENGAH');
INSERT INTO "public"."universitas" VALUES (101587, 213651, 'SEKOLAH TINGGI EKONOMI ISLAM SEKAYU PALEMBANG');
INSERT INTO "public"."universitas" VALUES (98859, 64110, 'AKADEMI KEPERAWATAN NGESTI WALUYO PARAKAN');
INSERT INTO "public"."universitas" VALUES (98860, 64111, 'AKADEMI KEPERAWATAN INSAN HUSADA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98861, 64112, 'AKADEMI KEPERAWATAN KARYA BHAKTI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98862, 64113, 'AKADEMI KEPERAWATAN KENDAL');
INSERT INTO "public"."universitas" VALUES (98863, 64114, 'AKADEMI KEPERAWATAN ALKAUTSAR TEMANGGUNG');
INSERT INTO "public"."universitas" VALUES (98864, 64115, 'AKADEMI KEBIDANAN UNISKA');
INSERT INTO "public"."universitas" VALUES (98865, 64116, 'AKADEMI KEBIDANAN YAPPI SRAGEN');
INSERT INTO "public"."universitas" VALUES (98866, 64118, 'AKADEMI KEPERAWATAN MUHAMMADIYAH KENDAL');
INSERT INTO "public"."universitas" VALUES (98867, 64120, 'AKADEMI KEPERAWATAN ASIH HUSADA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98868, 64121, 'AKADEMI KEPERAWATAN SERULINGMAS');
INSERT INTO "public"."universitas" VALUES (98869, 64122, 'AKADEMI KEBIDANAN PANTI WILASA');
INSERT INTO "public"."universitas" VALUES (98870, 64124, 'AMIK BSI PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98871, 64125, 'AKADEMI KEBIDANAN DULANG MAS');
INSERT INTO "public"."universitas" VALUES (98872, 64126, 'AKADEMI KEPERAWATAN KRIDA HUSADA');
INSERT INTO "public"."universitas" VALUES (98873, 64127, 'AKADEMI KEPERAWATAN GIRI SATRIA HUSADA');
INSERT INTO "public"."universitas" VALUES (98874, 64128, 'AKADEMI KEBIDANAN SITI FATIMAH');
INSERT INTO "public"."universitas" VALUES (98875, 64129, 'AKADEMI FARMASI THERESIANA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98876, 64130, 'AKADEMI KEBIDANAN PERWIRA HUSADA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (98877, 64131, 'AKADEMI KEBIDANAN BHAKTI PERTIWI PEMALANG');
INSERT INTO "public"."universitas" VALUES (98878, 64132, 'AKADEMI KEBIDANAN AR-RUM SALATIGA');
INSERT INTO "public"."universitas" VALUES (98879, 64133, 'AKADEMI KEBIDANAN CITRA MEDIKA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98880, 64134, 'AKADEMI KEBIDANAN BHAKTI NUSANTARA SALATIGA');
INSERT INTO "public"."universitas" VALUES (98881, 64135, 'AKADEMI AKUNTANSI SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98882, 64136, 'AKADEMI ANALIS KESEHATAN 17 AGUSTUS 1945 SEMARANG');
INSERT INTO "public"."universitas" VALUES (98883, 64137, 'AKADEMI KEBIDANAN HARAPAN IBU PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98884, 64138, 'AKADEMI KEBIDANAN YPBHK BREBES');
INSERT INTO "public"."universitas" VALUES (98885, 64139, 'AKADEMI KEPERAWATAN PATRIA HUSADA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98886, 64140, 'AKADEMI KEBIDANAN BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (98887, 64141, 'AKADEMI KEBIDANAN BHAKTI PUTRA BANGSA PURWOREJO');
INSERT INTO "public"."universitas" VALUES (98888, 64142, 'AKADEMI KEBIDANAN KH PUTRA');
INSERT INTO "public"."universitas" VALUES (98889, 64143, 'AKADEMI KEBIDANAN MUHAMMADIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98890, 64144, 'AKADEMI KEBIDANAN MUSLIMAT NAHDLATUL ULAMA KUDUS');
INSERT INTO "public"."universitas" VALUES (98891, 64145, 'AKADEMI ANALIS KESEHATAN NASIONAL SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98892, 64146, 'AKADEMI KEBIDANAN SOKO TUNGGAL');
INSERT INTO "public"."universitas" VALUES (98893, 64147, 'AKPER PKU MUHAMMADIYAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98894, 64148, 'AKADEMI KEPERAWATAN NGUDI WALUYO UNGARAN');
INSERT INTO "public"."universitas" VALUES (98895, 64149, 'AKADEMI KEPERAWATAN 17 KARANGANYAR');
INSERT INTO "public"."universitas" VALUES (98896, 64150, 'AKADEMI ENTERPRENEURSHIP TERANG BANGSA');
INSERT INTO "public"."universitas" VALUES (98897, 64151, 'AKADEMI KEPERAWATAN KESDAM IV/DIPONEGORO');
INSERT INTO "public"."universitas" VALUES (98898, 64152, 'AKADEMI KEBIDANAN GRAHA MANDIRI CILACAP');
INSERT INTO "public"."universitas" VALUES (98899, 64153, 'AKADEMI FARMASI NUSAPUTERA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98900, 64154, 'AKADEMI KESEHATAN ASIH HUSADA');
INSERT INTO "public"."universitas" VALUES (98901, 64155, 'AKBID WIRA HUSADA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (98902, 64156, 'AKADEMI FISIOTERAPI WIDYA HUSADA');
INSERT INTO "public"."universitas" VALUES (98903, 64157, 'AKADEMI KEPERAWATAN WIDYA HUSADA');
INSERT INTO "public"."universitas" VALUES (98904, 64158, 'AKADEMI FARMASI 17 AGUSTUS 1945 SEMARANG');
INSERT INTO "public"."universitas" VALUES (98905, 64159, 'AKADEMI ANALIS KESEHATAN THERESIANA');
INSERT INTO "public"."universitas" VALUES (98906, 64160, 'AKADEMI TEKNIK ELEKTRO MEDIK');
INSERT INTO "public"."universitas" VALUES (98907, 64161, 'AKADEMI KEPERAWATAN PRAGOLOPATI');
INSERT INTO "public"."universitas" VALUES (98908, 64162, 'AKADEMI KEBIDANAN PEMERINTAH KABUPATEN KUDUS');
INSERT INTO "public"."universitas" VALUES (98909, 64163, 'AMIK BSI TEGAL');
INSERT INTO "public"."universitas" VALUES (98910, 64164, 'AKADEMI TEKNIK PIKA');
INSERT INTO "public"."universitas" VALUES (98911, 64165, 'AKADEMI KEBIDANAN KUDUS');
INSERT INTO "public"."universitas" VALUES (98912, 64166, 'AKADEMI TEKNOLOGI BANK DARAH SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98913, 65001, 'POLITEKNIK JAWA DWIPA');
INSERT INTO "public"."universitas" VALUES (98914, 65002, 'POLITEKNIK PRATAMA MULIA');
INSERT INTO "public"."universitas" VALUES (98915, 65004, 'POLITEKNIK MUHAMMADIYAH MAGELANG');
INSERT INTO "public"."universitas" VALUES (98916, 65005, 'POLITEKNIK SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98917, 65006, 'POLITEKNIK PRATAMA');
INSERT INTO "public"."universitas" VALUES (98918, 65007, 'POLITEKNIK MA ARIF');
INSERT INTO "public"."universitas" VALUES (98919, 65008, 'POLITEKNIK SAWUNGGALIH AJI');
INSERT INTO "public"."universitas" VALUES (98920, 65010, 'POLITEKNIK DHARMA PATRIA');
INSERT INTO "public"."universitas" VALUES (98921, 65012, 'POLITEKNIK HARAPAN BERSAMA');
INSERT INTO "public"."universitas" VALUES (98922, 65013, 'POLITEKNIK INDONUSA SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98923, 65014, 'POLITEKNIK PUSMANU');
INSERT INTO "public"."universitas" VALUES (98924, 65015, 'POLITEKNIK PURBAYA');
INSERT INTO "public"."universitas" VALUES (98925, 65016, 'POLITEKNIK UNGGULAN SRAGEN');
INSERT INTO "public"."universitas" VALUES (98926, 65017, 'POLITEKNIK MANUFAKTUR CEPER');
INSERT INTO "public"."universitas" VALUES (98927, 65018, 'POLITEKNIK STIBISNIS');
INSERT INTO "public"."universitas" VALUES (98928, 65019, 'POLITEKNIK MUHAMMADIYAH PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (98929, 65020, 'POLITEKNIK CILACAP');
INSERT INTO "public"."universitas" VALUES (98930, 65021, 'POLITEKNIK BANJARNEGARA');
INSERT INTO "public"."universitas" VALUES (98931, 65022, 'POLITEKNIK MUHAMMADIYAH TEGAL');
INSERT INTO "public"."universitas" VALUES (98932, 65023, 'POLITEKNIK KESEHATAN BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (98933, 65024, 'POLITEKNIK ATMI');
INSERT INTO "public"."universitas" VALUES (98934, 65025, 'POLITEKNIK TRISILA DHARMA');
INSERT INTO "public"."universitas" VALUES (98935, 65026, 'POLITEKNIK BAJA TEGAL');
INSERT INTO "public"."universitas" VALUES (98936, 65027, 'POLITEKNIK MITRA KARYA MANDIRI');
INSERT INTO "public"."universitas" VALUES (98937, 65028, 'POLITEKNIK SANTO PAULUS SURAKARTA');
INSERT INTO "public"."universitas" VALUES (98938, 65029, 'POLITEKNIK BINA TRADA SEMARANG');
INSERT INTO "public"."universitas" VALUES (98939, 65030, 'POLITEKNIK BALEKAMBANG JEPARA');
INSERT INTO "public"."universitas" VALUES (98940, 65031, 'POLITEKNIK KATOLIK MANGUNWIJAYA');
INSERT INTO "public"."universitas" VALUES (98941, 65033, 'POLITEKNIK BUMI AKPELNI');
INSERT INTO "public"."universitas" VALUES (98942, 65034, 'POLITEKNIK YAKPERMAS BANYUMAS');
INSERT INTO "public"."universitas" VALUES (98943, 65035, 'POLITEKNIK KUDUS');
INSERT INTO "public"."universitas" VALUES (98944, 65036, 'POLITEKNIK AKBARA');
INSERT INTO "public"."universitas" VALUES (98945, 66001, 'AKADEMI KOMUNITAS BALEKAMBANG');
INSERT INTO "public"."universitas" VALUES (98946, 66002, 'AKADEMI KOMUNITAS SEMEN INDONESIA REMBANG');
INSERT INTO "public"."universitas" VALUES (98947, 66003, 'AKADEMI KOMUNITAS BPPMNU BANAT');
INSERT INTO "public"."universitas" VALUES (98948, 66004, 'AKADEMI KOMUNITAS AL-KAHFI');
INSERT INTO "public"."universitas" VALUES (98949, 66005, 'AKADEMI KOMUNITAS MIFTAHUS SA''ADAH GROBOGAN');
INSERT INTO "public"."universitas" VALUES (98950, 66006, 'AKADEMI KOMUNITAS ADIYASA');
INSERT INTO "public"."universitas" VALUES (98951, 71001, 'UNIVERSITAS 17 AGUSTUS 1945 SURABAYA');
INSERT INTO "public"."universitas" VALUES (100291, 105001, 'POLITEKNIK BATAM');
INSERT INTO "public"."universitas" VALUES (100292, 105002, 'POLITEKNIK CALTEX');
INSERT INTO "public"."universitas" VALUES (100293, 105003, 'POLITEKNIK TRI DHARMA');
INSERT INTO "public"."universitas" VALUES (100294, 105004, 'POLITEKNIK BENGKALIS');
INSERT INTO "public"."universitas" VALUES (100295, 105006, 'POLITEKNIK JAMBI');
INSERT INTO "public"."universitas" VALUES (100296, 105008, 'POLITEKNIK KESEHATAN SITEBA');
INSERT INTO "public"."universitas" VALUES (100297, 105009, 'POLITEKNIK KAMPAR');
INSERT INTO "public"."universitas" VALUES (100298, 105010, 'POLITEKNIK PARIWISATA BATAM');
INSERT INTO "public"."universitas" VALUES (100299, 105011, 'POLITEKNIK BINTAN CAKRAWALA');
INSERT INTO "public"."universitas" VALUES (100300, 106001, 'AKADEMI KOMUNITAS DIGITAL KREATIF MALAY BATAM');
INSERT INTO "public"."universitas" VALUES (100301, 111001, 'UNIVERSITAS 17 AGUSTUS 1945 SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100302, 111002, 'UNIVERSITAS ACHMAD YANI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100303, 111003, 'UNIVERSITAS ISLAM KALIMANTAN MUHAMMAD ARSYAD AL BANJARI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100304, 111004, 'UNIVERSITAS PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100305, 111005, 'UNIVERSITAS TRIDHARMA');
INSERT INTO "public"."universitas" VALUES (100306, 111006, 'UNIVERSITAS BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100307, 111007, 'UNIVERSITAS WIDYA GAMA MAHAKAM SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100308, 111008, 'UNIVERSITAS KUTAI KARTANEGARA TENGGARONG');
INSERT INTO "public"."universitas" VALUES (100309, 111009, 'UNIVERSITAS MUHAMMADIYAH PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100310, 111010, 'UNIVERSITAS KRISTEN PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100311, 111012, 'UNIVERSITAS TRUNAJAYA BONTANG');
INSERT INTO "public"."universitas" VALUES (100312, 111013, 'UNIVERSITAS MUHAMMADIYAH PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100313, 111014, 'UNIVERSITAS KAPUAS');
INSERT INTO "public"."universitas" VALUES (100314, 111015, 'UNIVERSITAS PGRI PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100315, 111016, 'UNIVERSITAS BORNEO TARAKAN');
INSERT INTO "public"."universitas" VALUES (100316, 111017, 'UNIVERSITAS ANTAKUSUMA');
INSERT INTO "public"."universitas" VALUES (100317, 111018, 'UNIVERSITAS DARWAN ALI');
INSERT INTO "public"."universitas" VALUES (100318, 111019, 'UNIVERSITAS KALTARA');
INSERT INTO "public"."universitas" VALUES (100319, 111020, 'UNIVERSITAS NAHDLATUL ULAMA KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (100320, 111021, 'UNIVERSITAS NAHDLATUL ULAMA KALIMANTAN SELATAN');
INSERT INTO "public"."universitas" VALUES (100321, 111022, 'UNIVERSITAS NAHDLATUL ULAMA KALIMANTAN BARAT');
INSERT INTO "public"."universitas" VALUES (100322, 111023, 'UNIVERSITAS MUHAMMADIYAH BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100323, 111024, 'UNIVERSITAS MUHAMMADIYAH KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (100324, 111025, 'UNIVERSITAS SARI MULIA');
INSERT INTO "public"."universitas" VALUES (100325, 111026, 'UNIVERSITAS MULIA');
INSERT INTO "public"."universitas" VALUES (100326, 111027, 'UNIVERSITAS WIDYA DHARMA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100327, 111028, 'UNIVERSITAS OSO');
INSERT INTO "public"."universitas" VALUES (100328, 111029, 'UNIVERSITAS CAHAYA BANGSA');
INSERT INTO "public"."universitas" VALUES (100329, 112001, 'IKIP PGRI KALTIM');
INSERT INTO "public"."universitas" VALUES (100330, 112002, 'IKIP PGRI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100331, 112003, 'INSTITUT SHANTI BHUANA');
INSERT INTO "public"."universitas" VALUES (100332, 112004, 'INSTITUT TEKNOLOGI KELING KUMANG');
INSERT INTO "public"."universitas" VALUES (100333, 113001, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100334, 113002, 'STIA BINA BANUA BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100335, 113003, 'STIMI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100336, 113004, 'SEKOLAH TINGGI ILMU HUKUM SULTAN ADAM');
INSERT INTO "public"."universitas" VALUES (100337, 113005, 'SEKOLAH TINGGI ILMU EKONOMI NASIONAL BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100338, 113006, 'STKIP PGRI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100339, 113007, 'SEKOLAH TINGGI ILMU EKONOMI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100340, 113008, 'STKIP PGRI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100341, 113009, 'SEKOLAH TINGGI ILMU HUKUM SOELTHAN M TSJAFIOEDDIN');
INSERT INTO "public"."universitas" VALUES (100342, 113010, 'SEKOLAH TINGGI ILMU EKONOMI BOEDI OETOMO');
INSERT INTO "public"."universitas" VALUES (100343, 113011, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100344, 113012, 'SEKOLAH TINGGI ILMU EKONOMI BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100345, 113013, 'SEKOLAH TINGGI ILMU KOMUNIKASI MAHAKAM');
INSERT INTO "public"."universitas" VALUES (100346, 113014, 'STMIK SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100347, 113016, 'SEKOLAH TINGGI ILMU EKONOMI PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100348, 113017, 'SEKOLAH TINGGI ILMU HUKUM TAMBUN BUNGAI');
INSERT INTO "public"."universitas" VALUES (100349, 113018, 'SEKOLAH TINGGI ILMU EKONOMI SAMPIT');
INSERT INTO "public"."universitas" VALUES (100350, 113019, 'SEKOLAH TINGGI ILMU HUKUM HABARING HURUNG SAMPIT');
INSERT INTO "public"."universitas" VALUES (100351, 113020, 'STKIP MUHAMMADIYAH SAMPIT');
INSERT INTO "public"."universitas" VALUES (100352, 113021, 'STIMI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100353, 113022, 'SEKOLAH TINGGI ILMU EKONOMI PANCASETIA');
INSERT INTO "public"."universitas" VALUES (100354, 113023, 'SEKOLAH TINGGI ILMU EKONOMI BULUNGAN TARAKAN');
INSERT INTO "public"."universitas" VALUES (100355, 113025, 'SEKOLAH TINGGI ILMU EKONOMI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100356, 113026, 'SEKOLAH TINGGI ILMU EKONOMI KUALA KAPUAS');
INSERT INTO "public"."universitas" VALUES (100357, 113027, 'STIE MUHAMMADIYAH TANJUNG REDEB');
INSERT INTO "public"."universitas" VALUES (100358, 113028, 'SEKOLAH TINGGI BAHASA ASING DINAMIK');
INSERT INTO "public"."universitas" VALUES (100359, 113029, 'STMIK PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100360, 113030, 'STMIK WIDYA CIPTA DHARMA');
INSERT INTO "public"."universitas" VALUES (100361, 113032, 'SEKOLAH TINGGI ILMU EKONOMI NASIONAL SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100362, 113033, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (100363, 113034, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100364, 113035, 'SEKOLAH TINGGI ILMU ADMINISTRASI AMUNTAI');
INSERT INTO "public"."universitas" VALUES (100365, 113036, 'SEKOLAH TINGGI ILMU EKONOMI MUARA TEWEH');
INSERT INTO "public"."universitas" VALUES (100366, 113038, 'STMIK BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100367, 113039, 'STIPER MUHAMMADIYAH TANAH GROGOT');
INSERT INTO "public"."universitas" VALUES (100368, 113041, 'SEKOLAH TINGGI TEKNOLOGI INDUSTRI BONTANG');
INSERT INTO "public"."universitas" VALUES (100369, 113042, 'SEKOLAH TINGGI ILMU BAHASA ASING PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100370, 113043, 'SEKOLAH TINGGI ILMU EKONOMI TANJUNG SELOR');
INSERT INTO "public"."universitas" VALUES (100371, 113045, 'SEKOLAH TINGGI ILMU EKONOMI DAHANI DAHANAI BUNTOK');
INSERT INTO "public"."universitas" VALUES (100372, 113046, 'SEKOLAH TINGGI PERTANIAN KUTAI TIMUR');
INSERT INTO "public"."universitas" VALUES (100373, 113047, 'SEKOLAH TINGGI PERTANIAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100374, 113048, 'STMIK BANJARBARU');
INSERT INTO "public"."universitas" VALUES (100375, 113049, 'SEKOLAH TINGGI TEKNOLOGI MIGAS');
INSERT INTO "public"."universitas" VALUES (100376, 113051, 'SEKOLAH TINGGI ILMU KESEHATAN CAHAYA BANGSA');
INSERT INTO "public"."universitas" VALUES (100377, 113052, 'STIKES MUHAMMADIYAH BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100378, 113053, 'SEKOLAH TINGGI ILMU PERTANIAN BERAU');
INSERT INTO "public"."universitas" VALUES (100379, 113054, 'SEKOLAH TINGGI ILMU PERTANIAN AMUNTAI');
INSERT INTO "public"."universitas" VALUES (100380, 113055, 'STMIK INDONESIA BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (101588, 213652, 'SEKOLAH TINGGI EKONOMI ISLAM AL FURQOON PRABUMULIH SUMATERA SELATAN');
INSERT INTO "public"."universitas" VALUES (101589, 213653, 'SEKOLAH TINGGI ILMU EKONOMI ISLAM JAKARTA');
INSERT INTO "public"."universitas" VALUES (101590, 213654, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM PERSATUAN UMAT ISLAM BOGOR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101591, 213655, 'SEKOLAH TINGGI AGAMA ISLAM NAHDLATUL ULAMA KEPULAUAN RIAU');
INSERT INTO "public"."universitas" VALUES (101592, 213656, 'SEKOLAH TINGGI ILMU EKONOMI DAN BISNIS SYARIAH NAHDLATUL ULAMA GARUT');
INSERT INTO "public"."universitas" VALUES (101593, 213657, 'SEKOLAH TINGGI ILMU TARBIYAH ASSUNNIYAH TAMBARANGAN RANTAU TAPIN');
INSERT INTO "public"."universitas" VALUES (101594, 213658, 'SEKOLAH TINGGI ILMU EKONOMI SYARI''AH BABUSSALAM');
INSERT INTO "public"."universitas" VALUES (101595, 213659, 'SEKOLAH TINGGI AGAMA ISLAM NURUL ARAFAH PANTON LABU ACEH UTARA');
INSERT INTO "public"."universitas" VALUES (101596, 213660, 'SEKOLAH TINGGI ILMU AL-QUR''AN ZAD CIANJUR');
INSERT INTO "public"."universitas" VALUES (101597, 213661, 'SEKOLAH TINGGI ILMU SYARIAH AL-SYAIKH ABDUL WAHID BAU-BAU');
INSERT INTO "public"."universitas" VALUES (101598, 213662, 'SEKOLAH TINGGI ILMU TARBIYAH AL-MATHIRIYAH MURATARA');
INSERT INTO "public"."universitas" VALUES (101599, 213663, 'SEKOLAH TINGGI ILMU TARBIYAH MAMBA''UL HIKAM PALI SUMSEL');
INSERT INTO "public"."universitas" VALUES (101600, 213664, 'SEKOLAH TINGGI ILMU TARBIYAH TANGGAMUS');
INSERT INTO "public"."universitas" VALUES (101601, 213665, 'SEKOLAH TINGGI AGAMA ISLAM TANBIHUL GHOFILIN BANJARNEGARA');
INSERT INTO "public"."universitas" VALUES (101602, 213666, 'SEKOLAH TINGGI ILMU TARBIYAH NUR AHADIYAH');
INSERT INTO "public"."universitas" VALUES (101603, 213667, 'SEKOLAH TINGGI ILMU TARBIYAH QURROTA AYUN');
INSERT INTO "public"."universitas" VALUES (101604, 213668, 'SEKOLAH TINGGI AGAMA ISLAM KH BADRUZZAMAN');
INSERT INTO "public"."universitas" VALUES (101605, 213669, 'SEKOLAH TINGGI ILMU TARBIYAH FATAHILLAH');
INSERT INTO "public"."universitas" VALUES (101606, 213670, 'SEKOLAH TINGGI ILMU TARBIYAH MUHAMMAD MARDIYANA');
INSERT INTO "public"."universitas" VALUES (101607, 213671, 'SEKOLAH TINGGI ILMU TARBIYAH LAKBOK');
INSERT INTO "public"."universitas" VALUES (101608, 213672, 'SEKOLAH TINGGI AGAMA ISLAM AL FALAH PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (101609, 213673, 'SEKOLAH TINGGI AGAMA ISLAM IMAM BUKHORI BULUKUMBA');
INSERT INTO "public"."universitas" VALUES (101610, 213674, 'SEKOLAH TINGGI ILMU ADAB DAN BUDAYA ISLAM RIYADUL ''ULUM');
INSERT INTO "public"."universitas" VALUES (101611, 213675, 'SEKOLAH TINGGI EKONOMI ISLAM AR-RISALAH SUMATERA BARAT');
INSERT INTO "public"."universitas" VALUES (101612, 213676, 'SEKOLAH TINGGI EKONOMI ISLAM YAPISHA GARUT');
INSERT INTO "public"."universitas" VALUES (101613, 213677, 'SEKOLAH TINGGI EKONOMI BISNIS ISLAM LIWA');
INSERT INTO "public"."universitas" VALUES (101614, 213678, 'SEKOLAH TINGGI EKONOMI BISNIS ISLAM BINA ESSA');
INSERT INTO "public"."universitas" VALUES (101615, 213679, 'SEKOLAH TINGGI EKONOMI BISNIS ISLAM SYARI''AH BINA MANDIRI CILEUNGSU BOGOR');
INSERT INTO "public"."universitas" VALUES (101616, 213680, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM AL-ANWAR BANGKALAN');
INSERT INTO "public"."universitas" VALUES (101617, 213681, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM BATAM');
INSERT INTO "public"."universitas" VALUES (101618, 213682, 'SEKOLAH TINGGI EKONOMI MANAJEMEN BISNIS ISLAM AL-AZIZIYAH RANDUDONGKAL PEMALANG');
INSERT INTO "public"."universitas" VALUES (101619, 213683, 'SEKOLAH TINGGI ILMU SYARIAH NURUL QARNAIN');
INSERT INTO "public"."universitas" VALUES (101620, 213684, 'SEKOLAH TINGGI ILMU TARBIYAH AL-HADY BOMBANA');
INSERT INTO "public"."universitas" VALUES (101621, 213685, 'SEKOLAH TINGGI ILMU USHULUDDIN DARUL QURAN');
INSERT INTO "public"."universitas" VALUES (101622, 213686, 'SEKOLAH TINGGI AGAMA ISLAM AL-AKBAR SURABAYA');
INSERT INTO "public"."universitas" VALUES (101623, 213687, 'SEKOLAH TINGGI AGAMA ISLAM KUPANG');
INSERT INTO "public"."universitas" VALUES (101624, 213688, 'SEKOLAH TINGGI ILMU SYARIAH AL WAFA');
INSERT INTO "public"."universitas" VALUES (101625, 213689, 'SEKOLAH TINGGI AGAMA ISLAM AL ITTIHAD CIANJUR JAWA BARAT');
INSERT INTO "public"."universitas" VALUES (101626, 213691, 'SEKOLAH TINGGI EKONOMI DAN BISNIS ISLAM BADRI MASHDUQI');
INSERT INTO "public"."universitas" VALUES (101627, 213692, 'SEKOLAH TINGGI AGAMA ISLAM DARUSSALAM KUNIR');
INSERT INTO "public"."universitas" VALUES (101628, 213693, 'SEKOLAH TINGGI ILMU EKONOMI DAN BISNIS SYARIAH RACHMATOELLAH SERANG');
INSERT INTO "public"."universitas" VALUES (101629, 213694, 'SEKOLAH TINGGI EKONOMI ISLAM PERMATA BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (101630, 213695, 'SEKOLAH TINGGI AGAMA ISLAM PERSATUAN ISLAM JAKARTA');
INSERT INTO "public"."universitas" VALUES (101631, 213696, 'SEKOLAH TINGGI AGAMA ISLAM DAARUT TAUHIID');
INSERT INTO "public"."universitas" VALUES (101632, 213698, 'SEKOLAH TINGGI ISLAM SUNNIYYAH SELO GROBOGAN');
INSERT INTO "public"."universitas" VALUES (101633, 213699, 'SEKOLAH TINGGI AGAMA ISLAM SAMARINDA');
INSERT INTO "public"."universitas" VALUES (101634, 213700, 'SEKOLAH TINGGI ILMU TARBIYAH DARUL ISHLAH');
INSERT INTO "public"."universitas" VALUES (101635, 213701, 'SEKOLAH TINGGI EKONOMI ISLAM NAHDLATUL ULAMA ARRIDHO DEPOK');
INSERT INTO "public"."universitas" VALUES (101636, 213703, 'SEKOLAH TINGGI AGAMA ISLAM AL-UTSMANI BONDOWOSO');
INSERT INTO "public"."universitas" VALUES (101637, 213704, 'SEKOLAH TINGGI ILMU SYARIAH SUBULUSSALAM');
INSERT INTO "public"."universitas" VALUES (101638, 213705, 'SEKOLAH TINGGI AGAMA ISLAM AHMAD SIBAWAYHIE');
INSERT INTO "public"."universitas" VALUES (101639, 214001, 'SEKOLAH TINGGI EKONOMI ISLAM (STEI) AL-ARSYADI KALIMANTAN TIMUR');
INSERT INTO "public"."universitas" VALUES (101640, 214002, 'SEKOLAH TINGGI ILMU TARBIYAH (STIT) MUMTAZ');
INSERT INTO "public"."universitas" VALUES (101641, 214003, 'SEKOLAH TINGGI ILMU TARBIYAH AL WASHLIYAH ACEH TENGAH');
INSERT INTO "public"."universitas" VALUES (101642, 214004, 'SEKOLAH TINGGI ILMU AL QURAN AL MULTAZAM');
INSERT INTO "public"."universitas" VALUES (101643, 214005, 'SEKOLAH TINGGI ILMU EKONOMI SYARI''AH ALIFA PRINGSEWU LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101644, 214006, 'INSTITUT AGAMA ISLAM AL MAWADDAH WARRAHMAH KOLAKA SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (101645, 214007, 'SEKOLAH TINGGI AGAMA ISLAM AL-HIDAYAH');
INSERT INTO "public"."universitas" VALUES (101646, 214008, 'SEKOLAH TINGGI ILMU TARBIYAH HIDAYATUNNAJAH BEKASI');
INSERT INTO "public"."universitas" VALUES (101647, 222001, 'INSTITUT AGAMA KRISTEN NEGERI TARUTUNG');
INSERT INTO "public"."universitas" VALUES (101648, 222002, 'INSTITUT AGAMA KRISTEN NEGERI MANADO');
INSERT INTO "public"."universitas" VALUES (101649, 222003, 'INSTITUT AGAMA KRISTEN NEGERI AMBON');
INSERT INTO "public"."universitas" VALUES (101650, 223001, 'STAK NEGERI TARUTUNG');
INSERT INTO "public"."universitas" VALUES (101651, 223002, 'STAK NEGERI PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (101652, 223003, 'STAK NEGERI MANADO');
INSERT INTO "public"."universitas" VALUES (98952, 71002, 'UNIVERSITAS KRISTEN PETRA');
INSERT INTO "public"."universitas" VALUES (98953, 71003, 'UNIVERSITAS KATOLIK WIDYA MANDALA SURABAYA');
INSERT INTO "public"."universitas" VALUES (98954, 71004, 'UNIVERSITAS SURABAYA');
INSERT INTO "public"."universitas" VALUES (98955, 71005, 'UNIVERSITAS DR SOETOMO');
INSERT INTO "public"."universitas" VALUES (98956, 71006, 'UNIVERSITAS MERDEKA SURABAYA');
INSERT INTO "public"."universitas" VALUES (98957, 71007, 'UNIVERSITAS SUNAN GIRI');
INSERT INTO "public"."universitas" VALUES (98958, 71008, 'UNIVERSITAS NAROTAMA');
INSERT INTO "public"."universitas" VALUES (98959, 71009, 'UNIVERSITAS WIJAYA KUSUMA SURABAYA');
INSERT INTO "public"."universitas" VALUES (98960, 71010, 'UNIVERSITAS BHAYANGKARA SURABAYA');
INSERT INTO "public"."universitas" VALUES (98961, 71011, 'UNIVERSITAS WIJAYA PUTRA');
INSERT INTO "public"."universitas" VALUES (98962, 71012, 'UNIVERSITAS MUHAMMADIYAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (98963, 71013, 'UNIVERSITAS YOS SUDARSO');
INSERT INTO "public"."universitas" VALUES (98964, 71014, 'UNIVERSITAS W R SUPRATMAN');
INSERT INTO "public"."universitas" VALUES (98965, 71016, 'UNIVERSITAS 45 SURABAYA');
INSERT INTO "public"."universitas" VALUES (98966, 71017, 'UNIVERSITAS WIDYA KARTIKA');
INSERT INTO "public"."universitas" VALUES (98967, 71018, 'UNIVERSITAS KARTINI');
INSERT INTO "public"."universitas" VALUES (98968, 71019, 'UNIVERSITAS KATOLIK DARMA CENDIKA');
INSERT INTO "public"."universitas" VALUES (98969, 71020, 'UNIVERSITAS GRESIK');
INSERT INTO "public"."universitas" VALUES (98970, 71022, 'UNIVERSITAS MAYJEN SUNGKONO');
INSERT INTO "public"."universitas" VALUES (98971, 71023, 'UNIVERSITAS DARUL ULUM');
INSERT INTO "public"."universitas" VALUES (98972, 71024, 'UNIVERSITAS MUHAMMADIYAH MALANG');
INSERT INTO "public"."universitas" VALUES (98973, 71025, 'UNIVERSITAS MERDEKA MALANG');
INSERT INTO "public"."universitas" VALUES (98974, 71026, 'UNIVERSITAS KATOLIK WIDYA KARYA');
INSERT INTO "public"."universitas" VALUES (98975, 71027, 'UNIVERSITAS ISLAM MALANG');
INSERT INTO "public"."universitas" VALUES (98976, 71028, 'UNIVERSITAS WISNUWARDHANA');
INSERT INTO "public"."universitas" VALUES (98977, 71029, 'UNIVERSITAS KRISTEN CIPTA WACANA');
INSERT INTO "public"."universitas" VALUES (98978, 71030, 'UNIVERSITAS WIDYA GAMA');
INSERT INTO "public"."universitas" VALUES (98979, 71031, 'UNIVERSITAS MERDEKA PASURUAN');
INSERT INTO "public"."universitas" VALUES (98980, 71032, 'UNIVERSITAS MUHAMMADIYAH JEMBER');
INSERT INTO "public"."universitas" VALUES (98981, 71033, 'UNIVERSITAS MOCHAMMAD SROEDJI');
INSERT INTO "public"."universitas" VALUES (98982, 71034, 'UNIVERSITAS ISLAM JEMBER');
INSERT INTO "public"."universitas" VALUES (98983, 71035, 'UNIVERSITAS 17 AGUSTUS 1945 BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (98984, 71036, 'UNIVERSITAS ABDURACHMAN SALEH');
INSERT INTO "public"."universitas" VALUES (98985, 71037, 'UNIVERSITAS BONDOWOSO');
INSERT INTO "public"."universitas" VALUES (98986, 71038, 'UNIVERSITAS PANCA MARGA');
INSERT INTO "public"."universitas" VALUES (98987, 71039, 'UNIVERSITAS KADIRI');
INSERT INTO "public"."universitas" VALUES (98988, 71040, 'UNIVERSITAS ISLAM KADIRI');
INSERT INTO "public"."universitas" VALUES (98989, 71041, 'UNIVERSITAS TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (98990, 71042, 'UNIVERSITAS MERDEKA MADIUN');
INSERT INTO "public"."universitas" VALUES (98991, 71043, 'UNIVERSITAS MERDEKA PONOROGO');
INSERT INTO "public"."universitas" VALUES (98992, 71044, 'UNIVERSITAS MUHAMMADIYAH PONOROGO');
INSERT INTO "public"."universitas" VALUES (98993, 71045, 'UNIVERSITAS SOERJO');
INSERT INTO "public"."universitas" VALUES (98994, 71046, 'UNIVERSITAS BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (98995, 71047, 'UNIVERSITAS SUNAN BONANG');
INSERT INTO "public"."universitas" VALUES (98996, 71048, 'UNIVERSITAS MADURA');
INSERT INTO "public"."universitas" VALUES (98997, 71049, 'UNIVERSITAS PGRI ADI BUANA');
INSERT INTO "public"."universitas" VALUES (98998, 71050, 'UNIVERSITAS KANJURUHAN');
INSERT INTO "public"."universitas" VALUES (98999, 71051, 'UNIVERSITAS GAJAYANA');
INSERT INTO "public"."universitas" VALUES (99000, 71052, 'UNIVERSITAS PAWYATAN DAHA');
INSERT INTO "public"."universitas" VALUES (99001, 71053, 'UNIVERSITAS KATOLIK WIDYA MANDALA MADIUN');
INSERT INTO "public"."universitas" VALUES (99002, 71054, 'UNIVERSITAS TRI TUNGGAL');
INSERT INTO "public"."universitas" VALUES (99003, 71055, 'UNIVERSITAS LUMAJANG');
INSERT INTO "public"."universitas" VALUES (99004, 71056, 'UNIVERSITAS HANG TUAH');
INSERT INTO "public"."universitas" VALUES (99005, 71057, 'UNIVERSITAS TEKNOLOGI SURABAYA');
INSERT INTO "public"."universitas" VALUES (99006, 71058, 'UNIVERSITAS WIRARAJA');
INSERT INTO "public"."universitas" VALUES (99007, 71059, 'UNIVERSITAS MUHAMMADIYAH GRESIK');
INSERT INTO "public"."universitas" VALUES (99008, 71060, 'UNIVERSITAS MUHAMMADIYAH SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99009, 71061, 'UNIVERSITAS TRIBHUWANA TUNGGA DEWI');
INSERT INTO "public"."universitas" VALUES (99010, 71062, 'UNIVERSITAS ISLAM DARUL `ULUM');
INSERT INTO "public"."universitas" VALUES (99011, 71064, 'UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JATIM');
INSERT INTO "public"."universitas" VALUES (99012, 71065, 'UNIVERSITAS PESANTREN TINGGI DARUL ULUM');
INSERT INTO "public"."universitas" VALUES (99013, 71066, 'UNIVERSITAS ISLAM MAJAPAHIT');
INSERT INTO "public"."universitas" VALUES (99014, 71067, 'UNIVERSITAS ISLAM LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99015, 71068, 'UNIVERSITAS ISLAM MADURA');
INSERT INTO "public"."universitas" VALUES (99016, 71069, 'UNIVERSITAS YUDHARTA PASURUAN');
INSERT INTO "public"."universitas" VALUES (99017, 71070, 'UNIVERSITAS ISLAM BALITAR');
INSERT INTO "public"."universitas" VALUES (99018, 71071, 'UNIVERSITAS CIPUTRA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99019, 71072, 'UNIVERSITAS NUSANTARA PGRI KEDIRI');
INSERT INTO "public"."universitas" VALUES (99020, 71073, 'UNIVERSITAS PGRI RONGGOLAWE');
INSERT INTO "public"."universitas" VALUES (99021, 71074, 'UNIVERSITAS MA CHUNG');
INSERT INTO "public"."universitas" VALUES (99022, 71075, 'UNIVERSITAS PGRI BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99023, 71076, 'UNIVERSITAS CAKRAWALA');
INSERT INTO "public"."universitas" VALUES (99024, 71077, 'UNIVERSITAS PELITA HARAPAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (99025, 71078, 'UNIVERSITAS BAKTI INDONESIA');
INSERT INTO "public"."universitas" VALUES (99026, 71079, 'UNIVERSITAS NAHDLATUL ULAMA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99027, 71080, 'UNIVERSITAS HASYIM ASY''ARI TEBUIRENG JOMBANG');
INSERT INTO "public"."universitas" VALUES (99028, 71081, 'UNIVERSITAS KH. A. WAHAB HASBULLAH');
INSERT INTO "public"."universitas" VALUES (99029, 71082, 'UNIVERSITAS NAHDLATUL ULAMA SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99030, 71083, 'UNIVERSITAS KAHURIPAN KEDIRI');
INSERT INTO "public"."universitas" VALUES (99031, 71084, 'UNIVERSITAS ISLAM RADEN RAHMAT');
INSERT INTO "public"."universitas" VALUES (99032, 71086, 'UNIVERSITAS MAARIF HASYIM LATIF');
INSERT INTO "public"."universitas" VALUES (99033, 71087, 'UNIVERSITAS WAHIDIYAH');
INSERT INTO "public"."universitas" VALUES (99034, 71088, 'UNIVERSITAS NAHDLATUL ULAMA SUNAN GIRI');
INSERT INTO "public"."universitas" VALUES (99035, 71089, 'UNIVERSITAS INTERNASIONAL SEMEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99036, 71090, 'UNIVERSITAS NAHDLATUL ULAMA BLITAR');
INSERT INTO "public"."universitas" VALUES (99037, 71091, 'UNIVERSITAS PGRI MADIUN');
INSERT INTO "public"."universitas" VALUES (99038, 71092, 'UNIVERSITAS DOKTOR NUGROHO MAGETAN');
INSERT INTO "public"."universitas" VALUES (99039, 71093, 'UNIVERSITAS BILLFATH');
INSERT INTO "public"."universitas" VALUES (99040, 71094, 'UNIVERSITAS NURUL JADID');
INSERT INTO "public"."universitas" VALUES (99041, 71095, 'UNIVERSITAS IBRAHIMY');
INSERT INTO "public"."universitas" VALUES (99042, 71096, 'UNIVERSITAS MUHAMMADIYAH LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99043, 71097, 'UNIVERSITAS QOMARUDDIN');
INSERT INTO "public"."universitas" VALUES (99044, 71098, 'UNIVERSITAS KH. BAHAUDIN MUDHARY MADURA');
INSERT INTO "public"."universitas" VALUES (99045, 71099, 'UNIVERSITAS DINAMIKA');
INSERT INTO "public"."universitas" VALUES (99046, 71100, 'UNIVERSITAS PGRI WIRANEGARA');
INSERT INTO "public"."universitas" VALUES (99047, 71101, 'UNIVERSITAS BHINNEKA PGRI');
INSERT INTO "public"."universitas" VALUES (99048, 71102, 'UNIVERSITAS MUHAMMADIYAH MADIUN');
INSERT INTO "public"."universitas" VALUES (99049, 72001, 'INSTITUT TEKNOLOGI PEMBANGUNAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (99050, 72002, 'INSTITUT TEKNOLOGI ADHI TAMA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99051, 72003, 'IKIP WIDYA DARMA');
INSERT INTO "public"."universitas" VALUES (99052, 72004, 'INSTITUT TEKNOLOGI NASIONAL MALANG');
INSERT INTO "public"."universitas" VALUES (99053, 72005, 'IKIP BUDI UTOMO');
INSERT INTO "public"."universitas" VALUES (100381, 113056, 'SEKOLAH TINGGI TEKNOLOGI BONTANG');
INSERT INTO "public"."universitas" VALUES (100382, 113057, 'SEKOLAH TINGGI ILMU ADMINISTRASI TABALONG');
INSERT INTO "public"."universitas" VALUES (100383, 113058, 'SEKOLAH TINGGI ILMU EKONOMI TENGGARONG');
INSERT INTO "public"."universitas" VALUES (100384, 113059, 'STIE YBPK PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100385, 113060, 'STIK MUHAMMADIYAH PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100386, 113061, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA PRAJA');
INSERT INTO "public"."universitas" VALUES (100387, 113062, 'STKIP PERSADA KHATULISTIWA');
INSERT INTO "public"."universitas" VALUES (100388, 113063, 'STIKES SUAKA INSAN');
INSERT INTO "public"."universitas" VALUES (100389, 113064, 'SEKOLAH TINGGI ILMU PENDIDIKAN BUNGA BANGSA');
INSERT INTO "public"."universitas" VALUES (100390, 113065, 'SEKOLAH TINGGI ILMU EKONOMI MULIA SINGKAWANG');
INSERT INTO "public"."universitas" VALUES (100391, 113066, 'STMIK PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (100392, 113067, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN MELAWI');
INSERT INTO "public"."universitas" VALUES (100393, 113068, 'STMIK WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (100394, 113070, 'STMIK SENTRA PENDIDIKAN BISNIS');
INSERT INTO "public"."universitas" VALUES (100395, 113071, 'STIKES HUSADA BORNEO');
INSERT INTO "public"."universitas" VALUES (100396, 113072, 'STIKES WIYATA HUSADA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100397, 113073, 'STIKES DARUL AZHAR BATULICIN');
INSERT INTO "public"."universitas" VALUES (100398, 113074, 'SEKOLAH TINGGI ILMU HUKUM KUALA KAPUAS');
INSERT INTO "public"."universitas" VALUES (100399, 113075, 'STMIK PPKIA TARAKANITA RAHMAWATI TARAKAN');
INSERT INTO "public"."universitas" VALUES (100400, 113076, 'STIE MADANI BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100401, 113077, 'STIKES SARI MULIA');
INSERT INTO "public"."universitas" VALUES (100402, 113078, 'STMIK BORNEO INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (100403, 113079, 'SEKOLAH TINGGI ILMU EKONOMI NUSANTARA SANGATTA');
INSERT INTO "public"."universitas" VALUES (100404, 113080, 'STKIP PARIS BARANTAI');
INSERT INTO "public"."universitas" VALUES (100405, 113081, 'STIKES KAPUAS RAYA');
INSERT INTO "public"."universitas" VALUES (100406, 113082, 'STIKES MUHAMMADIYAH SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100407, 113083, 'STIKES YARSI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100408, 113084, 'STIKES EKA HARAP');
INSERT INTO "public"."universitas" VALUES (100409, 113085, 'STKIP SINGKAWANG');
INSERT INTO "public"."universitas" VALUES (100410, 113086, 'STKIP PAMANE TALINO');
INSERT INTO "public"."universitas" VALUES (100411, 113087, 'SEKOLAH TINGGI ILMU KESEHATAN BORNEO LESTARI');
INSERT INTO "public"."universitas" VALUES (100412, 113088, 'SEKOLAH TINGGI BAHASA ASING PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100413, 113089, 'STIKES BORNEO CENDEKIA MEDIKA');
INSERT INTO "public"."universitas" VALUES (100414, 113090, 'SEKOLAH TINGGI BAHASA HARAPAN BERSAMA');
INSERT INTO "public"."universitas" VALUES (100415, 113091, 'SEKOLAH TINGGI ILMU MANAJEMEN SHANTI BHUANA');
INSERT INTO "public"."universitas" VALUES (100416, 113092, 'SEKOLAH TINGGI ILMU HUKUM AWANG LONG');
INSERT INTO "public"."universitas" VALUES (100417, 113093, 'STKIP ISLAM SABILAL MUHTADIN BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100418, 113094, 'STIKES DIRGAHAYU SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100419, 113095, 'SEKOLAH TINGGI ILMU KESEHATAN SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100420, 113096, 'SEKOLAH TINGGI ILMU KESEHATAN SAMBAS');
INSERT INTO "public"."universitas" VALUES (100421, 113097, 'SEKOLAH TINGGI ILMU KESEHATAN INTAN MARTAPURA');
INSERT INTO "public"."universitas" VALUES (100422, 113098, 'SEKOLAH TINGGI ILMU KESEHATAN MUTIARA MAHAKAM SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100423, 113099, 'SEKOLAH TINGGI ILMU KESEHATAN ISFI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100424, 114003, 'AKADEMI TEKNIK PEMBANGUNAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (100425, 114005, 'AKADEMI MANAJEMEN KOPERASI BARABAI');
INSERT INTO "public"."universitas" VALUES (100426, 114008, 'AKADEMI MANAJEMEN PERUSAHAAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100427, 114011, 'AKADEMI SEKRETARI & MANAJEMEN WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (100428, 114016, 'ASMI KMPI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100429, 114025, 'AKADEMI KEUANGAN & PERBANKAN GRHA ARTA KATULISTIWA');
INSERT INTO "public"."universitas" VALUES (100430, 114033, 'AKADEMI SEKRETARI DAN MANAJEMEN INDONESIA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100431, 114034, 'AKADEMI BAHASA ASING PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100432, 114035, 'AKADEMI PARIWISATA NASIONAL SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100433, 114036, 'AKADEMI AKUNTANSI BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100434, 114039, 'AKADEMI MARITIM NUSANTARA BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100435, 114041, 'AKADEMI BAHASA ASING BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100436, 114042, 'AKADEMI BAHASA ASING COLORADO SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100437, 114043, 'AKADEMI KEPERAWATAN DIRGAHAYU SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100438, 114045, 'AKADEMI KESEHATAN LINGKUNGAN MUHAMMADIYAHSAMARINDA');
INSERT INTO "public"."universitas" VALUES (100439, 114046, 'AKADEMI KEPERAWATAN MUHAMMADIYAH SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100440, 114047, 'AKADEMI BAHASA ASING WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (100441, 114048, 'AKADEMI MARITIM INDONESIA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100442, 114049, 'AMIK PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100443, 114050, 'AKADEMI PERPAJAKAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100444, 114052, 'AKADEMI BISNIS INTERNASIONAL SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100445, 114053, 'AKADEMI SEKRETARI INDONESIA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100446, 114054, 'AKADEMI FARMASI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100447, 114058, 'AKADEMI PARIWISATA NASIONAL BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100448, 114059, 'AKADEMI KEBIDANAN MARTAPURA');
INSERT INTO "public"."universitas" VALUES (100449, 114061, 'AKADEMI MANAJEMEN BUMI SEBALO BENGKAYANG');
INSERT INTO "public"."universitas" VALUES (100450, 114062, 'AMIK PPKIA TARAKANITA RAHMAWATI TARAKAN');
INSERT INTO "public"."universitas" VALUES (100452, 114064, 'AKADEMI AGROBISNIS BUMI SEBALO');
INSERT INTO "public"."universitas" VALUES (100453, 114065, 'AKADEMI KEPERAWATAN KALTARA TARAKAN');
INSERT INTO "public"."universitas" VALUES (100454, 114066, 'AKADEMI KEPERAWATAN YARSI SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100455, 114067, 'AKADEMI KEBIDANAN BUNGA KALIMANTAN');
INSERT INTO "public"."universitas" VALUES (100456, 114068, 'AKADEMI KEBIDANAN SARI MULIA');
INSERT INTO "public"."universitas" VALUES (100457, 114069, 'AKADEMI KEPERAWATAN BETHESDA SERUKAM');
INSERT INTO "public"."universitas" VALUES (100458, 114070, 'AKADEMI MANAJEMEN KOMPUTER DAN INFORMATIKA KETAPANG');
INSERT INTO "public"."universitas" VALUES (100459, 114071, 'AKADEMI KEBIDANAN SINGKAWANG');
INSERT INTO "public"."universitas" VALUES (100460, 114073, 'AKADEMI KEPERAWATAN PANDAN HARUM BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100461, 114074, 'AKADEMI KEBIDANAN AISYIYAH PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100462, 114076, 'AKADEMI KEBIDANAN BETANG ASI RAYA');
INSERT INTO "public"."universitas" VALUES (100463, 114077, 'AKADEMI KEBIDANAN BUNGA HUSADA');
INSERT INTO "public"."universitas" VALUES (100464, 114078, 'AKADEMI KEBIDANAN BORNEO MEDISTRA');
INSERT INTO "public"."universitas" VALUES (100465, 114079, 'AKADEMI FARMASI YARSI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100466, 114080, 'AKADEMI KEBIDANAN BAKTI INDONESIA BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100467, 114081, 'AKADEMI KEBIDANAN PERMATA HUSADA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (101653, 223004, 'STAK NEGERI AMBON');
INSERT INTO "public"."universitas" VALUES (101654, 223005, 'STAK NEGERI KUPANG');
INSERT INTO "public"."universitas" VALUES (101655, 223006, 'STAK NEGERI SENTANI');
INSERT INTO "public"."universitas" VALUES (101656, 223007, 'STAK NEGERI TORAJA');
INSERT INTO "public"."universitas" VALUES (101657, 231001, 'UNIVERSITAS KRISTEN INDONESIA TOMOHON');
INSERT INTO "public"."universitas" VALUES (101658, 232001, 'INSTITUT AGAMA DAN KEAGAMAAN OIKUMENE INDONESIA TIMUR AMBON');
INSERT INTO "public"."universitas" VALUES (101659, 232002, 'INSTITUT KRISTEN BORNEO');
INSERT INTO "public"."universitas" VALUES (101660, 232003, 'INSTITUT INJIL INDONESIA');
INSERT INTO "public"."universitas" VALUES (101661, 233001, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101662, 233002, 'SEKOLAH TINGGI TEOLOGI JAKARTA');
INSERT INTO "public"."universitas" VALUES (101663, 233003, 'STT BETHEL INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101664, 233004, 'SEKOLAH TINGGI TEOLOGI INJILI ARASTAMAR (SETIA) JAKARTA');
INSERT INTO "public"."universitas" VALUES (101665, 233005, 'SEKOLAH TINGGI TEOLOGI JAFFRAY JAKARTA');
INSERT INTO "public"."universitas" VALUES (101666, 233006, 'SEKOLAH TINGGI ALKITAB TIRANUS BANDUNG');
INSERT INTO "public"."universitas" VALUES (101667, 233007, 'SEKOLAH TINGGI TEOLOGI BAPTIS BANDUNG');
INSERT INTO "public"."universitas" VALUES (101668, 233008, 'SEKOLAH TINGGI TEOLOGI KHARISMA BANDUNG');
INSERT INTO "public"."universitas" VALUES (101669, 233009, 'SEKOLAH TINGGI TEOLOGI BETHESDA');
INSERT INTO "public"."universitas" VALUES (101670, 233010, 'SEKOLAH TINGGI TEOLOGI KADESI BOGOR');
INSERT INTO "public"."universitas" VALUES (101671, 233011, 'SEKOLAH TINGGI TEOLOGI CIANJUR');
INSERT INTO "public"."universitas" VALUES (101672, 233012, 'SEKOLAH TINGGI TEOLOGI CIPANAS');
INSERT INTO "public"."universitas" VALUES (101673, 233013, 'STT INTERNASIONAL HARVEST TANGERANG');
INSERT INTO "public"."universitas" VALUES (101674, 233014, 'STT PRESBYTERIAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (101675, 233015, 'SEKOLAH TINGGI TEOLOGI BERITA HIDUP');
INSERT INTO "public"."universitas" VALUES (101676, 233016, 'SEKOLAH TINGGI TEOLOGI BAPTIS INDONESIA');
INSERT INTO "public"."universitas" VALUES (101677, 233017, 'SEKOLAH TINGGI TEOLOGI INTHEOS SURAKARTA');
INSERT INTO "public"."universitas" VALUES (101678, 233018, 'SEKOLAH TINGGI TEOLOGI EFATA SALATIGA');
INSERT INTO "public"."universitas" VALUES (101679, 233019, 'STT RHEMA SALATIGA');
INSERT INTO "public"."universitas" VALUES (101680, 233020, 'SEKOLAH TINGGI TEOLOGI ABDIEL UNGARAN');
INSERT INTO "public"."universitas" VALUES (101681, 233021, 'SEKOLAH TINGGI TEOLOGI MAGELANG');
INSERT INTO "public"."universitas" VALUES (101682, 233022, 'SEKOLAH TINGGI TEOLOGI DIAKONOS');
INSERT INTO "public"."universitas" VALUES (101683, 233023, 'SEKOLAH TINGGI TEOLOGI PATRIA BLITAR');
INSERT INTO "public"."universitas" VALUES (101684, 233024, 'SEKOLAH TINGGI ALKITAB JEMBER');
INSERT INTO "public"."universitas" VALUES (101685, 233025, 'SEKOLAH TINGGI TEOLOGI DUTA PANISAL JEMBER');
INSERT INTO "public"."universitas" VALUES (101686, 233026, 'SEKOLAH TINGGI PENDIDIKAN AGAMA KRISTEN (STIPAK) MALANG');
INSERT INTO "public"."universitas" VALUES (101687, 233027, 'SEKOLAH TINGGI TEOLOGI YESTOYA MALANG');
INSERT INTO "public"."universitas" VALUES (101688, 233028, 'SEKOLAH TINGGI TEOLOGI SAAT');
INSERT INTO "public"."universitas" VALUES (101689, 233029, 'SEKOLAH TINGGI ALKITAB SURABAYA');
INSERT INTO "public"."universitas" VALUES (101690, 233030, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA SURABAYA');
INSERT INTO "public"."universitas" VALUES (101691, 233031, 'SEKOLAH TINGGI TEOLOGI INJILI ABDI ALLAH');
INSERT INTO "public"."universitas" VALUES (101692, 233032, 'SEKOLAH TINGGI ALKITAB NUSANTARA');
INSERT INTO "public"."universitas" VALUES (101693, 233033, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101694, 233034, 'SEKOLAH TINGGI AGAMA KRISTEN MARTURIA YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101695, 233035, 'SEKOLAH TINGGI THEOLOGIA NAZARENE INDONESIA');
INSERT INTO "public"."universitas" VALUES (101696, 233036, 'SEKOLAH TINGGI TEOLOGI JOHANES CALVIN BALI');
INSERT INTO "public"."universitas" VALUES (101697, 233037, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA BALI');
INSERT INTO "public"."universitas" VALUES (101698, 233038, 'SEKOLAH TINGGI TEOLOGI ABDI SABDA MEDAN');
INSERT INTO "public"."universitas" VALUES (101699, 233039, 'SEKOLAH TINGGI TEOLOGI BETHEL MEDAN');
INSERT INTO "public"."universitas" VALUES (101700, 233040, 'SEKOLAH TINGGI TEOLOGI INJILI BETHSAIDA MEDAN');
INSERT INTO "public"."universitas" VALUES (101701, 233041, 'SEKOLAH TINGGI TEOLOGI PAULUS MEDAN');
INSERT INTO "public"."universitas" VALUES (101702, 233042, 'SEKOLAH TINGGI TEOLOGI IMANUEL (SETITEL) TELUK DALAM KABUPATEN NIAS SELATAN');
INSERT INTO "public"."universitas" VALUES (101703, 233043, 'SEKOLAH TINGGI TEOLOGI PALEMBANG');
INSERT INTO "public"."universitas" VALUES (101704, 233044, 'SEKOLAH TINGGI TEOLOGI BASOM');
INSERT INTO "public"."universitas" VALUES (101705, 233045, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA BATAM');
INSERT INTO "public"."universitas" VALUES (101706, 233046, 'STT LINTAS BUDAYA BATAM');
INSERT INTO "public"."universitas" VALUES (101707, 233047, 'SEKOLAH TINGGI AGAMA KRISTEN ABDI WACANA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101708, 233048, 'SEKOLAH TINGGI TEOLOGI EKKLESIA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101709, 233049, 'SEKOLAH TINGGI TEOLOGI KALIMANTAN');
INSERT INTO "public"."universitas" VALUES (101710, 233050, 'SEKOLAH TINGGI TEOLOGI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101711, 233051, 'SEKOLAH TINGGI TEOLOGI GEREJA KALIMANTAN EVANGELIS (GKE)');
INSERT INTO "public"."universitas" VALUES (101712, 233052, 'SEKOLAH TINGGI TEOLOGI BETHEL BANJAR BARU');
INSERT INTO "public"."universitas" VALUES (101713, 233053, 'SEKOLAH TINGGI TEOLOGI MALINGGANG');
INSERT INTO "public"."universitas" VALUES (101714, 233054, 'SEKOLAH TINGGI AGAMA KRISTEN SAMARINDA');
INSERT INTO "public"."universitas" VALUES (101715, 233055, 'SEKOLAH TINGGI TEOLOGI BETHEL SAMARINDA');
INSERT INTO "public"."universitas" VALUES (101716, 233056, 'STT BISANRY MAKASSAR');
INSERT INTO "public"."universitas" VALUES (101717, 233057, 'SEKOLAH TINGGI AGAMA KRISTEN MANADO');
INSERT INTO "public"."universitas" VALUES (101718, 233058, 'SEKOLAH TINGGI TEOLOGI ANDERSON MANADO');
INSERT INTO "public"."universitas" VALUES (101719, 233059, 'SEKOLAH TINGGI TEOLOGI IKI EL-SHADDAI');
INSERT INTO "public"."universitas" VALUES (101720, 233060, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA MANADO');
INSERT INTO "public"."universitas" VALUES (101721, 233061, 'STT SEAPIN FILADELFIA PINANGUNIAN BITUNG');
INSERT INTO "public"."universitas" VALUES (101722, 233062, 'STT BALA KESELAMATAN PALU');
INSERT INTO "public"."universitas" VALUES (101723, 233063, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA AMBON');
INSERT INTO "public"."universitas" VALUES (101724, 233064, 'SEKOLAH TINGGI TEOLOGI DIAN HALMAHERA');
INSERT INTO "public"."universitas" VALUES (101725, 233065, 'SEKOLAH TINGGI TEOLOGI INJILI DAN KEJURUAN KUPANG');
INSERT INTO "public"."universitas" VALUES (101726, 233066, 'STT ABALBALAT WESLEYAN KUPANG');
INSERT INTO "public"."universitas" VALUES (101727, 233067, 'SEKOLAH TINGGI TEOLOGI BAPTIS PAPUA, ABEPURA');
INSERT INTO "public"."universitas" VALUES (101728, 233068, 'STAK OIKUMENE NOSENI BIAK NUMFOR');
INSERT INTO "public"."universitas" VALUES (101729, 233069, 'STT GEREJA PROTESTAN INDONESIA (GPI) PAPUA');
INSERT INTO "public"."universitas" VALUES (101730, 233070, 'STFT GKI IZAAK SAMUEL KIJNE JAYAPURA');
INSERT INTO "public"."universitas" VALUES (101731, 233071, 'SEKOLAH TINGGI TEOLOGI ERIKSON TRITT');
INSERT INTO "public"."universitas" VALUES (101732, 233072, 'SEKOLAH TINGGI AGAMA KRISTEN MERAUKE');
INSERT INTO "public"."universitas" VALUES (101733, 233073, 'SEKOLAH TINGGI TEOLOGI WALTER POST JAYAPURA PAPUA');
INSERT INTO "public"."universitas" VALUES (99054, 72006, 'INSTITUT PERTANIAN MALANG');
INSERT INTO "public"."universitas" VALUES (99055, 72007, 'IKIP PGRI JEMBER');
INSERT INTO "public"."universitas" VALUES (99056, 72010, 'IKIP PGRI MADIUN');
INSERT INTO "public"."universitas" VALUES (99057, 72011, 'IKIP PGRI BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99058, 72013, 'INSTITUT SAINS DAN TEKNOLOGI PALAPA');
INSERT INTO "public"."universitas" VALUES (99059, 72014, 'INSTITUT INFORMATIKA INDONESIA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99060, 72015, 'INSTITUT ILMU KESEHATAN BHAKTI WIYATA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99061, 72016, 'INSTITUT BISNIS DAN INFORMATIKA STIKOM SURABAYA');
INSERT INTO "public"."universitas" VALUES (99062, 72017, 'INSTITUT TEKNOLOGI KREATIF BINA NUSANTARA MALANG');
INSERT INTO "public"."universitas" VALUES (99063, 72018, 'INSTITUT TEKNOLOGI DAN SAINS NAHDLATUL ULAMA PASURUAN');
INSERT INTO "public"."universitas" VALUES (99064, 72019, 'INSTITUT TEKNOLOGI TELKOM SURABAYA');
INSERT INTO "public"."universitas" VALUES (99065, 72020, 'INSTITUT SAINS DAN TEKNOLOGI ANNUQAYAH');
INSERT INTO "public"."universitas" VALUES (99066, 72021, 'INSTITUT SAINS DAN TEKNOLOGI TERPADU SURABAYA');
INSERT INTO "public"."universitas" VALUES (99067, 72022, 'INSTITUT ILMU KESEHATAN STRADA INDONESIA');
INSERT INTO "public"."universitas" VALUES (99068, 72023, 'INSTITUT TEKNOLOGI DAN BISNIS ASIA MALANG');
INSERT INTO "public"."universitas" VALUES (99069, 72024, 'INSTITUT TEKNOLOGI DAN BISNIS MUHAMMADIYAH BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99070, 72025, 'INSTITUT TEKNOLOGI DAN BISNIS NAZHATUT THULLAB AL-MUAFA SAMPANG');
INSERT INTO "public"."universitas" VALUES (99071, 72026, 'INSTITUT TEKNOLOGI, SAINS, DAN KESEHATAN RS.DR. SOEPRAOEN KESDAM V/BRW');
INSERT INTO "public"."universitas" VALUES (99072, 72027, 'INSTITUT TEKNOLOGI DAN BISNIS AHMAD DAHLAN LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99073, 73002, 'SEKOLAH TINGGI ILMU EKONOMI PERBANAS SURABAYA');
INSERT INTO "public"."universitas" VALUES (99074, 73003, 'SEKOLAH TINGGI KESENIAN WILWATIKTA');
INSERT INTO "public"."universitas" VALUES (99075, 73004, 'SEKOLAH TINGGI ILMU EKONOMI MAHARDHIKA');
INSERT INTO "public"."universitas" VALUES (99076, 73005, 'SEKOLAH TINGGI TEKNIK SURABAYA');
INSERT INTO "public"."universitas" VALUES (99077, 73006, 'SEKOLAH TINGGI ILMU EKONOMI URIP SUMOHARDJO');
INSERT INTO "public"."universitas" VALUES (99078, 73007, 'SEKOLAH TINGGI ILMU EKONOMI ARTHA BODHI ISWARA');
INSERT INTO "public"."universitas" VALUES (99079, 73008, 'SEKOLAH TINGGI ILMU EKONOMI PARIWISATA SATYA WIDYA');
INSERT INTO "public"."universitas" VALUES (99080, 73010, 'SEKOLAH TINGGI ILMU KOMUNIKASI AWS');
INSERT INTO "public"."universitas" VALUES (99081, 73011, 'SEKOLAH TINGGI ILMU BAHASA DAN SASTRA SATYA WIDYA');
INSERT INTO "public"."universitas" VALUES (99082, 73012, 'STKIP TRI BHUWANA');
INSERT INTO "public"."universitas" VALUES (99083, 73014, 'STMIK SURABAYA');
INSERT INTO "public"."universitas" VALUES (99084, 73015, 'SEKOLAH TINGGI TEKNIK RADEN WIJAYA');
INSERT INTO "public"."universitas" VALUES (99085, 73017, 'STKIP PGRI JOMBANG');
INSERT INTO "public"."universitas" VALUES (99086, 73018, 'SEKOLAH TINGGI ILMU EKONOMI JAYA NEGARA TAMANSISWA');
INSERT INTO "public"."universitas" VALUES (99087, 73019, 'SEKOLAH TINGGI ILMU EKONOMI MALANGKUCECWARA');
INSERT INTO "public"."universitas" VALUES (99088, 73020, 'SEKOLAH TINGGI FILSAFAT TEOLOGI WIDYA SASANA');
INSERT INTO "public"."universitas" VALUES (99089, 73021, 'SEKOLAH TINGGI ILMU HUKUM SUNAN GIRI');
INSERT INTO "public"."universitas" VALUES (99090, 73022, 'SEKOLAH TINGGI ILMU EKONOMI KERTANEGARA');
INSERT INTO "public"."universitas" VALUES (99091, 73023, 'SEKOLAH TINGGI ILMU ADMINISTRASI MALANG');
INSERT INTO "public"."universitas" VALUES (99092, 73024, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA MALANG');
INSERT INTO "public"."universitas" VALUES (99093, 73025, 'STIKI MALANG');
INSERT INTO "public"."universitas" VALUES (99094, 73026, 'SEKOLAH TINGGI SOSIAL POLITIK WASKITA DARMA');
INSERT INTO "public"."universitas" VALUES (99095, 73027, 'STKIP PGRI PASURUAN');
INSERT INTO "public"."universitas" VALUES (99096, 73028, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA NASIONAL JEMBER');
INSERT INTO "public"."universitas" VALUES (99097, 73029, 'SEKOLAH TINGGI ILMU PERTANIAN');
INSERT INTO "public"."universitas" VALUES (99098, 73030, 'SEKOLAH TINGGI ILMU EKONOMI MANDALA');
INSERT INTO "public"."universitas" VALUES (99099, 73031, 'SEKOLAH TINGGI ILMU EKONOMI KOSGORO');
INSERT INTO "public"."universitas" VALUES (99100, 73032, 'STKIP PGRI SITUBONDO');
INSERT INTO "public"."universitas" VALUES (99101, 73033, 'STKIP PGRI LUMAJANG');
INSERT INTO "public"."universitas" VALUES (99102, 73034, 'SEKOLAH TINGGI ILMU HUKUM JENDERAL SUDIRMAN');
INSERT INTO "public"."universitas" VALUES (99103, 73035, 'STKIP MUHAMMADIYAH LUMAJANG');
INSERT INTO "public"."universitas" VALUES (99104, 73037, 'SEKOLAH TINGGI ILMU HUKUM ZAINUL HASAN');
INSERT INTO "public"."universitas" VALUES (99105, 73038, 'SEKOLAH TINGGI ILMU ADMINISTRASI BAYUANGGA');
INSERT INTO "public"."universitas" VALUES (99106, 73039, 'STKIP PGRI BLITAR');
INSERT INTO "public"."universitas" VALUES (99107, 73040, 'STKIP PGRI TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (99108, 73041, 'STKIP PGRI NGANJUK');
INSERT INTO "public"."universitas" VALUES (99109, 73042, 'STKIP WIDYA YUWANA');
INSERT INTO "public"."universitas" VALUES (99110, 73043, 'STISIP MUHAMMADIYAH MADIUN');
INSERT INTO "public"."universitas" VALUES (99111, 73044, 'STKIP PGRI PONOROGO');
INSERT INTO "public"."universitas" VALUES (99112, 73045, 'STKIP PGRI TRENGGALEK');
INSERT INTO "public"."universitas" VALUES (99113, 73046, 'STKIP PGRI NGAWI');
INSERT INTO "public"."universitas" VALUES (99114, 73048, 'STKIP PGRI LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99115, 73049, 'STKIP PGRI BANGKALAN');
INSERT INTO "public"."universitas" VALUES (99116, 73050, 'STKIP PGRI SAMPANG');
INSERT INTO "public"."universitas" VALUES (99117, 73051, 'STKIP PGRI SUMENEP');
INSERT INTO "public"."universitas" VALUES (99118, 73052, 'SEKOLAH TINGGI ILMU ADMINISTRASI PANGLIMA SUDIRMAN');
INSERT INTO "public"."universitas" VALUES (99119, 73053, 'SEKOLAH TINGGI PARIWISATA SATYA WIDYA');
INSERT INTO "public"."universitas" VALUES (99120, 73054, 'SEKOLAH TINGGI ILMU EKONOMI WILWATIKTA');
INSERT INTO "public"."universitas" VALUES (99121, 73055, 'SEKOLAH TINGGI BAHASA ASING MALANG');
INSERT INTO "public"."universitas" VALUES (99122, 73056, 'SEKOLAH TINGGI ILMU EKONOMI KOPERASI MALANG');
INSERT INTO "public"."universitas" VALUES (99123, 73057, 'SEKOLAH TINGGI TEKNIK MALANG');
INSERT INTO "public"."universitas" VALUES (99124, 73058, 'SEKOLAH TINGGI ILMU ADMINISTRASI PEMBANGUNAN');
INSERT INTO "public"."universitas" VALUES (99125, 73060, 'SEKOLAH TINGGI TEKNIK INDUSTRI TUREN');
INSERT INTO "public"."universitas" VALUES (99126, 73061, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA GAMA');
INSERT INTO "public"."universitas" VALUES (99127, 73063, 'SEKOLAH TINGGI ILMU EKONOMI KESUMANEGARA');
INSERT INTO "public"."universitas" VALUES (99128, 73064, 'STKIP PGRI SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99129, 73065, 'STKIP PGRI PACITAN');
INSERT INTO "public"."universitas" VALUES (99130, 73066, 'STMIK YADIKA BANGIL');
INSERT INTO "public"."universitas" VALUES (99131, 73067, 'SEKOLAH TINGGI ILMU PERIKANAN MALANG');
INSERT INTO "public"."universitas" VALUES (99132, 73069, 'SEKOLAH TINGGI ILMU EKONOMI IEU');
INSERT INTO "public"."universitas" VALUES (99133, 73070, 'SEKOLAH TINGGI TEKNIK BUDI UTOMO');
INSERT INTO "public"."universitas" VALUES (99134, 73072, 'SEKOLAH TINGGI ILMU KOMPUTER PGRI BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99135, 73075, 'SEKOLAH TINGGI ILMU EKONOMI IBMT');
INSERT INTO "public"."universitas" VALUES (99136, 73076, 'SEKOLAH TINGGI ILMU EKONOMI NGANJUK');
INSERT INTO "public"."universitas" VALUES (99137, 73077, 'SEKOLAH TINGGI TEKNIK WIDYA DARMA');
INSERT INTO "public"."universitas" VALUES (99138, 73079, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA DARMA');
INSERT INTO "public"."universitas" VALUES (99139, 73080, 'SEKOLAH TINGGI ILMU EKONOMI PGRI DEWANTARA');
INSERT INTO "public"."universitas" VALUES (100468, 114082, 'AKADEMI KEBIDANAN KUTAI HUSADA');
INSERT INTO "public"."universitas" VALUES (100469, 114084, 'ASMI CITRA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100470, 114085, 'AKADEMI KEBIDANAN MUHAMMADIYAH KOTIM');
INSERT INTO "public"."universitas" VALUES (100471, 114086, 'AKADEMI KEBIDANAN MUTIARA MAHAKAM');
INSERT INTO "public"."universitas" VALUES (100472, 114087, 'AKADEMI KEBIDANAN BANJARBARU');
INSERT INTO "public"."universitas" VALUES (100473, 114088, 'AKADEMI KEBIDANAN BANUA BINA HUSADA');
INSERT INTO "public"."universitas" VALUES (100474, 114089, 'AKADEMI KEBIDANAN ABDI PERSADA BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100475, 114090, 'AKTEK RADIODIAGNOSTIK & TERAPI CITRA INTAN PERSADA');
INSERT INTO "public"."universitas" VALUES (100476, 114091, 'AKADEMI KEBIDANAN YAPKESBI BANJARBARU');
INSERT INTO "public"."universitas" VALUES (100477, 114092, 'AKADEMI KEBIDANAN ST BENEDICTA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100478, 114093, 'AKADEMI KEPERAWATAN DHARMA INSAN PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100479, 114094, 'AKADEMI ANALIS KESEHATAN BORNEO LESTARI BANJARBARU');
INSERT INTO "public"."universitas" VALUES (100480, 114095, 'AKADEMI BAHASA ASING PERMATA HATI TARAKAN');
INSERT INTO "public"."universitas" VALUES (100481, 114096, 'AMIK BSI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100482, 114097, 'AKADEMI KEPERAWATAN KESDAM VI/TANJUNG PURA');
INSERT INTO "public"."universitas" VALUES (100483, 114098, 'AKADEMI KEBIDANAN PANCA BHAKTI');
INSERT INTO "public"."universitas" VALUES (100484, 114099, 'AKADEMI KEPERAWATAN INTAN MARTAPURA');
INSERT INTO "public"."universitas" VALUES (100485, 114101, 'AKADEMI FARMASI ISFI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100486, 114102, 'AKADEMI GIZI SINKA DHARMA MADANI SINGKAWANG');
INSERT INTO "public"."universitas" VALUES (100487, 114103, 'AKADEMI FARMASI KALTARA TARAKAN');
INSERT INTO "public"."universitas" VALUES (101768, 233110, 'SEKOLAH TINGGI TEOLOGI PANTEKOSTA JAKARTA');
INSERT INTO "public"."universitas" VALUES (100488, 114104, 'INSTITUT TEKNOLOGI KESEHATAN DAN SAINS WIYATA HUSADA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100489, 115001, 'POLITEKNIK TONGGAK EQUATOR');
INSERT INTO "public"."universitas" VALUES (100490, 115002, 'POLITEKNIK BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100491, 115003, 'POLITEKNIK PUTRA BANGSA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100492, 115004, 'POLITEKNIK KOTABARU');
INSERT INTO "public"."universitas" VALUES (100493, 115006, 'POLITEKNIK SENDAWAR');
INSERT INTO "public"."universitas" VALUES (100494, 115007, 'POLITEKNIK KETAPANG');
INSERT INTO "public"."universitas" VALUES (100495, 115008, 'POLITEKNIK MUARA TEWEH');
INSERT INTO "public"."universitas" VALUES (100496, 115009, 'POLITEKNIK MALINAU');
INSERT INTO "public"."universitas" VALUES (100497, 115010, 'POLITEKNIK TERPIKAT SAMBAS');
INSERT INTO "public"."universitas" VALUES (100498, 115011, 'POLITEKNIK ISLAM SYEKH SALMAN AL-FARISI RANTAU');
INSERT INTO "public"."universitas" VALUES (100499, 115012, 'POLITEKNIK TANAH LAUT');
INSERT INTO "public"."universitas" VALUES (100500, 115013, 'POLITEKNIK BISNIS LAMDA');
INSERT INTO "public"."universitas" VALUES (100501, 115014, 'POLITEKNIK HASNUR');
INSERT INTO "public"."universitas" VALUES (100502, 115015, 'POLITEKNIK ILMU PELAYARAN BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (100503, 115016, 'POLITEKNIK UNGGULAN KALIMANTAN');
INSERT INTO "public"."universitas" VALUES (100504, 115017, 'POLITEKNIK BATULICIN');
INSERT INTO "public"."universitas" VALUES (100505, 115018, 'POLITEKNIK SINAR MAS BERAU COAL');
INSERT INTO "public"."universitas" VALUES (100506, 115019, 'POLITEKNIK LAMANDAU');
INSERT INTO "public"."universitas" VALUES (100507, 115020, 'POLITEKNIK BISNIS KALTARA');
INSERT INTO "public"."universitas" VALUES (100508, 115021, 'POLITEKNIK AISYIYAH PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100509, 115022, 'POLITEKNIK SAMPIT');
INSERT INTO "public"."universitas" VALUES (100510, 115023, 'POLITEKNIK SERUYAN');
INSERT INTO "public"."universitas" VALUES (100511, 115024, 'POLITEKNIK KALTARA');
INSERT INTO "public"."universitas" VALUES (100512, 116001, 'AKADEMI KOMUNITAS FAVORIT SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100513, 121002, 'UNIVERSITAS DARUSSALAM AMBON');
INSERT INTO "public"."universitas" VALUES (100514, 121003, 'UNIVERSITAS KRISTEN INDONESIA MALUKU');
INSERT INTO "public"."universitas" VALUES (100515, 121004, 'UNIVERSITAS NUKU');
INSERT INTO "public"."universitas" VALUES (100516, 121005, 'UNIVERSITAS MUHAMMADIYAH MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (100517, 121007, 'UNIVERSITAS IQRA BURU');
INSERT INTO "public"."universitas" VALUES (100518, 121012, 'UNIVERSITAS MUSAMUS MERAUKE');
INSERT INTO "public"."universitas" VALUES (100519, 121015, 'UNIVERSITAS HALMAHERA');
INSERT INTO "public"."universitas" VALUES (100520, 121017, 'UNIVERSITAS BUMI HIJRAH TIDORE');
INSERT INTO "public"."universitas" VALUES (100521, 121018, 'UNIVERSITAS PASIFIK MOROTAI');
INSERT INTO "public"."universitas" VALUES (100522, 121019, 'UNIVERSITAS HEIN NAMOTEMO');
INSERT INTO "public"."universitas" VALUES (100523, 123004, 'STIE OTTOW & GEISSLER JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100524, 123008, 'SEKOLAH TINGGI ILMU ADMINISTRASI TRINITAS');
INSERT INTO "public"."universitas" VALUES (100525, 123021, 'SEKOLAH TINGGI PERIKANAN HATTA-SJAHRIR');
INSERT INTO "public"."universitas" VALUES (100526, 123022, 'SEKOLAH TINGGI ILMU ADMINISTRASI DARUL RACHMAN TUAL');
INSERT INTO "public"."universitas" VALUES (100527, 123023, 'STIA ABDUL AZIS KATALOKA');
INSERT INTO "public"."universitas" VALUES (100528, 123026, 'SEKOLAH TINGGI ILMU EKONOMI UMEL');
INSERT INTO "public"."universitas" VALUES (100529, 123028, 'SEKOLAH TINGGI ILMU-ILMU SOSIAL (STIS) TUAL');
INSERT INTO "public"."universitas" VALUES (100530, 123031, 'SEKOLAH TINGGI ILMU ADMINISTRASI LANGGUR');
INSERT INTO "public"."universitas" VALUES (100531, 123032, 'SEKOLAH TINGGI ILMU SOSIAL ILMU POLITIK KEBANGSAAN');
INSERT INTO "public"."universitas" VALUES (100532, 123033, 'SEKOLAH TINGGI ILMU EKONOMI SAUMLAKI');
INSERT INTO "public"."universitas" VALUES (100533, 123034, 'STKIP KIE RAHA');
INSERT INTO "public"."universitas" VALUES (100534, 123037, 'STKIP GOTONG ROYONG MASOHI');
INSERT INTO "public"."universitas" VALUES (100535, 123038, 'STIA AMAL ILMIAH WAMENA');
INSERT INTO "public"."universitas" VALUES (100536, 123040, 'SEKOLAH TINGGI ILMU EKONOMI MANAJEMEN RUTU NUSA');
INSERT INTO "public"."universitas" VALUES (100537, 123045, 'STMIK TIDORE MANDIRI');
INSERT INTO "public"."universitas" VALUES (100538, 123046, 'SEKOLAH TINGGI ILMU ADMINISTRASI SAID PERINTAH');
INSERT INTO "public"."universitas" VALUES (100539, 123051, 'SEKOLAH TINGGI PERTANIAN LABUHA');
INSERT INTO "public"."universitas" VALUES (100540, 123052, 'SEKOLAH TINGGI ILMU KESEHATAN MAKARIWO HALMAHERA');
INSERT INTO "public"."universitas" VALUES (100541, 123053, 'SEKOLAH TINGGI ILMU ADMINISTRASI SAUMLAKI');
INSERT INTO "public"."universitas" VALUES (100542, 123055, 'SEKOLAH TINGGI PERTANIAN KEWIRAUSAHAAN BANAU');
INSERT INTO "public"."universitas" VALUES (100543, 123056, 'STKIP HATTA SJAHRIR');
INSERT INTO "public"."universitas" VALUES (100544, 123058, 'STIKES MALUKU HUSADA');
INSERT INTO "public"."universitas" VALUES (100545, 123059, 'STIKES PASAPUA AMBON');
INSERT INTO "public"."universitas" VALUES (100546, 123062, 'SEKOLAH TINGGI ILMU KOMPUTER AMBON');
INSERT INTO "public"."universitas" VALUES (100547, 123065, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN SAUMLAKI');
INSERT INTO "public"."universitas" VALUES (100548, 123067, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMAD THAHA TUAL');
INSERT INTO "public"."universitas" VALUES (100549, 123068, 'STKIP ITA WOTU NUSA');
INSERT INTO "public"."universitas" VALUES (100550, 123069, 'STKIP HUNIMUA');
INSERT INTO "public"."universitas" VALUES (100551, 123070, 'SEKOLAH TINGGI ILMU MARITIM INDONESIA TERNATE');
INSERT INTO "public"."universitas" VALUES (100552, 124001, 'AKADEMI MARITIM MALUKU');
INSERT INTO "public"."universitas" VALUES (100553, 124010, 'AKADEMI ILMU KOMPUTER TERNATE');
INSERT INTO "public"."universitas" VALUES (100554, 124014, 'AKADEMI KEBIDANAN MAKARIWO');
INSERT INTO "public"."universitas" VALUES (100555, 124015, 'AKADEMI BANK YAPIS');
INSERT INTO "public"."universitas" VALUES (100556, 124016, 'AKADEMI KEBIDANAN ARU');
INSERT INTO "public"."universitas" VALUES (100557, 124018, 'AKADEMI KEBIDANAN GATRA BUANA GURABATI TIDORE');
INSERT INTO "public"."universitas" VALUES (100558, 124021, 'AKADEMI KEPERAWATAN RUMKIT TK III DR. J. A. LATUMETEN');
INSERT INTO "public"."universitas" VALUES (100559, 125003, 'POLITEKNIK PERDAMAIAN HALMAHERA');
INSERT INTO "public"."universitas" VALUES (101734, 233074, 'SEKOLAH TINGGI AGAMA KRISTEN MESIAS SORONG');
INSERT INTO "public"."universitas" VALUES (101735, 233075, 'STT GEREJA KEMAH INJIL INDONESIA (GKII)');
INSERT INTO "public"."universitas" VALUES (101736, 233076, 'SEKOLAH TINGGI TEOLOGI BAPTIS MEDAN');
INSERT INTO "public"."universitas" VALUES (101737, 233077, 'SEKOLAH TINGGI TEOLOGI BANDUNG');
INSERT INTO "public"."universitas" VALUES (101738, 233078, 'SEKOLAH TINGGI TEOLOGI SAPPI CIRANJANG');
INSERT INTO "public"."universitas" VALUES (101739, 233079, 'SEKOLAH TINGGI TEOLOGI EL-SHADDAY SURAKARTA');
INSERT INTO "public"."universitas" VALUES (101740, 233080, 'STT INSTITUT INJIL INDONESIA BATU (I-3)');
INSERT INTO "public"."universitas" VALUES (101741, 233081, 'SEKOLAH TINGGI TEOLOGI BAPTIS INDEPENDEN INDONESIA PURWOREJO');
INSERT INTO "public"."universitas" VALUES (101742, 233082, 'SEKOLAH TINGGI TEOLOGI MARTURIA TANJUNG BALAI');
INSERT INTO "public"."universitas" VALUES (101743, 233083, 'STT PERIAGO');
INSERT INTO "public"."universitas" VALUES (101744, 233084, 'STT SALATIGA');
INSERT INTO "public"."universitas" VALUES (101745, 233085, 'STT BETHANY BALIKPAPAN');
INSERT INTO "public"."universitas" VALUES (101746, 233086, 'STT INTIM MAKASSAR');
INSERT INTO "public"."universitas" VALUES (101747, 233087, 'STT INDONESIA MANADO (STTI MANADO)');
INSERT INTO "public"."universitas" VALUES (101748, 233088, 'SEKOLAH TINGGI TEOLOGI IKSM SANTOSA ASIH');
INSERT INTO "public"."universitas" VALUES (101749, 233089, 'SEKOLAH TINGGI TEOLOGI INALTA');
INSERT INTO "public"."universitas" VALUES (101750, 233090, 'SEKOLAH TINGGI TEOLOGI PELITA BANGSA');
INSERT INTO "public"."universitas" VALUES (101751, 233091, 'SEKOLAH TINGGI TEOLOGI REFORMED INDONESIA');
INSERT INTO "public"."universitas" VALUES (101752, 233092, 'STT BAPTIS INDEPENDEN JAKARTA');
INSERT INTO "public"."universitas" VALUES (101753, 233093, 'SEKOLAH TINGGI TEOLOGI AMANAT AGUNG');
INSERT INTO "public"."universitas" VALUES (101754, 233095, 'SEKOLAH TINGGI TEOLOGI LINTAS BUDAYA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101755, 233096, 'SEKOLAH TINGGI TEOLOGI TIBERIAS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101756, 233097, 'SEKOLAH TINGGI TEOLOGI WESLEY METHODIST INDONESIA');
INSERT INTO "public"."universitas" VALUES (101757, 233098, 'STT LIGHTHOUSE EQUIPPING THEOLOGICAL SCHOOL (LETS)');
INSERT INTO "public"."universitas" VALUES (101758, 233099, 'SEKOLAH TINGGI TEOLOGI BETHEL THE WAY, JAKARTA');
INSERT INTO "public"."universitas" VALUES (101759, 233100, 'SEKOLAH TINGGI TEOLOGI ECCLESIA CHRISTI JAKARTA');
INSERT INTO "public"."universitas" VALUES (101760, 233101, 'SEKOLAH TINGGI TEOLOGI EKLESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101761, 233102, 'SEKOLAH TINGGI TEOLOGI PAULUS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101762, 233103, 'SEKOLAH TINGGI TEOLOGI APOLLOS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101763, 233104, 'SEKOLAH TINGGI TEOLOGI BAPTIS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101764, 233105, 'SEKOLAH TINGGI TEOLOGI IKAT JAKARTA');
INSERT INTO "public"."universitas" VALUES (101765, 233106, 'SEKOLAH TINGGI TEOLOGI IMMANUEL NUSANTARA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101766, 233107, 'SEKOLAH TINGGI TEOLOGI AGAPES JAKARTA');
INSERT INTO "public"."universitas" VALUES (101767, 233109, 'SEKOLAH TINGGI TEOLOGI DOULOS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101769, 233111, 'SEKOLAH TINGGI TEOLOGI VICTORY CIBUBUR');
INSERT INTO "public"."universitas" VALUES (101770, 233112, 'STAK SOLA SCRIPTURA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101771, 233113, 'SEKOLAH TINGGI TEOLOGI RAHMAT EMMANUEL JAKARTA');
INSERT INTO "public"."universitas" VALUES (101772, 233114, 'SEKOLAH TINGGI TEOLOGI SUNSUGOS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101773, 233115, 'SEKOLAH TINGGI TEOLOGI ABDI FILADELFIA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (101774, 233116, 'STT MAHKOTA SION');
INSERT INTO "public"."universitas" VALUES (101775, 233117, 'STT BIBLIKA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101776, 233118, 'STT SAMUEL ELIZABETH');
INSERT INTO "public"."universitas" VALUES (101777, 233119, 'STT EKUMENE JAKARTA');
INSERT INTO "public"."universitas" VALUES (101778, 233120, 'SAAT MINISTRY CENTER');
INSERT INTO "public"."universitas" VALUES (101779, 233121, 'STT BAKTI FILADELFIA');
INSERT INTO "public"."universitas" VALUES (101780, 233122, 'STT INJILI JAKARTA');
INSERT INTO "public"."universitas" VALUES (101781, 233123, 'SEKOLAH TINGGI TEOLOGIA KABAR BAIK');
INSERT INTO "public"."universitas" VALUES (101782, 233124, 'SEKOLAH TINGGI TEOLOGI INTI BANDUNG');
INSERT INTO "public"."universitas" VALUES (101783, 233126, 'SEKOLAH TINGGI TEOLOGI MISI TUAIAN SEMESTA BANDUNG');
INSERT INTO "public"."universitas" VALUES (101784, 233127, 'SEKOLAH TINGGI TEOLOGI PRESBYTERIAN SHEMA');
INSERT INTO "public"."universitas" VALUES (101785, 233129, 'STT KERUSSO INDONESIA BEKASI');
INSERT INTO "public"."universitas" VALUES (101786, 233130, 'SEKOLAH TINGGI TEOLOGI ARRABONA BOGOR');
INSERT INTO "public"."universitas" VALUES (101787, 233131, 'SEKOLAH TINGGI ALKITAB PENYEBARAN INJIL (STAPIN) MAJALENGKA');
INSERT INTO "public"."universitas" VALUES (101788, 233132, 'STT BINA MUDA WIRAWAN TANGERANG');
INSERT INTO "public"."universitas" VALUES (101789, 233133, 'STT INJILI PHILADELPHIA TANGERANG');
INSERT INTO "public"."universitas" VALUES (101790, 233134, 'SEKOLAH TINGGI TEOLOGI MORIAH TANGERANG');
INSERT INTO "public"."universitas" VALUES (101791, 233135, 'SEKOLAH TINGGI TEOLOGI KATHAROS INDONESIA BEKASI');
INSERT INTO "public"."universitas" VALUES (101792, 233136, 'STT TABERNAKEL KEMULIAAN-NYA');
INSERT INTO "public"."universitas" VALUES (101793, 233137, 'STT SKRIPTURA INDONESIA');
INSERT INTO "public"."universitas" VALUES (101794, 233138, 'STT HARAPAN INDAH');
INSERT INTO "public"."universitas" VALUES (101795, 233139, 'STT KALAM MULIA BANDUNG');
INSERT INTO "public"."universitas" VALUES (101796, 233140, 'SEKOLAH TINGGI TEOLOGI ALKITABIAH EKLESIA');
INSERT INTO "public"."universitas" VALUES (101797, 233141, 'SEKOLAH TINGGI TEOLOGI KANAAN NUSANTARA UNGARAN');
INSERT INTO "public"."universitas" VALUES (101798, 233142, 'SEKOLAH TINGGI TEOLOGI KRISTUS ALFA OMEGA');
INSERT INTO "public"."universitas" VALUES (101799, 233143, 'STT INTERNASIONAL HARVEST SEMARANG');
INSERT INTO "public"."universitas" VALUES (101800, 233144, 'STT ANUGERAH ALIANSE SEMARANG');
INSERT INTO "public"."universitas" VALUES (101801, 233145, 'SEKOLAH TINGGI AGAMA KRISTEN TERPADU PESAT SALATIGA');
INSERT INTO "public"."universitas" VALUES (101802, 233146, 'SEKOLAH TINGGI TEOLOGI BEREA SALATIGA');
INSERT INTO "public"."universitas" VALUES (101803, 233147, 'SEKOLAH TINGGI TEOLOGI NUSANTARA SALATIGA');
INSERT INTO "public"."universitas" VALUES (101804, 233148, 'SEKOLAH TINGGI TEOLOGI SANGKAKALA');
INSERT INTO "public"."universitas" VALUES (101805, 233149, 'STT JEMAAT KRISTUS INDONESIA SALATIGA');
INSERT INTO "public"."universitas" VALUES (101806, 233150, 'SEKOLAH TINGGI TEOLOGI SOTERIA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (101807, 233151, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (101808, 233152, 'SEKOLAH TINGGI TEOLOGI TAWANGMANGU');
INSERT INTO "public"."universitas" VALUES (101809, 233153, 'SEKOLAH TINGGI TEOLOGI GAMALIEL');
INSERT INTO "public"."universitas" VALUES (101810, 233154, 'SEKOLAH TINGGI TEOLOGI TORSINA');
INSERT INTO "public"."universitas" VALUES (101811, 233155, 'STT AGAPE INDONESIA MISI INTERNASIONAL (AIMI)');
INSERT INTO "public"."universitas" VALUES (101812, 233156, 'SEKOLAH TINGGI TEOLOGI SIMPSON UNGARAN');
INSERT INTO "public"."universitas" VALUES (101813, 233157, 'SEKOLAH TINGGI AGAMA KRISTEN WIYATA WACANA PATI');
INSERT INTO "public"."universitas" VALUES (101814, 233158, 'SEKOLAH TINGGI TEOLOGI PROVIDENSIA');
INSERT INTO "public"."universitas" VALUES (101815, 233159, 'SEKOLAH TINGGI TEOLOGI ELOHIM INDONESIA');
INSERT INTO "public"."universitas" VALUES (99140, 73081, 'SEKOLAH TINGGI TEKNOLOGI CAHAYA SURYA');
INSERT INTO "public"."universitas" VALUES (99141, 73082, 'SEKOLAH TINGGI ILMU EKONOMI WIDYA DHARMA');
INSERT INTO "public"."universitas" VALUES (99142, 73084, 'SEKOLAH TINGGI ILMU EKONOMI DHARMA ISWARA');
INSERT INTO "public"."universitas" VALUES (99143, 73085, 'SEKOLAH TINGGI TEKNIK DHARMA ISWARA');
INSERT INTO "public"."universitas" VALUES (99144, 73086, 'SEKOLAH TINGGI ILMU EKONOMI FATAHILLAH');
INSERT INTO "public"."universitas" VALUES (99145, 73087, 'STIE MUHAMMADIYAH PACIRAN LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99146, 73088, 'STIA DAN MANAJEMEN KEPELABUHAN BARUNAWATI');
INSERT INTO "public"."universitas" VALUES (99147, 73089, 'SEKOLAH TINGGI ILMU EKONOMI CENDEKIA BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99148, 73090, 'SEKOLAH TINGGI ILMU EKONOMI KH AHMAD DAHLAN');
INSERT INTO "public"."universitas" VALUES (99149, 73092, 'SEKOLAH TINGGI TEKNIK YPM SEPANJANG');
INSERT INTO "public"."universitas" VALUES (99150, 73093, 'SEKOLAH TINGGI ILMU EKONOMI YPM SEPANJANG');
INSERT INTO "public"."universitas" VALUES (99151, 73094, 'SEKOLAH TINGGI ILMU EKONOMI AL-ANWAR');
INSERT INTO "public"."universitas" VALUES (99152, 73095, 'SEKOLAH TINGGI ILMU EKONOMI WAHIDIYAH');
INSERT INTO "public"."universitas" VALUES (99153, 73096, 'SEKOLAH TINGGI TEKNOLOGI STIKMA INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99154, 73097, 'SEKOLAH TINGGI TEKNOLOGI NURUL JADID');
INSERT INTO "public"."universitas" VALUES (99155, 73098, 'SEKOLAH TINGGI ILMU EKONOMI NU TRATE');
INSERT INTO "public"."universitas" VALUES (99156, 73099, 'SEKOLAH TINGGI ILMU EKONOMI CANDA BHIRAWA');
INSERT INTO "public"."universitas" VALUES (99157, 73100, 'SEKOLAH TINGGI TEKNIK ATLAS NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99158, 73102, 'SEKOLAH TINGGI ILMU EKONOMI PEMNAS INDONESIA');
INSERT INTO "public"."universitas" VALUES (99159, 73104, 'STMIK PPKIA PRADNYA PARAMITA');
INSERT INTO "public"."universitas" VALUES (99160, 73105, 'SEKOLAH TINGGI TEKNOLOGI GEMPOL');
INSERT INTO "public"."universitas" VALUES (99161, 73106, 'SEKOLAH TINGGI ILMU EKONOMI GEMPOL');
INSERT INTO "public"."universitas" VALUES (99162, 73107, 'SEKOLAH TINGGI ILMU EKONOMI MUHAMMADIYAH TUBAN');
INSERT INTO "public"."universitas" VALUES (99163, 73108, 'SEKOLAH TINGGI ILMU EKONOMI PEMUDA');
INSERT INTO "public"."universitas" VALUES (99164, 73109, 'SEKOLAH TINGGI ILMU HUKUM YPM SEPANJANG');
INSERT INTO "public"."universitas" VALUES (99165, 73110, 'SEKOLAH TINGGI ILMU EKONOMI ASIA MALANG');
INSERT INTO "public"."universitas" VALUES (99166, 73111, 'SEKOLAH TINGGI ILMU EKONOMI INDOCAKTI');
INSERT INTO "public"."universitas" VALUES (99167, 73112, 'STMIK KADIRI');
INSERT INTO "public"."universitas" VALUES (99168, 73113, 'SEKOLAH TINGGI TEKNOLOGI POMOSDA');
INSERT INTO "public"."universitas" VALUES (99169, 73114, 'SEKOLAH TINGGI ILMU EKONOMI YAPAN');
INSERT INTO "public"."universitas" VALUES (99170, 73115, 'SEKOLAH TINGGI ILMU EKONOMI YADIKA BANGIL');
INSERT INTO "public"."universitas" VALUES (99171, 73116, 'STMIK ASIA MALANG');
INSERT INTO "public"."universitas" VALUES (99172, 73117, 'STMIK CAHAYA SURYA');
INSERT INTO "public"."universitas" VALUES (99173, 73118, 'SEKOLAH TINGGI BAHASA ASING CAHAYA SURYA');
INSERT INTO "public"."universitas" VALUES (99174, 73119, 'STMIK BAHRUL ULUM JOMBANG');
INSERT INTO "public"."universitas" VALUES (99175, 73120, 'STIKES INSAN UNGGUL SURABAYA');
INSERT INTO "public"."universitas" VALUES (99176, 73121, 'STMIK PATRIA WACANA');
INSERT INTO "public"."universitas" VALUES (99177, 73122, 'STIKES SURYA MITRA HUSADA');
INSERT INTO "public"."universitas" VALUES (99178, 73123, 'SEKOLAH TINGGI ILMU KESEHATAN MAJAPAHIT');
INSERT INTO "public"."universitas" VALUES (99179, 73124, 'SEKOLAH TINGGI TEKNIK QOMARUDDIN');
INSERT INTO "public"."universitas" VALUES (99180, 73125, 'SEKOLAH TINGGI ILMU KESEHATAN ARTHA BODHI ISWARA');
INSERT INTO "public"."universitas" VALUES (99181, 73126, 'STIKES BINA SEHAT PPNI MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (99182, 73127, 'STIKES INSAN CENDEKIA MEDIKA JOMBANG');
INSERT INTO "public"."universitas" VALUES (99183, 73128, 'STIKES KARYA HUSADA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99184, 73129, 'STKIP BINA INSAN MANDIRI');
INSERT INTO "public"."universitas" VALUES (99185, 73130, 'STIKES MUHAMMADIYAH LAMONGAN');
INSERT INTO "public"."universitas" VALUES (99186, 73132, 'SEKOLAH TINGGI ILMU KESEHATAN HANG TUAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (99187, 73133, 'STIKES KATOLIK ST VINCENTIUS A PAULO SURABAYA');
INSERT INTO "public"."universitas" VALUES (99188, 73134, 'STIKES INSAN SE AGUNG');
INSERT INTO "public"."universitas" VALUES (99189, 73135, 'STIKES PATRIA HUSADA');
INSERT INTO "public"."universitas" VALUES (99190, 73136, 'STIKES BHAKTI MULIA');
INSERT INTO "public"."universitas" VALUES (99191, 73137, 'STIKES BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99192, 73138, 'STIKES SATRIA BHAKTI NGANJUK');
INSERT INTO "public"."universitas" VALUES (99193, 73139, 'SEKOLAH TINGGI ILMU KESEHATAN HUSADA JOMBANG');
INSERT INTO "public"."universitas" VALUES (99194, 73140, 'STIKES DIAN HUSADA');
INSERT INTO "public"."universitas" VALUES (99195, 73141, 'STIKES YARSI SURABAYA');
INSERT INTO "public"."universitas" VALUES (99196, 73142, 'STIKES RS BAPTIS KEDIRI');
INSERT INTO "public"."universitas" VALUES (99197, 73143, 'SEKOLAH TINGGI ILMU KESEHATAN MAHARANI');
INSERT INTO "public"."universitas" VALUES (99198, 73144, 'SEKOLAH TINGGI ILMU KESEHATAN PEMKAB JOMBANG');
INSERT INTO "public"."universitas" VALUES (99199, 73145, 'STIKES WIDYAGAMA HUSADA MALANG');
INSERT INTO "public"."universitas" VALUES (99200, 73146, 'SEKOLAH TINGGI ILMU KESEHATAN SURABAYA');
INSERT INTO "public"."universitas" VALUES (99201, 73148, 'STIKES BAHRUL ULUM JOMBANG');
INSERT INTO "public"."universitas" VALUES (99202, 73149, 'STIKES NAHDLATUL ULAMA TUBAN');
INSERT INTO "public"."universitas" VALUES (99203, 73150, 'SEKOLAH TINGGI ILMU KESEHATAN KEPANJEN');
INSERT INTO "public"."universitas" VALUES (99204, 73151, 'STIKES HAFSHAWATY PESANTREN ZAINUL HASAN');
INSERT INTO "public"."universitas" VALUES (99205, 73152, 'SEKOLAH TINGGI ILMU KESEHATAN KENDEDES');
INSERT INTO "public"."universitas" VALUES (99206, 73153, 'STIKES DR. SOEBANDI JEMBER');
INSERT INTO "public"."universitas" VALUES (99207, 73154, 'SEKOLAH TINGGI ILMU KESEHATAN NGUDIA HUSADA MADURA');
INSERT INTO "public"."universitas" VALUES (99208, 73155, 'STIKES GANESHA HUSADA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99209, 73156, 'STIKES WIDYA CIPTA HUSADA');
INSERT INTO "public"."universitas" VALUES (99210, 73157, 'SEKOLAH TINGGI ILMU KESEHATAN NURUL JADID');
INSERT INTO "public"."universitas" VALUES (99211, 73158, 'STIKES INSAN CENDEKIA HUSADA BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99212, 73159, 'STIKES HUTAMA ABDI HUSADA TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (99213, 73160, 'SEKOLAH TINGGI ILMU KESEHATAN WILLIAM BOOTH');
INSERT INTO "public"."universitas" VALUES (99214, 73161, 'STKIP DOKTOR NUGROHO MAGETAN');
INSERT INTO "public"."universitas" VALUES (99215, 73162, 'STIKES BHAKTI HUSADA MULIA');
INSERT INTO "public"."universitas" VALUES (99216, 73163, 'STIKES YAYASAN RS. DR. SOETOMO');
INSERT INTO "public"."universitas" VALUES (99217, 73164, 'STIKES BUANA HUSADA PONOROGO');
INSERT INTO "public"."universitas" VALUES (99218, 73165, 'SEKOLAH TINGGI MANAJEMEN SEMEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99219, 73166, 'STIKES BHAKTI AL-QODIRI');
INSERT INTO "public"."universitas" VALUES (99220, 73167, 'STKIP AL HIKMAH SURABAYA');
INSERT INTO "public"."universitas" VALUES (99221, 73168, 'STIKES KARYA PUTRA BANGSA TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (99222, 73169, 'STIKES MUHAMMADIYAH BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99223, 73170, 'STKIP MODERN NGAWI');
INSERT INTO "public"."universitas" VALUES (99224, 73171, 'STIKES DELIMA PERSADA GRESIK');
INSERT INTO "public"."universitas" VALUES (99225, 73172, 'STKIP QOMARUDDIN GRESIK');
INSERT INTO "public"."universitas" VALUES (99226, 73173, 'STIKES RUMAH SAKIT ANWAR MEDIKA');
INSERT INTO "public"."universitas" VALUES (99227, 73174, 'STIE BAKTI BANGSA');
INSERT INTO "public"."universitas" VALUES (100560, 125004, 'POLITEKNIK SAINS & TEKNOLOGI WIRATAMA MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (100561, 125007, 'POLITEKNIK HALMAHERA');
INSERT INTO "public"."universitas" VALUES (100562, 131001, 'UNIVERSITAS JABAL GHAFUR');
INSERT INTO "public"."universitas" VALUES (100563, 131002, 'UNIVERSITAS ISKANDAR MUDA');
INSERT INTO "public"."universitas" VALUES (100564, 131003, 'UNIVERSITAS ABULYATAMA');
INSERT INTO "public"."universitas" VALUES (100565, 131004, 'UNIVERSITAS MUHAMMADIYAH ACEH');
INSERT INTO "public"."universitas" VALUES (100566, 131005, 'UNIVERSITAS SERAMBI MEKKAH');
INSERT INTO "public"."universitas" VALUES (100567, 131006, 'UNIVERSITAS AL-MUSLIM');
INSERT INTO "public"."universitas" VALUES (100568, 131007, 'UNIVERSITAS TEUKU UMAR MEULABOH');
INSERT INTO "public"."universitas" VALUES (100569, 131008, 'UNIVERSITAS GAJAH PUTIH');
INSERT INTO "public"."universitas" VALUES (100570, 131009, 'UNIVERSITAS GUNUNG LEUSER ACEH');
INSERT INTO "public"."universitas" VALUES (100571, 131010, 'UNIVERSITAS UBUDIYAH INDONESIA');
INSERT INTO "public"."universitas" VALUES (100572, 131011, 'UNIVERSITAS SAINS CUT NYAK DHIEN');
INSERT INTO "public"."universitas" VALUES (100573, 131012, 'UNIVERSITAS ISLAM KEBANGSAAN INDONESIA');
INSERT INTO "public"."universitas" VALUES (100574, 133001, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100575, 133002, 'SEKOLAH TINGGI ILMU MANAJEMEN');
INSERT INTO "public"."universitas" VALUES (100576, 133003, 'SEKOLAH TINGGI ILMU EKONOMI SABANG');
INSERT INTO "public"."universitas" VALUES (100577, 133004, 'STMIK ABULYATAMA');
INSERT INTO "public"."universitas" VALUES (100578, 133005, 'SEKOLAH TINGGI ILMU KEHUTANAN PANTE KULU');
INSERT INTO "public"."universitas" VALUES (100579, 133006, 'SEKOLAH TINGGI ILMU ADMINISTRASI ISKANDAR THANI');
INSERT INTO "public"."universitas" VALUES (100580, 133007, 'SEKOLAH TINGGI TEKNIK ISKANDAR THANI');
INSERT INTO "public"."universitas" VALUES (100581, 133008, 'SEKOLAH TINGGI ILMU MANAJEMEN PASE');
INSERT INTO "public"."universitas" VALUES (100582, 133009, 'SEKOLAH TINGGI ILMU EKONOMI YPHB');
INSERT INTO "public"."universitas" VALUES (100583, 133010, 'SEKOLAH TINGGI TEKNIK BINA CENDIKIA');
INSERT INTO "public"."universitas" VALUES (100584, 133011, 'SEKOLAH TINGGI ILMU HUKUM MUHAMMADIYAH TAKENGON');
INSERT INTO "public"."universitas" VALUES (100585, 133012, 'STMIK BINA BANGSA');
INSERT INTO "public"."universitas" VALUES (100586, 133013, 'SEKOLAH TINGGI ILMU MANAJEMEN INDONESIA MEULABOH');
INSERT INTO "public"."universitas" VALUES (100587, 133014, 'SEKOLAH TINGGI ILMU PSIKOLOGI HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (100588, 133015, 'SEKOLAH TINGGI ILMU ADMINISTRASI NASIONAL');
INSERT INTO "public"."universitas" VALUES (100589, 133016, 'STKIP AL-WASHLIYAH');
INSERT INTO "public"."universitas" VALUES (100590, 133017, 'STKIP AN-NUR NANGRO ACEH');
INSERT INTO "public"."universitas" VALUES (100591, 133018, 'STKIP BINA BANGSA GETSEMPENA');
INSERT INTO "public"."universitas" VALUES (100592, 133019, 'SEKOLAH TINGGI ILMU PERTANIAN YASHAFA');
INSERT INTO "public"."universitas" VALUES (100593, 133020, 'STKIP MUHAMMADIYAH ACEH TENGAH');
INSERT INTO "public"."universitas" VALUES (100594, 133021, 'SEKOLAH TINGGI ILMU KESEHATAN HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (100595, 133022, 'STIKES PAYUNG NEGERI ACEH DARUSSALAM');
INSERT INTO "public"."universitas" VALUES (100596, 133023, 'SEKOLAH TINGGI ILMU KESEHATAN U BUDIYAH');
INSERT INTO "public"."universitas" VALUES (100597, 133024, 'STISIP AL WASHLIYAH BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100598, 133025, 'STIE BUMI PERSADA LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100599, 133026, 'STIKES CUT NYAK DHIEN LANGSA');
INSERT INTO "public"."universitas" VALUES (100600, 133027, 'SEKOLAH TINGGI ILMU EKONOMI LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100601, 133028, 'STMIK U BUDIYAH INDONESIA');
INSERT INTO "public"."universitas" VALUES (100602, 133029, 'SEKOLAH TINGGI ILMU KESEHATAN LANGSA');
INSERT INTO "public"."universitas" VALUES (100603, 133030, 'STIKES DARUSSALAM LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100604, 133031, 'STIKES MUHAMMADIYAH LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100605, 133032, 'STIKES MEDIKA SERAMOE BARAT');
INSERT INTO "public"."universitas" VALUES (100606, 133033, 'STIKES MEDIKA NURUL ISLAM');
INSERT INTO "public"."universitas" VALUES (100607, 133034, 'SEKOLAH TINGGI ILMU ADMINISTRASI PELITA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100608, 133035, 'STIKES BUMI PERSADA LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100609, 133036, 'STIKES GETSEMPENA LHOKSUKON');
INSERT INTO "public"."universitas" VALUES (100610, 133037, 'STIKES BINA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100611, 133038, 'STIKES BINA BANGSA KUALA SIMPANG');
INSERT INTO "public"."universitas" VALUES (100612, 133039, 'SEKOLAH TINGGI ILMU EKONOMI KEBANGSAAN BIREUEN');
INSERT INTO "public"."universitas" VALUES (100613, 133040, 'STKIP MUHAMMADIYAH ACEH BARAT DAYA');
INSERT INTO "public"."universitas" VALUES (100614, 133041, 'STIKES NURUL HASANAH KUTACANE');
INSERT INTO "public"."universitas" VALUES (100615, 133042, 'STKIP BINA BANGSA MEULABOH');
INSERT INTO "public"."universitas" VALUES (100616, 133043, 'STKIP USMAN SAFRI KUTACANE');
INSERT INTO "public"."universitas" VALUES (100617, 133044, 'STKIP BUMI PERSADA LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100618, 133045, 'STIKES MEDIKA TEUKU UMAR');
INSERT INTO "public"."universitas" VALUES (100619, 133046, 'STIKES BUSTANUL ULUM LANGSA');
INSERT INTO "public"."universitas" VALUES (100620, 133047, 'STMIK INDONESIA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100621, 133048, 'STKIP CITRA BANGSA ACEH UTARA');
INSERT INTO "public"."universitas" VALUES (100622, 133049, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER HARAPAN IBU');
INSERT INTO "public"."universitas" VALUES (100623, 133050, 'SEKOLAH TINGGI ILMU HUKUM KEBANGSAAN BIREUEN');
INSERT INTO "public"."universitas" VALUES (100624, 133051, 'STIKES ASSYIFA ACEH');
INSERT INTO "public"."universitas" VALUES (100625, 133052, 'SEKOLAH TINGGI ILMU HUKUM AL-BANNA');
INSERT INTO "public"."universitas" VALUES (100626, 133053, 'SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH ACEH');
INSERT INTO "public"."universitas" VALUES (100627, 134001, 'AKADEMI MANAJEMEN BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100628, 134004, 'AKADEMI SEKRETARI MANAJEMEN TANAH RENCONG');
INSERT INTO "public"."universitas" VALUES (100629, 134005, 'AKADEMI SEKRETARI MANAJEMEN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100630, 134006, 'AMIK INDONESIA');
INSERT INTO "public"."universitas" VALUES (100631, 134007, 'AKADEMI PARIWISATA MUHAMMADIYAH BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100632, 134008, 'AKADEMI KEUANGAN PERBANKAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100633, 134009, 'AMIK JABAL GHAFUR');
INSERT INTO "public"."universitas" VALUES (100634, 134010, 'AKADEMI KEUANGAN PERBANKAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (100635, 134011, 'AKADEMI MARITIM NUSANTARA MALAHAYATI');
INSERT INTO "public"."universitas" VALUES (100636, 134012, 'AKADEMI MARITIM ACEH DARUSSALAM');
INSERT INTO "public"."universitas" VALUES (100637, 134013, 'AKADEMI PERIKANAN DAN ILMU KELAUTAN');
INSERT INTO "public"."universitas" VALUES (100638, 134014, 'AKADEMI KEBIDANAN DARUSSALAM');
INSERT INTO "public"."universitas" VALUES (100639, 134015, 'AKADEMI KEPERAWATAN YAPPKES ACEH SINGKIL');
INSERT INTO "public"."universitas" VALUES (100640, 134016, 'AKADEMI KEPERAWATAN TEUNGKU FAKINAH BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100641, 134017, 'AKADEMI KEBIDANAN BUSTANUL ULUM LANGSA');
INSERT INTO "public"."universitas" VALUES (100642, 134018, 'AKADEMI KEBIDANAN PUBLIC HEALTH MEDICAL NURSING');
INSERT INTO "public"."universitas" VALUES (100643, 134019, 'AKADEMI KEBIDANAN SALEHA');
INSERT INTO "public"."universitas" VALUES (100644, 134020, 'AKADEMI KEBIDANAN HARAPAN IBU LANGSA');
INSERT INTO "public"."universitas" VALUES (100645, 134021, 'AKADEMI KEBIDANAN NURUL HASANAH');
INSERT INTO "public"."universitas" VALUES (100646, 134022, 'AKADEMI KEBIDANAN YAYASAN PENDIDIKAN MONA');
INSERT INTO "public"."universitas" VALUES (100647, 134023, 'AKADEMI KEBIDANAN MEDICA PUTRO BUNGSU');
INSERT INTO "public"."universitas" VALUES (100648, 134024, 'AKADEMI KEBIDANAN NADHIRAH');
INSERT INTO "public"."universitas" VALUES (101816, 233160, 'SEKOLAH TINGGI TEOLOGI SALEM');
INSERT INTO "public"."universitas" VALUES (101817, 233161, 'SEKOLAH TINGGI TEOLOGI SATYABHAKTI');
INSERT INTO "public"."universitas" VALUES (101818, 233162, 'SEKOLAH TINGGI ALKITAB BATU MALANG');
INSERT INTO "public"."universitas" VALUES (101819, 233163, 'SEKOLAH TINGGI TEOLOGI BETHANY SURABAYA');
INSERT INTO "public"."universitas" VALUES (101820, 233164, 'SEKOLAH TINGGI TEOLOGI PARAKLETOS SURABAYA');
INSERT INTO "public"."universitas" VALUES (101821, 233165, 'SEKOLAH TINGGI AGAMA KRISTEN ABDI WACANA');
INSERT INTO "public"."universitas" VALUES (101822, 233166, 'STT TABERNAKEL INDONESIA SURABAYA');
INSERT INTO "public"."universitas" VALUES (101823, 233167, 'SEKOLAH TINGGI TEOLOGI INJILI EFRATA SIDOARJO');
INSERT INTO "public"."universitas" VALUES (101824, 233168, 'SEKOLAH TINGGI TEOLOGI ADHI WACANA SURABAYA');
INSERT INTO "public"."universitas" VALUES (101825, 233169, 'SEKOLAH TINGGI TEOLOGI ALETHEIA');
INSERT INTO "public"."universitas" VALUES (101826, 233170, 'SEKOLAH TINGGI TEOLOGI TABERNAKEL LAWANG');
INSERT INTO "public"."universitas" VALUES (101827, 233171, 'SEKOLAH TINGGI TEOLOGI HAPPY FAMILY');
INSERT INTO "public"."universitas" VALUES (101828, 233172, 'SEKOLAH TINGGI ALKITAB GPDI BEIJI');
INSERT INTO "public"."universitas" VALUES (101829, 233173, 'STT WIDYA AGAPE MALANG');
INSERT INTO "public"."universitas" VALUES (101830, 233174, 'SEKOLAH TINGGI TEOLOGI KADESI YOGYAKARTA');
INSERT INTO "public"."universitas" VALUES (101831, 233175, 'SEKOLAH TINGGI TEOLOGI LUTHERAN YOGYA');
INSERT INTO "public"."universitas" VALUES (101832, 233176, 'STT BERITA KITAB WAHYU INTERNATIONAL');
INSERT INTO "public"."universitas" VALUES (101833, 233177, 'SEKOLAH TINGGI TEOLOGI BIWARA WACANA');
INSERT INTO "public"."universitas" VALUES (101834, 233179, 'SEKOLAH TINGGI TEOLOGI KINGDOM BALI');
INSERT INTO "public"."universitas" VALUES (101835, 233180, 'STT BANUA NIHA KERISO PROTESTAN SUNDERMANN NIAS');
INSERT INTO "public"."universitas" VALUES (101836, 233181, 'SEKOLAH TINGGI TEOLOGI GEREJA KRISTEN LUTHER INDONESIA');
INSERT INTO "public"."universitas" VALUES (101837, 233182, 'STT GEREJA METODIS INDONESIA (GMI) BANDAR BARU');
INSERT INTO "public"."universitas" VALUES (101838, 233183, 'SEKOLAH TINGGI TEOLOGI GLOBAL MISI MEDAN');
INSERT INTO "public"."universitas" VALUES (101839, 233185, 'SEKOLAH TINGGI TEOLOGI SILOAM MEDAN');
INSERT INTO "public"."universitas" VALUES (101840, 233186, 'SEKOLAH TINGGI TEOLOGI SOLA GRATIA MEDAN');
INSERT INTO "public"."universitas" VALUES (101841, 233187, 'SEKOLAH TINGGI TEOLOGI SUMATERA MEDAN');
INSERT INTO "public"."universitas" VALUES (101842, 233188, 'SEKOLAH TINGGI TEOLOGI SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (101843, 233189, 'SEKOLAH TINGGI TEOLOGI WILLIAM CAREY MEDAN');
INSERT INTO "public"."universitas" VALUES (101844, 233191, 'STT INJILI INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (101845, 233192, 'SEKOLAH TINGGI TEOLOGI RENATUS PEMATANG SIANTAR');
INSERT INTO "public"."universitas" VALUES (101846, 233193, 'SEKOLAH TINGGI TEOLOGI HKBP');
INSERT INTO "public"."universitas" VALUES (101847, 233194, 'SEKOLAH TINGGI TEOLOGI NIAS');
INSERT INTO "public"."universitas" VALUES (101848, 233195, 'STT OIKUMENE INJILI SIDIKALANG');
INSERT INTO "public"."universitas" VALUES (101849, 233196, 'SEKOLAH TINGGI TEOLOGI IMANUEL MINISTRY EL SHADDAY');
INSERT INTO "public"."universitas" VALUES (101850, 233197, 'SEKOLAH TINGGI TEOLOGI SYALOM NIAS');
INSERT INTO "public"."universitas" VALUES (101851, 233198, 'SEKOLAH TINGGI TEOLOGI PELITA KEBENARAN');
INSERT INTO "public"."universitas" VALUES (101852, 233199, 'STT SOLA FIDE');
INSERT INTO "public"."universitas" VALUES (101853, 233200, 'SEKOLAH TINGGI AGAMA KRISTEN EMMANUEL AGUNG NIAS');
INSERT INTO "public"."universitas" VALUES (101854, 233201, 'SEKOLAH TINGGI TEOLOGI REFORMED INJILI LUMBANTOR');
INSERT INTO "public"."universitas" VALUES (101855, 233202, 'STT INJILI ARASTAMAR NIAS SELATAN');
INSERT INTO "public"."universitas" VALUES (101856, 233203, 'STT TRINITY PARAPAT');
INSERT INTO "public"."universitas" VALUES (101857, 233204, 'STT KASIH MENTAWAI');
INSERT INTO "public"."universitas" VALUES (101858, 233205, 'STT EBENHAEZER TANJUNG ENIM');
INSERT INTO "public"."universitas" VALUES (101859, 233206, 'SEKOLAH TINGGI TEOLOGI AGAPE BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101860, 233207, 'SEKOLAH TINGGI TEOLOGI SYALOM BANDAR LAMPUNG');
INSERT INTO "public"."universitas" VALUES (101861, 233208, 'SEKOLAH TINGGI TEOLOGI ARASTAMAR BENGKULU');
INSERT INTO "public"."universitas" VALUES (101862, 233209, 'SEKOLAH TINGGI TEOLOGI CALVARY BATAM');
INSERT INTO "public"."universitas" VALUES (101863, 233210, 'SEKOLAH TINGGI TEOLOGI HUPERETES BATAM');
INSERT INTO "public"."universitas" VALUES (101864, 233211, 'SEKOLAH TINGGI TEOLOGI PRESBYTERIAN BATAM');
INSERT INTO "public"."universitas" VALUES (101865, 233212, 'SEKOLAH TINGGI TEOLOGI SIDANG JEMAAT KRISTUS');
INSERT INTO "public"."universitas" VALUES (101866, 233213, 'SEKOLAH TINGGI TEOLOGI PANTEKOSTA BATAM');
INSERT INTO "public"."universitas" VALUES (101867, 233214, 'STT ARASTAMAR RIAU');
INSERT INTO "public"."universitas" VALUES (101868, 233215, 'SEKOLAH TINGGI AGAMA KRISTEN PAIS BATAM');
INSERT INTO "public"."universitas" VALUES (101869, 233216, 'SEKOLAH TINGGI TEOLOGI ATI ANJUNGAN PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101870, 233217, 'SEKOLAH TINGGI TEOLOGI BEREA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101871, 233218, 'SEKOLAH TINGGI THEOLOGIA INJILI INDONESIA PONTIANAK');
INSERT INTO "public"."universitas" VALUES (101872, 233219, 'SEKOLAH TINGGI TEOLOGI BORNEO');
INSERT INTO "public"."universitas" VALUES (101873, 233220, 'SEKOLAH TINGGI TEOLOGI KHATULISTIWA SINTANG');
INSERT INTO "public"."universitas" VALUES (101874, 233221, 'SEKOLAH TINGGI TEOLOGI IMMANUEL SINTANG KAL-BAR');
INSERT INTO "public"."universitas" VALUES (101875, 233222, 'SEKOLAH TINGGI TEOLOGI TENGGARONG');
INSERT INTO "public"."universitas" VALUES (101876, 233223, 'SEKOLAH TINGGI TEOLOGI INJIL ARASTAMAR NGABANG');
INSERT INTO "public"."universitas" VALUES (101877, 233224, 'SEKOLAH TINGGI TEOLOGI WILLFINGGER KAMPUNG BARU');
INSERT INTO "public"."universitas" VALUES (101878, 233225, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA SAMARINDA');
INSERT INTO "public"."universitas" VALUES (101879, 233226, 'SEKOLAH TINGGI TEOLOGI KIBAID MAKALE');
INSERT INTO "public"."universitas" VALUES (101880, 233227, 'SEKOLAH TINGGI FILSAFAT JAFFRAY MAKASSAR');
INSERT INTO "public"."universitas" VALUES (101881, 233228, 'STT YESYURUN ARASTAMAR SERITI LUWU');
INSERT INTO "public"."universitas" VALUES (101882, 233229, 'SEKOLAH TINGGI TEOLOGI MAMASA');
INSERT INTO "public"."universitas" VALUES (101883, 233230, 'STT SULBAR DI MAMUJU');
INSERT INTO "public"."universitas" VALUES (101884, 233231, 'SEKOLAH TINGGI ALKITAB GINOSKO AIRMADIDI');
INSERT INTO "public"."universitas" VALUES (101885, 233232, 'SEKOLAH TINGGI AGAMA KRISTEN APOLLOS MANADO');
INSERT INTO "public"."universitas" VALUES (101886, 233233, 'SEKOLAH TINGGI TEOLOGI MISSIO DEI INDONESIA');
INSERT INTO "public"."universitas" VALUES (101887, 233234, 'SEKOLAH TINGGI TEOLOGI RHEMA PNEUMATIKOS');
INSERT INTO "public"."universitas" VALUES (101888, 233235, 'SEKOLAH TINGGI TEOLOGI PENTAKOSTA MOOAT');
INSERT INTO "public"."universitas" VALUES (101889, 233236, 'SEKOLAH TINGGI TEOLOGI PARAKLETOS TOMOHON');
INSERT INTO "public"."universitas" VALUES (101890, 233237, 'SEKOLAH TINGGI TEOLOGI TABERNAKEL TOMOHON');
INSERT INTO "public"."universitas" VALUES (101891, 233238, 'SEKOLAH TINGGI TEOLOGI ARASTAMAR MAMASA');
INSERT INTO "public"."universitas" VALUES (101892, 233239, 'STT BAHTERA JOSIAS');
INSERT INTO "public"."universitas" VALUES (101893, 233240, 'STT INJILI SETIA SIAU');
INSERT INTO "public"."universitas" VALUES (101894, 233241, 'SEKOLAH TINGGI TEOLOGI ISTTO HIKMAT WAHYU');
INSERT INTO "public"."universitas" VALUES (101895, 233242, 'SEKOLAH TINGGI TEOLOGI FILADELFIA LANGOWAN');
INSERT INTO "public"."universitas" VALUES (99228, 73175, 'SEKOLAH TINGGI ILMU KESEHATAN HARAPAN BANGSA');
INSERT INTO "public"."universitas" VALUES (99229, 73176, 'STIKES ARRAHMA MANDIRI INDONESIA');
INSERT INTO "public"."universitas" VALUES (99230, 73177, 'SEKOLAH TINGGI KEWIRAUSAHAAN SELAMAT PAGI INDONESIA');
INSERT INTO "public"."universitas" VALUES (99231, 73178, 'STIKES PANTI WALUYA MALANG');
INSERT INTO "public"."universitas" VALUES (99232, 73179, 'SEKOLAH TINGGI ILMU EKONOMI KH. BAHAUDIN MUDHARY MADURA');
INSERT INTO "public"."universitas" VALUES (99233, 73180, 'STIKES PAMENANG');
INSERT INTO "public"."universitas" VALUES (99235, 73182, 'SEKOLAH TINGGI TEKNOLOGI MUHAMMADIYAH AR FACHRUDDIN');
INSERT INTO "public"."universitas" VALUES (99236, 73183, 'SEKOLAH TINGGI ILMU KESEHATAN NAZHATUT THULLAB SAMPANG');
INSERT INTO "public"."universitas" VALUES (99237, 73184, 'SEKOLAH TINGGI ILMU KESEHATAN RAJEKWESI BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99238, 73185, 'SEKOLAH TINGGI ILMU EKONOMI DARUL FALAH');
INSERT INTO "public"."universitas" VALUES (99239, 74001, 'AKADEMI TEKNOLOGI INDUSTRI TEKSTIL SURABAYA');
INSERT INTO "public"."universitas" VALUES (99240, 74002, 'AKADEMI SEKRETARI DAN MANAJEMEN INDONESIA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99241, 74003, 'AKADEMI AKUPUNKTUR SURABAYA');
INSERT INTO "public"."universitas" VALUES (99242, 74005, 'AKADEMI TEKNIK NASIONAL SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99243, 74006, 'AKADEMI BAHASA ASING WEBB');
INSERT INTO "public"."universitas" VALUES (99244, 74013, 'AKADEMI MANAJEMEN KOPERASI KEDIRI');
INSERT INTO "public"."universitas" VALUES (99245, 74014, 'AKADEMI MANAJEMEN KOPERASI TANTULAR');
INSERT INTO "public"."universitas" VALUES (99246, 74018, 'AKADEMI MANAJEMEN PERPAJAKAN INDONESIA BLITAR');
INSERT INTO "public"."universitas" VALUES (99247, 74020, 'AKADEMI PERIKANAN QOMARUDDIN');
INSERT INTO "public"."universitas" VALUES (99248, 74023, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER JOMBANG');
INSERT INTO "public"."universitas" VALUES (99249, 74026, 'AKADEMI AKUNTANSI PGRI JEMBER');
INSERT INTO "public"."universitas" VALUES (99250, 74027, 'AKADEMI PARIWISATA 17 AGUSTUS 1945 SURABAYA');
INSERT INTO "public"."universitas" VALUES (99251, 74030, 'AKADEMI PARIWISATA MUHAMMADIYAH JEMBER');
INSERT INTO "public"."universitas" VALUES (99252, 74031, 'AKADEMI SEKRETARI WIDYA MANDALA SURABAYA');
INSERT INTO "public"."universitas" VALUES (99253, 74032, 'AKADEMI PARIWISATA MAJAPAHIT');
INSERT INTO "public"."universitas" VALUES (99254, 74033, 'AKADEMI MANAJEMEN INFORMATIKA DAN KOMPUTER TARUNA');
INSERT INTO "public"."universitas" VALUES (99255, 74035, 'AMIK IBRAHIMY');
INSERT INTO "public"."universitas" VALUES (99256, 74036, 'AKADEMI PERIKANAN IBRAHIMY');
INSERT INTO "public"."universitas" VALUES (99257, 74037, 'AKADEMI ANALIS KESEHATAN UNMUH SURABAYA');
INSERT INTO "public"."universitas" VALUES (99258, 74038, 'AKADEMI KEPERAWATAN BAHRUL ULUM JOMBANG');
INSERT INTO "public"."universitas" VALUES (99259, 74039, 'ASM WIDYA MANDALA MADIUN');
INSERT INTO "public"."universitas" VALUES (99260, 74040, 'AKADEMI KEPERAWATAN DIAN HUSADA');
INSERT INTO "public"."universitas" VALUES (99261, 74041, 'AKADEMI KEBIDANAN DARUL ULUM JOMBANG');
INSERT INTO "public"."universitas" VALUES (99262, 74043, 'AKADEMI ANALIS KESEHATAN YPM SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99263, 74045, 'AKADEMI KEPERAWATAN HAFSHAWATY ZAINUL HASAN');
INSERT INTO "public"."universitas" VALUES (99264, 74046, 'AKADEMI KEBIDANAN DHARMA HUSADA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99265, 74047, 'AKADEMI PEREKAM MEDIK DAN INFOKES PENA HUSADA');
INSERT INTO "public"."universitas" VALUES (99266, 74049, 'AKADEMI KEPERAWATAN DHARMA HUSADA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99267, 74050, 'AKADEMI KEPERAWATAN PAMENANG');
INSERT INTO "public"."universitas" VALUES (99268, 74051, 'AKADEMI KEPERAWATAN NAZHATUT THULLAB SAMPANG');
INSERT INTO "public"."universitas" VALUES (99269, 74052, 'AKADEMI KEPERAWATAN KERTA CENDEKIA SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99270, 74053, 'AKADEMI KELAUTAN BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99271, 74055, 'AKADEMI KEBIDANAN PAMENANG');
INSERT INTO "public"."universitas" VALUES (99272, 74057, 'AKADEMI KULINER MONAS PASIFIK');
INSERT INTO "public"."universitas" VALUES (99273, 74064, 'AKADEMI PARIWISATA DAN PERHOTELAN GANESHA');
INSERT INTO "public"."universitas" VALUES (99274, 74070, 'AKADEMI KEBIDANAN NGUDIA HUSADA MADURA');
INSERT INTO "public"."universitas" VALUES (99275, 74072, 'AKADEMI KEBIDANAN GRIYA HUSADA');
INSERT INTO "public"."universitas" VALUES (99276, 74073, 'AKADEMI KEPERAWATAN BINA SEHAT PPNI MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (99277, 74074, 'AKADEMI KEBIDANAN JEMBER');
INSERT INTO "public"."universitas" VALUES (99278, 74075, 'AKBID SITI KHOTIDJAH MUHAMMADIYAH SEPANJANG');
INSERT INTO "public"."universitas" VALUES (99279, 74076, 'AKADEMI KEPERAWATAN WILLIAM BOOTH SURABAYA');
INSERT INTO "public"."universitas" VALUES (99280, 74078, 'AKADEMI KEPERAWATAN ADI HUSADA');
INSERT INTO "public"."universitas" VALUES (99281, 74079, 'AKADEMI KESEHATAN RAJEKWESI BOJONEGORO');
INSERT INTO "public"."universitas" VALUES (99282, 74080, 'AKADEMI KEPERAWATAN PEMERINTAH KABUPATEN NGAWI');
INSERT INTO "public"."universitas" VALUES (99283, 74081, 'AKADEMI REFRAKSI OPTISI SURABAYA');
INSERT INTO "public"."universitas" VALUES (99284, 74082, 'AKADEMI FARMASI PUTERA INDONESIA MALANG');
INSERT INTO "public"."universitas" VALUES (99285, 74085, 'AKADEMI ANALIS FARMASI DAN MAKANAN PUTRA INDONESIA MALANG');
INSERT INTO "public"."universitas" VALUES (99286, 74088, 'AKBID HARAPAN MULYA PONOROGO');
INSERT INTO "public"."universitas" VALUES (99287, 74089, 'AKADEMI KEBIDANAN MITRA SEHAT SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99288, 74091, 'AKADEMI KEBIDANAN BHAKTI HUSADA MULIA');
INSERT INTO "public"."universitas" VALUES (99289, 74092, 'AKADEMI KEBIDANAN MANDIRI GRESIK');
INSERT INTO "public"."universitas" VALUES (99290, 74093, 'AKADEMI KEBIDANAN DELIMA PERSADA GRESIK');
INSERT INTO "public"."universitas" VALUES (99291, 74094, 'AKADEMI KEBIDANAN BINA HUSADA JEMBER');
INSERT INTO "public"."universitas" VALUES (99292, 74095, 'AKADEMI KEBIDANAN AIFA HUSADA');
INSERT INTO "public"."universitas" VALUES (99293, 74096, 'AKADEMI KEBIDANAN AR-RAHMA');
INSERT INTO "public"."universitas" VALUES (99294, 74097, 'AKADEMI KEPERAWATAN PANTI WALUYA MALANG');
INSERT INTO "public"."universitas" VALUES (99295, 74098, 'AKADEMI KEBIDANAN MEDIKA WIYATA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99296, 74099, 'AKADEMI KEBIDANAN WIRA HUSADA NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99297, 74100, 'AKADEMI ANALIS FARMASI DAN MAKANAN SUNAN GIRI');
INSERT INTO "public"."universitas" VALUES (99298, 74101, 'AKADEMI KEBIDANAN WIJAYA KUSUMA MALANG');
INSERT INTO "public"."universitas" VALUES (99299, 74102, 'AKADEMI KEBIDANAN HAFSHAWATY ZAINUL HASAN GENGGONG');
INSERT INTO "public"."universitas" VALUES (99300, 74103, 'AKADEMI KEBIDANAN WIYATA MITRA HUSADA NGANJUK');
INSERT INTO "public"."universitas" VALUES (99301, 74104, 'AKADEMI KEBIDANAN SAKINAH');
INSERT INTO "public"."universitas" VALUES (99302, 74106, 'AKADEMI KEBIDANAN MUHAMMADIYAH MADIUN');
INSERT INTO "public"."universitas" VALUES (99303, 74107, 'AKADEMI KESEHATAN ARGA HUSADA');
INSERT INTO "public"."universitas" VALUES (99304, 74108, 'AKADEMI ANALIS KESEHATAN MALANG');
INSERT INTO "public"."universitas" VALUES (99305, 74110, 'AKADEMI KEBIDANAN BERLIAN NUSANTARA');
INSERT INTO "public"."universitas" VALUES (99306, 74111, 'AKADEMI KEBIDANAN IBRAHIMY SITUBONDO');
INSERT INTO "public"."universitas" VALUES (99307, 74112, 'AKADEMI KEBIDANAN PGRI KEDIRI');
INSERT INTO "public"."universitas" VALUES (99308, 74113, 'AKADEMI KEBIDANAN WAHANA SEHAT SIDOARJO');
INSERT INTO "public"."universitas" VALUES (100649, 134025, 'AKADEMIK TEKNIK OTOMOTIF BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100650, 134026, 'AKADEMI KEBIDANAN MEDICA BAKTI PERSADA');
INSERT INTO "public"."universitas" VALUES (100651, 134027, 'AKADEMI KEBIDANAN MUNAWARRAH BIREUEN');
INSERT INTO "public"."universitas" VALUES (100652, 134028, 'AKADEMI FISIOTERAPI HARAPAN BANGSA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100653, 134029, 'AKADEMI ANALIS FARMASI DAN MAKANAN BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100654, 134030, 'AKADEMI KEBIDANAN GAYO LUES');
INSERT INTO "public"."universitas" VALUES (100655, 134031, 'AKADEMI KEBIDANAN ADHIRA MUSTIKA GAYO');
INSERT INTO "public"."universitas" VALUES (100656, 134032, 'AKADEMI KEBIDANAN DARUL HUSADA');
INSERT INTO "public"."universitas" VALUES (100657, 134033, 'AKADEMI KEBIDANAN BUNGA BANGSA IDI');
INSERT INTO "public"."universitas" VALUES (100658, 134034, 'AKADEMI KEBIDANAN MEDICA ALAS LEUSER');
INSERT INTO "public"."universitas" VALUES (100659, 134035, 'AKADEMI KEPERAWATAN IBNU SINA KOTA SABANG');
INSERT INTO "public"."universitas" VALUES (100660, 134036, 'AKADEMI KEBIDANAN MEDICA BAKTI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100661, 134037, 'AKADEMI KEBIDANAN PIDIE JAYA');
INSERT INTO "public"."universitas" VALUES (100662, 134038, 'AKADEMI FARMASI YPPM MANDIRI');
INSERT INTO "public"."universitas" VALUES (100663, 134039, 'AKADEMI KEBIDANAN MEDIKA SRI TAMIANG');
INSERT INTO "public"."universitas" VALUES (100664, 134040, 'AKADEMI KEBIDANAN MUHAMMADIYAH BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100665, 134041, 'AKADEMI KEPERAWATAN ABULYATAMA');
INSERT INTO "public"."universitas" VALUES (100666, 134042, 'AKADEMI KEPERAWATAN KESDAM ISKANDAR MUDA LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100667, 134043, 'AKADEMI KEPERAWATAN KESDAM ISKANDAR MUDA BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100668, 134044, 'AKADEMI KESEHATAN LINGKUNGAN JABAL GHAFUR');
INSERT INTO "public"."universitas" VALUES (100669, 134045, 'AKADEMI KEPERAWATAN JABAL GHAFUR');
INSERT INTO "public"."universitas" VALUES (100670, 134046, 'AKADEMI KEBIDANAN MEULIGOE NUR AMIN');
INSERT INTO "public"."universitas" VALUES (100671, 134047, 'AKADEMI PEREKAM DAN INFO KES SIHAT BEURATA');
INSERT INTO "public"."universitas" VALUES (100672, 134048, 'AKADEMI TEKNIK ELEKTROMEDIK KUPULA ACEH');
INSERT INTO "public"."universitas" VALUES (100673, 134049, 'AKADEMI KEBIDANAN MEDIKA ANUGERAH TASYA');
INSERT INTO "public"."universitas" VALUES (100674, 134050, 'AKADEMI TEKNIK RADIODIAGNOSTIK DAN RADIOTERAPI (ATRO) BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100675, 134051, 'AKADEMI FISIOTERAPI MUHAMMADIYAH ACEH');
INSERT INTO "public"."universitas" VALUES (100676, 134052, 'AKADEMI KEPERAWATAN MUHAMMADIYAH BIREUEN');
INSERT INTO "public"."universitas" VALUES (100677, 134053, 'AKADEMI MANAJEMEN GUNUNG LEUSER');
INSERT INTO "public"."universitas" VALUES (100678, 135001, 'POLITEKNIK ACEH');
INSERT INTO "public"."universitas" VALUES (100679, 135002, 'POLITEKNIK INDONESIA VENEZUELA');
INSERT INTO "public"."universitas" VALUES (100680, 135003, 'POLITEKNIK ACEH SELATAN');
INSERT INTO "public"."universitas" VALUES (100681, 135004, 'POLITEKNIK KUTARAJA');
INSERT INTO "public"."universitas" VALUES (100682, 141001, 'UNIVERSITAS MUHAMMADIYAH SORONG');
INSERT INTO "public"."universitas" VALUES (100683, 141002, 'UNIVERSITAS SAINS DAN TEKNOLOGI JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100684, 141003, 'UNIVERSITAS YAPIS PAPUA');
INSERT INTO "public"."universitas" VALUES (100685, 141004, 'UNIVERSITAS SATYA WIYATA MANDALA');
INSERT INTO "public"."universitas" VALUES (100686, 141005, 'UNIVERSITAS KRISTEN PAPUA');
INSERT INTO "public"."universitas" VALUES (100687, 141006, 'UNIVERSITAS TIMIKA');
INSERT INTO "public"."universitas" VALUES (100688, 141007, 'UNIVERSITAS VICTORY SORONG');
INSERT INTO "public"."universitas" VALUES (100689, 141008, 'UNIVERSITAS OTTOW GEISSLER');
INSERT INTO "public"."universitas" VALUES (100690, 141009, 'UNIVERSITAS NANI BILI NUSANTARA');
INSERT INTO "public"."universitas" VALUES (100691, 141010, 'UNIVERSITAS PENDIDIKAN MUHAMMADIYAH SORONG');
INSERT INTO "public"."universitas" VALUES (100692, 141011, 'UNIVERSITAS AMAL ILMIAH YAPIS WAMENA');
INSERT INTO "public"."universitas" VALUES (100693, 142001, 'IISIP YAPIS BIAK');
INSERT INTO "public"."universitas" VALUES (100694, 142002, 'INSTITUT SAINS DAN TEKNOLOGI INDONESIA MANOKWARI');
INSERT INTO "public"."universitas" VALUES (100695, 143001, 'SEKOLAH TINGGI ILMU HUKUM MANOKWARI');
INSERT INTO "public"."universitas" VALUES (100696, 143002, 'STISIP SILAS PAPARE JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100697, 143003, 'STFT GKI IZAAK SAMUEL KIJNE JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100698, 143004, 'SEKOLAH TINGGI FILSAFAT FAJAR TIMUR JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100699, 143005, 'SEKOLAH TINGGI ILMU ADMINISTRASI KARYA DHARMA MERAUKE');
INSERT INTO "public"."universitas" VALUES (100700, 143006, 'STKIP ABDI WACANA WAMENA');
INSERT INTO "public"."universitas" VALUES (100701, 143007, 'STIE OTTOW & GEISSLER FAK-FAK');
INSERT INTO "public"."universitas" VALUES (100702, 143008, 'SEKOLAH TINGGI ILMU ADMINISTRASI ASY SYAFI IYAH');
INSERT INTO "public"."universitas" VALUES (100703, 143009, 'SEKOLAH TINGGI ILMU EKONOMI PORT NUMBAY JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100704, 143010, 'STIPER SANTO THOMAS AQUINAS JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100705, 143011, 'SEKOLAH TINGGI ILMU EKONOMI OTTOW & GEISSLER SERUI');
INSERT INTO "public"."universitas" VALUES (100706, 143012, 'STIKOM MUHAMMADIYAH JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100707, 143013, 'SEKOLAH TINGGI ILMU EKONOMI JAMBATAN BULAN');
INSERT INTO "public"."universitas" VALUES (100708, 143014, 'SEKOLAH TINGGI ILMU HUKUM BINTUNI');
INSERT INTO "public"."universitas" VALUES (100709, 143015, 'SEKOLAH TINGGI ILMU EKONOMI MAH-EISA');
INSERT INTO "public"."universitas" VALUES (100710, 143016, 'SEKOLAH TINGGI ILMU HUKUM UMEL MANDIRI');
INSERT INTO "public"."universitas" VALUES (100711, 143017, 'SEKOLAH TINGGI ILMU EKONOMI BUKIT ZAITUN SORONG');
INSERT INTO "public"."universitas" VALUES (100712, 143018, 'SEKOLAH TINGGI SENI PAPUA');
INSERT INTO "public"."universitas" VALUES (100713, 143019, 'STKIP MUHAMMADIYAH SORONG');
INSERT INTO "public"."universitas" VALUES (100714, 143020, 'SEKOLAH TINGGI ILMU EKONOMI AMOR TIMIKA');
INSERT INTO "public"."universitas" VALUES (100715, 143021, 'SEKOLAH TINGGI ILMU KESEHATAN PAPUA');
INSERT INTO "public"."universitas" VALUES (100716, 143022, 'SEKOLAH TINGGI ILMU HUKUM BIAK-PAPUA');
INSERT INTO "public"."universitas" VALUES (100717, 143023, 'STIMIK SEPULUH NOPEMBER JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100718, 143024, 'SEKOLAH TINGGI ILMU PERTANIAN PETRA BALIEM WAMENA');
INSERT INTO "public"."universitas" VALUES (100719, 143025, 'STKIP KRISTEN WAMENA');
INSERT INTO "public"."universitas" VALUES (100720, 143026, 'STISIPOL YALEKA MARO');
INSERT INTO "public"."universitas" VALUES (100721, 143027, 'STKIP MUHAMMADIYAH MANOKWARI');
INSERT INTO "public"."universitas" VALUES (100722, 143028, 'SEKOLAH TINGGI ILMU KESEHATAN JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100723, 143029, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN NUUWAR');
INSERT INTO "public"."universitas" VALUES (100724, 143030, 'STISIP AMAL ILMIAH YAPIS WAMENA');
INSERT INTO "public"."universitas" VALUES (100725, 143031, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN BIAK');
INSERT INTO "public"."universitas" VALUES (100726, 143032, 'SEKOLAH TINGGI ILMU MANAJEMEN INFORMATIKA & TEKNIK KOMPUTER AGAMUA WAMENA PAPUA');
INSERT INTO "public"."universitas" VALUES (100727, 143033, 'SEKOLAH TINGGI ILMU EKONOMI YAPIS MERAUKE');
INSERT INTO "public"."universitas" VALUES (100728, 143034, 'STIE SAINT THERESA');
INSERT INTO "public"."universitas" VALUES (100729, 143035, 'STKIP HERMON TIMIKA');
INSERT INTO "public"."universitas" VALUES (100730, 143036, 'STMIK KREATINDO MANOKWARI');
INSERT INTO "public"."universitas" VALUES (100731, 143037, 'STIE TRINITAS SORONG');
INSERT INTO "public"."universitas" VALUES (101896, 233243, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA PALU');
INSERT INTO "public"."universitas" VALUES (101897, 233244, 'SEKOLAH TINGGI TEOLOGI MARTURIA PALU');
INSERT INTO "public"."universitas" VALUES (101898, 233245, 'SEKOLAH TINGGI TEOLOGI PALU');
INSERT INTO "public"."universitas" VALUES (101899, 233246, 'SEKOLAH TINGGI TEOLOGI PANTEKOSTA POSO');
INSERT INTO "public"."universitas" VALUES (101900, 233247, 'SEKOLAH TINGGI TEOLOGI GEREJA KRISTEN SULAWESI TENGAH TENTENA');
INSERT INTO "public"."universitas" VALUES (101901, 233248, 'STT STAR''S LUB LUWUK BANGGAI');
INSERT INTO "public"."universitas" VALUES (101902, 233249, 'SEKOLAH TINGGI TEOLOGI KALVARI MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (101903, 233250, 'SEKOLAH TINGGI TEOLOGI BETHEL AMBON');
INSERT INTO "public"."universitas" VALUES (101904, 233251, 'SEKOLAH TINGGI AGAMA KRISTEN INFORMATIKA TIMOR');
INSERT INTO "public"."universitas" VALUES (101905, 233252, 'SEKOLAH TINGGI TEOLOGI ARTA WACANA KUPANG');
INSERT INTO "public"."universitas" VALUES (101906, 233253, 'SEKOLAH TINGGI TEOLOGI TERPADU WAINGAPU');
INSERT INTO "public"."universitas" VALUES (101907, 233254, 'STT GEREJA KRISTEN SUMBA');
INSERT INTO "public"."universitas" VALUES (101908, 233255, 'SEKOLAH TINGGI THEOLOGIA INJILI INDONESIA LOMBOK');
INSERT INTO "public"."universitas" VALUES (101909, 233256, 'STT ARASTAMAR MATARAM');
INSERT INTO "public"."universitas" VALUES (101910, 233257, 'STT SOE PROV. NUSA TENGGARA TIMUR');
INSERT INTO "public"."universitas" VALUES (101911, 233258, 'STT INJILI INDONESIA KUPANG');
INSERT INTO "public"."universitas" VALUES (101912, 233259, 'STT GEREJA INJILI DI INDONESIA');
INSERT INTO "public"."universitas" VALUES (101913, 233260, 'SEKOLAH TINGGI AGAMA KRISTEN AMPARI SERUI');
INSERT INTO "public"."universitas" VALUES (101914, 233261, 'SEKOLAH TINGGI AGAMA KRISTEN DIASPORA WAMENA');
INSERT INTO "public"."universitas" VALUES (101915, 233262, 'SEKOLAH TINGGI TEOLOGI REFORMASI WAMENA');
INSERT INTO "public"."universitas" VALUES (101916, 233263, 'STT LEVINUS RUMASEB SENTANI');
INSERT INTO "public"."universitas" VALUES (101917, 233264, 'STT ARASTAMAR WAMENA');
INSERT INTO "public"."universitas" VALUES (101918, 233265, 'STT INJILI ARASTAMAR NABIRE');
INSERT INTO "public"."universitas" VALUES (101919, 233266, 'STT ARASTAMAR MERAUKE');
INSERT INTO "public"."universitas" VALUES (101920, 233267, 'STT PAPUA DI SUPIORI');
INSERT INTO "public"."universitas" VALUES (101921, 233268, 'STAK ANAK BANGSA');
INSERT INTO "public"."universitas" VALUES (101922, 233269, 'STT ANUGRAH INDONESIA');
INSERT INTO "public"."universitas" VALUES (101923, 233270, 'STT PELITA HATI');
INSERT INTO "public"."universitas" VALUES (101924, 233271, 'STT PETRA');
INSERT INTO "public"."universitas" VALUES (101925, 233272, 'STT ADVENT PAPUA');
INSERT INTO "public"."universitas" VALUES (101926, 233273, 'STT MISI BETHANY JAKARTA');
INSERT INTO "public"."universitas" VALUES (101927, 233274, 'SEKOLAH TINGGI TEOLOGI REFORMED INJILI INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (101928, 233275, 'SEKOLAH TINGGI TEOLOGI IMAN JAKARTA');
INSERT INTO "public"."universitas" VALUES (101929, 233276, 'SEKOLAH TINGGI TEOLOGI KENOS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101930, 233277, 'SEKOLAH TINGGI TEOLOGI SILOAM INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (101931, 233278, 'SEKOLAH TINGGI TEOLOGI INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101932, 233279, 'SEKOLAH TINGGI TEOLOGI OBAJA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101933, 233280, 'SEKOLAH TINGGI TEOLOGI HAGIASMOS MISSION JAKARTA');
INSERT INTO "public"."universitas" VALUES (101934, 233281, 'SEKOLAH TINGGI TEOLOGI PARAUSORAT NAULI JAKARTA');
INSERT INTO "public"."universitas" VALUES (101935, 233282, 'SEKOLAH TINGGI TEOLOGI GLOBAL GLOW INDONESIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101936, 233283, 'SEKOLAH TINGGI TEOLOGI SUNERGEO BANTEN');
INSERT INTO "public"."universitas" VALUES (101937, 233284, 'SEKOLAH TINGGI TEOLOGI SABDA AGUNG (STTSA)');
INSERT INTO "public"."universitas" VALUES (101938, 233285, 'SEKOLAH TINGGI TEOLOGI ABDI GUSTI NGANJUK');
INSERT INTO "public"."universitas" VALUES (101939, 233286, 'SEKOLAH TINGGI TEOLOGI PROVIDENSIA ADONAY');
INSERT INTO "public"."universitas" VALUES (101940, 233287, 'SEKOLAH TINGGI AGAMA KRISTEN TERUNA BHAKTI');
INSERT INTO "public"."universitas" VALUES (101941, 233288, 'SEKOLAH TINGGI AGAMA KRISTEN BINA CITRA PERSADA MEDAN');
INSERT INTO "public"."universitas" VALUES (101942, 233289, 'SEKOLAH TINGGI DIAKONES HKBP BALIGE');
INSERT INTO "public"."universitas" VALUES (101943, 233290, 'SEKOLAH TINGGI GURU HURIA HKBP SIPOHOLON');
INSERT INTO "public"."universitas" VALUES (101944, 233291, 'SEKOLAH TINGGI TEOLOGI INJILI BETANIA MEDAN');
INSERT INTO "public"."universitas" VALUES (101945, 233292, 'SEKOLAH TINGGI BIBELVROUW HKBP LAGUBOTI');
INSERT INTO "public"."universitas" VALUES (101946, 233293, 'SEKOLAH TINGGI TEOLOGI INJILI ARASTAMAR TAPANULI (STT SIARNAULI)');
INSERT INTO "public"."universitas" VALUES (101947, 233294, 'SEKOLAH TINGGI TEOLOGI BINA MUDA WIRAWAN MEDAN');
INSERT INTO "public"."universitas" VALUES (101948, 233295, 'SEKOLAH TINGGI TEOLOGI REAL BATAM');
INSERT INTO "public"."universitas" VALUES (101949, 233296, 'SEKOLAH TINGGI TEOLOGI INJILI SETIA SINTANG');
INSERT INTO "public"."universitas" VALUES (101950, 233297, 'SEKOLAH TINGGI TEOLOGI BLESSING INDONESIA MAKASSAR');
INSERT INTO "public"."universitas" VALUES (101951, 233298, 'SEKOLAH TINGGI TEOLOGI AGAPE MANADO');
INSERT INTO "public"."universitas" VALUES (101952, 233299, 'SEKOLAH TINGGI TEOLOGI TRANSFORMASI INDONESIA');
INSERT INTO "public"."universitas" VALUES (101953, 233301, 'SEKOLAH TINGGI TEOLOGI MANADO');
INSERT INTO "public"."universitas" VALUES (101954, 233302, 'SEKOLAH TINGGI TEOLOGI HASTA MARTURIA MANADO');
INSERT INTO "public"."universitas" VALUES (101955, 233303, 'SEKOLAH TINGGI TEOLOGI KALVARI MANADO');
INSERT INTO "public"."universitas" VALUES (101956, 233304, 'SEKOLAH TINGGI TEOLOGI MARANATHA MANADO');
INSERT INTO "public"."universitas" VALUES (101957, 233305, 'SEKOLAH TINGGI AGAMA KRISTEN PAIS TALAUD');
INSERT INTO "public"."universitas" VALUES (101958, 233307, 'SEKOLAH TINGGI AGAMA KRISTEN ARASTAMAR SOE (STAKAS)');
INSERT INTO "public"."universitas" VALUES (101959, 233308, 'SEKOLAH TINGGI AGAMA KRISTEN MANOKWARI');
INSERT INTO "public"."universitas" VALUES (101960, 233309, 'SEKOLAH TINGGI TEOLOGI RUSSEL TIMIKA');
INSERT INTO "public"."universitas" VALUES (101961, 233310, 'SEKOLAH TINGGI TEOLOGI DIAN EKA SABDA KALIMANTAN TENGAH');
INSERT INTO "public"."universitas" VALUES (101962, 233311, 'SEKOLAH TINGGI SENI MUSIK CANTATA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101963, 233312, 'STT SRIWIJAYA PALEMBANG');
INSERT INTO "public"."universitas" VALUES (101964, 233313, 'STT INJILI DI PALEMBANG');
INSERT INTO "public"."universitas" VALUES (101965, 233314, 'STT ANUGERAH SINAGOGE MEDAN');
INSERT INTO "public"."universitas" VALUES (101966, 233315, 'STT SANGKAKALA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101967, 233316, 'STT REAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (101968, 233317, 'STT POKOK ANGGUR JAKARTA');
INSERT INTO "public"."universitas" VALUES (101969, 233318, 'STT KRISBA');
INSERT INTO "public"."universitas" VALUES (101970, 233319, 'STT PERMATA BANGSA BARITO');
INSERT INTO "public"."universitas" VALUES (101971, 233320, 'STT TAMAN FIRDAUS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101972, 233321, 'STT PAIS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101973, 233322, 'STT MAKEDONIA JAKARTA');
INSERT INTO "public"."universitas" VALUES (101974, 233323, 'STT BETHEL BEKASI');
INSERT INTO "public"."universitas" VALUES (101975, 233324, 'STT PELITA DUNIA BANTEN');
INSERT INTO "public"."universitas" VALUES (101976, 233325, 'STT IKAT DI BATAM');
INSERT INTO "public"."universitas" VALUES (101977, 233326, 'STT KADESI KALIMANTAN');
INSERT INTO "public"."universitas" VALUES (101978, 233327, 'STT TABUT ELOHIM LANGOWAN');
INSERT INTO "public"."universitas" VALUES (101979, 233328, 'STT RUMAH MURID KRISTUS BITUNG');
INSERT INTO "public"."universitas" VALUES (101980, 233329, 'STT INJIL ARASTAMAR NGABANG (KAL-BAR)');
INSERT INTO "public"."universitas" VALUES (101981, 233330, 'STT KRISBA BATAM');
INSERT INTO "public"."universitas" VALUES (99309, 74114, 'AKADEMI KEBIDANAN GLOBAL MEDIKA');
INSERT INTO "public"."universitas" VALUES (99310, 74115, 'AKADEMI KEBIDANAN DHARMA PRAJA BONDOWOSO');
INSERT INTO "public"."universitas" VALUES (99311, 74116, 'AKADEMI KEBIDANAN SUKAWATI LAWANG');
INSERT INTO "public"."universitas" VALUES (99312, 74117, 'AKADEMI FARMASI MITRA SEHAT MANDIRI SIDOARJO');
INSERT INTO "public"."universitas" VALUES (99313, 74118, 'AKADEMI KEBIDANAN SURYA SEHAT');
INSERT INTO "public"."universitas" VALUES (99314, 74119, 'AKADEMI KEBIDANAN DR SOEBANDI');
INSERT INTO "public"."universitas" VALUES (99315, 74120, 'AKADEMI KEBIDANAN BRAWIJAYA HUSADA');
INSERT INTO "public"."universitas" VALUES (99316, 74121, 'AKADEMI ANALIS KESEHATAN DELIMA HUSADA GRESIK');
INSERT INTO "public"."universitas" VALUES (99317, 74122, 'AKADEMI FARMASI JEMBER');
INSERT INTO "public"."universitas" VALUES (99318, 74123, 'AKADEMI KEBIDANAN GRAHA HUSADA SAMPANG');
INSERT INTO "public"."universitas" VALUES (99319, 74124, 'AKADEMI KESEHATAN RUSTIDA');
INSERT INTO "public"."universitas" VALUES (99320, 74125, 'AKADEMI KEPERAWATAN KOSGORO MOJOKERTO');
INSERT INTO "public"."universitas" VALUES (99321, 74126, 'AKADEMI KEBIDANAN PERMATA DELIMA');
INSERT INTO "public"."universitas" VALUES (99322, 74127, 'AKADEMI KEBIDANAN ANINDYA');
INSERT INTO "public"."universitas" VALUES (99323, 74128, 'AKADEMI GIZI KARYA HUSADA KEDIRI');
INSERT INTO "public"."universitas" VALUES (99324, 74129, 'AKADEMI FARMASI SURABAYA');
INSERT INTO "public"."universitas" VALUES (99325, 74130, 'AKADEMI KULINER DAN PATISERI OTTIMMO INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99326, 74131, 'AKADEMI FARMASI YANNAS HUSADA');
INSERT INTO "public"."universitas" VALUES (99327, 74132, 'AKADEMI KEBIDANAN PEMENANG');
INSERT INTO "public"."universitas" VALUES (99328, 74133, 'AKADEMI KESEHATAN SUMENEP');
INSERT INTO "public"."universitas" VALUES (99329, 74134, 'AKADEMI SAGES');
INSERT INTO "public"."universitas" VALUES (99330, 74135, 'UNIVERSITAS PGRI WIRANEGARA');
INSERT INTO "public"."universitas" VALUES (99331, 75001, 'POLITEKNIK CAHAYA SURYA');
INSERT INTO "public"."universitas" VALUES (99332, 75002, 'POLITEKNIK NSC SURABAYA');
INSERT INTO "public"."universitas" VALUES (99333, 75003, 'POLITEKNIK UBAYA');
INSERT INTO "public"."universitas" VALUES (99334, 75004, 'POLITEKNIK SURABAYA');
INSERT INTO "public"."universitas" VALUES (99335, 75005, 'POLITEKNIK UNISMA MALANG');
INSERT INTO "public"."universitas" VALUES (99336, 75006, 'POLITEKNIK KESEHATAN MAJAPAHIT');
INSERT INTO "public"."universitas" VALUES (99337, 75007, 'POLITEKNIK SAKTI SURABAYA');
INSERT INTO "public"."universitas" VALUES (99338, 75008, 'POLITEKNIK MADIUN');
INSERT INTO "public"."universitas" VALUES (99339, 75009, 'POLITEKNIK KESEHATAN RS DR SOEPRAOEN KESDAM V');
INSERT INTO "public"."universitas" VALUES (99340, 75010, 'POLITEKNIK KOTA MALANG');
INSERT INTO "public"."universitas" VALUES (99341, 75011, 'POLITEKNIK BANYUWANGI');
INSERT INTO "public"."universitas" VALUES (99342, 75012, 'POLITEKNIK KEDIRI');
INSERT INTO "public"."universitas" VALUES (99343, 75013, 'POLITEKNIK 17 AGUSTUS 1945 SURABAYA');
INSERT INTO "public"."universitas" VALUES (99344, 75014, 'POLITEKNIK PERTANIAN DAN PETERNAKAN MAPENA');
INSERT INTO "public"."universitas" VALUES (99345, 75015, 'POLITEKNIK MASAMY INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99346, 75016, 'POLITEKNIK MITRA GLOBAL');
INSERT INTO "public"."universitas" VALUES (99347, 76001, 'AKADEMI KOMUNITAS SEMEN INDONESIA');
INSERT INTO "public"."universitas" VALUES (99348, 76002, 'AKADEMI KOMUNITAS AL-ANWAR BANGKALAN MADURA');
INSERT INTO "public"."universitas" VALUES (99349, 76003, 'AKADEMI KOMUNITAS TEKNOLOGI SYARIFUDDIN');
INSERT INTO "public"."universitas" VALUES (99350, 76004, 'AKADEMI KOMUNITAS DARUN NAJAH');
INSERT INTO "public"."universitas" VALUES (99351, 76005, 'AKADEMI KOMUNITAS KEBUN ANOM');
INSERT INTO "public"."universitas" VALUES (99352, 76006, 'AKADEMI KOMUNITAS DARUSSALAM BLOKAGUNG');
INSERT INTO "public"."universitas" VALUES (99353, 76007, 'AKADEMI KOMUNITAS NURUL JADID');
INSERT INTO "public"."universitas" VALUES (99354, 76008, 'AKADEMI KOMUNITAS KOPI AL-HASAN');
INSERT INTO "public"."universitas" VALUES (99355, 76009, 'AKADEMI KOMUNITAS ASSUNNIYYAH');
INSERT INTO "public"."universitas" VALUES (99356, 76010, 'AKADEMI KOMUNITAS PENABULU SAMUDRA WIYATA');
INSERT INTO "public"."universitas" VALUES (99357, 81001, 'UNIVERSITAS MAHENDRADATTA');
INSERT INTO "public"."universitas" VALUES (99358, 81002, 'UNIVERSITAS NGURAH RAI');
INSERT INTO "public"."universitas" VALUES (99359, 81003, 'UNIVERSITAS MAHASARASWATI DENPASAR');
INSERT INTO "public"."universitas" VALUES (99360, 81004, 'UNIVERSITAS PENDIDIKAN NASIONAL');
INSERT INTO "public"."universitas" VALUES (99361, 81005, 'UNIVERSITAS DWIJENDRA');
INSERT INTO "public"."universitas" VALUES (99362, 81006, 'UNIVERSITAS TABANAN');
INSERT INTO "public"."universitas" VALUES (99363, 81007, 'UNIVERSITAS WARMADEWA');
INSERT INTO "public"."universitas" VALUES (99364, 81008, 'UNIVERSITAS PANJI SAKTI SINGARAJA');
INSERT INTO "public"."universitas" VALUES (99365, 81009, 'UNIVERSITAS HINDU INDONESIA');
INSERT INTO "public"."universitas" VALUES (99366, 81010, 'UNIVERSITAS MUHAMMADIYAH MATARAM');
INSERT INTO "public"."universitas" VALUES (99367, 81011, 'UNIVERSITAS MAHASARASWATI MATARAM');
INSERT INTO "public"."universitas" VALUES (99368, 81012, 'UNIVERSITAS ISLAM AL-AZHAR');
INSERT INTO "public"."universitas" VALUES (99369, 81013, 'UNIVERSITAS 45 MATARAM');
INSERT INTO "public"."universitas" VALUES (99370, 81014, 'UNIVERSITAS NAHDLATUL WATHAN MATARAM');
INSERT INTO "public"."universitas" VALUES (99371, 81015, 'UNIVERSITAS GUNUNG RINJANI');
INSERT INTO "public"."universitas" VALUES (99372, 81016, 'UNIVERSITAS SAMAWA');
INSERT INTO "public"."universitas" VALUES (99373, 81017, 'UNIVERSITAS NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (99374, 81018, 'UNIVERSITAS KATOLIK WIDYA MANDIRA KUPANG');
INSERT INTO "public"."universitas" VALUES (99375, 81019, 'UNIVERSITAS FLORES');
INSERT INTO "public"."universitas" VALUES (99376, 81020, 'UNIVERSITAS KRISTEN ARTHA WACANA');
INSERT INTO "public"."universitas" VALUES (99377, 81021, 'UNIVERSITAS MUHAMMADIYAH KUPANG');
INSERT INTO "public"."universitas" VALUES (99378, 81022, 'UNIVERSITAS PGRI NUSA TENGGARA TIMUR');
INSERT INTO "public"."universitas" VALUES (99379, 81023, 'UNIVERSITAS TIMOR');
INSERT INTO "public"."universitas" VALUES (99380, 81024, 'UNIVERSITAS NUSA LONTAR ROTE');
INSERT INTO "public"."universitas" VALUES (99381, 81025, 'UNIVERSITAS NUSA NIPA');
INSERT INTO "public"."universitas" VALUES (99382, 81026, 'UNIVERSITAS TEKNOLOGI INDONESIA');
INSERT INTO "public"."universitas" VALUES (99383, 81027, 'UNIVERSITAS TRIBUANA KALABAHI');
INSERT INTO "public"."universitas" VALUES (99384, 81028, 'UNIVERSITAS CORDOVA');
INSERT INTO "public"."universitas" VALUES (99385, 81029, 'UNIVERSITAS DHYANA PURA');
INSERT INTO "public"."universitas" VALUES (99386, 81030, 'UNIVERSITAS TEKNOLOGI SUMBAWA');
INSERT INTO "public"."universitas" VALUES (99387, 81031, 'UNIVERSITAS KARYADARMA KUPANG');
INSERT INTO "public"."universitas" VALUES (99388, 81032, 'UNIVERSITAS NAHDLATUL ULAMA NUSA TENGGARA BARAT');
INSERT INTO "public"."universitas" VALUES (99389, 81033, 'UNIVERSITAS SAN PEDRO');
INSERT INTO "public"."universitas" VALUES (99390, 81034, 'UNIVERSITAS KRISTEN WIRA WACANA SUMBA');
INSERT INTO "public"."universitas" VALUES (99391, 81035, 'UNIVERSITAS HAMZANWADI');
INSERT INTO "public"."universitas" VALUES (99392, 81036, 'UNIVERSITAS PERSATUAN GURU 1945 NTT');
INSERT INTO "public"."universitas" VALUES (99393, 81037, 'UNIVERSITAS ARYASATYA DEO MURI');
INSERT INTO "public"."universitas" VALUES (99394, 81038, 'UNIVERSITAS QAMARUL HUDA BADARUDDIN BAGU');
INSERT INTO "public"."universitas" VALUES (99395, 81039, 'UNIVERSITAS BALI DWIPA');
INSERT INTO "public"."universitas" VALUES (99396, 81040, 'UNIVERSITAS BUMIGORA');
INSERT INTO "public"."universitas" VALUES (99397, 81041, 'UNIVERSITAS CITRA BANGSA');
INSERT INTO "public"."universitas" VALUES (99398, 81042, 'UNIVERSITAS KATOLIK INDONESIA SANTU PAULUS RUTENG');
INSERT INTO "public"."universitas" VALUES (99399, 81043, 'UNIVERSITAS TRIATMA MULYA');
INSERT INTO "public"."universitas" VALUES (99400, 81044, 'UNIVERSITAS TEKNOLOGI MATARAM');
INSERT INTO "public"."universitas" VALUES (99401, 81045, 'UNIVERSITAS PENDIDIKAN MANDALIKA');
INSERT INTO "public"."universitas" VALUES (99402, 81046, 'UNIVERSITAS BALI INTERNASIONAL');
INSERT INTO "public"."universitas" VALUES (99403, 81047, 'UNIVERSITAS MAHADEWA INDONESIA');
INSERT INTO "public"."universitas" VALUES (99404, 82001, 'IKIP SARASWATI');
INSERT INTO "public"."universitas" VALUES (99405, 82002, 'IKIP PGRI BALI');
INSERT INTO "public"."universitas" VALUES (99406, 82003, 'IKIP MATARAM');
INSERT INTO "public"."universitas" VALUES (100732, 143038, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN PGRI PAPUA');
INSERT INTO "public"."universitas" VALUES (100733, 143039, 'SEKOLAH TINGGI BIO SAINS SWADIRI');
INSERT INTO "public"."universitas" VALUES (100734, 143040, 'SEKOLAH TINGGI MANAJEMEN DAN ILMU KOMPUTER UMEL MANDIRI');
INSERT INTO "public"."universitas" VALUES (100735, 143041, 'SEKOLAH TINGGI ILMU KESEHATAN PERSADA NABIRE');
INSERT INTO "public"."universitas" VALUES (100736, 143042, 'SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER PESAT NABIRE');
INSERT INTO "public"."universitas" VALUES (100737, 143043, 'SEKOLAH TINGGI ILMU KEGURUAN DAN ILMU PENDIDIKAN TERANG BANGSA');
INSERT INTO "public"."universitas" VALUES (100738, 144001, 'AKADEMI SEKRETARI DAN MANAJEMEN INDONESIA JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100739, 144002, 'AKADEMI PARIWISATA 45 JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100740, 144003, 'AKADEMI PARIWISATA PETRUS KAFIAR BIAK');
INSERT INTO "public"."universitas" VALUES (100741, 144004, 'AKADEMI AKUNTANSI TRINITAS SORONG');
INSERT INTO "public"."universitas" VALUES (100742, 144005, 'AKADEMI PERIKANAN KAMASAN BIAK');
INSERT INTO "public"."universitas" VALUES (100743, 144006, 'AKADEMI TEKNIK BIAK');
INSERT INTO "public"."universitas" VALUES (100744, 144007, 'AKADEMI KEPERAWATAN JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100745, 144008, 'AMIK UMEL MANDIRI');
INSERT INTO "public"."universitas" VALUES (100746, 144009, 'AKADEMI BAHASA ASING NETAIKEN WAMENA');
INSERT INTO "public"."universitas" VALUES (100747, 144010, 'AKADEMI MANAJEMEN INDONESIA JAYAPURA');
INSERT INTO "public"."universitas" VALUES (100748, 144011, 'AKADEMI KEPERAWATAN RS MARTHEN INDEY');
INSERT INTO "public"."universitas" VALUES (100749, 144012, 'AKADEMI KEBIDANAN YALEKA MARO MERAUKE');
INSERT INTO "public"."universitas" VALUES (100750, 145001, 'POLITEKNIK AMAMAPARE');
INSERT INTO "public"."universitas" VALUES (100751, 145002, 'POLITEKNIK SAINT PAUL SORONG');
INSERT INTO "public"."universitas" VALUES (100752, 145003, 'POLITEKNIK PERTANIAN YASANTO');
INSERT INTO "public"."universitas" VALUES (100753, 145004, 'POLITEKNIK PAPUA INTERNASIONAL SORONG');
INSERT INTO "public"."universitas" VALUES (100754, 146001, 'AKADEMI KOMUNITAS DIASPORA BUNG KARNO WAMENA');
INSERT INTO "public"."universitas" VALUES (100755, 201001, 'UNIVERSITAS ISLAM NEGERI SYARIF HIDAYATULLAH');
INSERT INTO "public"."universitas" VALUES (100756, 201002, 'UNIVERSITAS ISLAM NEGERI SUNAN KALIJAGA');
INSERT INTO "public"."universitas" VALUES (100757, 201003, 'UNIVERSITAS ISLAM NEGERI MAULANA MALIK IBRAHIM');
INSERT INTO "public"."universitas" VALUES (100758, 201004, 'UNIVERSITAS ISLAM NEGERI SUNAN GUNUNG DJATI');
INSERT INTO "public"."universitas" VALUES (100759, 201005, 'UNIVERSITAS ISLAM NEGERI SULTAN SYARIF KASIM RIAU');
INSERT INTO "public"."universitas" VALUES (100760, 201006, 'UNIVERSITAS ISLAM NEGERI ALAUDDIN MAKASSAR');
INSERT INTO "public"."universitas" VALUES (100761, 201007, 'UNIVERSITAS ISLAM NEGERI SUNAN AMPEL');
INSERT INTO "public"."universitas" VALUES (100762, 201008, 'UNIVERSITAS ISLAM NEGERI SUMATERA UTARA MEDAN');
INSERT INTO "public"."universitas" VALUES (100763, 201009, 'UNIVERSITAS ISLAM NEGERI RADEN FATAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (100764, 201010, 'UNIVERSITAS ISLAM NEGERI WALISONGO SEMARANG');
INSERT INTO "public"."universitas" VALUES (100765, 201011, 'UNIVERSITAS ISLAM NEGERI AR-RANIRY BANDA ACEH');
INSERT INTO "public"."universitas" VALUES (100766, 201012, 'UNIVERSITAS ISLAM NEGERI SULTAN MAULANA HASANUDDIN BANTEN');
INSERT INTO "public"."universitas" VALUES (100767, 201013, 'UNIVERSITAS ISLAM NEGERI IMAM BONJOL PADANG');
INSERT INTO "public"."universitas" VALUES (100768, 201014, 'UNIVERSITAS ISLAM NEGERI RADEN INTAN LAMPUNG');
INSERT INTO "public"."universitas" VALUES (100769, 201015, 'UNIVERSITAS ISLAM NEGERI MATARAM');
INSERT INTO "public"."universitas" VALUES (100770, 201016, 'UNIVERSITAS ISLAM NEGERI SULTHAN THAHA SAIFUDDIN JAMBI');
INSERT INTO "public"."universitas" VALUES (100771, 201017, 'UNIVERSITAS ISLAM NEGERI ANTASARI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100772, 202001, 'IAIN IMAM BONJOL PADANG');
INSERT INTO "public"."universitas" VALUES (100773, 202002, 'IAIN RADEN FATAH PALEMBANG');
INSERT INTO "public"."universitas" VALUES (100774, 202003, 'IAIN SULTAN MAULANA HASANUDDIN BANTEN');
INSERT INTO "public"."universitas" VALUES (100775, 202004, 'IAIN SULTAN THAHA SAIFUDDIN JAMBI');
INSERT INTO "public"."universitas" VALUES (100776, 202005, 'IAIN SUNAN AMPEL');
INSERT INTO "public"."universitas" VALUES (100777, 202006, 'IAIN SURAKARTA');
INSERT INTO "public"."universitas" VALUES (100778, 202007, 'IAIN SYEKH NURJATI CIREBON');
INSERT INTO "public"."universitas" VALUES (100779, 202008, 'IAIN WALISONGO SEMARANG');
INSERT INTO "public"."universitas" VALUES (100780, 202009, 'IAIN AMBON');
INSERT INTO "public"."universitas" VALUES (100781, 202010, 'IAIN SULTAN AMAI GORONTALO');
INSERT INTO "public"."universitas" VALUES (100782, 202011, 'IAIN ANTASARI BANJARMASIN');
INSERT INTO "public"."universitas" VALUES (100783, 202012, 'IAIN SUMATERA UTARA');
INSERT INTO "public"."universitas" VALUES (100784, 202013, 'IAIN RADEN INTAN LAMPUNG');
INSERT INTO "public"."universitas" VALUES (100785, 202014, 'IAIN MATARAM');
INSERT INTO "public"."universitas" VALUES (100786, 202015, 'IAIN AR-RANIRY');
INSERT INTO "public"."universitas" VALUES (100787, 202016, 'IAIN BENGKULU');
INSERT INTO "public"."universitas" VALUES (100788, 202017, 'IAIN TULUNGAGUNG');
INSERT INTO "public"."universitas" VALUES (100789, 202018, 'INSTITUT AGAMA ISLAM NEGERI PADANGSIDIMPUAN');
INSERT INTO "public"."universitas" VALUES (100790, 202019, 'INSTITUT AGAMA ISLAM NEGERI PALU');
INSERT INTO "public"."universitas" VALUES (100791, 202020, 'IAIN MANADO');
INSERT INTO "public"."universitas" VALUES (100792, 202021, 'IAIN PALOPO');
INSERT INTO "public"."universitas" VALUES (100793, 202022, 'IAIN KENDARI');
INSERT INTO "public"."universitas" VALUES (100794, 202023, 'IAIN SALATIGA');
INSERT INTO "public"."universitas" VALUES (100795, 202024, 'IAIN TERNATE');
INSERT INTO "public"."universitas" VALUES (100796, 202025, 'IAIN LANGSA');
INSERT INTO "public"."universitas" VALUES (100797, 202026, 'IAIN PALANGKARAYA');
INSERT INTO "public"."universitas" VALUES (100798, 202027, 'IAIN SAMARINDA');
INSERT INTO "public"."universitas" VALUES (100799, 202028, 'IAIN JEMBER');
INSERT INTO "public"."universitas" VALUES (100800, 202029, 'IAIN PURWOKERTO');
INSERT INTO "public"."universitas" VALUES (100801, 202030, 'IAIN PONTIANAK');
INSERT INTO "public"."universitas" VALUES (100802, 202031, 'IAIN BUKITTINGGI');
INSERT INTO "public"."universitas" VALUES (100803, 202032, 'INSTITUT AGAMA ISLAM NEGERI BATUSANGKAR');
INSERT INTO "public"."universitas" VALUES (100804, 202033, 'INSTITUT AGAMA ISLAM NEGERI METRO');
INSERT INTO "public"."universitas" VALUES (100805, 202034, 'INSTITUT AGAMA ISLAM NEGERI PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (100806, 202035, 'INSTITUT AGAMA ISLAM NEGERI PONOROGO');
INSERT INTO "public"."universitas" VALUES (100807, 202036, 'INSTITUT AGAMA ISLAM NEGERI KERINCI');
INSERT INTO "public"."universitas" VALUES (100808, 202037, 'INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE');
INSERT INTO "public"."universitas" VALUES (100809, 202038, 'INSTITUT AGAMA ISLAM NEGERI PAREPARE');
INSERT INTO "public"."universitas" VALUES (100810, 202039, 'INSTITUT AGAMA ISLAM NEGERI CURUP');
INSERT INTO "public"."universitas" VALUES (100811, 202040, 'INSTITUT AGAMA ISLAM NEGERI FATTAHUL MULUK PAPUA');
INSERT INTO "public"."universitas" VALUES (100812, 202041, 'INSTITUT AGAMA ISLAM NEGERI KUDUS');
INSERT INTO "public"."universitas" VALUES (100813, 202042, 'INSTITUT AGAMA ISLAM NEGERI MADURA');
INSERT INTO "public"."universitas" VALUES (100814, 202043, 'INSTITUT AGAMA ISLAM NEGERI SYAIKH ABDURRAHMAN SIDDIK BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (100815, 202044, 'INSTITUT AGAMA ISLAM NEGERI BONE');
INSERT INTO "public"."universitas" VALUES (100816, 202045, 'INSTITUT AGAMA ISLAM NEGERI KEDIRI');
INSERT INTO "public"."universitas" VALUES (100817, 203001, 'STAIN SURAKARTA');
INSERT INTO "public"."universitas" VALUES (100818, 203002, 'STAIN BATUSANGKAR');
INSERT INTO "public"."universitas" VALUES (100819, 203004, 'STAIN MANADO');
INSERT INTO "public"."universitas" VALUES (100820, 203005, 'STAIN PADANGSIDEMPUAN');
INSERT INTO "public"."universitas" VALUES (100821, 203006, 'STAIN PALOPO');
INSERT INTO "public"."universitas" VALUES (100822, 203007, 'STAIN PAMEKASAN');
INSERT INTO "public"."universitas" VALUES (100823, 203008, 'STAIN PAREPARE');
INSERT INTO "public"."universitas" VALUES (100824, 203009, 'STAIN PEKALONGAN');
INSERT INTO "public"."universitas" VALUES (100825, 203010, 'STAIN PONOROGO');
INSERT INTO "public"."universitas" VALUES (101982, 233331, 'SEKOLAH TINGGI TEOLOGI PERJANJIANNYA KABANJAHE');
INSERT INTO "public"."universitas" VALUES (101983, 233333, 'SEKOLAH TINGGI ALKITAB KALAM KRISTUS JAKARTA');
INSERT INTO "public"."universitas" VALUES (101984, 233334, 'SEKOLAH TINGGI TEOLOGI INJIL BHAKTI CARAKA BATAM');
INSERT INTO "public"."universitas" VALUES (101985, 233336, 'SEKOLAH TINGGI TEOLOGI YERUSALEM BARU MANADO');
INSERT INTO "public"."universitas" VALUES (101986, 233337, 'SEKOLAH TINGGI AGAMA KRISTEN LENTERA BANGSA MANADO');
INSERT INTO "public"."universitas" VALUES (101987, 233338, 'SEKOLAH TINGGI AGAMA KRISTEN ARASTAMAR GRIMENAWA JAYAPURA');
INSERT INTO "public"."universitas" VALUES (101988, 233339, 'SEKOLAH TINGGI AGAMA KRISTEN MALUKU UTARA');
INSERT INTO "public"."universitas" VALUES (101989, 233340, 'SEKOLAH TINGGI TEOLOGI INJILI MAHKOTA SION SAUMLAKI');
INSERT INTO "public"."universitas" VALUES (101990, 233341, 'SEKOLAH TINGGI TEOLOGI INJILI HUMBLE BENGKAYANG');
INSERT INTO "public"."universitas" VALUES (101991, 233342, 'SEKOLAH TINGGI AGAMA KRISTEN DIDASKALOS SANGIHE');
INSERT INTO "public"."universitas" VALUES (101992, 233343, 'SEKOLAH TINGGI TEOLOGI BINA INSANI INDONESIA KASIH ABADI PEMATANG SIANTAR');
INSERT INTO "public"."universitas" VALUES (101993, 233344, 'SEKOLAH TINGGI TEOLOGI BAPTIS KALVARI JAKARTA');
INSERT INTO "public"."universitas" VALUES (101994, 233345, 'SEKOLAH TINGGI TEOLOGI AMSAL');
INSERT INTO "public"."universitas" VALUES (101995, 233346, 'SEKOLAH TINGGI TEOLOGI PERIAGO PEKANBARU');
INSERT INTO "public"."universitas" VALUES (101996, 233347, 'SEKOLAH TINGGI TEOLOGI DELI SERDANG MEDAN');
INSERT INTO "public"."universitas" VALUES (101997, 233348, 'SEKOLAH TINGGI TEOLOGI PANTEKOSTA SUMUT - ACEH');
INSERT INTO "public"."universitas" VALUES (101998, 233349, 'SEKOLAH TINGGI AGAMA KRISTEN BINA MUDA WIRAWAN WONOGIRI');
INSERT INTO "public"."universitas" VALUES (101999, 233350, 'SEKOLAH TINGGI TEOLOGI SOLA GRATIA INDONESIA');
INSERT INTO "public"."universitas" VALUES (102000, 233351, 'SEKOLAH TINGGI TEOLOGI INJILI INDONESIA MADIUN');
INSERT INTO "public"."universitas" VALUES (102001, 233352, 'SEKOLAH TINGGI TEOLOGI IMANUEL PACET');
INSERT INTO "public"."universitas" VALUES (102002, 233353, 'SEKOLAH TINGGI TEOLOGI GALILEA INDONESIA');
INSERT INTO "public"."universitas" VALUES (102003, 233354, 'SEKOLAH TINGGI TEOLOGI RATSON BANGKA BELITUNG');
INSERT INTO "public"."universitas" VALUES (102004, 233355, 'SEKOLAH TINGGI TEOLOGI ANDATU');
INSERT INTO "public"."universitas" VALUES (102005, 233356, 'SEKOLAH TINGGI TEOLOGI MAWAR SARON LAMPUNG');
INSERT INTO "public"."universitas" VALUES (102006, 233357, 'SEKOLAH TINGGI TEOLOGI MITRA');
INSERT INTO "public"."universitas" VALUES (102007, 233358, 'SEKOLAH TINGGI AGAMA KRISTEN DIASPORA SORONG');
INSERT INTO "public"."universitas" VALUES (102008, 233359, 'SEKOLAH TINGGI AGAMA KRISTEN LUWUK BANGGAI');
INSERT INTO "public"."universitas" VALUES (102009, 233360, 'SEKOLAH TINGGI TEOLOGI GLOBAL JAKARTA');
INSERT INTO "public"."universitas" VALUES (102010, 233361, 'SEKOLAH TINGGI AGAMA KRISTEN NABIRE');
INSERT INTO "public"."universitas" VALUES (102011, 233362, 'SEKOLAH TINGGI AGAMA KRISTEN OIKUMENE TIMIKA');
INSERT INTO "public"."universitas" VALUES (102012, 233363, 'SEKOLAH TINGGI TEOLOGI THE TRUTH JAKARTA');
INSERT INTO "public"."universitas" VALUES (102013, 233364, 'SEKOLAH TINGGI TEOLOGI GEREJA PENTAKOSTA DI INDONESIA PEMATANG SIANTAR');
INSERT INTO "public"."universitas" VALUES (102014, 233365, 'ST AGAMA KRISTEN WILLIAM BOOTH JAKARTA');
INSERT INTO "public"."universitas" VALUES (102015, 233366, 'SEKOLAH TINGGI TEOLOGI ANUGERAH MISI NIAS BARAT');
INSERT INTO "public"."universitas" VALUES (102016, 233367, 'SEKOLAH TINGGI IFTA JAYAPURA');
INSERT INTO "public"."universitas" VALUES (102017, 233368, 'SEKOLAH TINGGI KEGURUAN DAN ILMU PENDIDIKAN SAMARITAN');
INSERT INTO "public"."universitas" VALUES (102018, 233369, 'SEKOLAH TINGGI TEOLOGI EXCELSIUS');
INSERT INTO "public"."universitas" VALUES (102019, 233370, 'SEKOLAH TINGGI TEOLOGI TABGHA BATAM');
INSERT INTO "public"."universitas" VALUES (102020, 233371, 'SEKOLAH TINGGI AGAMA KRISTEN ARASTAMAR ASMAT');
INSERT INTO "public"."universitas" VALUES (102021, 233372, 'SEKOLAH TINGGI TEOLOGI BETHEL NUSANTARA');
INSERT INTO "public"."universitas" VALUES (102022, 233373, 'SEKOLAH TINGGI TEOLOGI MAKEDONIA NGABANG');
INSERT INTO "public"."universitas" VALUES (102023, 233374, 'SEKOLAH TINGGI TEOLOGI SAINT PAUL BANDUNG');
INSERT INTO "public"."universitas" VALUES (102024, 233375, 'SEKOLAH TINGGI TEOLOGI GEREJA TUHAN DI INDONESIA MEDAN');
INSERT INTO "public"."universitas" VALUES (102025, 233376, 'SEKOLAH TINGGI TEOLOGI MISI INJILI INDONESIA SINTANG');
INSERT INTO "public"."universitas" VALUES (102026, 241001, 'UNIVERSITAS HINDU NEGERI I GUSTI BAGUS SUGRIWA DENPASAR');
INSERT INTO "public"."universitas" VALUES (102027, 242001, 'INSTITUT HINDU DHARMA NEGERI DENPASAR');
INSERT INTO "public"."universitas" VALUES (102028, 242002, 'INSTITUT AGAMA HINDU NEGERI TAMPUNG PENYANG PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (102029, 243001, 'SEKOLAH TINGGI AGAMA HINDU NEGERI GDE PUDJA MATARAM');
INSERT INTO "public"."universitas" VALUES (102030, 243002, 'SEKOLAH TINGGI AGAMA HINDU NEGERI TAMPUNG PENYANG PALANGKA RAYA');
INSERT INTO "public"."universitas" VALUES (102031, 243003, 'SEKOLAH TINGGI AGAMA HINDU DHARMA NUSANTARA JAKARTA');
INSERT INTO "public"."universitas" VALUES (102032, 243004, 'SEKOLAH TINGGI AGAMA HINDU DHARMA SENTANA SULAWESI TENGAH');
INSERT INTO "public"."universitas" VALUES (102033, 243005, 'SEKOLAH TINGGI AGAMA HINDU LAMPUNG');
INSERT INTO "public"."universitas" VALUES (102034, 243006, 'SEKOLAH TINGGI AGAMA HINDU SHANTIKA DHARMA MALANG');
INSERT INTO "public"."universitas" VALUES (102035, 243007, 'SEKOLAH TINGGI HINDU DHARMA KLATEN JAWA TENGAH');
INSERT INTO "public"."universitas" VALUES (102036, 243008, 'STAH NEGERI MPU KUTURAN SINGARAJA BALI');
INSERT INTO "public"."universitas" VALUES (102037, 243009, 'SEKOLAH TINGGI AGAMA HINDU BHATARA GURU KENDARI SULAWESI TENGGARA');
INSERT INTO "public"."universitas" VALUES (102038, 263001, 'SEKOLAH TINGGI AGAMA KATOLIK NEGERI PONTIANAK');
INSERT INTO "public"."universitas" VALUES (102039, 273001, 'SEKOLAH TINGGI PASTORAL-YAYASAN INSTITUT PASTORAL INDONESIA MALANG');
INSERT INTO "public"."universitas" VALUES (102040, 273002, 'STIPAR ENDE');
INSERT INTO "public"."universitas" VALUES (102041, 273003, 'STIPAS KEUSKUPAN AGUNG KUPANG');
INSERT INTO "public"."universitas" VALUES (102042, 273004, 'STIKPAR TORAJA');
INSERT INTO "public"."universitas" VALUES (102043, 273005, 'STIPAS ST.SIRILUS RUTENG');
INSERT INTO "public"."universitas" VALUES (102044, 273006, 'STK ST. YAKOBUS MERAUKE');
INSERT INTO "public"."universitas" VALUES (102045, 273007, 'STP ST. AGUSTINUS KEUSKUPAN AGUNG PONTIANAK');
INSERT INTO "public"."universitas" VALUES (102046, 273008, 'SEKOLAH TINGGI PASTORAL KATEKETIK SANTO YOHANES RASUL JAYAPURA');
INSERT INTO "public"."universitas" VALUES (102047, 273009, 'SEKOLAH TINGGI PASTORAL KATEKETIK (STPKAT) SANTO FRANSISKUS ASISI SEMARANG');
INSERT INTO "public"."universitas" VALUES (102048, 273010, 'SEKOLAH TINGGI PASTORAL KATEKETIK ST. BENEDIKTUS');
INSERT INTO "public"."universitas" VALUES (102049, 273011, 'STP DIAN MANDALA GUNUNG SITOLI NIAS KEUSKUPAN SIBOLGA');
INSERT INTO "public"."universitas" VALUES (102050, 273012, 'SEKOLAH TINGGI PASTORAL ST. PETRUS KEUSKUPAN ATAMBUA');
INSERT INTO "public"."universitas" VALUES (103789, 452018, 'UNIVERSITAS MANDALA WALUYA');
INSERT INTO "public"."universitas" VALUES (103749, 12120, 'Universitas Islam Internasional Indonesia');
INSERT INTO "public"."universitas" VALUES (103389, NULL, 'SEKOLAH TINGGI ILMU EKONOMI INDONESIA SURABAYA');
INSERT INTO "public"."universitas" VALUES (103390, NULL, 'UNIVERSITAS BINA BANGSA GETSEMPENA');
INSERT INTO "public"."universitas" VALUES (104010, 73188, 'Sekolah Tinggi Ilmu Kesehatan Rustida');
INSERT INTO "public"."universitas" VALUES (103969, 71105, 'UNIVERSITAS HAYAM WURUK PERBANAS');
INSERT INTO "public"."universitas" VALUES (103790, 552018, 'Universitas Metamedia');
INSERT INTO "public"."universitas" VALUES (104111, 73188, 'SEKOLAH TINGGI ILMU KESEHATAN RUSTIDA');
INSERT INTO "public"."universitas" VALUES (104112, 71113, 'UNIVERSITAS NAHDLATUL ULAMA PASURUAN');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."acara_idacara_seq"
OWNED BY "public"."acara"."idacara";
SELECT setval('"public"."acara_idacara_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."institusi_asal_idinstitusi_asal_seq"
OWNED BY "public"."institusi_asal"."idinstitusi_asal";
SELECT setval('"public"."institusi_asal_idinstitusi_asal_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."jabatan_idjabatan_seq"
OWNED BY "public"."jabatan"."idjabatan";
SELECT setval('"public"."jabatan_idjabatan_seq"', 11, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."jenis_institusi_idjenis_institusi_seq"
OWNED BY "public"."jenis_institusi"."idjenis_institusi";
SELECT setval('"public"."jenis_institusi_idjenis_institusi_seq"', 6, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."jenis_transport_idjenis_transport_seq"
OWNED BY "public"."jenis_transport"."idjenis_transport";
SELECT setval('"public"."jenis_transport_idjenis_transport_seq"', 6, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."kelompok_jabatan_idkelompok_jabatan_seq"
OWNED BY "public"."kelompok_jabatan"."idkelompok_jabatan";
SELECT setval('"public"."kelompok_jabatan_idkelompok_jabatan_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."lldikti_idlldikti_seq"
OWNED BY "public"."lldikti"."idlldikti";
SELECT setval('"public"."lldikti_idlldikti_seq"', 17, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."log_institusi_idlog_institusi_seq"
OWNED BY "public"."log_institusi"."idlog_institusi";
SELECT setval('"public"."log_institusi_idlog_institusi_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."narasumber_idnarasumber_seq"
OWNED BY "public"."narasumber"."idnarasumber";
SELECT setval('"public"."narasumber_idnarasumber_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pameran_idpameran_seq"
OWNED BY "public"."pameran"."idpameran";
SELECT setval('"public"."pameran_idpameran_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pembayaran_idpembayaran_seq"
OWNED BY "public"."pembayaran"."idpembayaran";
SELECT setval('"public"."pembayaran_idpembayaran_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."pengguna_idpengguna_seq"
OWNED BY "public"."pengguna"."idpengguna";
SELECT setval('"public"."pengguna_idpengguna_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."peserta_acara_idpeserta_acara_seq"
OWNED BY "public"."peserta_acara"."idpeserta_acara";
SELECT setval('"public"."peserta_acara_idpeserta_acara_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."peserta_idpeserta_seq"
OWNED BY "public"."peserta"."idpeserta";
SELECT setval('"public"."peserta_idpeserta_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."petugas_jaga_idpetugas_jaga_seq"
OWNED BY "public"."petugas_jaga"."idpetugas_jaga";
SELECT setval('"public"."petugas_jaga_idpetugas_jaga_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."review_narasumber_idreview_narasumber_seq"
OWNED BY "public"."review_narasumber"."idreview_narasumber";
SELECT setval('"public"."review_narasumber_idreview_narasumber_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."review_pameran_idreview_seq"
OWNED BY "public"."review_pameran"."idreview";
SELECT setval('"public"."review_pameran_idreview_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."role_idrole_seq"
OWNED BY "public"."role"."idrole";
SELECT setval('"public"."role_idrole_seq"', 4, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."tagihan_idtagihan_seq"
OWNED BY "public"."tagihan"."idtagihan";
SELECT setval('"public"."tagihan_idtagihan_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."universitas_iduniversitas_seq"
OWNED BY "public"."universitas"."iduniversitas";
SELECT setval('"public"."universitas_iduniversitas_seq"', 1, false);

-- ----------------------------
-- Primary Key structure for table acara
-- ----------------------------
ALTER TABLE "public"."acara" ADD CONSTRAINT "acara_pkey" PRIMARY KEY ("idacara");

-- ----------------------------
-- Primary Key structure for table institusi_asal
-- ----------------------------
ALTER TABLE "public"."institusi_asal" ADD CONSTRAINT "institusi_asal_pkey" PRIMARY KEY ("idinstitusi_asal");

-- ----------------------------
-- Primary Key structure for table jabatan
-- ----------------------------
ALTER TABLE "public"."jabatan" ADD CONSTRAINT "jabatan_pkey" PRIMARY KEY ("idjabatan");

-- ----------------------------
-- Primary Key structure for table jenis_institusi
-- ----------------------------
ALTER TABLE "public"."jenis_institusi" ADD CONSTRAINT "jenis_institusi_pkey" PRIMARY KEY ("idjenis_institusi");

-- ----------------------------
-- Primary Key structure for table jenis_transport
-- ----------------------------
ALTER TABLE "public"."jenis_transport" ADD CONSTRAINT "jenis_transport_pkey" PRIMARY KEY ("idjenis_transport");

-- ----------------------------
-- Primary Key structure for table kelompok_jabatan
-- ----------------------------
ALTER TABLE "public"."kelompok_jabatan" ADD CONSTRAINT "kelompok_jabatan_pkey" PRIMARY KEY ("idkelompok_jabatan");

-- ----------------------------
-- Primary Key structure for table lldikti
-- ----------------------------
ALTER TABLE "public"."lldikti" ADD CONSTRAINT "lldikti_pkey" PRIMARY KEY ("idlldikti");

-- ----------------------------
-- Primary Key structure for table log_institusi
-- ----------------------------
ALTER TABLE "public"."log_institusi" ADD CONSTRAINT "log_institusi_pkey" PRIMARY KEY ("idlog_institusi");

-- ----------------------------
-- Primary Key structure for table narasumber
-- ----------------------------
ALTER TABLE "public"."narasumber" ADD CONSTRAINT "narasumber_pkey" PRIMARY KEY ("idnarasumber");

-- ----------------------------
-- Primary Key structure for table pameran
-- ----------------------------
ALTER TABLE "public"."pameran" ADD CONSTRAINT "pameran_pkey" PRIMARY KEY ("idpameran");

-- ----------------------------
-- Primary Key structure for table pembayaran
-- ----------------------------
ALTER TABLE "public"."pembayaran" ADD CONSTRAINT "pembayaran_pkey" PRIMARY KEY ("idpembayaran");

-- ----------------------------
-- Primary Key structure for table pengguna
-- ----------------------------
ALTER TABLE "public"."pengguna" ADD CONSTRAINT "pengguna_pkey" PRIMARY KEY ("idpengguna");

-- ----------------------------
-- Primary Key structure for table peserta
-- ----------------------------
ALTER TABLE "public"."peserta" ADD CONSTRAINT "peserta_pkey" PRIMARY KEY ("idpeserta");

-- ----------------------------
-- Primary Key structure for table peserta_acara
-- ----------------------------
ALTER TABLE "public"."peserta_acara" ADD CONSTRAINT "peserta_acara_pkey" PRIMARY KEY ("idpeserta_acara");

-- ----------------------------
-- Primary Key structure for table petugas_jaga
-- ----------------------------
ALTER TABLE "public"."petugas_jaga" ADD CONSTRAINT "petugas_jaga_pkey" PRIMARY KEY ("idpetugas_jaga");

-- ----------------------------
-- Primary Key structure for table review_narasumber
-- ----------------------------
ALTER TABLE "public"."review_narasumber" ADD CONSTRAINT "review_narasumber_pkey" PRIMARY KEY ("idreview_narasumber");

-- ----------------------------
-- Primary Key structure for table review_pameran
-- ----------------------------
ALTER TABLE "public"."review_pameran" ADD CONSTRAINT "review_pameran_pkey" PRIMARY KEY ("idreview");

-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE "public"."role" ADD CONSTRAINT "role_pkey" PRIMARY KEY ("idrole");

-- ----------------------------
-- Primary Key structure for table tagihan
-- ----------------------------
ALTER TABLE "public"."tagihan" ADD CONSTRAINT "tagihan_pkey" PRIMARY KEY ("idtagihan");

-- ----------------------------
-- Primary Key structure for table universitas
-- ----------------------------
ALTER TABLE "public"."universitas" ADD CONSTRAINT "universitas_pkey" PRIMARY KEY ("iduniversitas");

-- ----------------------------
-- Foreign Keys structure for table acara
-- ----------------------------
ALTER TABLE "public"."acara" ADD CONSTRAINT "fk_acara_acara_1" FOREIGN KEY ("idparent_acara") REFERENCES "public"."acara" ("idacara") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table institusi_asal
-- ----------------------------
ALTER TABLE "public"."institusi_asal" ADD CONSTRAINT "fk_institusi_asal_jenis_institusi_1" FOREIGN KEY ("idjenis_institusi") REFERENCES "public"."jenis_institusi" ("idjenis_institusi") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."institusi_asal" ADD CONSTRAINT "fk_institusi_asal_lldikti_1" FOREIGN KEY ("idlldikti") REFERENCES "public"."lldikti" ("idlldikti") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table jabatan
-- ----------------------------
ALTER TABLE "public"."jabatan" ADD CONSTRAINT "fk_jabatan_kelompok_jabatan_1" FOREIGN KEY ("idkelompok_jabatan") REFERENCES "public"."kelompok_jabatan" ("idkelompok_jabatan") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table jenis_institusi_jabatan
-- ----------------------------
ALTER TABLE "public"."jenis_institusi_jabatan" ADD CONSTRAINT "fk_jenis_institusi_jabatan_jenis_institusi_1" FOREIGN KEY ("idjenis_institusi") REFERENCES "public"."jenis_institusi" ("idjenis_institusi") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."jenis_institusi_jabatan" ADD CONSTRAINT "fk_jenis_institusi_jabatan_kelompok_jabatan_1" FOREIGN KEY ("idkelompok_jabatan") REFERENCES "public"."kelompok_jabatan" ("idkelompok_jabatan") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table log_institusi
-- ----------------------------
ALTER TABLE "public"."log_institusi" ADD CONSTRAINT "fk_log_institusi_institusi_asal_1" FOREIGN KEY ("idinstitusi_asal") REFERENCES "public"."institusi_asal" ("idinstitusi_asal") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."log_institusi" ADD CONSTRAINT "fk_log_institusi_peserta_1" FOREIGN KEY ("done_by") REFERENCES "public"."peserta" ("idpeserta") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table narasumber
-- ----------------------------
ALTER TABLE "public"."narasumber" ADD CONSTRAINT "fk_narasumber_acara_1" FOREIGN KEY ("idacara") REFERENCES "public"."acara" ("idacara") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."narasumber" ADD CONSTRAINT "fk_narasumber_pengguna_1" FOREIGN KEY ("idpengguna") REFERENCES "public"."pengguna" ("idpengguna") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."narasumber" ADD CONSTRAINT "fk_narasumber_universitas_1" FOREIGN KEY ("iduniversitas") REFERENCES "public"."universitas" ("iduniversitas") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table pameran
-- ----------------------------
ALTER TABLE "public"."pameran" ADD CONSTRAINT "fk_pameran_institusi_asal_1" FOREIGN KEY ("idinstitusi_asal") REFERENCES "public"."institusi_asal" ("idinstitusi_asal") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table pembayaran
-- ----------------------------
ALTER TABLE "public"."pembayaran" ADD CONSTRAINT "fk_pembayaran_tagihan_1" FOREIGN KEY ("idtagihan") REFERENCES "public"."tagihan" ("idtagihan") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table pengguna
-- ----------------------------
ALTER TABLE "public"."pengguna" ADD CONSTRAINT "fk_pengguna_institusi_asal_1" FOREIGN KEY ("idinstitusi_asal") REFERENCES "public"."institusi_asal" ("idinstitusi_asal") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."pengguna" ADD CONSTRAINT "fk_pengguna_role_1" FOREIGN KEY ("idrole") REFERENCES "public"."role" ("idrole") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table peserta
-- ----------------------------
ALTER TABLE "public"."peserta" ADD CONSTRAINT "fk_peserta_institusi_asal_1" FOREIGN KEY ("idinstitusi_asal") REFERENCES "public"."institusi_asal" ("idinstitusi_asal") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."peserta" ADD CONSTRAINT "fk_peserta_jabatan_1" FOREIGN KEY ("idjabatan") REFERENCES "public"."jabatan" ("idjabatan") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."peserta" ADD CONSTRAINT "fk_peserta_jenis_transport_1" FOREIGN KEY ("idjenis_transportasi_kedatangan") REFERENCES "public"."jenis_transport" ("idjenis_transport") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."peserta" ADD CONSTRAINT "fk_peserta_jenis_transport_2" FOREIGN KEY ("idjenis_transportasi_kepulangan") REFERENCES "public"."jenis_transport" ("idjenis_transport") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."peserta" ADD CONSTRAINT "fk_peserta_pengguna_1" FOREIGN KEY ("idpengguna") REFERENCES "public"."pengguna" ("idpengguna") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table peserta_acara
-- ----------------------------
ALTER TABLE "public"."peserta_acara" ADD CONSTRAINT "fk_peserta_acara_acara_1" FOREIGN KEY ("idacara") REFERENCES "public"."acara" ("idacara") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."peserta_acara" ADD CONSTRAINT "fk_peserta_acara_peserta_1" FOREIGN KEY ("idpeserta") REFERENCES "public"."peserta" ("idpeserta") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table petugas_jaga
-- ----------------------------
ALTER TABLE "public"."petugas_jaga" ADD CONSTRAINT "fk_petugas_jaga_pameran_1" FOREIGN KEY ("idpameran") REFERENCES "public"."pameran" ("idpameran") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."petugas_jaga" ADD CONSTRAINT "fk_petugas_jaga_peserta_1" FOREIGN KEY ("idpeserta") REFERENCES "public"."peserta" ("idpeserta") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table review_narasumber
-- ----------------------------
ALTER TABLE "public"."review_narasumber" ADD CONSTRAINT "fk_review_narasumber_narasumber_1" FOREIGN KEY ("idnarasumber") REFERENCES "public"."narasumber" ("idnarasumber") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."review_narasumber" ADD CONSTRAINT "fk_review_narasumber_pengguna_1" FOREIGN KEY ("created_by") REFERENCES "public"."pengguna" ("idpengguna") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table review_pameran
-- ----------------------------
ALTER TABLE "public"."review_pameran" ADD CONSTRAINT "fk_review_pameran_pameran_1" FOREIGN KEY ("idpameran") REFERENCES "public"."pameran" ("idpameran") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."review_pameran" ADD CONSTRAINT "fk_review_pameran_pengguna_1" FOREIGN KEY ("created_by") REFERENCES "public"."pengguna" ("idpengguna") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table tagihan
-- ----------------------------
ALTER TABLE "public"."tagihan" ADD CONSTRAINT "fk_tagihan_pameran_1" FOREIGN KEY ("idpameran") REFERENCES "public"."pameran" ("idpameran") ON DELETE NO ACTION ON UPDATE NO ACTION;
