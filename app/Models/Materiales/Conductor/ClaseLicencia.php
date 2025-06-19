<?php

namespace App\Models\Materiales\Conductor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ClaseLicencia extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_conductores_clase_licencias";

    protected $primaryKey = 'idconductor_clase_licencia';

    protected $fillable = ['clase'];

    /**
     * Relacion uno a muchos con tabla conductores_bomberos
     */
    public function conductores(): HasMany
    {
        return $this->hasMany(
            ConductorBombero::class,            // Modelo relacionado
            'clase_licencia_id',                // FK en conductores_bomberos
            'idconductor_clase_licencia'        // PK en conductores_clase_licencias
        );
    }
}
