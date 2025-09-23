<?php

namespace App\Livewire\Materiales\Conductores;

use App\Models\Gral\Ciudad;
use App\Models\Materiales\Conductor\ClaseLicencia;
use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Materiales\Conductor\TipoVehiculo;
use App\Models\Personal;
use App\Models\Personal\Categoria;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $categoria_id, $codigo, $personal_id, $info_personal; // PERSONAL BOMBERO
    #[Validate]
    public $origen_id, $anho_id, $resolucion_id, $info_resolucion; // RESOLUCION
    #[Validate]
    public $fecha_curso, $ciudad_curso_id, $ciudad_licencia_id;
    #[Validate]
    public $tipo_vehiculo_id, $numero_licencia, $clase_licencia_id;
    #[Validate]
    public $licencia_vencimiento;

    // PROPIEDADES PARA LOS SELECT
    public $categorias = [], $origenes = [], $anhos = [], $resoluciones = [], $ciudades = [], $tiposVehiculos = [], $licencias = [];

    // PROPIEDADES DE INFORMACION POR DEFECTO
    public $info_personal_label = 'No encontrado o no seleccionado aún';
    public $info_resolucion_label = 'No encontrado o no seleccionado aún';

    public function mount()
    {
        $this->categorias     = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->origenes       = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->anhos          = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
        $this->resoluciones   = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $this->anho_id]])->get();

        $this->ciudades       = Ciudad::select('id_ciudad', 'ciudad')->orderBy('ciudad')->get();
        $this->tiposVehiculos = TipoVehiculo::select('idconductor_tipo_vehiculo', 'tipo')->get();
        $this->licencias      = ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get();
    }

    protected function rules()
    {
        return [
            'categoria_id'         => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            'codigo'               => ['required', 'numeric', 'min_digits:1', 'max_digits:5', Rule::exists(Personal::class, 'codigo')],
            'origen_id'            => ['required'],
            'anho_id'              => ['required'],
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
        ConductorBombero::create([
            'personal_id'          => $this->personal_id,
            'estado_id'            => 1, // ACTIVO AL MOMENTO DE ALTA
            'resolucion_id'        => $this->resolucion_id,
            'fecha_curso'          => $this->fecha_curso,
            'ciudad_curso_id'      => $this->ciudad_curso_id,
            'ciudad_licencia_id'   => $this->ciudad_licencia_id,
            'tipo_vehiculo_id'     => $this->tipo_vehiculo_id,
            'numero_licencia'      => $this->numero_licencia,
            'licencia_vencimiento' => $this->licencia_vencimiento,
            'clase_licencia_id'    => $this->clase_licencia_id,
            'creadoPor'            => Auth::id(),
        ]);

        session()->flash('success', 'Conductor Registrado Correctamente!');
        $this->redirectRoute('materiales.conductores.index');
    }

    public function render()
    {
        return view('livewire.materiales.conductores.create');
    }

    /*
    |---------------------------------------
    | LOGICA DE ACTUALIZACION DE PROPIEDADES
    |---------------------------------------
    */

    public function updatedCategoriaId()
    {
        $this->updatedCodigo($this->codigo);
    }

    public function updatedCodigo($value)
    {
        $personal = VtPersonales::select('idpersonal', DB::raw("CONCAT(nombrecompleto, ' - ', compania) AS label"))
            ->where([['categoria_id', $this->categoria_id], ['codigo', $value]])
            ->first();

        $this->info_personal = $personal;
        $this->personal_id = $personal->idpersonal ?? null;
        $this->info_personal_label = $personal->label ?? 'No encontrado o no seleccionado aún';
    }

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
