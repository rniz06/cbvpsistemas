<?php

namespace App\Models\Materiales;

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
}
