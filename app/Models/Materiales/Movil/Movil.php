<?php

namespace App\Models\Materiales\Movil;

use App\Models\Gral\Compania;
use App\Models\Materiales\Operatividad;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Movil extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_moviles";

    protected $primaryKey = 'id_movil';

    protected $fillable = [
        'movil',
        'chasis',
        'detalles',
        'operativo',
        'anho',
        'cubiertas_frente',
        'cubiertas_atras',
        'chapa',
        'movil_tipo_id',
        'marca_id',
        'modelo_id',
        'transmision_id',
        'eje_id',
        'combustible_id',
        'operatividad_id',
        'compania_id',
        'creadoPor',
        'actualizadoPor'
    ];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function acronimo()
    {
        return $this->belongsTo(Acronimo::class, 'movil_tipo_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }

    public function transmision()
    {
        return $this->belongsTo(Transmision::class, 'transmision_id');
    }

    public function eje()
    {
        return $this->belongsTo(Eje::class, 'eje_id');
    }

    public function combustible()
    {
        return $this->belongsTo(Combustible::class, 'combustible_id');
    }

    public function operatividad()
    {
        return $this->belongsTo(Operatividad::class, 'operatividad_id');
    }

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'compania_id');
    }

    public function creadopor()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizadopor()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }

    public function comentarios()
    {
        return $this->hasMany(MovilComentario::class, 'movil_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | LOCAL SCOPE / FILTROS DE CONSULTAS
    |---------------------------------------
    */

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('movil', "%{$search}%")
                ->orWhereLike('chasis', "%{$search}%")
                ->orWhereLike('detalles', "%{$search}%")
                ->orWhereLike('anho', "%{$search}%")
                ->orWhereLike('cubiertas_frente', "%{$search}%")
                ->orWhereLike('cubiertas_atras', "%{$search}%")
                ->orWhereLike('chapa', "%{$search}%")
                ->orWhereHas('acronimo', function ($query) use ($search) {
                    $query->whereLike('tipo', "%{$search}%");
                })->orWhereHas('marca', function ($query) use ($search) {
                    $query->whereLike('marca', "%{$search}%");
                })->orWhereHas('modelo', function ($query) use ($search) {
                    $query->whereLike('modelo', "%{$search}%");
                })->orWhereHas('transmision', function ($query) use ($search) {
                    $query->whereLike('transmision', "%{$search}%");
                })->orWhereHas('eje', function ($query) use ($search) {
                    $query->whereLike('eje', "%{$search}%");
                })->orWhereHas('combustible', function ($query) use ($search) {
                    $query->whereLike('combustible', "%{$search}%");
                })->orWhereHas('operatividad', function ($query) use ($search) {
                    $query->whereLike('operatividad', "%{$search}%");
                })->orWhereHas('compania', function ($query) use ($search) {
                    $query->whereLike('compania', "%{$search}%");
                });
        });
    }

    /**
     * Se implementa funcion para filtrar por campo chasis.
     */
    public function scopeBuscarChasis(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('chasis', "%{$search}%");
        });
    }

    /**
     * Se implementa funcion para filtrar por campo anho.
     */
    public function scopeBuscarAnho(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('anho', "%{$search}%");
        });
    }

    /**
     * Se implementa funcion para filtrar por campo cubiertas_frente.
     */
    public function scopeBuscarCubiertasFrente(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('cubiertas_frente', "%{$search}%");
        });
    }

    /**
     * Se implementa funcion para filtrar por campo cubiertas_atras.
     */
    public function scopeBuscarCubiertasAtras(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('cubiertas_atras', "%{$search}%");
        });
    }

    /**
     * Se implementa funcion para filtrar por campo chapa.
     */
    public function scopeBuscarChapa(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('chapa', "%{$search}%");
        });
    }

    /**
     * Se implementa funcion para filtrar por campo movil_tipo_id.
     */
    public function scopeBuscarAcronimoId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('movil_tipo_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo marca_id.
     */
    public function scopeBuscarMarcaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('marca_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo modelo_id.
     */
    public function scopeBuscarModeloId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('modelo_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo transmision_id.
     */
    public function scopeBuscarTransmisionId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('transmision_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo eje_id.
     */
    public function scopeBuscarEjeId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('eje_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo combustible_id.
     */
    public function scopeBuscarCombustibleId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('combustible_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo operatividad_id.
     */
    public function scopeBuscarOperatividadId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('operatividad_id', $search);
        });
    }

    /**
     * Se implementa funcion para filtrar por campo compania_id.
     */
    public function scopeBuscarCompaniaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, $search) {
            $query->where('compania_id', $search);
        });
    }

    public function ultimoComentarioFueraServicio()
    {
        return $this->hasOne(MovilComentario::class, 'movil_id', 'id_movil')
            ->where('accion_id', 2)
            ->latest('created_at')
            ->with(['motivo:id_accion_categoria,categoria', 'detalle:idaccion_categoria_detalle,detalle']); // nombres de las columnas reales
    }

    public function scopeFiltrarInoperativos(Builder $query)
    {
        return $query->where('operatividad_id', 0); // 0 = INOPERATIVO
    }

    /*
    |---------------------------------------
    | FIN LOCAL SCOPE / FILTROS DE CONSULTAS
    |---------------------------------------
    */
}
