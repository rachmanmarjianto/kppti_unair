<?php

namespace App\Http\Controllers;

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
        $characters = '123456789abcdefghijklmnopqrstuvwxyz';
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
     * Base query for peserta rows with an active Peserta role and a non-deleted
     * pengguna row. Pass $idInstitusiAsal to scope to one kontingen (peserta
     * side); omit it (null) to query across every institusi (admin side).
     */
    protected function pesertaAktifQuery(?int $idInstitusiAsal = null)
    {
        $query = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
            ->join('role_pengguna as rp', function ($join) {
                $join->on('rp.idpengguna', '=', 'p.idpengguna')->where('rp.idrole', self::ROLE_PESERTA);
            })
            ->where('p.is_deleted', false)
            ->where('rp.status', true);

        if ($idInstitusiAsal !== null) {
            $query->where('p.idinstitusi_asal', $idInstitusiAsal);
        }

        return $query;
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
}
