<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected string $messagePrefix = 'global';
    protected string $permission = 'global';

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->messagePrefix .= '.';
    }

    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator);
    }

    public function messages(): array
    {
        return $this->messagesFromJson();
    }

    private function messagesFromJson(): array
    {
        try {
            $messages = trans('message');

            $response = [];
            foreach ($messages as $key => $message) {
                if (stristr($key, $this->messagePrefix)) {
                    $newKey = str_replace($this->messagePrefix, '', $key);
                    $response[$newKey] = $message;
                }
            }

            return $response;
        } catch (\Exception $exception) {
            return [];
        }
    }
}
