<?php

namespace App\Models;

use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Personal\ContactoEmergencia;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $connection = "db_companias";

    protected $table = "ciudades";

    protected $primaryKey = 'idciudades';

    public $timestamps = false;

    public function contactosEmergencias()
    {
        return $this->hasMany(ContactoEmergencia::class, 'ciudad_id', 'idciudades');
    }

    /**
     * Relacion Uno a muchos (inversa) con la tabla personalcbvp.conductores_bomberos.
     */

    public function conductorCiudadCurso()
    {
        return $this->hasMany(ConductorBombero::class, 'ciudad_curso_id', 'idciudades');
    }

    /**
     * Relacion Uno a muchos (inversa) con la tabla personalcbvp.conductores_bomberos.
     */

    public function conductorCiudadLicencia()
    {
        return $this->hasMany(ConductorBombero::class, 'ciudad_licencia_id', 'idciudades');
    }
}
