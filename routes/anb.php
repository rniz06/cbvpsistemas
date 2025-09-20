<?php

use App\Http\Controllers\Anb\QuieroSerBomberoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------
| RUTAS AGRUPADAS DEL MODULO ANB
|--------------------------------
*/

Route::get('/quiero-ser-bombero', [QuieroSerBomberoController::class, 'index'])->name('anb.quiero-ser-bombero');

Route::prefix('anb')->name('anb.')->middleware('auth')->group(function () {
    //
});
