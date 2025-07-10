<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Servicio extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios";

    protected $primaryKey = 'id_servicio';

    protected $fillable = ['servicio', 'clasificacion_boolean'];

    public function clasificaciones()
    {
        return $this->hasMany(Clasificacion::class, 'servicio_id', 'id_servicio');
    }
}
