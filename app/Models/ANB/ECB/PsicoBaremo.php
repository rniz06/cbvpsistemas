<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;

class PsicoBaremo extends Model
{
    protected $table='ECB_psico_baremos';

    protected $guarded=[];

    public function dimension()
    {
        return $this->belongsTo(
            PsicoDimension::class,
            'dimension_id'
        );
    }
}