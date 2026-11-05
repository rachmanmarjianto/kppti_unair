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
        Schema::create('log_status_mou', function (Blueprint $table) {
            $table->increments('idlog_status_mou');
            $table->timestamp('done_at')->nullable();
            $table->integer('done_by')->nullable();
            $table->smallInteger('status')->nullable();
            $table->integer('idpengajuan_mou')->nullable();

            $table->foreign('idpengajuan_mou')->references('idpengajuan_mou')->on('pengajuan_mou');
            $table->foreign('done_by')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_status_mou');
    }
};
