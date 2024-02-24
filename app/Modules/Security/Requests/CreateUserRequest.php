<?php

namespace App\Modules\Security\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateUserRequest extends FormRequest
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
            'username' => ['required', 'string', 'max:255','unique:users,username'],
            'password' => ['required', 'string', 'min:9', 'max:255'],
            'email' => ['required','email', 'string', 'max:255']
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response( ['spec' => ['messages' => $validator->errors()]]));
    }
}
