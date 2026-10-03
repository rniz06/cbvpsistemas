<?php

namespace App\Actions\Admin\Roles;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class RevocarRolDeUsuarios
{
    public function handle(int $roleId): void
    {
        # DESASIGNAR TODOS LOS USUARIOS CON ESE ROL
        DB::table('model_has_roles')
            ->where('role_id', $roleId)
            ->delete();

        # RESTABLECER ROLES Y PERMISOS ALMACENADOS EN CACHÉ
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
