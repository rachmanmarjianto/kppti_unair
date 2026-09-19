<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('idpengguna');
            $table->string('nama', 1000)->nullable();
            $table->string('email', 500)->nullable();
            $table->string('no_wa', 30)->nullable();
            $table->unsignedInteger('idrole')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('idinstitusi_asal')->nullable();

            $table->foreign('idinstitusi_asal')->references('idinstitusi_asal')->on('institusi_asal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
