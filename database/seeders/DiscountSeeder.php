<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            [
                'name' => 'BUY_5_GET_1',
                'category_id' => 2,
                'min_quantity' => 6,
                'free_items' => 1,
                'price_target' => null,
                'price_discount_rate' => null,
                'order_total_discount_rate' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CHEAPEST_ITEM_20_OFF',
                'category_id' => 1,
                'min_quantity' => 2,
                'free_items' => 0,
                'price_target' => 'lowest',
                'price_discount_rate' => 20.00,
                'order_total_discount_rate' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '10_PERCENT_OVER_1000',
                'category_id' => null,
                'min_quantity' => null,
                'free_items' => 0,
                'price_target' => null,
                'price_discount_rate' => null,
                'order_total_discount_rate' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
