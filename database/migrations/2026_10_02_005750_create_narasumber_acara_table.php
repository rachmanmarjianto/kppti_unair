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
        Schema::create('narasumber_acara', function (Blueprint $table) {
            $table->increments('idnarasumber_acara');
            $table->unsignedBigInteger('idacara')->nullable();
            $table->unsignedInteger('idnarasumber')->nullable();
            $table->boolean('status')->nullable()->default(true);

            $table->foreign('idacara')->references('idacara')->on('acara');
            $table->foreign('idnarasumber')->references('idnarasumber')->on('narasumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narasumber_acara');
    }
};
