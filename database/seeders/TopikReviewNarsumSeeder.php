<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopikReviewNarsumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('topik_review_narsum')->insertOrIgnore([
            [
                'idtopik_review_narsum' => 1,
                'nama_topik' => 'Relevansi dengan tema dan subtema KPPTI 2026',
                'status' => true,
                'bobot_dlm_persen' => 10,
            ],
            [
                'idtopik_review_narsum' => 2,
                'nama_topik' => 'Kebaruan dan keunggulan praktik baik atau inovasi',
                'status' => true,
                'bobot_dlm_persen' => 15,
            ],
            [
                'idtopik_review_narsum' => 3,
                'nama_topik' => 'Kualitas data dan bukti pendukung',
                'status' => true,
                'bobot_dlm_persen' => 20,
            ],
            [
                'idtopik_review_narsum' => 4,
                'nama_topik' => 'Signifikansi dan keterukuran dampak',
                'status' => true,
                'bobot_dlm_persen' => 25,
            ],
            [
                'idtopik_review_narsum' => 5,
                'nama_topik' => 'Integrasi teknologi dan kearifan lokal',
                'status' => true,
                'bobot_dlm_persen' => 10,
            ],
            [
                'idtopik_review_narsum' => 6,
                'nama_topik' => 'Kontribusi terhadap pendidikan tinggi yang inklusif dan humanis',
                'status' => true,
                'bobot_dlm_persen' => 10,
            ],
            [
                'idtopik_review_narsum' => 7,
                'nama_topik' => 'Keberlanjutan dan potensi replikasi',
                'status' => true,
                'bobot_dlm_persen' => 10,
            ],
        ]);

        $this->syncSequence('topik_review_narsum', 'idtopik_review_narsum');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
