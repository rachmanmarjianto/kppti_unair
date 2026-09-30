<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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
}
