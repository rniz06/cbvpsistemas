<?php

namespace App\Livewire\Cca\Despacho;

use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Enganchado;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Gral\Ciudad;
use App\Models\Vistas\Materiales\VtMayor;
use App\Services\Cca\Despacho\RegistrarEstadoDeMovilAlDespachar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DespachoEnganchado extends Component
{
    public $servicio; // SERVICIO DESDE EL CUAL SE ENGANCHA

    // Propiedades para los select de las vistas
    public $servicios, $clasificaciones, $ciudades, $moviles, $acargoDetalles;

    // Propiedades para el formulario
    #[Validate]
    public $servicio_id, $clasificacion_id, $informacion_servicio, $ciudad_id, $calle_referencia;
    public $movil_id, $acargo, $acargo_rentado = false, $chofer, $chofer_rentado = false;

    public function mount($servicioId)
    {
        $this->servicio = Existente::findOrFail($servicioId);

        $this->servicios = Servicio::select('id_servicio', 'servicio')->get();
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->where('servicio_id', $this->servicio_id)
            ->get();
        $this->ciudades = Ciudad::select('id_ciudad', 'ciudad')->get();
        // $this->moviles = VtMayor::select('id_movil', 'movil', 'tipo')
        //     ->where([['compania_id', $servicio->compania_id], ['operativo', 1]])->get();
    }

    public function updatedServicioId($value)
    {
        $this->clasificaciones = Clasificacion::select('id_servicio_clasificacion', 'clasificacion', 'servicio_id')
            ->when($value, function ($query) use ($value) {
                return $query->where('servicio_id', $value);
            })
            ->get();
        $this->clasificacion_id = '';
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'servicio_id' => ['required', Rule::exists(Servicio::class, 'id_servicio')],
            'clasificacion_id' => ['required', Rule::exists(Clasificacion::class, 'id_servicio_clasificacion')],
            'informacion_servicio' => ['required', 'min:2', 'max:255'],
            'ciudad_id' => ['required', Rule::exists(Ciudad::class, 'id_ciudad')],
            'calle_referencia' => ['required', 'min:2', 'max:255'],
        ];
    }


    public function grabar()
    {
        $this->validate();

        $servicio = DB::transaction(function () {

            $idServicioAnterior = $this->servicio->id_servicio_existente;

            // Buscar si el servicio anterior ya pertenece
            // a una cadena de enganches.
            $servicioPadreId = Enganchado::where(
                'servicio_actual_id',
                $idServicioAnterior
            )->value('servicio_padre_id');

            // Si no pertenece a otra cadena, él mismo será el padre.
            $servicioPadreId ??= $idServicioAnterior;

            $servicio = Existente::create([
                'informacion_servicio' => $this->informacion_servicio,
                'calle_referencia' => $this->calle_referencia,
                'cantidad_tripulantes' => $this->servicio->cantidad_tripulantes,
                'compania_id' => $this->servicio->compania_id,
                'servicio_id' => $this->servicio_id,
                'clasificacion_id' => $this->clasificacion_id,
                'ciudad_id' => $this->ciudad_id,
                'movil_id' => $this->servicio->movil_id,
                'acargo' => $this->servicio->acargo,
                'acargo_aux' => $this->servicio->acargo_aux,
                'acargo_rentado' => $this->servicio->acargo_rentado,
                'chofer' => $this->servicio->chofer,
                'chofer_aux' => $this->servicio->chofer_aux,
                'chofer_rentado' => $this->servicio->chofer_rentado,
                'estado_id' => 3,
                'fecha_cia' => now(),
                'fecha_movil' => now(),
                'creadoPor' => Auth::id(),
            ]);

            // Registrar el enganche y su servicio padre.
            Enganchado::create([
                'servicio_anterior_id' => $idServicioAnterior,
                'servicio_actual_id' => $servicio->id_servicio_existente,
                'servicio_padre_id' => $servicioPadreId,
            ]);

            // Cambiar estado del servicio anterior.
            $this->servicio->update([
                'estado_id' => 5, // Enganchado
            ]);

            // Registrar el estado del móvil.
            app(RegistrarEstadoDeMovilAlDespachar::class)
                ->ejecutar(
                    $servicio->id_servicio_existente,
                    $servicio->movil_id
                );

            return $servicio;
        });

        return redirect()->route('cca.despacho.ver-servicio', [
            'servicio' => $servicio->id_servicio_existente,
        ])->with('success', 'Servicio Despachado Correctamente!');
    }


    public function render()
    {
        return view('livewire.cca.despacho.despacho-enganchado');
    }
}
