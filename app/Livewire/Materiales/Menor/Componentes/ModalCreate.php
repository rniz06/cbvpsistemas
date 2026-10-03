<?php

namespace App\Livewire\Materiales\Menor\Componentes;

use App\Actions\Materiales\Menor\CrearItemEnTodasLasCompanias;
use App\Enums\Materiales\Menor\CategoriaComponente;
use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Categoria;
use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Menor\Tipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $nombre, $tipo_id, $categoria_id;

    # PROPIEDADES PARA LOS SELECTS
    public $tipos = [], $categorias;

    public function mount()
    {
        $this->tipos      = Tipo::orderBy('tipo')->get(['id_menor_tipo', 'tipo']);
        $this->categorias = Categoria::orderBy('nombre')->get(['id_menor_categoria', 'nombre']);
    }

    # REGLAS DE VALIDACION
    protected function rules()
    {
        return [
            'nombre'       => ['required', 'string', 'max:100', Rule::unique(Componente::class, 'nombre')->withoutTrashed()],
            'tipo_id'      => ['required', Rule::exists(Tipo::class, 'id_menor_tipo')],
            'categoria_id' => ['nullable', Rule::exists(Categoria::class, 'id_menor_categoria')]
        ];
    }

    # FUNCION PARA GUARDAR UN NUEVO REGISTRO
    public function guardar(CrearItemEnTodasLasCompanias $action)
    {
        $this->validate();

        try {

            DB::transaction(function () use ($action) {
                $userId = Auth::id();


                $componente = Componente::create([
                    'nombre'       => $this->nombre,
                    'tipo_id'      => $this->tipo_id,
                    'categoria_id' => $this->categoria_id,
                    'creadoPor'    => $userId,
                ]);

                # SI ES UN MENOR, HACER ACCION
                if ($this->tipo_id == TipoMenor::MENOR->value) {
                    $action->handle($componente->id_menor_componente);
                }
            });

            session()->flash('success', 'COMPONENTE REGISTRADO CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash('error', 'NO SE PUDO REGISTRAR' . $e->getMessage());
        }

        $this->redirectRoute('materiales.menor.componentes.index');
    }

    public function render()
    {
        return view('livewire.materiales.menor.componentes.modal-create');
    }

    # FUNCION QUE ESCUCHA BTN CERRAR DEL MODAL Y RESETEA LOS CAMPOS
    public function resetForm()
    {
        $this->reset(['nombre', 'tipo_id', 'categoria_id']);
        $this->resetValidation('nombre');
        $this->resetValidation('tipo_id');
        $this->resetValidation('categoria_id');
    }
}
