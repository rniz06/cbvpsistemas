<?php

namespace App\Livewire\Materiales\Conductores;

use App\Models\Gral\Ciudad;
use App\Models\Materiales\Conductor\ClaseLicencia;
use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Materiales\Conductor\Estado;
use App\Models\Materiales\Conductor\TipoVehiculo;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\Materiales\VtConductor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    // REGISTRO
    public $conductor, $resolucion;

    // PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $origen_id, $anho_id, $resolucion_id, $info_resolucion; // RESOLUCION
    #[Validate]
    public $fecha_curso, $ciudad_curso_id, $ciudad_licencia_id, $estado_id;
    #[Validate]
    public $tipo_vehiculo_id, $numero_licencia, $clase_licencia_id;
    #[Validate]
    public $licencia_vencimiento;

    // PROPIEDADES PARA LOS SELECT
    public $estados = [], $origenes = [], $anhos = [], $resoluciones = [], $ciudades = [], $tiposVehiculos = [], $licencias = [];

    public $info_resolucion_label = 'No encontrado o no seleccionado aún';

    public function mount(VtConductor $conductor)
    {
        $this->conductor = $conductor;
        // CARGAR DATOS DEL REGISTRO
        $this->resolucion_id        = $conductor->resolucion_id;
        $this->estado_id            = $conductor->estado_id;
        $this->fecha_curso          = $conductor->fecha_curso?->format('Y-m-d'); // FORMATEO POR QUE ESTA DECLARADO TIPO DATE EN CASTS MODELO
        $this->ciudad_curso_id      = $conductor->ciudad_curso_id;
        $this->ciudad_licencia_id   = $conductor->ciudad_licencia_id;
        $this->tipo_vehiculo_id     = $conductor->tipo_vehiculo_id;
        $this->numero_licencia      = $conductor->numero_licencia;
        $this->clase_licencia_id    = $conductor->clase_licencia_id;
        $this->licencia_vencimiento = $conductor->licencia_vencimiento?->format('Y-m-d'); // FORMATEO POR QUE ESTA DECLARADO TIPO DATE EN CASTS MODELO

        $this->resolucion = Resolucion::select('id','n_resolucion', 'concepto')->find($this->resolucion_id);

        // CARGAR PROPIEDADES PARA LOS SELECT
        $this->origenes       = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->anhos          = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
        $this->resoluciones   = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $this->anho_id]])->get();
        $this->ciudades       = Ciudad::select('id_ciudad', 'ciudad')->orderBy('ciudad')->get();
        $this->tiposVehiculos = TipoVehiculo::select('idconductor_tipo_vehiculo', 'tipo')->get();
        $this->licencias      = ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get();
        $this->estados        = Estado::select('id_conductor_estado', 'estado')->get();
    }

    protected function rules()
    {
        return [
            'estado_id'            => ['required', Rule::exists(Estado::class, 'id_conductor_estado')],
            'fecha_curso'          => ['required', 'date', Rule::date()->beforeOrEqual(today())],
            'ciudad_curso_id'      => ['required', Rule::exists(Ciudad::class, 'id_ciudad')],
            'ciudad_licencia_id'   => ['required', Rule::exists(Ciudad::class, 'id_ciudad')],
            'tipo_vehiculo_id'     => ['required', Rule::exists(TipoVehiculo::class, 'idconductor_tipo_vehiculo')],
            'numero_licencia'      => ['required', 'numeric', 'min_digits:6', 'max_digits:11'],
            'licencia_vencimiento' => ['required', 'date', Rule::date()->after(today()),],
            'clase_licencia_id'    => ['required', Rule::exists(ClaseLicencia::class, 'idconductor_clase_licencia')],
        ];
    }

    public function guardar()
    {
        $this->validate();
        //return dd($x);
        ConductorBombero::findOrFail($this->conductor->id_conductor_bombero)->update([
            'estado_id'            => $this->estado_id, 
            'resolucion_id'        => $this->resolucion_id,
            'fecha_curso'          => $this->fecha_curso,
            'ciudad_curso_id'      => $this->ciudad_curso_id,
            'ciudad_licencia_id'   => $this->ciudad_licencia_id,
            'tipo_vehiculo_id'     => $this->tipo_vehiculo_id,
            'numero_licencia'      => $this->numero_licencia,
            'licencia_vencimiento' => $this->licencia_vencimiento,
            'clase_licencia_id'    => $this->clase_licencia_id,
            //'creadoPor'            => Auth::id(), NO HAY CAMPO ACTUALIZADO POR, SE GUARDA DIRECTO EN LA TABLA audits
        ]);

        session()->flash('success', 'Ficha del Conductor Actualizada Correctamente!');
        $this->redirectRoute('materiales.conductores.index');
    }

    public function render()
    {
        return view('livewire.materiales.conductores.edit');
    }

    /*
    |---------------------------------------
    | LOGICA DE ACTUALIZACION DE PROPIEDADES
    |---------------------------------------
    */

    public function updatedOrigenId($value)
    {
       $this->resoluciones  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $value], ['ano', $this->anho_id]])->get();
    }

    public function updatedAnhoId($value)
    {
        $this->resoluciones  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $value]])->get();
    }

    public function updatedResolucionId($value)
    {
        $resolucion = Resolucion::findOrFail($value);

        $this->info_resolucion = $resolucion;
        $this->resolucion_id = $resolucion->id ?? null;
        $this->info_resolucion_label = $resolucion->concepto ?? 'No encontrado o no seleccionado aún';
    }
}
