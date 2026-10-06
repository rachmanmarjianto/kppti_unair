<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Widens kode_kontingen from varchar(5) to varchar(7) for the new
     * MMZZZYY format (was XXZZZ). Uses a raw statement — doctrine/dbal
     * isn't installed, so Schema::table(...)->change() isn't available.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE institusi_asal ALTER COLUMN kode_kontingen TYPE character varying(7)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE institusi_asal ALTER COLUMN kode_kontingen TYPE character varying(5)');
    }
};
