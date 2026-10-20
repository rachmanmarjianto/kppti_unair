<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DataMasterController extends Controller
{
    public function universitasIndex(): View
    {
        $menu = 'data-master';
        $submenu = 'universitas';

        return view('admin.data-master-universitas', compact('menu', 'submenu'));
    }

    /**
     * Cari universitas by nama (sebagian), dipakai untuk pencarian data di
     * halaman ini maupun untuk cek-mirip sebelum menambah data baru.
     */
    public function cariUniversitas(Request $request): JsonResponse
    {
        $keyword = $request->string('q')->trim()->value();

        if ($keyword === '') {
            return response()->json([]);
        }

        $universitas = DB::table('universitas')
            ->where('nama_universitas', 'ilike', "%{$keyword}%")
            ->select('iduniversitas', 'kode_universitas', 'nama_universitas')
            ->orderBy('nama_universitas')
            ->limit(20)
            ->get();

        return response()->json($universitas);
    }

    public function tambahUniversitas(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $nama = Str::upper(trim($validated['nama']));

        $sudahAda = DB::table('universitas')->where('nama_universitas', 'ilike', $nama)->exists();

        if ($sudahAda) {
            return $this->jsonResponse(409, 'Universitas ini sudah ada di data master.');
        }

        $universitasBaru = DB::transaction(function () use ($nama) {
            // ORDER BY ... DESC LIMIT 1 FOR UPDATE mengunci baris MAX saat ini,
            // sehingga dua admin yang menambah data nyaris bersamaan tidak bisa
            // membaca nilai MAX yang sama (dikonfirmasi developer: id & kode
            // dihitung manual MAX+1, bukan lewat sequence/insertGetId).
            // kode_universitas punya baris lama yang NULL, dan Postgres taruh
            // NULL di awal untuk ORDER BY DESC (default NULLS FIRST) — wajib
            // NULLS LAST supaya baris yang terkunci benar-benar baris MAX, bukan
            // baris NULL.
            $idBaru = (int) (DB::table('universitas')->orderByRaw('iduniversitas DESC NULLS LAST')->lockForUpdate()->value('iduniversitas') ?? 0) + 1;
            $kodeBaru = (int) (DB::table('universitas')->orderByRaw('kode_universitas DESC NULLS LAST')->lockForUpdate()->value('kode_universitas') ?? 0) + 1;

            DB::table('universitas')->insert([
                'iduniversitas' => $idBaru,
                'kode_universitas' => $kodeBaru,
                'nama_universitas' => $nama,
            ]);

            return [
                'iduniversitas' => $idBaru,
                'kode_universitas' => $kodeBaru,
                'nama_universitas' => $nama,
            ];
        });

        return $this->jsonResponse(200, 'Universitas berhasil ditambahkan.', $universitasBaru);
    }
}
