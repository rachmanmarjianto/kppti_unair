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
     * `log_peserta.done_by` (siapa yang melakukan aksi) tidak pernah punya FK
     * ke `pengguna.idpengguna` — kekurangan ini sudah ditambal manual di live
     * DB (lihat kppti_25.sql), migrasi ini cuma menambal kode supaya cocok,
     * sekaligus aman untuk fresh install (guard lewat cek
     * information_schema, bukan hasColumn/hasTable, karena kolomnya sudah
     * ada dari migrasi create_log_peserta_table — yang belum ada cuma FK-nya).
     */
    public function up(): void
    {
        if ($this->foreignKeyExists('log_peserta', 'fk_log_peserta_pengguna_1')) {
            return;
        }

        Schema::table('log_peserta', function (Blueprint $table) {
            $table->foreign('done_by', 'fk_log_peserta_pengguna_1')->references('idpengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_peserta', function (Blueprint $table) {
            $table->dropForeign('fk_log_peserta_pengguna_1');
        });
    }

    private function foreignKeyExists(string $table, string $constraintName): bool
    {
        return DB::table('information_schema.table_constraints')
            ->where('table_name', $table)
            ->where('constraint_name', $constraintName)
            ->exists();
    }
};
