<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use App\Models\Personal\Cargo;
use App\Models\Personal\Categoria;
use App\Models\Personal\Comisionamiento;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateAutoridad extends Component
{
    public $personal_id, $categoria_id, $codigo, $info_personal; // Datos del personal
    public $resolucion_id, $anho_id, $origen_id, $info_resolucion; // Datos de la resolucion
    public $cargo_id, $compania_id, $direccion_id, $fecha_inicio; // Datos generales
    public $info_personal_label = 'No encontrado o no seleccionado aún';
    public $info_resolucion_label = 'No encontrado o no seleccionado aún';

    // Variables Para los select
    public $categorias = [], $anhosResolucion = [], $nrosResolucion = [], $origenes = [], $companias = [], $cargos = [], $direcciones = [];

    public function mount()
    {
        $this->categorias      = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias       = CompaniaGral::select('id_compania', 'compania')
            ->whereIn('compania', ['DIRECTORIO', 'COMANDANCIA', 'ANB'])
            ->orderBy('orden', 'asc')->get();
        $this->anhosResolucion = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
        $this->origenes        = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->nrosResolucion  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $this->anho_id]])->get();
        $this->cargos          = Cargo::select('id_cargo', 'cargo', 'codigo_cargo')->whereNotNull('codigo_cargo')->get();
        $this->direcciones     = Direccion::select('id_direccion', 'direccion')->where('compania_id', $this->compania_id)->get();
    }

    protected function rules()
    {
        return [
            'categoria_id'           => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            'codigo'                 => [
                'required',
                'numeric',
                'min_digits:1',
                'max_digits:5',
                function ($attribute, $value, $fail) {
                    if (!VtPersonales::where('categoria_id', $this->categoria_id)
                        ->where('codigo', $value)
                        ->exists()) {
                        $fail('No existe un personal con esa categoría y código.');
                    }
                }
            ],
            'cargo_id'               => ['required', Rule::exists(Cargo::class, 'id_cargo')],
            'direccion_id'           => ['required', Rule::exists(Direccion::class, 'id_direccion')],
            'origen_id'              => ['nullable'],
            'anho_id'                => ['nullable'],
            'resolucion_id'          => ['nullable', Rule::exists(Resolucion::class, 'id')],
            'fecha_inicio'           => ['required', 'date'],
        ];
    }

    // Actualizar propiedad info_personal
    public function updatedCodigo($value)
    {
        $personal = VtPersonales::select('idpersonal', DB::raw("CONCAT(nombrecompleto, ' - ', compania) AS label"))
            ->where([['categoria_id', $this->categoria_id], ['codigo', $value]])
            ->first();

        $this->info_personal = $personal;
        $this->personal_id = $personal->idpersonal ?? null;
        $this->info_personal_label = $personal->label ?? 'No encontrado o no seleccionado aún';
    }

    public function updatedCategoriaId($value)
    {
        $this->updatedCodigo($this->codigo);
    }

    // Actualizar propiedad direcciones filtrando por el campo compania_id
    public function updatedCompaniaId($value)
    {
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->where('compania_id', $this->compania_id)->get();
    }

    // Actualizar propiedad info_resolucion
    public function updatedOrigenId($value)
    {
        $this->nrosResolucion  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $value], ['ano', $this->anho_id]])->get();
    }

    // Actualizar propiedad info_resolucion
    public function updatedAnhoId($value)
    {
        $this->nrosResolucion  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $value]])->get();
    }

    // Actualizar propiedad info_resolucion
    public function updatedResolucionId($value)
    {
        $resolucion = Resolucion::findOrFail($value);

        $this->info_resolucion = $resolucion;
        $this->resolucion_id = $resolucion->id ?? null;
        $this->info_resolucion_label = $resolucion->concepto ?? 'No encontrado o no seleccionado aún';
    }

    public function guardar()
    {
        $this->validate();
        Comisionamiento::create([
            'tipo_id'                => Comisionamiento::TIPO_AUTORIDAD_ELECTA, // Constante definida en el modelo
            'personal_id'            => $this->personal_id,
            'cargo_id'               => $this->cargo_id,
            'compania_id'            => $this->compania_id,
            'direccion_id'           => $this->direccion_id,
            'inicio_resolucion_id'   => $this->resolucion_id ?? null,
            'fecha_inicio'           => $this->fecha_inicio ?? null,
            'culminado'              => 0, // false por defecto
            'creadoPor'              => Auth::id()
        ]);

        session()->flash('success', 'Comisionamiento Registrado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $this->personal_id]);
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.create-autoridad');
    }
}
