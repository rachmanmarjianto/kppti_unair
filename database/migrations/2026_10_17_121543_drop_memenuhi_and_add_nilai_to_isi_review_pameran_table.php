<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * isi_review_pameran.memenuhi (boolean per-kriteria checkbox, added by
     * create_isi_review_pameran_table) never actually matched the real
     * pameran review design (dikonfirmasi developer) — replaced by `nilai`
     * (0-100 per topik, dikalikan topik_review.bobot_dlm_persen), mengikuti
     * pola yang sama dengan narasumber.
     */
    public function up(): void
    {
        if (Schema::hasColumn('isi_review_pameran', 'memenuhi')) {
            Schema::table('isi_review_pameran', function (Blueprint $table) {
                $table->dropColumn('memenuhi');
            });
        }

        if (! Schema::hasColumn('isi_review_pameran', 'nilai')) {
            Schema::table('isi_review_pameran', function (Blueprint $table) {
                $table->smallInteger('nilai')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isi_review_pameran', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });

        Schema::table('isi_review_pameran', function (Blueprint $table) {
            $table->boolean('memenuhi')->nullable()->default(false);
        });
    }
};
