<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SysSubModulo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "sys_sub_modulos";

    protected $primaryKey = 'id_sub_modulo';

    protected $fillable = ['sub_modulo', 'modulo_id'];

    public function modulo()
    {
        return $this->belongsTo(SysModulo::class, 'modulo_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'sub_modulo_id');
    }
}
