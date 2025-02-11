<?php

namespace App\Models;

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
}
