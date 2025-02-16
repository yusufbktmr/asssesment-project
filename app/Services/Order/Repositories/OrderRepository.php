<?php

namespace App\Services\Order\Repositories;


use App\Models\Order;
use App\Repositories\Base\EloquentRepository;
use http\Env\Request;

class OrderRepository extends EloquentRepository implements OrderInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function model()
    {
        return 'App\Models\Order';
    }

    public function index($id = null)
    {
        return $this->model->query()->with('items')
            ->when($id, function ($q, $id) {
                return $q->where('id', $id);
            })
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customerId' => $order->customer_id,
                    'items' => collect($order->items)->map(function ($item) {
                        return [
                            'productId' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'unitPrice' => $item['unit_price'],
                            'total' => $item['total'],
                        ];
                    })->toArray(),
                    'total' => $order->total,
                ];
            })->toArray();
    }

    public function orderDiscount($order_id)
    {
        return $this->model->query()->with('discounts')
            ->where("id", "=",$order_id)
            ->get()
            ->map(function ($order) {
               return [
                   "orderId" => $order->id,
                   "discounts" => collect($order->discounts)->map(function ($discount) {
                       return [
                           "discountReason" => $discount->discount_reason,
                           "discountAmount" => $discount->discount_amount,
                           "subtotal" => $discount->subtotal,
                       ];
                   }),
                   "totalDiscount" => (string)collect($order->discounts)->sum('discount_amount'),
                   "discountedTotal" => $order->total,
               ];
            });
    }
}
