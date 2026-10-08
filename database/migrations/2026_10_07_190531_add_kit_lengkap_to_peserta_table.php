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
     * so it's also safe on a fresh install where the column doesn't exist yet.
     */
    public function up(): void
    {
        if (Schema::hasColumn('peserta', 'kit_lengkap')) {
            return;
        }

        Schema::table('peserta', function (Blueprint $table) {
            $table->boolean('kit_lengkap')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn('kit_lengkap');
        });
    }
};
