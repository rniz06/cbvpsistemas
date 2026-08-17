<?php

namespace App\Models\Gral;

use App\Models\Cca\Operatividad\Operatividad;
use App\Models\Materiales\Menor\Item;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal\Asistencia\Asistencia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Compania extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "GRAL_companias";

    protected $primaryKey = 'id_compania';

    protected $fillable = [
        'compania',
        'ciudad_id',
        'region_id',
        'orden',
        'cca_operativo',
    ];

    protected function casts(): array
    {
        return [
            'cca_operativo' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function moviles()
    {
        return $this->hasMany(Movil::class, 'modelo_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    # RELACION CON MODELO DE MATERIAL MENOR
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'compania_id');
    }

    # OPERATIVIDAD EN CONDICION DE GUARDIA
    public function operatividades()
    {
        return $this->hasMany(
            Operatividad::class,
            'compania_id',
            'id_compania'
        );
    }

    public function ultimaOperatividad()
    {
        return $this->hasOne(
            Operatividad::class,
            'compania_id',
            'id_compania'
        )->latestOfMany('fecha_hora');
    }

    /*
    |--------------------------------------------------------------------------
    | FIN RELACIONES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES LOCALES PARA FILTROS
    |--------------------------------------------------------------------------
    */

    # FILTRO DIRECTO: TOMA PRIMER ROL DEL USUARIO EN EL MODULO DE MATERIALES 
    # DEPENDIENDO DEL ROL TRAE LISTADO COMPLETO DE COMPANIAS O SOLO EL ESPECIFICO
    public function scopeFiltrarPorRolMateriales(Builder $query): Builder
    {
        $usuario = Auth::user();

        $rol = $usuario->roles()
            ->where('name', 'like', 'materiales_%')
            ->value('name');

        return match ($rol) {

            # ADMIN Y SEMI -> VEN TODAS LAS COMPANIAS
            'materiales_admin',
            'materiales_semi_admin' => $query->orderBy('orden'),

            # MODERADOR CON COMPANIA DIRECTA
            'materiales_moderador_compania' => $query
                ->where('id_compania', $usuario->compania_id),

            # MODERADOR CON ASIGNACION PIVOTE
            'materiales_moderador_por_compania' => $query
                ->where('id_compania', function ($sub) use ($usuario) {
                    $sub->select('compania_id')
                        ->from('user_role_compania')
                        ->where('usuario_id', $usuario->id_usuario)
                        ->whereNotNull('compania_id')
                        ->limit(1);
                }),

            # DEFAULT -> COMPORTAMIENTO GENERAL
            default => $query->orderBy('orden'),
        };
    }

    /**
     * Busqueda por campo nombre.
     */
    public function scopeBuscarIdCompania(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->where('id_compania', $search);
        });
    }

    /**
     * Busqueda por campo nombre.
     */
    public function scopeCompaniasValidas(Builder $query): void
    {
        $query->whereNotIn('compania', ['ANB', 'DIRECTORIO', 'COMANDANCIA', 'BRAVO FENIX', 'BRAVO GOLF']);
    }

    /*
    |--------------------------------------------------------------------------
    | FIN SCOPES LOCALES PARA FILTROS
    |--------------------------------------------------------------------------
    */
}
