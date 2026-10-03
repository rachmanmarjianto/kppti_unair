<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_institusi', function (Blueprint $table) {
            $table->id('idlog_institusi');
            $table->timestamp('done_at', 6)->nullable();
            $table->unsignedBigInteger('done_by')->nullable();
            $table->string('aktifitas', 1000)->nullable();
            $table->unsignedInteger('idinstitusi_asal')->nullable();

            $table->foreign('done_by')->references('idpengguna')->on('pengguna');
            $table->foreign('idinstitusi_asal')->references('idinstitusi_asal')->on('institusi_asal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_institusi');
    }
};
