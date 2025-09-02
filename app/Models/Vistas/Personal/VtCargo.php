<?php

namespace App\Models\Vistas\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtCargo extends Model
{
    use SoftDeletes;

    protected $table = "PER_vt_cargos";

    protected $primaryKey = 'id_cargo';

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('cargo', 'like', "%{$value}%")
            ->orWhere('rango', 'like', "%{$value}%");
    }

    /**
     * Buscador del campo cargo.
     */
    public function scopeBuscarCargo($query, $value)
    {
        if (!empty($value)) {
            $query->where('cargo', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo rango_id.
     */
    public function scopeBuscarRangoId($query, $value)
    {
        if (!empty($value)) {
            $query->where('rango_id', '=', $value);
        }
    }
}
