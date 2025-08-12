<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComisionamientoController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Comisionamientos Listar', ['only' => ['index']]);
        $this->middleware('permission:Comisionamientos Crear', ['only' => ['createAutoridad', 'createComisionado']]);
        $this->middleware('permission:Comisionamientos Editar', ['only' => ['edit']]);
    }

    public function index()
    {
        return view('personal.comisionamientos.index');
    }

    public function createAutoridad()
    {
        return view('personal.comisionamientos.create-autoridad');
    }

    public function createComisionamiento()
    {
        return view('personal.comisionamientos.create-comisionado');
    }

    public function edit($comisionamiento)
    {
        return view('personal.comisionamientos.edit', compact('comisionamiento'));
    }
}
