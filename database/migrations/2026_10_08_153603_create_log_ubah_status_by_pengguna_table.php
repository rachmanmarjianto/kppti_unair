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
     * Mencatat kapan status sebuah tagihan berubah akibat aksi/kunjungan
     * seorang pengguna (dipakai saat tagihan ditandai expired otomatis
     * ketika pengguna membuka halaman pameran/detail tagihan).
     */
    public function up(): void
    {
        if (Schema::hasTable('log_ubah_status_by_pengguna')) {
            return;
        }

        Schema::create('log_ubah_status_by_pengguna', function (Blueprint $table) {
            $table->increments('idlog_ubah_status_by_pengguna');
            $table->timestamp('done_at', 6)->nullable();
            $table->unsignedInteger('done_by')->nullable();
            $table->unsignedInteger('idtagihan')->nullable();

            $table->foreign('done_by')->references('idpengguna')->on('pengguna');
            $table->foreign('idtagihan')->references('idtagihan')->on('tagihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_ubah_status_by_pengguna');
    }
};
