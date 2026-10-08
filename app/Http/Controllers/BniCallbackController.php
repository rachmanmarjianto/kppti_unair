<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\BniEncService;
use DB;

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
        if(!$request->isMethod('post')) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        $data_json = json_decode($request->getContent(), true);
        
        if (!$data_json) {
            // handling orang iseng

            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            
            $pesan = "Illegal Activity: Ada akses ke Callback API BNI dari ".$ipaddress." dengan tujuan tidak jelas";
            $subject = "REPORT ILLEGAL ACTIVITY";

            return response()->json(['status' => '999', 'message' => 'illegal activity: '.$ipaddress.' has been reported'], 400);

        }
        else{
            if($data_json['client_id'] === config('services.bni.cid')) {
                $BniEnc = new BniEncService();
                $data_asli = $BniEnc->decrypt(
                    $data_json['data'],
                    config('services.bni.cid'),
                    config('services.bni.secret_key')
                );

                if (!$data_asli) {
                    // handling jika waktu server salah/tdk sesuai atau secret key salah
                    return response()->json(['status' => '999', 'message' => 'waktu server tidak sesuai NTP atau secret key salah.'], 400);
                }

                $tagihan = DB::table('tagihan')->where('idtagihan', $data_asli['trx_id'])->first();
                if (!$tagihan) {
                    return response()->json(['status' => '108'], 404);
                }   

                $sisa_tagihan = $tagihan->sisa_tagihan - $data_asli['trx_amount'];

                $status_tagihan = $sisa_tagihan <= 0 ? 3 : 2;

                try {
                    DB::transaction(function () use ($data_asli, $sisa_tagihan, $status_tagihan) {
                        DB::table('pembayaran')->insert([
                            'idtagihan' => $data_asli['trx_id'],
                            'trx_amount' => $data_asli['trx_amount'],
                            'datetime_payment' => date('Y-m-d H:i:s', strtotime($data_asli['datetime_payment'])),
                            'payment_ntb' => $data_asli['payment_ntb']
                        ]);

                        DB::table('tagihan')->where('idtagihan', $data_asli['trx_id'])->update([
                            'sisa_tagihan' => $sisa_tagihan,
                            'status' => $status_tagihan
                        ]);
                    });
                } catch (\Throwable $e) {
                    Log::error('KPPTI: Failed to persist BNI callback payment', [
                        'trx_id' => $data_asli['trx_id'],
                        'exception' => $e->getMessage()
                    ]);

                    return response()->json(['status' => '999', 'message' => 'Gagal menyimpan pembayaran.'], 500);
                }

                Log::info("KPPTI: Received BNI callback data: ".json_encode($data_asli));
            }
            else {
                return response()->json(['status' => '999', 'message' => 'client_id tidak sesuai.'], 400);
            }
        }

        return response()->json(['received' => true]);
    }

    public function handle_forbidden(Request $request): JsonResponse
    {
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
