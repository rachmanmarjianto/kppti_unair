<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. `kppti_6.sql` mistakenly put two foreign keys on
     * `idpeserta` (one to `pengguna`, one to `peserta`) and none on `done_by`.
     * Correct it to match the `log_institusi` pattern: `done_by` -> `pengguna`,
     * `idpeserta` -> `peserta` (already correct, left untouched).
     */
    public function up(): void
    {
        Schema::table('log_peserta', function (Blueprint $table) {
            $table->dropForeign('fk_log_peserta_pengguna_1');
            $table->foreign('done_by')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_peserta', function (Blueprint $table) {
            $table->dropForeign(['done_by']);
            $table->foreign('idpeserta', 'fk_log_peserta_pengguna_1')->references('idpengguna')->on('pengguna');
        });
    }
};
