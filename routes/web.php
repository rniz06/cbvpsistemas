<?php

//use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\CambiarContrasenaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Livewire\VotacionPublica;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});


//Auth::routes();
// Auth::routes([
//     'register' => false, // Desactivar route Register...
//     'reset' => false, // Desactivar route Reset Password...
//     'verify' => false, // Desactivar route Email Verification...
// ]);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
//Route::get('/mesas/pantalla', VotacionPublica::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // Implementa el middleware auth en el constructor

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
        Route::get('personal/exportar', 'exportar')->name('personal.exportar');
        Route::post('personal/agregar-contacto', 'agregarcontacto')->name('personal.agregarcontacto');
        Route::post('personal/agregar-contacto-emergencia', 'agregarcontactoemergencia')->name('personal.agregarcontactoemergencia');
        Route::get('personal/search', 'search')->name('personal.search'); // ruta para búsqueda AJAX
        Route::get('personal/{personal}', 'show')->name('personal.show');
        Route::get('personal/{personal}/edit', 'edit')->name('personal.edit');
        Route::put('personal/{personal}', 'update')->name('personal.update');
        Route::delete('personal/{personal}', 'destroy')->name('personal.destroy');
        Route::get('personal/ficha/{personal}', 'fichapdf')->name('personal.fichapdf');
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
        Route::get('usuarios/{user}/asignarpermiso', 'asignarpermisovista')->name('usuarios.asignarpermisovista');
        Route::post('usuarios/{user}/asignarpermiso', 'asignarpermiso')->name('usuarios.asignarpermiso');
        Route::get('usuarios/{user}', 'show')->name('usuarios.show');
        Route::get('usuarios/{user}/edit', 'edit')->name('usuarios.edit');
        Route::put('usuarios/{user}', 'update')->name('usuarios.update');
        Route::delete('usuarios/{user}', 'destroy')->name('usuarios.destroy');
        Route::get('/cambiar-contrasena', [CambiarContrasenaController::class, 'cambiarContrasena'])->name('cambiar-contrasena');
        Route::post('/actualizar-contrasena', [CambiarContrasenaController::class, 'updatePassword'])->name('actualizar-contrasena');
        Route::get('usuarios/{usuario}/resetear-contrasena', 'passwordreset')->name('usuarios.passwordreset');
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

    /*
    |--------------------------------------------------------------------------
    | Modulo Mesas asignarpersonalmesa
    |--------------------------------------------------------------------------
    */
    // Route::controller(MesaController::class)->group(function () {
    //     Route::get('mesas', 'index')->name('mesas.index');
    //     Route::get('mesas/asignarpersonalmesa', 'asignarpersonalmesa')->name('mesas.asignarpersonalmesa');
    //     Route::post('mesas/asignarpersonalmesa', 'asignarpersonalmesapost')->name('mesas.asignarpersonalmesapost');
    //     Route::get('mesas/{mesa}', 'show')->name('mesas.show');        
    // });
});
