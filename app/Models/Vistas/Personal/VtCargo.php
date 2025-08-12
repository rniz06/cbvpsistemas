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
        if (!empty($value)) {
            $query->where('cargo', 'like', "%{$value}%")
                ->orWhere('codigo_cargo', 'like', "%{$value}%")
                ->orWhere('rango', 'like', "%{$value}%")
                ->orWhere('compania', 'like', "%{$value}%");
        }
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
     * Buscador del campo codigo_cargo.
     */
    public function scopeBuscarCodigoCargo($query, $value)
    {
        if (!empty($value)) {
            $query->where('codigo_cargo', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo rango_id.
     */
    public function scopeBuscarRangoId($query, $value)
    {
        if ($value) {
            $query->where('rango_id', $value);
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
