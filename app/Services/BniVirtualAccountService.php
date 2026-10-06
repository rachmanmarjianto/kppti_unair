<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BniVirtualAccountService
{
    private $BniEnc;

    public function __construct(BniEncService $BniEnc)
    {
        $this->BniEnc = $BniEnc;
    }

    // FROM BNI
    // private $prefix = config('services.bni.prefix');

    // private $secret_key = config('services.bni.secret_key');

    // //url production
    // private $url = config('services.bni.url');

    /**
     * Minta nomor VA baru ke BNI untuk satu tagihan. Dikosongkan sesuai
     * arahan developer — isi integrasi nyata (request HTTP ke API BNI)
     * menyusul diisi developer sendiri.
     */
    public function requestVa($idtagihan, $nama, $email, $hp): ?array
    {
        date_default_timezone_set('Asia/Jakarta');
        $exp_payment_date = date('c', time() + 6 * 3600);

        Log::info("KPPTI: Requesting VA for tagihan {$idtagihan} with exp_payment_date {$exp_payment_date}");

        $va_number = config('services.bni.prefix').config('services.bni.cid');
        $sisa_len = 16 - strlen($va_number);
        $va_number .= str_pad($idtagihan, $sisa_len, '0', STR_PAD_LEFT);

        $data_asli = [
            'type' => 'createBilling',
            'client_id' => config('services.bni.cid'),
            'trx_id' => $idtagihan, // fill with Billing ID
            'trx_amount' => config('services.biaya_pameran'),
            'billing_type' => 'c',
            'datetime_expired' => $exp_payment_date, // billing will be expired in 6 hours
            'virtual_account' => $va_number,
            'customer_name' => $nama,
            'customer_email' => $email,
            'customer_phone' => $hp,
            'description' => 'Biaya Registrasi Pameran KPPTI 2026 dengan kode biaya: '.$idtagihan,
        ];

        $hashed_string = $this->BniEnc->encrypt(
            $data_asli,
            config('services.bni.cid'),
            config('services.bni.secret_key')
        );

        $data_va = [
            'client_id' => config('services.bni.cid'),
            'data' => $hashed_string,
        ];

        $response = $this->get_content(config('services.bni.url'), json_encode($data_va));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {

            $ret_array = [
                'code' => 200,
                'message' => $response_json['status'].' - '.$response_json['message'] ?? 'Gagal membuat VA baru',
                'data' => [],
            ];

        } else {
            $data_response = $this->BniEnc->decrypt($response_json['data'], config('services.bni.cid'), config('services.bni.secret_key'));
            // $data_response will contains something like this:

            dd($data_response);

            $data = [
                'va_number' => $va_number,
                'trx_amount' => config('services.biaya_pameran'),
                'datetime_expired' => $exp_payment_date,
                'billing_type' => 'c',
                'payment_ntb' => null,
            ];

            $ret_array = [
                'code' => 200,
                'message' => 'Berhasil membuat VA baru',
                'data' => $data,
            ];

        }

        return $ret_array;
    }

    private function get_content($url, $post = '')
    {
        $usecookie = __DIR__.'/cookie.txt';
        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept-Encoding: gzip, deflate';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Accept-Language: en-US,en;q=0.8,id;q=0.6';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $rs = curl_exec($ch);

        // $rawRequestHeaders = curl_getinfo($ch, CURLINFO_HEADER_OUT);

        // dd($rawRequestHeaders, $post, $rs);

        if (empty($rs)) {
            var_dump($rs, curl_error($ch));
            curl_close($ch);

            return false;
        }
        curl_close($ch);

        return $rs;
    }
}
