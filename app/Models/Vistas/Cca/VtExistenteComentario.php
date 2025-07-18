<?php

namespace App\Models\Vistas\Cca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtExistenteComentario extends Model
{
    use SoftDeletes;
    
    protected $table = 'CCA_vt_servicios_existentes_comentarios';

    protected $primaryKey = 'idservicio_existente_comentario';
}
