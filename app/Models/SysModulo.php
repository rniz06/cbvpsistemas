<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SysModulo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "sys_modulos";

    protected $primaryKey = 'id_sys_modulo';

    protected $fillable = ['modulo', 'descripcion', 'orden'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'modulo_id');
    }
}
