<?php

namespace App\Http\Controllers;

use App\Http\Requests\Materiales\Conductores\StoreConductorRequest;
use App\Http\Requests\Materiales\Conductores\UpdateConductorRequest;
use App\Models\Ciudad;
use App\Models\Materiales\Conductor\ClaseLicencia;
use App\Models\Materiales\Conductor\ConductorBombero;
use App\Models\Materiales\Conductor\Estado;
use App\Models\Materiales\Conductor\TipoVehiculo;
use App\Models\Vistas\Materiales\VtConductor;
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
        $this->middleware('permission:Conductores Editar', ['only' => ['edit', 'update']]);
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

    public function show(VtConductor $conductor)
    {
        return view('materiales.conductores.show', compact('conductor'));
    }

    public function edit(VtConductor $conductor)
    {
        $ciudades = Ciudad::select('idciudades', 'ciudad')->orderBy('ciudad')->get();
        $tipoVehiculos = TipoVehiculo::select('idconductor_tipo_vehiculo', 'tipo')->get();
        $licencias = ClaseLicencia::select('idconductor_clase_licencia', 'clase')->get();
        $estados = Estado::select('id_conductor_estado', 'estado')->get();
        return view('materiales.conductores.edit', compact('conductor', 'ciudades', 'tipoVehiculos', 'licencias', 'estados'));
    }

    public function update(UpdateConductorRequest $request, ConductorBombero $conductor)
    {
        $conductor->update([
            'estado_id' => $request->estado_id, // Activo por defecto
            'resolucion' => $request->resolucion,
            'resolucion_enlace' => $request->resolucion_enlace,
            'fecha_curso' => $request->fecha_curso,
            'ciudad_curso_id' => $request->ciudad_curso_id,
            'ciudad_licencia_id' => $request->ciudad_licencia_id,
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'numero_licencia' => $request->numero_licencia,
            'clase_licencia_id' => $request->clase_licencia_id,
        ]);
        return redirect()->route('conductores.index')->with('success', 'Ficha de Conductor Actualizado Correctamente');
    }

    // public function destroy(ConductorBombero $conductor)
    // {
    //     $conductor->delete();
    //     return redirect()->route('conductores.index')
    //         ->with('success', 'Ficha de conductor eliminada correctamente');
    // }
}
