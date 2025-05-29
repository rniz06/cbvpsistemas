<?php

namespace App\Models\EquipoHidraulico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Modelo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_modelos";

    protected $primaryKey = 'id_hidraulico_modelo';

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
