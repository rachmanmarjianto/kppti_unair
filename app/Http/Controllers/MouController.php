<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MouController extends Controller
{
    public function listPeserta()
    {
        $menu = 'mou';
        $submenu = 'list-peserta';

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        $institusiList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->whereIn('i.idinstitusi_asal', $this->pesertaAktifQuery()->select('p.idinstitusi_asal')->distinct())
            ->select('i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) {
                $institusi->token = $this->encryptRouteValue($institusi->idinstitusi_asal);

                return $institusi;
            });

        return view('peserta.mou-list-peserta', compact('menu', 'submenu', 'jenisInstitusiList', 'institusiList'));
    }

    public function pengajuan()
    {
        $menu = 'mou';
        $submenu = 'pengajuan';

        return view('peserta.mou-pengajuan', compact('menu', 'submenu'));
    }

    public function pesertaInstitusi(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $idInstitusiAsal = $this->decryptRouteValue($validated['token']);

        if (! $idInstitusiAsal) {
            return $this->jsonResponse(404, 'Institusi tidak ditemukan.');
        }

        $pesertaList = $this->pesertaAktifQuery((int) $idInstitusiAsal)
            ->select('p.nama')
            ->orderBy('p.nama')
            ->get();

        return $this->jsonResponse(200, 'Berhasil.', ['peserta' => $pesertaList]);
    }
}
