<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PetugasMejaRegisController extends Controller
{
    /**
     * `antrian_regis.status` — kode numerik, lihat comment kolom di skema
     * (`kppti_33.sql`) dan docs/features/019-registrasi-antrian-kontingen.md §2.1.
     */
    private const STATUS_ANTRI = '1';

    private const STATUS_DIPANGGIL = '2';

    private const STATUS_DILAYANI = '3';

    private const STATUS_TERLAYANI = '4';

    private const STATUS_TERLEWAT = '5';

    private const LABEL_STATUS = [
        self::STATUS_ANTRI => 'Antri',
        self::STATUS_DIPANGGIL => 'Dipanggil',
        self::STATUS_DILAYANI => 'Sedang Dilayani',
        self::STATUS_TERLAYANI => 'Terlayani',
        self::STATUS_TERLEWAT => 'Terlewat',
    ];

    /**
     * Satu-satunya menu "Panggil Antrian" milik role Petugas Meja
     * Registrasi (F19). Menampilkan kartu antrian yang sedang
     * ditangani petugas ini (kalau ada), atau daftar antrian untuk
     * dipanggil.
     */
    public function index()
    {
        $menu = 'panggil-antrian';
        $submenu = '';

        $mejaRegis = $this->mejaRegisUntukPetugas();
        $kartuAktif = $mejaRegis ? $this->dataKartuAktif($mejaRegis) : null;
        $listDepan = ($mejaRegis && ! $kartuAktif) ? $this->dataListDepan() : ['antrianList' => collect(), 'terlewatList' => collect()];
        $antrianList = $listDepan['antrianList'];
        $terlewatList = $listDepan['terlewatList'];

        return view('petugas-meja-regis.index', compact('menu', 'submenu', 'mejaRegis', 'kartuAktif', 'antrianList', 'terlewatList'));
    }

    /**
     * AJAX — muat ulang list Antri + Terlewat tanpa reload halaman (tombol
     * "Refresh Antrian" di tampilan depan).
     */
    public function refreshList()
    {
        return $this->jsonResponse(200, 'Berhasil.', $this->dataListDepan());
    }

    /**
     * Panggil antrian — tanpa `token` mengambil antrian teratas (nomor
     * terkecil berstatus Antri), dengan `token` memanggil institusi
     * spesifik yang diklik dari list Antri **atau** list Terlewat (baris
     * Terlewat yang diklik lagi dipanggil ulang lewat jalur yang sama).
     * Race-condition-safe: dua petugas tidak bisa memanggil antrian yang
     * sama (lihat komentar di dalam transaksi untuk detail penguncian).
     */
    public function panggil(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun. Hubungi Admin.');
        }

        $validated = $request->validate([
            'token' => ['nullable', 'string'],
        ]);

        $idAntrianDiminta = null;

        if (! empty($validated['token'])) {
            $idAntrianDiminta = $this->decryptRouteValue($validated['token']);

            if ($idAntrianDiminta === null) {
                return $this->jsonResponse(404, 'Antrian tidak ditemukan.');
            }

            $idAntrianDiminta = (int) $idAntrianDiminta;
        }

        $error = null;

        DB::transaction(function () use ($mejaRegis, $idAntrianDiminta, &$error) {
            // Advisory lock diskop ke meja ini — menyerialkan klik "panggil"
            // ganda dari petugas yang sama (mis. double-click), pola yang
            // sama dengan AntrianRegisController::ambilNomor().
            DB::select('SELECT pg_advisory_xact_lock(?)', [crc32('meja-regis-'.$mejaRegis->idmeja_regis)]);

            $sedangAktif = DB::table('antrian_regis')
                ->where('dipanggil_oleh', $mejaRegis->idmeja_regis)
                ->whereIn('status', [self::STATUS_DIPANGGIL, self::STATUS_DILAYANI])
                ->whereDate('created_at', today())
                ->exists();

            if ($sedangAktif) {
                $error = 'Anda masih memiliki antrian aktif. Selesaikan dulu sebelum memanggil antrian lain.';

                return;
            }

            if ($idAntrianDiminta !== null) {
                // Klaim institusi spesifik — lock baris ini (bukan skip
                // locked) karena target sudah pasti, bukan "ambil yang mana
                // pun kosong": kalau sedang dikunci petugas lain yang
                // memproses institusi yang sama, tunggu sebentar lalu cek
                // ulang statusnya setelah lock didapat.
                $baris = DB::table('antrian_regis')
                    ->where('idantrian_regis', $idAntrianDiminta)
                    ->whereDate('created_at', today())
                    ->lockForUpdate()
                    ->first();

                if (! $baris) {
                    $error = 'Antrian tidak ditemukan.';

                    return;
                }

                // Boleh mengklaim baris berstatus Antri (dari list biasa)
                // maupun Terlewat (dipanggil ulang dari list Terlewat) —
                // status lain (sudah dipanggil/dilayani/terlayani petugas
                // lain) ditolak.
                if (! in_array($baris->status, [self::STATUS_ANTRI, self::STATUS_TERLEWAT], true)) {
                    $error = 'Antrian ini sudah dipanggil petugas lain. Silakan pilih antrian lain.';

                    return;
                }

                $idAntrian = $baris->idantrian_regis;
            } else {
                // Ambil antrian teratas — SKIP LOCKED supaya petugas lain
                // yang memanggil di saat bersamaan langsung mendapat
                // antrian berikutnya yang masih bebas, bukan menunggu atau
                // berebut baris yang sama.
                $slot = DB::selectOne(
                    'SELECT idantrian_regis FROM antrian_regis WHERE status = ? AND created_at::date = CURRENT_DATE ORDER BY nomor_antrian LIMIT 1 FOR UPDATE SKIP LOCKED',
                    [self::STATUS_ANTRI]
                );

                if (! $slot) {
                    $error = 'Tidak ada antrian yang menunggu saat ini.';

                    return;
                }

                $idAntrian = $slot->idantrian_regis;
            }

            DB::table('antrian_regis')->where('idantrian_regis', $idAntrian)->update([
                'status' => self::STATUS_DIPANGGIL,
                'dipanggil_oleh' => $mejaRegis->idmeja_regis,
                'panggilan_ke' => 1,
            ]);
        });

        if ($error !== null) {
            return $this->jsonResponse(409, $error);
        }

        return $this->jsonResponse(200, 'Antrian berhasil dipanggil.', $this->dataKartuAktif($mejaRegis));
    }

    /**
     * "Panggil Lagi" — tidak mengubah status, hanya increment
     * `panggilan_ke` supaya Halaman 2 (SSE) tahu harus memutar ulang
     * efek bel+TTS.
     */
    public function panggilUlang(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $baris = $this->antrianAktifMilikPetugas($mejaRegis, self::STATUS_DIPANGGIL);

        if (! $baris) {
            return $this->jsonResponse(404, 'Tidak ada antrian yang sedang dipanggil oleh Anda.');
        }

        DB::table('antrian_regis')->where('idantrian_regis', $baris->idantrian_regis)->update([
            'panggilan_ke' => $baris->panggilan_ke + 1,
        ]);

        return $this->jsonResponse(200, 'Panggilan diulang.', $this->dataKartuAktif($mejaRegis));
    }

    /**
     * Tandai antrian yang sedang ditangani petugas ini (Dipanggil maupun
     * Sedang Dilayani — tombol "Lewati" ada di kedua layar, lihat
     * docs/features) sebagai Terlewat — petugas kembali ke tampilan depan
     * untuk memanggil antrian lain. Dipakai juga saat perlengkapan (mis.
     * seminar kit) kurang di tengah layanan, supaya perwakilan diminta
     * menunggu lagi dan dipanggil ulang nanti.
     */
    public function terlewat(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $baris = $this->antrianAktifMilikPetugas($mejaRegis, [self::STATUS_DIPANGGIL, self::STATUS_DILAYANI]);

        if (! $baris) {
            return $this->jsonResponse(404, 'Tidak ada antrian yang sedang dipanggil oleh Anda.');
        }

        DB::table('antrian_regis')->where('idantrian_regis', $baris->idantrian_regis)->update([
            'status' => self::STATUS_TERLEWAT,
        ]);

        return $this->jsonResponse(200, 'Antrian ditandai terlewat.', $this->dataListDepan());
    }

    /**
     * "Layani" — status Dipanggil → Sedang Dilayani, lalu tampilkan
     * checklist kehadiran peserta kontingen ini.
     */
    public function layani(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $baris = $this->antrianAktifMilikPetugas($mejaRegis, self::STATUS_DIPANGGIL);

        if (! $baris) {
            return $this->jsonResponse(404, 'Tidak ada antrian yang sedang dipanggil oleh Anda.');
        }

        DB::table('antrian_regis')->where('idantrian_regis', $baris->idantrian_regis)->update([
            'status' => self::STATUS_DILAYANI,
        ]);

        return $this->jsonResponse(200, 'Mulai melayani kontingen.', $this->dataKartuAktif($mejaRegis));
    }

    /**
     * Checkbox kehadiran peserta — langsung AJAX per-item, pola sama
     * dengan `PetugasKitController::toggleKit()`.
     */
    public function toggleHadir(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'checked' => ['required', 'boolean'],
        ]);

        $antrianAktif = $this->antrianAktifMilikPetugas($mejaRegis, self::STATUS_DILAYANI);

        if (! $antrianAktif) {
            return $this->jsonResponse(404, 'Tidak ada institusi yang sedang dilayani oleh Anda.');
        }

        // Otorisasi: peserta yang dicentang harus benar dari institusi yang
        // sedang dilayani petugas ini, bukan sembarang idpeserta.
        $milikInstitusi = DB::table('peserta as pe')
            ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
            ->where('pe.idpeserta', $validated['idpeserta'])
            ->where('p.idinstitusi_asal', $antrianAktif->idinstitusi_asal)
            ->exists();

        if (! $milikInstitusi) {
            return $this->jsonResponse(403, 'Peserta ini bukan bagian dari kontingen yang sedang dilayani.');
        }

        DB::table('peserta')->where('idpeserta', $validated['idpeserta'])->update([
            'hadir' => $validated['checked'],
        ]);

        return $this->jsonResponse(200, 'Kehadiran berhasil diperbarui.');
    }

    /**
     * "Selesai Layani" — status Sedang Dilayani → Terlayani, petugas
     * kembali ke tampilan depan.
     */
    public function selesaiLayani(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $baris = $this->antrianAktifMilikPetugas($mejaRegis, self::STATUS_DILAYANI);

        if (! $baris) {
            return $this->jsonResponse(404, 'Tidak ada institusi yang sedang dilayani oleh Anda.');
        }

        DB::table('antrian_regis')->where('idantrian_regis', $baris->idantrian_regis)->update([
            'status' => self::STATUS_TERLAYANI,
        ]);

        return $this->jsonResponse(200, 'Layanan selesai.', $this->dataListDepan());
    }

    /**
     * AJAX — daftar antrian hari ini yang sudah Terlayani oleh petugas
     * ini, untuk modal "Riwayat Dilayani".
     */
    public function riwayatDilayani()
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            return $this->jsonResponse(422, 'Anda belum dipetakan ke meja registrasi mana pun.');
        }

        $riwayat = DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->where('ar.dipanggil_oleh', $mejaRegis->idmeja_regis)
            ->where('ar.status', self::STATUS_TERLAYANI)
            ->whereDate('ar.created_at', today())
            ->orderByDesc('ar.created_at')
            ->select('ar.idantrian_regis', 'ar.nomor_antrian', 'ar.status', 'ar.created_at', 'ia.nama_institusi')
            ->get()
            ->map(function ($baris) {
                $baris->status_label = self::LABEL_STATUS[$baris->status] ?? '-';

                return $baris;
            });

        return $this->jsonResponse(200, 'Berhasil.', $riwayat);
    }

    /**
     * Preview PDF daftar hadir di tab baru (nama institusi + list peserta +
     * kolom centang kosong untuk ditandatangani manual) — `stream()`, bukan
     * `download()`, supaya tampil langsung di browser (link dibuka dengan
     * `target="_blank"`), baru diunduh manual oleh petugas kalau perlu.
     */
    public function unduhPdfDaftarHadir(Request $request)
    {
        $mejaRegis = $this->mejaRegisUntukPetugas();

        if (! $mejaRegis) {
            abort(404);
        }

        $antrianAktif = $this->antrianAktifMilikPetugas($mejaRegis, self::STATUS_DILAYANI);

        if (! $antrianAktif) {
            abort(404);
        }

        $institusi = DB::table('institusi_asal')->where('idinstitusi_asal', $antrianAktif->idinstitusi_asal)->first();

        $pesertaList = $this->pesertaAktifQuery($antrianAktif->idinstitusi_asal)
            ->select('p.nama')
            ->orderBy('p.nama')
            ->get();

        return Pdf::loadView('petugas-meja-regis.daftar-hadir-pdf', [
            'namaInstitusi' => $institusi->nama_institusi,
            'pesertaList' => $pesertaList,
        ])->setPaper('a4', 'portrait')->stream('daftar-hadir-'.$institusi->kode_kontingen.'.pdf');
    }

    /**
     * Baris `meja_regis` milik petugas yang sedang login, atau null kalau
     * belum dipetakan Admin ke meja mana pun (lihat menu "Kedatangan
     * Kontingen → Petugas Meja").
     */
    private function mejaRegisUntukPetugas(): ?object
    {
        $idpengguna = session('userdata')['idpengguna'];

        return DB::table('meja_regis')->where('idpengguna', $idpengguna)->first();
    }

    /**
     * Baris `antrian_regis` hari ini yang dipanggil oleh meja ini dan
     * masih berstatus $status (satu status atau beberapa) — dipakai
     * berulang oleh panggilUlang(), terlewat(), layani(), toggleHadir(),
     * selesaiLayani().
     *
     * @param  string|array<int, string>  $status
     */
    private function antrianAktifMilikPetugas(object $mejaRegis, string|array $status): ?object
    {
        return DB::table('antrian_regis')
            ->where('dipanggil_oleh', $mejaRegis->idmeja_regis)
            ->whereIn('status', is_array($status) ? $status : [$status])
            ->whereDate('created_at', today())
            ->first();
    }

    /**
     * Data kartu antrian yang sedang ditangani petugas ini (status
     * Dipanggil atau Sedang Dilayani) — dipakai index() dan re-render
     * setelah setiap aksi AJAX. Null kalau petugas tidak punya antrian
     * aktif (tampilan depan harus menunjukkan list, bukan kartu).
     * `pesertaList` (hanya diisi saat status Sedang Dilayani) membawa
     * `isNarasumberDiterima` dan `isPetugasJaga` — pola sama seperti
     * Tapping Card (lihat `Controller::idPenggunaNarasumberDiterima()`).
     */
    private function dataKartuAktif(object $mejaRegis): ?array
    {
        $baris = DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->where('ar.dipanggil_oleh', $mejaRegis->idmeja_regis)
            ->whereIn('ar.status', [self::STATUS_DIPANGGIL, self::STATUS_DILAYANI])
            ->whereDate('ar.created_at', today())
            ->select('ar.idantrian_regis', 'ar.idinstitusi_asal', 'ar.nomor_antrian', 'ar.status', 'ar.panggilan_ke', 'ia.nama_institusi')
            ->first();

        if (! $baris) {
            return null;
        }

        $pesertaList = collect();

        if ($baris->status === self::STATUS_DILAYANI) {
            $pesertaList = $this->pesertaAktifQuery($baris->idinstitusi_asal)
                ->select('pe.idpeserta', 'p.idpengguna', 'p.nama', 'pe.hadir', 'pe.path_foto')
                ->orderBy('p.nama')
                ->get();

            $idPenggunaNarasumber = $this->idPenggunaNarasumberDiterima();

            $idPesertaJaga = DB::table('petugas_jaga')
                ->whereIn('idpeserta', $pesertaList->pluck('idpeserta'))
                ->pluck('idpeserta')
                ->unique();

            $pesertaList = $pesertaList->map(function ($peserta) use ($idPenggunaNarasumber, $idPesertaJaga) {
                $peserta->fotoLengkap = $peserta->path_foto !== null;
                $peserta->isNarasumberDiterima = $idPenggunaNarasumber->contains($peserta->idpengguna);
                $peserta->isPetugasJaga = $idPesertaJaga->contains($peserta->idpeserta);

                return $peserta;
            });
        }

        return [
            'idantrian_regis' => $baris->idantrian_regis,
            'nama_institusi' => $baris->nama_institusi,
            'nomor_antrian' => $baris->nomor_antrian,
            'status' => $baris->status,
            'status_label' => self::LABEL_STATUS[$baris->status] ?? '-',
            'panggilan_ke' => $baris->panggilan_ke,
            'nomor_meja' => $mejaRegis->nomor_meja,
            'pesertaList' => $pesertaList,
        ];
    }

    /**
     * Tampilan depan lengkap: list Antri + list Terlewat, dipakai index()
     * dan dikembalikan ulang oleh terlewat()/selesaiLayani() supaya kedua
     * list di layar langsung sinkron tanpa perlu reload.
     *
     * @return array{antrianList: Collection<int, object>, terlewatList: Collection<int, object>}
     */
    private function dataListDepan(): array
    {
        return [
            'antrianList' => $this->dataAntrianAtauTerlewatList(self::STATUS_ANTRI),
            'terlewatList' => $this->dataAntrianAtauTerlewatList(self::STATUS_TERLEWAT),
        ];
    }

    /**
     * List antrian hari ini dengan status tertentu (Antri atau Terlewat) —
     * keduanya ditampilkan di tampilan depan dan baris mana pun di
     * keduanya bisa diklik untuk dipanggil lewat panggil() dengan token.
     *
     * @return Collection<int, object>
     */
    private function dataAntrianAtauTerlewatList(string $status): Collection
    {
        return DB::table('antrian_regis as ar')
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'ar.idinstitusi_asal')
            ->whereDate('ar.created_at', today())
            ->where('ar.status', $status)
            ->orderBy('ar.nomor_antrian')
            ->select('ar.idantrian_regis', 'ar.nomor_antrian', 'ia.nama_institusi')
            ->get()
            ->map(function ($baris) {
                $baris->token = $this->encryptRouteValue($baris->idantrian_regis);

                return $baris;
            });
    }
}
