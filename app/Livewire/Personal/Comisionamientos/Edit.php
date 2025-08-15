<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Models\Admin\CompaniaGral;
use App\Models\Personal\Comisionamiento;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\Personal\VtComisionamiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public $comisionamiento;
    
    // Varibles del formulario
    #[Validate]
    public $compania_id, $fecha_inicio, $fecha_fin , $codigo_comisionamiento, $resolucion_id, $origen_id, $nro_resolucion, $concepto;

    public $companias = [], $origenes = [];

    public function mount($comisionamiento)
    {
        $this->comisionamiento = VtComisionamiento::findOrFail($comisionamiento);

        // Asignar valores a las propiedades públicas
        $this->compania_id            = $this->comisionamiento->compania_id;
        $this->fecha_inicio           = $this->comisionamiento->fecha_inicio?->format('Y-m-d');
        $this->fecha_fin              = $this->comisionamiento->fecha_fin?->format('Y-m-d');
        $this->codigo_comisionamiento = $this->comisionamiento->codigo_comisionamiento;
        $this->resolucion_id          = $this->comisionamiento->resolucion_id;
        $this->origen_id              = $this->comisionamiento->fuente_origen_id;
        $this->nro_resolucion         = $this->comisionamiento->n_resolucion;
        $this->concepto               = $this->comisionamiento->concepto;

        $this->companias  = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();
        $this->origenes   = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
    }

    protected function rules()
    {
        return [
            'compania_id'            => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'fecha_inicio'           => ['nullable', 'date'],
            'fecha_fin'              => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'codigo_comisionamiento' => ['nullable', 'string', 'min:1', 'max:5', Rule::unique(Comisionamiento::class)->ignore($this->comisionamiento->id_comisionamiento, 'id_comisionamiento')],
            'origen_id'              => ['nullable'],
            'nro_resolucion'         => ['nullable', 'string', 'min:9', 'max:9'],
        ];
    }

    // Actualizar propiedad info_resolucion
    public function updatedNroResolucion($value)
    {
        $resolucion = Resolucion::select('id', 'concepto')
            ->where('fuente_origen_id', $this->origen_id)
            ->where('n_resolucion', $this->nro_resolucion)
            ->first();

        $this->concepto = $resolucion->concepto ?? null;
        $this->resolucion_id = $resolucion->id ?? null;
    }

    public function updatedOrigenId($value)
    {
        $this->updatedNroResolucion($this->nro_resolucion);
    }

    public function guardar()
    {
        $this->validate();
        $comisionamiento = Comisionamiento::findOrFail($this->comisionamiento->id_comisionamiento);
        $comisionamiento->update([
            'compania_id'            => $this->compania_id,
            'resolucion_id'          => $this->resolucion_id ?? null,
            'fecha_inicio'           => $this->fecha_inicio ?? null,
            'fecha_fin'              => $this->fecha_fin ?? null,
            'codigo_comisionamiento' => $this->codigo_comisionamiento ?? null,
        ]);

        session()->flash('success', 'Registro de Comisionamiento Actualizado Correctamente!');
        $this->redirectRoute('personal.show', ['personal' => $this->comisionamiento->personal_id]);
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.edit');
    }
}
