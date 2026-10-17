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
     * Part of the SC pameran review restructure (dikonfirmasi developer,
     * see create_reviewer_pameran_table): review_pameran no longer links
     * to pameran directly — it's reached via
     * `created_by -> reviewer_pameran.idreviewer_pameran -> idpameran`
     * instead, so one pameran can have multiple independent reviewers.
     * `idpameran` is dropped, and `created_by`'s FK is repointed from
     * `pengguna` to `reviewer_pameran`.
     */
    public function up(): void
    {
        $this->dropForeignKeysOnColumn('review_pameran', 'created_by');
        $this->dropForeignKeysOnColumn('review_pameran', 'idpameran');

        if (Schema::hasColumn('review_pameran', 'idpameran')) {
            Schema::table('review_pameran', function (Blueprint $table) {
                $table->dropColumn('idpameran');
            });
        }

        if (! $this->constraintExists('fk_review_pameran_reviewer_pameran_1')) {
            Schema::table('review_pameran', function (Blueprint $table) {
                $table->foreign('created_by', 'fk_review_pameran_reviewer_pameran_1')
                    ->references('idreviewer_pameran')->on('reviewer_pameran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropForeignKeysOnColumn('review_pameran', 'created_by');

        if (! Schema::hasColumn('review_pameran', 'idpameran')) {
            Schema::table('review_pameran', function (Blueprint $table) {
                $table->unsignedInteger('idpameran')->nullable();
            });
        }

        Schema::table('review_pameran', function (Blueprint $table) {
            $table->foreign('idpameran')->references('idpameran')->on('pameran');
            $table->foreign('created_by')->references('idpengguna')->on('pengguna');
        });
    }

    private function constraintExists(string $name): bool
    {
        return DB::selectOne('select 1 from pg_constraint where conname = ?', [$name]) !== null;
    }

    private function dropForeignKeysOnColumn(string $table, string $column): void
    {
        $rows = DB::select(
            "select con.conname
                from pg_constraint con
                join pg_attribute att on att.attnum = any(con.conkey) and att.attrelid = con.conrelid
                where con.conrelid = ?::regclass
                  and con.contype = 'f'
                  and att.attname = ?",
            [$table, $column]
        );

        foreach ($rows as $row) {
            DB::statement("alter table {$table} drop constraint {$row->conname}");
        }
    }
};
