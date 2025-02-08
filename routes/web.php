<?php

//use Illuminate\Support\Facades\Auth;
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
