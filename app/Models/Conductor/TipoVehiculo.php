<?php

namespace App\Models\Conductor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TipoVehiculo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_conductores_tipo_vehiculo";

    protected $primaryKey = 'idconductor_tipo_vehiculo';

    protected $fillable = ['tipo'];

    /**
     * Relacion uno a muchos con tabla conductores_bomberos
     */
    public function conductores(): HasMany
    {
        return $this->hasMany(ConductorBombero::class);
    }
}
