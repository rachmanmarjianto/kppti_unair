<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The 4 initial seminar_kit rows were inserted manually with explicit
     * ids, without advancing the id sequence — so it was still at 1 while
     * the actual max id was 4, meaning the very next real insert (e.g. the
     * admin's "Tambah Jenis Kit") would fail with a duplicate key error.
     * Resets the sequence to max(idseminar_kit); safe/no-op on a fresh
     * install (empty table) or if already in sync.
     */
    public function up(): void
    {
        DB::statement("SELECT setval(pg_get_serial_sequence('seminar_kit', 'idseminar_kit'), COALESCE((SELECT MAX(idseminar_kit) FROM seminar_kit), 1))");
    }

    /**
     * Reverse the migrations.
     *
     * Nothing to reverse — this only corrects sequence state, which isn't
     * meaningfully "undoable" (and leaving it corrected is always safe).
     */
    public function down(): void
    {
        //
    }
};
