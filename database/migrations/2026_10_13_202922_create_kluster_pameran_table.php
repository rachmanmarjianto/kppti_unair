<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a table already created manually in development — guarded
     * so it's also safe on a fresh install where the table doesn't exist yet.
     * Data master kluster pameran (4 kluster tetap, lihat KlusterPameranSeeder),
     * dipilih peserta saat mengajukan pameran.
     */
    public function up(): void
    {
        if (Schema::hasTable('kluster_pameran')) {
            return;
        }

        Schema::create('kluster_pameran', function (Blueprint $table) {
            $table->increments('idkluster_pameran');
            $table->smallInteger('nomor_kluster')->nullable();
            $table->string('tema_kluster', 500)->nullable();
            $table->string('subtema_kluster', 500)->nullable();
            $table->boolean('status')->default(true)->comment('true: aktif/tampil, false: nonaktif (soft delete)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kluster_pameran');
    }
};
