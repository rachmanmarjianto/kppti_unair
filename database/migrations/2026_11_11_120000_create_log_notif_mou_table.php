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
            $table->text('pesan_1')->nullable();
            $table->text('pesan_2')->nullable();
            $table->text('pesan_3')->nullable();
            $table->string('no_wa', 40)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('sent_by')->nullable();
            $table->integer('idinstitusi_asal_penerima')->nullable();
            $table->integer('idpengguna_penerima')->nullable();

            $table->foreign('sent_by')->references('idpengguna')->on('pengguna');
            $table->foreign('idinstitusi_asal_penerima')->references('idinstitusi_asal')->on('institusi_asal');
            $table->foreign('idpengguna_penerima')->references('idpengguna')->on('pengguna');
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
