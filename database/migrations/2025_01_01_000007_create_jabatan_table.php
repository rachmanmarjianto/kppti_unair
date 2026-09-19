<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->increments('idjabatan');
            $table->string('nama_jabatan')->nullable();
            $table->unsignedInteger('idkelompok_jabatan')->nullable();

            $table->foreign('idkelompok_jabatan')->references('idkelompok_jabatan')->on('kelompok_jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
