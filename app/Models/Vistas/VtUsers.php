<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtUsers extends Model
{
    protected $table = 'vt_users';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscar($query, $value)
    {
        $query->where('nombrecompleto', 'like', "%{$value}%")
        ->orWhere('codigo', 'like', "%{$value}%")
        ->orWhere('documento', 'like', "%{$value}%")
        ->orWhere('categoria', 'like', "%{$value}%")
        ->orWhere('compania', 'like', "%{$value}%")
        ->orWhere('roles', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo nombrecompleto.
     */
    public function scopeBuscarNombrecompleto($query, $value)
    {
        $query->where('nombrecompleto', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo codigo.
     */
    public function scopeBuscarCodigo($query, $value)
    {
        $query->where('codigo', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarDocumento($query, $value)
    {
        $query->where('documento', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarCategoria($query, $value)
    {
        $query->where('categoria', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarCompania($query, $value)
    {
        $query->where('compania', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo roles.
     */
    public function scopeBuscarRoles($query, $value)
    {
        $query->where('roles', 'like', "%{$value}%");
    }
}
