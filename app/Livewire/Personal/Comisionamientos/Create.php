<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Models\Admin\CompaniaGral;
use App\Models\Personal\Categoria;
use App\Models\Personal\Comisionamiento;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // Variables del Formulario
    // Propiedades para el personal
    #[Validate]
    public $personal_id, $categoria_id, $codigo, $info_personal;
    // propiedades del Comisionamiento
    #[Validate]
    public $compania_id, $fecha_inicio, $fecha_fin, $codigo_comisionamiento, $culminado;
    // propiedades de la resolucion
    #[Validate]
    public $origen_id,$anho_id, $resolucion_id, $info_resolucion;
    public $info_personal_label = 'No encontrado o no seleccionado aún';
    public $info_resolucion_label = 'No encontrado o no seleccionado aún';

    // Variables Para los select
    public $categorias = [], $companias = [], $origenes = [], $anhos = [];

    public function mount()
    {
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->companias  = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();
        $this->origenes   = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->anhos      = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
    }

    protected function rules()
    {
        return [
            'categoria_id'           => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            'codigo'                 => ['required', 'numeric', 'min_digits:1', 'max_digits:5'],
            'compania_id'            => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'fecha_inicio'           => ['nullable', 'date'],
            'fecha_fin'              => ['nullable', 'date'],
            'codigo_comisionamiento' => ['nullable', 'string', 'min:1', 'max:5', Rule::unique(Comisionamiento::class)],
            'origen_id'              => ['nullable'],
            // 'nro_resolucion'         => ['nullable', 'string', 'min:9', 'max:9'],
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

    // Actualizar propiedad info_resolucion
    public function updatedNroResolucion($value)
    {
        $resolucion = Resolucion::select('id', 'concepto')
            ->where('fuente_origen_id', $this->origen_id)
            ->where('n_resolucion', $this->nro_resolucion)
            ->first();

        $this->info_resolucion = $resolucion;
        $this->resolucion_id = $resolucion->id ?? null;
        $this->info_resolucion_label = $resolucion->concepto ?? 'No encontrado o no seleccionado aún';
    }

    public function updatedOrigenId($value)
    {
        $this->updatedNroResolucion($this->nro_resolucion);
    }

    public function guardar()
    {
        $this->validate();
        $comisionamiento = Comisionamiento::create([
            'personal_id'            => $this->personal_id,
            'compania_id'            => $this->compania_id,
            'resolucion_id'          => $this->resolucion_id ?? null,
            'fecha_inicio'           => $this->fecha_inicio ?? null,
            'fecha_fin'              => $this->fecha_fin ?? null,
            'codigo_comisionamiento' => $this->codigo_comisionamiento ?? null,
            'culminado'              => 0, // false por defecto
        ]);

        session()->flash('success', 'Comisionamiento Registrado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $this->personal_id]);
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.create');
    }
}
