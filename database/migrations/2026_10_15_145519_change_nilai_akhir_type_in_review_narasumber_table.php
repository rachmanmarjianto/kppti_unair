<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * nilai_akhir (hasil SUM(nilai topik × bobot_dlm_persen / 100)) diubah
     * dari smallint ke real oleh developer langsung di DB, karena hasilnya
     * bisa pecahan — raw SQL (bukan Blueprint::change()) karena
     * doctrine/dbal tidak terpasang di proyek ini.
     */
    public function up(): void
    {
        if ($this->currentType() === 'float4') {
            return;
        }

        DB::statement('ALTER TABLE review_narasumber ALTER COLUMN nilai_akhir TYPE real');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->currentType() !== 'float4') {
            return;
        }

        DB::statement('ALTER TABLE review_narasumber ALTER COLUMN nilai_akhir TYPE smallint USING ROUND(nilai_akhir::numeric)::smallint');
    }

    private function currentType(): ?string
    {
        return DB::selectOne(
            'select udt_name from information_schema.columns where table_name = ? and column_name = ?',
            ['review_narasumber', 'nilai_akhir']
        )?->udt_name;
    }
};
