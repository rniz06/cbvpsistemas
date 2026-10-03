<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsicoSesion extends Model
{

    use SoftDeletes;

    protected $table='ECB_psico_sesiones';

    protected $guarded=[];



    protected $casts=[

        'inicio'=>'datetime',

        'expira_en'=>'datetime'

    ];



    public function aspirante()
    {

        return $this->belongsTo(
            Aspirante::class
        );

    }



    public function test()
    {

        return $this->belongsTo(
            PsicoTest::class,
            'test_id'
        );

    }

    public function respuestas()
    {

        return $this->hasMany(

            PsicoRespuesta::class,

            'sesion_id'

        );

    }
    
    public function resultados()
    {
        return $this->hasMany(

            PsicoResultado::class,

            'sesion_id'

        );
    }

}