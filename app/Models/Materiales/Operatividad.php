<?php

namespace App\Models\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Operatividad extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_operatividad";

    protected $primaryKey = 'id_operatividad';

    protected $fillable = [
        'operatividad',
    ];
}
