<?php

namespace App\Http\Controllers\Materiales\Menor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Materiales Menor Componentes Listar', ['only' => ['index']]);
        $this->middleware('permission:Materiales Menor Componentes Listar', ['only' => ['indexForestales']]);
    }

    public function index()
    {
        return view('materiales.menor.componentes.index');
    }

    public function indexForestales()
    {
        return view('materiales.menor.componentes.index-forestales');
    }
}
