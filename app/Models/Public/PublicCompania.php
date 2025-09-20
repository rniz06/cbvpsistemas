<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicCompania extends Model
{
    use SoftDeletes;
    
    protected $connection = "mysql_sololectura";

    protected $table = "GRAL_companias";

    protected $primaryKey = "id_compania";
}
