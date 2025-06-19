<?php

namespace App\Models\Vistas\Materiales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtMayorComentario extends Model
{
    use SoftDeletes;

    protected $table = 'MAT_vt_moviles_comentarios';

    protected $primaryKey = 'id_movil_comentario';

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('accion', 'like', "%{$value}%")
        ->orWhere('comentario', 'like', "%{$value}%")
        ->orWhere('nombrecompleto', 'like', "%{$value}%")
        ->orWhere('created_at', 'like', "%{$value}%");
    }
}
