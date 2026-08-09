<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\Personal\AsistenciaController;
use App\Http\Controllers\Personal\ComisionamientoController;
use App\Http\Controllers\PersonalController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('personal')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Personal
    |--------------------------------------------------------------------------
    */
    Route::controller(PersonalController::class)
        ->group(function () {
            Route::get('/constancia-de-ser-bombero/{personal}', 'constanciaDeSerBombero')->name('personal.constancia-de-ser-bombero');
        });

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

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Asistencias
    |--------------------------------------------------------------------------
    */
    Route::controller(AsistenciaController::class)
        ->group(function () {
            Route::get('/asistencias', 'index')->name('personal.asistencias.index');
            Route::get('/asistencias/generar-manualmente', 'generar_manualmente')->name('personal.asistencias.generar-manualmente');
            Route::get('/asistencias/{asistencia}', 'show')->name('personal.asistencias.show');
        });
});
