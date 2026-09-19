<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pameran', function (Blueprint $table) {
            $table->increments('idpameran');
            $table->text('abstract')->nullable();
            $table->char('status_ajuan', 1)->nullable()->comment('1: draft, 2: pengajuan, 3: review, 4: revisi, 5: Diterima, 6: Ditolak');
            $table->string('nomor_stand', 5)->nullable();
            $table->unsignedInteger('idinstitusi_asal')->nullable();

            $table->foreign('idinstitusi_asal')->references('idinstitusi_asal')->on('institusi_asal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pameran');
    }
};
