<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Mesa extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "mesas";

    protected $primaryKey = 'id_mesa';

    protected $fillable = [
        'mesa',
        'votos',
        'estado',
        'descripcion',
    ];

    public function personales()
    {
        return $this->belongsToMany(Personal::class, 'mesa_personal', 'mesa_id', 'personal_id')
            ->withPivot('votos')
            ->withTimestamps()->using(MesaPersonal::class);
    }
}
