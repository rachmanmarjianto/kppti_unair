<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('isi_review_pameran', function (Blueprint $table) {
            $table->foreign('created_by', 'fk_isi_review_pameran_pengguna_1')->references('idpengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::table('isi_review_pameran', function (Blueprint $table) {
            $table->dropForeign('fk_isi_review_pameran_pengguna_1');
        });
    }
};
