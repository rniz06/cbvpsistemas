<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonalRequest extends FormRequest
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
            // 'codigo' => [
            //     'required',
            //     Rule::unique('personal', 'codigo')
            //         ->where(function ($query) {
            //             return $query->where('categoria_id', $this->categoria_id);
            //         })
            //         ->ignore($this->idpersonal), // Ignora el registro actual
            // ],
            'categoria_id' => 'required|exists:personal_categorias,idpersonal_categorias',
            'compania_id' => 'required',
            'fecha_juramento' => 'required|numeric|min:4',
            'fecha_de_juramento' => 'required|date',
            'estado_id' => 'required|exists:personal_estados,idpersonal_estados',
            'documento' => 'required|numeric|min:6',
            'sexo_id' => 'required|exists:personal_sexo,idpersonal_sexo',
            'nacionalidad_id' => 'required|exists:paises,idpaises',
            'grupo_sanguineo_id' => 'required|exists:personal_grupo_sanguineo,idpersonal_grupo_sanguineo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombrecompleto.required' => 'El nombre es requerido',
            'nombrecompleto.string' => 'El nombre debe ser tipo texto',
            // 'codigo.required' => 'El Codigo es requerido',
            // 'codigo.numeric' => 'El Codigo debe ser númerico',
            // 'codigo.unique' => 'El Codigo ya existe',
            'categoria_id.required' => 'La Categoria es requerida',
            'categoria_id.exists' => 'Categoria: Selecciona una opción valida',
            'compania_id.required' => 'La Compañia es requerida',
            'fecha_juramento.required' => 'La Fecha De Juramento es requerida',
            'fecha_juramento.numeric' => 'La Fecha De Juramento debe ser númerica',
            'fecha_juramento.min' => 'La Fecha De Juramento debe contener 4 caracteres',
            'estado_id.required' => 'El Estado es requerido',
            'estado_id.exists' => 'Estado: Selecciona una opción valida',
            'documento.required' => 'El Documento es requerido',
            'documento.numeric' => 'El Documento debe ser númerico',
            'documento.min' => 'El Documento debe contener al menos 6 caracteres',
            'sexo_id.required' => 'El Sexo es requerido',
            'sexo_id.exists' => 'Sexo: Selecciona una opción valida',
            'nacionalidad_id.required' => 'La Nacionalidad es requerida',
            'nacionalidad_id.exists' => 'Nacionalidad: Selecciona una opción valida',
            'grupo_sanguineo_id.required' => 'El Grupo Sanguineo es requerida',
            'grupo_sanguineo_id.exists' => 'Grupo Sanguineo: Selecciona una opción valida',
        ];
    }
}
