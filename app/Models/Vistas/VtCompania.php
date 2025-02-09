<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtCompania extends Model
{
    protected $connection = "db_companias";

    protected $table = "vt_companias";

    protected $primaryKey = 'idcompanias';
}
