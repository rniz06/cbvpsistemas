<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comisionamiento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_comisionamientos";

    protected $primaryKey = 'id_comisionamiento';

    protected $fillable = [
        'personal_id',
        'compania_id',
        'resolucion_id',
        'fecha_inicio',
        'fecha_fin',
        'codigo_comisionamiento',
        'culminado',
    ];

    protected $casts = [
        'culminado'    => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];
}
