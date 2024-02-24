<?php

namespace App\Modules\Publication\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class HidePublicationRequest extends FormRequest
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
            'complaint' => ['filled','array'],
            'complaint.reason' => ['string','required_with:complaint'],
            'complaint.comment' => ['string'],
            'complaint.media' => ['array'],

            'stories' => ['filled','boolean'],
            'unsubscription' => ['filled','boolean'],
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response( ['spec' => ['messages' => $validator->errors()]]));
    }
}
