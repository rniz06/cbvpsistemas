<?php

namespace App\Models\Vistas\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtConductor extends Model
{
    use SoftDeletes;

    protected $table = "MAT_vt_conductores";

    protected $primaryKey = 'id_conductor_bombero';

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('codigo', 'like', "%{$value}%")
        ->orWhere('nombrecompleto', 'like', "%{$value}%")
        ->orWhere('compania', 'like', "%{$value}%")
        ->orWhere('estado', 'like', "%{$value}%");
    }
}
