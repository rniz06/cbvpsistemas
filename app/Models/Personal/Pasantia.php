<?php

namespace App\Models\Personal;

use App\Models\Personal;
use App\Models\Usuario;
use App\Models\Vistas\GralVtCompania;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Pasantia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'personal_pasantias';

    protected $primaryKey = 'id_pasantia';

    protected $fillable = [
        'personal_id',
        'compania_origen_id',
        'compania_destino_id',
        'fecha_inicio',
        'fecha_fin',
        'observaciones',
        'registrado_por',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    protected $appends = [
        'estado_calculado',
    ];

    public function personal(): BelongsTo
    {
        return $this->belongsTo(
            Personal::class,
            'personal_id',
            'idpersonal'
        );
    }

    public function companiaOrigen(): BelongsTo
    {
        return $this->belongsTo(
            GralVtCompania::class,
            'compania_origen_id',
            'id_compania'
        );
    }

    public function companiaDestino(): BelongsTo
    {
        return $this->belongsTo(
            GralVtCompania::class,
            'compania_destino_id',
            'id_compania'
        );
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'registrado_por',
            'id_usuario'
        );
    }

    public function getEstadoCalculadoAttribute(): string
    {
        $hoy = Carbon::today();

        $inicio = Carbon::parse($this->fecha_inicio)->startOfDay();
        $fin = Carbon::parse($this->fecha_fin)->startOfDay();

        if ($hoy->lt($inicio)) {
            return 'PENDIENTE';
        }

        if ($hoy->gt($fin)) {
            return 'VENCIDA';
        }

        return 'VIGENTE';
    }
}
