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
        Schema::create('file', function (Blueprint $table) {
            $table->increments('idfile');
            $table->string('path_file')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->smallInteger('jenis')->nullable()->comment('1: File; 2: Link');
            $table->integer('idref_tabel')->nullable()->comment('1: narasumber; 2: poster');
            $table->integer('idref')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file');
    }
};
