<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_pameran', function (Blueprint $table) {
            $table->increments('idreview');
            $table->unsignedInteger('idpameran')->nullable();
            $table->string('file_path')->nullable();
            $table->char('status_ajuan', 1)->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedInteger('created_by')->nullable();

            $table->foreign('idpameran')->references('idpameran')->on('pameran');
            $table->foreign('created_by')->references('idpengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_pameran');
    }
};
