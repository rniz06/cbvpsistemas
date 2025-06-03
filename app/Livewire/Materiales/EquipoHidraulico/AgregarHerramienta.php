<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Marca;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Modelo;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Motor;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AgregarHerramienta extends Component
{
    public $hidraulico_id;
    public $mostrar = false;
    public $serie, $marca_id, $modelo_id, $motor_id, $tipo_id;

    protected $listeners = ['openFormAgregarHerramienta' => 'open'];

    // Reglas de validación
    protected function rules()
    {
        return [
            'hidraulico_id' => ['required', 'exists:MAT_hidraulicos,id_hidraulico'],
            'serie' => ['required', 'string', 'max:11'],
            'marca_id' => ['required', 'exists:MAT_hidraulicos_herr_marcas,idhidraulico_herr_marca'],
            'modelo_id' => ['required', 'exists:MAT_hidraulicos_herr_modelos,idhidraulico_herr_modelo'],
            'motor_id' => ['required', 'exists:MAT_hidraulicos_herr_motor,idhidraulico_herr_motor'],
            'tipo_id' => ['required', 'exists:MAT_hidraulicos_herr_tipos,idhidraulico_herr_tipo'],
        ];
    }

    public function mount($hidraulico_id)
    {
        $this->hidraulico_id = $hidraulico_id;
    }

    public function open()
    {
        $this->mostrar = true;
        // NO resetees movil_id porque lo necesitas
        $this->reset(['serie', 'marca_id', 'modelo_id', 'motor_id', 'tipo_id']);
        $this->resetValidation();
    }

    public function close()
    {
        $this->mostrar = false;
    }

    public function save()
    {
        $this->validate();
        Herramienta::create([
            'hidraulico_id' => $this->hidraulico_id,
            'serie' => $this->serie,
            'operativo' => 1, // Operativo por defecto
            'marca_id' => $this->marca_id,
            'modelo_id' => $this->modelo_id,
            'motor_id' => $this->motor_id,
            'tipo_id' => $this->tipo_id,
            'operatividad_id' => 1, // Operatividad por defecto 'Operativo'
            'creadoPor' => Auth::id(),
        ]);
        $this->close();
        $this->redirectRoute('materiales.hidraulicos.show', ['hidraulico' => $this->hidraulico_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.agregar-herramienta',[
            'marcas' => Marca::select('idhidraulico_herr_marca', 'marca')->get(),
            'modelos' => Modelo::select('idhidraulico_herr_modelo', 'modelo')->where('marca_id', $this->marca_id ?? 1)->get(),
            'motores' => Motor::select('idhidraulico_herr_motor', 'motor')->get(),
            'tipos' => Tipo::select('idhidraulico_herr_tipo', 'tipo')->get(),
        ]);
    }
}
