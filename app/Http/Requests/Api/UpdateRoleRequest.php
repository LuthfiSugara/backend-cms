<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
            'id' => 'required',
            'name' => [
                'required',
                Rule::unique('role')->ignore($this->id, 'id')
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Cannot be empty!',
            'name.required' => 'Cannot be empty!',
            'name.unique' => 'Role already registered!',
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
