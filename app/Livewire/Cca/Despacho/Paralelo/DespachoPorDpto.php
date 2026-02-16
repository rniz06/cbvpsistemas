<?php

namespace App\Livewire\Cca\Despacho\Paralelo;

use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Gral\Ciudad;
use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Movil;
use App\Models\UserRoleCompania;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorDpto extends Component
{
    /*
    |--------------------------------------------------------------------------
    | FUNCION DEL COMPONENTE
    |--------------------------------------------------------------------------
    */

    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $compania_id, $calle_referencia;
    #[Validate]
    public $movil_id, $chofer, $chofer_rentado = false, $acargo, $acargo_rentado = false, $cantidad_tripulantes, $fecha_alfa, $fecha_cia;
    #[Validate]
    public $fecha_movil, $fecha_servicio, $fecha_base, $km_final, $desperfecto = false;

    # PROPIEDADES DE LOS SELECTS
    public $servicios = [], $clasificaciones = [], $ciudades = [], $companias = [], $moviles = [];

    public $usuario;

    # FUNCION MOUNT (CONSTRUCTOR) DE LIVEWIRE
    public function mount()
    {
        $this->usuario = Auth::user();

        // Verificar si el usuario tiene el rol específico en una sola consulta
        $tieneRolDepartamental = $this->usuario->roles()
            ->where('name', 'cca_operador_por_dpto')
            ->exists();

        if ($tieneRolDepartamental) {
            $this->cargarDatosFiltradosPorDepartamento();
        } else {
            $this->cargarDatosSinFiltros();
        }

        $this->servicios        = Servicio::get(['id_servicio', 'servicio']);

        // $this->moviles          = Ciudad::get(['id_ciudad', 'ciudad']);
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'servicio_id'           => ['required', 'integer', Rule::exists(Servicio::class, 'id_servicio')],
            'clasificacion_id'      => ['required', 'integer', Rule::exists(Clasificacion::class, 'id_clasificacion')],
            'informacion_servicio'  => ['required', 'string', 'min:2', 'max:255'],
            'ciudad_id'             => ['required', 'integer', Rule::exists(Ciudad::class, 'id_ciudad')],
            'compania_id'           => ['required', 'integer', Rule::exists(Compania::class, 'id_compania')],
            'calle_referencia'      => ['required', 'string', 'min:3', 'max:255'],
            'movil_id'              => ['required', 'integer', Rule::exists(Movil::class, 'id_movil')],
            'chofer'                => ['nullable', 'string', 'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'acargo'                => ['nullable', 'string', 'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'cantidad_tripulantes'  => ['required', 'min_digits:1', 'max_digits:11'],
            'fecha_alfa'            => ['required', 'date'],
            'fecha_cia'             => ['required', 'date'],
            'fecha_movil'           => ['required', 'date'],
            'fecha_servicio'        => ['required', 'date'],
            'fecha_base'            => ['required', 'date'],
            'km_final'              => $this->desperfecto ? 'nullable' : 'required|numeric|min_digits:1|max_digits:11',
        ];
    }

    public function guardar()
    {
        # VALIDAR LOS DATOS DEL FORMULARIO
        $this->validate();

        try {
            # DAR DE ALTA EL SERVICIO
            Existente::create([
                'informacion_servicio' => $this->informacion_servicio ?? null,
                'calle_referencia'     => $this->calle_referencia ?? null,
                'cantidad_tripulantes' => $this->cantidad_tripulantes ?? 0,
                'compania_id'          => $this->compania_id ?? null,
                'servicio_id'          => $this->servicio_id ?? null,
                'clasificacion_id'     => $this->clasificacion_id ?? null,
                'ciudad_id'            => $this->ciudad_id ?? null,
                'movil_id'             => $this->movil_id ?? null,
                'acargo'               => 'veremos',
                'acargo_aux'           => 'veremos',
                'acargo_rentado'       => $this->acargo_rentado ?? null,
                'chofer'               => 'veremos',
                'chofer_aux'           => 'veremos',
                'chofer_rentado'       => $this->chofer_rentado ?? null,
                'estado_id'            => 4, # Servicio Culminado
                'km_final'             => $this->km_final ?? null,
                'desperfecto'          => $this->desperfecto ?? null,
                'fecha_alfa'           => $this->fecha_alfa ?? null,
                'fecha_cia'            => $this->fecha_cia ?? null,
                'fecha_movil'          => $this->fecha_movil ?? null,
                'fecha_servicio'       => $this->fecha_servicio ?? null,
                'fecha_base'           => $this->fecha_base ?? null,
                'falsa_alarma'         => false, # FALSA ALARMA POR DEFECTO
                'despacho_policia'     => false, # NO ES DESPACHO DESDE 911
                'creadoPor'            => Auth::id()
            ]);

            session()->flash('success', 'SERVICIO CREADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO CREAR EL SERVICIO - ' . $e->getMessage()
            );
        }

        return redirect()->route('admin.companias.index');
    }

    public function render()
    {
        return view('livewire.cca.despacho.paralelo.despacho-por-dpto');
    }

    /*
    |--------------------------------------------------------------------------
    | OTROS METODOS Y FUNCIONES DEL COMPONENTE
    |--------------------------------------------------------------------------
    */
    private function cargarDatosSinFiltros()
    {
        $this->ciudades  = Ciudad::get(['id_ciudad', 'ciudad']);
        $this->companias = Compania::get(['id_compania', 'compania']);
    }

    private function cargarDatosFiltradosPorDepartamento()
    {
        # OBTENER departamento_id CON MANEJO DE CASO null
        $departamento_id = UserRoleCompania::where('usuario_id', $this->usuario->id_usuario)
            ->whereNotNull('departamento_id')
            ->value('departamento_id');

        // Si no hay departamento_id, cargar sin filtro
        if (!$departamento_id) {
            $this->cargarDatosSinFiltro();
            return;
        }

        // Cargar datos filtrados
        $this->ciudades = Ciudad::where('departamento_id', $departamento_id)
            ->get(['id_ciudad', 'ciudad']);

        $this->companias = Compania::whereRelation('ciudad', 'departamento_id', $departamento_id)
            ->orderBy('orden')
            ->get(['id_compania', 'compania']);
    }

    public function updatedServicioId($value)
    {
        $this->clasificaciones  = Clasificacion::where('servicio_id', $value)->get(['id_servicio_clasificacion', 'clasificacion']);
    }

    public function updatedCompaniaId($value)
    {
        $this->moviles  = Movil::where([['compania_id', $value], ['operativo', 1]])->select('id_movil', 'movil', 'movil_tipo_id')
            ->with('acronimo:id_movil_tipo,tipo')->get();
    }

    public function btnChoferRentado()
    {
        # 
    }
}
