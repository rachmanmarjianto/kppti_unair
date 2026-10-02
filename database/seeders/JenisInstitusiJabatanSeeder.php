<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisInstitusiJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds. Depends on `jenis_institusi` and `kelompok_jabatan`
     * (run {@see JenisInstitusiSeeder} and {@see KelompokJabatanSeeder} first).
     *
     * This table has no primary/unique key, so `insertOrIgnore` cannot dedupe on
     * re-run — guard with a count check instead.
     */
    public function run(): void
    {
        if (DB::table('jenis_institusi_jabatan')->count() > 0) {
            return;
        }

        DB::table('jenis_institusi_jabatan')->insert([
            ['idjenis_institusi' => 1, 'idkelompok_jabatan' => 1],
            ['idjenis_institusi' => 2, 'idkelompok_jabatan' => 2],
            ['idjenis_institusi' => 3, 'idkelompok_jabatan' => 2],
            ['idjenis_institusi' => 4, 'idkelompok_jabatan' => 3],
            ['idjenis_institusi' => 5, 'idkelompok_jabatan' => 2],
            ['idjenis_institusi' => 6, 'idkelompok_jabatan' => 2],
        ]);
    }
}
