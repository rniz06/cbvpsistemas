<?php

namespace App\Models\Materiales\Conductor;

use App\Models\Ciudad;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConductorBombero extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_conductores_bomberos";

    protected $primaryKey = 'id_conductor_bombero';

    protected $fillable = [
        'personal_id',
        'estado_id',
        'resolucion',
        'resolucion_id',
        'resolucion_enlace',
        'fecha_curso',
        'ciudad_curso_id',
        'ciudad_licencia_id',
        'tipo_vehiculo_id',
        'numero_licencia',
        'licencia_vencimiento',
        'clase_licencia_id',
        'creadoPor'
    ];

    protected function casts(): array
    {
        return [
            'fecha_curso'          => 'date',
            'licencia_vencimiento' => 'date'
        ];
    }

    /**
     * Relación uno a uno
     */
    public function personal(): HasOne
    {
        return $this->hasOne(Personal::class, 'personal_id');
    }

    /**
     * Relacion Uno a muchos con la tabla conductores_estados.
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    /**
     * Relacion Uno a muchos con la tabla emepy_bd.ciudades.
     */
    public function ciudadCurso()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_curso_id', 'idciudades');
    }

    /**
     * Relacion Uno a muchos con la tabla emepy_bd.ciudades.
     */
    public function ciudadLicencia()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_licencia_id', 'idciudades');
    }

    /**
     * Relacion Uno a muchos con la tabla conductores_tipo_vehiculo.
     */
    public function tipoVehiculo(): BelongsTo
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipo_vehiculo_id');
    }

    /**
     * Relacion Uno a muchos con la tabla conductores_tipo_vehiculo.
     */
    public function claseLicencia(): BelongsTo
    {
        return $this->belongsTo(
            ClaseLicencia::class,               // Modelo relacionado
            'clase_licencia_id',                // FK en conductores_bomberos
            'idconductor_clase_licencia'        // PK en conductores_clase_licencias
        );
    }
}
