<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Livewire\Materiales\EquipoHidraulico\Motor as EquipoHidraulicoMotor;
use App\Models\Materiales\EquipoHidraulico\Comentario;
use App\Models\Materiales\EquipoHidraulico\Hidraulico;
use App\Models\Materiales\EquipoHidraulico\Marca;
use App\Models\Materiales\EquipoHidraulico\Modelo;
use App\Models\Materiales\EquipoHidraulico\Motor;
use App\Models\Vistas\Materiales\VtHidraulico;
use App\Models\Vistas\VtCompania;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class VerCompania extends Component
{
    use WithPagination;

    // Recibe le ID de la compania desde la ruta
    public $compania_id;

    // Variables para la paginación
    public $paginadoHidraulicos = 10;

    // Variables para la Formulario
    public $formVisible = false;
    #[Validate]
    public $marca_id, $modelo_id, $motor_id, $anho;

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

    public function guardar()
    {
        $validados = $this->validate();
        // Agregar el ID del usuario autenticado al array validado
        $validados['creadoPor'] = Auth::id();
        $validados['compania_id'] = $this->compania_id;
        $validados['operativo'] = 1;
        $validados['operatividad_id'] = 1;
        // Guardar el registro
        $hidraulico = Hidraulico::create($validados);
        $this->formVisible = false;
        // Generar Comentario por defecto
        Comentario::create([
            'comentario' => 'SE DA DE ALTA EQUIPO HIDRAULICO EN EL SISTEMA',
            'hidraulico_id' => $hidraulico->id_hidraulico,
            'accion_id' => 3, // REPORTE
            'creadoPor' => Auth::id(), // REPORTE
        ]);
        session()->flash('success', 'Se Dio De Alta Equipo Hidraulico Correctamente En El Sistema!');
    }

    // Limpiar la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'paginadoHidraulicos') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.ver-compania', [
            'compania' => VtCompania::select('compania', 'ciudad', 'departamento')->findOrFail($this->compania_id),
            'hidraulicos' => VtHidraulico::select('id_hidraulico', 'marca', 'operatividad', 'compania_id', 'operativo')
                ->where('operativo', 1)
                ->where('compania_id', $this->compania_id)
                ->orderBy('operatividad', 'desc')
                ->orderBy('marca')
                ->paginate($this->paginadoHidraulicos, ['*'], 'hidraulicos_page'),
            // Datos para el formulario de agregar movil
            'marcas' => Marca::select('id_hidraulico_marca', 'marca')->get(),
            'modelos' => Modelo::select('id_hidraulico_modelo', 'modelo')->where('marca_id', $this->marca_id)->get(),
            'motores' => Motor::select('id_hidraulico_motor', 'motor')->get(),
        ]);
    }
}
