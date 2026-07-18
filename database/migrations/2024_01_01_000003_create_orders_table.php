<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->text('customer_address');
            $table->foreignId('service_id')->constrained();
            $table->decimal('weight', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->enum('status', ['Menunggu Konfirmasi', 'Dijemput', 'Dicuci', 'Disetrika', 'Selesai', 'Diantar'])->default('Menunggu Konfirmasi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
