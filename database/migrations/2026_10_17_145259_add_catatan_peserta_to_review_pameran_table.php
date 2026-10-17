<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * `catatan` tetap untuk catatan yang dikirim SC; `catatan_peserta`
     * (baru) untuk catatan yang dikirim peserta saat membalas revisi
     * (dikonfirmasi developer; lihat PameranController::balasRevisi()).
     */
    public function up(): void
    {
        if (Schema::hasColumn('review_pameran', 'catatan_peserta')) {
            return;
        }

        Schema::table('review_pameran', function (Blueprint $table) {
            $table->text('catatan_peserta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_pameran', function (Blueprint $table) {
            $table->dropColumn('catatan_peserta');
        });
    }
};
