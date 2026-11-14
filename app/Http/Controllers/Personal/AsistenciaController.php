<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Personal Asistencias Listar', [
            'only' => ['index'],
        ]);

        $this->middleware('permission:Personal Asistencias Ver', [
            'only' => ['show'],
        ]);

        $this->middleware('permission:Personal Asistencias Generar Manualmente', [
            'only' => ['generar_manualmente'],
        ]);

        $this->middleware('permission:Personal Asistencias Crear Periodo', [
            'only' => ['crear_periodo'],
        ]);

        $this->middleware('permission:Personal rectificaciones', [
            'only' => ['rectificaciones'],
        ]);
    }

    public function index()
    {
        return view('personal.asistencias.index');
    }

    public function show($asistencia)
    {
        return view('personal.asistencias.show', compact('asistencia'));
    }

    public function generar_manualmente()
    {
        return view('personal.asistencias.generar-manualmente');
    }

    public function crear_periodo()
    {
        return view('personal.asistencias.crear-periodo');
    }

    public function rectificaciones()
    {
        return view('personal.asistencias.rectificaciones');
    }
}