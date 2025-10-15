<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Existente;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\Materiales\VtMayor;
use App\Models\Vistas\VtPersonales;
use App\Services\Cca\Despacho\RegistrarEstadoDeMovilAlDespachar;
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
    public $movil_id, $acargo = '', $acargo_rentado = false, $chofer, $chofer_rentado = false, $cantidad_tripulantes;

    public function mount($servicio)
    {
        $this->servicio = VtExistente::findOrFail($servicio);
        $this->moviles = VtMayor::select('id_movil', 'movil', 'tipo')->where([['compania_id', $this->servicio->compania_id], ['operativo', 1]])->get();
        $this->acargoDetalles = VtPersonales::where('codigo', $this->acargo)->with('contactos')->first();
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'movil_id'             => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo'               => ['nullable', 'string', 'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'chofer'               => ['nullable', 'string', 'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'cantidad_tripulantes' => ['required', 'min_digits:1', 'max_digits:11'],
        ];
    }

    // Personalizar errores de validacion
    public function messages()
    {
        return [
            'acargo.regex' => 'El campo A cargo debe contener de 1 a 3 letras seguidas de 1 a 5 números(Comando de Companias), o solo de 1 a 5 dígitos numéricos(Codigo de bombero).',
            'chofer.regex' => 'El campo Chofer debe contener de 1 a 3 letras seguidas de 1 a 5 números(Comando de Companias), o solo de 1 a 5 dígitos numéricos(Codigo de bombero).',
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

    // Deshabilita el input acargo
    public function btnAcargoRentado()
    {
        $this->acargo_rentado = !$this->acargo_rentado;
        if ($this->acargo_rentado) {
            $this->acargo = null;
        }
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $acargo = null;
        $acargo_aux = null;
        if (!$this->acargo_rentado) {
            if (is_numeric($this->acargo)) {
                $acargo = Personal::where('codigo', $this->acargo)->value('idpersonal');
                if (is_null($acargo)) {
                    $acargo_aux = $this->acargo;
                }
            } else {
                $acargo = Personal::where('codigo_comisionamiento', $this->acargo)->value('idpersonal');
                if (is_null($acargo)) {
                    $acargo_aux = $this->acargo;
                }
            }
        }

        $chofer = null;
        $chofer_aux = null;
        if (!$this->chofer_rentado) {
            if (is_numeric($this->chofer)) {
                $chofer = Personal::where('codigo', $this->chofer)->value('idpersonal');
                if (is_null($chofer)) {
                    $chofer_aux = $this->chofer;
                }
            } else {
                $chofer = Personal::where('codigo_comisionamiento', $this->chofer)->value('idpersonal');
                if (is_null($chofer)) {
                    $chofer_aux = $this->chofer;
                }
            }
        }
        $servicio = Existente::findOrFail($this->servicio->id_servicio_existente)->update([
            'movil_id'             => $this->movil_id,
            'acargo'               => $acargo ?? null,
            'acargo_aux'           => $acargo_aux ?? null,
            'acargo_rentado'       => $this->acargo_rentado,
            'chofer'               => $chofer ?? null,
            'chofer_aux'           => $chofer_aux ?? null,
            'chofer_rentado'       => $this->chofer_rentado,
            'cantidad_tripulantes' => $this->cantidad_tripulantes,
            'fecha_movil'          => now(),
            'estado_id'            => 3, // Estado: Compañia despachada
        ]);

        // Registrar el estado del movil cuando se despacha un servicio
        app(RegistrarEstadoDeMovilAlDespachar::class)->ejecutar($this->servicio->id_servicio_existente, $this->movil_id);

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
