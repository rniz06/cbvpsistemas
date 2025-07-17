<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Clasificacion extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios_clasificaciones";

    protected $primaryKey = 'id_servicio_clasificacion';

    protected $fillable = ['clasificacion', 'servicio_id'];
    
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id_servicio');
    }
}
