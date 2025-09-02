<?php

namespace App\Models\Vistas\Gral;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GralVtDireccion extends Model
{
    use SoftDeletes;
    
    protected $table = 'GRAL_vt_direcciones';

    protected $primaryKey = 'id_direccion';

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('direccion', 'like', "%{$value}%")
        ->orWhere('compania', 'like', "%{$value}%");
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
     * Buscador del campo compania.
     */
    public function scopeBuscarCompania($query, $value)
    {
        if (!empty($value)) {
            $query->where('compania', 'like', "%{$value}%");
        }
    }
}
