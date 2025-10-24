<?php

namespace App\Models\Personal\Asistencia;

use App\Models\Gral\Compania;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Asistencia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias";

    protected $primaryKey = 'id_asistencia';

    protected $fillable = ['compania_id', 'periodo_id', 'estado_id'];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'compania_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function asistenciasDetalles()
    {
        return $this->hasMany(Asistencia::class);    
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */
}
