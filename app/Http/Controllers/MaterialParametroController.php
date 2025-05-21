<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialParametroController extends Controller
{
    public function index()
    {
        return view('materiales.parametros.index');    
    }

    public function transmision()
    {
        return view('materiales.mayor.transmision');    
    }

    public function ejes()
    {
        return view('materiales.mayor.ejes');    
    }

    public function combustibles()
    {
        return view('materiales.mayor.combustibles');    
    }

    public function acronimos()
    {
        return view('materiales.mayor.acronimos');    
    }

    public function marcas()
    {
        return view('materiales.mayor.marcas');    
    }

    public function modelos($marca)
    {
        return view('materiales.mayor.modelos', compact('marca'));    
    }

    public function hidraulicoMotores()
    {
        return view('materiales.equipo-hidraulico.motor');    
    }

    public function hidraulicoMarcas()
    {
        return view('materiales.equipo-hidraulico.marcas');    
    }

    public function hidraulicoModelos($marca)
    {
        return view('materiales.equipo-hidraulico.modelos', compact('marca'));    
    }

    public function hidraulicoHerramientasMotores()
    {
        return view('materiales.equipo-hidraulico.herramientas.motor');    
    }

    public function hidraulicoHerramientasMarcas()
    {
        return view('materiales.equipo-hidraulico.herramientas.marcas');    
    }

    public function hidraulicoHerramientasModelos($marca)
    {
        return view('materiales.equipo-hidraulico.herramientas.modelos', compact('marca'));    
    }

    public function hidraulicoHerramientasTipos()
    {
        return view('materiales.equipo-hidraulico.herramientas.tipos');    
    }
}
