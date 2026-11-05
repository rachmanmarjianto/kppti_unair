<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasRuangMouController extends Controller
{
    /**
     * `pengajuan_mou.status_ajuan` yang bisa dipilih Petugas Ruang MoU
     * sebagai hasil pertemuan (lihat docs — F22).
     */
    private const STATUS_AJUAN_TERJALIN = 4;

    private const STATUS_AJUAN_TUNDA = 3;

    /**
     * Satu-satunya menu "Pengajuan MoU" — isinya sama persis dengan submenu
     * "Pertemuan MoU" milik Admin (`MouAdminController::pertemuanIndex()`),
     * bedanya sel yang terisi membuka modal kerja (bukan halaman detail).
     */
    public function index(Request $request)
    {
        $menu = 'pengajuan-mou';
        $submenu = '';

        $tanggalAktifList = DB::table('tanggal_mou')->where('status', true)->orderBy('tanggal')->get();
        $ruangList = DB::table('ruang_mou')->orderBy('nama_ruang')->get();

        $idTanggalTerpilih = $request->query('idtanggal_mou') ?? $tanggalAktifList->first()?->idtanggal_mou;
        $idRuangTerpilih = $request->query('idruang_mou') ?? $ruangList->first()?->idruang_mou;

        $sesiList = null;
        $kolomMeja = null;
        $ruangTerpilih = null;
        $tanggalTerpilih = null;
        $pertemuanMap = null;

        if ($idTanggalTerpilih && $idRuangTerpilih) {
            $tanggalTerpilih = $tanggalAktifList->firstWhere('idtanggal_mou', (int) $idTanggalTerpilih);
            $ruangTerpilih = $ruangList->firstWhere('idruang_mou', (int) $idRuangTerpilih);
        }

        if ($tanggalTerpilih && $ruangTerpilih) {
            $sesiList = DB::table('sesi_mou')->orderBy('jam_mulai')->get();
            $kolomMeja = range(1, $ruangTerpilih->kapasitas);

            $pertemuanMap = DB::table('pertemuan_mou as pt')
                ->leftJoin('pengajuan_mou as pm', 'pm.idpengajuan_mou', '=', 'pt.idpengajuan_mou')
                ->leftJoin('institusi_asal as ia_pengaju', 'ia_pengaju.idinstitusi_asal', '=', 'pm.idinstitusi_pengaju')
                ->leftJoin('institusi_asal as ia_mitra', 'ia_mitra.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
                ->where('pt.idtanggal_mou', $tanggalTerpilih->idtanggal_mou)
                ->where('pt.idruang_mou', $ruangTerpilih->idruang_mou)
                ->select(
                    'pt.idsesi_mou', 'pt.isi_ke', 'pt.idpengajuan_mou', 'pm.status_ajuan',
                    'ia_pengaju.nama_institusi as nama_institusi_pengaju',
                    'ia_mitra.nama_institusi as nama_institusi_mitra'
                )
                ->get()
                ->map(function ($baris) {
                    $baris->token = $baris->idpengajuan_mou ? $this->encryptRouteValue($baris->idpengajuan_mou) : null;

                    return $baris;
                })
                ->keyBy(fn ($baris) => "{$baris->idsesi_mou}-{$baris->isi_ke}");
        }

        return view('petugas-ruang-mou.pengajuan', compact(
            'menu', 'submenu', 'tanggalAktifList', 'ruangList',
            'idTanggalTerpilih', 'idRuangTerpilih', 'tanggalTerpilih', 'ruangTerpilih',
            'sesiList', 'kolomMeja', 'pertemuanMap'
        ));
    }

    /**
     * Tombol "Sesuaikan Slot" — sama persis dengan
     * `MouAdminController::sesuaikanSlot()`.
     */
    public function sesuaikanSlot(Request $request)
    {
        $validated = $request->validate([
            'idtanggal_mou' => ['required', 'integer', 'exists:tanggal_mou,idtanggal_mou'],
            'idruang_mou' => ['required', 'integer', 'exists:ruang_mou,idruang_mou'],
        ]);

        $ruang = DB::table('ruang_mou')->where('idruang_mou', $validated['idruang_mou'])->first();
        $sesiList = DB::table('sesi_mou')->get();

        $existing = DB::table('pertemuan_mou')
            ->where('idtanggal_mou', $validated['idtanggal_mou'])
            ->where('idruang_mou', $validated['idruang_mou'])
            ->select('idsesi_mou', 'isi_ke')
            ->get()
            ->map(fn ($baris) => "{$baris->idsesi_mou}-{$baris->isi_ke}")
            ->flip()
            ->all();

        $barisBaru = [];

        foreach ($sesiList as $sesi) {
            for ($isiKe = 1; $isiKe <= $ruang->kapasitas; $isiKe++) {
                $kunci = "{$sesi->idsesi_mou}-{$isiKe}";

                if (isset($existing[$kunci])) {
                    continue;
                }

                $barisBaru[] = [
                    'idtanggal_mou' => $validated['idtanggal_mou'],
                    'idsesi_mou' => $sesi->idsesi_mou,
                    'idruang_mou' => $validated['idruang_mou'],
                    'isi_ke' => $isiKe,
                ];
            }
        }

        if (! empty($barisBaru)) {
            DB::transaction(function () use ($barisBaru) {
                foreach (array_chunk($barisBaru, 500) as $chunk) {
                    DB::table('pertemuan_mou')->insert($chunk);
                }
            });
        }

        $jumlah = count($barisBaru);

        return $this->jsonResponse(200, "{$jumlah} slot berhasil ditambahkan.", ['jumlah' => $jumlah]);
    }

    /**
     * AJAX — data satu sel matrix yang diklik, untuk mengisi 3 card di modal
     * kerja (Pengaju, Mitra, Hasil Pertemuan).
     */
    public function detailSlot(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $pengajuan = $this->ambilDataSlot((int) $idpengajuanMou);

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        return $this->jsonResponse(200, 'Berhasil.', $pengajuan);
    }

    /**
     * Card 1 — catat kehadiran PIC Pengaju. Kalau setelah ini PIC Mitra juga
     * sudah tercatat hadir, isi `pertemuan_mou.mulai_at`.
     */
    public function hadirPengaju(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $idpengajuanMou = (int) $idpengajuanMou;

        $pengajuan = DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        DB::transaction(function () use ($idpengajuanMou, $userdata) {
            DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->update([
                'pic_pengaju_hadir_at' => now(),
                'pic_pengaju_stamp_by' => $userdata['idpengguna'],
            ]);

            $this->tandaiMulaiJikaKeduanyaHadir($idpengajuanMou);
        });

        return $this->jsonResponse(200, 'Kehadiran PIC Pengaju berhasil dicatat.', $this->ambilDataSlot($idpengajuanMou));
    }

    /**
     * Card 2 — catat kehadiran PIC Mitra. Simetris dengan hadirPengaju().
     */
    public function hadirMitra(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $idpengajuanMou = (int) $idpengajuanMou;

        $pengajuan = DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        DB::transaction(function () use ($idpengajuanMou, $userdata) {
            DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->update([
                'pic_mitra_hadir_at' => now(),
                'pic_mitra_stamp_by' => $userdata['idpengguna'],
            ]);

            $this->tandaiMulaiJikaKeduanyaHadir($idpengajuanMou);
        });

        return $this->jsonResponse(200, 'Kehadiran PIC Mitra berhasil dicatat.', $this->ambilDataSlot($idpengajuanMou));
    }

    /**
     * Card 3 — tetapkan hasil pertemuan (Terjalin/Tunda Lain Waktu). Boleh
     * diubah bolak-balik kapan saja; tiap kali dijalankan, `log_status_mou`
     * ditambah satu baris dan `pertemuan_mou.selesai_at` di-set ulang.
     */
    public function ubahHasilPertemuan(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'token' => ['required', 'string'],
            'status_ajuan' => ['required', 'integer', 'in:'.self::STATUS_AJUAN_TUNDA.','.self::STATUS_AJUAN_TERJALIN],
        ]);

        $idpengajuanMou = $this->decryptRouteValue($validated['token']);

        if ($idpengajuanMou === null) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        $idpengajuanMou = (int) $idpengajuanMou;

        $pengajuan = DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->first();

        if (! $pengajuan) {
            return $this->jsonResponse(404, 'Pengajuan MoU tidak ditemukan.');
        }

        DB::transaction(function () use ($idpengajuanMou, $validated, $userdata) {
            DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->update([
                'status_ajuan' => $validated['status_ajuan'],
            ]);

            DB::table('log_status_mou')->insert([
                'done_at' => now(),
                'done_by' => $userdata['idpengguna'],
                'status' => $validated['status_ajuan'],
                'idpengajuan_mou' => $idpengajuanMou,
            ]);

            DB::table('pertemuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->update([
                'selesai_at' => now(),
            ]);
        });

        return $this->jsonResponse(200, 'Hasil pertemuan berhasil disimpan.', $this->ambilDataSlot($idpengajuanMou));
    }

    /**
     * Set `pertemuan_mou.mulai_at` = sekarang kalau PIC Pengaju dan PIC
     * Mitra pada pengajuan ini sudah sama-sama tercatat hadir. Dipanggil di
     * dalam transaksi yang sama dengan update hadir_at, supaya baca data
     * terbaru (bukan data sebelum update).
     */
    private function tandaiMulaiJikaKeduanyaHadir(int $idpengajuanMou): void
    {
        $pengajuan = DB::table('pengajuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->first();

        if ($pengajuan->pic_pengaju_hadir_at && $pengajuan->pic_mitra_hadir_at) {
            DB::table('pertemuan_mou')->where('idpengajuan_mou', $idpengajuanMou)->update([
                'mulai_at' => now(),
            ]);
        }
    }

    /**
     * Data satu pengajuan MoU untuk render ulang modal kerja (3 card) setelah
     * sebuah aksi (buka modal pertama kali, atau setelah hadir/ubah hasil).
     */
    private function ambilDataSlot(int $idpengajuanMou): ?object
    {
        $pengajuan = DB::table('pengajuan_mou as pm')
            ->join('institusi_asal as ia_pengaju', 'ia_pengaju.idinstitusi_asal', '=', 'pm.idinstitusi_pengaju')
            ->join('institusi_asal as ia_mitra', 'ia_mitra.idinstitusi_asal', '=', 'pm.idinstitusi_mitra')
            ->leftJoin('pengguna as pic_pengaju', 'pic_pengaju.idpengguna', '=', 'pm.idpic_institusi_pengaju')
            ->leftJoin('pengguna as pic_mitra', 'pic_mitra.idpengguna', '=', 'pm.idpic_institusi_mitra')
            ->where('pm.idpengajuan_mou', $idpengajuanMou)
            ->select(
                'pm.idpengajuan_mou', 'pm.status_ajuan',
                'ia_pengaju.nama_institusi as nama_institusi_pengaju',
                'pic_pengaju.nama as nama_pic_pengaju', 'pm.pic_pengaju_hadir_at',
                'ia_mitra.nama_institusi as nama_institusi_mitra',
                'pic_mitra.nama as nama_pic_mitra', 'pm.pic_mitra_hadir_at'
            )
            ->first();

        if (! $pengajuan) {
            return null;
        }

        $pengajuan->token = $this->encryptRouteValue($pengajuan->idpengajuan_mou);

        return $pengajuan;
    }
}
