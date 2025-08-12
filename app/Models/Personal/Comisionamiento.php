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
        'tipo_id',
        'personal_id',
        'compania_id',
        'direccion_id',
        'cargo_id',
        'inicio_resolucion_id',
        'fin_resolucion_id',
        'fecha_inicio',
        'fecha_fin',
        'codigo_comisionamiento',
        'culminado',
        'creadoPor',
        'actualizadoPor',
    ];

    protected $casts = [
        'culminado'    => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];
}
