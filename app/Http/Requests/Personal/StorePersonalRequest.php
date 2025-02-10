<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalRequest extends FormRequest
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
            'nombrecompleto' => 'required|string',
            'codigo' => 'required|numeric|unique:personal,codigo',
            'categoria_id' => 'required',
            'compania_id' => 'required',
            'fecha_juramento' => 'required|numeric|min:4',
            'estado_id' => 'required',
            'documento' => 'required|numeric|min:6',
            'sexo_id' => 'required',
            'nacionalidad_id' => 'required',
            'grupo_sanguineo_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nombrecompleto.required' => 'El nombre es requerido',
            'nombrecompleto.string' => 'El nombre debe ser tipo texto',
            'codigo.required' => 'El Codigo es requerido',
            'codigo.numeric' => 'El Codigo debe ser númerico',
            'codigo.unique' => 'El Codigo ya existe',
            'categoria_id.required' => 'La Categoria es requerida',
            'compania_id.required' => 'La Compañia es requerida',
            'fecha_juramento.required' => 'La Fecha De Juramento es requerida',
            'fecha_juramento.numeric' => 'La Fecha De Juramento debe ser númerica',
            'fecha_juramento.min' => 'La Fecha De Juramento debe contener 4 caracteres',
            'estado_id.required' => 'El Estado es requerido',
            'documento.required' => 'El Documento es requerido',
            'documento.numeric' => 'El Documento debe ser númerico',
            'documento.min' => 'El Documento debe contener al menos 6 caracteres',
            'nacionalidad_id.required' => 'La Nacionalidad es requerida',
            'grupo_sanguineo_id.required' => 'La Grupo Sanguineo es requerida',
        ];
    }
}
