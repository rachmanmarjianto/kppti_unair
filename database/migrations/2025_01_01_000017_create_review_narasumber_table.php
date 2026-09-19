<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_narasumber', function (Blueprint $table) {
            $table->increments('idreview_narasumber');
            $table->unsignedInteger('idnarasumber')->nullable();
            $table->string('file_path')->nullable();
            $table->char('status_ajuan', 1)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->unsignedInteger('created_by')->nullable();

            $table->foreign('idnarasumber')->references('idnarasumber')->on('narasumber');
            $table->foreign('created_by')->references('idpengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_narasumber');
    }
};
