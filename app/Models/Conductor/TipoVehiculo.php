<?php

namespace App\Models\Conductor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoVehiculo extends Model
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "conductores_tipo_vehiculo";

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
