<?php

namespace App\Models\Materiales;

use App\Models\Materiales\Movil\MovilComentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Accion extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_acciones";

    protected $primaryKey = 'id_accion';

    protected $fillable = [
        'accion',
    ];

    public function movilcomentarios()
    {
        return $this->hasMany(MovilComentario::class, 'accion_id');
    }
}
