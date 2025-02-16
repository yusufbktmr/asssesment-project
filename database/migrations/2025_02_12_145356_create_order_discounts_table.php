<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('discount_reason');     // İndirimin sebebi (ör. BUY_5_GET_1)
            $table->decimal('discount_amount', 10, 2); // İndirim tutarı (ör. 11.28)
            $table->decimal('subtotal', 10, 2);    // Ara toplam (ör. 1263.90)
            $table->timestamps();

            // Foreign key (order_id)
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_discounts');
    }
}
