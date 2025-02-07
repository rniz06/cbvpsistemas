<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * La primary key asociada a la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'personal_id',
        'codigo',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación uno a uno con el modelo Personal.
     * 
     * Este método obtiene el registro de personal al que pertenece este usuario.
     * La relación se establece a través de la clave foránea 'personal_id' en la tabla 'users'.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
