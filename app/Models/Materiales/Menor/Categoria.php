<?php

namespace App\Models\Materiales\Menor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_menor_categorias";

    protected $primaryKey = 'id_menor_categoria';

    protected $fillable = ['nombre', 'padre_id', 'creadoPor', 'actualizadoPor'];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function padre(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'padre_id');
    }

    public function componentes(): HasMany
    {
        return $this->hasMany(Componente::class, 'categoria_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
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
