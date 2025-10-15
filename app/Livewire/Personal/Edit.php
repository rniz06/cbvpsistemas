<?php

namespace App\Livewire\Personal;

use App\Models\Personal;
use App\Models\Personal\Categoria;
use App\Models\Personal\Estado;
use App\Models\Personal\EstadoActualizar;
use App\Models\Personal\GrupoSanguineo;
use App\Models\Personal\Pais;
use App\Models\Personal\Sexo;
use App\Models\Personal\TipoDocumento;
use App\Models\Vistas\GralVtCompania;
use App\Models\Vistas\VtPersonales;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public $personal;
    // PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombrecompleto, $codigo, $categoria_id, $compania_id, $fecha_juramento, $fecha_de_juramento, $fecha_nacimiento, $estado_id, $documento, $sexo_id, $nacionalidad_id, $ultima_actualizacion, $estado_actualizar_id, $grupo_sanguineo_id;
    #[Validate]
    public $tipo_documento_id;

    // PROPIEDADES PARA LOS SELECT
    public $categorias, $companias, $estados, $sexos, $paises, $estadosActualizar, $gruposSanguineos, $tiposDocumentos = [];

    public function mount(VtPersonales $personal)
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias = GralVtCompania::select('id_compania', 'compania', 'departamento', 'ciudad')->where('id_compania', $personal->compania_id)->orderBy('orden', 'asc')->get();
        $this->estados = Estado::select('idpersonal_estados', 'estado')->get();
        $this->sexos = Sexo::select('idpersonal_sexo', 'sexo')->get();
        $this->paises = Pais::select('idpaises', 'pais')->get();
        $this->estadosActualizar = EstadoActualizar::select('idpersonal_estado_actualizar', 'estado')->get();
        $this->gruposSanguineos = GrupoSanguineo::select('idpersonal_grupo_sanguineo', 'grupo_sanguineo')->get();
        $this->tiposDocumentos = TipoDocumento::select('id_tipo_documento', 'tipo_documento')->get();

        // Cargar datos del personal
        $this->nombrecompleto       = $personal->nombrecompleto;
        $this->codigo               = $personal->codigo;
        $this->categoria_id         = $personal->categoria_id;
        $this->compania_id          = $personal->compania_id;
        $this->fecha_juramento      = $personal->fecha_juramento;
        $this->fecha_de_juramento   = $personal->fecha_de_juramento;
        $this->fecha_nacimiento     = $personal->fecha_nacimiento;
        $this->estado_id            = $personal->estado_id;
        $this->documento            = $personal->documento;
        $this->sexo_id              = $personal->sexo_id;
        $this->nacionalidad_id      = $personal->nacionalidad_id;
        $this->estado_actualizar_id = $personal->estado_actualizar_id;
        $this->grupo_sanguineo_id   = $personal->grupo_sanguineo_id;
        $this->tipo_documento_id    = $personal->tipo_documento_id;
    }

    protected function rules()
    {
        return [
            'nombrecompleto' => ['required', 'string', 'max:255'],
            // 'codigo' => [
            //     'required',
            //     'numeric',
            //     'max_digits:5',
            //     'min_digits:1',
            //     Rule::unique('personal')->where(function ($query) {
            //         return $query->where('categoria_id', $this->categoria_id);
            //     })->ignore($this->personal, 'idpersonal'),
            // ],
            'categoria_id' => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            // 'compania_id' => 'required',
            'fecha_de_juramento' => ['required', 'date'],
            'fecha_juramento' => ['nullable', 'numeric', 'min_digits:4', 'max_digits:4'],
            'fecha_nacimiento' => ['required', 'date'],
            'estado_id' => ['required', Rule::exists(Estado::class, 'idpersonal_estados')],
            'documento' => [
                'required',
                'numeric',
                Rule::unique(Personal::class, 'documento')->ignore($this->personal, 'idpersonal'),
                Rule::when(
                    $this->tipo_documento_id != 1,
                    ['min_digits:6', 'max_digits:15'],
                    ['min_digits:6', 'max_digits:7']
                )
            ],
            'sexo_id' => ['required', Rule::exists(Sexo::class, 'idpersonal_sexo')],
            'nacionalidad_id' => ['required', Rule::exists(Pais::class, 'idpaises')],
            'grupo_sanguineo_id' => ['required', Rule::exists(GrupoSanguineo::class, 'idpersonal_grupo_sanguineo')],
            'tipo_documento_id'  => ['required', Rule::exists(TipoDocumento::class, 'id_tipo_documento')],
        ];
    }

    public function guardar()
    {
        $this->validate();
        $personal = Personal::findOrFail($this->personal)->update([
            'nombrecompleto' => $this->nombrecompleto,
            //'codigo' => $this->codigo,
            'categoria_id' => $this->categoria_id,
            //'compania_id' => $this->compania_id,
            'fecha_juramento' => $this->fecha_de_juramento ? Carbon::parse($this->fecha_de_juramento)->year : null,
            'fecha_de_juramento' => $this->fecha_de_juramento,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'estado_id' => $this->estado_id ?? 1,  // VIGENTE
            'documento' => $this->documento,
            'sexo_id' => $this->sexo_id ?? 3,  // SIN DEFINIR
            'nacionalidad_id' => $this->nacionalidad_id ?? 2,  // VIGENTE
            'ultima_actualizacion' => now(),
            'estado_actualizar_id' => $this->estado_actualizar_id ?? 1, // FALTA ACTUALIZAR
            'grupo_sanguineo_id' => $this->grupo_sanguineo_id ?? 1, // SIN DATOS
            'tipo_documento_id' => $this->tipo_documento_id ?? 1, // CEDULA PARAGUAYA
        ]);

        session()->flash('success', 'Personal Voluntario Registrado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $this->personal]);
    }

    public function render()
    {
        return view('livewire.personal.edit');
    }
}
