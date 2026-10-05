<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanPameranController extends Controller
{
    /**
     * Daftar tagihan pameran — status ditandai lunas manual oleh admin
     * selama integrasi VA BNI belum diisi (lihat
     * docs/features/007-pengajuan-pameran.md §4).
     */
    public function index()
    {
        $menu = 'pameran';
        $submenu = 'tagihan-pameran';

        $tagihan = DB::table('tagihan as t')
            ->join('pameran as p', 'p.idpameran', '=', 't.idpameran')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 't.idinstitusi_asal')
            ->whereNotNull('t.idpameran')
            ->select('t.idtagihan', 't.status', 't.tagihan', 't.sisa_tagihan', 'p.tema', 'i.nama_institusi')
            ->orderBy('t.idtagihan')
            ->get()
            ->map(function ($row) {
                $row->token = $this->encryptRouteValue($row->idtagihan);

                return $row;
            });

        return view('admin.tagihan-pameran', compact('menu', 'submenu', 'tagihan'));
    }

    /**
     * Tandai satu tagihan pameran lunas — tombol sementara selama request
     * VA & callback BNI masih fungsi kosong.
     */
    public function tandaiLunas(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idtagihan' => ['required', 'integer'],
        ]);

        $tagihan = DB::table('tagihan')->where('idtagihan', $validated['idtagihan'])->whereNotNull('idpameran')->first();

        if (! $tagihan) {
            return $this->jsonResponse(404, 'Tagihan tidak ditemukan.');
        }

        if ((int) $tagihan->status === 3) {
            return $this->jsonResponse(422, 'Tagihan ini sudah lunas.');
        }

        DB::table('tagihan')->where('idtagihan', $tagihan->idtagihan)->update([
            'status' => 3,
            'sisa_tagihan' => 0,
        ]);

        $this->logInstitusi($tagihan->idinstitusi_asal, $userdata['idpengguna'], 'Menandai lunas tagihan pameran (manual, menunggu integrasi VA BNI).');

        return $this->jsonResponse(200, 'Tagihan berhasil ditandai lunas.');
    }
}
