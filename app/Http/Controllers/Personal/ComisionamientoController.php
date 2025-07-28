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
        $this->middleware('permission:Comisionamietnos Listar', ['only' => ['index']]);
        $this->middleware('permission:Comisionamietnos Crear', ['only' => ['create']]);
        // $this->middleware('permission:Conductores Ver', ['only' => ['show']]);
        // $this->middleware('permission:Conductores Editar', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        return view('personal.comisionamientos.index');
    }

    public function create()
    {
        return view('personal.comisionamientos.create');
    }
}
