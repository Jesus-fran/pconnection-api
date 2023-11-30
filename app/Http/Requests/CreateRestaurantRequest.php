<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRestaurantRequest extends FormRequest
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
            'restaurant' => 'required|min:4|max:50|unique:restaurants,restaurant|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.,]+$/',
        ];
    }

    public function messages()
    {
        return [
            'restaurant.required' => 'Debe ingresar el nombre de su restaurante.',
            'restaurant.min' => 'El nombre debe contener al menos 4 caracteres.',
            'restaurant.max' => 'El nombre no debe ser mayor a 50 caracteres.',
            'restaurant.unique' => 'Este nombre de restaurante ya existe. Eliga otro.',
            'restaurant.regex' => 'El nombre no debe contener caracteres especiales.',
        ];
    }
}
