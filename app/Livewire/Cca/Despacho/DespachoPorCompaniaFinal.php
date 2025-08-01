<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CiudadGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
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
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia, $movil_id, $acargo, $chofer, $chofer_rentado = false, $cantidad_tripulantes;

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
            'acargo' => ['required', 'string', 'regex:/^[A-Za-z]{1,2}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'chofer' => ['nullable', 'string', 'regex:/^[A-Za-z]{1,2}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'cantidad_tripulantes' => ['required', 'min_digits:1', 'max_digits:11'],
        ];
    }
    // Personalizar errores de validacion
    public function messages()
    {
        return [
            'acargo.regex' => 'El campo A cargo debe contener de 1 a 2 letras seguidas de 1 a 5 números, o solo de 1 a 5 dígitos numéricos.',
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
        $this->validate();

        $acargo = null;
        $acargo_aux = null;
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

        $servicio = Existente::create([
            'informacion_servicio' => $this->informacion_servicio,
            'calle_referencia' => $this->calle_referencia,
            'cantidad_tripulantes' => $this->cantidad_tripulantes,
            'compania_id' => $this->compania->id_compania,
            'servicio_id' => $this->servicio_id,
            'clasificacion_id' => $this->clasificacion_id,
            'ciudad_id' => $this->ciudad_id,
            'movil_id' => $this->movil_id,
            'acargo' => $acargo ?? null,
            'acargo_aux' => $acargo_aux ?? null,
            'chofer' => $chofer ?? null,
            'chofer_aux' => $chofer_aux ?? null,
            'chofer_rentado' => $this->chofer_rentado ?? null,
            'estado_id' => 3, // Estado: Movil Despachado
            'fecha_cia' => now(),
            'fecha_movil' => now(),
            'creadoPor' => Auth::id()
        ]);
        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $servicio->id_servicio_existente])
            ->with('success', 'Servicio Despachado Correctamente!');
    }

    public function updatedAcargo($value)
    {
        $value = strtoupper($value);
        $this->acargo = $value; // Importante: actualizar la propiedad Livewire
        $this->acargoDetalles = VtPersonales::where('codigo', $value)->with('contactos')->first();
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-compania-final', [
            'acargoDetalles' => VtPersonales::where('codigo', $this->acargo)->first(),
        ]);
    }
}
