<?php

namespace App\Models\Materiales;

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
}
