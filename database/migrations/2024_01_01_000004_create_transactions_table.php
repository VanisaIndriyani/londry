<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('customer_name');
            $table->decimal('total_weight', 8, 2);
            $table->decimal('price_per_unit', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->enum('payment_method', ['Cash', 'Transfer', 'QRIS']);
            $table->enum('payment_status', ['Belum Bayar', 'Lunas'])->default('Belum Bayar');
            $table->date('payment_date')->nullable();
            $table->string('proof_of_transfer')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
