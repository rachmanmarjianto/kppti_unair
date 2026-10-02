<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insertOrIgnore([
            ['idrole' => 1, 'nama_role' => 'admin'],
            ['idrole' => 2, 'nama_role' => 'Peserta'],
            ['idrole' => 3, 'nama_role' => 'Nara Sumber'],
            ['idrole' => 4, 'nama_role' => 'SC'],
        ]);

        $this->syncSequence('role', 'idrole');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
