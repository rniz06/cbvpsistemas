<?php

namespace App\Models\Vistas\Gral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtDireccion extends Model
{
    use SoftDeletes;

    protected $table = "GRAL_vt_direcciones";

    protected $primaryKey = 'id_direccion';

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        if (!empty($value)) {
            $query->where('direccion', 'like', "%{$value}%")
                ->orWhere('compania', 'like', "%{$value}%");
        }
    }


    /**
     * Buscador del campo direccion.
     */
    public function scopeBuscarDireccion($query, $value)
    {
        if (!empty($value)) {
            $query->where('direccion', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo compania_id.
     */
    public function scopeBuscarCompaniaId($query, $value)
    {
        if ($value) {
            $query->where('compania_id', $value);
        }
    }
}
