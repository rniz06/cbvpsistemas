<?php

namespace App\Models\Gral;

use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Personal\ContactoEmergencia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Ciudad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "GRAL_ciudades";

    protected $primaryKey = 'id_ciudad';

    protected $fillable = [
        'ciudad',
        'departamento_id',
    ];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELACIONES CON EL MODULO DE PERSONAL
    |--------------------------------------------------------------------------
    |
    | LAS SIGUIENTES RELACIONES ESTAN HECHAS CON MODELOS PERTENECIENTES
    | AL MODULO DE PERSONAL
    |
    */

    public function contactosEmergencias()
    {
        return $this->hasMany(ContactoEmergencia::class, 'ciudad_id', 'id_ciudad');
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES CON EL MODULO DE PERSONAL
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELACIONES CON EL MODULO DE MATERIALES/CONDUCTORES
    |--------------------------------------------------------------------------
    */

    public function conductorCiudadCurso()
    {
        return $this->hasMany(ConductorBombero::class, 'ciudad_curso_id', 'id_ciudad');
    }
}
