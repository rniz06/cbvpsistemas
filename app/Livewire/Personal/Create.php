<?php

namespace App\Livewire\Personal;

use App\Models\Personal;
use App\Models\Personal\Categoria;
use App\Models\Personal\Estado;
use App\Models\Personal\EstadoActualizar;
use App\Models\Personal\GrupoSanguineo;
use App\Models\Personal\Pais;
use App\Models\Personal\Sexo;
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
    #[Validate]
    public $nombrecompleto, $codigo, $categoria_id, $compania_id, $fecha_juramento, $fecha_de_juramento, $estado_id, $documento, $sexo_id, $nacionalidad_id, $ultima_actualizacion, $estado_actualizar_id, $grupo_sanguineo_id;

    public $categorias, $companias, $estados, $sexos, $paises, $estadosActualizar, $gruposSanguineos;

    public function mount()
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias = VtCompania::select('idcompanias', 'compania', 'departamento', 'ciudad')->orderBy('orden', 'asc')->get();
        $this->estados = Estado::select('idpersonal_estados', 'estado')->get();
        $this->sexos = Sexo::select('idpersonal_sexo', 'sexo')->get();
        $this->paises = Pais::select('idpaises', 'pais')->get();
        $this->estadosActualizar = EstadoActualizar::select('idpersonal_estado_actualizar', 'estado')->get();
        $this->gruposSanguineos = GrupoSanguineo::select('idpersonal_grupo_sanguineo', 'grupo_sanguineo')->get();
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
            'estado_id' => ['nullable', Rule::exists(Estado::class, 'idpersonal_estados')],
            'documento' => ['nullable', 'numeric', 'min_digits:6', 'max_digits:7', Rule::unique(Personal::class, 'documento')],
            'sexo_id' => ['nullable', Rule::exists(Sexo::class, 'idpersonal_sexo')],
            'nacionalidad_id' => ['nullable', Rule::exists(Pais::class, 'idpaises')],
            'grupo_sanguineo_id' => ['nullable', Rule::exists(GrupoSanguineo::class, 'idpersonal_grupo_sanguineo')],
        ];
    }

    public function guardar()
    {
        $personal = Personal::create([
            'nombrecompleto' => $this->nombrecompleto,
            'codigo' => $this->codigo,
            'categoria_id' => $this->categoria_id,
            'compania_id' => $this->compania_id,
            'fecha_juramento' => Carbon::parse($this->fecha_de_juramento)->year,
            'fecha_de_juramento' => $this->fecha_de_juramento,
            'estado_id' => $this->estado_id,
            'documento' => $this->documento,
            'sexo_id' => $this->sexo_id,
            'nacionalidad_id' => $this->nacionalidad_id,
            'ultima_actualizacion' => now(),
            'estado_actualizar_id' => $this->estado_actualizar_id,
            'grupo_sanguineo_id' => $this->grupo_sanguineo_id,
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
