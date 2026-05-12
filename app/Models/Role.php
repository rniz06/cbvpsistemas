<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    //

    public function scopeSoloRolesOficiales(Builder $query): void
    {
        $query->whereIn('name', [
            'personal_admin',
            'personal_semi_admin',
            'personal_moderador_compania',
            'personal_moderador_por_compania',
            'materiales_admin',
            'materiales_semi_admin',
            'materiales_moderador_compania',
            'materiales_moderador_por_compania',
        ]);
    }
}
