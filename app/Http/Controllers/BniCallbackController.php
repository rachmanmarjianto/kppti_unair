<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BniCallbackController extends Controller
{
    /**
     * Webhook publik dari BNI untuk notifikasi pembayaran VA — tidak ada sesi,
     * tidak ada middleware akses. Dikosongkan sesuai arahan developer; isi
     * verifikasi callback, insert baris baru ke `pembayaran` (satu per
     * notifikasi pembayaran — relasinya one-to-many dari `tagihan`, karena
     * BNI bisa mengirim pembayaran sebagian), dan perbarui
     * `tagihan.sisa_tagihan`/`status` menyusul diisi developer sendiri.
     */
    public function handle(Request $request): JsonResponse
    {
        // TODO: verifikasi callback BNI, insert ke `pembayaran`, update `tagihan`.
        Log::info('BNI callback request', $request->all());

        return response()->json(['received' => true]);
    }
}
