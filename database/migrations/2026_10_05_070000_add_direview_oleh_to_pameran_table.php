<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->unsignedInteger('direview_oleh')->nullable();
            $table->foreign('direview_oleh', 'fk_pameran_pengguna_1')->references('idpengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->dropForeign('fk_pameran_pengguna_1');
            $table->dropColumn('direview_oleh');
        });
    }
};
