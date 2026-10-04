<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            RoleSeeder::class,
            JenisInstitusiSeeder::class,
            KelompokJabatanSeeder::class,
            LldiktiSeeder::class,
            JenisTransportSeeder::class,
            UniversitasSeeder::class,
            JabatanSeeder::class,
            JenisInstitusiJabatanSeeder::class,
            AdminPenggunaSeeder::class,
            JadwalPentingSeeder::class,
            TopikReviewSeeder::class,
        ]);
    }
}
