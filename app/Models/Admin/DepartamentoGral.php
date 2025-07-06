<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DepartamentoGral extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "GRAL_departamentos";

    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'departamento',
    ];

    // Relacion inversa
    public function companias()
    {
        return $this->hasMany(CompaniaGral::class);
    }
}
