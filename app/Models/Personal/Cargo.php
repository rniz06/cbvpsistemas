<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Cargo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_cargos";

    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'cargo',
        'codigo_cargo',
        'rango_id',
        'creadoPor',
        'actualizadoPor',
    ];
}
