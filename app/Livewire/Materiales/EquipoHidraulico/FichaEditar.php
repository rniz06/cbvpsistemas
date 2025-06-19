<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Models\Materiales\EquipoHidraulico\Comentario;
use App\Models\Materiales\EquipoHidraulico\Hidraulico;
use App\Models\Materiales\EquipoHidraulico\Marca;
use App\Models\Materiales\EquipoHidraulico\Modelo;
use App\Models\Materiales\EquipoHidraulico\Motor;
use App\Models\Vistas\Materiales\VtHidraulico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FichaEditar extends Component
{
    public $hidraulico_id, $hidraulico;

    #[Validate]
    public $marca_id, $modelo_id, $motor_id, $anho;

    public function mount($hidraulico_id)
    {
        $this->hidraulico_id = $hidraulico_id;
        $this->hidraulico = VtHidraulico::findOrFail($hidraulico_id);

        // Asignar valores a las propiedades públicas
        $this->marca_id = $this->hidraulico->marca_id;
        $this->modelo_id = $this->hidraulico->modelo_id;
        $this->motor_id = $this->hidraulico->motor_id;
        $this->anho = $this->hidraulico->anho;
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'marca_id' => ['required', Rule::exists(Marca::class, 'id_hidraulico_marca')],
            'modelo_id' => ['required', Rule::exists(Modelo::class, 'id_hidraulico_modelo')],
            'motor_id' => ['required', Rule::exists(Motor::class, 'id_hidraulico_motor')],
            'anho' => ['required', 'numeric', 'min_digits:4', 'max_digits:4'],
        ];
    }

    public function actualizar()
    {
        $validados = $this->validate();
        //return dd($validados);
        // Agregar el ID del usuario autenticado al array validado
        $validados['actualizadoPor'] = Auth::id();

        // Obtener los datos actuales del móvil desde una vista en la bd antes de cualquier modificación
        $hidraulicoRegistro = VtHidraulico::findOrFail($this->hidraulico_id);
        // Construir el string con los datos anteriores
        $comentario = "DATOS ANTERIORES: ";
        $comentario .= "MOTOR: " . $hidraulicoRegistro->motor . " - ";
        $comentario .= "MARCA: " . $hidraulicoRegistro->marca . " - ";
        $comentario .= "MODELO: " . $hidraulicoRegistro->modelo . " - ";
        $comentario .= "AÑO: " . $hidraulicoRegistro->anho . " - ";
        //Generar un comentario con los datos anteriores
        Comentario::create([
            'comentario' => $comentario,
            'hidraulico_id' => $hidraulicoRegistro->id_hidraulico,
            'accion_id' => 3, // REPORTE
            'creadoPor' => Auth::id(),
        ]);
        // Actualizar el registro
        $hidraulicoActualizar = Hidraulico::findOrFail($this->hidraulico_id);
        $hidraulicoActualizar->update($validados);
        session()->flash('success', 'Se Actualizo el Equipo Hidraulico Correctamente En El Sistema!');
        return redirect()->route('materiales.hidraulicos.show', $this->hidraulico_id);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.ficha-editar', [
            'hidraulicoRegistro' => $this->hidraulico,
            'marcas' => Marca::select('id_hidraulico_marca', 'marca')->get(),
            'modelos' => Modelo::select('id_hidraulico_modelo', 'modelo')->where('marca_id', $this->marca_id)->get(),
            'motores' => Motor::select('id_hidraulico_motor', 'motor')->get(),
        ]);
    }
}
