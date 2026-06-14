<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenFisico extends Model
{

    use SoftDeletes;

    protected $table='ECB_examenes_fisicos';

    protected $guarded=[];



    public function pruebas()
    {

        return $this->hasMany(

            ExamenFisicoPrueba::class,

            'examen_fisico_id'

        );

    }

    public function detalles()
    {

        return $this->hasMany(

            ResultadoExamenFisicoDetalle::class,

            'resultado_id'

        );

    }

}