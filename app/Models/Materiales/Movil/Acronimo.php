<?php

namespace App\Models\Materiales\Movil;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Acronimo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_moviles_tipos";

    protected $primaryKey = 'id_movil_tipo';

    protected $fillable = ['tipo', 'descripcion', 'activo'];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function moviles()
    {
        return $this->hasMany(Movil::class, 'movil_tipo_id');
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
        ->orWhere('descripcion', 'like', "%{$value}%")
        ->orWhere('activo', 'like', "%{$value}%");
    }

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}
