<?php

namespace App\Models\Conductor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ClaseLicencia extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "conductores_clase_licencias";

    protected $primaryKey = 'idconductor_clase_licencia';

    protected $fillable = ['clase'];

    /**
     * Relacion uno a muchos con tabla conductores_bomberos
     */
    public function conductores(): HasMany
    {
        return $this->hasMany(ConductorBombero::class);
    }
}
