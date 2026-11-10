<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MouController extends Controller
{
    /**
     * `pengajuan_mou.status_ajuan` yang tidak menghalangi pasangan institusi
     * yang sama mengajukan MoU baru (lihat docs/features/020-pengajuan-mou.md §4.4).
     */
    private const STATUS_AJUAN_DIBATALKAN = 5;

    /**
     * `jadwal_penting.idjadwal_penting` untuk sesi pengajuan MoU.
     */
    private const IDJADWAL_PENGAJUAN_MOU = 6;

    /**
     * Submenu "Jadwal Temu" — matrix sesi × ruang untuk satu tanggal
     * Temu Diskusi, hanya menampilkan pertemuan milik institusi sendiri
     * (sebagai Pengaju maupun Mitra), bukan jadwal publik semua institusi
     * (dikonfirmasi developer).
     */
    public function jadwalTemu(Request $request)
    {
        $menu = 'mou';
        $submenu = 'jadwal-temu';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $tanggalAktifList = DB::table('tanggal_mou')->where('status', true)->orderBy('tanggal')->get();
        $idTanggalTerpilih = (int) ($request->query('idtanggal_mou') ?: $tanggalAktifList->first()?->idtanggal_mou);

        $sesiList = DB::table('sesi_mou')->orderBy('jam_mulai')->get();
        $ruangList = DB::table('ruang_mou')->orderBy('nama_ruang')->get();

        $pertemuanList = $idTanggalTerpilih
            ? DB::table('pertemuan_mou as pt')
                ->join('pengajuan_mou as pm', 'pm.idpengajuan_mou', '=', 'pt.idpengajuan_mou')
                ->join('institusi_asal as ia_pengaju', 'ia_pengaju.idinstitusi_asal', '=', 'pm.idinstitusi_pengaju')
                ->join('institusi_asal as ia_mitra', 'ia_mitra.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
                ->leftJoin('pengguna as pic_pengaju', 'pic_pengaju.idpengguna', '=', 'pm.idpic_institusi_pengaju')
                ->leftJoin('pengguna as pic_mitra', 'pic_mitra.idpengguna', '=', 'pm.idpic_institusi_mitra')
                ->where('pt.idtanggal_mou', $idTanggalTerpilih)
                ->where(function ($query) use ($idInstitusiAsal) {
                    $query->where('pm.idinstitusi_pengaju', $idInstitusiAsal)->orWhere('pm.idinstitusi_mitra', $idInstitusiAsal);
                })
                ->select(
                    'pt.idsesi_mou', 'pt.idruang_mou',
                    'ia_pengaju.nama_institusi as nama_institusi_pengaju', 'pic_pengaju.nama as nama_pic_pengaju',
                    'ia_mitra.nama_institusi as nama_institusi_mitra', 'pic_mitra.nama as nama_pic_mitra'
                )
                ->get()
                ->keyBy(fn ($p) => $p->idsesi_mou.'-'.$p->idruang_mou)
            : collect();

        return view('peserta.mou-jadwal-temu', compact(
            'menu', 'submenu', 'tanggalAktifList', 'idTanggalTerpilih', 'sesiList', 'ruangList', 'pertemuanList'
        ));
    }

    public function listPeserta()
    {
        $menu = 'mou';
        $submenu = 'list-peserta';

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        $institusiList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->whereIn('i.idinstitusi_asal', $this->pesertaAktifQuery()->select('p.idinstitusi_asal')->distinct())
            ->select('i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) {
                $institusi->token = $this->encryptRouteValue($institusi->idinstitusi_asal);

                return $institusi;
            });

        return view('peserta.mou-list-peserta', compact('menu', 'submenu', 'jenisInstitusiList', 'institusiList'));
    }

    /**
     * Daftar pengajuan MoU yang melibatkan institusi peserta yang login —
     * baik sebagai Pengaju maupun Mitra (lihat docs/features/020-pengajuan-mou.md §3).
     */
    public function daftarPengajuan()
    {
        $menu = 'mou';
        $submenu = 'pengajuan';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $sebagaiPengaju = DB::table('pengajuan_mou as pm')
            ->join('pengguna as pic_sendiri', 'pic_sendiri.idpengguna', '=', 'pm.idpic_institusi_pengaju')
            ->leftJoin('pengguna as pic_lawan', 'pic_lawan.idpengguna', '=', 'pm.idpic_institusi_mitra')
            ->join('institusi_asal as ia_lawan', 'ia_lawan.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
            ->join('jenis_institusi as ji_lawan', 'ji_lawan.idjenis_institusi', '=', 'ia_lawan.idjenis_institusi')
            ->where('pm.idinstitusi_pengaju', $idInstitusiAsal)
            ->selectRaw("pm.idpengajuan_mou, pm.status_ajuan, 'Pengaju' as posisi, pic_sendiri.nama as nama_pic_sendiri, pic_sendiri.no_wa as no_wa_pic_sendiri, ia_lawan.nama_institusi as nama_institusi_lawan, pic_lawan.nama as nama_pic_lawan, pic_lawan.no_wa as no_wa_pic_lawan, ji_lawan.nama_jenis_institusi as nama_jenis_institusi");

        $sebagaiMitra = DB::table('pengajuan_mou as pm')
            ->leftJoin('pengguna as pic_sendiri', 'pic_sendiri.idpengguna', '=', 'pm.idpic_institusi_mitra')
            ->leftJoin('pengguna as pic_lawan', 'pic_lawan.idpengguna', '=', 'pm.idpic_institusi_pengaju')
            ->join('institusi_asal as ia_lawan', 'ia_lawan.idinstitusi_asal', '=', 'pm.idinstitusi_pengaju')
            ->join('jenis_institusi as ji_lawan', 'ji_lawan.idjenis_institusi', '=', 'ia_lawan.idjenis_institusi')
            ->where('pm.idinstitusi_mitra', $idInstitusiAsal)
            ->selectRaw("pm.idpengajuan_mou, pm.status_ajuan, 'Penerima' as posisi, pic_sendiri.nama as nama_pic_sendiri, pic_sendiri.no_wa as no_wa_pic_sendiri, ia_lawan.nama_institusi as nama_institusi_lawan, pic_lawan.nama as nama_pic_lawan, pic_lawan.no_wa as no_wa_pic_lawan, ji_lawan.nama_jenis_institusi as nama_jenis_institusi");

        $gabungan = $sebagaiPengaju->unionAll($sebagaiMitra);

        $pertemuanTerakhir = DB::table('pertemuan_mou')
            ->selectRaw('idpengajuan_mou, MAX(idpertemuan_mou) as idpertemuan_mou_terakhir')
            ->groupBy('idpengajuan_mou');

        $pengajuanList = DB::query()->fromSub($gabungan, 'g')
            ->leftJoinSub($pertemuanTerakhir, 'pt', 'pt.idpengajuan_mou', '=', 'g.idpengajuan_mou')
            ->leftJoin('pertemuan_mou as pert', 'pert.idpertemuan_mou', '=', 'pt.idpertemuan_mou_terakhir')
            ->leftJoin('tanggal_mou as tgl', 'tgl.idtanggal_mou', '=', 'pert.idtanggal_mou')
            ->leftJoin('sesi_mou as sesi', 'sesi.idsesi_mou', '=', 'pert.idsesi_mou')
            ->leftJoin('ruang_mou as ruang', 'ruang.idruang_mou', '=', 'pert.idruang_mou')
            ->select('g.*', 'tgl.tanggal', 'sesi.jam_mulai', 'sesi.jam_akhir', 'ruang.nama_ruang')
            ->orderBy('g.idpengajuan_mou', 'desc')
            ->get()
            ->map(function ($baris) {
                $baris->waktu_lokasi = $baris->tanggal
                    ? Carbon::parse($baris->tanggal)->translatedFormat('d M Y').' ('.substr($baris->jam_mulai, 0, 5).'-'.substr($baris->jam_akhir, 0, 5).') — '.$baris->nama_ruang
                    : '-';
                $baris->token = $this->encryptRouteValue($baris->idpengajuan_mou);

                return $baris;
            });

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();
        $picMouOptions = $pengajuanList->pluck('nama_pic_sendiri')->unique()->sort()->values();
        $jumlahBelumRespon = $pengajuanList->where('posisi', 'Penerima')->where('status_ajuan', 1)->count();

        return view('peserta.mou-pengajuan', compact('menu', 'submenu', 'pengajuanList', 'jenisInstitusiList', 'picMouOptions', 'jumlahBelumRespon'));
    }

    /**
     * Halaman detail satu pengajuan MoU, view only — bisa diakses institusi
     * Pengaju maupun Mitra dari pengajuan itu.
     */
    public function detailPengajuan(Request $request)
    {
        $menu = 'mou';
        $submenu = 'pengajuan';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $idpengajuanMou = $this->decryptRouteValue($request->query('token'));

        if ($idpengajuanMou === null) {
            abort(404);
        }

        $pengajuan = DB::table('pengajuan_mou as pm')
            ->join('institusi_asal as ia_pengaju', 'ia_pengaju.idinstitusi_asal', '=', 'pm.idinstitusi_pengaju')
            ->join('institusi_asal as ia_mitra', 'ia_mitra.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
            ->join('jenis_institusi as ji_pengaju', 'ji_pengaju.idjenis_institusi', '=', 'ia_pengaju.idjenis_institusi')
            ->join('jenis_institusi as ji_mitra', 'ji_mitra.idjenis_institusi', '=', 'ia_mitra.idjenis_institusi')
            ->leftJoin('pengguna as pic_pengaju', 'pic_pengaju.idpengguna', '=', 'pm.idpic_institusi_pengaju')
            ->leftJoin('pengguna as pic_mitra', 'pic_mitra.idpengguna', '=', 'pm.idpic_institusi_mitra')
            ->where('pm.idpengajuan_mou', (int) $idpengajuanMou)
            ->where(function ($query) use ($idInstitusiAsal) {
                $query->where('pm.idinstitusi_pengaju', $idInstitusiAsal)
                    ->orWhere('pm.idinstitusi_mitra', $idInstitusiAsal);
            })
            ->select(
                'pm.idpengajuan_mou', 'pm.status_ajuan', 'pm.idinstitusi_pengaju', 'pm.idinstitusi_mitra',
                'ia_pengaju.nama_institusi as nama_institusi_pengaju', 'ji_pengaju.nama_jenis_institusi as nama_jenis_institusi_pengaju',
                'ia_mitra.nama_institusi as nama_institusi_mitra', 'ji_mitra.nama_jenis_institusi as nama_jenis_institusi_mitra',
                'pic_pengaju.nama as nama_pic_pengaju', 'pic_pengaju.no_wa as no_wa_pic_pengaju',
                'pic_mitra.nama as nama_pic_mitra', 'pic_mitra.no_wa as no_wa_pic_mitra'
            )
            ->first();

        if (! $pengajuan) {
            abort(404);
        }

        $pengajuan->posisi = (int) $pengajuan->idinstitusi_pengaju === (int) $idInstitusiAsal ? 'Pengaju' : 'Penerima';

        $lampiranList = DB::table('lampiran_mou')
            ->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)
            ->orderBy('idlampiran_mou')
            ->get()
            ->map(function ($lampiran) {
                $lampiran->catatan = $lampiran->jenis_lampiran === 2 ? $this->sanitizeRichText($lampiran->catatan) : $lampiran->catatan;
                $lampiran->token = $this->encryptRouteValue($lampiran->idlampiran_mou);

                return $lampiran;
            });

        $riwayatStatus = DB::table('log_status_mou as l')
            ->leftJoin('pengguna as p', 'p.idpengguna', '=', 'l.done_by')
            ->where('l.idpengajuan_mou', $pengajuan->idpengajuan_mou)
            ->select('l.status', 'l.done_at', 'p.nama as nama_done_by')
            ->orderBy('l.done_at')
            ->get();

        $pertemuan = DB::table('pertemuan_mou as pert')
            ->leftJoin('tanggal_mou as tgl', 'tgl.idtanggal_mou', '=', 'pert.idtanggal_mou')
            ->leftJoin('sesi_mou as sesi', 'sesi.idsesi_mou', '=', 'pert.idsesi_mou')
            ->leftJoin('ruang_mou as ruang', 'ruang.idruang_mou', '=', 'pert.idruang_mou')
            ->where('pert.idpengajuan_mou', $pengajuan->idpengajuan_mou)
            ->select('tgl.tanggal', 'sesi.jam_mulai', 'sesi.jam_akhir', 'ruang.nama_ruang')
            ->orderByDesc('pert.idpertemuan_mou')
            ->first();

        // Dibutuhkan tombol "Respon Ajuan" (F21) — hanya institusi Mitra pada
        // pengajuan yang masih berstatus 1 (Ajuan) yang boleh merespon.
        $bisaRespon = $pengajuan->posisi === 'Penerima' && (int) $pengajuan->status_ajuan === 1;
        $bisaBatalkan = $pengajuan->posisi === 'Pengaju' && (int) $pengajuan->status_ajuan === 1;
        // Pengaju masih boleh mengganti PIC Pengaju selama Mitra belum
        // merespon sama sekali (status masih 1/Ajuan) — dikonfirmasi
        // developer, sama syaratnya dengan $bisaBatalkan.
        $bisaUbahPicPengaju = $bisaBatalkan;
        $pesertaOptionsMitra = $bisaRespon
            ? $this->pesertaAktifQuery($idInstitusiAsal)->select('p.idpengguna', 'p.nama')->orderBy('p.nama')->get()
            : collect();
        $pesertaOptionsPengaju = $bisaUbahPicPengaju
            ? $this->pesertaAktifQuery($idInstitusiAsal)->select('p.idpengguna', 'p.nama')->orderBy('p.nama')->get()
            : collect();
        $tanggalAktifList = $bisaRespon
            ? DB::table('tanggal_mou')->where('status', true)->orderBy('tanggal')->get()
            : collect();

        $token = $request->query('token');

        return view('peserta.mou-pengajuan-detail', compact(
            'menu', 'submenu', 'pengajuan', 'lampiranList', 'riwayatStatus', 'pertemuan',
            'bisaRespon', 'bisaBatalkan', 'bisaUbahPicPengaju', 'pesertaOptionsMitra',
            'pesertaOptionsPengaju', 'tanggalAktifList', 'token'
        ));
    }

    /**
     * Unduh satu file lampiran MoU — hanya institusi Pengaju/Mitra dari
     * pengajuan terkait yang boleh mengakses.
     */
    public function unduhLampiran(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $idlampiranMou = $this->decryptRouteValue($request->query('token'));

        if ($idlampiranMou === null) {
            abort(404);
        }

        $lampiran = DB::table('lampiran_mou as lm')
            ->join('pengajuan_mou as pm', 'pm.idpengajuan_mou', '=', 'lm.idpengajuan_mou')
            ->where('lm.idlampiran_mou', (int) $idlampiranMou)
            ->where(function ($query) use ($idInstitusiAsal) {
                $query->where('pm.idinstitusi_pengaju', $idInstitusiAsal)
                    ->orWhere('pm.idinstitusi_mitra', $idInstitusiAsal);
            })
            ->select('lm.file_path')
            ->first();

        if (! $lampiran || ! $lampiran->file_path || ! Storage::disk('local')->exists($lampiran->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($lampiran->file_path);
    }

    /**
     * Tab 1 "Response" — institusi Mitra menunda pengajuan (lihat
     * docs/features/021-respon-ajuan-mou.md §3).
     */
    public function tundaAjuan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = DB::table('pengajuan_mou')
            ->where('idpengajuan_mou', (int) $idpengajuanMou)
            ->where('idinstitusi_mitra', $idInstitusiAsal)
            ->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        if ((int) $pengajuan->status_ajuan !== 1) {
            return $this->jsonResponse(422, 'Pengajuan ini sudah direspon sebelumnya.');
        }

        DB::transaction(function () use ($pengajuan, $userdata) {
            DB::table('pengajuan_mou')->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)->update([
                'status_ajuan' => 3,
            ]);

            DB::table('log_status_mou')->insert([
                'done_at' => now(),
                'done_by' => $userdata['idpengguna'],
                'status' => 3,
                'idpengajuan_mou' => $pengajuan->idpengajuan_mou,
            ]);
        });

        $this->logInstitusi($userdata['idinstitusi_asal'], $userdata['idpengguna'], 'Menunda pengajuan MoU ke lain waktu.');

        return $this->jsonResponse(200, 'Pengajuan MoU ditunda ke lain waktu.');
    }

    /**
     * Institusi Pengaju membatalkan pengajuan MoU miliknya sendiri, selama
     * masih berstatus 1 (Ajuan) — sebelum Mitra merespon.
     */
    public function batalkanAjuan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = DB::table('pengajuan_mou')
            ->where('idpengajuan_mou', (int) $idpengajuanMou)
            ->where('idinstitusi_pengaju', $idInstitusiAsal)
            ->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        if ((int) $pengajuan->status_ajuan !== 1) {
            return $this->jsonResponse(422, 'Pengajuan ini sudah tidak berstatus Ajuan — tidak bisa dibatalkan lagi.');
        }

        DB::transaction(function () use ($pengajuan, $userdata) {
            DB::table('pengajuan_mou')->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)->update([
                'status_ajuan' => self::STATUS_AJUAN_DIBATALKAN,
            ]);

            DB::table('log_status_mou')->insert([
                'done_at' => now(),
                'done_by' => $userdata['idpengguna'],
                'status' => self::STATUS_AJUAN_DIBATALKAN,
                'idpengajuan_mou' => $pengajuan->idpengajuan_mou,
            ]);
        });

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Membatalkan pengajuan MoU.');

        return $this->jsonResponse(200, 'Pengajuan MoU berhasil dibatalkan.');
    }

    /**
     * Ganti PIC Pengaju — hanya boleh selama pengajuan masih berstatus 1
     * (Ajuan), yaitu Mitra belum merespon sama sekali, sama syaratnya
     * dengan `batalkanAjuan()` (dikonfirmasi developer).
     */
    public function ubahPicPengaju(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'idpic_institusi_pengaju' => ['required', 'integer'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = DB::table('pengajuan_mou')
            ->where('idpengajuan_mou', (int) $idpengajuanMou)
            ->where('idinstitusi_pengaju', $idInstitusiAsal)
            ->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        if ((int) $pengajuan->status_ajuan !== 1) {
            return $this->jsonResponse(422, 'Pengajuan ini sudah direspon Mitra — PIC Pengaju tidak bisa diubah lagi.');
        }

        $picValid = $this->pesertaAktifQuery($idInstitusiAsal)
            ->where('p.idpengguna', $validated['idpic_institusi_pengaju'])
            ->exists();

        if (! $picValid) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        if ($this->picPengajuSudahPenuh($validated['idpic_institusi_pengaju'], $pengajuan->idpengajuan_mou)) {
            return $this->jsonResponse(422, 'PIC ini sudah menjadi PIC Pengaju di jumlah pengajuan MoU maksimal (mengikuti jumlah sesi Temu Diskusi yang tersedia). Pilih PIC lain.');
        }

        DB::table('pengajuan_mou')->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)->update([
            'idpic_institusi_pengaju' => $validated['idpic_institusi_pengaju'],
        ]);

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Mengubah PIC Pengaju pengajuan MoU.');

        return $this->jsonResponse(200, 'PIC Pengaju berhasil diubah.');
    }

    /**
     * True kalau seorang PIC sudah menjadi PIC Pengaju di jumlah pengajuan
     * MoU aktif (bukan Dibatalkan) sebanyak batas maksimal atau lebih.
     * Batasnya diambil dari jumlah baris `sesi_mou` (bukan angka tetap) —
     * satu orang tidak mungkin menghadiri lebih dari satu Temu Diskusi
     * pada waktu yang sama, dan pilihan waktu Temu Diskusi dibatasi oleh
     * slot sesi yang tersedia (dikonfirmasi developer). Dipakai
     * `simpanPengajuan()` (ajuan baru) dan `ubahPicPengaju()` (koreksi PIC
     * Pengaju) — pada koreksi, `$kecualiIdpengajuanMou` dikecualikan dari
     * hitungan supaya baris yang sedang dikoreksi sendiri tidak ikut
     * dihitung dobel.
     */
    private function picPengajuSudahPenuh(int $idpic, ?int $kecualiIdpengajuanMou = null): bool
    {
        $jumlahDipakai = DB::table('pengajuan_mou')
            ->where('idpic_institusi_pengaju', $idpic)
            ->where('status_ajuan', '!=', self::STATUS_AJUAN_DIBATALKAN)
            ->when($kecualiIdpengajuanMou, fn ($query) => $query->where('idpengajuan_mou', '!=', $kecualiIdpengajuanMou))
            ->count();

        return $jumlahDipakai >= DB::table('sesi_mou')->count();
    }

    /**
     * Tab 2 — daftar sesi yang masih tersedia untuk PIC Pengaju (pengajuan
     * ini) dan PIC Mitra yang baru dipilih, pada tanggal terpilih (lihat
     * docs/features/021-respon-ajuan-mou.md §5.2).
     */
    public function opsiSesiTersedia(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'idpic_institusi_mitra' => ['required', 'integer'],
            'idtanggal_mou' => ['required', 'integer'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = DB::table('pengajuan_mou')
            ->where('idpengajuan_mou', (int) $idpengajuanMou)
            ->where('idinstitusi_mitra', $idInstitusiAsal)
            ->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        if ((int) $pengajuan->status_ajuan !== 1) {
            return $this->jsonResponse(422, $this->pesanStatusSudahBerubah((int) $pengajuan->status_ajuan));
        }

        $picValid = $this->pesertaAktifQuery($idInstitusiAsal)
            ->where('p.idpengguna', $validated['idpic_institusi_mitra'])
            ->exists();

        if (! $picValid) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        $idTanggal = $validated['idtanggal_mou'];
        $idPicPengaju = $pengajuan->idpic_institusi_pengaju;
        $idPicMitra = $validated['idpic_institusi_mitra'];

        $sesiAdaSlot = DB::table('pertemuan_mou')
            ->where('idtanggal_mou', $idTanggal)
            ->whereNull('idpengajuan_mou')
            ->distinct()
            ->pluck('idsesi_mou');

        $sesiKonflik = DB::table('pertemuan_mou as pt')
            ->join('pengajuan_mou as pm', 'pm.idpengajuan_mou', '=', 'pt.idpengajuan_mou')
            ->where('pt.idtanggal_mou', $idTanggal)
            ->where(function ($query) use ($idPicPengaju, $idPicMitra) {
                $query->whereIn('pm.idpic_institusi_pengaju', [$idPicPengaju, $idPicMitra])
                    ->orWhereIn('pm.idpic_institusi_mitra', [$idPicPengaju, $idPicMitra]);
            })
            ->distinct()
            ->pluck('pt.idsesi_mou');

        $idSesiTersedia = $sesiAdaSlot->diff($sesiKonflik);

        $sesiList = DB::table('sesi_mou')
            ->whereIn('idsesi_mou', $idSesiTersedia)
            ->orderBy('jam_mulai')
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', $sesiList);
    }

    /**
     * Tab 2 — submit final: klaim satu slot pertemuan_mou secara atomik
     * (race-condition-safe lewat SELECT ... FOR UPDATE SKIP LOCKED), lalu
     * ubah status_ajuan jadi 2 (Temu Diskusi) (lihat
     * docs/features/021-respon-ajuan-mou.md §5.4).
     */
    public function responTemuDiskusi(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'idpic_institusi_mitra' => ['required', 'integer'],
            'idtanggal_mou' => ['required', 'integer'],
            'idsesi_mou' => ['required', 'integer'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = DB::table('pengajuan_mou')
            ->where('idpengajuan_mou', (int) $idpengajuanMou)
            ->where('idinstitusi_mitra', $idInstitusiAsal)
            ->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        if ((int) $pengajuan->status_ajuan !== 1) {
            return $this->jsonResponse(422, $this->pesanStatusSudahBerubah((int) $pengajuan->status_ajuan));
        }

        $picValid = $this->pesertaAktifQuery($idInstitusiAsal)
            ->where('p.idpengguna', $validated['idpic_institusi_mitra'])
            ->exists();

        if (! $picValid) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        $slotHabis = false;
        $statusSudahBerubah = null;

        DB::transaction(function () use ($validated, $pengajuan, $userdata, &$slotHabis, &$statusSudahBerubah) {
            // Kunci baris pengajuan_mou dan cek ulang statusnya di sini — bisa
            // saja Pengaju membatalkan ajuan ini (batalkanAjuan()) tepat di
            // antara pengecekan awal di atas dan transaksi ini dimulai.
            $statusTerkini = DB::table('pengajuan_mou')
                ->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)
                ->lockForUpdate()
                ->value('status_ajuan');

            if ((int) $statusTerkini !== 1) {
                $statusSudahBerubah = (int) $statusTerkini;

                return;
            }

            $slot = DB::selectOne(
                'SELECT idpertemuan_mou FROM pertemuan_mou WHERE idtanggal_mou = ? AND idsesi_mou = ? AND idpengajuan_mou IS NULL LIMIT 1 FOR UPDATE SKIP LOCKED',
                [$validated['idtanggal_mou'], $validated['idsesi_mou']]
            );

            if (! $slot) {
                $slotHabis = true;

                return;
            }

            DB::table('pertemuan_mou')->where('idpertemuan_mou', $slot->idpertemuan_mou)->update([
                'idpengajuan_mou' => $pengajuan->idpengajuan_mou,
            ]);

            DB::table('pengajuan_mou')->where('idpengajuan_mou', $pengajuan->idpengajuan_mou)->update([
                'status_ajuan' => 2,
                'idpic_institusi_mitra' => $validated['idpic_institusi_mitra'],
            ]);

            DB::table('log_status_mou')->insert([
                'done_at' => now(),
                'done_by' => $userdata['idpengguna'],
                'status' => 2,
                'idpengajuan_mou' => $pengajuan->idpengajuan_mou,
            ]);
        });

        if ($statusSudahBerubah !== null) {
            return $this->jsonResponse(409, $this->pesanStatusSudahBerubah($statusSudahBerubah));
        }

        if ($slotHabis) {
            return $this->jsonResponse(409, 'Meja pada sesi ini baru saja penuh. Silakan ulangi proses penerimaan dari awal.');
        }

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Menerima pengajuan MoU untuk Temu Diskusi.');
        $this->kirimWaTemuDiskusiKePengaju($pengajuan->idpengajuan_mou);

        return $this->jsonResponse(200, 'Pengajuan MoU berhasil diterima untuk Temu Diskusi.');
    }

    /**
     * Kirim notifikasi WA ke PIC Pengaju begitu Mitra menyetujui Temu
     * Diskusi — best-effort: kegagalan kirim WA dicatat ke log saja, tidak
     * membatalkan keputusan Temu Diskusi yang sudah tersimpan (pola sama
     * dengan Controller::kirimWaPameranTerpilih()).
     */
    private function kirimWaTemuDiskusiKePengaju(int $idpengajuanMou): void
    {
        $data = DB::table('pengajuan_mou as pm')
            ->join('institusi_asal as ia_mitra', 'ia_mitra.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
            ->leftJoin('pengguna as pic_pengaju', 'pic_pengaju.idpengguna', '=', 'pm.idpic_institusi_pengaju')
            ->leftJoin('pertemuan_mou as pert', 'pert.idpengajuan_mou', '=', 'pm.idpengajuan_mou')
            ->leftJoin('tanggal_mou as tgl', 'tgl.idtanggal_mou', '=', 'pert.idtanggal_mou')
            ->leftJoin('sesi_mou as sesi', 'sesi.idsesi_mou', '=', 'pert.idsesi_mou')
            ->leftJoin('ruang_mou as ruang', 'ruang.idruang_mou', '=', 'pert.idruang_mou')
            ->where('pm.idpengajuan_mou', $idpengajuanMou)
            ->select(
                'ia_mitra.nama_institusi as nama_institusi_mitra',
                'pic_pengaju.no_wa as no_wa_pic_pengaju',
                'tgl.tanggal', 'sesi.jam_mulai', 'sesi.jam_akhir', 'ruang.nama_ruang'
            )
            ->first();

        if (! $data || ! $data->no_wa_pic_pengaju) {
            return;
        }

        $tanggalFormat = $data->tanggal ? Carbon::parse($data->tanggal)->translatedFormat('d M Y') : '-';
        $jamRange = $data->jam_mulai ? substr($data->jam_mulai, 0, 5).'-'.substr($data->jam_akhir, 0, 5) : '-';

        $pesan1 = 'Selamat, calon mitra MoU Anda,';
        $pesan2 = "{$data->nama_institusi_mitra}, telah menentukan bertemu untuk diskusi pada tanggal {$tanggalFormat} jam {$jamRange} di ruang {$data->nama_ruang}.";
        $pesan3 = 'Detail informasi silakan login di halaman KPPTI.';

        try {
            $this->kirim_wa_oca_token_3($pesan1, $pesan2, $pesan3, $data->no_wa_pic_pengaju);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Pesan error yang sesuai saat status_ajuan ternyata sudah berubah dari
     * 1 (Ajuan) — dibedakan khusus untuk kasus dibatalkan Pengaju (§
     * docs/features/021-respon-ajuan-mou.md & permintaan "Batalkan" sisi
     * Pengaju), supaya pesannya jelas ke pengguna.
     */
    private function pesanStatusSudahBerubah(int $status): string
    {
        if ($status === self::STATUS_AJUAN_DIBATALKAN) {
            return 'Pengajuan ini sudah dibatalkan oleh pihak Pengaju.';
        }

        return 'Pengajuan ini sudah direspon sebelumnya.';
    }

    /**
     * Halaman form "Ajukan MoU Baru" (lihat docs/features/020-pengajuan-mou.md §4).
     */
    public function tambahPengajuanForm()
    {
        $menu = 'mou';
        $submenu = 'pengajuan';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        $pesertaOptions = $this->pesertaAktifQuery($idInstitusiAsal)
            ->select('p.idpengguna', 'p.nama', 'p.no_wa', 'j.nama_jabatan')
            ->orderBy('p.nama')
            ->get();

        return view('peserta.mou-pengajuan-tambah', compact('menu', 'submenu', 'jenisInstitusiList', 'pesertaOptions'));
    }

    /**
     * Opsi institusi untuk TomSelect "Pilih Mitra" — dikecualikan institusi
     * sendiri dan institusi yang sudah punya pengajuan_mou (arah mana pun)
     * dengan institusi sendiri yang belum Dibatalkan (§4.1).
     */
    public function opsiMitraInstitusi(Request $request)
    {
        $validated = $request->validate([
            'idjenis_institusi' => ['required', 'integer'],
            'q' => ['nullable', 'string', 'max:255'],
        ]);

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $idInstitusiDiblokir = $this->institusiDenganPengajuanAktif($idInstitusiAsal);

        $institusiList = DB::table('institusi_asal')
            ->where('idjenis_institusi', $validated['idjenis_institusi'])
            ->where('idinstitusi_asal', '!=', $idInstitusiAsal)
            ->whereNotIn('idinstitusi_asal', $idInstitusiDiblokir)
            ->whereIn('idinstitusi_asal', function ($query) {
                $query->select('p.idinstitusi_asal')
                    ->from('pengguna as p')
                    ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
                    ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
                    ->join('role_pengguna as rp', function ($join) {
                        $join->on('rp.idpengguna', '=', 'p.idpengguna')->where('rp.idrole', 2);
                    })
                    ->where('p.is_deleted', false);
            })
            ->when($validated['q'] ?? null, function ($query, $q) {
                $query->where('nama_institusi', 'ilike', "%{$q}%");
            })
            ->select('idinstitusi_asal', 'nama_institusi')
            ->orderBy('nama_institusi')
            ->limit(50)
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', $institusiList);
    }

    /**
     * Simpan pengajuan MoU baru — insert pengajuan_mou, log_status_mou, dan
     * lampiran_mou (catatan + file) dalam satu transaksi (§4.4).
     */
    public function simpanPengajuan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        if (! $this->jadwalSedangBuka(self::IDJADWAL_PENGAJUAN_MOU)) {
            return $this->jsonResponse(422, 'Sesi pengajuan MoU sedang ditutup. Pengajuan hanya bisa dilakukan dalam periode yang ditentukan panitia.');
        }

        $validated = $request->validate([
            'idinstitusi_mitra' => ['required', 'integer'],
            'idpic_institusi_pengaju' => ['required', 'integer'],
            'catatan' => ['nullable', 'string'],
            'files' => ['nullable', 'array'],
            'files.*.tujuan' => ['nullable', 'string', 'max:255'],
            'files.*.berkas' => ['nullable', 'file', 'mimes:pdf,docx', 'max:5120'],
        ]);

        if ((int) $validated['idinstitusi_mitra'] === (int) $idInstitusiAsal) {
            return $this->jsonResponse(422, 'Institusi Mitra tidak boleh sama dengan institusi Anda sendiri.');
        }

        $picValid = $this->pesertaAktifQuery($idInstitusiAsal)
            ->where('p.idpengguna', $validated['idpic_institusi_pengaju'])
            ->exists();

        if (! $picValid) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        if ($this->picPengajuSudahPenuh($validated['idpic_institusi_pengaju'])) {
            return $this->jsonResponse(422, 'PIC ini sudah menjadi PIC Pengaju di jumlah pengajuan MoU maksimal (mengikuti jumlah sesi Temu Diskusi yang tersedia). Pilih PIC lain.');
        }

        $idInstitusiDiblokir = $this->institusiDenganPengajuanAktif($idInstitusiAsal);

        if (in_array((int) $validated['idinstitusi_mitra'], $idInstitusiDiblokir, true)) {
            return $this->jsonResponse(422, 'Sudah terdapat pengajuan MoU dengan mitra yang sama.');
        }

        try {
            DB::transaction(function () use ($validated, $idInstitusiAsal, $userdata) {
                $idpengajuanMou = DB::table('pengajuan_mou')->insertGetId([
                    'status_ajuan' => 1,
                    'idinstitusi_pengaju' => $idInstitusiAsal,
                    'idpic_institusi_pengaju' => $validated['idpic_institusi_pengaju'],
                    'idinstitusi_mitra' => $validated['idinstitusi_mitra'],
                ], 'idpengajuan_mou');

                DB::table('log_status_mou')->insert([
                    'done_at' => now(),
                    'done_by' => $userdata['idpengguna'],
                    'status' => 1,
                    'idpengajuan_mou' => $idpengajuanMou,
                ]);

                $catatan = $this->sanitizeRichText($validated['catatan'] ?? null);

                if ($catatan && trim($catatan) !== '') {
                    DB::table('lampiran_mou')->insert([
                        'jenis_lampiran' => 2,
                        'catatan' => $catatan,
                        'idpengajuan_mou' => $idpengajuanMou,
                        'dikirim_oleh' => $idInstitusiAsal,
                    ]);
                }

                foreach ($validated['files'] ?? [] as $berkas) {
                    if (! isset($berkas['berkas']) || ! $berkas['berkas'] instanceof UploadedFile) {
                        continue;
                    }

                    $filePath = $this->simpanFileLampiranMou($berkas['berkas'], $idpengajuanMou);

                    DB::table('lampiran_mou')->insert([
                        'jenis_lampiran' => 1,
                        'catatan' => $berkas['tujuan'] ?? null,
                        'file_path' => $filePath,
                        'idpengajuan_mou' => $idpengajuanMou,
                        'dikirim_oleh' => $idInstitusiAsal,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menyimpan pengajuan MoU. Silakan coba lagi.');
        }

        $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], 'Mengajukan MoU ke institusi lain.');

        return $this->jsonResponse(200, 'Pengajuan MoU berhasil dikirim.');
    }

    /**
     * Simpan satu file lampiran MoU ke disk non-publik, pola sama dengan
     * PameranController::simpanFilePortofolio()/dst.
     */
    private function simpanFileLampiranMou(UploadedFile $file, int $idpengajuanMou): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "lampiran-mou/mou-{$idpengajuanMou}-".time().'-'.uniqid().".{$ext}";

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }

    /**
     * ID institusi yang tidak boleh dipilih sebagai Mitra baru oleh
     * `$idInstitusiAsal` — sudah punya pengajuan_mou dengan institusi itu,
     * arah mana pun, yang belum berstatus Dibatalkan (§4.1/§4.4).
     *
     * @return array<int>
     */
    private function institusiDenganPengajuanAktif(int $idInstitusiAsal): array
    {
        $sebagaiPengaju = DB::table('pengajuan_mou')
            ->where('idinstitusi_pengaju', $idInstitusiAsal)
            ->where('status_ajuan', '!=', self::STATUS_AJUAN_DIBATALKAN)
            ->pluck('idinstitusi_mitra');

        $sebagaiMitra = DB::table('pengajuan_mou')
            ->where('idinstitusi_mitra', $idInstitusiAsal)
            ->where('status_ajuan', '!=', self::STATUS_AJUAN_DIBATALKAN)
            ->pluck('idinstitusi_pengaju');

        return $sebagaiPengaju->merge($sebagaiMitra)->map(fn ($id) => (int) $id)->unique()->values()->all();
    }

    /**
     * Unduh template dokumen Nota Kesepahaman (MoU) — tombol "Download
     * Template MoU" di halaman daftar pengajuan.
     */
    public function unduhTemplate()
    {
        $namaFile = 'template_nota_kesepahaman(MoU).docx';
        $path = "dokumen-template/{$namaFile}";

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $namaFile);
    }

    public function pesertaInstitusi(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idInstitusiAsal = $this->decryptRouteValue($validated['token']);

        if (! $idInstitusiAsal) {
            return $this->jsonResponse(404, 'Institusi tidak ditemukan.');
        }

        $pesertaList = $this->pesertaAktifQuery((int) $idInstitusiAsal)
            ->select('p.nama')
            ->orderBy('p.nama')
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', ['peserta' => $pesertaList]);
    }
}
