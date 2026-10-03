<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;

class PsicoDimension extends Model
{
    protected $table =
        'ECB_psico_dimensiones';

    protected $fillable = [

        'test_id',

        'orden',

        'nombre',

        'divisor',
        'codigo',

    ];

    public function test()
    {
        return $this->belongsTo(
            PsicoTest::class,
            'test_id'
        );
    }


public function resultados()
{
    return $this->hasMany(

        PsicoResultado::class,

        'dimension_id'

    );
}

public function preguntas()
{
    return $this->hasMany(

        PsicoPregunta::class,

        'dimension_id'

    );
}

public function preguntasRelacionadas()
{
    return $this->belongsToMany(

        PsicoPregunta::class,

        'ECB_psico_dimension_preguntas',

        'dimension_id',

        'pregunta_id'

    );
}

}