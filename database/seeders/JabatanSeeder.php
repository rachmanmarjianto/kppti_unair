<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds. Depends on `kelompok_jabatan` (run {@see KelompokJabatanSeeder} first).
     */
    public function run(): void
    {
        DB::table('jabatan')->insertOrIgnore([
            ['idjabatan' => 1, 'nama_jabatan' => 'Rektor', 'idkelompok_jabatan' => 1],
            ['idjabatan' => 2, 'nama_jabatan' => 'Wakil Rektor', 'idkelompok_jabatan' => 1],
            ['idjabatan' => 3, 'nama_jabatan' => 'Dosen', 'idkelompok_jabatan' => 1],
            ['idjabatan' => 4, 'nama_jabatan' => 'Mahasiswa', 'idkelompok_jabatan' => 1],
            ['idjabatan' => 5, 'nama_jabatan' => 'Tenaga Kependidikan', 'idkelompok_jabatan' => 1],
            ['idjabatan' => 6, 'nama_jabatan' => 'Direktur', 'idkelompok_jabatan' => 2],
            ['idjabatan' => 7, 'nama_jabatan' => 'Wakil Direktur', 'idkelompok_jabatan' => 2],
            ['idjabatan' => 8, 'nama_jabatan' => 'Staff', 'idkelompok_jabatan' => 2],
            ['idjabatan' => 9, 'nama_jabatan' => 'Ketua', 'idkelompok_jabatan' => 3],
            ['idjabatan' => 10, 'nama_jabatan' => 'Wakil Ketua', 'idkelompok_jabatan' => 3],
            ['idjabatan' => 11, 'nama_jabatan' => 'Staff', 'idkelompok_jabatan' => 3],
        ]);

        $this->syncSequence('jabatan', 'idjabatan');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
