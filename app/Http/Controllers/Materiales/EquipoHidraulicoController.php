<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipoHidraulicoController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Equipos Hidraulicos Listar', ['only' => ['index']]);
        $this->middleware('permission:Equipos Hidraulicos Ver', ['only' => ['show']]);
    }

    public function index()
    {
        return view('materiales.equipo-hidraulico.index');
    }

    public function show($hidraulico)
    {
        return view('materiales.equipo-hidraulico.show');
    }
}
