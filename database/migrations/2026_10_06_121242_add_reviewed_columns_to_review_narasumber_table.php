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
     * Formalizes a schema change already applied manually in development
     * (see kppti_20.sql) — guarded so it's also safe on a fresh install
     * where the columns/FK don't exist yet.
     */
    public function up(): void
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_narasumber', function (Blueprint $table) {
            $table->dropForeign('fk_review_narasumber_pengguna_2');
            $table->dropColumn(['reviewed_by', 'reviewed_at']);
        });
    }

    private function constraintExists(string $name): bool
    {
        return DB::selectOne('select 1 from pg_constraint where conname = ?', [$name]) !== null;
    }
};
