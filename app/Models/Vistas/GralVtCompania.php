<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GralVtCompania extends Model
{
    use SoftDeletes;

    protected $table = "GRAL_vt_companias";

    protected $primaryKey = 'id_compania';

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('compania', 'like', "%{$value}%")
        ->orWhere('departamento', 'like', "%{$value}%")
        ->orWhere('ciudad', 'like', "%{$value}%")
        ->orWhere('region', 'like', "%{$value}%");
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

    /**
     * Buscador del campo departamento_id.
     */
    public function scopeBuscarDepartamentoId($query, $value)
    {
        if ($value) {
            $query->where('departamento_id', $value);
        }
    }

    /**
     * Buscador del campo ciudad_id.
     */
    public function scopeBuscarCiudadId($query, $value)
    {
        if ($value) {
            $query->where('ciudad_id', $value);
        }
    }

    /**
     * Buscador del campo region_id.
     */
    public function scopeBuscarRegionId($query, $value)
    {
        if ($value) {
            $query->where('region_id', $value);
        }
    }
}
