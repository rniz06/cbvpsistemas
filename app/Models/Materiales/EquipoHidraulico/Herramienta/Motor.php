<?php

namespace App\Models\Materiales\EquipoHidraulico\Herramienta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Motor extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_herr_motor";

    protected $primaryKey = 'idhidraulico_herr_motor';

    protected $fillable = ['motor'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('motor', 'like', "%{$value}%");
    }
}
