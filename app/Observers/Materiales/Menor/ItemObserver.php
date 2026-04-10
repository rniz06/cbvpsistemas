<?php

namespace App\Observers\Materiales\Menor;

use App\Models\Materiales\Menor\Item;
use Illuminate\Support\Facades\Auth;

class ItemObserver
{
    /**
     * GENERA COMENTARIO AUTOMATICO CUANDO
     * SE DA DE ALTA UN ITEM.
     */
    public function created(Item $item): void
    {
        $item->comentarios()->create([
            'comentario' => "SE DA DE ALTA EN EL SISTEMA",
            'creadoPor'  => Auth::id(),
        ]);
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        //
    }
}
