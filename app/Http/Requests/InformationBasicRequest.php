<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationBasicRequest extends FormRequest
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
            'restaurant' => 'nullable|max:50|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.,]+$/',
            'logo' => 'nullable|String',
            'telefono' => 'nullable|regex:/^[0-9]{10}$/',
            'descripcion' => 'nullable|max:100|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.:,-]+$/',
            'tipo' => 'nullable|max:100|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?-]+$/',
        ];
    }


    public function messages()
    {
        return [
            'restaurant.max' => 'El nombre no debe ser mayor a 50 caracteres.',
            'restaurant.regex' => 'El titulo no debe contener caracteres especiales.',

            'logo.image' => 'Debe seleccionar una imagen correcta',
            'logo.file' => 'Debe seleccionar una imagen correcta',
            'logo.mimes' => 'Debe seleccionar una imagen correcta',
            'logo.mimetypes' => 'Debe seleccionar una imagen correcta',
            'logo.max' => 'La imagen no debe ser mayor a 2 megabytes',

            'telefono.regex' => 'El telefono solo debe contener numeros y una longitud de 10 caracteres.',

            'descripcion.max' => 'La descripción no debe ser mayor a 100 caracteres.',
            'descripcion.regex' => 'La descripción no debe contener caracteres especiales.',

            'tipo.max' => 'El tipo no debe ser mayor a 100 caracteres.',
            'tipo.regex' => 'La tipo no debe contener caracteres especiales.',
        ];
    }
}
