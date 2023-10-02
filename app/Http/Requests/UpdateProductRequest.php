<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['nullable', 'max:100'],
            'categories' => ['nullable', 'max:50'],
            'color' => ['nullable', 'max:50'],
            'size' => ['nullable', 'max:50'],
            'storage' => ['nullable', 'max:50'],
            'description' => ['nullable'],
            'price' => ['nullable'],
        ];
    }

     // override message response
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response([
             'error' => $validator->getMessageBag()
         ], 400));
     }
}
