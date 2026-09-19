<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acara', function (Blueprint $table) {
            $table->id('idacara');
            $table->boolean('has_child')->nullable();
            $table->unsignedBigInteger('idparent_acara')->nullable();
            $table->text('tema')->nullable();
            $table->text('speaker')->nullable();
            $table->smallInteger('hari_ke')->nullable();
            $table->time('jam_mulai', 6)->nullable();
            $table->time('jam_akhir', 6)->nullable();
            $table->boolean('perlu_narsum')->nullable();

            $table->foreign('idparent_acara')->references('idacara')->on('acara');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acara');
    }
};
