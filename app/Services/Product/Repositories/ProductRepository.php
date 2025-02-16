<?php

namespace App\Services\Product\Repositories;


use App\Models\Product;
use App\Repositories\Base\EloquentRepository;

class ProductRepository extends EloquentRepository implements ProductInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function model()
    {
        return 'App\Models\Product';
    }

}
