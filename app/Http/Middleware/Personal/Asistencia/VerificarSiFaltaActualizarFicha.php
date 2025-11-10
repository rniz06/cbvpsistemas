<?php

namespace App\Http\Middleware\Personal\Asistencia;

use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Detalle;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarSiFaltaActualizarFicha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $asistenciaId = $request->route('asistencia');

        if ($asistenciaId) {
            // Verificar si existen fichas sin actualizar solo de esa asistencia
            $pendiente = Detalle::where('asistencia_id', $asistenciaId)
                ->whereRelation('personal', 'estado_actualizar_id', 1)
                ->exists();

            // Si es SuperAdmin, permitir el acceso pero mostrar alerta si hay pendientes
            if ($user && $user->hasRole('SuperAdmin')) {
                if ($pendiente) {
                    session()->flash('danger', 'EXISTEN FICHAS NO ACTUALIZADAS.');
                }
                return $next($request);
            }

            // Si no es SuperAdmin y hay fichas pendientes, bloquear el acceso
            if ($pendiente) {
                return redirect()
                    ->route('personal.index')
                    ->with('danger', 'EXISTEN FICHAS NO ACTUALIZADAS.');
            }
        }

        return $next($request);
    }
}
