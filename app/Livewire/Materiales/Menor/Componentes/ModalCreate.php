<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Enums\Materiales\Menor\CategoriaComponente;
use App\Models\Materiales\Menor\Componente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModalCreate extends Component
{
    /*
    |-----------------------------------------------------
    | COMPONENTE MODAL CON FORMULARIO DE ALTA DE COPONENTE
    | SE REALIZA COMO MODAL PARA USARLO EN VARIOS 
    | MODULOS(MAT. MENOR, EQUIPOS FORESTALES, ERAS)
    |-----------------------------------------------------
    */
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $nombre;

    public $routeToRedirect, $categoriaId;

    # FUNCION MOUNT DE LIVEWIRE
    public function mount($routeToRedirect, $categoriaId)
    {
        $this->routeToRedirect = $routeToRedirect ?? 'home';
        $this->categoriaId     = $categoriaId;
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:100', Rule::unique(Componente::class, 'nombre')
                ->where('categoria_id', $this->categoriaId)->withoutTrashed()]
        ];
    }

    # FUNCION PARA GUARDAR UN NUEVO REGISTRO
    public function grabar()
    {
        $this->validate();

        try {
            Componente::create([
                'nombre'       => $this->nombre,
                'categoria_id' => $this->categoriaId,
                'creadoPor'    => Auth::id(),
            ]);
            session()->flash('success', 'COMPONENTE REGISTRADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO REGISTRAR - ' . $e->getMessage());
        }

        $this->redirectRoute($this->routeToRedirect);
    }

    public function render()
    {
        return view('livewire.materiales.menor.componentes.modal-create');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset('nombre');
        $this->resetValidation('nombre');
    }
}
