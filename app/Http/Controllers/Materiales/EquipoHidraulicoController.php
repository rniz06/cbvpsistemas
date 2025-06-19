<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Models\Vistas\Materiales\VtHidraulico;
use App\Models\Vistas\Materiales\VtHidraulicoHerr;
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
        $this->middleware('permission:Equipos Hidraulicos Ver', ['only' => ['show', 'verCompania']]);
        $this->middleware('permission:Equipos Hidraulicos Herramientas Ver', ['only' => ['showHerramientas']]);
    }

    public function index()
    {
        return view('materiales.equipo-hidraulico.index');
    }

    public function show($hidraulico)
    {
        return view('materiales.equipo-hidraulico.ficha', compact('hidraulico'));
    }

    public function showHerramientas(VtHidraulico $hidraulico, VtHidraulicoHerr $herramienta)
    {
        return view('materiales.equipo-hidraulico.herramientas.ficha', compact('hidraulico', 'herramienta'));
    }

    public function verCompania($compania)
    {
        return view('materiales.equipo-hidraulico.ver-compania', compact('compania'));
    }
}
