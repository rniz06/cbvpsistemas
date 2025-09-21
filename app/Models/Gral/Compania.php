<?php

namespace App\Models\Gral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Compania extends Model implements Auditable
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
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
