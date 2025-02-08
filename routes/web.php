<?php

//use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PersonalController;
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
});
