<?php

namespace App\Models\Materiales\EquipoHidraulico\Herramienta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comentario extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_herr_comentarios";

    protected $primaryKey = 'idhidraulico_herr_comentario';

    protected $fillable = ['comentario', 'herramienta_id', 'accion_id', 'creadoPor', 'actualizadoPor'];
}
