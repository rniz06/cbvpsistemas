<?php

namespace App\Models\Vistas;

use App\Models\Personal\Contacto;
use App\Models\Personal\ContactoEmergencia;
use Illuminate\Database\Eloquent\Model;

class VtPersonales extends Model
{
    protected $table = "vt_personales";

    protected $primaryKey = 'idpersonal';

    public $timestamps = false;

    /**
     * Buscador general del componente Livewire.
     */
    public function scopeBuscar($query, $value)
    {
        if (!empty($value)) {
            $query->where(function ($q) use ($value) {
                $q->where('nombrecompleto', 'like', "%{$value}%")
                    ->orWhere('codigo', 'like', "%{$value}%")
                    ->orWhere('documento', 'like', "%{$value}%")
                    ->orWhere('fecha_juramento', 'like', "%{$value}%")
                    ->orWhere('categoria', 'like', "%{$value}%")
                    ->orWhere('estado', 'like', "%{$value}%")
                    ->orWhere('estado_actualizar', 'like', "%{$value}%")
                    ->orWhere('pais', 'like', "%{$value}%")
                    ->orWhere('sexo', 'like', "%{$value}%")
                    ->orWhere('compania', 'like', "%{$value}%");
            });
        }
    }

    /**
     * Buscador del campo nombrecompleto.
     */
    public function scopeBuscarNombrecompleto($query, $value)
    {
        if (!empty($value)) {
            $query->where('nombrecompleto', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo código.
     */
    public function scopeBuscarCodigo($query, $value)
    {
        if (!empty($value)) {
            $query->where('codigo', 'like', "%{$value}%")->orderBy('codigo', 'asc');
        }
    }

    /**
     * Buscador del campo documento.
     */
    public function scopeBuscarDocumento($query, $value)
    {
        if (!empty($value)) {
            $query->where('documento', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo fecha_juramento.
     */
    public function scopeBuscarFechajuramento($query, $value)
    {
        if (!empty($value)) {
            $query->where('fecha_juramento', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo categoría.
     */
    public function scopeBuscarCategoria($query, $value)
    {
        if (!empty($value)) {
            $query->where('categoria', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo estado.
     */
    public function scopeBuscarEstado($query, $value)
    {
        if (!empty($value)) {
            $query->where('estado', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo estado_actualizar.
     */
    public function scopeBuscarEstadoActualizar($query, $value)
    {
        if (!empty($value)) {
            $query->where('estado_actualizar', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo país.
     */
    public function scopeBuscarPais($query, $value)
    {
        if (!empty($value)) {
            $query->where('pais', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo sexo.
     */
    public function scopeBuscarSexo($query, $value)
    {
        if (!empty($value)) {
            $query->where('sexo', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo grupo_sanguineo.
     */
    public function scopeBuscarGrupoSanguineo($query, $value)
    {
        if (!empty($value)) {
            $query->where('grupo_sanguineo', 'like', "%{$value}%");
        }
    }

    /**
     * Buscador del campo compañía.
     */
    public function scopeBuscarCompania($query, $value)
    {
        if (!empty($value)) {
            $query->where('compania', 'like', "%{$value}%");
        }
    }

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal_contactos".
     * Un TipoContacto puede tener varios registros asociados en la tabla "personal_contactos".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'personal_id');
    }

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal_contactos_emergencias".
     * Un Personal puede tener varios registros asociados en la tabla "personal_contactos_emergencias".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactosEmergencias()
    {
        return $this->hasMany(ContactoEmergencia::class, 'personal_id');
    }
}
