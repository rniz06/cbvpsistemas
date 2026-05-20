<?php

namespace App\Models\Materiales\Menor;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Categoria extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_menor_categorias";

    protected $primaryKey = 'id_menor_categoria';

    protected $fillable = ['nombre', 'creadoPor', 'actualizadoPor'];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function componentes(): HasMany
    {
        return $this->hasMany(Componente::class, 'categoria_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /**
     * Busqueda por campo nombre.
     */
    public function scopeBuscador(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->whereLike('nombre', "%{$search}%");
        });
    }

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
