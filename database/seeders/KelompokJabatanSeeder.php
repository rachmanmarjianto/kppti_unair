<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelompok_jabatan')->insertOrIgnore([
            ['idkelompok_jabatan' => 1, 'nama_kelompok_jabatan' => 'Perguruan Tinggi'],
            ['idkelompok_jabatan' => 2, 'nama_kelompok_jabatan' => 'asosiasi, lembaga akre, pemerhati pendidikan, lainnya'],
            ['idkelompok_jabatan' => 3, 'nama_kelompok_jabatan' => 'lldikti'],
        ]);

        $this->syncSequence('kelompok_jabatan', 'idkelompok_jabatan');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
