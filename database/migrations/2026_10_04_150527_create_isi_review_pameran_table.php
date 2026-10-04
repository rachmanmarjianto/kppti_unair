<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('isi_review_pameran', function (Blueprint $table) {
            $table->increments('idisi_review_pameran');
            $table->unsignedInteger('idreview')->nullable();
            $table->unsignedInteger('idtopik_review')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->text('isi_review')->nullable();
            $table->boolean('memenuhi')->nullable()->default(false);

            $table->foreign('idreview')->references('idreview')->on('review_pameran');
            $table->foreign('idtopik_review')->references('idtopik_review')->on('topik_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_review_pameran');
    }
};
