<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idRoleAdmin = DB::table('role')->where('nama_role', 'admin')->value('idrole');

        if ($idRoleAdmin === null) {
            $idRoleAdmin = DB::table('role')->insertGetId(['nama_role' => 'admin']);
        }

        $pengguna = Pengguna::create([
            'nama' => 'admin',
            'email' => 'admin@kppti2026.unair.ac.id',
            'password' => '12345678',
            'no_wa' => null,
            'idinstitusi_asal' => null,
        ]);

        DB::table('role_pengguna')->insert([
            'idpengguna' => $pengguna->idpengguna,
            'idrole' => $idRoleAdmin,
            'status' => true,
        ]);
    }
}
