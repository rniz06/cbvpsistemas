<?php

namespace App\Models\Vistas\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtComisionamiento extends Model
{
    use SoftDeletes;

    protected $table = "PER_vt_comisionamientos";

    protected $primaryKey = 'id_comisionamiento';

    protected $casts = [
        'culminado'    => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    /**
     * Se implementa funcion para buscador general.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('nombrecompleto', 'like', "%{$value}%")
            ->orWhere('codigo', 'like', "%{$value}%")
            ->orWhere('compania', 'like', "%{$value}%")
            ->orWhere('fecha_inicio', 'like', "%{$value}%")
            ->orWhere('fecha_fin', 'like', "%{$value}%")
            ->orWhere('codigo_comisionamiento', 'like', "%{$value}%")
            ->orWhere('culminado', 'like', "%{$value}%");
    }

    /**
     * Buscador del campo nombrecompleto.
     */
    public function scopeBuscarNombreCompleto($query, $value)
    {
        if (!empty($value)) {
            $query->where('nombrecompleto', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo codigo.
     */
    public function scopeBuscarCodigo($query, $value)
    {
        if (!empty($value)) {
            $query->where('codigo', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo compania_id.
     */
    public function scopeBuscarCompaniaId($query, $value)
    {
        if (!empty($value)) {
            $query->where('compania_id', '=', $value);
        }
    }

    /**
     * Buscador del campo fecha_inicio.
     */
    public function scopeBuscarFechaInicio($query, $value)
    {
        if (!empty($value)) {
            $query->where('fecha_inicio', '>=', $value);
        }
    }

    /**
     * Buscador del campo fecha_fin.
     */
    public function scopeBuscarFechaFin($query, $value)
    {
        if (!empty($value)) {
            $query->where('fecha_fin', '<=', $value);
        }
    }

    /**
     * Buscador Por Rangos de Fecha.
     */
    public function scopeBuscarPorRangoFechas($query, $desde, $hasta)
    {
        if (!empty($desde) && !empty($hasta)) {
            $query->whereBetween('fecha_inicio', [$desde, $hasta]);
        } elseif (!empty($desde)) {
            $query->where('fecha_inicio', '>=', $desde);
        } elseif (!empty($hasta)) {
            $query->where('fecha_inicio', '<=', $hasta);
        }
    }

    /**
     * Buscador del campo codigo_comisionamiento.
     */
    public function scopeBuscarCodigoComisionamiento($query, $value)
    {
        if (!empty($value)) {
            $query->where('codigo_comisionamiento', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo culminado
     */
    public function scopeBuscarCulminado($query, $value)
    {
        if ($value === '1') {
            $query->where('culminado', true);
        } elseif ($value === '0') {
            $query->where('culminado', false);
        } elseif ($value === 'null') {
            $query->whereNull('culminado');
        }
    }
}
