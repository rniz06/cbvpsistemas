<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsicoTest extends Model
{
    use SoftDeletes;

    protected $table='ECB_psico_tests';

    protected $guarded=[];

    public function preguntas()
    {
        return $this->hasMany(

            PsicoPregunta::class,

            'test_id'

        );
    }

    public function dimensiones()
    {
        return $this->hasMany(

            PsicoDimension::class,

            'test_id'

        );
    }
}