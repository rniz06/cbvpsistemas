<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\Personal\ComisionamientoController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('personal')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Comisionamientos
    |--------------------------------------------------------------------------
    */
    Route::controller(ComisionamientoController::class)
        ->group(function () {
            Route::get('/comisionamientos', 'index')->name('personal.comisionamientos.index');
            Route::get('/comisionamientos/create', 'create')->name('personal.comisionamientos.create');
            Route::get('/comisionamientos/{comisionamiento}/edit', 'edit')->name('personal.comisionamientos.edit');
        });

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Cargos
    |--------------------------------------------------------------------------
    */
    Route::controller(CargoController::class)
        ->group(function () {
            Route::get('/cargos', 'index')->name('personal.cargos.index');
        });
});
