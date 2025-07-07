<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Compania;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRoleCompania;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AsignarRol extends Component
{
    public $usuario, $rolesSelect = [], $roles = [], $companias = [], $compania_id = null, $usuarioAuth;

    public function mount(User $usuario)
    {
        $this->usuario = $usuario;
        $this->usuarioAuth = Auth::user()->roles()->pluck('name')->first();
        switch ($this->usuarioAuth) {
            case 'SuperAdmin':
                $this->rolesSelect = Role::pluck('name', 'name')->all();
                $this->roles = $usuario->roles->pluck('name')->toArray();
                break;
            case 'personal_admin':
                $this->rolesSelect = Role::where('name', 'like', 'personal_%')->where('name', '!=', 'SuperAdmin')->pluck('name', 'name')->toArray();
                $this->roles = $usuario->roles()->where('name', 'like', 'personal_%')->pluck('name')->toArray();
                break;
            case 'materiales_admin':
                $this->rolesSelect = Role::where('name', 'like', 'materiales_%')->where('name', '!=', 'SuperAdmin')->pluck('name', 'name')->toArray();
                $this->roles = $usuario->roles()->where('name', 'like', 'materiales_%')->pluck('name')->toArray();
                break;
            default:
                $this->rolesSelect = [];
                break;
        }
        //$this->rolesSelect = Role::pluck('name', 'name')->all();

        $this->companias = Compania::select('idcompanias', 'compania')->orderBy('orden')->get();

        $this->cargarCompaniaSiAplica();
    }

    public function getDebeMostrarSelectCompaniaProperty()
    {
        return collect($this->roles)->contains(fn($rol) => Str::endsWith($rol, '_moderador_por_compania'));
    }

    public function guardar()
    {
        $this->validate([
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
            'compania_id' => ['nullable', Rule::exists(Compania::class, 'idcompanias')]
        ]);

        $user = $this->usuario;

        // Asignar roles con Spatie
        $authUserRole = Auth::user()->roles()->pluck('name')->first();

        if ($authUserRole !== 'SuperAdmin') {
            // Obtener los roles actuales del usuario
            $rolesActuales = $user->roles->pluck('name')->toArray();

            // Unir sin duplicados
            $todosLosRoles = collect($rolesActuales)
                ->merge($this->roles)
                ->unique()
                ->toArray();

            $user->syncRoles($todosLosRoles);
        } else {
            // SuperAdmin puede sobreescribir todos los roles
            $user->syncRoles($this->roles);
        }

        // Actualizar nuestra tabla pivote personalizada
        UserRoleCompania::where('usuario_id', $user->id_usuario)->delete(); // limpieza anterior

        foreach ($this->roles as $rolNombre) {
            $rol = Role::where('name', $rolNombre)->first();
            $data = [
                'usuario_id' => $user->id_usuario,
                'role_id' => $rol->id,
                'compania_id' => Str::endsWith($rolNombre, '_moderador_por_compania') ? $this->compania_id : null,
            ];
            UserRoleCompania::create($data);
        }

        session()->flash('success', 'Roles actualizados correctamente.');
        return redirect()->route('usuarios.asignarrolevista', $user->id_usuario);
    }

    public function render()
    {
        return view('livewire.usuarios.asignar-rol', [
            'companiaAsignada' => $this->compania_id
                ? $this->companias->firstWhere('idcompanias', $this->compania_id)
                : null,
        ]);
    }

    protected function cargarCompaniaSiAplica()
    {
        $asignaciones = UserRoleCompania::where('usuario_id', $this->usuario->id_usuario)->get();

        foreach ($asignaciones as $asignacion) {
            if (Str::endsWith($asignacion->rol->name, '_moderador_por_compania')) {
                $this->compania_id = $asignacion->compania_id;
                break;
            }
        }
    }
}
