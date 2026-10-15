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
     * Isian SC per topik (komentar + nilai 0-100), terikat ke satu baris
     * `review_narasumber` tertentu — satu giliran review punya satu set
     * nilai sendiri, sama pola dengan `isi_review_pameran`/`topik_review`.
     */
    public function up(): void
    {
        if (Schema::hasTable('isi_review_narsum')) {
            return;
        }

        Schema::create('isi_review_narsum', function (Blueprint $table) {
            $table->increments('idisi_review_narsum');
            $table->unsignedInteger('idreview_narasumber')->nullable();
            $table->unsignedInteger('idtopik_review_narsum')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->text('isi_review')->nullable();
            $table->smallInteger('nilai')->nullable();

            $table->foreign('idreview_narasumber', 'fk_isi_review_narsum_review_narasumber_1')->references('idreview_narasumber')->on('review_narasumber');
            $table->foreign('idtopik_review_narsum', 'fk_isi_review_narsum_topik_review_narsum_1')->references('idtopik_review_narsum')->on('topik_review_narsum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_review_narsum');
    }
};
