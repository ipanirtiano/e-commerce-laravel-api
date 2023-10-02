<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddNewOrderRequest extends FormRequest
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
            'products' => ['required'],
            'amount' => ['required'],
            'name' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'package' => ['nullable'],
            'status' => ['nullable'],
        ];
    }

     // throw error message response
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response([
             'error' => $validator->getMessageBag()
         ], 400));
     }
}
