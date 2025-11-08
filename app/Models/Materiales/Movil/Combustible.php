<?php

namespace App\Models\Materiales\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Combustible extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_moviles_combustibles";

    protected $primaryKey = 'id_movil_combustible';

    protected $fillable = ['tipo', 'activo'];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function moviles()
    {
        return $this->hasMany(Movil::class, 'combustible_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /**
     * Se implementa funcion para buscador general del componente livewire.
     */
    public function scopeBuscador($query, $value)
    {
        $query->where('tipo', 'like', "%{$value}%")
        ->orWhere('activo', 'like', "%{$value}%");
    }
}
