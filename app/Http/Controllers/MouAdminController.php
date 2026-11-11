<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MouAdminController extends Controller
{
    /**
     * Label status_ajuan (1-4) yang dipakai di rekap §ajuanIndex — status 5
     * (Dibatalkan) sengaja dikecualikan dari semua hitungan (Total, dashboard,
     * dan daftar modal "total"), bukan hanya dari kolom breakdown.
     */
    private const LABEL_STATUS_AJUAN = [
        1 => 'Ajuan',
        2 => 'Temu Diskusi',
        3 => 'Tunda Lain Waktu',
        4 => 'Terjalin',
        5 => 'Dibatalkan',
    ];

    /**
     * Submenu "Ajuan" — rekap jumlah pengajuan_mou per institusi, baik
     * sebagai Pengaju ("Ajuan") maupun sebagai Mitra ("Permintaan"), dipecah
     * per status. Hanya institusi yang punya minimal 1 baris pengajuan_mou
     * (arah mana pun) yang ditampilkan.
     */
    public function ajuanIndex()
    {
        $menu = 'mou';
        $submenu = 'ajuan';

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        $ajuanAgg = DB::table('pengajuan_mou')
            ->where('status_ajuan', '!=', 5)
            ->selectRaw('
                idinstitusi_pengaju as idinstitusi_asal,
                COUNT(*) as ajuan_total,
                COUNT(*) FILTER (WHERE status_ajuan = 1) as ajuan_belum,
                COUNT(*) FILTER (WHERE status_ajuan = 3) as ajuan_tunda,
                COUNT(*) FILTER (WHERE status_ajuan = 2) as ajuan_temu,
                COUNT(*) FILTER (WHERE status_ajuan = 4) as ajuan_terjalin
            ')
            ->groupBy('idinstitusi_pengaju');

        $permintaanAgg = DB::table('pengajuan_mou')
            ->where('status_ajuan', '!=', 5)
            ->selectRaw('
                idinstitusi_mitra as idinstitusi_asal,
                COUNT(*) as permintaan_total,
                COUNT(*) FILTER (WHERE status_ajuan = 1) as permintaan_belum,
                COUNT(*) FILTER (WHERE status_ajuan = 3) as permintaan_tunda,
                COUNT(*) FILTER (WHERE status_ajuan = 2) as permintaan_temu,
                COUNT(*) FILTER (WHERE status_ajuan = 4) as permintaan_terjalin
            ')
            ->groupBy('idinstitusi_mitra');

        $rekapList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoinSub($ajuanAgg, 'aj', 'aj.idinstitusi_asal', '=', 'i.idinstitusi_asal')
            ->leftJoinSub($permintaanAgg, 'pm', 'pm.idinstitusi_asal', '=', 'i.idinstitusi_asal')
            ->whereRaw('COALESCE(aj.ajuan_total, 0) + COALESCE(pm.permintaan_total, 0) > 0')
            ->select(
                'i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi',
                DB::raw('COALESCE(aj.ajuan_total, 0) as ajuan_total'),
                DB::raw('COALESCE(aj.ajuan_belum, 0) as ajuan_belum'),
                DB::raw('COALESCE(aj.ajuan_tunda, 0) as ajuan_tunda'),
                DB::raw('COALESCE(aj.ajuan_temu, 0) as ajuan_temu'),
                DB::raw('COALESCE(aj.ajuan_terjalin, 0) as ajuan_terjalin'),
                DB::raw('COALESCE(pm.permintaan_total, 0) as permintaan_total'),
                DB::raw('COALESCE(pm.permintaan_belum, 0) as permintaan_belum'),
                DB::raw('COALESCE(pm.permintaan_tunda, 0) as permintaan_tunda'),
                DB::raw('COALESCE(pm.permintaan_temu, 0) as permintaan_temu'),
                DB::raw('COALESCE(pm.permintaan_terjalin, 0) as permintaan_terjalin')
            )
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idinstitusi_asal);

                return $baris;
            });

        $jumlahTotalMou = DB::table('pengajuan_mou')->where('status_ajuan', '!=', 5)->count();
        $jumlahTerjalin = DB::table('pengajuan_mou')->where('status_ajuan', 4)->count();
        $jumlahInstitusiTerjalin = DB::table('pengajuan_mou')->where('status_ajuan', 4)->pluck('idinstitusi_pengaju')
            ->merge(DB::table('pengajuan_mou')->where('status_ajuan', 4)->pluck('idinstitusi_mitra'))
            ->unique()
            ->count();
        $jumlahTemuDiskusi = DB::table('pengajuan_mou')->where('status_ajuan', 2)->count();
        $jumlahInstitusiTemuDiskusi = DB::table('pengajuan_mou')->where('status_ajuan', 2)->pluck('idinstitusi_pengaju')
            ->merge(DB::table('pengajuan_mou')->where('status_ajuan', 2)->pluck('idinstitusi_mitra'))
            ->unique()
            ->count();

        return view('admin.mou-ajuan', compact(
            'menu', 'submenu', 'jenisInstitusiList', 'rekapList',
            'jumlahTotalMou', 'jumlahTerjalin', 'jumlahInstitusiTerjalin',
            'jumlahTemuDiskusi', 'jumlahInstitusiTemuDiskusi'
        ));
    }

    /**
     * AJAX — daftar institusi lawan untuk satu sel rekap (peran + status)
     * yang diklik di submenu "Ajuan". Khusus sel "Belum Merespon" di bawah
     * grup "Penerima" (peran mitra, status 1) — institusi yang diklik
     * ("penerima ajuan MoU") adalah yang belum merespon, bukan
     * institusi-institusi lawan di daftar — jadi ikut dikembalikan semua
     * peserta kontingennya (`pesertaDenganJabatan()`) supaya Admin bisa
     * memilih siapa yang dikirimi notifikasi WA lewat
     * `kirimWaBelumRespon()`.
     */
    public function ajuanModalList(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'peran' => ['required', 'in:pengaju,mitra'],
            'status' => ['required', 'string'],
        ]);

        $idInstitusiAsal = $this->decryptRouteValue($validated['token']);

        if ($idInstitusiAsal === null) {
            return $this->jsonResponse(404, 'Institusi tidak ditemukan.');
        }

        $idInstitusiAsal = (int) $idInstitusiAsal;

        $kolomSendiri = $validated['peran'] === 'pengaju' ? 'idinstitusi_pengaju' : 'idinstitusi_mitra';
        $kolomLawan = $validated['peran'] === 'pengaju' ? 'idinstitusi_mitra' : 'idinstitusi_pengaju';

        $query = DB::table('pengajuan_mou as pm')
            ->join('institusi_asal as ia_lawan', 'ia_lawan.idinstitusi_asal', '=', "pm.{$kolomLawan}")
            ->where("pm.{$kolomSendiri}", $idInstitusiAsal);

        if ($validated['status'] !== 'total') {
            $query->where('pm.status_ajuan', (int) $validated['status']);
        } else {
            $query->where('pm.status_ajuan', '!=', 5);
        }

        $list = $query->select('ia_lawan.nama_institusi', 'pm.status_ajuan', 'pm.idpengajuan_mou')
            ->orderBy('ia_lawan.nama_institusi')
            ->get()
            ->map(function ($baris) {
                $baris->status_label = self::LABEL_STATUS_AJUAN[$baris->status_ajuan] ?? '-';
                $baris->token = $this->encryptRouteValue($baris->idpengajuan_mou);

                return $baris;
            });

        $belumMeresponSebagaiMitra = $validated['peran'] === 'mitra' && $validated['status'] === '1';

        return $this->jsonResponse(200, 'Berhasil.', [
            'list' => $list,
            'pesertaPenerima' => $belumMeresponSebagaiMitra ? $this->pesertaDenganJabatan($idInstitusiAsal) : collect(),
            'jumlahBelumRespon' => $belumMeresponSebagaiMitra ? $list->count() : 0,
        ]);
    }

    /**
     * Semua peserta aktif satu institusi beserta nama jabatannya, plus
     * flag `isPimpinan` (idjabatan termasuk `self::JABATAN_PIMPINAN`,
     * base Controller) — dipakai untuk mengisi pilihan penerima WA di
     * modal "Belum Merespon".
     *
     * @return Collection<int, object>
     */
    private function pesertaDenganJabatan(int $idInstitusiAsal)
    {
        return DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->where('p.is_deleted', false)
            ->select('pe.idpeserta', 'p.nama', 'p.no_wa', 'j.nama_jabatan', 'pe.idjabatan')
            ->orderBy('p.nama')
            ->get()
            ->map(function ($peserta) {
                $peserta->isPimpinan = in_array((int) $peserta->idjabatan, self::JABATAN_PIMPINAN, true);

                return $peserta;
            });
    }

    /**
     * AJAX — kirim notifikasi WA ke satu peserta (dipilih Admin dari
     * select di modal "Belum Merespon") memberi tahu institusinya punya
     * ajuan MoU yang belum direspon. `$jumlahBelumRespon` dihitung ulang
     * di sini (bukan dipercaya dari payload klien) supaya tidak basi
     * antara modal dibuka dan tombol diklik. Respons `kirim_wa_oca_token_3()`
     * dicek isinya ("sukses"), bukan cuma exception — pola sama seperti
     * `PesertaAdminController::resetPassword()` — supaya kegagalan dari sisi
     * gateway (bukan HTTP) tetap terdeteksi. `log_notif_mou` hanya dicatat
     * kalau benar-benar terkirim.
     */
    public function kirimWaBelumRespon(Request $request)
    {
        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $penerima = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->where('pe.idpeserta', $validated['idpeserta'])
            ->where('p.is_deleted', false)
            ->select('p.idpengguna', 'p.nama', 'p.no_wa', 'p.idinstitusi_asal')
            ->first();

        if (! $penerima) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        if (! $penerima->no_wa) {
            return $this->jsonResponse(422, 'Peserta ini belum memiliki nomor WhatsApp.');
        }

        $jumlahBelumRespon = DB::table('pengajuan_mou')
            ->where('idinstitusi_mitra', $penerima->idinstitusi_asal)
            ->where('status_ajuan', 1)
            ->count();

        if ($jumlahBelumRespon === 0) {
            return $this->jsonResponse(422, 'Institusi ini sudah tidak memiliki ajuan yang belum direspon.');
        }

        // 3 baris wajib terisi (gateway WA ini memang "kirim-wa_3line_token",
        // 3 baris template) — baris kosong terbukti membuat pengiriman gagal
        // di production meski tidak melempar exception, karena gateway-nya
        // sendiri yang menolak, bukan request HTTP-nya. Dipecah dari kalimat
        // asli, tanpa menambah kata baru.
        $pesan1 = "Anda menerima {$jumlahBelumRespon} ajuan kerjasama MoU yang belum anda respon,";
        $pesan2 = 'silahkan login ke halaman KPPTI 2026 untuk memberi respon ajuan kerjasama tersebut.';
        $pesan3 = '12 November 2024 adalah batas akhir untuk memberi respon.';

        try {
            $res = $this->kirim_wa_oca_token_3($pesan1, $pesan2, $pesan3, $penerima->no_wa);
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengirim notifikasi WhatsApp.');
        }

        // Curl bisa sukses (tidak melempar exception) walau gateway-nya
        // sendiri menolak permintaan — responsnya berupa teks "sukses"
        // kalau benar-benar terkirim, pola sama seperti
        // PesertaAdminController::resetPassword()/PesertaController::tambahPeserta().
        // Tanpa pengecekan ini method akan selalu lapor berhasil walau WA-nya
        // tidak pernah terkirim.
        if (strtoupper($res) != strtoupper('sukses')) {
            return $this->jsonResponse(500, 'Gagal mengirim notifikasi WhatsApp. Respon: '.$res);
        }

        $userdata = session('userdata');

        DB::table('log_notif_mou')->insert([
            'idinstitusi_asal_penerima' => $penerima->idinstitusi_asal,
            'idpengguna_penerima' => $penerima->idpengguna,
            'pesan_1' => $pesan1,
            'pesan_2' => $pesan2,
            'pesan_3' => $pesan3,
            'no_wa' => $penerima->no_wa,
            'created_at' => now(),
            'sent_by' => $userdata['idpengguna'] ?? null,
        ]);

        return $this->jsonResponse(200, 'Notifikasi WhatsApp berhasil dikirim.', ['wa_response' => $res]);
    }

    /**
     * Submenu "Sesi MoU" — view only.
     */
    public function sesiIndex()
    {
        $menu = 'mou';
        $submenu = 'sesi';

        $sesiList = DB::table('sesi_mou')->orderBy('idsesi_mou')->get();

        return view('admin.mou-sesi', compact('menu', 'submenu', 'sesiList'));
    }

    /**
     * Submenu "Ruang MoU" — view only.
     */
    public function ruangIndex()
    {
        $menu = 'mou';
        $submenu = 'ruang';

        $ruangList = DB::table('ruang_mou')->orderBy('idruang_mou')->get();

        return view('admin.mou-ruang', compact('menu', 'submenu', 'ruangList'));
    }

    /**
     * Submenu "Tanggal MoU" — lihat, tambah, soft delete (kolom `status`).
     */
    public function tanggalIndex()
    {
        $menu = 'mou';
        $submenu = 'tanggal';

        $tanggalList = DB::table('tanggal_mou')->orderBy('tanggal')->get();

        return view('admin.mou-tanggal', compact('menu', 'submenu', 'tanggalList'));
    }

    public function tambahTanggal(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
        ]);

        $sudahAda = DB::table('tanggal_mou')->where('tanggal', $validated['tanggal'])->exists();

        if ($sudahAda) {
            return $this->jsonResponse(409, 'Tanggal ini sudah ada di data master.');
        }

        DB::table('tanggal_mou')->insert([
            'tanggal' => $validated['tanggal'],
            'status' => true,
        ]);

        return $this->jsonResponse(200, 'Tanggal MoU berhasil ditambahkan.');
    }

    /**
     * Nonaktifkan/aktifkan satu Tanggal MoU — soft toggle (pola sama seperti
     * SeminarKitController::toggleStatus()), tapi menonaktifkan diblokir
     * total kalau tanggal itu masih punya pertemuan_mou dengan booking aktif
     * (idpengajuan_mou terisi) — lihat docs/features/024-manajemen-mou-admin.md §4.
     */
    public function toggleStatusTanggal(Request $request)
    {
        $validated = $request->validate([
            'idtanggal_mou' => ['required', 'integer'],
        ]);

        $tanggal = DB::table('tanggal_mou')->where('idtanggal_mou', $validated['idtanggal_mou'])->first();

        if (! $tanggal) {
            return $this->jsonResponse(404, 'Tanggal MoU tidak ditemukan.');
        }

        $statusBaru = ! $tanggal->status;

        if (! $statusBaru) {
            $masihAdaBooking = DB::table('pertemuan_mou')
                ->where('idtanggal_mou', $tanggal->idtanggal_mou)
                ->whereNotNull('idpengajuan_mou')
                ->exists();

            if ($masihAdaBooking) {
                return $this->jsonResponse(422, 'Tidak bisa dinonaktifkan — masih ada pertemuan MoU terjadwal di tanggal ini.');
            }
        }

        DB::table('tanggal_mou')->where('idtanggal_mou', $tanggal->idtanggal_mou)->update([
            'status' => $statusBaru,
        ]);

        $pesan = $statusBaru ? 'Tanggal MoU berhasil diaktifkan.' : 'Tanggal MoU berhasil dinonaktifkan.';

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Submenu "Pertemuan MoU" — matrix slot per tanggal+ruang terpilih
     * (lihat docs/features/024-manajemen-mou-admin.md §5).
     */
    public function pertemuanIndex(Request $request)
    {
        $menu = 'mou';
        $submenu = 'pertemuan';

        $tanggalAktifList = DB::table('tanggal_mou')->where('status', true)->orderBy('tanggal')->get();
        $ruangList = DB::table('ruang_mou')->orderBy('nama_ruang')->get();

        // Default ke opsi paling awal kalau belum ada filter di query string —
        // halaman ini selalu tampil dengan satu tanggal+ruang terpilih, tidak
        // ada opsi "pilih dulu" (dikonfirmasi developer).
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

        return view('admin.mou-pertemuan', compact(
            'menu', 'submenu', 'tanggalAktifList', 'ruangList',
            'idTanggalTerpilih', 'idRuangTerpilih', 'tanggalTerpilih', 'ruangTerpilih',
            'sesiList', 'kolomMeja', 'pertemuanMap'
        ));
    }

    /**
     * Tombol "Sesuaikan Slot" — generate baris pertemuan_mou yang belum ada
     * untuk kombinasi tanggal+ruang yang difilter (semua sesi), sejumlah
     * kapasitas ruang. Idempoten, logika sama dengan
     * App\Console\Commands\GenerateSlotPertemuanMou tapi dipersempit ke satu
     * tanggal + satu ruang.
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
     * Detail satu pengajuan MoU, view only — dibuka dari sel matrix
     * Pertemuan MoU yang sudah terisi. Admin bisa melihat pengajuan MoU
     * apa pun (tidak dibatasi institusi, berbeda dari versi peserta).
     */
    public function detailPengajuan(Request $request)
    {
        $menu = 'mou';
        $submenu = 'pertemuan';

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

        return view('admin.mou-pengajuan-detail', compact('menu', 'submenu', 'pengajuan', 'lampiranList', 'riwayatStatus', 'pertemuan'));
    }

    /**
     * Unduh satu file lampiran MoU — sisi Admin, tidak dibatasi institusi.
     */
    public function unduhLampiran(Request $request)
    {
        $idlampiranMou = $this->decryptRouteValue($request->query('token'));

        if ($idlampiranMou === null) {
            abort(404);
        }

        $lampiran = DB::table('lampiran_mou')->where('idlampiran_mou', (int) $idlampiranMou)->first();

        if (! $lampiran || ! $lampiran->file_path || ! Storage::disk('local')->exists($lampiran->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($lampiran->file_path);
    }
}
