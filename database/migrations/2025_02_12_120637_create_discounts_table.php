<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable()->comment('Discount applies to this category ID. Null means applies to all categories.');
            $table->integer('min_quantity')->nullable()->comment('Minimum quantity of items to apply the discount.');
            $table->integer('free_items')->nullable()->default(0)->comment('Number of free items for bulk purchases.');
            $table->enum('price_target', ['highest', 'lowest'])->nullable()->comment('Target for price-based discounts (highest or lowest priced item).');
            $table->decimal('price_discount_rate', 5, 2)->nullable()->default(0)->comment('Discount rate for the price target.');
            $table->decimal('order_total_discount_rate', 5, 2)->nullable()->default(0)->comment('Discount rate for total order amount.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
