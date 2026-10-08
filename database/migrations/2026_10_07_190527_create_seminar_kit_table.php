<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a table already created manually in development — guarded
     * so it's also safe on a fresh install where the table doesn't exist yet.
     */
    public function up(): void
    {
        if (Schema::hasTable('seminar_kit')) {
            return;
        }

        Schema::create('seminar_kit', function (Blueprint $table) {
            $table->increments('idseminar_kit');
            $table->string('nama_kit')->nullable();
            $table->boolean('status')->default(true)->comment('true: aktif/tampil, false: nonaktif (soft delete)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_kit');
    }
};
