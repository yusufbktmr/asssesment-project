<?php

namespace App\Http\Requests;

use App\Rules\StockAvailable;

class OrderStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "customerId" => "required|integer|exists:customers,id",
            "stock" => "required|array",
            "stock.*.productId" => ["required", "integer", "exists:products,id"],
            "stock.*.quantity" => ["required", "integer", "min:1",
                function ($attribute, $value, $fail) {
                    $index = explode(".", $attribute)[1];
                    $stockCheck = new StockAvailable($this->stock[$index]["productId"]);
                    if (!$stockCheck->passes($attribute, $value)) {
                        $fail(__('validation.product.stock'));
                    }

                }],
        ];
    }
}
