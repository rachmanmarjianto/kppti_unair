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
        Schema::table('acara', function (Blueprint $table) {
            $table->dropForeign(['idnarasumber']);
            $table->dropColumn('idnarasumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acara', function (Blueprint $table) {
            $table->unsignedInteger('idnarasumber')->nullable()->after('status');

            $table->foreign('idnarasumber')->references('idnarasumber')->on('narasumber');
        });
    }
};
