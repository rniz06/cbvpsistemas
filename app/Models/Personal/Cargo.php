<?php

namespace App\Models\Personal;

use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Cargo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "PER_cargos";

    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'cargo',
        'codigo_base',
        'tipo_codigo',
        'rango_id',
        'creadoPor',
        'actualizadoPor',
    ];

    public function rango()
    {
        return $this->belongsTo(Rango::class, 'rango_id');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'PER_cargo_rol',
            'cargo_id',
            'rol_id'
        )->withPivot('creadoPor')->withTimestamps();
    }

    protected $casts = [
        'tipo_codigo' => TipoCodigo::class
    ];
}
