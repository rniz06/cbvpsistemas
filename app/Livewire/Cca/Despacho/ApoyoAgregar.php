<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Apoyo;
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
    public $compania_id, $movil_id, $acargo, $chofer, $chofer_rentado = false, $cantidad_tripulantes;

    public function mount($servicio)
    {
        $this->servicio = $servicio;
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
            'compania_id' => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'movil_id' => ['required', Rule::exists(Movil::class, 'id_movil')],
            'acargo' => ['required', 'numeric', 'min_digits:1', 'max_digits:5'],
            'chofer' => ['nullable', 'numeric', 'min_digits:1', 'max_digits:5'],
            'cantidad_tripulantes' => ['required', 'integer', 'min:1', 'min_digits:1', 'max:12', 'max_digits:2'],
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



    public function guardar()
    {
        $this->validate();
        $acargo = Personal::where('codigo', $this->acargo)->value('idpersonal');
        $chofer = Personal::where('codigo', $this->chofer)->value('idpersonal');
        Apoyo::create([
            'servicio_id'           => $this->servicio,
            'compania_id'           => $this->compania_id,
            'movil_id'              => $this->movil_id,
            'acargo'                => $acargo ?? null,
            'chofer'                => $chofer ?? null,
            'chofer_rentado'        => $this->chofer_rentado ?? null,
            'cantidad_tripulantes'  => $this->cantidad_tripulantes,
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
