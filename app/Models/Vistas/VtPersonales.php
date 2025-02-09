<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtPersonales extends Model
{
    protected $table = "vt_personales";

    protected $primaryKey = 'idpersonal';

    public $timestamps = false;
}
