<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->increments('idtagihan');
            $table->unsignedInteger('idinstitusi_asal')->nullable();
            $table->timestamp('created_at', 6)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('va', 50)->nullable();
            $table->smallInteger('status')->nullable()->comment('1: tertagih; 2: terbayar sebagian; 3: lunas; 4: batal');
            $table->integer('tagihan')->nullable();
            $table->integer('sisa_tagihan')->nullable();
            $table->date('expired_date')->nullable();
            $table->char('billing_type', 1)->nullable();
            $table->string('customer_email', 500)->nullable();
            $table->string('payment_ntb', 100)->nullable();
            $table->char('va_status', 1)->nullable()->comment('1: aktif; 2: non aktif');
            $table->unsignedInteger('idpameran')->nullable();

            $table->foreign('idinstitusi_asal')->references('idinstitusi_asal')->on('institusi_asal');
            $table->foreign('idpameran')->references('idpameran')->on('pameran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
