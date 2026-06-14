<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;

class PsicoResultado extends Model
{
    protected $table =
        'ECB_psico_resultados';

    protected $guarded = [];

    public function sesion()
    {
        return $this->belongsTo(

            PsicoSesion::class,

            'sesion_id'

        );
    }

    public function dimension()
    {
        return $this->belongsTo(

            PsicoDimension::class,

            'dimension_id'

        );
    }


}