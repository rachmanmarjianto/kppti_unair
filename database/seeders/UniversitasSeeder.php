<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitasSeeder extends Seeder
{
    /**
     * Run the database seeds. Data lives in database/seeders/data/universitas.json
     * (6000+ rows) rather than inline, to keep this file readable.
     */
    public function run(): void
    {
        $rows = json_decode(
            file_get_contents(__DIR__.'/data/universitas.json'),
            true
        );

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('universitas')->insertOrIgnore($chunk);
        }

        $this->syncSequence('universitas', 'iduniversitas');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
