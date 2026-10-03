<?php

namespace App\Livewire\Admin\Roles;

use App\Actions\Admin\Roles\RevocarRolDeUsuarios;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\PermissionRegistrar;

class RemoverEnLote extends Component
{
    # PROPIEDADES DEL FORMULARIO
    #[Validate]
    public $role_id;

    # PROPIEDADES DE LOS SELECTS
    public $roles = [];

    public function mount()
    {
        $this->roles  = Role::get(['id', 'name']);
    }

    protected function rules()
    {
        return [
            'role_id'  => ['required', Rule::exists(Role::class, 'id')],
        ];
    }

    public function guardar(RevocarRolDeUsuarios $revocarRolDeUsuarios)
    {
        $this->validate();

        try {
            $revocarRolDeUsuarios->handle($this->role_id);
            session()->flash('success', 'ROL REMOVIDO DE USUARIOS CORRECTAMENTE!');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO REMOVER LOS USUARIOS DE ESE ROL - ' . $e->getMessage()
            );
        }

        return redirect()->route('roles.remover-en-lote');
    }

    public function render()
    {
        return view('livewire.admin.roles.remover-en-lote');
    }
}
