<?php

namespace App\Models\Personal;

use App\Models\Personal;
use App\Models\Vistas\VtPersonales;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "personal_contactos";

    protected $primaryKey = 'id_personal_contacto';

    protected $fillable = [
        'personal_id',
        'tipo_contacto_id',
        'contacto',
    ];

    /**
     * Relación de "uno a muchos" con la tabla "personal_tipo_contactos".
     * Cada registro de este modelo pertenece a una tipoContacto específico a través del campo "tipo_contacto_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoContacto()
    {
        return $this->belongsTo(TipoContacto::class, 'tipo_contacto_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal".
     * Cada registro de este modelo pertenece a una personal específico a través del campo "personal_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal".
     * Cada registro de este modelo pertenece a una personal específico a través del campo "personal_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vtPersonal()
    {
        return $this->belongsTo(VtPersonales::class, 'personal_id');
    }
}
