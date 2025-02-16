<?php

namespace App\Http\Requests;

class OrderDestroyRequest extends BaseRequest
{
    protected string $messagePrefix = 'order';

    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['order_id'] = $this->route('order_id');
        return $data;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
        ];
    }
}
