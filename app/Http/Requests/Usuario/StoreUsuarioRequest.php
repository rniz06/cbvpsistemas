<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'personal_id' => 'required|unique:users,personal_id|exists:personal,idpersonal',
        ];
    }

    public function messages(): array
    {
        return [
            'personal_id.required' => 'Este Campo es requerido',
            'personal_id.unique' => 'Este Registro Ya existe en la tabla de Usuarios',
            'personal_id.exists' => 'El id del registro no existe en la tabla: personal.idpersonal'            
        ];
    }
}
