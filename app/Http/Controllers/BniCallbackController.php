<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BniCallbackController extends Controller
{
    /**
     * Webhook publik dari BNI untuk notifikasi pembayaran VA — tidak ada sesi,
     * tidak ada middleware akses. Dikosongkan sesuai arahan developer; isi
     * verifikasi callback & update tagihan.status menyusul diisi developer
     * sendiri (lihat docs/features/007-pengajuan-pameran.md §4).
     */
    public function handle(Request $request): JsonResponse
    {
        // TODO: verifikasi callback BNI, update tagihan.status.

        return response()->json(['received' => true]);
    }
}
