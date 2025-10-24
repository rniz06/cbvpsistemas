<?php

namespace App\Models\Gral;

use App\Models\Personal\AsistenciaPeriodo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Anho extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_anhos";

    protected $primaryKey = 'id_anho';

    protected $fillable = ['anho'];

    // Relacion inversa
    public function asistenciasPeriodos()
    {
        return $this->hasMany(AsistenciaPeriodo::class);
    }
}
