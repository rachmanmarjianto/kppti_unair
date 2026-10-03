<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id('idpeserta');
            $table->unsignedInteger('idjenis_transportasi_kedatangan')->nullable();
            $table->string('stasiun_kedatangan')->nullable();
            $table->date('tanggal_kedatangan')->nullable();
            $table->time('jam_kedatangan', 6)->nullable();
            $table->unsignedInteger('idjenis_transportasi_kepulangan')->nullable();
            $table->string('stasiun_kepulangan')->nullable();
            $table->date('tanggal_kepulangan')->nullable();
            $table->time('jam_kepulangan', 6)->nullable();
            $table->string('nama_hotel')->nullable();
            $table->boolean('city_tour')->nullable()->default(false);
            $table->unsignedInteger('idpengguna')->nullable();
            $table->unsignedInteger('idjabatan')->nullable();

            $table->foreign('idjenis_transportasi_kedatangan')->references('idjenis_transport')->on('jenis_transport');
            $table->foreign('idjenis_transportasi_kepulangan')->references('idjenis_transport')->on('jenis_transport');
            $table->foreign('idpengguna')->references('idpengguna')->on('pengguna');
            $table->foreign('idjabatan')->references('idjabatan')->on('jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
