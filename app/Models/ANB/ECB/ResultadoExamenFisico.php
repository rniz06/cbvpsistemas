<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoExamenFisico extends Model
{

    use SoftDeletes;

    protected $table='ECB_resultados_examen_fisico';

    protected $guarded=[];



    public function aspirante()
    {

        return $this->belongsTo(
            Aspirante::class
        );

    }



    public function examen()
    {

        return $this->belongsTo(

            ExamenFisico::class,

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