<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgregarContactoEmergenciaRequest extends FormRequest
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
            'personal_id' => 'required|exists:personal,idpersonal',
            'tipo_contacto_id' => 'required|exists:personal_tipo_contactos,id_tipo_contacto',
            'parentesco_id' => 'required|exists:personal_parentescos,id_parentesco',
            'ciudad_id' => 'nullable',
            'nombre_completo' => 'required|string',
            'direccion' => 'nullable|string',
            'contacto' => 'required|unique:personal_contactos_emergencias,contacto',
        ];
    }

    public function messages(): array
    {
        return [
            'personal_id.required' => 'El Personal es requerido',
            'personal_id.exists' => 'El Personal seleccionado no existe en la tabla personal',
            'tipo_contacto_id.required' => 'El Tipo de Contacto es requerido',
            'tipo_contacto_id.exists' => 'Selecciona una opcion valida',
            'parentesco_id.required' => 'El Parentesco es requerido',
            'parentesco_id.exists' => 'Selecciona una opcion valida',
            'nombre_completo.required' => 'El Nombre es requerido',
            'nombre_completo.string' => 'El Nombre debe ser tipo texto',
            'direccion.string' => 'El Nombre debe ser tipo texto',
            'contacto.required' => 'El Contacto es requerido',
            'contacto.unique' => 'El Contacto ya existe',
        ];
    }
}
