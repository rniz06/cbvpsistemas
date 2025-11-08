<?php

use App\Http\Controllers\Materiales\ConductorController;
use App\Http\Controllers\Materiales\EquipoHidraulicoController;
use App\Http\Controllers\Materiales\Mayor\ReporteController;
use App\Http\Controllers\Materiales\MayorController;
use App\Http\Controllers\MaterialParametroController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas del modulo Materiales
|--------------------------------------------------------------------------
*/

// RUTAS ESTATICAS DE PARAMETROS
Route::controller(MaterialParametroController::class)
    ->middleware('auth')
    ->prefix('materiales')
    ->group(function () {
        Route::get('/', 'index')->name('materiales.index');
        Route::get('parametros', 'indexParametros')->name('materiales.parametros');

        // MAYOR
        Route::get('mayor/transmision', 'transmision')->name('materiales.mayor.transmision');
        Route::get('mayor/ejes', 'ejes')->name('materiales.mayor.ejes');
        Route::get('mayor/combustibles', 'combustibles')->name('materiales.mayor.combustibles');
        Route::get('mayor/acronimos', 'acronimos')->name('materiales.mayor.acronimos');
        Route::get('mayor/marcas', 'marcas')->name('materiales.mayor.marcas');
        Route::get('mayor/marcas/{marca}/modelos', 'modelos')->name('materiales.mayor.modelos');

        // HIDRAULICO
        Route::get('equipo-hidraulico/motores', 'hidraulicoMotores')->name('materiales.hidraulico.motor');
        Route::get('equipo-hidraulico/marcas', 'hidraulicoMarcas')->name('materiales.hidraulico.marcas');
        Route::get('equipo-hidraulico/marcas/{marca}/modelos', 'hidraulicoModelos')->name('materiales.hidraulico.modelos');

        // HIDRAULICO HERRAMIENTA
        Route::get('equipo-hidraulico/herramientas/motores', 'hidraulicoHerramientasMotores')->name('materiales.hidraulico.herramientas.motor');
        Route::get('equipo-hidraulico/herramientas/marcas', 'hidraulicoHerramientasMarcas')->name('materiales.hidraulico.herramientas.marcas');
        Route::get('equipo-hidraulico/herramientas/marcas/{marca}/modelos', 'hidraulicoHerramientasModelos')->name('materiales.hidraulico.herramientas.modelos');
        Route::get('equipo-hidraulico/herramientas/tipos', 'hidraulicoHerramientasTipos')->name('materiales.hidraulico.herramientas.tipos');
    });

// FIN

// RUTAS CON PARAMETROS DE MATERIAL MAYOR
Route::controller(MayorController::class)->middleware('auth')->prefix('materiales/mayor')->group(function () {
    Route::get('/', 'index')->name('materiales.mayor.index');
    Route::get('ver-compania/{compania}', 'verCompania')->name('materiales.mayor.ver-compania');
    Route::get('{movil}', 'show')
        ->where('movil', '[0-9]+') // <-- restringe para que no tome textos como "transmision"
        ->name('materiales.mayor.show');
    Route::get('servicios-por-movil/{movil}', 'serviciosPorMovil')
        ->where('movil', '[0-9]+') // <-- restringe para que no tome textos como "transmision"
        ->name('materiales.mayor.servicios-por-movil');
});

// FIN

// RUTAS CON PARAMETROS DE EQUIPO HIDRAULICO
Route::controller(EquipoHidraulicoController::class)->middleware('auth')->prefix('materiales/equipo-hidraulico')->group(function () {
    Route::get('/', 'index')->name('materiales.hidraulicos.index');
    Route::get('/ver-compania/{compania}', 'verCompania')->name('materiales.hidraulicos.ver-compania');
    Route::get('{hidraulico}', 'show')
        ->where('hidraulico', '[0-9]+') // <-- restringe para que no tome textos como "transmision"
        ->name('materiales.hidraulicos.show');
    Route::get('{hidraulico}/herramienta/{herramienta}', 'showHerramientas')
        ->where('hidraulico', '[0-9]+') // <-- restringe para que no tome textos como "transmision"
        ->name('materiales.hidraulicos.herramientas.show');
});


/*
|--------------------------------------------------------------------------
| RUTAS AGRUPADAS DEL MODULO MATERIALES || FALTA ADECUAR 
|--------------------------------------------------------------------------
*/

Route::prefix('materiales')->name('materiales.')->middleware('auth')->group(function () {

    // RUTAS DEL MODULO CONDUCTORES

    Route::controller(ConductorController::class)->prefix('conductores')->group(function () {
        Route::get('/', 'index')->name('conductores.index');
        Route::get('/create', 'create')->name('conductores.create');
        Route::get('/{conductor}', 'show')->name('conductores.show');
        Route::get('/{conductor}/edit', 'edit')->name('conductores.edit');
    });

    // FIN 

    // RUTAS DEL MAYOR REPORTES

    Route::controller(ReporteController::class)->prefix('/mayor/reportes')->name('mayor.reportes.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/general', 'general')->name('general');
        Route::get('/inoperativos', 'inoperativos')->name('inoperativos');
    });

    // FIN 
});
