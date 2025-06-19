<?php

namespace App\Models\Vistas\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtHidraulicoComentario extends Model
{
    use SoftDeletes;

    protected $table = 'MAT_vt_hidraulicos_comentarios';

    protected $primaryKey = 'id_hidraulico_comentario';
}
