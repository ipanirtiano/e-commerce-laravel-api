<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'name' => ['nullable', 'max:100'],
            'email' => ['nullable', 'max:100'],
            'phone' => ['nullable', 'max:20'],
            'address' => ['nullable', 'max:100'],
            'password' => ['nullable', 'max:255'],
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
