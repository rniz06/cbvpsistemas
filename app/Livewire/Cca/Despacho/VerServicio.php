<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Comentario;
use App\Models\Cca\Servicios\Enganchado;
use App\Models\Cca\Servicios\Existente;
use App\Models\Vistas\Cca\VtExistente;
use App\Services\Cca\Servicio\FalsaAlarmaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class VerServicio extends Component
{
    public $servicio, $serviciosEnganchados, $mostrarFormAgregarDetalle = false;

    public $km_final = null, $desperfecto = false;

    public $servicioPadre;

    public function rules()
    {
        return [
            'km_final' => $this->desperfecto ? 'nullable' : 'required|numeric|min_digits:1|max_digits:11',
        ];
    }

    public function mount(VtExistente $servicio)
    {
        $this->servicio = $servicio;

        $idServicio = $servicio->id_servicio_existente;

        // Identificar el servicio padre de la cadena
        $padreId = Enganchado::where('servicio_actual_id', $idServicio)
            ->value('servicio_padre_id') ?? $idServicio;

        // Obtener todos los servicios de la cadena
        $this->serviciosEnganchados = Enganchado::with([
            'anterior.servicio',
            'actual.servicio',
        ])
            ->where('servicio_padre_id', $padreId)
            ->get()
            ->sortBy(fn($enganche) => $enganche->actual?->fecha_alfa)
            ->values();

        // Incluir el servicio original
        $this->servicioPadre = Existente::with('servicio')
            ->find($padreId);
    }


    public function guardarDetalles()
    {
        $this->validate();

        DB::transaction(function () {

            $datos = [
                'km_final'    => $this->km_final,
                'desperfecto' => $this->desperfecto,
                'fecha_base'  => now(),
                'estado_id'   => 4, // Servicio Culminado
            ];

            $idServicioActual = $this->servicio->id_servicio_existente;

            // Servicios que deben culminarse
            $serviciosIds = collect([$idServicioActual]);

            // Servicios pendientes de recorrer
            $pendientes = collect([$idServicioActual]);

            // Evitar ciclos y registros duplicados
            while ($pendientes->isNotEmpty()) {

                $enganchar = Enganchado::whereIn(
                    'servicio_actual_id',
                    $pendientes
                )->get();

                $nuevosPendientes = collect();

                foreach ($enganchar as $enganche) {

                    // Marcar el enganche como culminado
                    if (!$enganche->culminado) {
                        $enganche->update([
                            'culminado' => true,
                        ]);
                    }

                    $idAnterior = $enganche->servicio_anterior_id;

                    // Agregar solamente servicios no procesados
                    if (!$serviciosIds->contains($idAnterior)) {
                        $serviciosIds->push($idAnterior);
                        $nuevosPendientes->push($idAnterior);
                    }
                }

                $pendientes = $nuevosPendientes;
            }

            // Actualizar individualmente cada servicio.
            // Esto permite ejecutar los eventos de Eloquent
            // y registrar cada modificación mediante Laravel Auditing.
            foreach ($serviciosIds as $id) {

                $existente = Existente::findOrFail($id);

                $existente->update($datos);
            }
        });

        $mensaje = is_null($this->km_final)
            ? "10.77 y Móvil en Base Asignado Correctamente!"
            : "Kilometraje Final y Móvil en Base Asignado Correctamente!";

        return redirect()->route('cca.despacho.ver-servicio', [
            'servicio' => $this->servicio->id_servicio_existente,
        ])->with('success', $mensaje);
    }


    // Deshabilita el input desperfecto
    public function btndesperfecto()
    {
        $this->desperfecto = !$this->desperfecto;
        if ($this->desperfecto) {
            $this->km_final = null;
        }
    }

    public function horaAccion($accion, $servicioId)
    {
        $servicio =  Existente::findOrFail($servicioId);
        switch ($accion) {
            case '1':
                $servicio->update([
                    'fecha_cia' => now(),
                ]);
                $mensaje = 'Llegada de Cia Accionada Correctamente!';
                break;

            case '2':
                $servicio->update([
                    'fecha_movil' => now(),
                ]);
                $mensaje = 'Salida de Móvil Accionada Correctamente!';
                break;

            case '3':
                $servicio->update([
                    'fecha_servicio' => now(),
                ]);
                $mensaje = 'Llegada de Móvil Accionada Correctamente!';
                break;

            case '4':
                $servicio->update([
                    'fecha_base' => now(),
                    'estado_id' => 4, // Servicio Culminado
                ]);
                $mensaje = 'Móvil en base Accionada Correctamente!';
                break;
        }

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente])
            ->with('success', $mensaje);
    }

    public function render()
    {
        return view('livewire.cca.despacho.ver-servicio');
    }

    # FUNCIONES ADICIONALES

    public function falsaAlarma(FalsaAlarmaService $servicio)
    {
        try {
            $servicio->handle($this->servicio->id_servicio_existente);

            session()->flash('success', 'CORRECTAMENTE DECLARADA COMO FALSA ALARMA!');
        } catch (\Exception $e) {
            session()->flash(
                'error',
                'NO SE PUDO DECLARAR COMO FALSA ALARMA - ' . $e->getMessage()
            );
        }

        return redirect()->route('cca.despacho.ver-servicio', ['servicio' => $this->servicio->id_servicio_existente]);
    }
}
