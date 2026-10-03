<?php

namespace App\Models\Gral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Region extends Model implements Auditable
{
        use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_regiones";

    protected $primaryKey = 'id_region';

    protected $fillable = [
        'region',
    ];

    // Relacion inversa
    public function companias()
    {
        return $this->hasMany(
            Compania::class,
            'region_id',   // FK en GRAL_companias
            'id_region'    // PK de GRAL_regiones
        );
    }
}
