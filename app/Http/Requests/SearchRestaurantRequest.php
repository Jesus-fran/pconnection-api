<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRestaurantRequest extends FormRequest
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

            'busqueda' => 'required|min:3|max:50|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.,]+$/',
        ];
    }

    public function messages()
    {
        return [
            'busqueda.required' => 'Ingrese su busqueda',
            'busqueda.min' => 'Ingrese al menos 3 caracteres',
            'busqueda.max' => 'Tu busqueda no debe ser mayor a 50 caracteres.',
            'busqueda.regex' => 'Tu busqueda no debe contener caracteres especiales.',
        ];
    }
}
