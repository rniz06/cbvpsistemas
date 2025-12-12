<?php

namespace App\Models\Gral;

use App\Models\Personal\Asistencia\Periodo;
use App\Models\Personal\AsistenciaPeriodo;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Mes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_meses";

    protected $primaryKey = 'id_mes';

    protected $fillable = ['mes', 'numero'];

    public $timestamps = false;

    // Relacion inversa
    public function asistenciasPeriodos()
    {
        return $this->hasMany(Periodo::class);
    }
}
