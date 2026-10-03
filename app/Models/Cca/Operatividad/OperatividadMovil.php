<?php

namespace App\Models\Cca\Operatividad;

use App\Models\Materiales\Movil\Movil;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OperatividadMovil extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = "CCA_operatividad_moviles";

    protected $primaryKey = 'id_operatividad_movil';

    protected $fillable = [
        'operatividad_detalle_id',
        'movil_id',
        'operativo',
        'creadoPor',
        'actualizadoPor'
    ];

    protected function casts(): array
    {
        return [
            'operativo' => 'boolean',
        ];
    }

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function operatividadDetalle()
    {
        return $this->belongsTo(Operatividad::class, 'operatividad_detalle_id');
    }

    public function movil()
    {
        return $this->belongsTo(Movil::class, 'movil_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | RELACIONES DE AUDITORIA DE LA TABLA
    |---------------------------------------
    */
    public function creado_por()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizado_por()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }
}
