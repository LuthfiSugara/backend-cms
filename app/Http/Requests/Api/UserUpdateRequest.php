<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'min:6',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Cannot be empty!',
            'email.required' => 'Cannot be empty!',
            'email.unique' => 'Email already registered!',
            'email.email' => 'Wrong email format!',
            'password.min' => 'Minimum 6 characters!',
            'role.required' => 'Cannot be empty!',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => "fail",
            'error' => $validator->errors(),
            'message' => $validator->errors()->first(),
        ]));
    }
}
