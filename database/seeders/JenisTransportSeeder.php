<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_transport')->insertOrIgnore([
            ['idjenis_transport' => 1, 'nama_jenis_transport' => 'Pesawat', 'status' => true],
            ['idjenis_transport' => 2, 'nama_jenis_transport' => 'Kereta', 'status' => true],
            ['idjenis_transport' => 3, 'nama_jenis_transport' => 'Bus', 'status' => true],
            ['idjenis_transport' => 4, 'nama_jenis_transport' => 'Minibus', 'status' => true],
            ['idjenis_transport' => 5, 'nama_jenis_transport' => 'Kendaraan Pribadi', 'status' => true],
            ['idjenis_transport' => 6, 'nama_jenis_transport' => 'Kendaraan Pribadi', 'status' => false],
        ]);

        $this->syncSequence('jenis_transport', 'idjenis_transport');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
