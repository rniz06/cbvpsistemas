<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RegionGral extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_regiones";

    protected $primaryKey = 'id_region';

    protected $fillable = [
        'region',
    ];

    // Relacion inversa
    public function companias()
    {
        return $this->hasMany(CompaniaGral::class);
    }
}
