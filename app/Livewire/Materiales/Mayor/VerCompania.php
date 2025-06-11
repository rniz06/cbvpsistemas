<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Materiales\Movil\Acronimo;
use App\Models\Materiales\Movil\Combustible;
use App\Models\Materiales\Movil\Eje;
use App\Models\Materiales\Movil\Marca;
use App\Models\Materiales\Movil\Modelo;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\MovilComentario;
use App\Models\Materiales\Movil\Transmision;
use App\Models\Vistas\Materiales\VtMayor;
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
    public $paginadoMoviles = 10;

    // Variables para la Formulario
    public $formVisible = false;
    #[Validate]
    public $marca_id, $modelo_id, $movil_tipo_id, $movil, $anho, $chasis, $transmision_id, $eje_id, $cubiertas_frente, $cubiertas_atras, $combustible_id, $chapa;

    // Reglas de validación
    protected function rules()
    {
        return [
            'marca_id' => ['required', 'exists:MAT_moviles_marcas,id_movil_marca'],
            'modelo_id' => ['required', 'exists:MAT_moviles_modelos,id_movil_modelo'],
            'movil_tipo_id' => ['required', 'exists:MAT_moviles_tipos,id_movil_tipo'],
            'movil' => ['required', 'min:2', 'max:5'],
            'anho' => ['required', 'numeric', 'min_digits:4', 'max_digits:4'],
            'chasis' => ['required', Rule::unique(Movil::class, 'chasis')],
            'transmision_id' => ['required', 'exists:MAT_moviles_transmision,id_movil_transmision'],
            'eje_id' => ['required', 'exists:MAT_moviles_ejes,id_movil_eje'],
            'cubiertas_frente' => ['required', 'max:15'],
            'cubiertas_atras' => ['required', 'max:15'],
            'combustible_id' => ['required', 'exists:MAT_moviles_combustibles,id_movil_combustible'],
            'chapa' => ['required', Rule::unique(Movil::class, 'chapa')],
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
        $movil = Movil::create($validados);
        $this->formVisible = false;
        // Generar Comentario por defecto
        MovilComentario::create([
            'comentario' => 'SE DA DE ALTA MATERIAL MAYOR EN EL SISTEMA',
            'movil_id' => $movil->id_movil,
            'accion_id' => 3, // REPORTE
            'creadoPor' => Auth::id(), // REPORTE
        ]);
        session()->flash('success', 'Se Dio De Alta Material Mayor Correctamente En El Sistema!');
    }

    // Limpiar la paginación al cambiar de pagina
    public function updating($key): void
    {
        if ($key === 'paginadoMoviles') {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.materiales.mayor.ver-compania', [
            'compania' => VtCompania::select('compania', 'ciudad', 'departamento')->findOrFail($this->compania_id),
            'moviles' => VtMayor::select('id_movil', 'movil', 'tipo', 'operatividad', 'marca', 'compania_id', 'operativo')
                ->where('operativo', 1)
                ->where('compania_id', $this->compania_id)
                ->orderBy('operatividad', 'desc')
                ->orderBy('tipo')
                ->orderBy('movil')
                ->paginate($this->paginadoMoviles, ['*'], 'moviles_page'),
            // Datos para el formulario de agregar movil
            'marcas' => Marca::select('id_movil_marca', 'marca')->get(),
            'modelos' => Modelo::select('id_movil_modelo', 'modelo')->where('marca_id', $this->marca_id)->get(),
            'tipos' => Acronimo::select('id_movil_tipo', 'tipo', 'activo')->where('activo', 1)->get(),
            'transmisiones' => Transmision::select('id_movil_transmision', 'transmision', 'activo')->where('activo', 1)->get(),
            'ejes' => Eje::select('id_movil_eje', 'eje', 'activo')->where('activo', 1)->get(),
            'combustibles' => Combustible::select('id_movil_combustible', 'tipo', 'activo')->where('activo', 1)->get()
        ]);
    }
}
