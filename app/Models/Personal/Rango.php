<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Rango extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_rangos";

    protected $primaryKey = 'id_rango';

    protected $fillable = [
        'rango',
        'creadoPor',
        'actualizadoPor',
    ];

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        if (!empty($value)) {
            $query->where('rango', 'like', "%{$value}%");
                // ->orWhere('compania', 'like', "%{$value}%");
        }
    }
}
