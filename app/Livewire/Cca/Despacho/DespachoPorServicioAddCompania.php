<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Existente;
use App\Models\Vistas\Cca\VtExistente;
use App\Models\Vistas\GralVtCompania;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoPorServicioAddCompania extends Component
{

    // Propiedades para asignar el parametro recibido
    public $servicio;

    // Propiedades para el select
    #[Validate]
    public $companias;

    // Propiedades para el formulario
    #[Validate]
    public $compania_id;

    public function mount($servicio)
    {
        $this->servicio = VtExistente::select('id_servicio_existente', 'servicio' , 'clasificacion', 'ciudad', 'informacion_servicio', 'calle_referencia')->findOrFail($servicio);
        $this->companias = GralVtCompania::select('id_compania', 'compania', 'departamento', 'ciudad')->orderBy('orden')->get();
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'compania_id' => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
        ];
    }

    public function grabar()
    {
        // Validar los datos
        $this->validate();
        $servicio = Existente::where('id_servicio_existente', $this->servicio->id_servicio_existente)->update([
            'compania_id' => $this->compania_id,
            'fecha_cia' => now(),
            'estado_id' => 2, // Estado: Inicializado
        ]);
        return redirect()->route('cca.despacho.despacho-por-servicio-final', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', 'Servicio Despachado Con Movil Correctamente!');
    }

    public function render()
    {
        return view('livewire.cca.despacho.despacho-por-servicio-add-compania');
    }
}
