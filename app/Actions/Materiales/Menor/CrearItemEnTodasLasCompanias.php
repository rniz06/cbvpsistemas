<?php

namespace App\Actions\Materiales\Menor;

use App\Models\Gral\Compania;
use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;

class CrearItemEnTodasLasCompanias
{
    /**
     * ANADIR EL COMPONENTE A TODAS LAS COMPANIAS
     */
    public function handle(int $componenteId): void
    {
        $userId = Auth::id();

        $companias = Compania::companiasValidas()
            ->pluck('id_compania');

        $items = $companias->map(function ($companiaId) use ($componenteId, $userId) {
            return [
                'componente_id'        => $componenteId,
                'cantidad_operativo'   => 0,
                'cantidad_inoperativo' => 0,
                'compania_id'          => $companiaId,
                'creadoPor'            => $userId,
            ];
        })->toArray();

        Item::insert($items);
    }
}
