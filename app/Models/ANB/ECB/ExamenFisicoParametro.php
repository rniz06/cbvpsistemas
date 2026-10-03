<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenFisicoParametro extends Model
{

    use SoftDeletes;

    protected $table='ECB_examen_fisico_parametros';

    protected $guarded=[];



    public function prueba()
    {

        return $this->belongsTo(

            ExamenFisicoPrueba::class,

            'prueba_id'

        );

    }

}