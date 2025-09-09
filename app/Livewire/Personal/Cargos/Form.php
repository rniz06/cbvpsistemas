<?php

namespace App\Livewire\Personal\Cargos;

use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use App\Models\Personal\Cargo;
use App\Models\Personal\Rango;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    public $cargo_id;
    #[Validate()]
    public $cargo, $codigo_base, $tipo_codigo, $rango_id;
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado

    public $rangos = [];

    protected $listeners = ['cargoSeleccionado' => 'cargarCargo'];

    public function mount()
    {
        $this->rangos = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
    }

    protected function rules()
    {
        return [
            'cargo'       => ['required', Rule::unique(Cargo::class)->ignore($this->cargo_id, 'id_cargo'), 'max:45'],
            'codigo_base' => [
                'nullable',
                'max:15',
                Rule::unique(Cargo::class, 'codigo_base')->ignore($this->cargo_id, 'id_cargo'),
            ],
            'tipo_codigo' => ['required', Rule::enum(TipoCodigo::class)],
            'rango_id'    => ['required', Rule::exists(Rango::class, 'id_rango')],
        ];
    }

    public function agregar()
    {
        $this->resetearForm();
        $this->modo = 'agregar';
    }

    public function cargarCargo($id)
    {
        $cargo = Cargo::findOrFail($id);

        $this->cargo_id    = $cargo->id_cargo;
        $this->cargo       = $cargo->cargo;
        $this->codigo_base = $cargo->codigo_base;
        $this->tipo_codigo = $cargo->tipo_codigo;
        $this->rango_id    = $cargo->rango_id;
        $this->modo        = 'seleccionado';
    }

    public function editar()
    {
        $this->modo = 'modificar';
    }

    public function cancelar()
    {
        $this->resetearForm();
    }

    public function eliminar()
    {
        if ($this->cargo_id) {
            Cargo::destroy($this->cargo_id);
            $this->resetearForm();
            $this->dispatch('cargoActualizado');
        }
    }

    public function grabar()
    {
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            $validados['creadoPor'] = Auth::id();
            Cargo::create($validados);
        } elseif ($this->modo === 'modificar' && $this->cargo_id) {
            $validados['actualizadoPor'] = Auth::id();
            Cargo::findOrFail($this->cargo_id)->update($validados);
        }

        $this->resetearForm();
        $this->dispatch('cargoActualizado');
    }

    private function resetearForm()
    {
        $this->cargo_id    = null;
        $this->cargo       = '';
        $this->codigo_base = '';
        $this->tipo_codigo = '';
        $this->rango_id    = '';
        $this->modo        = 'inicio';
    }

    public function render()
    {
        return view('livewire.personal.cargos.form');
    }
}
