<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Model implements Auditable
{
    use SoftDeletes, HasRoles, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    protected $primaryKey = 'id_usuario';

    protected $fillable = ['personal_id', 'name', 'email', 'password', 'ultimo_acceso'];

    // Especifica el guard explícitamente
    protected $guard_name = 'web';

    public function getMorphClass()
    {
        return User::class; // Asegura que Spatie guarde `App\Models\User`
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    // En el modelo Usuario
    public static function registrarAcceso($id)
    {
        static::findOrFail($id)->update(['ultimo_acceso' => now()]);
    }
}
