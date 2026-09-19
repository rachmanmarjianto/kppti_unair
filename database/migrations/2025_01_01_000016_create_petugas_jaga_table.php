<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas_jaga', function (Blueprint $table) {
            $table->increments('idpetugas_jaga');
            $table->unsignedInteger('idpameran')->nullable();
            $table->unsignedBigInteger('idpeserta')->nullable();

            $table->foreign('idpameran')->references('idpameran')->on('pameran');
            $table->foreign('idpeserta')->references('idpeserta')->on('peserta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas_jaga');
    }
};
