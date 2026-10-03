<?php

namespace App\Models\Personal\Asistencia;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Detalle extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias_detalles";

    protected $primaryKey = 'id_asistencia_detalle';

    protected $fillable = ['asistencia_id', 'personal_id', 'practica', 'guardia', 'citacion', 'total'];

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
        return $this->belongsTo(Personal::class, 'personal_id')->orderBy('codigo');
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | FILTROS DE BUSQUEDA
    |--------------------------------------------------------------------------
    */

    /**
     * Busqueda por relacion personal campo nombrecompleto.
     */
    public function scopeBuscarNombrecompleto(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->whereHas('personal', function (Builder $q) use ($search) {
                $q->whereLike('nombrecompleto', "%$search%");
            });
        });
    }

    /**
     * Busqueda por relacion personal campo codigo.
     */
    public function scopeBuscarCodigo(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->whereHas('personal', function (Builder $q) use ($search) {
                $q->whereLike('codigo', "%$search%");
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FIN FILTROS DE BUSQUEDA
    |--------------------------------------------------------------------------
    */
}
