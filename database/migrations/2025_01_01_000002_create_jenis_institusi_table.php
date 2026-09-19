<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_institusi', function (Blueprint $table) {
            $table->increments('idjenis_institusi');
            $table->string('nama_jenis_institusi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_institusi');
    }
};
