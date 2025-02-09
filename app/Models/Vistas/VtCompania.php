<?php

namespace App\Models\Vistas;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Model;

class VtCompania extends Model
{
    protected $connection = "db_companias";

    protected $table = "vt_companias";

    protected $primaryKey = 'idcompanias';

    /**
     * Relación "tiene muchos" con la tabla "personal".
     * Una "compañía" tiene varios registros de "personal" asociados a través de la columna "compania_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personal()
    {
        return $this->hasMany(Personal::class, 'compania_id', 'idcompanias');
    }
}
