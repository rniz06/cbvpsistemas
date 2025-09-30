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
use App\Models\Usuario;
use App\Models\Vistas\VtCompania;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombrecompleto, $codigo, $categoria_id, $compania_id, $fecha_juramento, $fecha_de_juramento, $fecha_nacimiento, $estado_id, $documento, $sexo_id, $nacionalidad_id, $ultima_actualizacion, $estado_actualizar_id, $grupo_sanguineo_id;
    #[Validate]
    public $tipo_documento_id;

    // PROPIEDADES PARA LOS SELECT
    public $categorias, $companias, $estados, $sexos, $paises, $estadosActualizar, $gruposSanguineos, $tiposDocumentos = [];

    public function mount()
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias = VtCompania::select('idcompanias', 'compania', 'departamento', 'ciudad')->orderBy('orden', 'asc')->get();
        $this->estados = Estado::select('idpersonal_estados', 'estado')->get();
        $this->sexos = Sexo::select('idpersonal_sexo', 'sexo')->get();
        $this->paises = Pais::select('idpaises', 'pais')->get();
        $this->estadosActualizar = EstadoActualizar::select('idpersonal_estado_actualizar', 'estado')->get();
        $this->gruposSanguineos = GrupoSanguineo::select('idpersonal_grupo_sanguineo', 'grupo_sanguineo')->get();
        $this->tiposDocumentos = TipoDocumento::select('id_tipo_documento', 'tipo_documento')->get();

        // RETORNAR POR DEFECTO CEDULA PARAGUAYA
        $this->tipo_documento_id = TipoDocumento::findOrFail(1)->value('id_tipo_documento');
    }

    protected function rules()
    {
        return [
            'nombrecompleto' => ['required', 'string', 'max:255'],
            'codigo' => [
                'required',
                'numeric',
                'max_digits:5',
                'min_digits:1',
                Rule::unique('personal')->where(function ($query) {
                    return $query->where('categoria_id', $this->categoria_id);
                }),
            ],
            'categoria_id' => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            'compania_id' => 'required',
            'fecha_de_juramento' => ['nullable', 'date'],
            'fecha_juramento' => ['nullable', 'numeric', 'min_digits:4', 'max_digits:4'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'estado_id' => ['nullable', Rule::exists(Estado::class, 'idpersonal_estados')],
            'documento' => [
                'nullable',
                'numeric',
                Rule::unique(Personal::class, 'documento'),
                Rule::when($this->tipo_documento_id != 1, 
                ['min_digits:6', 'max_digits:15'], ['min_digits:6', 'max_digits:7'])
            ],
            'sexo_id' => ['nullable', Rule::exists(Sexo::class, 'idpersonal_sexo')],
            'nacionalidad_id' => ['nullable', Rule::exists(Pais::class, 'idpaises')],
            'grupo_sanguineo_id' => ['nullable', Rule::exists(GrupoSanguineo::class, 'idpersonal_grupo_sanguineo')],
            'tipo_documento_id'  => ['required', Rule::exists(TipoDocumento::class, 'id_tipo_documento')],
        ];
    }

    public function guardar()
    {
        $this->validate();
        $personal = Personal::create([
            'nombrecompleto' => $this->nombrecompleto,
            'codigo' => $this->codigo,
            'categoria_id' => $this->categoria_id,
            'compania_id' => $this->compania_id,
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
        ]);

        Usuario::create([
            'personal_id' => $personal->idpersonal,
            'password' => Hash::make($personal->codigo),
        ]);
        session()->flash('success', 'Personal Voluntario Registrado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $personal->idpersonal]);
    }

    public function render()
    {
        return view('livewire.personal.create');
    }
}
