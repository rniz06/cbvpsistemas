<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MesaPersonal extends Pivot
{
    protected $fillable = [
        'mesa_id',
        'personal_id',
        'votos',
    ];

    protected $table = 'mesa_personal';
}
