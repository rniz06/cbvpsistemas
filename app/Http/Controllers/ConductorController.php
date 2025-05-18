<?php

namespace App\Http\Controllers;

use App\Http\Requests\Materiales\Conductores\StoreConductorRequest;
use App\Models\Ciudad;
use App\Models\Conductor\ClaseLicencia;
use App\Models\Conductor\ConductorBombero;
use App\Models\Conductor\TipoVehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConductorController extends Controller
{
    /**
     * Establece los middleware necesarios para gestionar permisos
     * Se utilizan permisos específicos para cada acción del controlador.
     */
    function __construct()
    {
        $this->middleware('permission:Conductores Listar', ['only' => ['index']]);
        $this->middleware('permission:Conductores Crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:Conductores Ver', ['only' => ['show']]);
    }

    public function index()
    {
        return view('materiales.conductores.index');
    }

    public function create()
    {
        $ciudades = Ciudad::select('idciudades', 'ciudad')->orderBy('ciudad')->get();
        $tipoVehiculos = TipoVehiculo::select('idconductor_tipo_vehiculo', 'tipo')->get();
        $licencias = ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get();
        return view('materiales.conductores.create', compact('ciudades', 'tipoVehiculos', 'licencias'));
    }

    public function store(StoreConductorRequest $request)
    {
        ConductorBombero::create([
            'personal_id' => $request->personal_id,
            'estado_id' => 1, // Activo por defecto
            'resolucion' => $request->resolucion,
            'resolucion_enlace' => $request->resolucion_enlace,
            'fecha_curso' => $request->fecha_curso,
            'ciudad_curso_id' => $request->ciudad_curso_id,
            'ciudad_licencia_id' => $request->ciudad_licencia_id,
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'numero_licencia' => $request->numero_licencia,
            'clase_licencia_id' => $request->clase_licencia_id,
            'creadoPor' => Auth::id()
        ]);
        return redirect()->route('conductores.index')->with('success', 'Conductor Registrado Correctamente');
    }
}
