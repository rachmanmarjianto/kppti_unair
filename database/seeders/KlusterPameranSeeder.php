<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlusterPameranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kluster_pameran')->insertOrIgnore([
            [
                'idkluster_pameran' => 1,
                'nomor_kluster' => 1,
                'tema_kluster' => 'Ekonomi Kerakyatan & Hilirisasi UMKM ',
                'subtema_kluster' => 'Teknologi tepat guna, pendampingan usaha, manajemen rantai pasok lokal',
                'status' => true,
            ],
            [
                'idkluster_pameran' => 2,
                'nomor_kluster' => 2,
                'tema_kluster' => 'Transformasi Digital & Inovasi AI',
                'subtema_kluster' => 'Penerapan AI/IoT pada industri, aplikasi efisiensi publik, literasi digital',
                'status' => true,
            ],
            [
                'idkluster_pameran' => 3,
                'nomor_kluster' => 3,
                'tema_kluster' => 'Gerbang SDGs & Keunggulan Berkelanjutan',
                'subtema_kluster' => 'Energi terbarukan, sanitasi/air bersih, pangan mandiri, kesehatan/telemedicine',
                'status' => true,
            ],
            [
                'idkluster_pameran' => 4,
                'nomor_kluster' => 4,
                'tema_kluster' => 'Inklusi, Humaniora & Ketahanan Budaya',
                'subtema_kluster' => 'Teknologi akses disabilitas, digitalisasi warisan budaya, advokasi kelompok marginal',
                'status' => true,
            ],
            [
                'idkluster_pameran' => 5,
                'nomor_kluster' => 5,
                'tema_kluster' => 'Industri/Mitra/Asosiasi/NGO',
                'subtema_kluster' => null,
                'status' => true,
            ],
        ]);

        $this->syncSequence('kluster_pameran', 'idkluster_pameran');
    }

    private function syncSequence(string $table, string $column): void
    {
        DB::statement(
            "SELECT setval(pg_get_serial_sequence('{$table}', '{$column}'), (SELECT COALESCE(MAX({$column}), 1) FROM {$table}))"
        );
    }
}
