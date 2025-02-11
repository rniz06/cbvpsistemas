<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgregarContactoRequest extends FormRequest
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
            'tipo_contacto_id' => 'required|exists:personal_tipo_contactos,id_tipo_contacto',
            'contacto' => 'required|unique:personal_contactos,contacto',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_contacto_id.required' => 'El Tipo de Contacto es requerido',
            'tipo_contacto_id.exists' => 'Selecciona una opcion valida',
            'contacto.required' => 'El Contacto es requerido',
            'contacto.unique' => 'El Contacto ya existe',
        ];
    }
}
