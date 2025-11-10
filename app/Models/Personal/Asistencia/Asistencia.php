<?php

namespace App\Models\Personal\Asistencia;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Gral\Compania;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Asistencia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "PER_asistencias";

    protected $primaryKey = 'id_asistencia';

    protected $fillable = ['compania_id', 'periodo_id', 'estado_id', 'hubo_citacion'];

    public $timestamps = false;

    protected $casts = [
        'hubo_citacion' => 'boolean',
    ];

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

    /*
    |--------------------------------------------------------------------------
    | FILTROS DE BUSQUEDA
    |--------------------------------------------------------------------------
    */

    /**
     * Busqueda por campo compania_id.
     */
    public function scopeBuscarCompaniaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('compania_id', $search);
        });
    }

    /**
     * Busqueda por relacion periodo campo anho_id.
     */
    public function scopeBuscarAnhoId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->whereHas('periodo', function (Builder $q) use ($search) {
                $q->where('anho_id', $search);
            });
        });
    }

    /**
     * Busqueda por relacion periodo campo mes_id.
     */
    public function scopeBuscarMesId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->whereHas('periodo', function (Builder $q) use ($search) {
                $q->where('mes_id', $search);
            });
        });
    }

    /**
     * Busqueda por campo estado_id.
     */
    public function scopeBuscarEstadoId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('estado_id', $search);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FILTROS DE BUSQUEDA
    |--------------------------------------------------------------------------
    */
}
