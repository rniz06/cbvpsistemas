<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Apoyo;
use App\Models\Cca\Servicios\Existente;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
use App\Models\Vistas\Materiales\VtMayor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ApoyoAgregar extends Component
{
    // Propiedad recibida desde la ruta
    public $servicio;

    // Propiedades para el select
    public $companias, $moviles;

    // Propiedad del formulario
    #[Validate]
    public $compania_id, $movil_id, $acargo, $acargo_rentado = false, $chofer, $chofer_rentado = false, $cantidad_tripulantes, $despacho_policia = false;

    public function mount($servicio)
    {
        $this->servicio = Existente::findOrFail($servicio, ['id_servicio_existente', 'despacho_policia']);
        $this->companias = CompaniaGral::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->moviles = VtMayor::select('id_movil', 'tipo', 'movil')->where([['compania_id', $this->compania_id], ['operativo', 1]])->orderBy('tipo')->get();
    }

    public function updatedCompaniaId($value)
    {
        $this->moviles = VtMayor::select('id_movil', 'tipo', 'movil')->where([['compania_id', $value], ['operativo', 1]])->orderBy('tipo')->get();
        $this->movil_id = '';
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'compania_id'          => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'movil_id'             => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo'               => [
                Rule::when(
                    $this->acargo_rentado == true,
                    ['nullable'],
                    ['required']
                ),
                'string',
                'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'
            ],
            'chofer'               => [Rule::when(
                $this->chofer_rentado == true,
                ['nullable'],
                ['required']
            ), 'string', 'regex:/^[A-Z]{1,3}?[0-9]{1,5}$|^[0-9]{1,5}$/'],
            'cantidad_tripulantes' => ['required', 'integer', 'min:1', 'min_digits:1', 'max:12', 'max_digits:2'],
            'despacho_policia' => ['required', 'boolean']
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

    public function depacho_por_policia()
    {
        $this->despacho_policia = !$this->despacho_policia;    
    }

    public function guardar()
    {
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
        Apoyo::create([
            'servicio_id'           => $this->servicio->id_servicio_existente,
            'compania_id'           => $this->compania_id,
            'movil_id'              => $this->movil_id,
            'acargo'                => $acargo ?? null,
            'acargo_aux'            => $acargo_aux ?? null,
            'acargo_rentado'        => $this->acargo_rentado ?? null,
            'chofer'                => $chofer ?? null,
            'chofer_aux'            => $chofer_aux ?? null,
            'chofer_rentado'        => $this->chofer_rentado ?? null,
            'cantidad_tripulantes'  => $this->cantidad_tripulantes,
            'despacho_policia'      => $this->servicio->despacho_policia,
            'creadoPor'             => Auth::id(),
        ]);
        $this->dispatch('apoyo-agregado');
        $this->dispatch('cerrar-formulario-apoyo');
    }

    public function render()
    {
        return view('livewire.cca.despacho.apoyo-agregar');
    }
}
