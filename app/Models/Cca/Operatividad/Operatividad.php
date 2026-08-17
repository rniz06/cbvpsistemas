<?php

namespace App\Models\Cca\Operatividad;

use App\Models\Gral\Compania;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Operatividad extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = "CCA_operatividad_detalles";

    protected $primaryKey = 'id_operatividad_detalle';

    protected $fillable = [
        'fecha_hora',
        'acargo',
        'acargo_aux',
        'cant_personal',
        'cant_conductor',
        'equipo_hidraulico',
        'pileta',
        'cant_autonomo',
        'cant_espuma',
        'compania_id',
        'creadoPor',
        'actualizadoPor'
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora'        => 'datetime',
            'equipo_hidraulico' => 'boolean',
            'pileta'            => 'boolean',
        ];
    }

    public function acargo_rel()
    {
        return $this->belongsTo(Personal::class, 'acargo', 'idpersonal');
    }

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'compania_id', 'id_compania');
    }

    public function moviles()
    {
        return $this->hasMany(OperatividadMovil::class, 'operatividad_detalle_id', 'id_operatividad_detalle');
    }

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
