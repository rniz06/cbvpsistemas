<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoExamenFisicoDetalle extends Model
{

    use SoftDeletes;

    protected $table='ECB_resultados_examen_fisico_detalle';

    protected $guarded=[];



    public function resultado()
    {

        return $this->belongsTo(

            ResultadoExamenFisico::class,

            'resultado_id'

        );

    }



    public function prueba()
    {

        return $this->belongsTo(

            ExamenFisicoPrueba::class,

            'prueba_id'

        );

    }

}