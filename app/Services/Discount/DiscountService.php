<?php

namespace App\Services\Discount;


use App\Services\Discount\Repositories\DiscountRepository;

class DiscountService
{

    public function __construct(public DiscountRepository $discount_repository)
    {

    }


}

