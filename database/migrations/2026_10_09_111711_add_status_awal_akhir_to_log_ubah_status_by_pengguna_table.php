<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes columns already added manually in development — guarded so
     * it's also safe on a fresh install right after
     * create_log_ubah_status_by_pengguna_table. Mencatat status tagihan
     * sebelum/sesudah berubah (sama tipe dengan tagihan.status, smallint),
     * supaya tiap baris log bisa dibaca sendiri tanpa perlu menebak dari
     * konteks lain.
     */
    public function up(): void
    {
        Schema::table('log_ubah_status_by_pengguna', function (Blueprint $table) {
            if (! Schema::hasColumn('log_ubah_status_by_pengguna', 'status_awal')) {
                $table->smallInteger('status_awal')->nullable();
            }

            if (! Schema::hasColumn('log_ubah_status_by_pengguna', 'status_akhir')) {
                $table->smallInteger('status_akhir')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_ubah_status_by_pengguna', function (Blueprint $table) {
            $table->dropColumn(['status_awal', 'status_akhir']);
        });
    }
};
