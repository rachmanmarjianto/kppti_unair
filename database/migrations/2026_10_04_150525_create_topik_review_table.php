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
        Schema::create('topik_review', function (Blueprint $table) {
            $table->increments('idtopik_review');
            $table->string('nama_topik', 500)->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('petunjuk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_review');
    }
};
