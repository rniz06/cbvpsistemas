<?php

namespace App\Livewire\Usuarios;

use Illuminate\Support\Str;
use App\Models\Compania;
use App\Models\Role;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AsignarRol extends Component
{
    public $usuario, $rolesSelect, $roles, $companias, $compania_id;

    public function mount(User $usuario)
    {
        $this->usuario = $usuario;
        $this->rolesSelect = Role::pluck('name', 'name')->all();
        // Obtener roles actuales del usuario (como array de nombres)
        $this->roles = $usuario->roles->pluck('name')->toArray();
        $this->companias = Compania::select('idcompanias', 'compania')->orderBy('orden')->get();

        // Verificar si alguno de los roles tiene compania_id y asignarlo
        foreach ($this->roles as $rolNombre) {
            if (Str::endsWith($rolNombre, '_moderador_por_compania')) {
                $roleId = Role::where('name', $rolNombre)->value('id');

                $compania = DB::table('model_has_roles')
                    ->where('model_id', $usuario->id_usuario)
                    ->where('role_id', $roleId)
                    ->value('compania_id');

                if ($compania) {
                    $this->compania_id = $compania;
                    break; // Tomamos la primera que encontremos (puede ajustarse si necesitás más)
                }
            }
        }
    }

    public function getDebeMostrarSelectCompaniaProperty()
    {
        // Verifica si alguno de los roles contiene '_moderador_por_compania'
        return collect($this->roles)->contains(function ($rol) {
            return Str::endsWith($rol, '_moderador_por_compania');
        });
    }

    public function guardar()
    {
        $validados = $this->validate([
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
            'compania_id' => 'nullable'
        ]);
        //return dd($validados);

        // Sincronizar roles (elimina los que no estén en el array y agrega los nuevos)
        $user = Usuario::findOrFail($this->usuario->id_usuario);
        $user->syncRoles($this->roles);

        // actualizar el campo compania_id para los roles que lo necesiten
        foreach ($this->roles as $rolNombre) {
            if (Str::endsWith($rolNombre, '_moderador_por_compania')) {
                $roleId = Role::where('name', $rolNombre)->value('id');

                DB::table('model_has_roles')
                    ->where('model_id', $user->id_usuario)
                    //->where('model_type', get_class($user))
                    ->where('role_id', $roleId)
                    ->update(['compania_id' => $this->compania_id]);
            }
        }

        session()->flash('success', 'Roles actualizados correctamente.');
        return redirect()->route('usuarios.asignarrolevista', $this->usuario->id_usuario);
    }

    public function render()
    {
        return view('livewire.usuarios.asignar-rol', [
            'companiaAsignada' => Compania::select('idcompanias', 'compania')->where('idcompanias', $this->compania_id)->first()
        ]);
    }
}
