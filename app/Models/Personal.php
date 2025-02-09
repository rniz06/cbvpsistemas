<?php

namespace App\Models;

use App\Models\Personal\Categoria;
use App\Models\Personal\Contacto;
use App\Models\Personal\ContactoEmergencia;
use App\Models\Personal\Estado;
use App\Models\Personal\EstadoActualizar;
use App\Models\Personal\GrupoSanguineo;
use App\Models\Personal\Pais;
use App\Models\Personal\Sexo;
use App\Models\Vistas\VtCompania;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "personal";

    protected $primaryKey = 'idpersonal';

    /**
     * Los campos que se pueden asignar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombrecompleto',
        'codigo',
        'categoria_id',
        'compania_id',
        'fecha_juramento',
        'estado_id',
        'documento',
        'sexo_id',
        'nacionalidad_id',
        'contrasena',
        'ultima_actualizacion',
        'estado_actualizar_id',
        'grupo_sanguineo_id',
    ];

    /**
     * Relación uno a uno con el modelo User.
     * 
     * Este método obtiene el usuario asociado a este registro de personal.
     * La relación se establece a través de la clave foránea 'personal_id' en la tabla 'users'.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usuario()
    {
        return $this->hasOne(User::class, 'personal_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal_categorias".
     * Cada registro de este modelo pertenece a una categoría específica a través del campo "categoria_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal_estados".
     * Cada registro de este modelo pertenece a una categoría específica a través del campo "estado_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal_sexo".
     * Cada registro de este modelo pertenece a una categoría específica a través del campo "sexo_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "paises".
     * Cada registro de este modelo pertenece a un pais específico a través del campo "nacionalidad_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'nacionalidad_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal_estado_actualizar".
     * Cada registro de este modelo pertenece a una estadoActualizar específico a través del campo "estado_actualizar_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoActualizar()
    {
        return $this->belongsTo(EstadoActualizar::class, 'estado_actualizar_id');
    }

    /**
     * Relación de "uno a muchos" con la tabla "personal_grupo_sanguineo".
     * Cada registro de este modelo pertenece a una grupoSanguineo específico a través del campo "grupo_sanguineo_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupoSanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'grupo_sanguineo_id');
    }

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal_contactos".
     * Un TipoContacto puede tener varios registros asociados en la tabla "personal_contactos".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'personal_id');
    }

    /**
     * Relación de "uno a muchos" (inversa) con la tabla "personal_contactos_emergencias".
     * Un Personal puede tener varios registros asociados en la tabla "personal_contactos_emergencias".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactosEmergencias()
    {
        return $this->hasMany(ContactoEmergencia::class, 'personal_id');
    }

    /**
     * Relación "pertenece a" con la tabla "vt_companias".
     * Un "personal" pertenece a una "compañía" a través de la columna "compania_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vtcompania()
    {
        return $this->belongsTo(VtCompania::class, 'compania_id', 'idcompanias');
    }
}
