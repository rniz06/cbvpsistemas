<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Enganchado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "CCA_servicios_enganchados";

    protected $primaryKey = 'id_servicio_enganchado';

    protected $fillable = ['servicio_anterior_id', 'servicio_actual_id', 'servicio_padre_id','culminado'];

    protected $casts = [
        'culminado'   => 'boolean',
    ];

    public function anterior()
    {
        return $this->belongsTo(Existente::class, 'servicio_anterior_id', 'id_servicio_existente');
    }

    public function actual()
    {
        return $this->belongsTo(Existente::class, 'servicio_actual_id', 'id_servicio_existente');
    }

    public function padre()
    {
        return $this->belongsTo(Existente::class, 'servicio_padre_id', 'id_servicio_existente');
    }
}
