<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token', function (Blueprint $table) {
            $table->string('token', 6)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->unsignedInteger('used_by')->nullable();
            $table->string('no_wa', 50)->nullable();

            $table->foreign('used_by')->references('idpengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token');
    }
};
