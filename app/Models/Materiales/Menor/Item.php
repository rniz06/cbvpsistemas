<?php

namespace App\Models\Materiales\Menor;

use App\Models\Gral\Compania;
use App\Models\Materiales\Operatividad;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $table = "MAT_menor_items";

    protected $primaryKey = 'id_menor_item';

    protected $fillable = ['componente_id', 'estado_id', 'compania_id', 'creadoPor', 'actualizadoPor'];

    /*
    |---------------------------------------
    | RELACIONES DEL MODELO
    |---------------------------------------
    */

    public function componente(): BelongsTo
    {
        return $this->belongsTo(Componente::class, 'componente_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Operatividad::class, 'estado_id');
    }

    public function compania(): BelongsTo
    {
        return $this->belongsTo(Compania::class, 'compania_id');
    }

    /*
    |---------------------------------------
    | FIN RELACIONES DEL MODELO
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | SCOPES LOCALES PARA FILTROS
    |---------------------------------------
    */

    public function scopeOperativos(Builder $query): void
    {
        $query->where('estado_id', 1); # 1 -> OPERATIVO
    }

    public function scopeInoperativos(Builder $query): void
    {
        $query->where('estado_id', 0); # 0 -> INOPERATIVO
    }

    public function scopeBajas(Builder $query): void
    {
        $query->where('estado_id', 2); # 1 -> BAJA
    }

    # BUSCAR POR CAMPO componente_id
    public function scopeBuscarComponenteId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->where('componente_id', $search);
        });
    }

    # BUSCAR POR RELACION componente CAMPO marca_id
    public function scopeBuscarMarcaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->whereRelation('componente', 'marca_id', $search);
        });
    }

    # BUSCAR POR CAMPO compania_id
    public function scopeBuscarCompaniaId(Builder $query, $search = null): void
    {
        $query->when($search, function (Builder $query, int $search) {
            $query->where('compania_id', $search);
        });
    }

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
            'materiales_semi_admin' => $query->orderBy('id_menor_item'),

            # MODERADOR CON COMPANIA DIRECTA
            'materiales_moderador_compania' => $query
                ->where('compania_id', $usuario->compania_id),

            # MODERADOR CON ASIGNACION PIVOTE
            'materiales_moderador_por_compania' => $query
                ->where('compania_id', function ($sub) use ($usuario) {
                    $sub->select('compania_id')
                        ->from('user_role_compania')
                        ->where('usuario_id', $usuario->id_usuario)
                        ->whereNotNull('compania_id')
                        ->limit(1);
                }),

            # DEFAULT -> COMPORTAMIENTO GENERAL
            default => $query->orderBy('id_menor_item'),
        };
    }

    /*
    |---------------------------------------
    | FIN SCOPES LOCALES PARA FILTROS
    |---------------------------------------
    */

    /*
    |---------------------------------------
    | RELACIONES DEL AUDITORIA DE LA TABLA
    |---------------------------------------
    */

    public function creadopor()
    {
        return $this->belongsTo(User::class, 'creadoPor');
    }

    public function actualizadopor()
    {
        return $this->belongsTo(User::class, 'actualizadoPor');
    }
}
