<?php

namespace App\Models\EquipoHidraulico\Herramienta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Tipo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "hidraulicos_herr_tipos";

    protected $primaryKey = 'idhidraulico_herr_tipo';

    protected $fillable = ['tipo'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('tipo', 'like', "%{$value}%");
    }
}
