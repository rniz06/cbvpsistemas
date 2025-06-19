<?php

namespace App\Models\Materiales\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MovilComentario extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_moviles_comentarios";

    protected $primaryKey = 'id_movil_comentario';

    protected $fillable = ['comentario', 'movil_id', 'accion_id', 'creadoPor', 'actualizadoPor'];
}
