<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Role IDs, per the `role` reference table.
     */
    private const ROLE_ADMIN = 1;

    private const ROLE_SC = 4;

    private const ROLE_PETUGAS_KIT = 5;

    private const ROLE_MASTER_SC = 6;

    /**
     * Maps the "box" slug used throughout this page/view to its role ID.
     *
     * @var array<string, int>
     */
    private const IDROLE_BY_BOX = [
        'admin' => self::ROLE_ADMIN,
        'sc' => self::ROLE_SC,
        'petugas-kit' => self::ROLE_PETUGAS_KIT,
        'master-sc' => self::ROLE_MASTER_SC,
    ];

    public function index()
    {
        $menu = 'home';
        $submenu = '';

        return view('admin.home', compact('menu', 'submenu'));
    }

    public function adminusers()
    {
        $menu = 'users';
        $submenu = 'admin';

        $adminUsers = $this->getUsersByRole(self::ROLE_ADMIN);
        $scUsers = $this->getUsersByRole(self::ROLE_SC);
        $petugasKitUsers = $this->getUsersByRole(self::ROLE_PETUGAS_KIT);
        $masterScUsers = $this->getUsersByRole(self::ROLE_MASTER_SC);

        return view('admin.admin-users', compact('menu', 'submenu', 'adminUsers', 'scUsers', 'petugasKitUsers', 'masterScUsers'));
    }

    /**
     * Search non-deleted pengguna by name, for the "tambah pengguna lama" modal's remote select.
     */
    public function searchPengguna(Request $request)
    {
        $keyword = $request->string('q')->trim()->value();

        if ($keyword === '') {
            return response()->json([]);
        }

        $pengguna = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where('nama', 'ilike', "%{$keyword}%")
            ->select('idpengguna', 'nama', 'email', 'no_wa')
            ->orderBy('nama')
            ->limit(20)
            ->get();

        return response()->json($pengguna);
    }

    /**
     * Create a brand-new pengguna (not yet in the `pengguna` table) and grant them
     * the role tied to the given box (see IDROLE_BY_BOX).
     */
    public function tambahPenggunaBaru(Request $request)
    {
        $validated = $request->validate([
            'boxId' => ['required', 'string', 'in:'.implode(',', array_keys(self::IDROLE_BY_BOX))],
            'nama' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:500'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $validated['nama'] = mb_strtoupper($validated['nama']);

        $idrole = self::IDROLE_BY_BOX[$validated['boxId']];

        $sudahTerdaftar = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where(function ($query) use ($validated) {
                $query->where('email', $validated['email'])
                    ->orWhere('no_wa', $validated['no_wa']);
            })
            ->exists();

        if ($sudahTerdaftar) {
            return $this->jsonResponse(409, 'Email atau nomor WhatsApp sudah terdaftar.');
        }

        $password = $this->generateRandomPassword(10);

        try {
            $idpengguna = DB::transaction(function () use ($validated, $idrole, $password) {
                $idpengguna = DB::table('pengguna')->insertGetId([
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'no_wa' => $validated['no_wa'],
                    'password' => Hash::make($password),
                    'created_at' => now(),
                    'is_deleted' => false,
                ], 'idpengguna');

                DB::table('role_pengguna')->insert([
                    'idpengguna' => $idpengguna,
                    'idrole' => $idrole,
                    'status' => true,
                ]);

                return $idpengguna;
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menambahkan pengguna.');
        }

        $pesan_1 = 'Akun KPPTI 2026 Anda telah dibuat. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$validated['email']}\nPassword: {$password}";
        $pesan_3 = 'Akun Aktif';

        try {
            $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $validated['no_wa']);
        } catch (\Throwable $e) {
            return $this->jsonResponse(500, 'Pengguna berhasil ditambahkan, namun informasi login gagal dikirim melalui WhatsApp.', ['idpengguna' => $idpengguna, 'token' => $this->encryptRouteValue($idpengguna)]);
        }

        return $this->jsonResponse(200, 'Pengguna berhasil ditambahkan dan informasi login telah dikirim melalui WhatsApp.', ['idpengguna' => $idpengguna, 'token' => $this->encryptRouteValue($idpengguna)]);
    }

    /**
     * Grant an existing pengguna the role tied to the given box (see
     * IDROLE_BY_BOX). All of the pengguna's other active roles are
     * deactivated so only the newly granted one remains active.
     */
    public function tambahPenggunaLama(Request $request)
    {
        $validated = $request->validate([
            'boxId' => ['required', 'string', 'in:'.implode(',', array_keys(self::IDROLE_BY_BOX))],
            'idpengguna' => ['required', 'integer'],
        ]);

        $idrole = self::IDROLE_BY_BOX[$validated['boxId']];

        $pengguna = DB::table('pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('is_deleted', false)
            ->first();

        if (! $pengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        $sudahAktif = DB::table('role_pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('idrole', $idrole)
            ->where('status', true)
            ->exists();

        if ($sudahAktif) {
            return $this->jsonResponse(409, 'Pengguna sudah memiliki role tersebut secara aktif.');
        }

        try {
            DB::transaction(function () use ($validated, $idrole) {
                $this->activateSingleRole($validated['idpengguna'], $idrole);
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menambahkan role pengguna.');
        }

        return $this->jsonResponse(200, 'Role pengguna berhasil ditambahkan.', ['idpengguna' => $pengguna->idpengguna, 'token' => $this->encryptRouteValue($pengguna->idpengguna)]);
    }

    /**
     * Remove a pengguna's membership in the role tied to the given box (see
     * IDROLE_BY_BOX) entirely — deletes the `role_pengguna` row, so they
     * disappear from that box's list (unlike toggling `status`, which only
     * changes which role is active). If that was their only active role,
     * the first remaining role (if any) is activated so they aren't left
     * without one. Removing the last remaining Admin is blocked, since
     * that would lock everyone out of user management.
     */
    public function hapusRole(Request $request)
    {
        $validated = $request->validate([
            'boxId' => ['required', 'string', 'in:'.implode(',', array_keys(self::IDROLE_BY_BOX))],
            'idpengguna' => ['required', 'integer'],
        ]);

        $idrole = self::IDROLE_BY_BOX[$validated['boxId']];

        $rolePengguna = DB::table('role_pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('idrole', $idrole)
            ->first();

        if (! $rolePengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak memiliki role tersebut.');
        }

        if ($idrole === self::ROLE_ADMIN) {
            $jumlahAdminLain = DB::table('role_pengguna as rp')
                ->join('pengguna as p', 'p.idpengguna', '=', 'rp.idpengguna')
                ->where('rp.idrole', self::ROLE_ADMIN)
                ->where('rp.idpengguna', '!=', $validated['idpengguna'])
                ->where('p.is_deleted', false)
                ->count();

            if ($jumlahAdminLain === 0) {
                return $this->jsonResponse(422, 'Tidak bisa menghapus role Admin terakhir yang tersisa.');
            }
        }

        DB::transaction(function () use ($validated, $rolePengguna) {
            DB::table('role_pengguna')->where('idrole_pengguna', $rolePengguna->idrole_pengguna)->delete();

            $masihAdaAktif = DB::table('role_pengguna')->where('idpengguna', $validated['idpengguna'])->where('status', true)->exists();

            if (! $masihAdaAktif) {
                $roleLain = DB::table('role_pengguna')->where('idpengguna', $validated['idpengguna'])->first();

                if ($roleLain) {
                    DB::table('role_pengguna')->where('idrole_pengguna', $roleLain->idrole_pengguna)->update(['status' => true]);
                }
            }
        });

        return $this->jsonResponse(200, 'Role pengguna berhasil dihapus.');
    }

    /**
     * Fetch a pengguna's details (every `pengguna` column except password) plus every
     * role they hold and its active status, for the "Detail Pengguna" modal. The
     * idpengguna travels as an encrypted `token` query value, not a raw GET
     * parameter — see CONVENTIONS.md §7.
     */
    public function detailPengguna(Request $request)
    {
        $idpengguna = $this->decryptRouteValue($request->query('token'));

        if ($idpengguna === null) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        $idpengguna = (int) $idpengguna;

        $pengguna = DB::table('pengguna as p')
            ->leftJoin('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->where('p.idpengguna', $idpengguna)
            ->select('p.idpengguna', 'p.nama', 'p.email', 'p.no_wa', 'p.created_at', 'p.is_deleted', 'i.nama_institusi')
            ->first();

        if (! $pengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        $roles = $this->rolesForPengguna($idpengguna);

        return $this->jsonResponse(200, 'Detail pengguna berhasil diambil.', [
            'pengguna' => $pengguna,
            'roles' => $roles,
        ]);
    }

    /**
     * Switch which of a pengguna's existing roles is active. The target role must already
     * be assigned to the pengguna — this only changes which one is active, it does not
     * grant a new role. Only one role may be active at a time.
     */
    public function ubahRoleAktif(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
            'idrole' => ['required', 'integer'],
        ]);

        $rolePengguna = DB::table('role_pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('idrole', $validated['idrole'])
            ->first();

        if (! $rolePengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak memiliki role tersebut.');
        }

        if ($rolePengguna->status) {
            return $this->jsonResponse(409, 'Role tersebut sudah aktif.');
        }

        try {
            DB::transaction(function () use ($validated) {
                $this->activateSingleRole($validated['idpengguna'], $validated['idrole']);
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengubah role aktif.');
        }

        return $this->jsonResponse(200, 'Role aktif berhasil diubah.', [
            'roles' => $this->rolesForPengguna($validated['idpengguna']),
        ]);
    }

    /**
     * Update a pengguna's editable fields (nama, no_wa) from the "Edit Pengguna" modal.
     * Email, institusi asal, and password are not editable here.
     */
    public function updatePengguna(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
            'nama' => ['required', 'string', 'max:1000'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $pengguna = DB::table('pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('is_deleted', false)
            ->first();

        if (! $pengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        $noWaDipakai = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where('no_wa', $validated['no_wa'])
            ->where('idpengguna', '!=', $validated['idpengguna'])
            ->exists();

        if ($noWaDipakai) {
            return $this->jsonResponse(409, 'Nomor WhatsApp sudah digunakan oleh pengguna lain.');
        }

        $nama = mb_strtoupper($validated['nama']);

        DB::table('pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->update([
                'nama' => $nama,
                'no_wa' => $validated['no_wa'],
            ]);

        return $this->jsonResponse(200, 'Data pengguna berhasil diperbarui.', [
            'idpengguna' => $validated['idpengguna'],
            'nama' => $nama,
            'no_wa' => $validated['no_wa'],
        ]);
    }

    /**
     * Generate a new password for a pengguna and send it, together with their email,
     * to the no_wa currently saved in the database (not any unsaved edit in the modal).
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'idpengguna' => ['required', 'integer'],
        ]);

        $pengguna = DB::table('pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->where('is_deleted', false)
            ->first();

        if (! $pengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak ditemukan.');
        }

        if (! $pengguna->no_wa) {
            return $this->jsonResponse(422, 'Pengguna belum memiliki nomor WhatsApp.');
        }

        $password = $this->generateRandomPassword(8);

        DB::table('pengguna')
            ->where('idpengguna', $validated['idpengguna'])
            ->update(['password' => Hash::make($password)]);

        $pesan_1 = 'Password akun KPPTI 2026 Anda telah direset. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$pengguna->email} ### Password: {$password}";
        $pesan_3 = 'Akun Aktif';

        try {
            $res = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $pengguna->no_wa);
        } catch (\Throwable $e) {
            return $this->jsonResponse(500, 'Password berhasil direset, namun informasi login gagal dikirim melalui WhatsApp.');
        }

        return $this->jsonResponse(200, 'Password berhasil direset dan informasi login telah dikirim melalui WhatsApp.', $res);
    }

    /**
     * @return Collection<int, object>
     */
    private function getUsersByRole(int $idrole)
    {
        return DB::table('pengguna as p')
            ->join('role_pengguna as rp', function ($join) {
                $join->on('rp.idpengguna', '=', 'p.idpengguna');
            })
            ->where('rp.idrole', $idrole)
            ->where('p.is_deleted', false)
            ->select('p.idpengguna', 'p.nama', 'p.email', 'p.no_wa')
            ->orderBy('p.nama')
            ->get()
            ->map(function ($user) {
                $user->token = $this->encryptRouteValue($user->idpengguna);

                return $user;
            });
    }
}
