<?php

namespace App\Livewire\Personal\Cargos;

use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use App\Models\Personal\Cargo;
use App\Models\Personal\Rango;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    public $cargo_id;
    #[Validate()]
    public $cargo, $codigo_base, $tipo_codigo, $rango_id, $roles = [];
    public $modo = 'inicio'; // inicio, agregar, modificar, seleccionado

    public $rangos = [], $rolSelect = [];

    protected $listeners = ['cargoSeleccionado' => 'cargarCargo'];

    public function mount()
    {
        $this->rangos    = Rango::select('id_rango', 'rango')->orderBy('rango')->get();
        $this->rolSelect = Role::soloRolesOficiales()->orderBy('name')->get(['id', 'name']);
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
        $this->roles       = DB::table('PER_cargo_rol')->where('cargo_id', $id)->pluck('rol_id');
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
            DB::transaction(function () {
                Cargo::destroy($this->cargo_id);
                DB::table('PER_cargo_rol')->where('cargo_id', $this->cargo_id)->delete();
            });
            
            $this->resetearForm();
            $this->dispatch('cargoActualizado');
        }
    }

    public function grabar()
    {
        $validados = $this->validate();

        if ($this->modo === 'agregar') {
            $validados['creadoPor'] = Auth::id();
            DB::transaction(function () use ($validados) {
                $cargo = Cargo::create($validados);
                $this->asignarRolCargo($cargo->id_cargo);
            });
        } elseif ($this->modo === 'modificar' && $this->cargo_id) {
            $validados['actualizadoPor'] = Auth::id();

            DB::transaction(function () use ($validados) {
                $cargo = Cargo::findOrFail($this->cargo_id);
                $cargo->update($validados);
                $this->asignarRolCargo($cargo->id_cargo);
            });
        }

        $this->resetearForm();
        $this->dispatch('cargoActualizado');
    }

    private function asignarRolCargo(int $cargoId)
    {
        $cargo = Cargo::findOrFail($cargoId);

        $rolesSync = collect($this->roles)->mapWithKeys(function ($rolId) {
            return [
                $rolId => ['creadoPor' => Auth::id()]
            ];
        })->toArray();

        $cargo->roles()->sync($rolesSync);
    }

    // private function asignarRolCargo(int $cargoId)
    // {
    //     if (isset($this->roles)) {
    //         DB::table('PER_cargo_rol')->where('cargo_id', $cargoId)->delete();
    //         foreach ($this->roles as $x) {
    //             DB::table('PER_cargo_rol')->insert([
    //                 'cargo_id' => $cargoId,
    //                 'rol_id' => $x,
    //                 'creadoPor' => Auth::id(),
    //             ]);
    //         }
    //     }
    // }

    private function resetearForm()
    {
        $this->cargo_id    = null;
        $this->cargo       = '';
        $this->codigo_base = '';
        $this->tipo_codigo = '';
        $this->rango_id    = '';
        $this->roles       = [];
        $this->modo        = 'inicio';
    }

    public function render()
    {
        return view('livewire.personal.cargos.form');
    }
}
