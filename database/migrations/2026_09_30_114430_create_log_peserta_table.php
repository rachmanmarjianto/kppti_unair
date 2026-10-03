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
        Schema::create('log_peserta', function (Blueprint $table) {
            $table->id('idlog_peserta');
            $table->timestamp('done_at', 6)->nullable();
            $table->unsignedBigInteger('done_by')->nullable();
            $table->string('aktifitas', 2000)->nullable();
            $table->unsignedBigInteger('idpeserta')->nullable();

            $table->foreign('idpeserta')->references('idpeserta')->on('peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_peserta');
    }
};
