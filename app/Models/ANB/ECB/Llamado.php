<?php

namespace App\Models\ANB\ECB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Llamado extends Model
{
    use SoftDeletes;

    protected $table='ECB_llamados';

    protected $guarded=[];

    public function aspirantes()
    {
        return $this->hasMany(Aspirante::class);
    }
}