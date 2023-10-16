<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAutenticationRequest extends FormRequest
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
            'email' => 'required|email|max:60',
            'password' => 'required|string|min:6|max:30|regex:/^(?=.*[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ])(?=.*\d)(?=.*[@$!%*?&^#\/_.;\s:-])[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d@$!%*?&^#\/_.;\s:-]+$/',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar un correo',
            'email.email' => 'Debe ingresar un correo valido',
            'email.max' => 'Su correo no debe tener más  de 60 caracteres',
            'password.required' => 'Debe ingresar una contraseña',
            'password.string' => 'La contraseña debe ser un string',
            'password.min' => 'Su contraseña debe tener al menos 6 caracteres',
            'password.max' => 'Su contraseña de debe tener más de 30 caracteres',
            'password.regex' => 'Su contraseña debe tener al menos una letra minúscula o  mayúscula, un número y un caracter especial',
        ];
    }
}
