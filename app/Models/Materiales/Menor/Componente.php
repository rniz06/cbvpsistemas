<?php

namespace App\Models\Materiales\Menor;

use App\Enums\Materiales\Menor\TipoMenor;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Componente extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_menor_componentes";

    protected $primaryKey = 'id_menor_componente';

    protected $fillable = ['nombre', 'tipo_id', 'categoria_id', 'creadoPor', 'actualizadoPor'];

    protected $casts = [
        'tipo_id' => TipoMenor::class,
    ];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    # RELACION CON MODELO DE MATERIAL MENOR
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'componente_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | SCOPES LOCALES PARA FILTROS
    |---------------------------------------
    */

    # RETORNAR SOLO REGISTROS QUE PERTENESCAN A MATERIAL MENOR
    public function scopeMenor(Builder $query): void
    {
        $query->where('tipo_id', TipoMenor::MENOR);
    }

    # RETORNAR SOLO REGISTROS QUE PERTENESCAN A MATERIAL MENOR
    public function scopeForestales(Builder $query): void
    {
        #$query->where('categoria_id', CategoriaComponente::EQUIPOS_FORESTALES);
    }

    # RETORNAR SOLO REGISTROS QUE PERTENESCAN A MATERIAL MENOR
    public function scopeEras(Builder $query): void
    {
        $query->where('tipo_id', TipoMenor::ERAS);
    }

    # RETORNAR REGISTROS QUE PERTENESCAN A MENOR Y FORESTALES
    public function scopeMenorAndForestales(Builder $query): void
    {
        $query->whereIn('tipo_id', [TipoMenor::MENOR, TipoMenor::FORESTALES]);
    }

    /**
     * Busqueda por campo nombre.
     */
    public function scopeBuscarNombre(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('nombre', "%{$search}%");
        });
    }

    /**
     * Busqueda por campo tipo_id.
     */
    public function scopeBuscarTipoId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->where('tipo_id', $search);
        });
    }

    /**
     * Busqueda por campo categoria_id.
     */
    public function scopeBuscarCategoriaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->where('categoria_id', $search);
        });
    }

    /*
    |---------------------------------------
    | FIN SCOPES LOCALES PARA FILTROS
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | RELACIONES DEL AUDITORIA DE LA TABLA
    |---------------------------------------
    */

    public function creadopor()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizadopor()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }
}
