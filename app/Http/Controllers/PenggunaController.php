<?php

namespace App\Http\Controllers;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PenggunaController extends Controller
{
    public function registrasi()
    {
        $jenisInstitusi = DB::table('jenis_institusi')->orderBy('idjenis_institusi')->get();
        $lldikti = DB::table('lldikti')->orderBy('nomor_lldikti')->get();

        $jabatanPerJenis = DB::table('jenis_institusi_jabatan')
            ->join('jabatan', 'jabatan.idkelompok_jabatan', '=', 'jenis_institusi_jabatan.idkelompok_jabatan')
            ->select('jenis_institusi_jabatan.idjenis_institusi', 'jabatan.idjabatan', 'jabatan.nama_jabatan')
            ->orderBy('jabatan.nama_jabatan')
            ->get()
            ->groupBy('idjenis_institusi');

        return view('registrasikppti', compact('jenisInstitusi', 'lldikti', 'jabatanPerJenis'));
    }

    public function lupaPassword()
    {
        return view('lupa-password');
    }

    /**
     * Reset password lewat email ATAU no. WA yang dikenali, dikirim ke WA
     * (sama seperti reset password admin — tidak ada link reset email).
     * Respons ke pengguna **selalu identik** terlepas dari apakah
     * email/no. WA itu dikenali atau tidak, dan terlepas dari hasil kirim
     * WA — ini sengaja (dikonfirmasi developer) supaya endpoint ini tidak
     * bisa dipakai untuk mencari tahu email/no. WA mana yang valid
     * (user enumeration). Kegagalan kirim WA tetap di-`report()` untuk
     * visibilitas developer, hanya tidak dibocorkan ke pengguna.
     */
    public function lupaPasswordReset(Request $request)
    {
        $validated = $request->validate([
            'metode' => ['required', 'in:email,wa'],
            'nilai' => ['required', 'string', 'max:255'],
        ]);

        $kolom = $validated['metode'] === 'email' ? 'email' : 'no_wa';

        $pengguna = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where($kolom, trim($validated['nilai']))
            ->first();

        if ($pengguna && $pengguna->no_wa) {
            $password = $this->generateRandomPassword(8);

            DB::table('pengguna')->where('idpengguna', $pengguna->idpengguna)->update([
                'password' => Hash::make($password),
            ]);

            $pesan_1 = 'Ada permintaan reset password untuk akun KPPTI 2026 Anda. Berikut informasi login baru Anda:';
            $pesan_2 = "Email: {$pengguna->email} ### Password: {$password}";
            $pesan_3 = 'Akun Aktif';

            try {
                $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $pengguna->no_wa);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $this->jsonResponse(200, 'Password baru dikirim ke WA.');
    }

    public function profile()
    {
        $menu = 'profile';
        $submenu = '';

        $role = DB::table('role')->get();
        $userdata = session('userdata');

        $institusi = $userdata['idinstitusi_asal']
            ? DB::table('institusi_asal')->where('idinstitusi_asal', $userdata['idinstitusi_asal'])->value('nama_institusi')
            : null;

        $rolePengguna = $this->rolesForPengguna($userdata['idpengguna']);

        return view('profile', compact('role', 'rolePengguna', 'institusi', 'menu', 'submenu'));
    }

    /**
     * Switch which of the signed-in pengguna's own roles is active — same
     * underlying mechanism as AdminController::ubahRoleAktif() (which does
     * this on behalf of another pengguna from the admin-users modal), via
     * the shared activateSingleRole() helper. The target role must already
     * be assigned to the pengguna; this only changes which one is active.
     * Additionally syncs session('userdata.idrole_aktif') so the change
     * takes effect immediately, without requiring the pengguna to log out.
     */
    public function ubahRoleAktif(Request $request)
    {
        $validated = $request->validate([
            'idrole' => ['required', 'integer'],
        ]);

        $userdata = session('userdata');
        $idRole = (int) $validated['idrole'];

        $rolePengguna = DB::table('role_pengguna')
            ->where('idpengguna', $userdata['idpengguna'])
            ->where('idrole', $idRole)
            ->first();

        if (! $rolePengguna) {
            return $this->jsonResponse(404, 'Anda tidak memiliki role tersebut.');
        }

        if ($rolePengguna->status) {
            return $this->jsonResponse(409, 'Role tersebut sudah aktif.');
        }

        if (! array_key_exists($idRole, self::HOME_BY_ROLE)) {
            return $this->jsonResponse(422, 'Area untuk role ini belum tersedia.');
        }

        try {
            DB::transaction(function () use ($userdata, $idRole) {
                $this->activateSingleRole($userdata['idpengguna'], $idRole);
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal mengubah role aktif.');
        }

        $userdata['idrole_aktif'] = $idRole;
        session(['userdata' => $userdata]);

        return $this->jsonResponse(200, 'Role aktif berhasil diubah.', [
            'roles' => $this->rolesForPengguna($userdata['idpengguna']),
            'redirect' => route(self::HOME_BY_ROLE[$idRole]),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini tidak sesuai.',
            ]);
        }

        $user->password = $request->input('password');
        $user->save();

        return back()->with('status', [
            'status' => 'success',
            'message' => 'Kata sandi berhasil diperbarui.',
        ]);
    }

    public function kirimOtp(Request $request)
    {
        $request->validate([
            'no_wa' => ['required', 'string'],
        ]);

        $token = $this->generateRandomToken();

        $arr_insert = [
            'no_wa' => $request->input('no_wa'),
            'token' => $token,
            'created_at' => now(),
        ];

        try {
            DB::table('token')->insert($arr_insert);
        } catch (\Throwable $e) {
            return $this->jsonResponse(500, 'Kode OTP gagal dikirim.');
        }

        $pesan_1 = 'Kode OTP untuk verifikasi akun KPPTI 2026 Anda adalah:';
        $pesan_2 = '*'.$token.'*';
        $pesan_3 = 'Kode ini berlaku selama 5 menit. Jangan bagikan kode ini kepada siapapun.';

        try {
            $result = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $request->input('no_wa'));
        } catch (\Throwable $e) {
            return $this->jsonResponse(500, 'Kode OTP gagal dikirim.');
        }

        $data = json_decode($result, true) ?? $result;

        return $this->jsonResponse(200, 'Kode OTP berhasil dikirim.', $data);
    }

    public function cekOtp(Request $request)
    {
        $request->validate([
            'no_wa' => ['required', 'string'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if (! $this->isOtpValid($request->input('no_wa'), $request->input('otp'))) {
            return $this->jsonResponse(404, 'Kombinasi nomor WhatsApp dan kode OTP tidak ditemukan.');
        }

        return $this->jsonResponse(200, 'Kombinasi nomor WhatsApp dan kode OTP ditemukan.');
    }

    /**
     * Live OTP check for the public registration form. Unlike {@see cekOtp()}
     * (used by the Admin modal), this also enforces a 1-minute expiry.
     */
    public function cekOtpRegistrasi(Request $request)
    {
        $request->validate([
            'no_wa' => ['required', 'string'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if (! $this->isOtpValid($request->input('no_wa'), $request->input('otp'), 60)) {
            return $this->jsonResponse(404, 'Kode OTP salah atau sudah kedaluwarsa.');
        }

        return $this->jsonResponse(200, 'Kode OTP valid.');
    }

    /**
     * Search universitas by name, for the "Perguruan Tinggi" TomSelect on the
     * registration form.
     */
    public function searchUniversitas(Request $request)
    {
        $keyword = $request->string('q')->trim()->value();

        if ($keyword === '') {
            return response()->json([]);
        }

        $universitas = DB::table('universitas')
            ->where('nama_universitas', 'ilike', "%{$keyword}%")
            ->select('iduniversitas', 'nama_universitas')
            ->orderBy('nama_universitas')
            ->limit(20)
            ->get();

        return response()->json($universitas);
    }

    /**
     * Search existing institusi_asal by name (scoped to jenis institusi, and to
     * idlldikti when jenis = LLDikti), so peserta from the same institution can
     * pick the same institusi_asal row instead of creating a duplicate.
     */
    public function searchInstitusiAsal(Request $request)
    {
        $keyword = $request->string('q')->trim()->value();
        $idJenisInstitusi = $request->integer('jenis_institusi');

        if ($keyword === '' || ! $idJenisInstitusi) {
            return response()->json([]);
        }

        $query = DB::table('institusi_asal')
            ->where('idjenis_institusi', $idJenisInstitusi)
            ->where('nama_institusi', 'ilike', "%{$keyword}%");

        if ($idJenisInstitusi === 4 && $request->filled('idlldikti')) {
            $query->where('idlldikti', $request->integer('idlldikti'));
        }

        $institusi = $query->select('idinstitusi_asal', 'nama_institusi')
            ->orderBy('nama_institusi')
            ->limit(20)
            ->get();

        return response()->json($institusi);
    }

    /**
     * Submit the peserta registration form: validate, resolve/create the shared
     * institusi_asal row for the peserta's institution, create the pengguna +
     * role_pengguna + peserta rows in one transaction, then send login
     * credentials via WhatsApp.
     */
    public function storeRegistrasi(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:1000'],
            'jenis_institusi' => ['required', 'integer', 'exists:jenis_institusi,idjenis_institusi'],
            'nomor_wa' => ['required', 'string', 'max:30'],
            'otp' => ['required', 'string', 'size:6'],
            'email' => ['required', 'email', 'max:500'],
            'email_confirmation' => ['required', 'same:email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'ptn_pts' => ['required_if:jenis_institusi,1', 'nullable', 'in:1,2'],
            'iduniversitas' => ['required_if:jenis_institusi,1', 'nullable', 'integer', 'exists:universitas,iduniversitas'],
            'idlldikti' => ['required_if:jenis_institusi,4', 'nullable', 'integer', 'exists:lldikti,idlldikti'],
            'nama_institusi' => ['required_unless:jenis_institusi,1', 'nullable', 'string', 'max:255'],
            'idjabatan' => ['required', 'integer', 'exists:jabatan,idjabatan'],
        ]);

        $jenisInstitusi = (int) $validated['jenis_institusi'];

        $sudahTerdaftar = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where(function ($query) use ($validated) {
                $query->where('email', $validated['email'])
                    ->orWhere('no_wa', $validated['nomor_wa']);
            })
            ->exists();

        if ($sudahTerdaftar) {
            return back()->withErrors(['email' => 'Email atau nomor WhatsApp sudah terdaftar.'])->withInput();
        }

        if (! $this->isOtpValid($validated['nomor_wa'], $validated['otp'], 60)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'])->withInput();
        }

        $jabatanValid = DB::table('jabatan')
            ->join('jenis_institusi_jabatan', 'jenis_institusi_jabatan.idkelompok_jabatan', '=', 'jabatan.idkelompok_jabatan')
            ->where('jenis_institusi_jabatan.idjenis_institusi', $jenisInstitusi)
            ->where('jabatan.idjabatan', $validated['idjabatan'])
            ->exists();

        if (! $jabatanValid) {
            return back()->withErrors(['idjabatan' => 'Jabatan tidak sesuai dengan jenis institusi yang dipilih.'])->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $jenisInstitusi) {
                $idInstitusiAsal = $this->resolveInstitusiAsal($jenisInstitusi, $validated);

                $idpengguna = DB::table('pengguna')->insertGetId([
                    'nama' => mb_strtoupper($validated['nama']),
                    'email' => $validated['email'],
                    'no_wa' => $validated['nomor_wa'],
                    'password' => Hash::make($validated['password']),
                    'idinstitusi_asal' => $idInstitusiAsal,
                    'created_at' => now(),
                    'is_deleted' => false,
                ], 'idpengguna');

                DB::table('role_pengguna')->insert([
                    'idpengguna' => $idpengguna,
                    'idrole' => 2,
                    'status' => true,
                ]);

                $idpeserta = DB::table('peserta')->insertGetId([
                    'idpengguna' => $idpengguna,
                    'idjabatan' => $validated['idjabatan'],
                ], 'idpeserta');

                $this->registerWajibAcaraUntukPeserta($idpeserta);

                $latestToken = DB::table('token')
                    ->where('no_wa', $validated['nomor_wa'])
                    ->orderByDesc('created_at')
                    ->first();

                DB::table('token')
                    ->where('no_wa', $validated['nomor_wa'])
                    ->where('created_at', $latestToken->created_at)
                    ->update([
                        'used_at' => now(),
                        'used_by' => $idpengguna,
                    ]);
            });
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['email' => 'Registrasi gagal diproses. Silakan coba lagi.'])->withInput();
        }

        $pesan_1 = 'Akun KPPTI 2026 Anda telah dibuat. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$validated['email']} || Password: {$validated['password']}";
        $pesan_3 = 'Akun Aktif';

        try {
            $result = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $validated['nomor_wa']);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')->with('status', [
                'status' => 'success',
                'message' => 'Registrasi berhasil, namun informasi login gagal dikirim melalui WhatsApp. Silakan hubungi panitia.',
            ]);
        }

        return redirect()->route('login')->with('status', [
            'status' => 'success',
            'message' => 'Registrasi berhasil, ! Informasi login telah dikirim ke WhatsApp Anda. Silakan masuk.',
        ]);
    }

    /**
     * Find the institusi_asal row shared by everyone from the same institution,
     * or create a new one (with a freshly generated kode_kontingen) if none
     * matches yet.
     *
     * @param  array<string, mixed>  $validated
     */
    private function resolveInstitusiAsal(int $jenisInstitusi, array $validated): int
    {
        if ($jenisInstitusi === 1) {
            $existing = DB::table('institusi_asal')
                ->where('idjenis_institusi', 1)
                ->where('tabel_ref_institusi', 'universitas')
                ->where('idref_institusi', $validated['iduniversitas'])
                ->first();

            if ($existing) {
                return $existing->idinstitusi_asal;
            }

            $namaUniversitas = DB::table('universitas')
                ->where('iduniversitas', $validated['iduniversitas'])
                ->value('nama_universitas');

            $idInstitusiAsal = $this->insertInstitusiAsalDenganKodeUnik([
                'idjenis_institusi' => 1,
                'ptn_pts' => (string) $validated['ptn_pts'],
                'nama_institusi' => mb_strtoupper($namaUniversitas),
                'tabel_ref_institusi' => 'universitas',
                'idref_institusi' => $validated['iduniversitas'],
                'created_at' => now(),
            ], 1);

            $this->logInstitusiBaru($idInstitusiAsal);

            return $idInstitusiAsal;
        }

        $namaInstitusi = mb_strtoupper(trim($validated['nama_institusi']));

        $query = DB::table('institusi_asal')
            ->where('idjenis_institusi', $jenisInstitusi)
            ->whereRaw('lower(nama_institusi) = lower(?)', [$namaInstitusi]);

        if ($jenisInstitusi === 4) {
            $query->where('idlldikti', $validated['idlldikti']);
        }

        $existing = $query->first();

        if ($existing) {
            return $existing->idinstitusi_asal;
        }

        $idInstitusiAsal = $this->insertInstitusiAsalDenganKodeUnik([
            'idjenis_institusi' => $jenisInstitusi,
            'idlldikti' => $jenisInstitusi === 4 ? $validated['idlldikti'] : null,
            'nama_institusi' => $namaInstitusi,
            'created_at' => now(),
        ], $jenisInstitusi);

        $this->logInstitusiBaru($idInstitusiAsal);

        return $idInstitusiAsal;
    }

    /**
     * Insert a new institusi_asal row with a freshly generated kode_kontingen,
     * retrying with a newly generated code if a concurrent request already
     * claimed the one just generated (institusi_asal.kode_kontingen has a
     * unique index — generateKodeKontingen()'s count-then-insert is not
     * atomic, so two requests in the same month can race for the same
     * sequence number).
     *
     * @param  array<string, mixed>  $dataTanpaKode
     */
    private function insertInstitusiAsalDenganKodeUnik(array $dataTanpaKode, int $idJenisInstitusi): int
    {
        $maksimalPercobaan = 5;

        for ($percobaan = 1; $percobaan <= $maksimalPercobaan; $percobaan++) {
            try {
                return DB::table('institusi_asal')->insertGetId(
                    $dataTanpaKode + ['kode_kontingen' => $this->generateKodeKontingen($idJenisInstitusi)],
                    'idinstitusi_asal'
                );
            } catch (UniqueConstraintViolationException $e) {
                if ($percobaan === $maksimalPercobaan) {
                    throw $e;
                }
            }
        }
    }

    /**
     * Format MMZZZYY: MM = registration month (2 digits), ZZZ = sequence of
     * institusi_asal rows created that same month (3 digits), YY =
     * idjenis_institusi (2 digits).
     */
    private function generateKodeKontingen(int $idJenisInstitusi): string
    {
        $bulan = now()->format('m');

        $urutan = DB::table('institusi_asal')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1;

        $jenis = str_pad((string) $idJenisInstitusi, 2, '0', STR_PAD_LEFT);

        return $bulan.str_pad((string) $urutan, 3, '0', STR_PAD_LEFT).$jenis;
    }

    /**
     * Record the creation of a new institusi_asal row in log_institusi. Called
     * during self-registration, where there is no authenticated pengguna yet,
     * so `done_by` is left null.
     */
    private function logInstitusiBaru(int $idInstitusiAsal): void
    {
        $this->logInstitusi($idInstitusiAsal, null, 'Create institusi baru');
    }
}
