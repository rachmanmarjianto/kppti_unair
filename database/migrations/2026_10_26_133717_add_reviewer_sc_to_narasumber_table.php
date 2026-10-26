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
     * so it's also safe on a fresh install. SC yang dipetakan Admin untuk
     * mereview satu pengajuan narasumber (menggantikan model klaim bebas).
     */
    public function up(): void
    {
        if (Schema::hasColumn('narasumber', 'reviewer_sc')) {
            return;
        }

        Schema::table('narasumber', function (Blueprint $table) {
            $table->unsignedInteger('reviewer_sc')->nullable();

            $table->foreign('reviewer_sc')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('narasumber', function (Blueprint $table) {
            $table->dropForeign(['reviewer_sc']);
            $table->dropColumn('reviewer_sc');
        });
    }
};
