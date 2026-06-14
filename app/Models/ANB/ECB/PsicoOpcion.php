<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsicoOpcion extends Model
{

    use SoftDeletes;

    protected $table='ECB_psico_opciones';

    protected $guarded=[];



    public function pregunta()
    {

        return $this->belongsTo(

            PsicoPregunta::class,

            'pregunta_id'

        );

    }

}