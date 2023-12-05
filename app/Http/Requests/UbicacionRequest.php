<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UbicacionRequest extends FormRequest
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
            'ubicacion' => 'required|min:4|max:100|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.:,-]+$/',
        ];
    }

    public function messages()
    {
        return [
            'ubicacion.required' => 'Ingrese la ubicación de su negocio',
            'ubicacion.min' => 'Ingrese al menos 4 caracteres.',
            'ubicacion.max' => 'Su ubicación no debe ser mayor a 100 caracteres.',
            'ubicacion.regex' => 'Su ubicación no debe contener caracteres especiales.',
        ];
    }
}
