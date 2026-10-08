<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Widens expired_date from date to timestamp(6) — VA sekarang bisa
     * expired jam-ke-jam, bukan cuma per-hari. Raw statement karena
     * doctrine/dbal tidak terpasang, jadi Schema::table(...)->change()
     * tidak tersedia (pola sama seperti change_kode_kontingen_length).
     * Juga memperluas komentar kolom status untuk mencakup nilai 5: expired.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE tagihan ALTER COLUMN expired_date TYPE timestamp(6)');
        DB::statement("COMMENT ON COLUMN tagihan.status IS '1: tertagih; 2: terbayar sebagian; 3: lunas; 4: batal; 5: expired'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE tagihan ALTER COLUMN expired_date TYPE date');
        DB::statement("COMMENT ON COLUMN tagihan.status IS '1: tertagih; 2: terbayar sebagian; 3: lunas; 4: batal'");
    }
};
