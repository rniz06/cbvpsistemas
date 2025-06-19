<?php

namespace App\Models\Materiales\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Movil extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_moviles";

    protected $primaryKey = 'id_movil';

    protected $fillable = [
        'movil',
        'chasis',
        'detalles',
        'operativo',
        'anho',
        'cubiertas_frente',
        'cubiertas_atras',
        'chapa',
        'movil_tipo_id',
        'marca_id',
        'modelo_id',
        'transmision_id',
        'eje_id',
        'combustible_id',
        'operatividad_id',
        'compania_id',
        'creadoPor',
        'actualizadoPor'
    ];
}
