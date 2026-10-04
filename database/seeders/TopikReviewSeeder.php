<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopikReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('topik_review')->insertOrIgnore([
            [
                'idtopik_review' => 1,
                'nama_topik' => 'Sudah Diimplementasikan',
                'status' => true,
                'petunjuk' => "<ul>\r\n<li>Tujuan</li>\r\n<li>Diterapkan Dilingkungan Nyata</li>\r\n<li>Before After</li>\r\n<li>Dokumen Implementasi</li>\r\n</ul>",
            ],
            [
                'idtopik_review' => 2,
                'nama_topik' => 'Memiliki Dampak Yang Terukur',
                'status' => true,
                'petunjuk' => "<p><strong>Output</strong></p>\r\n<ul>\r\n<li>Prototype, Produk Inovasi, Program</li>\r\n</ul>\r\n<p><strong>Outcome / dampak</strong></p>\r\n<ul>\r\n<li>Akademik</li>\r\n<li>Ekonomi</li>\r\n<li>Sosial</li>\r\n<li>Institusional</li>\r\n<li>Lingkungan</li>\r\n</ul>",
            ],
            [
                'idtopik_review' => 3,
                'nama_topik' => 'Dapat direplikasi oleh PT/Masyarakat',
                'status' => true,
                'petunjuk' => "<ul>\r\n<li>Mudah dipelajari</li>\r\n<li>Terdokumentasi</li>\r\n<li>Adaptif</li>\r\n<li>Biaya</li>\r\n<li>Ketergantungan</li>\r\n</ul>",
            ],
            [
                'idtopik_review' => 4,
                'nama_topik' => 'Keterlibatan Mitra',
                'status' => true,
                'petunjuk' => "<ul>\r\n<li>Kesiapan Modul, SOP, Perangkat Pembelajaran</li>\r\n<li>Peluang kolaborasi bersama</li>\r\n<li>Kesiapan Mentor / TOT</li>\r\n<li>Potensi Kemitraan Stakeholder</li>\r\n</ul>",
            ],
        ]);

        $this->syncSequence('topik_review', 'idtopik_review');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
