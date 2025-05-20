<?php

namespace App\Models\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Marca extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "moviles_marcas";

    protected $primaryKey = 'id_movil_marca';

    protected $fillable = ['marca'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('marca', 'like', "%{$value}%")
            ->orWhere('activo', 'like', "%{$value}%");
    }
}
