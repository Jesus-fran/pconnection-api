<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRestaurantRequest extends FormRequest
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
            'tipo' => 'required|max:100|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?-]+$/',
        ];
    }

    public function messages()
    {
        return [
            'tipo.max' => 'El tipo no debe ser mayor a 100 caracteres.',
            'tipo.regex' => 'La tipo no debe contener caracteres especiales.',
        ];
    }
}
