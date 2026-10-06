<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AcaraController extends Controller
{
    public function index()
    {
        $menu = 'acara';
        $submenu = '';

        ['acaraList' => $topLevel, 'legendaHari' => $legendaHari] = $this->acaraListDenganPembicara();

        $keDataJs = function ($a) {
            return [
                'idacara' => $a->idacara,
                'idparent_acara' => $a->idparent_acara,
                'has_child' => (bool) $a->has_child,
                'tema' => $a->tema,
                'ruang' => $a->ruang,
                'opsi_pilih' => $a->opsi_pilih,
                'hari_ke' => $a->hari_ke,
                'jam_mulai' => $a->jam_mulai ? substr($a->jam_mulai, 0, 5) : null,
                'jam_akhir' => $a->jam_akhir ? substr($a->jam_akhir, 0, 5) : null,
                'perlu_narsum' => (bool) $a->perlu_narsum,
                'speaker' => $a->speaker,
                'narasumberList' => $a->narasumberList->map(fn ($n) => [
                    'nama' => $n->nama,
                    'subtema' => $n->subtema,
                ])->values(),
            ];
        };

        $acaraDataJs = $topLevel->flatMap(fn ($a) => collect([$a])->merge($a->children))
            ->map($keDataJs)
            ->values();

        return view('admin.acara', [
            'menu' => $menu,
            'submenu' => $submenu,
            'acaraList' => $topLevel,
            'acaraDataJs' => $acaraDataJs,
            'legendaHari' => $legendaHari,
            'parentOptions' => $topLevel->map(fn ($a) => (object) ['idacara' => $a->idacara, 'tema' => $a->tema]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAcara($request);

        $idacara = DB::table('acara')->insertGetId($validated, 'idacara');

        if (! empty($validated['idparent_acara'])) {
            $this->recalculateHasChild((int) $validated['idparent_acara']);
        }

        return $this->jsonResponse(200, 'Acara berhasil ditambahkan.', ['idacara' => $idacara]);
    }

    public function update(Request $request)
    {
        $request->validate(['idacara' => ['required', 'integer', 'exists:acara,idacara']]);

        $acaraLama = DB::table('acara')->where('idacara', $request->integer('idacara'))->first();

        if (! $acaraLama || $acaraLama->status === false) {
            return $this->jsonResponse(404, 'Acara tidak ditemukan.');
        }

        $validated = $this->validateAcara($request, (int) $request->idacara);

        if (! empty($validated['idparent_acara']) && $acaraLama->has_child) {
            return $this->jsonResponse(422, 'Acara ini masih punya sub-acara, tidak bisa dijadikan sub-acara dari acara lain.');
        }

        DB::table('acara')->where('idacara', $acaraLama->idacara)->update($validated);

        $idParentLama = $acaraLama->idparent_acara;
        $idParentBaru = $validated['idparent_acara'] ?? null;

        if ((int) $idParentLama !== (int) $idParentBaru) {
            if ($idParentLama) {
                $this->recalculateHasChild((int) $idParentLama);
            }

            if ($idParentBaru) {
                $this->recalculateHasChild((int) $idParentBaru);
            }
        }

        return $this->jsonResponse(200, 'Acara berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate(['idacara' => ['required', 'integer']]);

        $acara = DB::table('acara')->where('idacara', $validated['idacara'])->first();

        if (! $acara || $acara->status === false) {
            return $this->jsonResponse(404, 'Acara tidak ditemukan.');
        }

        $jumlahAnakAktif = $this->acaraAktifQuery()
            ->where('idparent_acara', $acara->idacara)
            ->count();

        if ($jumlahAnakAktif > 0) {
            return $this->jsonResponse(409, "Acara ini masih punya {$jumlahAnakAktif} sub-acara aktif, hapus/pindahkan dulu semua sub-acaranya.");
        }

        DB::table('acara')->where('idacara', $acara->idacara)->update(['status' => false]);

        if ($acara->idparent_acara) {
            $this->recalculateHasChild((int) $acara->idparent_acara);
        }

        return $this->jsonResponse(200, 'Acara berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateAcara(Request $request, ?int $idacaraSedangDiedit = null): array
    {
        $perluNarsum = $request->boolean('perlu_narsum');

        $validated = $request->validate([
            'tema' => ['nullable', 'string'],
            'ruang' => ['nullable', 'string', 'max:100'],
            'opsi_pilih' => ['required', 'in:1,2,3'],
            'hari_ke' => ['nullable', 'integer', 'min:1'],
            'jam_mulai' => ['nullable', 'date_format:H:i'],
            'jam_akhir' => ['nullable', 'date_format:H:i', 'after:jam_mulai'],
            'perlu_narsum' => ['required', 'boolean'],
            'idparent_acara' => ['nullable', 'integer', 'exists:acara,idacara'],
            'speaker' => [$perluNarsum ? 'nullable' : 'required', 'string', 'max:255'],
        ]);

        if (! empty($validated['idparent_acara'])) {
            $parent = DB::table('acara')->where('idacara', $validated['idparent_acara'])->first();

            if (! $parent || $parent->status === false || $parent->idparent_acara !== null) {
                throw ValidationException::withMessages([
                    'idparent_acara' => 'Induk acara harus berupa acara utama, bukan sub-acara.',
                ]);
            }

            if ($idacaraSedangDiedit !== null && (int) $validated['idparent_acara'] === $idacaraSedangDiedit) {
                throw ValidationException::withMessages([
                    'idparent_acara' => 'Acara tidak bisa dijadikan induk untuk dirinya sendiri.',
                ]);
            }
        }

        // Nama pembicara untuk acara yang narasumbernya berasal dari alur pengajuan (F05/F06)
        // tidak pernah diisi lewat form ini — hanya relevan saat perlu_narsum = false.
        $validated['speaker'] = $perluNarsum ? null : $validated['speaker'];

        return $validated;
    }

    private function recalculateHasChild(int $idacara): void
    {
        $adaAnakAktif = $this->acaraAktifQuery()
            ->where('idparent_acara', $idacara)
            ->exists();

        DB::table('acara')->where('idacara', $idacara)->update(['has_child' => $adaAnakAktif]);
    }
}
