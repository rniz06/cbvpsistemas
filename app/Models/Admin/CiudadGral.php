<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CiudadGral extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_ciudades";

    protected $primaryKey = 'id_ciudad';

    protected $fillable = [
        'ciudad',
        'departamento_id',
    ];

    public function departamento()
    {
        return $this->belongsTo(DepartamentoGral::class, 'departamento_id');
    }
    
    // Relacion inversa
    public function companias()
    {
        return $this->hasMany(CompaniaGral::class);
    }
}
