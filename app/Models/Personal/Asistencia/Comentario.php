<?php

namespace App\Models\Personal\Asistencia;

use App\Enums\Personal\Asistencias\Accion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comentario extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias_comentarios";

    protected $primaryKey = 'id_asistencia_comentario';

    protected $fillable = ['comentario', 'accion', 'asistencia_id', 'creadoPor', 'actualizadoPor'];

    protected $casts = [
        'accion' => Accion::class,
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

    /*
    |---------------------------------------
    | RELACIONES DE AUDITORIA DE LA TABLA
    |---------------------------------------
    */
    public function creado_por()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizado_por()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }
}
