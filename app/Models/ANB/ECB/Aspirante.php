<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aspirante extends Model
{
    use SoftDeletes;

    protected $table='ECB_aspirantes';

    protected $guarded=[];

    public function llamado()
    {
        return $this->belongsTo(Llamado::class);
    }

    public function compania()
    {
        return $this->belongsTo(
            \App\Models\Compania::class,
            'compania_id'
        );
    }

    public function fichaMedica()
    {

        return $this->hasOne(
            FichaMedica::class
        );

    }


    public function resultadosExamenFisico()
    {

        return $this->hasMany(

            ResultadoExamenFisico::class,

            'aspirante_id'

        );

    }

    public function sesionesPsicologicas()
    {

        return $this->hasMany(

            \App\Models\ANB\ECB\PsicoSesion::class,

            'aspirante_id'

        );

    }


}