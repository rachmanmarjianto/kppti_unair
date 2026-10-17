<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes a column already added manually in development, as part
     * of the SC pameran review restructure (see
     * create_reviewer_pameran_table).
     */
    public function up(): void
    {
        if (Schema::hasColumn('pameran', 'file_path_pertama')) {
            return;
        }

        Schema::table('pameran', function (Blueprint $table) {
            $table->string('file_path_pertama')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            $table->dropColumn('file_path_pertama');
        });
    }
};
