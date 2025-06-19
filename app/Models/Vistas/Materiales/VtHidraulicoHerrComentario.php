<?php

namespace App\Models\Vistas\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtHidraulicoHerrComentario extends Model
{
    use SoftDeletes;

    protected $table = 'MAT_vt_hidraulicos_herr_comentarios';

    protected $primaryKey = 'idhidraulico_herr_comentario';
}
