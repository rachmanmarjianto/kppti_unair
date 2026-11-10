<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PesertaAdminController extends Controller
{
    /**
     * Role ID Peserta, per tabel referensi `role`.
     */
    private const ROLE_PESERTA = 2;

    /**
     * idjabatan yang dianggap "pimpinan" institusi (puncak + wakil, per
     * kelompok jabatan: Perguruan Tinggi, asosiasi/lembaga/pemerhati,
     * LLDikti) — dikonfirmasi developer, bukan flag di tabel jabatan.
     */
    private const JABATAN_PIMPINAN = [1, 2, 6, 7, 9, 10];

    public function index()
    {
        $menu = 'users';
        $submenu = 'peserta';

        $pesertaList = $this->pesertaDenganStatusLengkap();

        $institusiList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->select('i.idinstitusi_asal', 'i.idjenis_institusi', 'i.nama_institusi', 'i.kode_kontingen', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) use ($pesertaList) {
                $institusi->pesertaList = $pesertaList->where('idinstitusi_asal', $institusi->idinstitusi_asal)->values();
                $institusi->jumlahPeserta = $institusi->pesertaList->count();
                $institusi->semuaLengkap = $institusi->jumlahPeserta > 0 && $institusi->pesertaList->every(fn ($p) => $p->lengkap);
                $institusi->token = $this->encryptRouteValue($institusi->idinstitusi_asal);

                return $institusi;
            });

        $jenisInstitusiList = $institusiList->groupBy('nama_jenis_institusi')->map(function ($institusiPerJenis, $namaJenis) {
            return (object) [
                'nama_jenis_institusi' => $namaJenis,
                'institusiList' => $institusiPerJenis->values(),
                'jumlahInstitusi' => $institusiPerJenis->count(),
                'jumlahPeserta' => $institusiPerJenis->sum('jumlahPeserta'),
            ];
        })->values();

        $jabatanPerJenis = DB::table('jabatan as j')
            ->join('jenis_institusi_jabatan as jij', 'jij.idkelompok_jabatan', '=', 'j.idkelompok_jabatan')
            ->select('jij.idjenis_institusi', 'j.idjabatan', 'j.nama_jabatan')
            ->orderBy('j.nama_jabatan')
            ->get()
            ->groupBy('idjenis_institusi');

        $dashboard = [
            'totalPeserta' => $pesertaList->count(),
            'totalInstitusi' => $institusiList->where('jumlahPeserta', '>', 0)->count(),
            'jumlahCityTour' => $pesertaList->where('city_tour', true)->count(),
            'jumlahLengkap' => $pesertaList->where('lengkap', true)->count(),
            'jumlahBelumLengkap' => $pesertaList->where('lengkap', false)->count(),
            'kontingenSiapCetak' => $institusiList->where('semuaLengkap', true)->count(),
            'kontingenBelumSiap' => $institusiList->where('jumlahPeserta', '>', 0)->where('semuaLengkap', false)->count(),
            'jumlahSudahCard' => $pesertaList->filter(fn ($p) => ! empty($p->idcard))->count(),
            'jumlahFotoLengkap' => $pesertaList->where('fotoLengkap', true)->count(),
        ];

        return view('admin.peserta', compact('menu', 'submenu', 'jenisInstitusiList', 'institusiList', 'dashboard', 'jabatanPerJenis'));
    }

    /**
     * Tambahkan peserta baru ke kontingen manapun — duplikasi
     * PesertaController::tambahPeserta() apa adanya (akun baru, role
     * Peserta, kirim kredensial lewat WA, daftar otomatis ke acara
     * wajib), bedanya institusi tujuan dipilih Admin lewat input (bukan
     * dari session, karena Admin tidak terikat satu kontingen) dan rute
     * ini SENGAJA TIDAK digerbangi jadwalPenting — Admin boleh menambah
     * peserta kapan pun walau sesi registrasi peserta sudah ditutup.
     */
    public function tambahPeserta(Request $request)
    {
        $validated = $request->validate([
            'idinstitusi_asal' => ['required', 'integer', 'exists:institusi_asal,idinstitusi_asal'],
            'nama' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:500'],
            'no_wa' => ['required', 'string', 'max:30'],
            'idjabatan' => ['required', 'integer', 'exists:jabatan,idjabatan'],
        ]);

        $idInstitusiAsal = (int) $validated['idinstitusi_asal'];
        $jenisInstitusi = $this->institusiJenis($idInstitusiAsal);

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
        }

        return $this->jsonResponse(200, 'Peserta berhasil ditambahkan dan informasi login telah dikirim melalui WhatsApp.', ['idpengguna' => $idpengguna, 'wa_response' => $result]);
    }

    /**
     * Submenu "List Pimpinan" — daftar peserta aktif yang jabatannya
     * termasuk JABATAN_PIMPINAN, lintas institusi.
     */
    public function listPimpinan()
    {
        $menu = 'users';
        $submenu = 'list-pimpinan';

        $pimpinanList = $this->pesertaAktifQuery()
            ->join('institusi_asal as ia', 'ia.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'ia.idjenis_institusi')
            ->whereIn('pe.idjabatan', self::JABATAN_PIMPINAN)
            ->select('ia.nama_institusi', 'p.nama', 'j.nama_jabatan', 'p.no_wa', 'ji.nama_jenis_institusi')
            ->orderBy('ia.nama_institusi')
            ->get();

        $jenisInstitusiList = DB::table('jenis_institusi')->orderBy('nama_jenis_institusi')->get();

        return view('admin.list-pimpinan', compact('menu', 'submenu', 'pimpinanList', 'jenisInstitusiList'));
    }

    /**
     * Pindahkan satu peserta ke institusi_asal (kontingen) lain — dibutuhkan
     * karena data master `universitas` punya duplikat nama (dikonfirmasi
     * developer), yang membuat peserta tak sengaja terdaftar di kontingen
     * yang salah. Submit form biasa (bukan AJAX, dikonfirmasi developer),
     * jadi responsnya flash `status` + redirect, bukan `jsonResponse()`.
     */
    public function pindahKontingen(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer', 'exists:peserta,idpeserta'],
            'idinstitusi_asal_baru' => ['required', 'integer', 'exists:institusi_asal,idinstitusi_asal'],
        ]);

        $peserta = DB::table('peserta as pe')
            ->join('pengguna as p', 'p.idpengguna', '=', 'pe.idpengguna')
            ->where('pe.idpeserta', $validated['idpeserta'])
            ->select('pe.idpeserta', 'p.idpengguna', 'p.nama', 'p.idinstitusi_asal')
            ->first();

        $idInstitusiBaru = (int) $validated['idinstitusi_asal_baru'];

        if ($peserta->idinstitusi_asal === $idInstitusiBaru) {
            return redirect()->route('admin.peserta')->with('status', [
                'status' => 'danger',
                'message' => 'Peserta tersebut sudah berada di kontingen itu.',
            ]);
        }

        $namaInstitusiLama = DB::table('institusi_asal')->where('idinstitusi_asal', $peserta->idinstitusi_asal)->value('nama_institusi');
        $namaInstitusiBaru = DB::table('institusi_asal')->where('idinstitusi_asal', $idInstitusiBaru)->value('nama_institusi');

        DB::transaction(function () use ($peserta, $idInstitusiBaru, $namaInstitusiLama, $namaInstitusiBaru, $userdata) {
            DB::table('pengguna')->where('idpengguna', $peserta->idpengguna)->update(['idinstitusi_asal' => $idInstitusiBaru]);

            $this->logPeserta(
                $peserta->idpeserta,
                $userdata['idpengguna'],
                "Dipindahkan dari kontingen '{$namaInstitusiLama}' ke kontingen '{$namaInstitusiBaru}' oleh admin"
            );
        });

        return redirect()->route('admin.peserta')->with('status', [
            'status' => 'success',
            'message' => "Peserta '{$peserta->nama}' berhasil dipindahkan ke kontingen '{$namaInstitusiBaru}'.",
        ]);
    }

    /**
     * Fetch a peserta's full detail (personal, institusi, logistik, status foto)
     * for the "Detail Peserta" modal — read-only, cross-institusi (an Admin may
     * view any peserta). The idpeserta travels as an encrypted `token` query
     * value, not a raw GET parameter (CONVENTIONS.md §7).
     */
    public function detailPeserta(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idpeserta = (int) $idpeserta;

        $peserta = DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->join('jabatan as j', 'j.idjabatan', '=', 'pe.idjabatan')
            ->join('institusi_asal as i', 'i.idinstitusi_asal', '=', 'p.idinstitusi_asal')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->leftJoin('jenis_transport as jtk', 'jtk.idjenis_transport', '=', 'pe.idjenis_transportasi_kedatangan')
            ->leftJoin('jenis_transport as jtp', 'jtp.idjenis_transport', '=', 'pe.idjenis_transportasi_kepulangan')
            ->where('pe.idpeserta', $idpeserta)
            ->where('p.is_deleted', false)
            ->select(
                'p.nama', 'p.email', 'p.no_wa', 'j.nama_jabatan',
                'i.nama_institusi', 'ji.nama_jenis_institusi', 'i.kode_kontingen',
                'jtk.nama_jenis_transport as nama_transport_kedatangan', 'pe.stasiun_kedatangan', 'pe.tanggal_kedatangan', 'pe.jam_kedatangan',
                'jtp.nama_jenis_transport as nama_transport_kepulangan', 'pe.stasiun_kepulangan', 'pe.tanggal_kepulangan', 'pe.jam_kepulangan',
                'pe.nama_hotel', 'pe.city_tour',
                'pe.idjenis_transportasi_kedatangan', 'pe.idjenis_transportasi_kepulangan', 'pe.path_foto'
            )
            ->first();

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();
        $peserta->logistikLengkap = $this->isLogistikLengkap($peserta, $idKendaraanPribadi);
        $peserta->fotoLengkap = $peserta->path_foto !== null;
        $peserta->lengkap = $peserta->logistikLengkap && $peserta->fotoLengkap;
        unset($peserta->path_foto, $peserta->idjenis_transportasi_kedatangan, $peserta->idjenis_transportasi_kepulangan);

        return $this->jsonResponse(200, 'Detail peserta berhasil diambil.', $peserta);
    }

    /**
     * Serve a peserta's stored photo for the admin "Detail Peserta" modal —
     * never exposed as a static public URL (CONVENTIONS.md §7). Cross-
     * institusi (an Admin may view any peserta's photo), unlike
     * PesertaController::tampilFoto() which is scoped to the peserta's own
     * kontingen. The idpeserta travels as an encrypted `token` query value.
     */
    public function tampilFoto(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $pathFoto = DB::table('peserta')->where('idpeserta', (int) $idpeserta)->value('path_foto');

        if (! $pathFoto || ! Storage::disk('local')->exists($pathFoto)) {
            abort(404);
        }

        return Storage::disk('local')->response($pathFoto);
    }

    /**
     * Show the upload/crop page for any peserta's photo — same as
     * PesertaController::foto(), just not scoped to one institusi (an Admin
     * may edit any peserta).
     */
    public function foto(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaById($idpeserta);

        if (! $peserta) {
            abort(404);
        }

        $menu = 'users';
        $submenu = 'peserta';
        $token = $this->encryptRouteValue($idpeserta);
        $adaFoto = DB::table('peserta')->where('idpeserta', $idpeserta)->value('path_foto') !== null;

        return view('admin.foto-peserta', compact('menu', 'submenu', 'peserta', 'idpeserta', 'token', 'adaFoto'));
    }

    /**
     * Save any peserta's cropped photo — same rules and re-encoding as
     * PesertaController::updateFoto() (`simpanFotoPeserta()`, now shared on
     * the base Controller), just not scoped to one institusi.
     */
    public function updateFoto(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:10240'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

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

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Foto diperbarui oleh admin');

        return $this->jsonResponse(200, 'Foto berhasil disimpan.');
    }

    /**
     * Show the "Edit Logistik" page for any peserta — same fields as modal
     * "Data Logistik" di sisi Peserta (`PesertaController::detailLogistik()`),
     * tapi sebagai halaman penuh (bukan modal+AJAX): nilai awal langsung
     * diisi dari sini, bukan di-fetch ulang lewat JS. `pesertaLainLengkap`
     * (kandidat "Salin Data dari Peserta Lain") di-scope ke kontingen
     * peserta ini, bukan lintas institusi.
     */
    public function logistik(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaById($idpeserta);

        if (! $peserta) {
            abort(404);
        }

        $menu = 'users';
        $submenu = 'peserta';
        $token = $this->encryptRouteValue($idpeserta);

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

        $jenisTransportOptions = DB::table('jenis_transport')
            ->where('status', true)
            ->orderBy('idjenis_transport')
            ->get();

        $idKendaraanPribadi = $this->idJenisTransportKendaraanPribadi();

        $pesertaLainLengkap = $this->pesertaDenganStatusLengkap($peserta->idinstitusi_asal)
            ->where('logistikLengkap', true)
            ->where('idpeserta', '!=', $idpeserta)
            ->values();

        return view('admin.logistik-peserta', compact(
            'menu', 'submenu', 'peserta', 'idpeserta', 'token', 'logistik',
            'jenisTransportOptions', 'idKendaraanPribadi', 'pesertaLainLengkap'
        ));
    }

    /**
     * Update any peserta's logistik fields — same validation and change-log
     * logic as PesertaController::updateLogistik(), just not scoped to one
     * institusi.
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

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

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
                    $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], $aktifitas.' (oleh admin)');
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->jsonResponse(500, 'Gagal memperbarui data logistik.');
        }

        return $this->jsonResponse(200, 'Data logistik berhasil diperbarui.');
    }

    /**
     * Reset a peserta's password — scoped across every institusi (an Admin isn't
     * part of any single kontingen), same pattern as
     * PesertaController::resetPasswordPeserta().
     */
    public function resetPassword(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

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
        }

        return $this->jsonResponse(200, 'Password berhasil direset dan informasi login telah dikirim melalui WhatsApp.', ['wa_response' => $res]);
    }

    /**
     * Ubah email peserta — email dipakai sebagai kredensial login, jadi
     * wajib unik lintas seluruh `pengguna` (bukan cuma lintas peserta),
     * dicek manual (bukan rule `unique:`) konsisten dengan pola
     * `PenggunaController::storeRegistrasi()`.
     */
    public function updateEmail(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'email' => ['required', 'email', 'max:500'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $emailBaru = $validated['email'];

        if ($emailBaru === $peserta->email) {
            return $this->jsonResponse(422, 'Email baru sama dengan email saat ini.');
        }

        $sudahDipakai = DB::table('pengguna')
            ->where('is_deleted', false)
            ->where('idpengguna', '!=', $peserta->idpengguna)
            ->where('email', $emailBaru)
            ->exists();

        if ($sudahDipakai) {
            return $this->jsonResponse(422, 'Email ini sudah digunakan oleh pengguna lain.');
        }

        DB::table('pengguna')->where('idpengguna', $peserta->idpengguna)->update(['email' => $emailBaru]);

        $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], "Email diubah oleh admin dari {$peserta->email} menjadi {$emailBaru}");

        return $this->jsonResponse(200, 'Email peserta berhasil diperbarui.');
    }

    /**
     * Hapus role Peserta dari seorang pengguna (pola sama seperti
     * AdminController::hapusRole() untuk box admin/sc/dst, tapi role-nya
     * tetap Peserta dan ada aturan tambahan): kalau pengguna itu punya role
     * lain, baris `role_pengguna` untuk Peserta dihapus — kalau role
     * Peserta yang tadi aktif, satu role lain diaktifkan supaya pengguna
     * tidak ditinggal tanpa role aktif. Kalau Peserta adalah satu-satunya
     * role yang dia punya, baris `role_pengguna` TIDAK dihapus (sengaja —
     * pengguna harus tetap punya minimal satu role), melainkan
     * `pengguna.is_deleted` diset true supaya pengguna tersebut tidak lagi
     * dianggap aktif di seluruh aplikasi.
     */
    public function hapusRolePeserta(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

        if (! $peserta) {
            return $this->jsonResponse(404, 'Peserta tidak ditemukan.');
        }

        $rolePengguna = DB::table('role_pengguna')
            ->where('idpengguna', $peserta->idpengguna)
            ->where('idrole', self::ROLE_PESERTA)
            ->first();

        if (! $rolePengguna) {
            return $this->jsonResponse(404, 'Pengguna tidak memiliki role Peserta.');
        }

        $jumlahRole = DB::table('role_pengguna')->where('idpengguna', $peserta->idpengguna)->count();

        DB::transaction(function () use ($peserta, $rolePengguna, $jumlahRole, $userdata) {
            if ($jumlahRole <= 1) {
                DB::table('pengguna')->where('idpengguna', $peserta->idpengguna)->update(['is_deleted' => true]);

                $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Role Peserta adalah satu-satunya role, akun dinonaktifkan (is_deleted) oleh admin');

                return;
            }

            DB::table('role_pengguna')->where('idrole_pengguna', $rolePengguna->idrole_pengguna)->delete();

            $masihAdaAktif = DB::table('role_pengguna')->where('idpengguna', $peserta->idpengguna)->where('status', true)->exists();

            if (! $masihAdaAktif) {
                $roleLain = DB::table('role_pengguna')->where('idpengguna', $peserta->idpengguna)->first();

                if ($roleLain) {
                    DB::table('role_pengguna')->where('idrole_pengguna', $roleLain->idrole_pengguna)->update(['status' => true]);
                }
            }

            $this->logPeserta($peserta->idpeserta, $userdata['idpengguna'], 'Role Peserta dihapus oleh admin');
        });

        $pesan = $jumlahRole <= 1
            ? 'Peserta ini hanya memiliki role Peserta, sehingga akun dinonaktifkan.'
            : 'Role Peserta berhasil dihapus dari pengguna ini.';

        return $this->jsonResponse(200, $pesan);
    }

    /**
     * Download a kontingen's registration card — same completeness gate as
     * PesertaController::kartuKontingen(), just scoped to the institusi chosen
     * by the Admin (via an encrypted token) instead of the logged-in session's
     * own institusi.
     */
    public function cetakKartu(Request $request)
    {
        $idInstitusiAsal = $this->decryptRouteValue($request->query('token'));

        if ($idInstitusiAsal === null) {
            abort(404);
        }

        $idInstitusiAsal = (int) $idInstitusiAsal;

        $institusi = DB::table('institusi_asal')
            ->where('idinstitusi_asal', $idInstitusiAsal)
            ->first();

        if (! $institusi) {
            abort(404);
        }

        $pesertaList = $this->pesertaDenganStatusLengkap($idInstitusiAsal);
        $belumLengkap = $pesertaList->where('lengkap', false);

        if ($pesertaList->isEmpty() || $belumLengkap->isNotEmpty()) {
            $namaBelumLengkap = $belumLengkap->pluck('nama')->implode(', ');
            $pesan = $pesertaList->isEmpty()
                ? 'Belum ada peserta dalam kontingen ini.'
                : "Untuk mengunduh kartu registrasi, harap lengkapi semua data peserta. Belum lengkap: {$namaBelumLengkap}.";

            return redirect()->route('admin.peserta')->with('status', [
                'status' => 'danger',
                'message' => $pesan,
            ]);
        }

        return $this->unduhKartuKontingenResponse($institusi);
    }

    /**
     * List every peserta (cross-institusi), grouped jenis institusi → institusi,
     * each with a "Pilih Acara" link — so an admin can manage any peserta's
     * acara choices, including after `jadwalPenting:1,tutup` has locked
     * peserta's own self-service routes (see
     * docs/features/010-peserta-pilih-acara.md).
     */
    public function acara()
    {
        $menu = 'users';
        $submenu = 'acara-peserta';

        $pesertaList = $this->pesertaDenganStatusLengkap();

        $institusiList = DB::table('institusi_asal as i')
            ->join('jenis_institusi as ji', 'ji.idjenis_institusi', '=', 'i.idjenis_institusi')
            ->select('i.idinstitusi_asal', 'i.nama_institusi', 'ji.nama_jenis_institusi')
            ->orderBy('i.nama_institusi')
            ->get()
            ->map(function ($institusi) use ($pesertaList) {
                $institusi->pesertaList = $pesertaList->where('idinstitusi_asal', $institusi->idinstitusi_asal)->values();
                $institusi->jumlahPeserta = $institusi->pesertaList->count();

                return $institusi;
            });

        $jenisInstitusiList = $institusiList->groupBy('nama_jenis_institusi')->map(function ($institusiPerJenis, $namaJenis) {
            return (object) [
                'nama_jenis_institusi' => $namaJenis,
                'institusiList' => $institusiPerJenis->values(),
            ];
        })->values();

        return view('admin.peserta-acara', compact('menu', 'submenu', 'jenisInstitusiList'));
    }

    /**
     * Show the "Pilih Acara" page for any peserta — same as
     * PesertaController::pilihAcara() but not scoped to one institusi (an
     * admin may manage any peserta). The idpeserta travels as an encrypted
     * `token` query value (CONVENTIONS.md §7).
     */
    public function pilihAcara(Request $request)
    {
        $idpeserta = $this->decryptRouteValue($request->query('token'));

        if ($idpeserta === null) {
            abort(404);
        }

        $idpeserta = (int) $idpeserta;

        $peserta = $this->findPesertaById($idpeserta);

        if (! $peserta) {
            abort(404);
        }

        $menu = 'users';
        $submenu = 'acara-peserta';
        $token = $this->encryptRouteValue($idpeserta);

        $idacaraTerdaftar = DB::table('peserta_acara')
            ->where('idpeserta', $idpeserta)
            ->pluck('idacara');

        $acaraAktifQuery = fn () => DB::table('acara')->where(fn ($q) => $q->where('status', true)->orWhereNull('status'));

        $lengkapi = function ($acara) use ($idacaraTerdaftar) {
            $acara->bisaDipilih = ! $acara->has_child && in_array($acara->opsi_pilih, ['2', '3'], true);
            $acara->terkunci = $acara->opsi_pilih === '3';
            $acara->sudahTerdaftar = $idacaraTerdaftar->contains($acara->idacara);

            return $acara;
        };

        $topLevel = $acaraAktifQuery()->whereNull('idparent_acara')->orderBy('idacara')->get();
        $children = $topLevel->isEmpty()
            ? collect()
            : $acaraAktifQuery()->whereIn('idparent_acara', $topLevel->pluck('idacara'))->orderBy('idacara')->get();

        $acaraList = $topLevel->map($lengkapi)->map(function ($acara) use ($children, $lengkapi) {
            $acara->children = $children->where('idparent_acara', $acara->idacara)->map($lengkapi)->values();

            return $acara;
        })->values();

        return view('admin.pilih-acara', compact('menu', 'submenu', 'peserta', 'idpeserta', 'token', 'acaraList'));
    }

    /**
     * Register any peserta into an acara — same rules as
     * PesertaController::daftarAcara() (not scoped to one institusi).
     */
    public function daftarAcara(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idacara' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

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
     * Unregister any peserta from an acara — same rules as
     * PesertaController::batalAcara() (not scoped to one institusi).
     */
    public function batalAcara(Request $request)
    {
        $userdata = session('userdata');

        $validated = $request->validate([
            'idpeserta' => ['required', 'integer'],
            'idacara' => ['required', 'integer'],
        ]);

        $peserta = $this->findPesertaById((int) $validated['idpeserta']);

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
     * Find a peserta by idpeserta across every institusi — Admin isn't scoped to
     * one kontingen the way a peserta is.
     */
    private function findPesertaById(int $idpeserta): ?object
    {
        return DB::table('pengguna as p')
            ->join('peserta as pe', 'pe.idpengguna', '=', 'p.idpengguna')
            ->where('pe.idpeserta', $idpeserta)
            ->where('p.is_deleted', false)
            ->select('p.idpengguna', 'pe.idpeserta', 'p.nama', 'p.email', 'p.no_wa', 'pe.idjabatan', 'p.idinstitusi_asal')
            ->first();
    }
}
