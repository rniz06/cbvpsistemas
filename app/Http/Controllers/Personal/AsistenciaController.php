<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Personal Asistencias Listar', ['only' => ['index']]);
        // $this->middleware('permission:Comisionamientos Crear', ['only' => ['create']]);
        // $this->middleware('permission:Comisionamientos Editar', ['only' => ['edit']]);
        $this->middleware('permission:Personal Asistencias Ver', ['only' => ['show']]); 
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
}
