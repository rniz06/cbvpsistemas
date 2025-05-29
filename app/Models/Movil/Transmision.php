<?php

namespace App\Models\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Transmision extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_moviles_transmision";

    protected $primaryKey = 'id_movil_transmision';

    protected $fillable = ['transmision'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('transmision', 'like', "%{$value}%");
    }
}
