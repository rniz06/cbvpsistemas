<?php

namespace App\Models\Vistas\Cca;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtExistenteApoyo extends Model
{
    use SoftDeletes;

    protected $table = 'CCA_vt_servicios_existentes_apoyos';

    protected $primaryKey = 'idservicio_existente_apoyo';

    protected $casts = [
        'fecha_cia' => 'datetime',
        'fecha_movil' => 'datetime',
        'fecha_servicio' => 'datetime',
        'fecha_base' => 'datetime',
    ];

    /*
    |---------------------------------------
    | SCOPES LOCALES / FILTROS DE BUSQUEDA
    |---------------------------------------
    */

    /**
     * Buscar por campos tipo + movil.
     */
    public function scopeBuscarMovil(Builder $query, ?string $search = null): void
    {
        $query->when($search, function (Builder $query, string $search) {

            // Normalizar input (quitar espacios y guiones)
            $search = trim($search);
            $search = str_replace(['-', ' '], '', $search);

            $query->whereRaw(
                "REPLACE(REPLACE(UPPER(CONCAT(tipo, movil)), '-', ''), ' ', '') LIKE ?",
                ["%{$search}%"]
            );
        });
    }
}
