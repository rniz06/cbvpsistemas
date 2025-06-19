<?php

namespace App\Models\Materiales\EquipoHidraulico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comentario extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_comentarios";

    protected $primaryKey = 'id_hidraulico_comentario';

    protected $fillable = ['comentario', 'hidraulico_id', 'accion_id', 'creadoPor', 'actualizadoPor'];
}
