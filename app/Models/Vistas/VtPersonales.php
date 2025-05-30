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
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscar($query, $value)
    {
        $query->where('nombrecompleto', 'like', "%{$value}%")
        ->orWhere('codigo', 'like', "%{$value}%")
        ->orWhere('documento', 'like', "%{$value}%")
        ->orWhere('fecha_juramento', 'like', "%{$value}%")
        ->orWhere('categoria', 'like', "%{$value}%")
        ->orWhere('estado', 'like', "%{$value}%")
        ->orWhere('estado_actualizar', 'like', "%{$value}%")
        ->orWhere('pais', 'like', "%{$value}%")
        ->orWhere('sexo', 'like', "%{$value}%")
        ->orWhere('compania', 'like', "%{$value}%");
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
        $query->where('codigo', 'like', "%{$value}%")->orderBy('codigo', 'asc');
    }

    /**
     * Se implementa funcion para buscador del campo codigo.
     */
    public function scopeBuscarDocumento($query, $value)
    {
        $query->where('documento', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo codigo.
     */
    public function scopeBuscarFechajuramento($query, $value)
    {
        $query->where('fecha_juramento', 'like', "%{$value}%");
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
    public function scopeBuscarEstado($query, $value)
    {
        $query->where('estado', 'like', "%{$value}%");
    }
    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarEstadoActualizar($query, $value)
    {
        $query->where('estado_actualizar', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarPais($query, $value)
    {
        $query->where('pais', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarSexo($query, $value)
    {
        $query->where('sexo', 'like', "%{$value}%");
    }

    /**
     * Se implementa funcion para buscador del campo documento.
     */
    public function scopeBuscarCompania($query, $value)
    {
        $query->where('compania', 'like', "%{$value}%");
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
