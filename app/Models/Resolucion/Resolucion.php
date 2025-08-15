<?php

namespace App\Models\Resolucion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resolucion extends Model
{
    use SoftDeletes;

    protected $connection = 'db_resoluciones';

    protected $table = 'resoluciones';

}
