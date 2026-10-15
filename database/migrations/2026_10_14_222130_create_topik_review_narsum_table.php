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
     * Data master kriteria penilaian narasumber (7 topik aktif, lihat
     * TopikReviewNarsumSeeder), masing-masing berbobot (`bobot_dlm_persen`)
     * untuk menghitung `review_narasumber.nilai_akhir`.
     */
    public function up(): void
    {
        if (Schema::hasTable('topik_review_narsum')) {
            return;
        }

        Schema::create('topik_review_narsum', function (Blueprint $table) {
            $table->increments('idtopik_review_narsum');
            $table->string('nama_topik', 255)->nullable();
            $table->boolean('status')->default(true)->comment('true: aktif/tampil, false: nonaktif (soft delete)');
            $table->smallInteger('bobot_dlm_persen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_review_narsum');
    }
};
