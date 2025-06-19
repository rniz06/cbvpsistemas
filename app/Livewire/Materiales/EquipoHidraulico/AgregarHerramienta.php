<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Materiales\EquipoHidraulico\Comentario;
use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Marca;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Modelo;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Motor;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use App\Models\Materiales\EquipoHidraulico\Hidraulico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AgregarHerramienta extends Component
{
    public $hidraulico_id;
    public $serie = 0, $marca_id, $modelo_id, $motor_id, $tipo_id;

    // Reglas de validación
    protected function rules()
    {
        return [
            'hidraulico_id' => ['required', Rule::exists(Hidraulico::class, 'id_hidraulico')],
            'serie' => ['required', 'numeric', 'max_digits:11'],
            'marca_id' => ['required', Rule::exists(Marca::class, 'idhidraulico_herr_marca')],
            'modelo_id' => ['required', Rule::exists(Modelo::class, 'idhidraulico_herr_modelo')],
            'motor_id' => ['required', Rule::exists(Motor::class, 'idhidraulico_herr_motor')],
            'tipo_id' => ['required', Rule::exists(Tipo::class, 'idhidraulico_herr_tipo')],
        ];
    }

    public function mount($hidraulico_id)
    {
        $this->hidraulico_id = $hidraulico_id;
    }

    public function guardar()
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
        Comentario::create([
            'hidraulico_id' => $this->hidraulico_id,
            'accion_id' => 3, // REPORTE
            'comentario' => "SE HA AÑADIDO UNA HERRAMIENTA NUEVA",
            'creadoPor' => Auth::id(),
        ]);
        session()->flash('success', 'Herramienta Agregada Exitosamente!');
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
