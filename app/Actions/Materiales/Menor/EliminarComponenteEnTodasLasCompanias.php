<?php

namespace App\Actions\Materiales\Menor;

use App\Models\Materiales\Menor\Componente;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\DB;

class EliminarComponenteEnTodasLasCompanias
{
    /**
     * ELIMINA LOGICAMENTE UN COMPONENTE Y TODOS LOS REGISTROS DE ITEMS ASOCIADOS A LAS COMPANIAS
     */
    public function handle(int $componenteId): void
    {
        DB::transaction(function () use ($componenteId) {

            // 1. Soft delete de los items asociados
            Item::where('componente_id', $componenteId)
                ->delete();

            // 2. Soft delete del componente
            Componente::findOrFail($componenteId)
                ->delete();
        });
    }
}
