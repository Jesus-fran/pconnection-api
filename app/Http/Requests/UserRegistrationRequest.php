<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'email' => 'required|email|max:60|unique:users,email',
            'password' => 'required|string|min:6|max:30|regex:/^(?=.*[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ])(?=.*\d)(?=.*[@$!%*?&])[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d@$!%*?&]+$/',
            'username' => 'required|min:4|max:25|regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar un correo',
            'email.email' => 'Debe ingresar un correo valido',
            'email.max' => 'Su correo no debe tener más  de 60 caracteres',
            'email.unique' => 'Ya existe una cuenta con este correo, debe elegir otro',
            'username.required' => 'Debe ingresar un nombre de usuario',
            'username.min' => 'Su nombre debe tener al menos 4 caracteres',
            'username.max' => 'Su nombre no debe tener más de 25 caracteres',
            'username.regex' => 'Su nombre no debe tener caracteres especiales',
            'password.required' => 'Debe ingresar una contraseña',
            'password.string' => 'La contraseña debe ser un string',
            'password.min' => 'Su contraseña debe tener al menos 6 caracteres',
            'password.max' => 'Su contraseña de debe tener más de 30 caracteres',
            'password.regex' => 'Su contraseña debe tener al menos una letra minúscula o  mayúscula, un número y un caracter especial',
        ];
    }
}
