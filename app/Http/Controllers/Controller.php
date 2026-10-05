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
