<?php

use App\Http\Controllers\Personal\CargoController;
use App\Http\Controllers\Personal\ComisionamientoController;
use App\Http\Controllers\Personal\RangoController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('personal')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Personal/Rangos
    |--------------------------------------------------------------------------
    */
    Route::controller(RangoController::class)
        ->group(function () {
            Route::get('/rangos', 'index')->name('personal.rangos.index');
        });

        /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Personal/Cargos
    |--------------------------------------------------------------------------
    */
    Route::controller(CargoController::class)
        ->group(function () {
            Route::get('/cargos', 'index')->name('personal.cargos.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Comisionamientos
    |--------------------------------------------------------------------------
    */
    Route::controller(ComisionamientoController::class)
        ->group(function () {
            Route::get('/comisionamientos', 'index')->name('personal.comisionamientos.index');
            Route::get('/comisionamientos/create-autoridad', 'createAutoridad')->name('personal.comisionamientos.create-autoridad');
            Route::get('/comisionamientos/create-comisionamiento', 'createComisionamiento')->name('personal.comisionamientos.create-comisionamiento');
            Route::get('/comisionamientos/{comisionamiento}/edit', 'edit')->name('personal.comisionamientos.edit');
        });
});
