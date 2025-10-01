<?php

namespace App\Models\Personal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TipoDocumento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_tipos_documentos";

    protected $primaryKey = 'id_tipo_documento';

    protected $fillable = [
        'tipo_documento',
        'creadoPor',
        'actualizadoPor',
    ];

    /*
    |---------------------------------------
    | RELACIONES DE AUDITORIA DE LA TABLA
    |---------------------------------------
    */
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }
}
