<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'nombrecompleto' => 'required|string|max:80',
            //'codigo' => ['required','numeric','unique:personal,codigo,'.$this->categoria_id.',categoria_id'],    
            'codigo' => [
                'required',
                'numeric',
                'max_digits:5',
                'min_digits:1',
                Rule::unique('personal')->where(function ($query) {
                    return $query->where('categoria_id', $this->categoria_id);
                }),
            ],
            'categoria_id' => 'required|exists:personal_categorias,idpersonal_categorias',
            'compania_id' => 'required',
            //'fecha_juramento' => 'required|numeric|min_digits:4|max_digits:4',
            'fecha_de_juramento' => 'required|date',
            'estado_id' => 'required',
            'documento' => 'required|numeric|min_digits:6|max_digits:7',
            'sexo_id' => 'required|exists:personal_sexo,idpersonal_sexo',
            'nacionalidad_id' => 'required',
            'grupo_sanguineo_id' => 'required|exists:personal_grupo_sanguineo,idpersonal_grupo_sanguineo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombrecompleto.required' => 'El nombre es requerido',
            'nombrecompleto.string' => 'El nombre debe ser tipo texto',
            'nombrecompleto.max' => 'El Nombre Completo debe contener maximo 80 caracteres',
            'codigo.required' => 'El Codigo es requerido',
            'codigo.numeric' => 'El Codigo debe ser númerico',
            'codigo.unique' => 'El Codigo ya existe en esa categoria',
            'codigo.max' => 'El Codigo debe contener maximo 5 números',
            //'codigo.unique' => 'El Codigo ya existe',
            'categoria_id.required' => 'La Categoria es requerida',
            'compania_id.required' => 'La Compañia es requerida',
            'fecha_juramento.required' => 'El año De Juramento es requerida',
            'fecha_juramento.numeric' => 'El año De Juramento debe ser númerica',
            'fecha_juramento.min' => 'El año De Juramento debe contener 4 caracteres',
            'fecha_juramento.max' => 'El año De Juramento debe contener maximo 4 caracteres',
            'fecha_de_juramento.required' => 'La Fecha De Juramento es requerida',
            'fecha_de_juramento.numeric' => 'La Fecha De Juramento debe ser de tipo fecha',
            'estado_id.required' => 'El Estado es requerido',
            'documento.required' => 'El Documento es requerido',
            'documento.numeric' => 'El Documento debe ser númerico',
            'documento.min' => 'El Documento debe contener al menos 6 caracteres',
            'documento.max' => 'El Documento debe contener maximo 7 caracteres',
            'nacionalidad_id.required' => 'La Nacionalidad es requerida',
            'grupo_sanguineo_id.required' => 'La Grupo Sanguineo es requerida',
            'grupo_sanguineo_id.exists' => 'El Grupo Sanguineo no existe en la tabla',
        ];
    }
}
