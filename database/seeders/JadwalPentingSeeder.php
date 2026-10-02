<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPentingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_penting')->insertOrIgnore([
            ['idjadwal_penting' => 1, 'nama_jadwal' => 'Registrasi Peserta', 'timestamp_buka' => '2026-10-02 12:00:00', 'timestamp_tutup' => '2026-10-06 20:31:31', 'mode' => '1'],
            ['idjadwal_penting' => 2, 'nama_jadwal' => 'Pengajuan Narasumber', 'timestamp_buka' => '2026-10-02 12:00:00', 'timestamp_tutup' => '2026-10-06 20:31:31', 'mode' => '1'],
            ['idjadwal_penting' => 3, 'nama_jadwal' => 'Pengajuan Pameran', 'timestamp_buka' => '2026-10-02 12:00:00', 'timestamp_tutup' => '2026-10-06 20:31:31', 'mode' => '1'],
        ]);

        $this->syncSequence('jadwal_penting', 'idjadwal_penting');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
