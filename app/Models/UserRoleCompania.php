<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserRoleCompania extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'user_role_compania';

    protected $fillable = [
        'usuario_id',
        'role_id',
        'compania_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function compania()
    {
        return $this->belongsTo(Compania::class, 'compania_id');
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
