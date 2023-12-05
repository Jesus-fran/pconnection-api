<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'oferta' => 'nullable|String',
            'desc_oferta' => 'nullable|min:4|max:500|regex:/^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s¡!¿?.:,-]+$/',
        ];
    }

    public function messages()
    {
        return [

            'oferta.image' => 'Debe seleccionar una imagen correcta',
            'oferta.file' => 'Debe seleccionar una imagen correcta',
            'oferta.mimes' => 'Debe seleccionar una imagen correcta',
            'oferta.mimetypes' => 'Debe seleccionar una imagen correcta',
            'oferta.max' => 'La imagen no debe ser mayor a 2 megabytes',

            'desc_oferta.min' => 'Ingrese al menos 4 caracteres.',
            'desc_oferta.max' => 'El menu no debe ser mayor a 500 caracteres.',
            'desc_oferta.regex' => 'El menu no debe contener caracteres especiales.',
        ];
    }
}
