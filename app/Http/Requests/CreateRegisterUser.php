<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateRegisterUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:100'],
            'password' => ['required', 'max:255'],
            'confirmPassword' => ['required', 'max:255'],
        ];
    }

     // overide message response error validation
     protected function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response([
             'error' => $validator->getMessageBag()
         ], 400));
     }
}
