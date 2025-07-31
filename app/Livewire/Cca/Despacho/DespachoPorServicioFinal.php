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
    public $movil_id, $acargo = '', $chofer, $chofer_rentado = false, $cantidad_tripulantes;

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
            'movil_id'             => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo'               => ['required', 'string', 'min:2', 'max:10'],
            'chofer'               => ['nullable', 'numeric', 'min_digits:1', 'max_digits:5'],
            'cantidad_tripulantes' => ['required', 'min_digits:1', 'max_digits:11'],
        ];
    }

    // Deshabilita el input chofer
    public function btnrentado()
    {
        $this->chofer_rentado = !$this->chofer_rentado;
        if ($this->chofer_rentado) {
            $this->chofer = null;
        }
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $acargo = null;
        $acargo_aux = null;
        if (is_numeric($this->acargo)) {
            $acargo = Personal::where('codigo', $this->acargo)->value('idpersonal');
        } else {
            $acargo_aux = Personal::where('codigo_comisionamiento', $this->acargo)->value('idpersonal');
        }
        $chofer = Personal::where('codigo', $this->chofer)->value('idpersonal');
        $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'movil_id'             => $this->movil_id,
            'acargo'               => $acargo ?? null,
            'acargo_aux'           => $acargo_aux ?? null,
            'chofer'               => $chofer ?? null,
            'chofer_rentado'       => $this->chofer_rentado,
            'cantidad_tripulantes' => $this->cantidad_tripulantes,
            'fecha_movil'          => now(),
            'estado_id'            => 3, // Estado: Compañia despachada
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
