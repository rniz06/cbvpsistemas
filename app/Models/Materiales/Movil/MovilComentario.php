<?php

namespace App\Models\Materiales\Movil;

use App\Models\Materiales\Accion;
use App\Models\Materiales\AccionCategoria;
use App\Models\Materiales\AccionCategoriaDetalle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MovilComentario extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_moviles_comentarios";

    protected $primaryKey = 'id_movil_comentario';

    protected $fillable = ['comentario', 'movil_id', 'accion_id', 'accion_categoria_id', 'categoria_detalle_id', 'creadoPor', 'actualizadoPor'];

    public function movil()
    {
        return $this->belongsTo(Movil::class, 'movil_id');
    }

    public function accion()
    {
        return $this->belongsTo(Accion::class, 'accion_id');
    }

    public function motivo()
    {
        return $this->belongsTo(AccionCategoria::class, 'accion_categoria_id');
    }

    public function detalle()
    {
        return $this->belongsTo(AccionCategoriaDetalle::class, 'categoria_detalle_id');
    }
}
