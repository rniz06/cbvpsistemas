<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ComisionamientoTipo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_comisionamientos_tipos";

    protected $primaryKey = 'id_comisionamiento_tipo';

    protected $fillable = [
        'tipo',
    ];
}
