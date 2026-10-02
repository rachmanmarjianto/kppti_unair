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
        Schema::table('acara', function (Blueprint $table) {
            $table->char('opsi_pilih', 1)->nullable()->after('ruang')
                ->comment('1: none; 2: opsional; 3: wajib;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acara', function (Blueprint $table) {
            $table->dropColumn('opsi_pilih');
        });
    }
};
