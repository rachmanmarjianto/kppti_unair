<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('idpembayaran');
            $table->unsignedInteger('idtagihan')->nullable();
            $table->integer('trx_amount')->nullable();
            $table->timestamp('datetime_payment', 6)->nullable();
            $table->string('payment_ntb')->nullable();
            $table->integer('cumulative_payment_amount')->nullable();

            $table->foreign('idtagihan')->references('idtagihan')->on('tagihan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
