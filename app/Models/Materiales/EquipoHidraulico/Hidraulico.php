<?php

namespace App\Models\Materiales\EquipoHidraulico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Hidraulico extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos";

    protected $primaryKey = 'id_hidraulico';

    protected $fillable = [
        'anho',
        'operativo',
        'marca_id',
        'modelo_id',
        'motor_id',
        'compania_id',
        'operatividad_id',
        'creadoPor',
        'actualizadoPor'
    ];
}
