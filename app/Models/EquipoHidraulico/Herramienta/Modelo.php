<?php

namespace App\Models\EquipoHidraulico\Herramienta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Modelo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "hidraulicos_herr_modelos";

    protected $primaryKey = 'idhidraulico_herr_modelo';

    protected $fillable = ['modelo', 'marca_id'];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('modelo', 'like', "%{$value}%")
            ->orWhereHas('marca', function ($query) use ($value) {
                $query->where('marca', 'like', "%{$value}%");
            });
    }
}
