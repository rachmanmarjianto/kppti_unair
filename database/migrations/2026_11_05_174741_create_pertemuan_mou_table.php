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
        Schema::create('pertemuan_mou', function (Blueprint $table) {
            $table->increments('idpertemuan_mou');
            $table->integer('idsesi_mou')->nullable();
            $table->integer('idruang_mou')->nullable();
            $table->integer('idtanggal_mou')->nullable();
            $table->integer('idpengajuan_mou')->nullable();
            $table->smallInteger('isi_ke')->nullable();
            $table->timestamp('mulai_at')->nullable();
            $table->timestamp('selesai_at')->nullable();

            $table->foreign('idpengajuan_mou')->references('idpengajuan_mou')->on('pengajuan_mou');
            $table->foreign('idruang_mou')->references('idruang_mou')->on('ruang_mou');
            $table->foreign('idsesi_mou')->references('idsesi_mou')->on('sesi_mou');
            $table->foreign('idtanggal_mou')->references('idtanggal_mou')->on('tanggal_mou');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan_mou');
    }
};
