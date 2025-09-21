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

    protected function casts(): array
    {
        return [
            'licencia_vencimiento' => 'date', //fecha_curso
            'fecha_curso'          => 'date'
        ];
    }

    /**
     * Se implementa funcion para filtrar por campo Codigo.
     */
    public function scopeBuscarCodigo($query, $value)
    {
        if ($value) {
            $query->where('codigo', 'like', "%{$value}%");
        }
    }

    /**
     * Se implementa funcion para filtrar por campo nombrecompleto.
     */
    public function scopeBuscarNombrecompleto($query, $value)
    {
        if ($value) {
            $query->where('nombrecompleto', 'like', "%{$value}%");
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

    /**
     * Se implementa funcion para filtrar por campo estado_id.
     */
    public function scopeBuscarEstadoId($query, $value)
    {
        if ($value) {
            $query->where('estado_id', $value);
        }
    }

    /**
     * Se implementa funcion para filtrar por campo estado_id.
     */
    public function scopeBuscarClaseLicenciaId($query, $value)
    {
        if ($value) {
            $query->where('clase_licencia_id', $value);
        }
    }
}
