<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Existente;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\VtPersonales;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorServicioFinal extends Component
{
    public $servicio;

    public $acargoDetalles;

    // Propiedades para el select
    public $moviles;

    // Propiedades para el formulario
    #[Validate]
    public $movil_id, $acargo = '', $chofer, $cantidad_tripulantes;

    public function mount($servicio)
    {
        $this->servicio = VtExistente::select('id_servicio_existente', 'servicio', 'clasificacion', 'ciudad', 'informacion_servicio', 'calle_referencia', 'compania_id', 'compania')->findOrFail($servicio);
        $this->moviles = VtMayor::select('id_movil', 'movil', 'tipo')->where([['compania_id', $this->servicio->compania_id], ['operativo', 1]])->get();
        $this->acargoDetalles = VtPersonales::where('codigo', $this->acargo)->with('contactos')->first();
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'movil_id' => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo' => ['required', 'numeric', 'min_digits:1', 'max_digits:5', Rule::exists(Personal::class, 'codigo')],
            'chofer' => ['required', 'numeric', 'min_digits:1', 'max_digits:10'],
            'cantidad_tripulantes' => ['required', 'min_digits:1', 'max_digits:11'],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'movil_id' => $this->movil_id,
            'acargo' => $this->acargo,
            'chofer' => $this->chofer,
            'cantidad_tripulantes' => $this->cantidad_tripulantes,
            'fecha_movil' => now(),
            'estado_id' => 3, // Estado: Compañia despachada
        ]);
        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', 'Servicio guardado!');
    }

    public function updatedAcargo($value)
    {
        $this->acargoDetalles = VtPersonales::where('codigo', $value)->with('contactos')->first();
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-servicio-final');
    }
}
