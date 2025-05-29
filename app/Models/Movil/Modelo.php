<?php

namespace App\Models\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Modelo extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_moviles_modelos";

    protected $primaryKey = 'id_movil_modelo';

    protected $fillable = ['modelo', 'marca_id', 'activo'];

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
            })
            ->orWhere('activo', 'like', "%{$value}%");
    }
}
