<?php

namespace App\Models\Personal;

use App\Models\Ciudad;
use App\Models\Personal;
use App\Models\Vistas\VtPersonales;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class ContactoEmergencia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "personal_contactos_emergencias";

    protected $primaryKey = 'id_contacto_emergencia';

    protected $fillable = [
        'personal_id',
        'tipo_contacto_id',
        'parentesco_id',
        'ciudad_id',
        'nombre_completo',
        'direccion',
        'contacto',
    ];

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
     * Relación de "uno a muchos" con la tabla "personal_parentescos".
     * Cada registro de este modelo pertenece a una parentesco específico a través del campo "parentesco_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class, 'parentesco_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'compania_id', 'idciudades');
    }
}
