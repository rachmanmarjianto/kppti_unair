<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_institusi_jabatan', function (Blueprint $table) {
            $table->unsignedInteger('idjenis_institusi')->nullable();
            $table->unsignedInteger('idkelompok_jabatan')->nullable();

            $table->foreign('idjenis_institusi')->references('idjenis_institusi')->on('jenis_institusi');
            $table->foreign('idkelompok_jabatan')->references('idkelompok_jabatan')->on('kelompok_jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_institusi_jabatan');
    }
};
