<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $connection = "db_companias";

    protected $table = "departamentos";

    protected $primaryKey = 'iddepartamentos';

    protected $fillable = ['departamento'];

    public $timestamps = false;
}
