<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsicoPregunta extends Model
{
    use SoftDeletes;

    protected $table='ECB_psico_preguntas';

    protected $guarded=[];

    public function test()
    {
        return $this->belongsTo(

            PsicoTest::class,

            'test_id'

        );
    }

    public function dimension()
    {
        return $this->belongsTo(

            PsicoDimension::class,

            'dimension_id'

        );
    }

    public function opciones()
    {
        return $this->hasMany(

            PsicoOpcion::class,

            'pregunta_id'

        );
    }

    public function dimensiones()
    {
        return $this->belongsToMany(

            PsicoDimension::class,

            'ECB_psico_dimension_preguntas',

            'pregunta_id',

            'dimension_id'

        );
    }
    public function dimensionesRelacionadas()
{
    return $this->belongsToMany(

        PsicoDimension::class,

        'ECB_psico_dimension_preguntas',

        'pregunta_id',

        'dimension_id'

    );
}
}