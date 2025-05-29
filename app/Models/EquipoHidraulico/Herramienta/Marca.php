<?php

namespace App\Models\EquipoHidraulico\Herramienta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Marca extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_herr_marcas";

    protected $primaryKey = 'idhidraulico_herr_marca';

    protected $fillable = ['marca'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('marca', 'like', "%{$value}%");
    }
}
