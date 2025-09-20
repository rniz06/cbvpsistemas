<?php

namespace App\Models\Anb;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $connection = "sqlite";

    protected $table = "ANB_postulantes";

    protected $primaryKey = 'id_postulante';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',
        'celular',
        'correo',
        'direccion_particular',
        'direccion_laboral',
        'compania_id',
        'anho',
    ];

    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = trim($value);
    }

    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = trim($value);
    }

    public function setCedulaAttribute($value)
    {
        $this->attributes['cedula'] = trim($value);
    }

    public function setCelularAttribute($value)
    {
        $this->attributes['celular'] = trim($value);
    }

    public function setCorreoAttribute($value)
    {
        $this->attributes['correo'] = trim($value);
    }

    public function setDireccionParticularAttribute($value)
    {
        $this->attributes['direccion_particular'] = trim($value);
    }

    public function setDireccionLaboralAttribute($value)
    {
        $this->attributes['direccion_laboral'] = trim($value);
    }
}
