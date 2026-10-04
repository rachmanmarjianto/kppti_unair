<?php

namespace App\Http\Controllers;

use App\Services\BniVirtualAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PameranController extends Controller
{
    /**
     * Placeholder nominal tagihan pameran — belum ditentukan panitia
     * (lihat docs/features/007-pengajuan-pameran.md §10). Tidak menghambat
     * kerangka tagihan, tinggal diubah kapan saja setelah nominal pasti.
     */
    private const NOMINAL_TAGIHAN_PAMERAN = 0;

    /**
     * Show the kontingen's pameran submission — one per institusi. Shows an
     * editable form when there's no submission yet, or the current one is
     * Draft/Revisi; otherwise a read-only status + history view. The last
     * history row is hidden entirely while an SC is still composing their
     * decision (status Review) — see docs/features/007-pengajuan-pameran.md §6.
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = '';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->first();

        $pesertaOptions = $this->pesertaAktifQuery($idInstitusiAsal)
            ->select('pe.idpeserta', 'p.nama')
            ->orderBy('p.nama')
            ->get();

        $riwayat = collect();
        $sedangDireview = false;
        $draftSaatIni = null;

        if ($pameran) {
            $semuaRiwayat = DB::table('review_pameran')
                ->where('idpameran', $pameran->idpameran)
                ->orderBy('idreview')
                ->get()
                ->map(function ($baris) {
                    $baris->token = $this->encryptRouteValue($baris->idreview);
                    $baris->kriteria = $this->kriteriaUntukReview($baris->idreview);

                    return $baris;
                });

            $terakhir = $semuaRiwayat->last();

            if ($terakhir && $terakhir->status_ajuan === '3') {
                $sedangDireview = true;
                $riwayat = $semuaRiwayat->slice(0, -1)->values();
            } elseif ($terakhir && $terakhir->status_ajuan === '1') {
                $draftSaatIni = $terakhir;
                $riwayat = $semuaRiwayat->slice(0, -1)->values();
            } else {
                $riwayat = $semuaRiwayat;
            }
        }

        $bisaEdit = ! $pameran || in_array($pameran->status_ajuan, ['1', '4'], true);

        return view('peserta.pameran', compact(
            'menu', 'submenu', 'pameran', 'pesertaOptions', 'riwayat',
            'sedangDireview', 'draftSaatIni', 'bisaEdit'
        ));
    }

    /**
     * Save (or start) the current draft turn — creates the `pameran` row on
     * the very first save, and either updates the open Draft row or starts a
     * new one when the previous turn ended in Revisi (see
     * docs/features/007-pengajuan-pameran.md §8).
     */
    public function simpanDraft(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $validated = $request->validate([
            'idpeserta_PIC' => ['required', 'integer'],
            'tema' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'portofolio' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $validated['abstract'] = $this->sanitizeRichText($validated['abstract']);

        $pic = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta_PIC'], $idInstitusiAsal);

        if (! $pic) {
            return $this->jsonResponse(422, 'PIC harus peserta dari kontingen Anda sendiri.');
        }

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        try {
            DB::transaction(function () use ($request, $validated, $idInstitusiAsal, $userdata, &$pameran) {
                if (! $pameran) {
                    $idpameran = DB::table('pameran')->insertGetId([
                        'idinstitusi_asal' => $idInstitusiAsal,
                        'tema' => $validated['tema'],
                        'abstract' => $validated['abstract'],
                        'idpeserta_PIC' => $validated['idpeserta_PIC'],
                        'status_ajuan' => '1',
                    ], 'idpameran');

                    $pameran = DB::table('pameran')->where('idpameran', $idpameran)->first();
                } else {
                    DB::table('pameran')->where('idpameran', $pameran->idpameran)->update([
                        'tema' => $validated['tema'],
                        'abstract' => $validated['abstract'],
                        'idpeserta_PIC' => $validated['idpeserta_PIC'],
                        'status_ajuan' => '1',
                    ]);
                }

                $terakhir = DB::table('review_pameran')
                    ->where('idpameran', $pameran->idpameran)
                    ->orderByDesc('idreview')
                    ->first();

                if ($terakhir && $terakhir->status_ajuan === '1') {
                    $idreview = $terakhir->idreview;
                } elseif (! $terakhir || $terakhir->status_ajuan === '4') {
                    $idreview = DB::table('review_pameran')->insertGetId([
                        'idpameran' => $pameran->idpameran,
                        'status_ajuan' => '1',
                        'created_by' => $userdata['idpengguna'],
                        'created_at' => now(),
                    ], 'idreview');
                } else {
                    throw new \RuntimeException('Pengajuan ini tidak bisa diubah pada status saat ini.');
                }

                if ($request->hasFile('portofolio')) {
                    $path = $this->simpanPortofolioPameran($pameran->idpameran, $idreview, $request->file('portofolio'));
                    DB::table('review_pameran')->where('idreview', $idreview)->update(['file_path' => $path]);
                } elseif (! $terakhir || $terakhir->status_ajuan !== '1' || ! $terakhir->file_path) {
                    throw new \RuntimeException('Portofolio (PDF/DOC/DOCX) wajib diunggah.');
                }

                $this->logInstitusi($pameran->idinstitusi_asal, $userdata['idpengguna'], "Menyimpan draf pengajuan pameran: {$validated['tema']}");
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menyimpan draf pengajuan pameran.');
        }

        return $this->jsonResponse(200, 'Draf pengajuan pameran berhasil disimpan.');
    }

    /**
     * Submit the open Draft turn — moves it to Pengajuan and issues a
     * tagihan (first submission only; later Revisi→Pengajuan cycles reuse
     * the same tagihan, see docs/features/007-pengajuan-pameran.md §4).
     */
    public function ajukan(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pameran = DB::table('pameran')->where('idinstitusi_asal', $idInstitusiAsal)->first();

        if (! $pameran) {
            return $this->jsonResponse(404, 'Belum ada pengajuan pameran untuk diajukan.');
        }

        $draft = DB::table('review_pameran')
            ->where('idpameran', $pameran->idpameran)
            ->orderByDesc('idreview')
            ->first();

        if (! $draft || $draft->status_ajuan !== '1') {
            return $this->jsonResponse(422, 'Tidak ada draf yang bisa diajukan saat ini.');
        }

        if (! $pameran->tema || ! $pameran->abstract || ! $pameran->idpeserta_PIC || ! $draft->file_path) {
            return $this->jsonResponse(422, 'Lengkapi tema, abstrak, PIC, dan portofolio sebelum mengajukan.');
        }

        DB::transaction(function () use ($pameran, $draft, $idInstitusiAsal, $userdata) {
            DB::table('review_pameran')->where('idreview', $draft->idreview)->update(['status_ajuan' => '2']);
            DB::table('pameran')->where('idpameran', $pameran->idpameran)->update(['status_ajuan' => '2']);

            $tagihan = DB::table('tagihan')->where('idpameran', $pameran->idpameran)->first();

            if (! $tagihan) {
                $idtagihan = DB::table('tagihan')->insertGetId([
                    'idinstitusi_asal' => $idInstitusiAsal,
                    'idpameran' => $pameran->idpameran,
                    'created_at' => now(),
                    'created_by' => $userdata['idpengguna'],
                    'status' => 1,
                    'tagihan' => self::NOMINAL_TAGIHAN_PAMERAN,
                    'sisa_tagihan' => self::NOMINAL_TAGIHAN_PAMERAN,
                ], 'idtagihan');

                $tagihan = DB::table('tagihan')->where('idtagihan', $idtagihan)->first();

                app(BniVirtualAccountService::class)->requestVa($tagihan);
            }

            $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], "Mengajukan pameran: {$pameran->tema}");
        });

        return $this->jsonResponse(200, 'Pengajuan pameran berhasil dikirim. Silakan selesaikan pembayaran agar bisa direview SC.');
    }

    /**
     * Serve a portofolio file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Scoped to the kontingen that owns the pameran;
     * SC/admin access the same file via their own controllers.
     */
    public function tampilPortofolio(Request $request)
    {
        $userdata = session('userdata');
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_pameran as r')
            ->join('pameran as p', 'p.idpameran', '=', 'r.idpameran')
            ->where('r.idreview', (int) $idreview)
            ->where('p.idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->select('r.file_path')
            ->first();

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

    /**
     * Store an uploaded portofolio file on the private `local` disk, keyed
     * deterministically by idpameran+idreview so re-uploading within the
     * same draft turn simply overwrites it (no stale leftover file).
     */
    private function simpanPortofolioPameran(int $idpameran, int $idreview, UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "portofolio-pameran/pameran-{$idpameran}-{$idreview}.{$ext}";

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }
}
