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
     * create_isi_review_narsum_table. Nilai akhir hasil penjumlahan
     * (nilai topik × bobot_dlm_persen / 100) seluruh topik aktif, dihitung
     * saat SC mengirim keputusan final (lihat NarasumberReviewController).
     */
    public function up(): void
    {
        if (Schema::hasColumn('review_narasumber', 'nilai_akhir')) {
            return;
        }

        Schema::table('review_narasumber', function (Blueprint $table) {
            $table->smallInteger('nilai_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_narasumber', function (Blueprint $table) {
            $table->dropColumn('nilai_akhir');
        });
    }
};
