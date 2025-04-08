<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'categoria_id' => 'required|exists:personal_categorias,idpersonal_categorias',
            'usuario' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Personalizar el mensaje de error segun el campo.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Categoria Requerida.',
            'categoria_id.exists' => 'Categoria No Valida.',
            'usuario.required' => 'Usuario requerido.',
            'password.required' => 'Contraseña requerida.',
        ];
    }
}
