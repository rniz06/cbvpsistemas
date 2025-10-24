<?php

namespace App\Models\Personal\Asistencia;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Detalle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias_detalles";

    protected $primaryKey = 'id_asistencia_detalle';

    protected $fillable = ['asistencia_id', 'personal_id', 'practica', 'guardia', 'citacion'];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */
}
