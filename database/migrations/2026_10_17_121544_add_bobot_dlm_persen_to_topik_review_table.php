<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a column already added manually in development, part of
     * switching pameran review from a boolean "memenuhi" checkbox per
     * topik to a weighted 0-100 score (dikonfirmasi developer; lihat juga
     * drop_memenuhi_and_add_nilai_to_isi_review_pameran_table).
     */
    public function up(): void
    {
        if (Schema::hasColumn('topik_review', 'bobot_dlm_persen')) {
            return;
        }

        Schema::table('topik_review', function (Blueprint $table) {
            $table->smallInteger('bobot_dlm_persen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topik_review', function (Blueprint $table) {
            $table->dropColumn('bobot_dlm_persen');
        });
    }
};
