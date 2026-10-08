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
     * Note: the `check` column is a SQL reserved word — Laravel's schema
     * grammar quotes identifiers automatically, so `$table->boolean('check')`
     * is safe, but any raw SQL touching this table must quote it manually.
     */
    public function up(): void
    {
        if (Schema::hasTable('kit_peserta')) {
            return;
        }

        Schema::create('kit_peserta', function (Blueprint $table) {
            $table->id('idkit_peserta');
            $table->unsignedBigInteger('idpeserta')->nullable();
            $table->unsignedInteger('idseminar_kit')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->boolean('check')->default(false);

            $table->foreign('idpeserta')->references('idpeserta')->on('peserta');
            $table->foreign('idseminar_kit')->references('idseminar_kit')->on('seminar_kit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kit_peserta');
    }
};
