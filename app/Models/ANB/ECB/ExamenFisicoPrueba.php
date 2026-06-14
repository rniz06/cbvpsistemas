<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenFisicoPrueba extends Model
{

    use SoftDeletes;

    protected $table='ECB_examen_fisico_pruebas';

    protected $guarded=[];



    public function examen()
    {

        return $this->belongsTo(

            ExamenFisico::class,

            'examen_fisico_id'

        );

    }



    public function parametros()
    {

        return $this->hasMany(

            ExamenFisicoParametro::class,

            'prueba_id'

        );

    }

}