<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Conductores Listar', ['only' => ['index']]);
        $this->middleware('permission:Conductores Crear', ['only' => ['create']]);
        //$this->middleware('permission:Conductores Ver', ['only' => ['show']]);
        //$this->middleware('permission:Conductores Editar', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        return view('materiales.conductores.index');
    }

    public function create()
    {
        return view('materiales.conductores.create');
    }
}
