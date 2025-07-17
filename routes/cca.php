<?php

use App\Http\Controllers\Cca\DespachoController;
use App\Http\Controllers\Cca\DespachoPorCompaniaController;
use App\Http\Controllers\Cca\ReporteController;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | Rutas del modulo CCA
    |--------------------------------------------------------------------------
    */

Route::prefix('cca')->middleware('auth')->group(function () {

    // Rutas de Despachos
    Route::controller(DespachoController::class)
        ->prefix('despachos')
        ->group(function () {
            // Despachos por compania
            Route::get('/despacho-por-compania', 'despachoPorCompania')->name('cca.despacho.despacho-por-compania');
            Route::get('/despacho-por-compania-final/{compania}', 'despachoPorCompaniaFinal')->name('cca.despacho.despacho-por-compania-final');

            // Despachos por Servicio
            Route::get('/despacho-por-servicio', 'despachoPorServicio')->name('cca.despacho.despacho-por-servicio');
            Route::get('/despacho-por-servicio-add-compania/{servicio}', 'despachoPorServicioAddCompania')->name('cca.despacho.despacho-por-servicio-add-compania');
            Route::get('/despacho-por-servicio-final/{servicio}', 'despachoPorServicioFinal')->name('cca.despacho.despacho-por-servicio-final');

            Route::get('/ver-servicio/{servicio}', 'verServicio')->name('cca.despacho.ver-servicio');
            Route::get('/servicios-activos', 'serviciosActivos')->name('cca.despacho.servicios-activos');
        });

        // Rutas de Reportes
    Route::controller(ReporteController::class)
        ->prefix('reportes')
        ->group(function () {
            Route::get('/historico', 'historico')->name('cca.reportes.historico');
            Route::get('/graficos-por-compania', 'graficosPorCompania')->name('cca.reportes.graficos-por-compania');
        });
});
