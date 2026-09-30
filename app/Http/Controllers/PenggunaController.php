<?php

namespace App\Http\Controllers;

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

    public function profile()
    {
        $menu = 'profile';
        $submenu = '';

        $role = DB::table('role')->get();
        $userdata = session('userdata');

        $institusi = $userdata['idinstitusi_asal']
            ? DB::table('institusi_asal')->where('idinstitusi_asal', $userdata['idinstitusi_asal'])->value('nama_institusi')
            : null;

        return view('profile', compact('role', 'institusi', 'menu', 'submenu'));
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

                DB::table('peserta')->insert([
                    'idpengguna' => $idpengguna,
                    'idjabatan' => $validated['idjabatan'],
                ]);

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
        $pesan_2 = "Email: {$validated['email']} === Password: {$validated['password']}";
        $pesan_3 = 'Akun Aktif';

        try {
            $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $validated['nomor_wa']);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')->with('status', [
                'status' => 'success',
                'message' => 'Registrasi berhasil, namun informasi login gagal dikirim melalui WhatsApp. Silakan hubungi panitia.',
            ]);
        }

        return redirect()->route('login')->with('status', [
            'status' => 'success',
            'message' => 'Registrasi berhasil! Informasi login telah dikirim ke WhatsApp Anda. Silakan masuk.',
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

            return DB::table('institusi_asal')->insertGetId([
                'idjenis_institusi' => 1,
                'ptn_pts' => (string) $validated['ptn_pts'],
                'nama_institusi' => $namaUniversitas,
                'tabel_ref_institusi' => 'universitas',
                'idref_institusi' => $validated['iduniversitas'],
                'kode_kontingen' => $this->generateKodeKontingen(),
                'created_at' => now(),
            ], 'idinstitusi_asal');
        }

        $namaInstitusi = trim($validated['nama_institusi']);

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

        return DB::table('institusi_asal')->insertGetId([
            'idjenis_institusi' => $jenisInstitusi,
            'idlldikti' => $jenisInstitusi === 4 ? $validated['idlldikti'] : null,
            'nama_institusi' => $namaInstitusi,
            'kode_kontingen' => $this->generateKodeKontingen(),
            'created_at' => now(),
        ], 'idinstitusi_asal');
    }

    /**
     * Format XXZZZ: XX = registration date (day of month, 2 digits), ZZZ =
     * global sequence of institusi_asal rows created that same day (3 digits).
     */
    private function generateKodeKontingen(): string
    {
        $tanggal = str_pad((string) now()->day, 2, '0', STR_PAD_LEFT);

        $urutan = DB::table('institusi_asal')
            ->whereDate('created_at', now()->toDateString())
            ->count() + 1;

        return $tanggal.str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
    }
}
