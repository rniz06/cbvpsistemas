<?php

namespace App\Models\Materiales\Menor;

use App\Enums\Materiales\Menor\CategoriaComponente;
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

    protected $fillable = ['nombre', 'categoria_id', 'creadoPor', 'actualizadoPor'];

    protected $casts = [
        'categoria_id' => CategoriaComponente::class,
    ];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

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
        $query->where('categoria_id', CategoriaComponente::MATERIAL_MENOR);
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
