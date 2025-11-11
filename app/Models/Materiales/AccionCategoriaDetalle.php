<?php

namespace App\Models\Materiales;

use App\Models\Materiales\Movil\MovilComentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AccionCategoriaDetalle extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_acciones_categorias_detalles";

    protected $primaryKey = 'idaccion_categoria_detalle';

    protected $fillable = [
        'detalle',
        'accion_categoria_id',
    ];

    public function movilcomentarios()
    {
        return $this->hasMany(MovilComentario::class, 'categoria_detalle_id');
    }
}
