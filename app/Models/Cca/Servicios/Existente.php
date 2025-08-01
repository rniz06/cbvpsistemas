<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Existente extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios_existentes";

    protected $primaryKey = 'id_servicio_existente';

    protected $fillable = [
        'informacion_servicio',
        'calle_referencia',
        'cantidad_tripulantes',
        'compania_id',
        'servicio_id',
        'clasificacion_id',
        'ciudad_id',
        'movil_id',
        'acargo',
        'acargo_aux',
        'chofer',
        'chofer_aux',
        'chofer_rentado',
        'estado_id',
        'km_final',
        'desperfecto',
        'fecha_alfa',
        'fecha_cia',
        'fecha_movil',
        'fecha_servicio',
        'fecha_base',
        'falsa_alarma',
        'creadoPor',
        'actualizadoPor',
    ];

    protected $casts = [
        'chofer_rentado' => 'boolean',
        'desperfecto'    => 'boolean',
    ];
}
