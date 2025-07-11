<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CiudadGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorServicio extends Component
{
    // Propiedades para los select
    public $servicios, $clasificaciones, $ciudades;

    // Propiedades para el formulario
    #[Validate]
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia;

    public function mount()
    {
        $this->servicios = Servicio::select('id_servicio', 'servicio')->get();
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->where('servicio_id', $this->servicio_id)->get();
        $this->ciudades = CiudadGral::select('id_ciudad', 'ciudad')->get();
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
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $servicio = Existente::create([
            'informacion_servicio' => $this->informacion_servicio,
            'calle_referencia' => $this->calle_referencia,
            'servicio_id' => $this->servicio_id,
            'clasificacion_id' => $this->clasificacion_id,
            'ciudad_id' => $this->ciudad_id,
            'estado_id' => 1, // Estado: Inicializado
            'creadoPor' => Auth::id()
        ]);
        return redirect()->route('cca.despacho.despacho-por-servicio-add-compania', ['servicio' => $servicio->id_servicio_existente])
            ->with('success', 'Servicio guardado parte uno!');
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

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-servicio');
    }
}
