<?php

namespace App\Models\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Eje extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "moviles_ejes";

    protected $primaryKey = 'id_movil_eje';

    protected $fillable = ['eje', 'activo'];

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('eje', 'like', "%{$value}%")
        ->orWhere('activo', 'like', "%{$value}%");
    }
}
