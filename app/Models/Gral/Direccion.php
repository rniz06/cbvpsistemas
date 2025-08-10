<?php

namespace App\Models\Gral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Direccion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "GRAL_direcciones";

    protected $primaryKey = 'id_direccion';

    protected $fillable = [
        'direccion',
        'compania_id',
        'creadoPor',
        'actualizadoPor',
    ];
}
