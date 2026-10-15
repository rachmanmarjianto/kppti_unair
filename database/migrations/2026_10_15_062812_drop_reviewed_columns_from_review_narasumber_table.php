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
     * reviewed_by/reviewed_at (added by
     * 2026_10_06_121242_add_reviewed_columns_to_review_narasumber_table)
     * were removed manually by the developer — that info now lives in
     * isi_review_narsum.created_by/created_at instead. This formalizes the
     * removal so a fresh install ends up matching the live DB, without
     * editing the already-applied migration above.
     */
    public function up(): void
    {
        if ($this->constraintExists('fk_review_narasumber_pengguna_2')) {
            Schema::table('review_narasumber', function (Blueprint $table) {
                $table->dropForeign('fk_review_narasumber_pengguna_2');
            });
        }

        Schema::table('review_narasumber', function (Blueprint $table) {
            if (Schema::hasColumn('review_narasumber', 'reviewed_by')) {
                $table->dropColumn('reviewed_by');
            }

            if (Schema::hasColumn('review_narasumber', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_narasumber', function (Blueprint $table) {
            if (! Schema::hasColumn('review_narasumber', 'reviewed_by')) {
                $table->unsignedInteger('reviewed_by')->nullable();
            }

            if (! Schema::hasColumn('review_narasumber', 'reviewed_at')) {
                $table->timestamp('reviewed_at', 6)->nullable();
            }
        });

        if (! $this->constraintExists('fk_review_narasumber_pengguna_2')) {
            Schema::table('review_narasumber', function (Blueprint $table) {
                $table->foreign('reviewed_by', 'fk_review_narasumber_pengguna_2')
                    ->references('idpengguna')->on('pengguna');
            });
        }
    }

    private function constraintExists(string $name): bool
    {
        return DB::selectOne('select 1 from pg_constraint where conname = ?', [$name]) !== null;
    }
};
