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
        Schema::create('pengajuan_mou', function (Blueprint $table) {
            $table->increments('idpengajuan_mou');
            $table->smallInteger('status_ajuan')->nullable()->comment("1: Ajuan\r\n2: Temu diskusi\r\n3: Tunda lain waktu\r\n4: Terjalin\r\n5: Dibatalkan");
            $table->integer('idinstitusi_pengaju')->nullable();
            $table->integer('idpic_institusi_pengaju')->nullable();
            $table->integer('idinstitusi_mitra')->nullable();
            $table->integer('idpic_institusi_mitra')->nullable();
            $table->timestamp('pic_pengaju_hadir_at')->nullable();
            $table->timestamp('pic_mitra_hadir_at')->nullable();
            $table->integer('pic_pengaju_stamp_by')->nullable();
            $table->integer('pic_mitra_stamp_by')->nullable();

            $table->foreign('idinstitusi_pengaju')->references('idinstitusi_asal')->on('institusi_asal');
            $table->foreign('idinstitusi_mitra')->references('idinstitusi_asal')->on('institusi_asal');
            $table->foreign('idpic_institusi_pengaju')->references('idpengguna')->on('pengguna');
            $table->foreign('idpic_institusi_mitra')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_mou');
    }
};
