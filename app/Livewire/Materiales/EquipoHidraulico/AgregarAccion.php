<?php

namespace App\Livewire\Materiales\EquipoHidraulico;

use App\Actions\Materiales\Hidraulicos\PasarHerramientaAInoperativo;
use App\Actions\Materiales\Hidraulicos\PasarHerramientaOpetativo;
use App\Models\Materiales\Accion;
use App\Models\Materiales\EquipoHidraulico\Comentario;
use App\Models\Materiales\EquipoHidraulico\Herramienta;
use App\Models\Materiales\EquipoHidraulico\Hidraulico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AgregarAccion extends Component
{
    public int $hidraulico_id;
    public string $accion_id = '';
    public string $comentario = '';
    public $herramientaSeleccionada = null;
    public $herramientas = [];

    # CONSTANTES DE ACCIONES
    const ACCION_EN_SERVICIO    = 1;
    const ACCION_FUERA_SERVICIO = 2;
    const ACCION_NOVEDAD        = 3;

    const OPERATIVIDAD_INOPERATIVO = 0;
    const OPERATIVIDAD_OPERATIVO   = 1;

    const HERRAMIENTA_SOLO_EQUIPO = 0; // AFECTAR SOLO HIDRAULICO, NO LAS HERRAMIENTAS

    protected function rules(): array
    {
        $rules = [
            'hidraulico_id' => ['required', Rule::exists(Hidraulico::class, 'id_hidraulico')],
            'accion_id'     => ['required', Rule::exists(Accion::class, 'id_accion')],
            'comentario'    => ['required', 'string', 'max:65535'],
        ];

        # SI LA ACCION REQUIERE SELECCION DE HERRAMIENTA, VALIDARLA
        if (in_array($this->accion_id, [self::ACCION_EN_SERVICIO, self::ACCION_FUERA_SERVICIO])) {
            $rules['herramientaSeleccionada'] = [
                'required',
                Rule::in(
                    array_merge(
                        [self::HERRAMIENTA_SOLO_EQUIPO],
                        $this->herramientas->pluck('id_hidraulico_herr')->toArray()
                    )
                ),
            ];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'accion_id.required'              => 'Debe seleccionar una acción.',
            'comentario.required'             => 'El comentario es obligatorio.',
            'comentario.max'                  => 'El comentario no puede superar los 65.535 caracteres.',
            'herramientaSeleccionada.required' => 'Debe seleccionar una herramienta o la opción de solo marcar equipo.',
        ];
    }

    public function mount(int $hidraulico_id): void
    {
        $this->hidraulico_id = $hidraulico_id;
    }

    public function updatedAccionId(string $value): void
    {
        # RESETEAR SELECCION AL CAMBIAR DE ACCION
        $this->herramientaSeleccionada = null;
        $this->herramientas = collect();

        $query = Herramienta::select('id_hidraulico_herr', 'tipo_id')
            ->where('hidraulico_id', $this->hidraulico_id)
            ->with(['tipo:idhidraulico_herr_tipo,tipo']);

        match ((int) $value) {
            self::ACCION_EN_SERVICIO    => $this->herramientas = $query->where('operatividad_id', self::OPERATIVIDAD_INOPERATIVO)->get(),
            self::ACCION_FUERA_SERVICIO => $this->herramientas = $query->get(),
            default                     => null,
        };
    }

    public function guardar(PasarHerramientaOpetativo $actionOperativo, PasarHerramientaAInoperativo $actionInoperativo): void
    {
        $this->validate();

        $hidraulico = Hidraulico::findOrFail($this->hidraulico_id);

        match ((int) $this->accion_id) {
            self::ACCION_EN_SERVICIO    => $this->procesarEnServicio($hidraulico, $actionOperativo),
            self::ACCION_FUERA_SERVICIO => $this->procesarFueraDeServicio($hidraulico, $actionInoperativo),
            default                     => null,
        };

        Comentario::create([
            'hidraulico_id' => $this->hidraulico_id,
            'accion_id'     => $this->accion_id,
            'comentario'    => $this->comentario,
            'creadoPor'     => Auth::id(),
        ]);

        session()->flash('success', 'Comentario guardado exitosamente.');

        $this->redirectRoute('materiales.hidraulicos.show', ['hidraulico' => $this->hidraulico_id]);
    }

    public function render()
    {
        return view('livewire.materiales.equipo-hidraulico.agregar-accion');
    }

    # --- Métodos privados ---

    private function procesarEnServicio(Hidraulico $hidraulico, PasarHerramientaOpetativo $action): void
    {
        // VERIFICAR SI QUEDAN HERRAMIENTAS INOPERATIVAS (EXCLUYENDO LA QUE SE ESTÁ PASANDO A OPERATIVO)
        $quedanInoperativas = Herramienta::where('id_hidraulico_herr', '!=', $this->herramientaSeleccionada)
            ->where('hidraulico_id', $this->hidraulico_id)
            ->where('operatividad_id', self::OPERATIVIDAD_INOPERATIVO)
            ->exists();

        if (!$quedanInoperativas) {
            $hidraulico->update(['operatividad_id' => self::OPERATIVIDAD_OPERATIVO]);
        }

        if ($this->herramientaEsValida()) {
            $action->handle((int) $this->herramientaSeleccionada);
        }
    }

    private function procesarFueraDeServicio(Hidraulico $hidraulico, PasarHerramientaAInoperativo $action): void
    {
        $hidraulico->update(['operatividad_id' => self::OPERATIVIDAD_INOPERATIVO]);

        if ($this->herramientaEsValida()) {
            $action->handle((int) $this->herramientaSeleccionada);
        }
    }

    private function herramientaEsValida(): bool
    {
        return !empty($this->herramientaSeleccionada)
            && (int) $this->herramientaSeleccionada !== self::HERRAMIENTA_SOLO_EQUIPO;
    }
}
