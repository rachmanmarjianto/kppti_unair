<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a column already added manually in development — guarded
     * so it's also safe on a fresh install right after
     * create_kluster_pameran_table. Kluster yang dipilih peserta saat
     * mengajukan pameran.
     */
    public function up(): void
    {
        if (Schema::hasColumn('pameran', 'idkluster_pameran')) {
            return;
        }

        Schema::table('pameran', function (Blueprint $table) {
            $table->unsignedInteger('idkluster_pameran')->nullable();

            $table->foreign('idkluster_pameran')->references('idkluster_pameran')->on('kluster_pameran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->dropForeign(['idkluster_pameran']);
            $table->dropColumn('idkluster_pameran');
        });
    }
};
