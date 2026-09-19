<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_acara', function (Blueprint $table) {
            $table->id('idpeserta_acara');
            $table->unsignedBigInteger('idpeserta')->nullable();
            $table->unsignedBigInteger('idacara')->nullable();

            $table->foreign('idpeserta')->references('idpeserta')->on('peserta');
            $table->foreign('idacara')->references('idacara')->on('acara');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_acara');
    }
};
