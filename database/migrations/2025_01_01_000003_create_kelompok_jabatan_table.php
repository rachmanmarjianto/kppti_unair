<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_jabatan', function (Blueprint $table) {
            $table->increments('idkelompok_jabatan');
            $table->string('nama_kelompok_jabatan', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_jabatan');
    }
};
