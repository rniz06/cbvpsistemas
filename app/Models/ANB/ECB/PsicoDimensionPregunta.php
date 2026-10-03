<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;

class PsicoDimensionPregunta extends Model
{
    protected $table =
        'ECB_psico_dimension_preguntas';

    protected $guarded = [];

    public function pregunta()
    {
        return $this->belongsTo(
            PsicoPregunta::class,
            'pregunta_id'
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