<?php

use App\Http\Controllers\Admin\CompaniaController;
use App\Http\Controllers\Admin\DireccionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Admin/Companias
    |--------------------------------------------------------------------------
    */
    Route::controller(CompaniaController::class)
        ->middleware('auth')
        ->group(function () {
            Route::get('/companias', 'index')->name('admin.companias.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Rutas del modulo Admin/Direcciones
    |--------------------------------------------------------------------------
    */
    Route::controller(DireccionController::class)
        ->middleware('auth')
        ->group(function () {
            Route::get('/direcciones', 'index')->name('admin.direcciones.index');
        });
});
