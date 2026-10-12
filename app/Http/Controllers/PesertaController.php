<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PesertaController extends Controller
{
    /**
     * Role IDs, per the `role` reference table.
     */
    private const ROLE_PESERTA = 2;

    /**
     * Jenis institusi IDs, per the `jenis_institusi` reference table.
     */
    private const JENIS_PERGURUAN_TINGGI = 1;

    private const JENIS_LLDIKTI = 4;

    public function home()
    {
        $menu = 'home';
        $submenu = '';

        $userdata = session('userdata');

        $institusi = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->where('i.idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->select('i.nama_institusi', 'ji.nama_jenis_institusi')
            ->first();

        $pesertaList = $this->pesertaDenganStatusLengkap($userdata['idinstitusi_asal']);
        $jumlahPeserta = $pesertaList->count();
        $jumlahLengkap = $pesertaList->where('lengkap', true)->count();
        $semuaLengkap = $jumlahPeserta > 0 && $jumlahLengkap === $jumlahPeserta;

        return view('peserta.home', compact('menu', 'submenu', 'institusi', 'jumlahPeserta', 'jumlahLengkap', 'semuaLengkap'));
    }

    /**
     * Update the editable columns of the peserta's own institusi_asal row. Which
     * columns are editable depends on the institusi's idjenis_institusi (see
     * docs/features/003-manajemen-institusi-dan-kontingen.md §4).
     */
    public function updateInstitusi(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $institusi = DB::table('institusi_asal')
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->first();

        if (! $institusi) {
            return $this->jsonResponse(404, 'Institusi asal tidak ditemukan.');
        }

        $jenisInstitusi = (int) $institusi->idjenis_institusi;

        $rules = [
            'nama_institusi' => ['required', 'string', 'max:255'],
        ];

        if ($jenisInstitusi === self::JENIS_PERGURUAN_TINGGI) {
            $rules['ptn_pts'] = ['required', 'in:1,2'];
        } elseif ($jenisInstitusi === self::JENIS_LLDIKTI) {
            $rules['idlldikti'] = ['required', 'integer', 'exists:lldikti,idlldikti'];
        }

        $validated = $request->validate($rules);
        $validated['nama_institusi'] = mb_strtoupper(trim($validated['nama_institusi']));

        $dupQuery = DB::table('institusi_asal')
            ->where('idjenis_institusi', $jenisInstitusi)
            ->where('idinstitusi_asal', '!=', $idInstitusiAsal)
            ->whereRaw('lower(nama_institusi) = lower(?)', [$validated['nama_institusi']]);

        if ($jenisInstitusi === self::JENIS_LLDIKTI) {
            $dupQuery->where('idlldikti', $validated['idlldikti']);
        }

        if ($dupQuery->exists()) {
            return $this->jsonResponse(409, 'Nama institusi tersebut sudah dipakai oleh institusi lain.');
        }

        $changes = [];
        $update = ['nama_institusi' => $validated['nama_institusi']];

        if ($institusi->nama_institusi !== $validated['nama_institusi']) {
            $changes[] = "Nama institusi diubah dari '{$institusi->nama_institusi}' menjadi '{$validated['nama_institusi']}'";
        }

        if ($jenisInstitusi === self::JENIS_PERGURUAN_TINGGI) {
            $update['ptn_pts'] = $validated['ptn_pts'];

            if ((string) $institusi->ptn_pts !== (string) $validated['ptn_pts']) {
                $changes[] = sprintf(
                    "PTN/PTS diubah dari '%s' menjadi '%s'",
                    $this->labelPtnPts($institusi->ptn_pts),
                    $this->labelPtnPts($validated['ptn_pts'])
                );
            }
        } elseif ($jenisInstitusi === self::JENIS_LLDIKTI) {
            $update['idlldikti'] = $validated['idlldikti'];

            if ((int) $institusi->idlldikti !== (int) $validated['idlldikti']) {
                $labelLama = DB::table('lldikti')->where('idlldikti', $institusi->idlldikti)->value('nomor_lldikti') ?? '-';
                $labelBaru = DB::table('lldikti')->where('idlldikti', $validated['idlldikti'])->value('nomor_lldikti');
                $changes[] = "Wilayah LLDikti diubah dari '{$labelLama}' menjadi '{$labelBaru}'";
            }
        }

        if (empty($changes)) {
            return $this->jsonResponse(200, 'Tidak ada perubahan data.');
        }

        try {
            DB::transaction(function () use ($idInstitusiAsal, $update, $changes, $userdata) {
                DB::table('institusi_asal')
                    ->where('idinstitusi_asal', $idInstitusiAsal)
                    ->update($update);

                foreach ($changes as $aktifitas) {
                    $this->logInstitusi($idInstitusiAsal, $userdata['idpengguna'], $aktifitas);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal memperbarui data institusi.');
        }

        return $this->jsonResponse(200, 'Data institusi berhasil diperbarui.');
    }

    public function sekontingen()
    {
        $menu = 'sekontingen';
        $submenu = '';

        $userdata = session('userdata');

        $institusi = DB::table('institusi_asal')
            ->where('idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->first();

        $jenisInstitusi = (int) $institusi->idjenis_institusi;

        $lldikti = DB::table('lldikti')->orderBy('idlldikti')->get();

        $pesertaList = $this->pesertaDenganStatusLengkap($userdata['idinstitusi_asal']);

        $jabatanOptions = DB::table('jabatan as j')
            ->join('jenis_institusi_jabatan as jij', 'jij.idkelompok_jabatan', '=', 'j.idkelompok_jabatan')
            ->where('jij.idjenis_institusi', $jenisInstitusi)
            ->select('j.idjabatan', 'j.nama_jabatan')
            ->orderBy('j.nama_jabatan')
            ->get();

        $jenisTransportOptions = DB::table('jenis_transport')
            ->where('status', true)
            ->orderBy('idjenis_transport')
            ->get();

        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();

        return view('peserta.sekontingen', compact('menu', 'submenu', 'institusi', 'lldikti', 'pesertaList', 'jabatanOptions', 'jenisTransportOptions', 'idKendaraanPribadi'));
    }

    /**
     * Fetch a peserta's editable fields, for the "Edit Peserta" modal — scoped to
     * the logged-in peserta's own institusi. The idpeserta travels as an
     * encrypted `token` query value, not a raw GET parameter (CONVENTIONS.md §7).
     */
    public function detailPeserta(Request $request)
    {
        $userdata = session('userdata');
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $peserta = $this->findPesertaInOwnInstitusi((int) $idpeserta, $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        return $this->jsonResponse(200, 'Detail peserta berhasil diambil.', $peserta);
    }

    /**
     * Add a new peserta directly into the logged-in peserta's institusi (same
     * kontingen). No password field and no WA OTP verification here — the person
     * adding it is already authenticated and vouches for the data.
     */
    public function tambahPeserta(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];
        $jenisInstitusi = $this->institusiJenis($idInstitusiAsal);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:500'],
            'no_wa' => ['required', 'string', 'max:30'],
            'idjabatan' => ['required', 'integer', 'exists:jabatan,idjabatan'],
        ]);

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

        if (! $this->jabatanValidUntukJenis((int) $validated['idjabatan'], $jenisInstitusi)) {
            return $this->jsonResponse(422, 'Jabatan tidak sesuai dengan jenis institusi.');
        }

        $nama = mb_strtoupper($validated['nama']);
        $password = $this->generateRandomPassword();

        try {
            $idpengguna = DB::transaction(function () use ($validated, $idInstitusiAsal, $password, $nama) {
                $idpengguna = DB::table('pengguna')->insertGetId([
                    'nama' => $nama,
                    'email' => $validated['email'],
                    'no_wa' => $validated['no_wa'],
                    'password' => Hash::make($password),
                    'idinstitusi_asal' => $idInstitusiAsal,
                    'created_at' => now(),
                    'is_deleted' => false,
                ], 'idpengguna');

                DB::table('role_pengguna')->insert([
                    'idpengguna' => $idpengguna,
                    'idrole' => self::ROLE_PESERTA,
                    'status' => true,
                ]);

                $idpeserta = DB::table('peserta')->insertGetId([
                    'idpengguna' => $idpengguna,
                    'idjabatan' => $validated['idjabatan'],
                ], 'idpeserta');

                $this->registerWajibAcaraUntukPeserta($idpeserta);

                return $idpengguna;
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal menambahkan peserta.');
        }

        $pesan_1 = 'Akun KPPTI 2026 Anda telah dibuat. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$validated['email']} || Password: {$password}";
        $pesan_3 = 'Akun Aktif';

        try {
            $result = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $validated['no_wa']);
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Peserta berhasil ditambahkan, namun informasi login gagal dikirim melalui WhatsApp, PERIKSA NOMOR WHATSAPP dan Silahkan Refresh Halaman!!', ['idpengguna' => $idpengguna]);
        }

        if (strtoupper($result) != 'SUKSES') {
            return $this->jsonResponse(500, 'Peserta berhasil ditambahkan, namun informasi login gagal dikirim melalui WhatsApp, PERIKSA NOMOR WHATSAPP dan Silahkan Refresh Halaman!!', ['idpengguna' => $idpengguna]);
        } else {
            return $this->jsonResponse(200, 'Peserta berhasil ditambahkan dan informasi login telah dikirim melalui WhatsApp.', ['idpengguna' => $idpengguna, 'wa_response' => $result]);
        }

    }

    /**
     * Update another peserta's (or the logged-in peserta's own) editable fields —
     * scoped to the same institusi. Every changed column is logged to log_peserta.
     */
    public function updatePeserta(Request $request)
    {
        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];
        $jenisInstitusi = $this->institusiJenis($idInstitusiAsal);

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'nama' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:500'],
            'no_wa' => ['required', 'string', 'max:30'],
            'idjabatan' => ['required', 'integer', 'exists:jabatan,idjabatan'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $idInstitusiAsal);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $emailDipakai = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where('email', $validated['email'])
            ->where('idpengguna', '!=', $peserta->idpengguna)
            ->exists();

        if ($emailDipakai) {
            return $this->jsonResponse(409, 'Email sudah digunakan oleh pengguna lain.');
        }

        $noWaDipakai = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where('no_wa', $validated['no_wa'])
            ->where('idpengguna', '!=', $peserta->idpengguna)
            ->exists();

        if ($noWaDipakai) {
            return $this->jsonResponse(409, 'Nomor WhatsApp sudah digunakan oleh pengguna lain.');
        }

        if (! $this->jabatanValidUntukJenis((int) $validated['idjabatan'], $jenisInstitusi)) {
            return $this->jsonResponse(422, 'Jabatan tidak sesuai dengan jenis institusi.');
        }

        $nama = mb_strtoupper($validated['nama']);
        $changes = [];

        if ($peserta->nama !== $nama) {
            $changes[] = "Nama diubah menjadi '{$nama}'";
        }

        if ($peserta->email !== $validated['email']) {
            $changes[] = "Email diubah menjadi '{$validated['email']}'";
        }

        if ($peserta->no_wa !== $validated['no_wa']) {
            $changes[] = "Nomor WhatsApp diubah menjadi '{$validated['no_wa']}'";
        }

        if ((int) $peserta->idjabatan !== (int) $validated['idjabatan']) {
            $namaJabatanBaru = DB::table('jabatan')->where('idjabatan', $validated['idjabatan'])->value('nama_jabatan');
            $changes[] = "Jabatan diubah menjadi '{$namaJabatanBaru}'";
        }

        if (empty($changes)) {
            return $this->jsonResponse(200, 'Tidak ada perubahan data.');
        }

        try {
            DB::transaction(function () use ($peserta, $validated, $nama, $changes, $userdata) {
                DB::table('pengguna')
                    ->where('idpengguna', $peserta->idpengguna)
                    ->update([
                        'nama' => $nama,
                        'email' => $validated['email'],
                        'no_wa' => $validated['no_wa'],
                    ]);

                DB::table('peserta')
                    ->where('idpeserta', $peserta->idpeserta)
                    ->update(['idjabatan' => $validated['idjabatan']]);

                foreach ($changes as $aktifitas) {
                    $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], $aktifitas);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal memperbarui data peserta.');
        }

        return $this->jsonResponse(200, 'Data peserta berhasil diperbarui.');
    }

    /**
     * Reset a peserta's password (self or another peserta in the same institusi),
     * following the same pattern as AdminController::resetPassword.
     */
    public function resetPasswordPeserta(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        if (! $peserta->no_wa) {
            return $this->jsonResponse(422, 'Peserta belum memiliki nomor WhatsApp.');
        }

        $password = $this->generateRandomPassword();

        DB::table('pengguna')
            ->where('idpengguna', $peserta->idpengguna)
            ->update(['password' => Hash::make($password)]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Password direset');

        $pesan_1 = 'Password akun KPPTI 2026 Anda telah direset. Berikut informasi login Anda:';
        $pesan_2 = "Email: {$peserta->email} ### Password: {$password}";
        $pesan_3 = 'Akun Aktif';

        try {
            $res = $this->kirim_wa_oca_token_3($pesan_1, $pesan_2, $pesan_3, $peserta->no_wa);
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Password berhasil direset, namun informasi login gagal dikirim melalui WhatsApp.');
        }

        if (strtoupper($res) != strtoupper('sukses')) {
            return $this->jsonResponse(500, 'Password berhasil direset, namun informasi login gagal dikirim melalui WhatsApp. Respon: '.$res);
        } else {
            return $this->jsonResponse(200, 'Password berhasil direset dan informasi login telah dikirim melalui WhatsApp.', ['wa_response' => $res]);
        }

    }

    /**
     * Show the upload/crop page for a peserta's photo (for face recognition
     * enrollment, see docs/features/011-logistik-dan-kartu-kontingen.md §5).
     * The idpeserta travels as an encrypted `token` query value, not a raw GET
     * parameter (CONVENTIONS.md §7).
     */
    public function foto(Request $request)
    {
        $userdata = session('userdata');
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaInOwnInstitusi($idpeserta, $userdata['idinstitusi_asal']);

        if (! $peserta) {
            abort(404);
        }

        $menu = 'sekontingen';
        $submenu = '';
        $token = $this->encryptRouteValue($idpeserta);
        $adaFoto = DB::table('peserta')->where('idpeserta', $idpeserta)->value('path_foto') !== null;

        return view('peserta.foto-peserta', compact('menu', 'submenu', 'peserta', 'idpeserta', 'token', 'adaFoto'));
    }

    /**
     * Serve a peserta's stored photo — never exposed as a static public URL
     * (CONVENTIONS.md §7). The idpeserta travels as an encrypted `token` query
     * value.
     */
    public function tampilFoto(Request $request)
    {
        $userdata = session('userdata');
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $peserta = $this->findPesertaInOwnInstitusi((int) $idpeserta, $userdata['idinstitusi_asal']);

        if (! $peserta) {
            abort(404);
        }

        $pathFoto = DB::table('peserta')->where('idpeserta', (int) $idpeserta)->value('path_foto');

        if (! $pathFoto || ! Storage::disk('local')->exists($pathFoto)) {
            abort(404);
        }

        return Storage::disk('local')->response($pathFoto);
    }

    /**
     * Save a peserta's cropped photo. The browser already crops to the 3:4
     * guide, but the server never trusts that — it always re-encodes to an
     * exact 600×800 JPEG, compressed to fit under 200 KB (see
     * docs/features/011-logistik-dan-kartu-kontingen.md §5.2), regardless
     * of what was uploaded.
     */
    public function updateFoto(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:10240'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $pathLama = DB::table('peserta')->where('idpeserta', $peserta->idpeserta)->value('path_foto');

        try {
            $path = $this->simpanFotoPeserta($peserta->idpeserta, file_get_contents($request->file('foto')->getRealPath()));
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal memproses foto. Silakan coba unggah foto lain.');
        }

        if ($pathLama && $pathLama !== $path && Storage::disk('local')->exists($pathLama)) {
            Storage::disk('local')->delete($pathLama);
        }

        DB::table('peserta')->where('idpeserta', $peserta->idpeserta)->update(['path_foto' => $path]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Foto diperbarui');

        return $this->jsonResponse(200, 'Foto berhasil disimpan.');
    }

    /**
     * Fetch a peserta's logistik fields, for the "Data Logistik" modal — scoped to
     * the logged-in peserta's own institusi. The idpeserta travels as an
     * encrypted `token` query value, not a raw GET parameter (CONVENTIONS.md §7).
     */
    public function detailLogistik(Request $request)
    {
        $userdata = session('userdata');
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaInOwnInstitusi($idpeserta, $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $logistik = DB::table('peserta')
            ->where('idpeserta', $idpeserta)
            ->select(
                'idpeserta',
                'idjenis_transportasi_kedatangan',
                'stasiun_kedatangan',
                'tanggal_kedatangan',
                'jam_kedatangan',
                'idjenis_transportasi_kepulangan',
                'stasiun_kepulangan',
                'tanggal_kepulangan',
                'jam_kepulangan',
                'nama_hotel',
                'city_tour'
            )
            ->first();

        return $this->jsonResponse(200, 'Detail logistik berhasil diambil.', $logistik);
    }

    /**
     * Update a peserta's logistik fields (self or another peserta in the same
     * institusi). Validation for stasiun_kedatangan/kepulangan is conditional:
     * not required when the chosen jenis transportasi is "Kendaraan Pribadi"
     * (see docs/features/011-logistik-dan-kartu-kontingen.md §2.1).
     */
    public function updateLogistik(Request $request)
    {
        $userdata = session('userdata');

        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();

        $rules = [
            'idpeserta' => ['required', 'integer'],
            'idjenis_transportasi_kedatangan' => ['required', 'integer', 'exists:jenis_transport,idjenis_transport'],
            'tanggal_kedatangan' => ['required', 'date'],
            'jam_kedatangan' => ['required'],
            'idjenis_transportasi_kepulangan' => ['required', 'integer', 'exists:jenis_transport,idjenis_transport'],
            'tanggal_kepulangan' => ['required', 'date'],
            'jam_kepulangan' => ['required'],
            'nama_hotel' => ['nullable', 'string', 'max:255'],
            'city_tour' => ['nullable', 'boolean'],
            'stasiun_kedatangan' => (int) $request->input('idjenis_transportasi_kedatangan') === $idKendaraanPribadi
                ? ['nullable', 'string', 'max:255']
                : ['required', 'string', 'max:255'],
            'stasiun_kepulangan' => (int) $request->input('idjenis_transportasi_kepulangan') === $idKendaraanPribadi
                ? ['nullable', 'string', 'max:255']
                : ['required', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $logistikLama = DB::table('peserta')->where('idpeserta', $peserta->idpeserta)->first();

        $update = [
            'idjenis_transportasi_kedatangan' => $validated['idjenis_transportasi_kedatangan'],
            'stasiun_kedatangan' => $validated['stasiun_kedatangan'] ?? null,
            'tanggal_kedatangan' => $validated['tanggal_kedatangan'],
            'jam_kedatangan' => $validated['jam_kedatangan'],
            'idjenis_transportasi_kepulangan' => $validated['idjenis_transportasi_kepulangan'],
            'stasiun_kepulangan' => $validated['stasiun_kepulangan'] ?? null,
            'tanggal_kepulangan' => $validated['tanggal_kepulangan'],
            'jam_kepulangan' => $validated['jam_kepulangan'],
            'nama_hotel' => $validated['nama_hotel'] ?? null,
            'city_tour' => $request->boolean('city_tour'),
        ];

        $labelField = [
            'idjenis_transportasi_kedatangan' => 'Jenis transportasi kedatangan',
            'stasiun_kedatangan' => 'Stasiun/titik kedatangan',
            'tanggal_kedatangan' => 'Tanggal kedatangan',
            'jam_kedatangan' => 'Jam kedatangan',
            'idjenis_transportasi_kepulangan' => 'Jenis transportasi kepulangan',
            'stasiun_kepulangan' => 'Stasiun/titik kepulangan',
            'tanggal_kepulangan' => 'Tanggal kepulangan',
            'jam_kepulangan' => 'Jam kepulangan',
            'nama_hotel' => 'Nama hotel',
            'city_tour' => 'City tour',
        ];

        $kolomWaktu = ['jam_kedatangan', 'jam_kepulangan'];
        $kolomJenisTransport = ['idjenis_transportasi_kedatangan', 'idjenis_transportasi_kepulangan'];
        $namaJenisTransport = DB::table('jenis_transport')->pluck('nama_jenis_transport', 'idjenis_transport');
        $changes = [];

        foreach ($update as $kolom => $nilaiBaru) {
            $nilaiLama = $logistikLama->$kolom;

            if ($kolom === 'city_tour') {
                $nilaiLama = (bool) $nilaiLama;
            } elseif (in_array($kolom, $kolomWaktu, true)) {
                // Normalisasi "HH:MM:SS" (dari DB) vs "HH:MM" (dari input type="time")
                // supaya tidak dianggap "berubah" kalau nilainya sebenarnya sama.
                $nilaiLama = $nilaiLama !== null ? substr($nilaiLama, 0, 5) : null;
            }

            if ($nilaiLama != $nilaiBaru) {
                if (in_array($kolom, $kolomJenisTransport, true)) {
                    $label = $namaJenisTransport[$nilaiBaru] ?? $nilaiBaru;
                } elseif (is_bool($nilaiBaru)) {
                    $label = $nilaiBaru ? 'Ya' : 'Tidak';
                } else {
                    $label = $nilaiBaru;
                }

                $changes[] = "{$labelField[$kolom]} diubah menjadi '{$label}'";
            }
        }

        if (empty($changes)) {
            return $this->jsonResponse(200, 'Tidak ada perubahan data.');
        }

        try {
            DB::transaction(function () use ($peserta, $update, $changes, $userdata) {
                DB::table('peserta')
                    ->where('idpeserta', $peserta->idpeserta)
                    ->update($update);

                foreach ($changes as $aktifitas) {
                    $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], $aktifitas);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal memperbarui data logistik.');
        }

        return $this->jsonResponse(200, 'Data logistik berhasil diperbarui.');
    }

    /**
     * Download the kontingen's registration card (PDF, A5) — only allowed once
     * every peserta in the institusi has complete data (see
     * docs/features/011-logistik-dan-kartu-kontingen.md §2.2).
     */
    public function kartuKontingen()
    {
        $userdata = session('userdata');

        $pesertaList = $this->pesertaDenganStatusLengkap($userdata['idinstitusi_asal']);
        $belumLengkap = $pesertaList->where('lengkap', false);

        if ($pesertaList->isEmpty() || $belumLengkap->isNotEmpty()) {
            $namaBelumLengkap = $belumLengkap->pluck('nama')->implode(', ');
            $pesan = $pesertaList->isEmpty()
                ? 'Belum ada peserta dalam kontingen ini.'
                : "Untuk mengunduh kartu registrasi, harap lengkapi semua data peserta. Belum lengkap: {$namaBelumLengkap}.";

            return redirect()->route('peserta.home')->with('status', [
                'status' => 'danger',
                'message' => $pesan,
            ]);
        }

        $institusi = DB::table('institusi_asal')
            ->where('idinstitusi_asal', $userdata['idinstitusi_asal'])
            ->first();

        return $this->unduhKartuKontingenResponse($institusi);
    }

    /**
     * Show the "Acara" page: the kontingen's peserta list (with a link per
     * peserta to "Pilih Acara") and the full jadwal acara, each row showing
     * which peserta from this kontingen are registered (see
     * docs/features/010-peserta-pilih-acara.md §3–§4).
     */
    public function acara()
    {
        $menu = 'acara';
        $submenu = '';

        $userdata = session('userdata');
        $idInstitusiAsal = $userdata['idinstitusi_asal'];

        $pesertaList = $this->pesertaDenganStatusLengkap($idInstitusiAsal);

        $jumlahAcaraPerPeserta = DB::table('peserta_acara')
            ->whereIn('idpeserta', $pesertaList->pluck('idpeserta'))
            ->select('idpeserta', DB::raw('count(*) as jumlah'))
            ->groupBy('idpeserta')
            ->pluck('jumlah', 'idpeserta');

        $pesertaList = $pesertaList->map(function ($peserta) use ($jumlahAcaraPerPeserta) {
            $peserta->jumlahAcara = (int) ($jumlahAcaraPerPeserta[$peserta->idpeserta] ?? 0);

            return $peserta;
        });

        $namaPerAcara = DB::table('peserta_acara as pa')
            ->join('peserta as pe', 'pe.idpeserta', '=', 'pa.idpeserta')
            ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
            ->where('p.idinstitusi_asal', $idInstitusiAsal)
            ->orderBy('p.nama')
            ->select('pa.idacara', 'p.nama')
            ->get()
            ->groupBy('idacara');

        $topLevel = $this->acaraAktifQuery()->whereNull('idparent_acara')->get();
        $children = $topLevel->isEmpty()
            ? collect()
            : $this->acaraAktifQuery()->whereIn('idparent_acara', $topLevel->pluck('idacara'))->get();

        $narasumberPerAcara = $this->narasumberPerAcara($topLevel->pluck('idacara')->merge($children->pluck('idacara')));

        $lengkapi = function ($acara) use ($namaPerAcara, $narasumberPerAcara) {
            $acara->namaPeserta = $namaPerAcara->get($acara->idacara, collect())->pluck('nama')->values();
            $acara->narasumberList = $narasumberPerAcara->get($acara->idacara, collect())->values();

            return $acara;
        };

        $acaraList = $topLevel->map($lengkapi)->map(function ($acara) use ($children, $lengkapi) {
            $acara->children = $children->where('idparent_acara', $acara->idacara)->map($lengkapi)->values();

            return $acara;
        })->values();

        return view('peserta.acara', compact('menu', 'submenu', 'pesertaList', 'acaraList'));
    }

    /**
     * Show the "Pilih Acara" page for a peserta — scoped to the logged-in
     * peserta's own institusi (see docs/features/010-peserta-pilih-acara.md).
     * The idpeserta travels as an encrypted `token` query value, not a raw GET
     * parameter (CONVENTIONS.md §7).
     */
    public function pilihAcara(Request $request)
    {
        $userdata = session('userdata');
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaInOwnInstitusi($idpeserta, $userdata['idinstitusi_asal']);

        if (! $peserta) {
            abort(404);
        }

        $menu = 'acara';
        $submenu = '';
        $token = $this->encryptRouteValue($idpeserta);

        $adalahPenjagaStand = DB::table('petugas_jaga')->where('idpeserta', $idpeserta)->exists();

        $idacaraTerdaftar = DB::table('peserta_acara')
            ->where('idpeserta', $idpeserta)
            ->pluck('idacara');

        $topLevel = $this->acaraAktifQuery()->whereNull('idparent_acara')->get();
        $children = $topLevel->isEmpty()
            ? collect()
            : $this->acaraAktifQuery()->whereIn('idparent_acara', $topLevel->pluck('idacara'))->get();

        $narasumberPerAcara = $this->narasumberPerAcara($topLevel->pluck('idacara')->merge($children->pluck('idacara')));

        $lengkapi = function ($acara) use ($idacaraTerdaftar, $narasumberPerAcara) {
            $acara->bisaDipilih = ! $acara->has_child && in_array($acara->opsi_pilih, ['2', '3'], true);
            $acara->terkunci = $acara->opsi_pilih === '3';
            $acara->sudahTerdaftar = $idacaraTerdaftar->contains($acara->idacara);
            $acara->narasumberList = $narasumberPerAcara->get($acara->idacara, collect())->values();

            return $acara;
        };

        $acaraList = $topLevel->map($lengkapi)->map(function ($acara) use ($children, $lengkapi) {
            $acara->children = $children->where('idparent_acara', $acara->idacara)->map($lengkapi)->values();

            return $acara;
        })->values();

        return view('peserta.pilih-acara', compact(
            'menu', 'submenu', 'peserta', 'idpeserta', 'token', 'acaraList', 'adalahPenjagaStand'
        ));
    }

    /**
     * Register a peserta (self or another peserta in the same institusi) into
     * an acara. Rejects acara that aren't selectable (has children, or
     * opsi_pilih not 2/3), already-registered acara, and schedule conflicts
     * (see docs/features/010-peserta-pilih-acara.md §5–§6).
     */
    public function daftarAcara(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idacara' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $acara = DB::table('acara')
            ->where('idacara', $validated['idacara'])
            ->where(fn ($q) => $q->where('status', true)->orWhereNull('status'))
            ->first();

        if (! $acara) {
            return $this->jsonResponse(404, 'Acara tidak ditemukan.');
        }

        if ($acara->has_child || $acara->opsi_pilih !== '2') {
            return $this->jsonResponse(422, $acara->opsi_pilih === '3'
                ? 'Acara wajib terdaftar otomatis, tidak perlu didaftarkan manual.'
                : 'Acara ini tidak bisa dipilih.');
        }

        $sudahTerdaftar = DB::table('peserta_acara')
            ->where('idpeserta', $peserta->idpeserta)
            ->where('idacara', $acara->idacara)
            ->exists();

        if ($sudahTerdaftar) {
            return $this->jsonResponse(409, 'Peserta sudah terdaftar di acara ini.');
        }

        $acaraBentrok = $this->acaraBentrok($peserta->idpeserta, $acara);

        if ($acaraBentrok) {
            $jamBentrok = $acaraBentrok->jam_mulai && $acaraBentrok->jam_akhir
                ? substr($acaraBentrok->jam_mulai, 0, 5).'–'.substr($acaraBentrok->jam_akhir, 0, 5)
                : '-';

            return $this->jsonResponse(409, "Bentrok dengan acara yang sudah dipilih: {$acaraBentrok->tema} (Hari {$acaraBentrok->hari_ke}, {$jamBentrok}).");
        }

        DB::table('peserta_acara')->insert([
            'idpeserta' => $peserta->idpeserta,
            'idacara' => $acara->idacara,
        ]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], "Mendaftar acara: {$acara->tema}");

        return $this->jsonResponse(200, 'Berhasil didaftarkan ke acara ini.');
    }

    /**
     * Unregister a peserta (self or another peserta in the same institusi)
     * from an acara. No gate besides acara wajib being locked — cancelling an
     * opsional acara is always allowed.
     */
    public function batalAcara(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idacara' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $pesertaAcara = DB::table('peserta_acara')
            ->where('idpeserta', $peserta->idpeserta)
            ->where('idacara', $validated['idacara'])
            ->first();

        if (! $pesertaAcara) {
            return $this->jsonResponse(404, 'Peserta belum terdaftar di acara ini.');
        }

        $acara = DB::table('acara')->where('idacara', $validated['idacara'])->first();

        if ($acara && $acara->opsi_pilih === '3') {
            return $this->jsonResponse(422, 'Acara wajib tidak bisa dibatalkan.');
        }

        DB::table('peserta_acara')->where('idpeserta_acara', $pesertaAcara->idpeserta_acara)->delete();

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Membatalkan pendaftaran acara: '.($acara->tema ?? '-'));

        return $this->jsonResponse(200, 'Pendaftaran acara berhasil dibatalkan.');
    }

    /**
     * Toggle keikutsertaan acara WAJIB — khusus peserta yang jadi penjaga
     * stand pameran (`petugas_jaga`), dan khusus acara wajib (opsi_pilih=3).
     * Tidak digerbangi `jadwalPenting` — penjaga stand boleh mengubah ini
     * kapan pun, termasuk setelah sesi registrasi acara ditutup. Acara
     * opsional tetap lewat `daftarAcara()`/`batalAcara()` biasa.
     */
    public function toggleAcaraWajibPenjaga(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idacara' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaInOwnInstitusi((int) $validated['idpeserta'], $userdata['idinstitusi_asal']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $adalahPenjagaStand = DB::table('petugas_jaga')->where('idpeserta', $peserta->idpeserta)->exists();

        if (! $adalahPenjagaStand) {
            return $this->jsonResponse(403, 'Hanya penjaga stand pameran yang bisa mengubah keikutsertaan acara wajib.');
        }

        $acara = DB::table('acara')->where('idacara', $validated['idacara'])->first();

        if (! $acara || $acara->has_child || $acara->opsi_pilih !== '3') {
            return $this->jsonResponse(422, 'Ini bukan acara wajib.');
        }

        $pesertaAcara = DB::table('peserta_acara')
            ->where('idpeserta', $peserta->idpeserta)
            ->where('idacara', $acara->idacara)
            ->first();

        if ($pesertaAcara) {
            DB::table('peserta_acara')->where('idpeserta_acara', $pesertaAcara->idpeserta_acara)->delete();

            $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], "Penjaga stand membatalkan keikutsertaan acara wajib: {$acara->tema}");

            return $this->jsonResponse(200, 'Berhasil tidak mengikuti acara wajib ini.');
        }

        $acaraBentrok = $this->acaraBentrok($peserta->idpeserta, $acara);

        if ($acaraBentrok) {
            $jamBentrok = $acaraBentrok->jam_mulai && $acaraBentrok->jam_akhir
                ? substr($acaraBentrok->jam_mulai, 0, 5).'–'.substr($acaraBentrok->jam_akhir, 0, 5)
                : '-';

            return $this->jsonResponse(409, "Bentrok dengan acara yang sudah dipilih: {$acaraBentrok->tema} (Hari {$acaraBentrok->hari_ke}, {$jamBentrok}).");
        }

        DB::table('peserta_acara')->insert([
            'idpeserta' => $peserta->idpeserta,
            'idacara' => $acara->idacara,
        ]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], "Penjaga stand mendaftar ulang acara wajib: {$acara->tema}");

        return $this->jsonResponse(200, 'Berhasil mendaftar ulang ke acara wajib ini.');
    }

    /**
     * Re-encode an uploaded photo into exactly 600×800 JPEG (3:4 portrait),
     * compressed to stay under 200 KB, and store it on the private `local`
     * disk under `foto-peserta/`. Returns the stored relative path.
     */
    private function simpanFotoPeserta(int $idpeserta, string $binaryImage): string
    {
        $sumber = imagecreatefromstring($binaryImage);

        if ($sumber === false) {
            throw new \RuntimeException('Berkas bukan gambar yang valid.');
        }

        $tujuan = imagecreatetruecolor(600, 800);
        imagecopyresampled($tujuan, $sumber, 0, 0, 0, 0, 600, 800, imagesx($sumber), imagesy($sumber));

        $kualitas = 92;

        do {
            ob_start();
            imagejpeg($tujuan, null, $kualitas);
            $data = ob_get_clean();
            $kualitas -= 5;
        } while (strlen($data) > 200 * 1024 && $kualitas > 10);

        $path = "foto-peserta/peserta-{$idpeserta}.jpg";
        Storage::disk('local')->put($path, $data);

        return $path;
    }

    private function institusiJenis(int $idInstitusiAsal): int
    {
        return (int) DB::table('institusi_asal')
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->value('idjenis_institusi');
    }

    private function jabatanValidUntukJenis(int $idJabatan, int $idJenisInstitusi): bool
    {
        return DB::table('jabatan')
            ->join('jenis_institusi_jabatan', 'jenis_institusi_jabatan.idkelompok_jabatan', '=', 'jabatan.idkelompok_jabatan')
            ->where('jenis_institusi_jabatan.idjenis_institusi', $idJenisInstitusi)
            ->where('jabatan.idjabatan', $idJabatan)
            ->exists();
    }

    private function labelPtnPts(?string $value): string
    {
        return match ($value) {
            '1' => 'PTN',
            '2' => 'PTS',
            default => '-',
        };
    }
}
