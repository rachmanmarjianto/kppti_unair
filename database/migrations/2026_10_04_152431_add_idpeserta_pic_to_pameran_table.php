<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->unsignedBigInteger('idpeserta_PIC')->nullable();

            $table->foreign('idpeserta_PIC', 'fk_pameran_peserta_1')->references('idpeserta')->on('peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->dropForeign('fk_pameran_peserta_1');
            $table->dropColumn('idpeserta_PIC');
        });
    }
};
