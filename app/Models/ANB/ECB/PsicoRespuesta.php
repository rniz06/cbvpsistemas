<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;

class PsicoRespuesta extends Model
{

    protected $table='ECB_psico_respuestas';

    protected $guarded=[];



    public function opcion()
    {

        return $this->belongsTo(

            PsicoOpcion::class,

            'opcion_id'

        );

    }



    public function pregunta()
    {

        return $this->belongsTo(

            PsicoPregunta::class,

            'pregunta_id'

        );

    }



    public function sesion()
    {

        return $this->belongsTo(

            PsicoSesion::class,

            'sesion_id'

        );

    }

}