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
        Schema::create('poster', function (Blueprint $table) {
            $table->increments('idposter');
            $table->integer('idnarasumber')->nullable();
            $table->timestamp('created_at', 6)->nullable();

            $table->foreign('idnarasumber')->references('idnarasumber')->on('narasumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poster');
    }
};
