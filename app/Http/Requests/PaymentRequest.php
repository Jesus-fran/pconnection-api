<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'tokenCard' => 'required',
            'plan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tokenCard.required' => 'Es necesario un token card',
            'plan.required' => 'Es necesario un plan',
        ];
    }
}
