<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtPersonalContactoEmergencia extends Model
{
    protected $table = "vt_personales_contactos_emergencias";

    protected $primaryKey = 'id_contacto_emergencia';

    public $timestamps = false;
}
