<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institusi_asal', function (Blueprint $table) {
            $table->increments('idinstitusi_asal');
            $table->unsignedInteger('idjenis_institusi')->nullable()->comment('1: PTN / PTS, 2: asosiasi, 3: lembaga akreditasi, 4: Pemerhati Pendidikan, 5: LL Dikti, 6: Lainnya');
            $table->char('ptn_pts', 1)->nullable()->comment('1: PTN; 2:PTS');
            $table->string('nama_institusi')->nullable();
            $table->string('tabel_ref_institusi')->nullable();
            $table->bigInteger('idref_institusi')->nullable();
            $table->unsignedInteger('idlldikti')->nullable();
            $table->string('kode_kontingen', 5)->nullable()->comment('XXZZZ, XX: tanggal 2 digit, ZZZ: urutan dihari itu');
            $table->timestamp('created_at', 6)->nullable();

            $table->foreign('idjenis_institusi')->references('idjenis_institusi')->on('jenis_institusi');
            $table->foreign('idlldikti')->references('idlldikti')->on('lldikti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institusi_asal');
    }
};
