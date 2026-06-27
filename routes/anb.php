<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ANB\ECB\LlamadoController;
use App\Http\Controllers\ANB\ECB\AspiranteController;
use App\Http\Controllers\ANB\ECB\ExamenFisicoController;
use App\Http\Controllers\ANB\ECB\ExamenFisicoParametroController;
use App\Http\Controllers\ANB\ECB\ExamenFisicoPruebaController;
use App\Http\Controllers\ANB\ECB\PsicoBaremoController;
use App\Http\Controllers\ANB\ECB\PsicoCorreccionController;
use App\Http\Controllers\ANB\ECB\PsicoMotorController;
use App\Http\Controllers\ANB\ECB\PsicoTestController;
use App\Http\Controllers\ANB\ECB\PsicoPreguntaController;
use App\Http\Controllers\ANB\ECB\PsicoOpcionController;
use App\Http\Controllers\ANB\ECB\PsicoPortalController;
use App\Http\Controllers\ANB\ECB\ReportesController;

Route::prefix('anb')
->name('anb.')
->group(function(){

    Route::prefix('ecb')
    ->name('ecb.')
    ->group(function(){

        Route::get('/llamados',[LlamadoController::class,'index'])
            ->name('llamados.index');

        Route::get('/aspirantes',[AspiranteController::class,'index'])
            ->name('aspirantes.index');

        Route::get('/aspirantes/{aspirante}',[AspiranteController::class,'show'])
        ->name('aspirantes.show');

        Route::get('/examenes-fisicos',[ ExamenFisicoController::class,'index'])
        ->name('examenes-fisicos.index');

        Route::get('/examenes-fisicos/{examen}/pruebas',[ ExamenFisicoPruebaController::class,'index'])
        ->name('examenes-fisicos.pruebas.index');

        Route::get('/examenes-fisicos/pruebas/{prueba}/parametros',[ ExamenFisicoParametroController::class,'index'])
        ->name('examenes-fisicos.parametros.index');

        Route::get('/psico-tests',[PsicoTestController::class,'index'])
        ->name('psico-tests.index');

        Route::get('/psico-tests/{test}/preguntas',[PsicoPreguntaController::class,'index'])
        ->name('psico-tests.preguntas.index');

        Route::get(
            '/psico-tests/{test}/motor',
            [PsicoMotorController::class,'index']
        )->name('psico-tests.motor.index');
        Route::get(
            '/psico-tests/{test}/baremos',
            [PsicoBaremoController::class,'index']
        )->name('psico-tests.baremos.index');

        Route::get('/psico-preguntas/{pregunta}/opciones',[PsicoOpcionController::class,'index'])
        ->name('psico-tests.opciones.index');        

        Route::get('/evaluacion-psicologica',[PsicoPortalController::class,'index'])
        ->name('psico.portal');   
        
    });

    Route::prefix('ecb/reportes')
    ->name('ecb.reportes.')
    ->group(function () {

        Route::get(
            '/',
            [ReportesController::class, 'index']
        )->name('index');

        Route::get(
            '/aspirantes-medicos',
            [ReportesController::class, 'aspirantesMedicos']
        )->name('aspirantes-medicos');

        Route::get(
            '/examenes-fisicos',
            [ReportesController::class, 'examenesFisicos']
        )->name('examenes-fisicos');

        Route::get(
            '/psicologicos',
            [ReportesController::class, 'psicologicos']
        )->name('psicologicos');
    });

});