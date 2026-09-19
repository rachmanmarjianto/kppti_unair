<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lldikti', function (Blueprint $table) {
            $table->increments('idlldikti');
            $table->string('nomor_lldikti', 5)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lldikti');
    }
};
