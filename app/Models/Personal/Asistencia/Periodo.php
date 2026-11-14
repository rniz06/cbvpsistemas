<?php

namespace App\Models\Personal\Asistencia;

use App\Models\Gral\Anho;
use App\Models\Gral\Mes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Periodo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'PER_asistencias_periodos';

    protected $primaryKey = 'id_asistencia_periodo';

    protected $fillable = [
        'anho_id',
        'mes_id',
        'fecha_vencimiento',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
    ];

    public $timestamps = false;

    public function anho()
    {
        return $this->belongsTo(Anho::class, 'anho_id');
    }

    public function mes()
    {
        return $this->belongsTo(Mes::class, 'mes_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'periodo_id', 'id_asistencia_periodo');
    }
}
