<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtResolucion extends Model
{
    use SoftDeletes;

    protected $connection = 'db_resoluciones';

    protected $table = 'vista_resoluciones';

    protected $primaryKey = 'id_resolucion';

    public $timestamps = false;

    public function scopeBuscar($query, $value)
    {
        $query->where('n_resolucion', 'like', "%{$value}%")
        ->orWhere('concepto', 'like', "%{$value}%")
        ->orWhere('ano', 'like', "%{$value}%")
        ->orWhere('fuente_origen', 'like', "%{$value}%")
        ->orWhere('tipo_documento', 'like', "%{$value}%");
    }
}
