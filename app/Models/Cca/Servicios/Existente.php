<?php

namespace App\Models\Cca\Servicios;

use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Movil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Existente extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "CCA_servicios_existentes";

    protected $primaryKey = 'id_servicio_existente';

    protected $fillable = [
        'informacion_servicio',
        'calle_referencia',
        'cantidad_tripulantes',
        'compania_id',
        'servicio_id',
        'clasificacion_id',
        'ciudad_id',
        'movil_id',
        'acargo',
        'acargo_aux',
        'acargo_rentado',
        'chofer',
        'chofer_aux',
        'chofer_rentado',
        'estado_id',
        'km_final',
        'desperfecto',
        'fecha_alfa',
        'fecha_cia',
        'fecha_movil',
        'fecha_servicio',
        'fecha_base',
        'falsa_alarma',
        'despacho_policia',
        'creadoPor',
        'actualizadoPor',
    ];

    protected $casts = [
        'chofer_rentado'   => 'boolean',
        'desperfecto'      => 'boolean',
        'despacho_policia' => 'boolean'
    ];

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'compania_id', 'id_compania');
    }

    public function movil()
    {
        return $this->belongsTo(Movil::class, 'movil_id', 'id_movil');
    }

    public function enganchadoAnterior()
    {
        return $this->belongsTo(Enganchado::class, 'servicio_anterior_id', 'id_servicio_existente');
    }

    public function enganchadoActual()
    {
        return $this->belongsTo(Enganchado::class, 'servicio_actual_id', 'id_servicio_existente');
    }
}
