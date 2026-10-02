<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('narasumber', function (Blueprint $table) {
            $table->dropForeign(['iduniversitas']);
            $table->dropColumn('iduniversitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('narasumber', function (Blueprint $table) {
            $table->unsignedBigInteger('iduniversitas')->nullable();

            $table->foreign('iduniversitas')->references('iduniversitas')->on('universitas');
        });
    }
};
