<?php

namespace App\Models\Materiales\EquipoHidraulico;

use App\Models\Materiales\EquipoHidraulico\Herramienta\Tipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Herramienta extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "MAT_hidraulicos_herr";

    protected $primaryKey = 'id_hidraulico_herr';

    protected $fillable = ['serie', 'operativo', 'hidraulico_id', 'marca_id', 'modelo_id', 'motor_id', 'tipo_id', 'operatividad_id', 'creadoPor', 'actualizadoPor'];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }
}
