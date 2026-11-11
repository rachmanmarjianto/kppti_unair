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
        Schema::create('log_notif_mou', function (Blueprint $table) {
            $table->increments('idlog_notif_mou');
            $table->integer('idinstitusi_asal')->nullable();
            $table->integer('idpeserta')->nullable();
            $table->text('pesan_1')->nullable();
            $table->text('pesan_2')->nullable();
            $table->text('pesan_3')->nullable();
            $table->string('no_wa')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('sent_by')->nullable();

            $table->foreign('idinstitusi_asal')->references('idinstitusi_asal')->on('institusi_asal');
            $table->foreign('idpeserta')->references('idpeserta')->on('peserta');
            $table->foreign('sent_by')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_notif_mou');
    }
};
