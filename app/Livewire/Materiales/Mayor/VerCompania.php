<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Acronimo;
use App\Models\Materiales\Movil\Combustible;
use App\Models\Materiales\Movil\Eje;
use App\Models\Materiales\Movil\Marca;
use App\Models\Materiales\Movil\Modelo;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\MovilComentario;
use App\Models\Materiales\Movil\Transmision;
use App\Models\Vistas\Materiales\VtMayor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class VerCompania extends Component
{
    use WithPagination;

    // Recibe le ID de la compania desde la ruta
    public $compania;

    // Variables para la paginación
    public $paginadoMoviles = 10;

    // Variables para la Formulario
    public $formVisible = false;
    #[Validate]
    public $marca_id, $modelo_id, $movil_tipo_id, $movil, $anho, $chasis, $transmision_id, $eje_id, $cubiertas_frente, $cubiertas_atras, $combustible_id, $chapa;

    public $marcas = [], $modelos = [], $tipos = [], $transmisiones = [], $ejes = [], $combustibles = [];

    public function mount($compania_id)
    {
        $this->compania = Compania::select('id_compania', 'compania', 'ciudad_id')
            ->with(['ciudad:id_ciudad,ciudad', 'ciudad.departamento:id_departamento,departamento'])
            ->findOrFail($compania_id);

            // Datos para el formulario de agregar movil
            $this->marcas        = Marca::select('id_movil_marca', 'marca')->get();
            $this->tipos         = Acronimo::select('id_movil_tipo', 'tipo', 'activo')->where('activo', 1)->get();
            $this->transmisiones = Transmision::select('id_movil_transmision', 'transmision', 'activo')->where('activo', 1)->get();
            $this->ejes          = Eje::select('id_movil_eje', 'eje', 'activo')->where('activo', 1)->get();
            $this->combustibles  = Combustible::select('id_movil_combustible', 'tipo', 'activo')->where('activo', 1)->get();
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'marca_id' => ['required', 'exists:MAT_moviles_marcas,id_movil_marca'],
            'modelo_id' => ['required', 'exists:MAT_moviles_modelos,id_movil_modelo'],
            'movil_tipo_id' => ['required', 'exists:MAT_moviles_tipos,id_movil_tipo'],
            'movil' => ['required', 'min:2', 'max:5'],
            'anho' => ['required', 'numeric', 'min_digits:4', 'max_digits:4'],
            'transmision_id' => ['required', 'exists:MAT_moviles_transmision,id_movil_transmision'],
            'eje_id' => ['required', 'exists:MAT_moviles_ejes,id_movil_eje'],
            'cubiertas_frente' => ['required', 'max:15'],
            'cubiertas_atras' => ['required', 'max:15'],
            'combustible_id' => ['required', 'exists:MAT_moviles_combustibles,id_movil_combustible'],
            'chasis' => [
                'required',
                Rule::unique(Movil::class, 'chasis')
                    ->where(function ($query) {
                        $query->where('chasis', '!=', 'SIN DATOS');
                    }),
            ],
            'chapa' => [
                'required',
                Rule::unique(Movil::class, 'chasis')
                    ->where(function ($query) {
                        $query->where('chasis', '!=', 'SIN DATOS');
                    }),
            ],
        ];
    }

    public function guardar()
    {
        $validados = $this->validate();
        // Agregar el ID del usuario autenticado al array validado
        $validados['creadoPor'] = Auth::id();
        $validados['compania_id'] = $this->compania->id_compania;
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
        $this->reset(['marca_id', 'modelo_id', 'movil_tipo_id', 'movil', 'anho', 'chasis', 'transmision_id', 'eje_id', 'cubiertas_frente', 'cubiertas_atras', 'combustible_id', 'chapa']);
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
            'moviles' => VtMayor::select('id_movil', 'movil', 'tipo', 'operatividad', 'marca', 'compania_id', 'operativo')
                ->where('operativo', 1)
                ->where('compania_id', $this->compania->id_compania)
                ->orderBy('operatividad', 'desc')
                ->orderBy('tipo')
                ->orderBy('movil')
                ->paginate($this->paginadoMoviles, ['*'], 'moviles_page')
        ]);
    }

    public function updatedMarcaId($value)
    {
        $this->modelos = Modelo::select('id_movil_modelo', 'modelo')->where('marca_id', $this->marca_id)->get();
    }
}
