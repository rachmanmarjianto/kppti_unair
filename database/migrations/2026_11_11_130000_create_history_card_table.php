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
        Schema::create('history_card', function (Blueprint $table) {
            $table->increments('idhistory_card');
            $table->integer('idpengguna')->nullable();
            $table->smallInteger('aktifitas')->nullable()->comment('1: tambah; 2: delete');
            $table->string('idcard')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->integer('done_by')->nullable();

            $table->foreign('idpengguna')->references('idpengguna')->on('pengguna');
            $table->foreign('done_by')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_card');
    }
};
