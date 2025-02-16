<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Services\Discount\Repositories\DiscountRepository;
use App\Services\Order\Repositories\OrderRepository;
use App\Services\Product\Repositories\ProductRepository;
use Illuminate\Http\Response;

class OrderService
{

    public function __construct(
        public OrderRepository $repository,
        protected DiscountRepository $discount_repository,
        protected ProductRepository $product_repository)
    {
    }

    public function orderStore($attributes)
    {
        try {
            $orderData = $attributes->all();
            $customerId = $orderData['customerId'];
            $items = $orderData['stock'];

            // 1. Order oluştur
            $order = Order::create([
                'customer_id' => $customerId,
                'total' => 0,
            ]);

            $totalPrice = 0;
            $discounts = $this->discount_repository->get();
            $orderDiscounts = [];
            $orderItems = [];
            $lowestPrice = 0;

            foreach ($items as $item) {
                $product = $this->product_repository->find($item['productId']);
                $lowestPrice = $lowestPrice == 0 ? $product->price : ($lowestPrice > $product->price ? $product->price : $lowestPrice);
                $itemTotal = $product->price * $item['quantity'];
                $orderItems[] = new OrderItem([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $itemTotal,
                ]);

                $totalPrice += $itemTotal;

                if ($product->stock >= $item['quantity']) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                } else {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }
            }

            $discountedTotal = $totalPrice;
            foreach ($discounts as $discount) {
                // Discount for category
                foreach ($items as $item) {
                    $product = $this->product_repository->find($item['productId']);
                    if ($discount->category_id && $discount->category_id == $product->category_id) {
                        if ($discount->free_items) {
                            // For Free Items
                            $freeItems = floor($item['quantity'] / $discount->min_quantity) * $discount->free_items;
                            $discountAmount = $freeItems * $product->price;
                            $orderDiscounts[] = new OrderDiscount([
                                'discount_reason' => $discount->name,
                                'discount_amount' => $discountAmount,
                                'subtotal' => $discountedTotal,
                            ]);
                            $discountedTotal -= $discountAmount;
                        }

                        if ($discount->price_target === 'lowest') {
                            // Discount for lower item
                            if ($item['quantity'] >= $discount->min_quantity) {
                                $discountAmount = $lowestPrice * $discount->price_discount_rate / 100;
                                $orderDiscounts[] = new OrderDiscount([
                                    'discount_reason' => $discount->name,
                                    'discount_amount' => $discountAmount,
                                    'subtotal' => $discountedTotal,
                                ]);
                                $discountedTotal -= $discountAmount;
                            }
                        }
                    }
                }

                // Discount For Total Price
                if ($discount->order_total_discount_rate && $totalPrice >= 1000) {
                    $totalDiscount = ($discountedTotal * $discount->order_total_discount_rate) / 100;
                    $orderDiscounts[] = new OrderDiscount([
                        'discount_reason' => $discount->name,
                        'discount_amount' => $totalDiscount,
                        'subtotal' => $discountedTotal,
                    ]);
                    $discountedTotal -= $totalDiscount;
                }
            }

            // 4. OrderItemları veritabanına kaydet
            $order->items()->saveMany($orderItems);

            // 5. OrderDiscountları veritabanına kaydet
            $order->discounts()->saveMany($orderDiscounts);

            // 6. Order'ı güncelle ve toplam tutarı ayarla
            $order->total = $discountedTotal;
            $order->save();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function orderDestroy($orderId)
    {
        try {
            $order = $this->repository->find($orderId);
            \DB::transaction(function () use ($order) {
                $order->items()->delete();
                $order->discounts()->delete();
                $order->delete();
            });

            return response()->json([
                'message' => __('Order deleted successfully'),
            ], Response::HTTP_OK);

        } catch (\Exception $e) {

            return response()->json([
                'message' => __('Failed to delete the order'),
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

