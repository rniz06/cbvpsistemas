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
        $this->middleware('permission:Comisionamientos Crear', ['only' => ['create']]);
        $this->middleware('permission:Comisionamientos Editar', ['only' => ['edit']]);
        // $this->middleware('permission:Conductores Ver', ['only' => ['show']]);
        
    }

    public function index()
    {
        return view('personal.comisionamientos.index');
    }

    public function create()
    {
        return view('personal.comisionamientos.create');
    }

    public function edit($comisionamiento)
    {
        return view('personal.comisionamientos.edit', compact('comisionamiento'));
    }
}
