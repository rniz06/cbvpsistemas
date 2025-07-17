<?php

namespace App\Models\Vistas\Cca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtExistente extends Model
{
    use SoftDeletes;
    
    protected $table = 'CCA_vt_servicios_existentes';

    protected $primaryKey = 'id_servicio_existente';

    protected $casts = [
        'fecha_alfa' => 'datetime',
        'fecha_cia' => 'datetime',
        'fecha_movil' => 'datetime',
        'fecha_servicio' => 'datetime',
        'fecha_base' => 'datetime',
    ];
}
