<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CompaniaGral extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_companias";

    protected $primaryKey = 'id_compania';

    protected $fillable = [
        'compania',
        'ciudad_id',
        'region_id',
        'orden',
    ];

    public function ciudad()
    {
        return $this->belongsTo(CiudadGral::class, 'ciudad_id');
    }

    public function region()
    {
        return $this->belongsTo(RegionGral::class, 'region_id');
    }
}
