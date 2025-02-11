<?php

namespace App\Models\Personal;

use App\Models\Personal;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "personal_grupo_sanguineo";

    protected $primaryKey = 'idpersonal_grupo_sanguineo';

    protected $fillable = [
        'grupo_sanguineo',
    ];

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal".
     * Un GrupoSanguineo puede tener varios registros asociados en la tabla "personal".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personales()
    {
        return $this->hasMany(Personal::class);
    }
}
