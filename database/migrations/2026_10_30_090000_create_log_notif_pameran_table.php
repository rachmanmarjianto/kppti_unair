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
        Schema::create('log_notif_pameran', function (Blueprint $table) {
            $table->increments('idlog_notif_pameran');
            $table->text('pesan_1')->nullable();
            $table->text('pesan_2')->nullable();
            $table->text('pesan_3')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('sent_by')->nullable();
            $table->integer('idpameran')->nullable();
            $table->string('no_wa')->nullable();

            $table->foreign('idpameran')->references('idpameran')->on('pameran');
            $table->foreign('sent_by')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_notif_pameran');
    }
};
