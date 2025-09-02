<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Cargos Listar', ['only' => ['index']]);
    }

    public function index()
    {
        return view('personal.cargos.index');
    }
}
