<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_pengguna', function (Blueprint $table) {
            $table->increments('idrole_pengguna');
            $table->unsignedInteger('idpengguna')->nullable();
            $table->unsignedInteger('idrole')->nullable();
            $table->boolean('status')->default(true);

            $table->foreign('idpengguna')->references('idpengguna')->on('pengguna');
            $table->foreign('idrole')->references('idrole')->on('role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_pengguna');
    }
};
