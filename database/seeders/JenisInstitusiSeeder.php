<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisInstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_institusi')->insertOrIgnore([
            ['idjenis_institusi' => 1, 'nama_jenis_institusi' => 'Perguruan Tinggi'],
            ['idjenis_institusi' => 2, 'nama_jenis_institusi' => 'Lembaga Akreditasi'],
            ['idjenis_institusi' => 3, 'nama_jenis_institusi' => 'Asosiasi'],
            ['idjenis_institusi' => 4, 'nama_jenis_institusi' => 'LLDikti'],
            ['idjenis_institusi' => 5, 'nama_jenis_institusi' => 'Pemerhati Pendidikan'],
            ['idjenis_institusi' => 6, 'nama_jenis_institusi' => 'Lainnya'],
        ]);

        $this->syncSequence('jenis_institusi', 'idjenis_institusi');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
