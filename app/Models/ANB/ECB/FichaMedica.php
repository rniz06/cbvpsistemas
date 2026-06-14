<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FichaMedica extends Model
{

    use SoftDeletes;

    protected $table='ECB_fichas_medicas';

    protected $fillable=[

        'aspirante_id',

        'registro_medico',

        'observacion',

        'ficha_medica_archivo',

        'ecg_archivo',

        'radiografia_torax_archivo',

        'laboratorio_archivo',

        'documentacion_complementaria_archivo',

    ];



    public function aspirante()
    {

        return $this->belongsTo(
            Aspirante::class
        );

    }

}