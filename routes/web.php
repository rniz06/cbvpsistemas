<?php

//use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Auth::routes();
Auth::routes([
    'register' => false, // Desactivar route Register...
    'reset' => false, // Desactivar route Reset Password...
    'verify' => false, // Desactivar route Email Verification...
]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Modulo Personal
    |--------------------------------------------------------------------------
    */
    Route::controller(PersonalController::class)->group(function () {
        Route::get('personal', 'index')->name('personal.index');
        Route::get('personal/create', 'create')->name('personal.create');
        Route::post('personal/store', 'store')->name('personal.store');
        Route::get('personal/{personal}', 'show')->name('personal.show');
        Route::get('personal/{personal}/edit', 'edit')->name('personal.edit');
        Route::put('personal/{personal}', 'update')->name('personal.update');
        Route::delete('personal/{personal}', 'destroy')->name('personal.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Modulo Usuario
    |--------------------------------------------------------------------------
    */
    Route::controller(UsuarioController::class)->group(function () {
        Route::get('usuarios', 'index')->name('usuarios.index');
        Route::get('usuarios/create', 'create')->name('usuarios.create');
        Route::post('usuarios/store', 'store')->name('usuarios.store');
        Route::get('usuarios/{user}/asignarrole', 'asignarrolevista')->name('usuarios.asignarrolevista');
        Route::post('usuarios/{user}/asignarrole', 'asignarrole')->name('usuarios.asignarrole');
        Route::get('usuarios/{user}', 'show')->name('usuarios.show');
        Route::get('usuarios/{user}/edit', 'edit')->name('usuarios.edit');
        Route::put('usuarios/{user}', 'update')->name('usuarios.update');
        Route::delete('usuarios/{user}', 'destroy')->name('usuarios.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Modulo Roles
    |--------------------------------------------------------------------------
    */
    Route::controller(RoleController::class)->group(function () {
        Route::get('roles', 'index')->name('roles.index');
        Route::get('roles/create', 'create')->name('roles.create');
        Route::post('roles/store', 'store')->name('roles.store');
        Route::get('roles/{role}', 'show')->name('roles.show');
        Route::get('roles/{role}/edit', 'edit')->name('roles.edit');
        Route::put('roles/{role}', 'update')->name('roles.update');
        Route::delete('roles/{role}', 'destroy')->name('roles.destroy');
    });
});
