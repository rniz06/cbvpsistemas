<?php

namespace App\Models\Personal\Asistencia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Estado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias_estados";

    protected $primaryKey = 'id_asistencia_estado';

    protected $fillable = ['estado'];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Relacion Inversa
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
