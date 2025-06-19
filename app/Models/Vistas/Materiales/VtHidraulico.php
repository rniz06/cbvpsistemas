<?php

namespace App\Models\Vistas\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtHidraulico extends Model
{
    use SoftDeletes;

    protected $table = 'MAT_vt_hidraulicos';

    protected $primaryKey = 'id_hidraulico';

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('marca', 'like', "%{$value}%")
        ->orWhere('modelo', 'like', "%{$value}%")
        ->orWhere('compania', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para filtrar por campo departamento_id.
     */
    public function scopeBuscarDepartamentoId($query, $value)
    {
        if ($value) {
            $query->where('departamento_id', $value);
        }
    }

    /**
     * Se implementa funcion para filtrar por campo ciudad_id.
     */
    public function scopeBuscarCiudadId($query, $value)
    {
        if ($value) {
            $query->where('ciudad_id', $value);
        }
    }

    /**
     * Se implementa funcion para filtrar por campo compania_id.
     */
    public function scopeBuscarCompaniaId($query, $value)
    {
        if ($value) {
            $query->where('compania_id', $value);
        }
    }
}
