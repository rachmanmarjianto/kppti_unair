<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lampiran_mou', function (Blueprint $table) {
            $table->increments('idlampiran_mou');
            $table->text('catatan')->nullable();
            $table->string('file_path')->nullable();
            $table->smallInteger('jenis_lampiran')->nullable()->comment('1: file; 2: catatan');
            $table->integer('idpengajuan_mou')->nullable();
            $table->integer('dikirim_oleh')->nullable()->comment('idinstansi_asal');

            $table->foreign('idpengajuan_mou')->references('idpengajuan_mou')->on('pengajuan_mou');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_mou');
    }
};
