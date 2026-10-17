<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Formalizes the column comment already set manually in development —
     * pameran.status_ajuan grew from 6 values (Draft..Ditolak) to 9 as
     * part of the 2-reviewer + Master SC redesign (dikonfirmasi developer).
     * Comment-only change, safe to run repeatedly.
     */
    public function up(): void
    {
        DB::statement("comment on column pameran.status_ajuan is '1: draft, 2: pengajuan, 3: review, 4: revisi, 5: Memenuhi, 6: Tidak Memenuhi, 7: Proses Seleksi, 8: Tidak Terpilih, 9: Terpilih'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("comment on column pameran.status_ajuan is '1: draft, 2: pengajuan, 3: review, 4: revisi, 5: Diterima, 6: Ditolak'");
    }
};
