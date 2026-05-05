<?php

namespace App\Models\Gral;

use App\Models\Materiales\Movil\Movil;
use App\Models\Personal\Asistencia\Asistencia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Compania extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "GRAL_companias";

    protected $primaryKey = 'id_compania';

    protected $fillable = [
        'compania',
        'ciudad_id',
        'region_id',
        'orden',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function moviles()
    {
        return $this->hasMany(Movil::class, 'modelo_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);    
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */
}
