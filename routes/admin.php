<?php

use App\Http\Controllers\Admin\CompaniaController;
use App\Http\Controllers\Admin\DireccionController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Rutas del modulo Admin
    |--------------------------------------------------------------------------
    */

Route::prefix('admin')->middleware('auth', 'role:SuperAdmin')->group(function () {
    Route::get('companias', [CompaniaController::class, 'index'])->name('admin.companias.index');
    Route::get('direcciones', [DireccionController::class, 'index'])->name('admin.direcciones.index');
});
