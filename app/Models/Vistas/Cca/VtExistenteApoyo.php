<?php

namespace App\Models\Vistas\Cca;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtExistenteApoyo extends Model
{
    use SoftDeletes;

    protected $table = 'CCA_vt_servicios_existentes_apoyos';

    protected $primaryKey = 'idservicio_existente_apoyo';

    protected $casts = [
        'fecha_cia' => 'datetime',
        'fecha_movil' => 'datetime',
        'fecha_servicio' => 'datetime',
        'fecha_base' => 'datetime',
    ];
}
