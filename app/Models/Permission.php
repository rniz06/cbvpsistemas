<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    public function modulo()
    {
        return $this->belongsTo(SysModulo::class, 'modulo_id');
    }

    public function subModulo()
{
    return $this->belongsTo(SysSubModulo::class, 'sub_modulo_id');
}
}
