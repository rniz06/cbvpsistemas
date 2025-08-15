<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtUsuarioConRole extends Model
{
    use SoftDeletes;

    protected $table = 'vt_usuarios_con_roles';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $casts = [
        'ultimo_acceso' => 'datetime'
    ];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->whereAny([
            'nombrecompleto',
            'codigo',
            'documento',
            'categoria',
            'compania',
            'roles',
        ],  'like', "%{$value}%");
    }
    // FUNCION ANTIGUA
    // public function scopeBuscar($query, $value)
    // {
    //     $query->where('nombrecompleto', 'like', "%{$value}%")
    //         ->orWhere('codigo', 'like', "%{$value}%")
    //         ->orWhere('documento', 'like', "%{$value}%")
    //         ->orWhere('categoria', 'like', "%{$value}%")
    //         ->orWhere('compania', 'like', "%{$value}%")
    //         ->orWhere('roles', 'like', "%{$value}%");
    // }

    /**
     * Se implementa funcion para buscador del campo nombrecompleto.
     */
    public function scopeBuscarNombrecompleto($query, $value)
    {
        if (!empty($value)) {
            $query->where('nombrecompleto', 'like', "%{$value}%");
        }
    }

    /**
     * Se implementa funcion para buscador del campo codigo.
     */
    public function scopeBuscarCodigo($query, $value)
    {
        if (!empty($value)) {
            $query->where('codigo', 'like', "%{$value}%");
        }
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarDocumento($query, $value)
    {
        if (!empty($value)) {
            $query->where('documento', 'like', "%{$value}%");
        }
    }

    /**
     * Se implementa funcion para buscador del campo categoria_id.
     */
    public function scopeBuscarCategoriaId($query, $value)
    {
        if ($value) {
            $query->where('categoria_id', $value);
        }
    }

    /**
     * Se implementa funcion para buscador del campo compania_id.
     */
    public function scopeBuscarCompaniaId($query, $value)
    {
        if ($value) {
            $query->where('compania_id', $value);
        }
    }

    /**
     * Se implementa funcion para buscador del campo roles.
     */
    public function scopeBuscarRoles($query, $value)
    {
        if (!empty($value)) {
            $query->where('roles', 'like', "%{$value}%");
        }
    }
}
