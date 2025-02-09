<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $connection = "db_companias";

    protected $table = "companias";

    protected $primaryKey = 'idcompanias';

    public $timestamps = false;

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
