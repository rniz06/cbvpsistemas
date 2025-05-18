<?php

namespace App\Http\Requests\Materiales\Conductores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConductorRequest extends FormRequest
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
            'personal_id' => ['required', Rule::unique('conductores_bomberos')],
            'resolucion' => ['required', 'max:50'],
            'resolucion_enlace' => ['nullable', 'max:255'],
            'fecha_curso' => ['required', 'date'],
            'ciudad_curso_id' => ['required'],
            'ciudad_licencia_id' => ['required'],
            'tipo_vehiculo_id' => ['required', 'exists:conductores_tipo_vehiculo,idconductor_tipo_vehiculo'],
            'numero_licencia' => ['required', 'unique:conductores_bomberos,numero_licencia', 'numeric', 'min_digits:6', 'max_digits:7'],
            'clase_licencia_id' => ['required', 'exists:conductores_clase_licencias,idconductor_clase_licencia'],
        ];
    }
}
