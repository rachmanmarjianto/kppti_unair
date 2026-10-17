<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a table already created manually in development — SC
     * pameran review is being restructured to support multiple reviewers
     * per pameran (`reviewer_ke` = urutan reviewer), replacing the old
     * single `pameran.direview_oleh` column. `review_pameran.created_by`
     * now points here instead of directly to `pengguna` (see
     * drop_idpameran_and_repoint_created_by_in_review_pameran_table).
     */
    public function up(): void
    {
        if (Schema::hasTable('reviewer_pameran')) {
            return;
        }

        Schema::create('reviewer_pameran', function (Blueprint $table) {
            $table->increments('idreviewer_pameran');
            $table->unsignedInteger('idpameran')->nullable();
            $table->unsignedInteger('idpengguna')->nullable();
            $table->smallInteger('reviewer_ke')->nullable();

            $table->foreign('idpameran', 'fk_reviewer_pameran_pameran_1')->references('idpameran')->on('pameran');
            $table->foreign('idpengguna', 'fk_reviewer_pameran_pengguna_1')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_pameran');
    }
};
