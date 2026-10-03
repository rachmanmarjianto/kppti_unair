<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_transport', function (Blueprint $table) {
            $table->increments('idjenis_transport');
            $table->string('nama_jenis_transport')->nullable();
            $table->boolean('status')->nullable()->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_transport');
    }
};
