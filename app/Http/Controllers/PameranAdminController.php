<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranAdminController extends Controller
{
    /**
     * Daftar semua pengajuan pameran — admin punya visibilitas paling luas
     * di aplikasi ini, jadi ditampilkan tanpa kecuali (termasuk yang masih
     * Draft), beda dari SC yang sama sekali tidak bisa melihat Draft.
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = 'ajuan';

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->select('p.idpameran', 'p.tema', 'i.nama_institusi', 'p.status_ajuan')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);

                return $row;
            });

        return view('admin.pameran-ajuan', compact('menu', 'submenu', 'pameran'));
    }

    /**
     * Detail read-only — tampilan sama seperti halaman detail SC, tapi tanpa
     * aksi apa pun (tidak ada klaim/beri review). Breakdown 4 kriteria cuma
     * ditampilkan untuk baris yang sudah final (4/5/6); baris yang masih
     * diklaim/direview SC (status 2/3) tetap disembunyikan isinya dari admin
     * juga — admin tidak pernah jadi pihak yang mengklaim.
     */
    public function detail(Request $request)
    {
        $idpameran = $this->decryptRouteValue($request->query('token'));

        if ($idpameran === null) {
            abort(404);
        }

        $idpameran = (int) $idpameran;

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->leftJoin('pengguna as sc', 'sc.idpengguna', '=', 'p.direview_oleh')
            ->where('p.idpameran', $idpameran)
            ->select('p.*', 'i.nama_institusi', 'pic.nama as nama_pic', 'sc.nama as nama_sc')
            ->first();

        if (! $pameran) {
            abort(404);
        }

        $menu = 'pameran';
        $submenu = 'ajuan';

        $riwayat = DB::table('review_pameran')
            ->where('idpameran', $idpameran)
            ->orderBy('idreview')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idreview);
                $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6'], true)
                    ? $this->kriteriaUntukReview($baris->idreview)
                    : collect();

                return $baris;
            });

        return view('admin.pameran-ajuan-detail', compact('menu', 'submenu', 'pameran', 'riwayat'));
    }

    /**
     * Daftar pengajuan pameran yang sudah Diterima — satu-satunya tempat
     * admin menetapkan nomor stand.
     */
    public function nomorStand()
    {
        $menu = 'pameran';
        $submenu = 'nomor-stand';

        $pameran = DB::table('pameran as p')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('peserta as pe', 'pe.idpeserta', '=', 'p.idpeserta_PIC')
            ->leftJoin('pengguna as pic', 'pic.idpengguna', '=', 'pe.idpengguna')
            ->where('p.status_ajuan', '5')
            ->select('p.idpameran', 'p.idinstitusi_asal', 'p.tema', 'p.nomor_stand', 'i.nama_institusi', 'ji.nama_jenis_institusi', 'pic.nama as nama_pic', 'pic.no_wa as no_wa_pic')
            ->orderBy('p.idpameran')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idpameran);
                $row->penjaga = DB::table('petugas_jaga as pj')
                    ->join('peserta as pe', 'pe.idpeserta', '=', 'pj.idpeserta')
                    ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
                    ->where('pj.idpameran', $row->idpameran)
                    ->select('pj.idpetugas_jaga', 'pj.idpeserta', 'p.nama')
                    ->orderBy('pj.idpetugas_jaga')
                    ->get();
                $row->jumlah_penjaga = $row->penjaga->count();
                $row->pesertaOptions = $this->pesertaAktifQuery($row->idinstitusi_asal)
                    ->select('pe.idpeserta', 'p.nama')
                    ->orderBy('p.nama')
                    ->get();

                return $row;
            });

        return view('admin.pameran-nomor-stand', compact('menu', 'submenu', 'pameran'));
    }

    /**
     * Tetapkan/ubah nomor stand satu pengajuan yang sudah Diterima — nomor
     * stand harus unik antar pengajuan Diterima (dikonfirmasi developer).
     */
    public function updateNomorStand(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'nomor_stand' => ['required', 'string', 'max:5'],
        ]);

        $nomorStand = trim($validated['nomor_stand']);

        $pameran = DB::table('pameran')
            ->where('idpameran', $validated['idpameran'])
            ->where('status_ajuan', '5')
            ->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran Diterima tidak ditemukan.');
        }

        $adaPenjaga = DB::table('petugas_jaga')->where('idpameran', $pameran->idpameran)->exists();

        if (! $adaPenjaga) {
            return $this->jsonResponse(422, 'Pengajuan ini belum punya penjaga stand. Minimal 1 penjaga stand diperlukan sebelum nomor stand bisa diberikan.');
        }

        $sudahDipakai = DB::table('pameran')
            ->where('status_ajuan', '5')
            ->where('idpameran', '!=', $pameran->idpameran)
            ->whereRaw('LOWER(nomor_stand) = ?', [mb_strtolower($nomorStand)])
            ->exists();

        if ($sudahDipakai) {
            return $this->jsonResponse(422, 'Nomor stand ini sudah dipakai institusi lain.');
        }

        DB::table('pameran')->where('idpameran', $pameran->idpameran)->update([
            'nomor_stand' => $nomorStand,
        ]);

        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Admin menetapkan nomor stand pameran: {$nomorStand}");

        return $this->jsonResponse(200, 'Nomor stand berhasil disimpan.');
    }

    /**
     * Tambah satu penjaga stand — versi admin, dipakai sebagai jalan keluar
     * setelah nomor stand ditetapkan (saat itu peserta sudah tidak bisa lagi
     * mengubah sendiri). Institusi diambil dari baris `pameran`, bukan dari
     * sesi admin — dan tidak ada gerbang status nomor stand di sini.
     */
    public function tambahPenjaga(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpameran' => ['required', 'integer'],
            'idpeserta' => ['required', 'integer'],
        ]);

        $pameran = DB::table('pameran')->where('idpameran', $validated['idpameran'])->where('status_ajuan', '5')->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Pengajuan pameran Diterima tidak ditemukan.');
        }

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $pameran->idinstitusi_asal);

        if (! $peserta) {
            return $this->jsonResponse(422, 'Penjaga stand harus peserta dari institusi asal yang sama dengan pengajuan ini.');
        }

        $jumlahSaatIni = DB::table('petugas_jaga')->where('idpameran', $pameran->idpameran)->count();

        if ($jumlahSaatIni >= 2) {
            return $this->jsonResponse(422, 'Maksimal 2 penjaga stand.');
        }

        $sudahJadiPenjaga = DB::table('petugas_jaga')
            ->where('idpameran', $pameran->idpameran)
            ->where('idpeserta', $validated['idpeserta'])
            ->exists();

        if ($sudahJadiPenjaga) {
            return $this->jsonResponse(422, 'Peserta ini sudah jadi penjaga stand.');
        }

        DB::table('petugas_jaga')->insert([
            'idpameran' => $pameran->idpameran,
            'idpeserta' => $validated['idpeserta'],
        ]);

        $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Admin menambahkan {$peserta->nama} sebagai penjaga stand pameran.");

        return $this->jsonResponse(200, 'Penjaga stand berhasil ditambahkan.');
    }

    /**
     * Hapus satu penjaga stand — versi admin, tanpa batasan institusi sesi
     * (admin boleh menghapus penjaga pameran mana pun).
     */
    public function hapusPenjaga(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpetugas_jaga' => ['required', 'integer'],
        ]);

        $petugas = DB::table('petugas_jaga as pj')
            ->join('pameran as p', 'p.idpameran', '=', 'pj.idpameran')
            ->where('pj.idpetugas_jaga', $validated['idpetugas_jaga'])
            ->select('pj.idpetugas_jaga', 'p.idinstitusi_asal')
            ->first();

        if (! $petugas) {
            return $this->jsonResponse(404, 'Penjaga stand tidak ditemukan.');
        }

        DB::table('petugas_jaga')->where('idpetugas_jaga', $petugas->idpetugas_jaga)->delete();

        $this->logInstitusi($petugas->idinstitusi_asal, $userdata['idpengguna'], 'Admin menghapus satu penjaga stand pameran.');

        return $this->jsonResponse(200, 'Penjaga stand berhasil dihapus.');
    }

    /**
     * Serve a portofolio file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Admin boleh akses kapan pun termasuk saat baris
     * masih Draft (beda dari SC yang menolak status Draft).
     */
    public function tampilPortofolio(Request $request)
    {
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran')->where('idreview', (int) $idreview)->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * The 4-criteria scoring breakdown for one review_pameran row (empty for
     * rows that never reached an SC decision), joined with topik_review for
     * the criteria name.
     */
    private function kriteriaUntukReview(int $idreview)
    {
        return DB::table('isi_review_pameran as i')
            ->join('topik_review as t', 't.idtopik_review', '=', 'i.idtopik_review')
            ->where('i.idreview', $idreview)
            ->select('t.nama_topik', 'i.isi_review', 'i.memenuhi')
            ->orderBy('t.idtopik_review')
            ->get();
    }
}
