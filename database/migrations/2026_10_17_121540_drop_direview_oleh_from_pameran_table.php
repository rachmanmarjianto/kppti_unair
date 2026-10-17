<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * `pameran.direview_oleh` (added by
     * 2026_10_05_070000_add_direview_oleh_to_pameran_table) is removed —
     * single-reviewer claim is replaced by the `reviewer_pameran` table
     * (multiple reviewers per pameran, dikonfirmasi developer). Never
     * editing the already-applied migration above, per project convention.
     */
    public function up(): void
    {
        if ($this->constraintExists('fk_pameran_pengguna_1')) {
            Schema::table('pameran', function (Blueprint $table) {
                $table->dropForeign('fk_pameran_pengguna_1');
            });
        }

        if (Schema::hasColumn('pameran', 'direview_oleh')) {
            Schema::table('pameran', function (Blueprint $table) {
                $table->dropColumn('direview_oleh');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pameran', function (Blueprint $table) {
            if (! Schema::hasColumn('pameran', 'direview_oleh')) {
                $table->unsignedInteger('direview_oleh')->nullable();
            }
        });

        if (! $this->constraintExists('fk_pameran_pengguna_1')) {
            Schema::table('pameran', function (Blueprint $table) {
                $table->foreign('direview_oleh', 'fk_pameran_pengguna_1')->references('idpengguna')->on('pengguna');
            });
        }
    }

    private function constraintExists(string $name): bool
    {
        return DB::selectOne('select 1 from pg_constraint where conname = ?', [$name]) !== null;
    }
};
