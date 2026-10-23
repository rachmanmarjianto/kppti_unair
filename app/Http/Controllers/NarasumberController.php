<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NarasumberController extends Controller
{
    /**
     * Show the pengguna's own narasumber submission — one per pengguna, only
     * visible to the pengguna who submitted it (unlike pameran, this is not
     * shared across a kontingen). Shows an editable form when there's no
     * submission yet, or the current one is Draft/Revisi; otherwise a
     * read-only status + history view.
     */
    public function index()
    {
        $menu = 'narasumber';
        $submenu = '';

        $userdata = session('userdata');

        $narasumber = DB::table('narasumber as n')
            ->leftJoin('acara as a', 'a.idacara', '=', 'n.idacara')
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'a.idparent_acara')
            ->where('n.idpengguna', $userdata['idpengguna'])
            ->select('n.*', 'a.tema as acara_tema', 'a.hari_ke as acara_hari_ke', 'a.jam_mulai as acara_jam_mulai', 'a.jam_akhir as acara_jam_akhir', 'a.ruang as acara_ruang', 'parent.tema as acara_parent_tema')
            ->first();

        $acaraOptions = $this->acaraAktifQuery()
            ->leftJoin('acara as parent', 'parent.idacara', '=', 'acara.idparent_acara')
            ->where('acara.perlu_narsum', true)
            ->select('acara.idacara', 'acara.tema', 'acara.hari_ke', 'acara.jam_mulai', 'acara.jam_akhir', 'acara.ruang', 'parent.tema as parent_tema')
            ->orderBy('acara.hari_ke')
            ->orderBy('acara.jam_mulai')
            ->get();

        $riwayat = collect();
        $draftSaatIni = null;
        $sedangDireview = false;

        if ($narasumber) {
            $semuaRiwayat = DB::table('review_narasumber')
                ->where('idnarasumber', $narasumber->idnarasumber)
                ->orderBy('idreview_narasumber')
                ->get()
                ->map(function ($baris) {
                    $baris->token = $this->encryptRouteValue($baris->idreview_narasumber);
                    $baris->reviewed_at = $this->reviewerTerakhirUntukReviewNarasumber($baris->idreview_narasumber)->created_at ?? null;
                    // '5' (Diterima) berarti baris ini sudah pernah '7' (Proses
                    // Seleksi) lalu diputuskan Master SC — skornya tetap
                    // melekat di baris yang sama (lihat NarasumberReviewController).
                    $baris->kriteria = in_array($baris->status_ajuan, ['4', '5', '6', '7', '8'], true)
                        ? $this->kriteriaUntukReviewNarsum($baris->idreview_narasumber)
                        : collect();

                    return $baris;
                });

            $terakhir = $semuaRiwayat->last();

            if ($terakhir && $terakhir->status_ajuan === '1') {
                $draftSaatIni = $terakhir;
                $riwayat = $semuaRiwayat->slice(0, -1)->values();
            } else {
                $riwayat = $semuaRiwayat;
            }

            $sedangDireview = $terakhir && in_array($terakhir->status_ajuan, ['2', '3'], true);
        }

        $bisaEdit = ! $narasumber || in_array($narasumber->status_ajuan, ['1', '4'], true);

        return view('peserta.narasumber', compact(
            'menu', 'submenu', 'narasumber', 'riwayat', 'sedangDireview', 'draftSaatIni', 'bisaEdit', 'acaraOptions'
        ));
    }

    /**
     * Save (or start) the current draft turn — creates the `narasumber` row
     * on the very first save, and either updates the open Draft row or
     * starts a new one when the previous turn ended in Revisi (mirrors
     * PameranController::simpanDraft()).
     */
    public function simpanDraft(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idacara' => ['required', 'integer'],
            'subtema' => ['required', 'string', 'max:255'],
            'berkas' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $acaraValid = $this->acaraAktifQuery()
            ->where('idacara', $validated['idacara'])
            ->where('perlu_narsum', true)
            ->exists();

        if (! $acaraValid) {
            return $this->jsonResponse(422, 'Sesi acara yang dipilih tidak valid.');
        }

        $narasumber = DB::table('narasumber')->where('idpengguna', $userdata['idpengguna'])->first();

        try {
            DB::transaction(function () use ($request, $validated, $userdata, &$narasumber) {
                if (! $narasumber) {
                    $idnarasumber = DB::table('narasumber')->insertGetId([
                        'idpengguna' => $userdata['idpengguna'],
                        'idacara' => $validated['idacara'],
                        'subtema' => $validated['subtema'],
                        'status_ajuan' => '1',
                    ], 'idnarasumber');

                    $narasumber = DB::table('narasumber')->where('idnarasumber', $idnarasumber)->first();
                } else {
                    DB::table('narasumber')->where('idnarasumber', $narasumber->idnarasumber)->update([
                        'idacara' => $validated['idacara'],
                        'subtema' => $validated['subtema'],
                    ]);
                }

                $terakhir = DB::table('review_narasumber')
                    ->where('idnarasumber', $narasumber->idnarasumber)
                    ->orderByDesc('idreview_narasumber')
                    ->first();

                if ($terakhir && $terakhir->status_ajuan === '1') {
                    $idreview = $terakhir->idreview_narasumber;
                } elseif (! $terakhir || $terakhir->status_ajuan === '4') {
                    $idreview = DB::table('review_narasumber')->insertGetId([
                        'idnarasumber' => $narasumber->idnarasumber,
                        'status_ajuan' => '1',
                        'created_by' => $userdata['idpengguna'],
                        'created_at' => now(),
                    ], 'idreview_narasumber');
                } else {
                    throw new \RuntimeException('Pengajuan ini tidak bisa diubah pada status saat ini.');
                }

                $this->syncNarasumberStatus($narasumber->idnarasumber);

                if ($request->hasFile('berkas')) {
                    $path = $this->simpanBerkasNarasumber($narasumber->idnarasumber, $idreview, $request->file('berkas'));
                    DB::table('review_narasumber')->where('idreview_narasumber', $idreview)->update(['file_path' => $path]);
                } elseif (! $terakhir || $terakhir->status_ajuan !== '1' || ! $terakhir->file_path) {
                    throw new \RuntimeException('Extended Abstract (PDF/DOC/DOCX) wajib diunggah.');
                }

                $idpeserta = DB::table('peserta')->where('idpengguna', $userdata['idpengguna'])->value('idpeserta');

                if ($idpeserta) {
                    $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], 'Menyimpan draf pengajuan narasumber');
                }
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(422, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menyimpan draf pengajuan narasumber.');
        }

        return $this->jsonResponse(200, 'Draf pengajuan narasumber berhasil disimpan.');
    }

    /**
     * Submit the open Draft turn — moves it to Pengajuan. No tagihan is
     * involved (narasumber submissions are free). The jadwal_penting(2)
     * ("Pengajuan Narasumber") window only gates the very first-ever
     * submission — revision resubmissions remain ungated, mirroring
     * PameranController::ajukan().
     */
    public function ajukan(Request $request)
    {
        $userdata = session('userdata');

        $narasumber = DB::table('narasumber')->where('idpengguna', $userdata['idpengguna'])->first();

        if (! $narasumber) {
            return $this->jsonResponse(404, 'Belum ada pengajuan narasumber untuk diajukan.');
        }

        $draft = DB::table('review_narasumber')
            ->where('idnarasumber', $narasumber->idnarasumber)
            ->orderByDesc('idreview_narasumber')
            ->first();

        if (! $draft || $draft->status_ajuan !== '1') {
            return $this->jsonResponse(422, 'Tidak ada draf yang bisa diajukan saat ini.');
        }

        if (! $narasumber->idacara || ! $narasumber->subtema || ! $draft->file_path) {
            return $this->jsonResponse(422, 'Lengkapi sesi, subtema, dan Extended Abstract sebelum mengajukan.');
        }

        $sudahPernahDiajukan = DB::table('review_narasumber')->where('idnarasumber', $narasumber->idnarasumber)->count() > 1;

        if (! $sudahPernahDiajukan && ! $this->jadwalSedangBuka(2)) {
            return $this->jsonResponse(422, 'Sesi pengajuan narasumber sedang ditutup. Pengajuan awal hanya bisa dilakukan dalam periode yang ditentukan panitia.');
        }

        DB::transaction(function () use ($narasumber, $draft, $userdata) {
            DB::table('review_narasumber')->where('idreview_narasumber', $draft->idreview_narasumber)->update(['status_ajuan' => '2']);
            $this->syncNarasumberStatus($narasumber->idnarasumber);

            $idpeserta = DB::table('peserta')->where('idpengguna', $userdata['idpengguna'])->value('idpeserta');

            if ($idpeserta) {
                $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], 'Mengajukan narasumber');
            }
        });

        $pesan = $sudahPernahDiajukan
            ? 'Pengajuan narasumber berhasil dikirim ulang untuk direview SC.'
            : 'Pengajuan narasumber berhasil dikirim untuk direview SC.';

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Batalkan pengajuan (Pengajuan → Draft kembali) — hanya boleh selama
     * status_ajuan masih '2' (belum masuk Review). Mirip
     * `PameranController::batalkanAjuan()`, tapi tidak ada tagihan yang
     * perlu dibatalkan (pengajuan narasumber tidak ditagih, lihat
     * `ajukan()`).
     */
    public function batalkanAjuan(Request $request)
    {
        $userdata = session('userdata');

        $narasumber = DB::table('narasumber')->where('idpengguna', $userdata['idpengguna'])->first();

        if (! $narasumber || $narasumber->status_ajuan !== '2') {
            return $this->jsonResponse(422, 'Pengajuan ini tidak bisa dibatalkan pada status saat ini.');
        }

        $terakhir = DB::table('review_narasumber')
            ->where('idnarasumber', $narasumber->idnarasumber)
            ->orderByDesc('idreview_narasumber')
            ->first();

        if (! $terakhir || $terakhir->status_ajuan !== '2') {
            return $this->jsonResponse(422, 'Pengajuan ini tidak bisa dibatalkan pada status saat ini.');
        }

        try {
            DB::transaction(function () use ($narasumber, $terakhir, $userdata) {
                $diperbarui = DB::table('review_narasumber')
                    ->where('idreview_narasumber', $terakhir->idreview_narasumber)
                    ->where('status_ajuan', '2')
                    ->update(['status_ajuan' => '1']);

                if ($diperbarui === 0) {
                    throw new \RuntimeException('Pengajuan ini sudah diproses.');
                }

                $this->syncNarasumberStatus($narasumber->idnarasumber);

                $idpeserta = DB::table('peserta')->where('idpengguna', $userdata['idpengguna'])->value('idpeserta');

                if ($idpeserta) {
                    $this->logPeserta((int) $idpeserta, $userdata['idpengguna'], 'Membatalkan pengajuan narasumber, kembali ke Draft');
                }
            });
        } catch (\RuntimeException $e) {
            return $this->jsonResponse(409, $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal membatalkan pengajuan.');
        }

        return $this->jsonResponse(200, 'Pengajuan berhasil dikembalikan ke Draft.');
    }

    /**
     * Serve a berkas file — never exposed as a static public URL
     * (CONVENTIONS.md §7). Scoped to the pengguna that owns the narasumber
     * submission (individual, not kontingen-wide like pameran).
     */
    public function tampilBerkas(Request $request)
    {
        $userdata = session('userdata');
        $idreview = $this->decryptRouteValue($request->query('token'));

        if ($idreview === null) {
            abort(404);
        }

        $review = DB::table('review_narasumber as r')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'r.idnarasumber')
            ->where('r.idreview_narasumber', (int) $idreview)
            ->where('n.idpengguna', $userdata['idpengguna'])
            ->select('r.file_path')
            ->first();

        if (! $review || ! $review->file_path || ! Storage::disk('local')->exists($review->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($review->file_path);
    }

    /**
     * Unduh pedoman penulisan Extended Abstract — berkas statis bersama
     * untuk semua peserta, disimpan di `storage/app/private/dokumen-template/`
     * (pola sama seperti PameranController::unduhTemplate()).
     */
    public function unduhPedoman()
    {
        $namaFile = 'DRAFT_PEDOMAN_PENULISAN_EXTENDED_ABSTRACT.docx';
        $path = "dokumen-template/{$namaFile}";

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $namaFile);
    }

    /**
     * Store an uploaded berkas file on the private `local` disk, keyed
     * deterministically by idnarasumber+idreview so re-uploading within the
     * same draft turn simply overwrites it (no stale leftover file).
     */
    private function simpanBerkasNarasumber(int $idnarasumber, int $idreview, UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = "berkas-narasumber/narasumber-{$idnarasumber}-{$idreview}.{$ext}";

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }
}
