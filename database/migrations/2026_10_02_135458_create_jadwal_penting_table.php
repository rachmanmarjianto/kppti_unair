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
        Schema::create('jadwal_penting', function (Blueprint $table) {
            $table->increments('idjadwal_penting');
            $table->string('nama_jadwal')->nullable();
            $table->timestamp('timestamp_buka')->nullable();
            $table->timestamp('timestamp_tutup')->nullable();
            $table->char('mode', 1)->nullable()->comment('1: auto; 2: open');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penting');
    }
};
