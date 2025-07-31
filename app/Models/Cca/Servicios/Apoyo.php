<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Apoyo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios_existentes_apoyos";

    protected $primaryKey = 'idservicio_existente_apoyo';

    protected $fillable = [
        'cantidad_tripulantes',
        'servicio_id',
        'compania_id',
        'movil_id',
        'acargo',
        'chofer',
        'chofer_rentado',
        'fecha_cia',
        'fecha_movil',
        'fecha_servicio',
        'fecha_base',
        'creadoPor',
        'actualizadoPor',
    ];

    protected $casts = [
        'chofer_rentado'    => 'boolean',
    ];
}
