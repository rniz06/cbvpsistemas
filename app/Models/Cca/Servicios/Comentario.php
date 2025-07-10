<?php

namespace App\Models\Cca\Servicios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios_existentes_comentarios";

    protected $primaryKey = 'idservicio_existente_comentario';

    protected $fillable = ['comentario', 'servicio_id', 'creadoPor', 'actualizadoPor'];
}
