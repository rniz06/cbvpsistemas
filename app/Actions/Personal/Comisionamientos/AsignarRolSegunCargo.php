<?php

namespace App\Actions\Personal\Comisionamientos;

use App\Models\Personal;
use App\Models\Personal\Cargo;
use Illuminate\Support\Facades\DB;

class AsignarRolSegunCargo
{
    /**
     * Elimina un registro del modelo Personal..
     */
    public function handle(Personal $personal, int $cargoId): void
    {
        // Cargar cargo con roles
        $cargo = Cargo::with('roles')->find($cargoId);

        if (!$cargo) {
            return;
        }

        // Validar que el personal tenga usuario (Spatie trabaja con user)
        if (!$personal->tableusuario) {
            return;
        }

        // Obtener nombres de roles (Spatie usa name)
        $roles = $cargo->roles->pluck('name')->toArray();

        // Asignar roles
        $personal->tableusuario->syncRoles($roles);
        // o ->assignRole($roles);
    }
}
