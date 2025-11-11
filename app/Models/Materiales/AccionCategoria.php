<?php

namespace App\Models\Materiales;

use App\Models\Materiales\Movil\MovilComentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AccionCategoria extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_acciones_categorias";

    protected $primaryKey = 'id_accion_categoria';

    protected $fillable = [
        'categoria',
        'accion_id',
    ];

    public function movilcomentarios()
    {
        return $this->hasMany(MovilComentario::class, 'accion_categoria_id');
    }
}
