<?php

namespace App\Modules\Publication\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class GetAllPublicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['int','exists:users,id']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response( ['spec' => ['messages' => $validator->errors()]]));
    }
}
