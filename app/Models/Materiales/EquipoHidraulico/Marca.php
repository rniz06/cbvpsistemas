<?php

namespace App\Models\Materiales\EquipoHidraulico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Marca extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_marcas";

    protected $primaryKey = 'id_hidraulico_marca';

    protected $fillable = ['marca'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('marca', 'like', "%{$value}%");
    }
}
