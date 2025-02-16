<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDestroyRequest;
use App\Http\Requests\OrderDiscountRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Services\Discount\DiscountService;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service)
    {
    }

    public function index()
    {
        return $this->service->repository->index();
    }

    public function store(OrderStoreRequest $request)
    {
        $response = $this->service->orderStore($request);
        return $this->service->repository->index($response->id);
    }

    public function destroy(OrderDestroyRequest $request)
    {
        return $this->service->orderDestroy($request->order_id);
    }

    public function orderDiscount(OrderDiscountRequest $request)
    {
        return $this->service->repository->orderDiscount($request->order_id);
    }
}
