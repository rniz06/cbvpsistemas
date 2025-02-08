<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "personal";

    protected $primaryKey = 'idpersonal';

    /**
     * Los campos que se pueden asignar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombrecompleto',
        'codigo',
        'categoria_id',
        'compania_id',
        'fecha_juramento',
        'estado_id',
        'documento',
        'sexo_id',
        'nacionalidad_id',
        'contrasena',
        'ultima_actualizacion',
        'estado_actualizar_id',
        'grupo_sanguineo_id',
    ];

    /**
     * Relación uno a uno con el modelo User.
     * 
     * Este método obtiene el usuario asociado a este registro de personal.
     * La relación se establece a través de la clave foránea 'personal_id' en la tabla 'users'.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(User::class, 'personal_id');
    }
}
