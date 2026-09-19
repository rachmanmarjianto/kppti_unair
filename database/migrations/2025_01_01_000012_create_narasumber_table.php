<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('narasumber', function (Blueprint $table) {
            $table->increments('idnarasumber');
            $table->unsignedBigInteger('idacara')->nullable();
            $table->text('abstract')->nullable();
            $table->char('status_ajuan', 1)->nullable()->comment('1: draft, 2: pengajuan, 3: review, 4: revisi, 5: Diterima, 6: Ditolak');
            $table->unsignedInteger('idpengguna')->nullable();
            $table->unsignedBigInteger('iduniversitas')->nullable();

            $table->foreign('idacara')->references('idacara')->on('acara');
            $table->foreign('idpengguna')->references('idpengguna')->on('pengguna');
            $table->foreign('iduniversitas')->references('iduniversitas')->on('universitas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('narasumber');
    }
};
