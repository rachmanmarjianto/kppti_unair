<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LldiktiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayah = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII'];

        DB::table('lldikti')->insertOrIgnore(
            collect($wilayah)
                ->map(fn (string $nomor, int $index) => ['idlldikti' => $index + 1, 'nomor_lldikti' => $nomor])
                ->all()
        );

        $this->syncSequence('lldikti', 'idlldikti');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
