<?php

namespace App\Http\Controllers;

use App\Services\BniVirtualAccountService;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Role IDs, per the `role` reference table.
     */
    private const ROLE_PESERTA = 2;

    /**
     * Redirect target (route name) per active role. Role 3 (Nara Sumber)
     * doesn't have an area built yet. Shared by LoginController (initial
     * redirect after login) and PenggunaController (switching active role
     * from the profile page).
     *
     * @var array<int, string>
     */
    protected const HOME_BY_ROLE = [
        1 => 'admin.home',
        2 => 'peserta.home',
        4 => 'sc.pameran',
        5 => 'petugas-kit.home',
    ];

    /**
     * Standard JSON response shape for this app's AJAX endpoints:
     * `code` (HTTP status code), `status` (its text interpretation),
     * `message`, and `data` (the endpoint's payload, if any — null otherwise).
     */
    protected function jsonResponse(int $code, string $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => Response::$statusTexts[$code] ?? '',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Encrypt a value (AES-256, via Laravel's Crypt facade) for use as a GET
     * query-string value — per CONVENTIONS.md §7, GET requests never carry raw
     * identifiers. The output is remapped to be URL-safe (`+`/`/` cause issues
     * in query strings) and padding-stripped; `decryptRouteValue()` reverses it.
     */
    protected function encryptRouteValue(int|string $value): string
    {
        return rtrim(strtr(Crypt::encryptString((string) $value), '+/', '-_'), '=');
    }

    /**
     * Decrypt a value produced by `encryptRouteValue()`. Returns null (instead of
     * throwing) when the token is missing, malformed, or tampered with — callers
     * should treat that the same as "not found" (404), never a server error.
     */
    protected function decryptRouteValue(?string $token): ?string
    {
        if (! $token) {
            return null;
        }

        $base64 = strtr($token, '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);

        try {
            return Crypt::decryptString($base64);
        } catch (DecryptException) {
            return null;
        }
    }

    /**
     * Check whether $otp is the code from the most recently sent token row for
     * $no_wa (not just "any matching row"), optionally also requiring it to be
     * no older than $maxAgeSeconds. Shared by the Admin OTP check and the
     * peserta registration OTP check — they only differ on $maxAgeSeconds.
     */
    protected function isOtpValid(string $no_wa, string $otp, ?int $maxAgeSeconds = null): bool
    {
        $latestToken = DB::table('token')
            ->where('no_wa', $no_wa)
            ->orderByDesc('created_at')
            ->first();

        if (! $latestToken || $latestToken->token !== $otp) {
            return false;
        }

        if ($maxAgeSeconds !== null && abs(now()->diffInSeconds($latestToken->created_at)) > $maxAgeSeconds) {
            return false;
        }

        return true;
    }

    protected function generateRandomToken(int $length = 6): string
    {
        $characters = '1234567890';
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $token;
    }

    /**
     * Generate a random password that always satisfies
     * `Password::min(8)->mixedCase()->numbers()->symbols()`, excluding characters
     * that are easily confused with each other (`l`/`I`, `0`/`O`).
     */
    protected function generateRandomPassword(int $length = 8): string
    {
        $lower = 'abcdefghijkmnpqrstuvwxyz';
        $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $numbers = '123456789';
        $symbols = '!@#$&?';
        // $symbols = '!@';
        $all = $lower.$upper.$numbers.$symbols;

        $password = [
            $lower[random_int(0, strlen($lower) - 1)],
            $upper[random_int(0, strlen($upper) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $symbols[random_int(0, strlen($symbols) - 1)],
        ];

        for ($i = count($password); $i < $length; $i++) {
            $password[] = $all[random_int(0, strlen($all) - 1)];
        }

        shuffle($password);

        return implode('', $password);
    }

    /**
     * Record an activity against an institusi_asal row in log_institusi.
     */
    protected function logInstitusi(int $idInstitusiAsal, ?int $doneBy, string $aktifitas): void
    {
        DB::table('log_institusi')->insert([
            'idinstitusi_asal' => $idInstitusiAsal,
            'aktifitas' => $aktifitas,
            'done_at' => now(),
            'done_by' => $doneBy,
        ]);
    }

    /**
     * Record an activity against a peserta row in log_peserta.
     */
    protected function logPeserta(int $idPeserta, ?int $doneBy, string $aktifitas): void
    {
        DB::table('log_peserta')->insert([
            'idpeserta' => $idPeserta,
            'aktifitas' => $aktifitas,
            'done_at' => now(),
            'done_by' => $doneBy,
        ]);
    }

    protected function kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $hp)
    {
        try {
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, 'https://h2h.unair.ac.id/token/ambil-token-v2');
            curl_setopt($ch2, CURLOPT_POST, 1);
            $param = [
                'user' => config('services.h2h.user'),
                'key' => config('services.h2h.key'),
            ];
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $param);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($ch2);

            if ($response === false) {
                throw new \RuntimeException(curl_error($ch2));
            }

            $token = str_replace('"', '', $response);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil token H2H: '.$e->getMessage());

            throw new \RuntimeException('Gagal mengambil token H2H.', previous: $e);
        } finally {
            if (isset($ch2)) {
                curl_close($ch2);
            }
        }

        try {
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, 'https://h2h.unair.ac.id/wabaoca/kirim-wa_3line_token');
            curl_setopt($ch2, CURLOPT_POST, 1);
            $param = [
                'nowa' => $hp,
                'token' => $token,
                'pesan_1' => base64_encode($pesan_1),
                'pesan_2' => base64_encode($pesan_2),
                'pesan_3' => base64_encode($pesan_3),
            ];
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $param);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

            $result = curl_exec($ch2);

            if ($result === false) {
                throw new \RuntimeException(curl_error($ch2));
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim WA OTP: '.$e->getMessage());

            throw new \RuntimeException('Gagal mengirim WA OTP.', previous: $e);
        } finally {
            if (isset($ch2)) {
                curl_close($ch2);
            }
        }

        return $result;
    }

    /**
     * Register a peserta into every active, selectable, wajib (`opsi_pilih=3`)
     * acara that doesn't already have a `peserta_acara` row for them. Called
     * when a new peserta is created (see docs/features/010-peserta-pilih-acara.md
     * §7); idempotent, so it's also safe to call repeatedly for backfilling
     * existing peserta.
     */
    protected function registerWajibAcaraUntukPeserta(int $idpeserta): void
    {
        $idAcaraWajib = DB::table('acara')
            ->where('opsi_pilih', '3')
            ->where(fn ($q) => $q->where('has_child', false)->orWhereNull('has_child'))
            ->where(fn ($q) => $q->where('status', true)->orWhereNull('status'))
            ->pluck('idacara');

        if ($idAcaraWajib->isEmpty()) {
            return;
        }

        $idSudahTerdaftar = DB::table('peserta_acara')
            ->where('idpeserta', $idpeserta)
            ->whereIn('idacara', $idAcaraWajib)
            ->pluck('idacara');

        $baris = $idAcaraWajib->diff($idSudahTerdaftar)
            ->map(fn ($idacara) => ['idpeserta' => $idpeserta, 'idacara' => $idacara])
            ->values()->all();

        if (! empty($baris)) {
            DB::table('peserta_acara')->insert($baris);
        }
    }

    /**
     * Base query for peserta rows that hold the Peserta role and have a
     * non-deleted pengguna row. Pass $idInstitusiAsal to scope to one
     * kontingen (peserta side); omit it (null) to query across every
     * institusi (admin side).
     *
     * Deliberately does NOT require `rp.status = true` (the Peserta role
     * being the currently *active* role) — a pengguna is still a member of
     * their kontingen regardless of which role is active right now (e.g.
     * an Admin who also happens to be registered as a peserta). Only
     * `role_pengguna` row existing for idrole=Peserta matters here, not its
     * active/inactive flag. See docs/features for the "satu role aktif"
     * design — that only governs which role's *menu/akses* applies to the
     * current session, not kontingen membership.
     */
    protected function pesertaAktifQuery(?int $idInstitusiAsal = null)
    {
        $query = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
            ->join('role_pengguna as rp', function ($join) {
                $join->on('rp.idpengguna', '=', 'p.idpengguna')->where('rp.idrole', self::ROLE_PESERTA);
            })
            ->where('p.is_deleted', false);

        if ($idInstitusiAsal !== null) {
            $query->where('p.idinstitusi_asal', $idInstitusiAsal);
        }

        return $query;
    }

    /**
     * Every institusi_asal + jenis_institusi, with `jumlahPeserta` (active
     * peserta count) and `jumlahLengkap` (how many of those have
     * `kit_lengkap = true`) — the per-kontingen seminar kit progress
     * summary. Shared by SeminarKitController (admin, read-only) and
     * PetugasKitController (same list, interactive detail page).
     *
     * @return Collection<int, object>
     */
    protected function kontingenKitProgress(): Collection
    {
        $pesertaPerInstitusi = $this->pesertaAktifQuery()
            ->select('p.idinstitusi_asal', 'pe.kit_lengkap')
            ->get()
            ->groupBy('idinstitusi_asal');

        return DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->select('i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) use ($pesertaPerInstitusi) {
                $peserta = $pesertaPerInstitusi->get($institusi->idinstitusi_asal, collect());
                $institusi->jumlahPeserta = $peserta->count();
                $institusi->jumlahLengkap = $peserta->where('kit_lengkap', true)->count();
                $institusi->token = $this->encryptRouteValue($institusi->idinstitusi_asal);

                return $institusi;
            });
    }

    /**
     * Full seminar-kit progress detail for one institusi_asal: the active
     * seminar_kit list (table columns) and the institusi's active peserta,
     * each carrying a `kitMap` keyed by idseminar_kit with that kit's
     * check/created_at/nama_petugas (or nulls if no kit_peserta row yet
     * for that pair). Shared by SeminarKitController::progressDetail()
     * (admin, read-only) and PetugasKitController::detail() (Petugas Kit,
     * interactive checkboxes).
     *
     * @return array{kitAktif: Collection<int, object>, pesertaList: Collection<int, object>}
     */
    protected function kitProgressDetail(int $idInstitusiAsal): array
    {
        $kitAktif = DB::table('seminar_kit')->where('status', true)->orderBy('idseminar_kit')->get();

        $pesertaList = $this->pesertaAktifQuery($idInstitusiAsal)
            ->select('pe.idpeserta', 'p.nama', 'pe.kit_lengkap')
            ->orderBy('p.nama')
            ->get();

        $kitPesertaRows = $pesertaList->isEmpty()
            ? collect()
            : DB::table('kit_peserta as kp')
                ->leftJoin('pengguna as petugas', 'petugas.idpengguna', '=', 'kp.created_by')
                ->whereIn('kp.idpeserta', $pesertaList->pluck('idpeserta'))
                ->select('kp.idpeserta', 'kp.idseminar_kit', 'kp.check', 'kp.created_at', 'petugas.nama as nama_petugas')
                ->get()
                ->groupBy('idpeserta');

        $pesertaList = $pesertaList->map(function ($peserta) use ($kitPesertaRows, $kitAktif) {
            $rowsUntukPeserta = $kitPesertaRows->get($peserta->idpeserta, collect())->keyBy('idseminar_kit');

            $peserta->kitMap = $kitAktif->mapWithKeys(function ($kit) use ($rowsUntukPeserta) {
                $row = $rowsUntukPeserta->get($kit->idseminar_kit);

                return [$kit->idseminar_kit => [
                    'check' => $row ? (bool) $row->check : false,
                    'created_at' => $row->created_at ?? null,
                    'nama_petugas' => $row->nama_petugas ?? null,
                ]];
            });

            return $peserta;
        });

        return ['kitAktif' => $kitAktif, 'pesertaList' => $pesertaList];
    }

    /**
     * The idjenis_transport of the active ("status" = true) "Kendaraan Pribadi"
     * row — looked up by name instead of a hardcoded ID, since the seeder keeps
     * an inactive duplicate row around.
     */
    protected function idJenisTransportKendaraanPribadi(): int
    {
        return (int) DB::table('jenis_transport')
            ->where('nama_jenis_transport', 'Kendaraan Pribadi')
            ->where('status', true)
            ->value('idjenis_transport');
    }

    /**
     * Whether a peserta's logistik data (and photo) is complete (see
     * docs/features/011-logistik-dan-kartu-kontingen.md §2.1 and §5.5):
     * transportasi, tanggal, jam, and path_foto are always required; stasiun is
     * required unless the peserta is using their own private vehicle.
     */
    protected function isLogistikLengkap(object $peserta, int $idKendaraanPribadi): bool
    {
        $wajibIsi = [
            $peserta->idjenis_transportasi_kedatangan,
            $peserta->tanggal_kedatangan,
            $peserta->jam_kedatangan,
            $peserta->idjenis_transportasi_kepulangan,
            $peserta->tanggal_kepulangan,
            $peserta->jam_kepulangan,
        ];

        if ((int) $peserta->idjenis_transportasi_kedatangan !== $idKendaraanPribadi) {
            $wajibIsi[] = $peserta->stasiun_kedatangan;
        }

        if ((int) $peserta->idjenis_transportasi_kepulangan !== $idKendaraanPribadi) {
            $wajibIsi[] = $peserta->stasiun_kepulangan;
        }

        foreach ($wajibIsi as $nilai) {
            if ($nilai === null || $nilai === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Every peserta belonging to $idInstitusiAsal (or every peserta across all
     * institusi when null), with logistik columns and extra boolean properties:
     * `logistikLengkap`, `fotoLengkap`, and `lengkap` (both combined) indicating
     * data completeness.
     *
     * @return Collection<int, object>
     */
    protected function pesertaDenganStatusLengkap(?int $idInstitusiAsal = null)
    {
        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();

        return $this->pesertaAktifQuery($idInstitusiAsal)
            ->select(
                'p.idpengguna', 'pe.idpeserta', 'p.nama', 'p.email', 'p.no_wa', 'p.idinstitusi_asal', 'j.nama_jabatan',
                'pe.idjenis_transportasi_kedatangan', 'pe.stasiun_kedatangan', 'pe.tanggal_kedatangan', 'pe.jam_kedatangan',
                'pe.idjenis_transportasi_kepulangan', 'pe.stasiun_kepulangan', 'pe.tanggal_kepulangan', 'pe.jam_kepulangan',
                'pe.nama_hotel', 'pe.city_tour', 'pe.path_foto'
            )
            ->orderBy('p.nama')
            ->get()
            ->map(function ($peserta) use ($idKendaraanPribadi) {
                $peserta->logistikLengkap = $this->isLogistikLengkap($peserta, $idKendaraanPribadi);
                $peserta->fotoLengkap = $peserta->path_foto !== null;
                $peserta->lengkap = $peserta->logistikLengkap && $peserta->fotoLengkap;
                $peserta->token = $this->encryptRouteValue($peserta->idpeserta);

                return $peserta;
            });
    }

    /**
     * Build and stream the kontingen's registration card (PDF, A5) for the given
     * institusi_asal row. Callers are responsible for enforcing the "every
     * peserta has complete data" gate before calling this.
     */
    protected function unduhKartuKontingenResponse(object $institusi)
    {
        $qrDataUri = (new Builder(
            writer: new PngWriter,
            data: $institusi->kode_kontingen,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 320,
            margin: 12,
        ))->build()->getDataUri();

        $data = [
            'namaInstitusi' => $institusi->nama_institusi,
            'kodeKontingen' => $institusi->kode_kontingen,
            'qrDataUri' => $qrDataUri,
            'logoUnairPath' => public_path('src/assets/img/logo_unair_kecil.png'),
            'logoKpptiPath' => public_path('src/assets/img/kppti_logo.png'),
        ];

        return Pdf::loadView('peserta.kartu-kontingen-pdf', $data)
            ->setPaper('a5', 'portrait')
            ->download('kartu-registrasi-kontingen-'.$institusi->kode_kontingen.'.pdf');
    }

    /**
     * The first acara already registered for $idpeserta whose hari_ke matches
     * $acaraBaru and whose jam range overlaps it. Rows with a null hari_ke or
     * null jam on either side are never considered a conflict (the overlap
     * can't be determined), see docs/features/010-peserta-pilih-acara.md §5.
     * Shared by PesertaController (own kontingen) and PesertaAdminController
     * (any peserta, used when admin manages acara choices on a peserta's
     * behalf after registration has closed).
     */
    protected function acaraBentrok(int $idpeserta, object $acaraBaru): ?object
    {
        if (! $acaraBaru->hari_ke || ! $acaraBaru->jam_mulai || ! $acaraBaru->jam_akhir) {
            return null;
        }

        return DB::table('peserta_acara as pa')
            ->join('acara as a', 'a.idacara', '=', 'pa.idacara')
            ->where('pa.idpeserta', $idpeserta)
            ->where('a.hari_ke', $acaraBaru->hari_ke)
            ->whereNotNull('a.jam_mulai')
            ->whereNotNull('a.jam_akhir')
            ->where('a.jam_mulai', '<', $acaraBaru->jam_akhir)
            ->where('a.jam_akhir', '>', $acaraBaru->jam_mulai)
            ->select('a.tema', 'a.hari_ke', 'a.jam_mulai', 'a.jam_akhir')
            ->first();
    }

    /**
     * Find a peserta by idpeserta, but only if they belong to $idInstitusiAsal —
     * used to enforce that a peserta may only view/edit peserta (or be chosen
     * as PIC for a pameran submission) from their own kontingen.
     */
    protected function findPesertaInOwnInstitusi(int $idpeserta, int $idInstitusiAsal): ?object
    {
        return DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->where('pe.idpeserta', $idpeserta)
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->where('p.is_deleted', false)
            ->select('p.idpengguna', 'pe.idpeserta', 'p.nama', 'p.email', 'p.no_wa', 'pe.idjabatan')
            ->first();
    }

    /**
     * Every role a pengguna holds (not just the active one), for the "Role"
     * list shown on both the admin "Detail Pengguna" modal and the pengguna's
     * own profile page.
     *
     * @return Collection<int, object>
     */
    protected function rolesForPengguna(int $idpengguna): Collection
    {
        return DB::table('role_pengguna as rp')
            ->join('role as r', 'r.idrole', '=', 'rp.idrole')
            ->where('rp.idpengguna', $idpengguna)
            ->select('r.idrole', 'r.nama_role', 'rp.status')
            ->orderBy('r.nama_role')
            ->get();
    }

    /**
     * Deactivate all of a pengguna's roles, then activate the given one — reactivating
     * their existing row for it if one exists, or inserting a new row otherwise. Ensures
     * a pengguna never ends up with more than one active role. Shared by AdminController
     * (changing another pengguna's active role) and PenggunaController (a pengguna
     * changing their own, from the profile page).
     */
    protected function activateSingleRole(int $idpengguna, int $idrole): void
    {
        DB::table('role_pengguna')
            ->where('idpengguna', $idpengguna)
            ->update(['status' => false]);

        $existingRole = DB::table('role_pengguna')
            ->where('idpengguna', $idpengguna)
            ->where('idrole', $idrole)
            ->first();

        if ($existingRole) {
            DB::table('role_pengguna')
                ->where('idrole_pengguna', $existingRole->idrole_pengguna)
                ->update(['status' => true]);
        } else {
            DB::table('role_pengguna')->insert([
                'idpengguna' => $idpengguna,
                'idrole' => $idrole,
                'status' => true,
            ]);
        }
    }

    /**
     * Base query for acara rows that are not soft-deleted. `status` is nullable
     * on old rows (no explicit value ever set), which still counts as active.
     * Shared by AcaraController (F09 admin management) and
     * NarasumberReviewController (picking a sesi when deciding Diterima).
     */
    protected function acaraAktifQuery()
    {
        return DB::table('acara')
            ->where(function ($query) {
                $query->where('acara.status', true)->orWhereNull('acara.status');
            })
            ->orderBy('acara.idacara');
    }

    /**
     * Accepted (Diterima) narasumber assignments for the given acara ids,
     * grouped by idacara — each entry carries `nama` (the narasumber's own
     * nama) and `subtema`. Shared by AcaraController (F09 admin, read-only)
     * and PesertaController (read-only display on the peserta's Acara /
     * Pilih Acara pages) — see docs/features/009-manajemen-acara.md §2.2.
     *
     * @param  Collection<int, int>  $idAcaraList
     * @return Collection<int, Collection<int, object>>
     */
    protected function narasumberPerAcara($idAcaraList): Collection
    {
        if ($idAcaraList->isEmpty()) {
            return collect();
        }

        return DB::table('narasumber_acara as na')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'na.idnarasumber')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->whereIn('na.idacara', $idAcaraList)
            ->where('na.status', true)
            ->where('n.status_ajuan', '5')
            ->select('na.idacara', 'p.nama', 'n.subtema')
            ->get()
            ->groupBy('idacara');
    }

    /**
     * Border accent colors per hari_ke, cycled if there are more days than colors.
     * Reuses the admin template's existing theme palette (primary, success,
     * warning, info, secondary, danger) for visual consistency.
     *
     * @var array<int, string>
     */
    private const WARNA_HARI = ['#4361ee', '#00ab55', '#e2a03f', '#2196f3', '#805dca', '#e7515a'];

    private function warnaHari(?int $hariKe): string
    {
        if (! $hariKe || $hariKe < 1) {
            return '#bfc9d4';
        }

        return self::WARNA_HARI[($hariKe - 1) % count(self::WARNA_HARI)];
    }

    /**
     * Top-level acara (+ their children), each enriched with `narasumberList`
     * and `warna_hari`, plus the per-hari color legend — the full read-only
     * display data for an acara listing. Shared by AcaraController (F09
     * admin, which adds its own edit-modal-only data on top) and
     * AcaraScController (SC's read-only Acara menu).
     *
     * @return array{acaraList: Collection<int, object>, legendaHari: Collection<int, object>}
     */
    protected function acaraListDenganPembicara(): array
    {
        $topLevel = $this->acaraAktifQuery()
            ->whereNull('idparent_acara')
            ->get();

        $children = collect();

        if ($topLevel->isNotEmpty()) {
            $children = $this->acaraAktifQuery()
                ->whereIn('idparent_acara', $topLevel->pluck('idacara'))
                ->get();
        }

        $narasumberPerAcara = $this->narasumberPerAcara($topLevel->pluck('idacara')->merge($children->pluck('idacara')));

        $lengkapi = function ($acara) use ($narasumberPerAcara) {
            $acara->narasumberList = $narasumberPerAcara->get($acara->idacara, collect())->values();
            $acara->warna_hari = $this->warnaHari($acara->hari_ke);

            return $acara;
        };

        $acaraList = $topLevel->map($lengkapi)->map(function ($acara) use ($children, $lengkapi) {
            $acara->children = $children->where('idparent_acara', $acara->idacara)->map($lengkapi)->values();

            return $acara;
        })->values();

        $legendaHari = $acaraList->flatMap(fn ($a) => collect([$a])->merge($a->children))
            ->pluck('hari_ke')
            ->filter()
            ->unique()
            ->sort()
            ->map(fn ($hari) => (object) ['hari_ke' => $hari, 'warna' => $this->warnaHari($hari)])
            ->values();

        return ['acaraList' => $acaraList, 'legendaHari' => $legendaHari];
    }

    /**
     * Whether a jadwal_penting row is currently open: now() falls within
     * [timestamp_buka, timestamp_tutup], or mode is '2' (always open).
     * Mirrors JadwalPentingMiddleware's default "buka" check, exposed here
     * for call sites that need to gate a single action inside a shared
     * controller method rather than an entire route.
     */
    protected function jadwalSedangBuka(int $idJadwalPenting): bool
    {
        $jadwal = DB::table('jadwal_penting')->where('idjadwal_penting', $idJadwalPenting)->first();

        if (! $jadwal) {
            return false;
        }

        if ($jadwal->mode === '2') {
            return true;
        }

        $sekarang = now();

        if ($jadwal->timestamp_buka && $sekarang->lt($jadwal->timestamp_buka)) {
            return false;
        }

        if ($jadwal->timestamp_tutup && $sekarang->gt($jadwal->timestamp_tutup)) {
            return false;
        }

        return true;
    }

    /**
     * Baris tagihan paling baru milik satu pameran — relasi pameran→tagihan
     * one-to-many (satu pameran bisa punya beberapa baris tagihan berturutan,
     * baik karena VA sebelumnya expired dan diganti lewat requestVaBaru(),
     * maupun karena kluster pameran berganti dari yang gratis ke yang
     * berbayar), jadi baris yang relevan selalu yang idtagihan-nya terbesar.
     * Dipakai PameranController (peserta) dan PameranReviewController (SC) —
     * gate SC harus selalu mengacu ke tagihan TERBARU, bukan "pernah ada
     * yang lunas", supaya tagihan lama yang auto-lunas (kluster gratis)
     * tidak membuat pengajuan lolos gate begitu kluster berganti jadi
     * berbayar dan tagihan barunya belum lunas.
     */
    protected function tagihanTerbaru(int $idpameran): ?object
    {
        return DB::table('tagihan')->where('idpameran', $idpameran)->orderByDesc('idtagihan')->first();
    }

    /**
     * Inquiry billing ke BNI untuk satu baris tagihan, lalu proses hasilnya:
     * kalau BNI melapor sudah ada pembayaran (`payment_ntb` terisi) dan
     * pembayaran itu belum pernah tercatat (`payment_ntb` belum ada di
     * `pembayaran`), kurangi `sisa_tagihan`, set status (`3` lunas kalau
     * sisa <= 0, `2` terbayar sebagian kalau masih ada sisa), dan simpan
     * baris `pembayaran` baru. Dipakai dari sisi peserta (tombol "Check
     * Status Pembayaran") maupun admin (tombol "Status Bayar") supaya
     * logikanya persis sama di kedua tempat — lihat
     * PameranController::cekStatusPembayaran() dan
     * TagihanPameranController::cekStatusBayar().
     *
     * Mengembalikan respons mentah dari BniVirtualAccountService::inquiryBilling()
     * (`code`, `message`, `data`) supaya pemanggil bisa menampilkan detail
     * apa pun yang dikembalikan BNI, tanpa helper ini perlu tahu soal itu.
     *
     * @return array{code: int, message: string, data: array}
     */
    protected function prosesInquiryBillingTagihan(object $tagihan): array
    {
        $resp_inquiry = app(BniVirtualAccountService::class)->inquiryBilling($tagihan->idtagihan);

        if (empty($resp_inquiry['data']['payment_ntb'])) {
            return $resp_inquiry;
        }

        $trx_amount = $resp_inquiry['data']['payment_amount'] ?? null;
        $payment_ntb = $resp_inquiry['data']['payment_ntb'] ?? null;
        $datetime_payment = $resp_inquiry['data']['datetime_payment'] ?? null;

        $existingPayment = DB::table('pembayaran')->where('payment_ntb', $payment_ntb)->first();

        if (! $existingPayment) {
            $sisa_tagihan = $tagihan->sisa_tagihan - $trx_amount;

            DB::transaction(function () use ($tagihan, $sisa_tagihan, $payment_ntb, $trx_amount, $datetime_payment) {
                DB::table('tagihan')->where('idtagihan', $tagihan->idtagihan)->update([
                    'sisa_tagihan' => $sisa_tagihan,
                    'status' => $sisa_tagihan <= 0 ? 3 : 2,
                ]);

                DB::table('pembayaran')->insert([
                    'idtagihan' => $tagihan->idtagihan,
                    'payment_ntb' => $payment_ntb,
                    'trx_amount' => $trx_amount,
                    'datetime_payment' => $datetime_payment,
                ]);
            });
        }

        return $resp_inquiry;
    }

    /**
     * Reduce WYSIWYG (Quill) output down to a safe formatting-only HTML
     * subset before it's stored. The hidden form field a WYSIWYG editor
     * writes into can be edited directly (devtools/Postman) bypassing the
     * toolbar entirely, so the toolbar is not a security boundary — this is
     * the actual guard against stored XSS, since the saved value is later
     * rendered unescaped (`{!! !!}`) back to other users (SC/admin).
     */
    protected function sanitizeRichText(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return $html;
        }

        $tagDiizinkan = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'h1', 'h2', 'h3', 'ul', 'ol', 'li', 'blockquote', 'a'];
        $tagDihapusTotal = ['script', 'style', 'iframe', 'object', 'embed', 'noscript', 'svg', 'form', 'input', 'button', 'textarea', 'select', 'option', 'img', 'video', 'audio', 'source', 'link', 'meta'];

        $dom = new \DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?><div>'.$html.'</div>', LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $container = $dom->getElementsByTagName('div')->item(0);

        if (! $container) {
            return '';
        }

        $this->bersihkanNodeHtml($container, $tagDiizinkan, $tagDihapusTotal);

        $hasil = '';
        foreach (iterator_to_array($container->childNodes) as $child) {
            $hasil .= $dom->saveHTML($child);
        }

        return trim($hasil);
    }

    /**
     * @param  string[]  $tagDiizinkan
     * @param  string[]  $tagDihapusTotal
     */
    private function bersihkanNodeHtml(\DOMNode $node, array $tagDiizinkan, array $tagDihapusTotal): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                continue;
            }

            if ($child->nodeType !== XML_ELEMENT_NODE) {
                $node->removeChild($child);

                continue;
            }

            $tag = strtolower($child->nodeName);

            if (in_array($tag, $tagDihapusTotal, true)) {
                $node->removeChild($child);

                continue;
            }

            // Bersihkan anak-anaknya dulu sebelum memutuskan nasib tag ini sendiri,
            // supaya konten yang dipromosikan saat unwrap juga sudah bersih.
            $this->bersihkanNodeHtml($child, $tagDiizinkan, $tagDihapusTotal);

            if (! in_array($tag, $tagDiizinkan, true)) {
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);

                continue;
            }

            foreach (iterator_to_array($child->attributes ?? []) as $attr) {
                if ($tag === 'a' && $attr->name === 'href' && $this->hrefAman($attr->value)) {
                    continue;
                }

                $child->removeAttribute($attr->name);
            }
        }
    }

    private function hrefAman(string $href): bool
    {
        $href = trim($href);

        return (bool) preg_match('/^(https?:|mailto:)/i', $href) || str_starts_with($href, '/') || str_starts_with($href, '#');
    }
}
