<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a column already added manually in development — nilai
     * akhir hasil penjumlahan (nilai topik x bobot_dlm_persen / 100)
     * seluruh topik aktif, mengikuti pola yang sama dengan
     * review_narasumber.nilai_akhir (dikonfirmasi developer). Live column
     * is `double precision`, unlike review_narasumber's `real` — formalized
     * as given, not assumed to match.
     */
    public function up(): void
    {
        if (Schema::hasColumn('review_pameran', 'nilai_akhir')) {
            return;
        }

        Schema::table('review_pameran', function (Blueprint $table) {
            $table->double('nilai_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_pameran', function (Blueprint $table) {
            $table->dropColumn('nilai_akhir');
        });
    }
};
