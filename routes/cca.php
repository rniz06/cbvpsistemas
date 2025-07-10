<?php

use App\Http\Controllers\Cca\DespachoController;
use App\Http\Controllers\Cca\DespachoPorCompaniaController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Rutas del modulo CCA
    |--------------------------------------------------------------------------
    */

Route::prefix('cca')->middleware('auth')->group(function () {
    Route::controller(DespachoController::class)
        ->prefix('despachos')
        ->group(function () {
            Route::get('/despacho-por-compania', 'despachoPorCompania')->name('cca.despacho.despacho-por-compania');
            Route::get('/despacho-por-compania-final/{compania}', 'despachoPorCompaniaFinal')->name('cca.despacho.despacho-por-compania-final');
            Route::get('/ver-servicio/{servicio}', 'verServicio')->name('cca.despacho.ver-servicio');
        });
});
