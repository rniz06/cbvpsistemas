<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtPersonalContacto extends Model
{
    protected $table = "vt_personales_contactos";

    protected $primaryKey = 'id_personal_contacto';

    public $timestamps = false;
}
