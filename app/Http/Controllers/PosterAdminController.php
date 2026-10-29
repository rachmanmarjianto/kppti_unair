<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PosterAdminController extends Controller
{
    /**
     * idref_tabel di tabel `file` untuk baris yang menunjuk ke `poster`.
     */
    private const IDREF_TABEL_POSTER = 2;

    /**
     * Monitor peserta narasumber berstatus Tidak Terpilih ('8') beserta
     * status upload poster-nya — aman dari duplikat baris karena invarian
     * "maksimal 1 file aktif per poster" dijaga di `PosterController::simpan()`.
     */
    public function index()
    {
        $menu = 'narasumber';
        $submenu = 'poster';

        $posterList = DB::table('narasumber as n')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->leftJoin('poster as po', 'po.idnarasumber', '=', 'n.idnarasumber')
            ->leftJoin('file as f', function ($join) {
                $join->on('f.idref', '=', 'po.idposter')
                    ->where('f.idref_tabel', self::IDREF_TABEL_POSTER)
                    ->where('f.status', true);
            })
            ->where('n.status_ajuan', '8')
            ->select('n.idnarasumber', 'p.nama', 'i.nama_institusi', 'f.idfile', 'f.created_at as diupload_pada')
            ->orderBy('p.nama')
            ->get()
            ->map(function ($row) {
                if ($row->idfile) {
                    $row->token = $this->encryptRouteValue($row->idfile);
                }

                return $row;
            });

        return view('admin.narasumber-poster', compact('menu', 'submenu', 'posterList'));
    }

    /**
     * Unduh (forced-download, bukan inline) file poster satu peserta.
     */
    public function unduh(Request $request)
    {
        $idfile = $this->decryptRouteValue($request->query('token'));

        if ($idfile === null) {
            abort(404);
        }

        $file = DB::table('file as f')
            ->join('poster as po', 'po.idposter', '=', 'f.idref')
            ->join('narasumber as n', 'n.idnarasumber', '=', 'po.idnarasumber')
            ->join('pengguna as p', 'p.idpengguna', '=', 'n.idpengguna')
            ->where('f.idfile', (int) $idfile)
            ->where('f.idref_tabel', self::IDREF_TABEL_POSTER)
            ->select('f.path_file', 'p.nama')
            ->first();

        if (! $file || ! $file->path_file || ! Storage::disk('local')->exists($file->path_file)) {
            abort(404);
        }

        $ext = strtolower(pathinfo($file->path_file, PATHINFO_EXTENSION));
        $namaFile = 'Poster-'.str_replace(' ', '-', $file->nama).'.'.$ext;

        return Storage::disk('local')->download($file->path_file, $namaFile);
    }
}
