<?php

namespace App\Services\Discount\Repositories;


use App\Models\Discount;
use App\Repositories\Base\EloquentRepository;

class DiscountRepository extends EloquentRepository implements DiscountInterface
{
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }

    public function model()
    {
        return 'App\Models\Discount';
    }

}
