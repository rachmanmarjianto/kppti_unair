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
                'nama_topik' => 'Bukti Dampak Nyata (Impact & Validation)',
                'status' => true,
                'petunjuk' => 'Indikator: Bukti penggunaan oleh mitra (mitra industri/UMKM/masyarakat), data efisiensi atau peningkatan omzet, dokumen serah terima, atau testimoni terverifikasi.',
                'bobot_dlm_persen' => 40,
            ],
            [
                'idtopik_review' => 2,
                'nama_topik' => 'Potensi Replikasi (Replicability / Best Practice)',
                'status' => true,
                'petunjuk' => 'Indikator: Kesiapan panduan teknis, modul, atau cetak biru operasional yang memungkinkan kampus lain meniru program/produk tersebut',
                'bobot_dlm_persen' => 25,
            ],
            [
                'idtopik_review' => 3,
                'nama_topik' => 'Kesiapan Tingkat Adopsi (Readiness Level)',
                'status' => true,
                'petunjuk' => 'Indikator: Untuk produk fisik minimal TRL/TKT 7 (prototipe teruji di lingkungan sebenarnya). Untuk program sosial memiliki kemandirian keberlanjutan (sustainability)',
                'bobot_dlm_persen' => 20,
            ],
            [
                'idtopik_review' => 4,
                'nama_topik' => 'Rencana Presentasi Visual & Interaktivitas Booth',
                'status' => true,
                'petunjuk' => 'Indikator: Konsep display luring yang interaktif, demonstratif, menghindari penumpukan banner/poster (X-Banner konvensional), dan mengutamakan pengalaman langsung (hands-on)',
                'bobot_dlm_persen' => 15,
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
