<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CiudadGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Materiales\Movil\Movil;
use App\Models\Vistas\GralVtCompania;
use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorCompaniaFinal extends Component
{
    public $compania;

    // Propiedades para los select de las vistas
    public $servicios, $clasificaciones, $ciudades, $moviles, $acargoDetalles;

    // Propiedades para el formulario
    #[Validate]
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia, $movil_id, $acargo, $chofer, $cantidad_tripulantes;

    public function mount(GralVtCompania $compania)
    {
        $this->compania = $compania;
        $this->servicios = Servicio::select('id_servicio', 'servicio')->get();
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->where('servicio_id', $this->servicio_id)
            // ->when($this->servicio_id, function ($query) {
            //     $query->where('servicio_id', $this->servicio_id);
            // })
            ->get();
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad')->get();
        $this->moviles = VtMayor::select('id_movil', 'movil', 'tipo')
            ->where([['compania_id', $compania->id_compania], ['operativo', 1]])->get();
        $this->acargoDetalles = VtPersonales::where('codigo', $this->acargo)->first();
    }

    public function updatedServicioId($value)
    {
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->when($value, function ($query) use ($value) {
                return $query->where('servicio_id', $value);
            })
            ->get();
        $this->clasificacion_id = '';
    }

    public function updatedAcargo($value)
    {
        $this->acargoDetalles = VtPersonales::where('codigo', $value)->with('contactos')->first();
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'servicio_id' => ['required', Rule::exists(Servicio::class, 'id_servicio')],
            'clasificacion_id' => ['required', Rule::exists(Clasificacion::class, 'id_servicio_clasificacion')],
            'informacion_servicio' => ['required', 'min:3', 'max:255'],
            'ciudad_id' => ['required', Rule::exists(CiudadGral::class, 'id_ciudad')],
            'calle_referencia' => ['required', 'min:3', 'max:255'],
            'movil_id' => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo' => ['required', 'numeric', 'min_digits:1', 'max_digits:5'],
            'chofer' => ['required', 'min_digits:1', 'max_digits:10'],
            'cantidad_tripulantes' => ['required', 'min_digits:1', 'max_digits:11'],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $servicio = Existente::create([
            'informacion_servicio' => $this->informacion_servicio,
            'calle_referencia' => $this->calle_referencia,
            'cantidad_tripulantes' => $this->cantidad_tripulantes,
            'compania_id' => $this->compania->id_compania,
            'servicio_id' => $this->servicio_id,
            'clasificacion_id' => $this->clasificacion_id,
            'ciudad_id' => $this->ciudad_id,
            'movil_id' => $this->movil_id,
            'acargo' => $this->acargo,
            'chofer' => $this->chofer,
            'estado_id' => 3, // Estado: Movil Despachado
            'fecha_cia' => now(),
            'fecha_movil' => now(),
            'creadoPor' => Auth::id()
        ]);
        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $servicio->id_servicio_existente])
            ->with('success', 'Servicio Despachado Correctamente!');
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-compania-final', [
            'acargoDetalles' => VtPersonales::where('codigo', $this->acargo)->first(),
        ]);
    }
}
