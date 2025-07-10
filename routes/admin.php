<?php

use App\Http\Controllers\Admin\CompaniaController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Rutas del modulo Admin/Companias
    |--------------------------------------------------------------------------
    */

Route::controller(CompaniaController::class)
    ->middleware('auth')
    ->prefix('admin')
    ->group(function () {
        Route::get('/companias', 'index')->name('admin.companias.index');
    });
