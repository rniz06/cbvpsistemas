<?php

namespace App\Models\Materiales;

use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Movil\Movil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Operatividad extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_operatividad";

    protected $primaryKey = 'id_operatividad';

    protected $fillable = [
        'operatividad',
    ];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function moviles()
    {
        return $this->hasMany(Movil::class, 'operatividad_id');
    }

    # RELACION CON MODELO DE MATERIAL MENOR
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'estado_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */
}
