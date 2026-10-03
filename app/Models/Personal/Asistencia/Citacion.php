<?php

namespace App\Models\Personal\Asistencia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Citacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias_citaciones";

    protected $primaryKey = 'id_asistencia_citacion';

    protected $fillable = ['asistencia_id', 'referencia', 'fecha'];

    protected $casts = [
        'fecha' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */
}
