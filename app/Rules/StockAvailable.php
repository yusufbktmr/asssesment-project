<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class StockAvailable implements Rule
{
    private $productId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product = Product::find($this->productId);
        return $product && $value <= $product->stock;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return false;
    }
}
