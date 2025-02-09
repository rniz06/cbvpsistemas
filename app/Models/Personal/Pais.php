<?php

namespace App\Models\Personal;

use App\Models\Personal;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "paises";

    protected $primaryKey = 'idpaises';

    protected $fillable = [
        'pais',
    ];

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal".
     * Un Pais puede tener varios registros asociados en la tabla "personal".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personales()
    {
        return $this->hasMany(Personal::class);
    }
}
