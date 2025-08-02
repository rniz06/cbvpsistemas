<?php

namespace App\Livewire\Materiales\Mayor;

use App\Models\Materiales\Movil\Acronimo;
use App\Models\Materiales\Movil\Combustible;
use App\Models\Materiales\Movil\Eje;
use App\Models\Materiales\Movil\Marca;
use App\Models\Materiales\Movil\Modelo;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\MovilComentario;
use App\Models\Materiales\Movil\Transmision;
use App\Models\Vistas\Materiales\VtMayor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FichaEditar extends Component
{
    public $movil_id;
    public $movilRegistro;

    #[Validate]
    public $marca_id, $modelo_id, $movil_tipo_id, $movil, $anho, $chasis, $transmision_id, $eje_id, $cubiertas_frente, $cubiertas_atras, $combustible_id, $chapa;

    public function mount($movil_id)
    {
        $this->movil_id = $movil_id;
        $this->movilRegistro = VtMayor::findOrFail($movil_id);

        // Asignar valores a las propiedades públicas
        $this->marca_id = $this->movilRegistro->marca_id;
        $this->modelo_id = $this->movilRegistro->modelo_id;
        $this->movil_tipo_id = $this->movilRegistro->movil_tipo_id;
        $this->movil = $this->movilRegistro->movil;
        $this->anho = $this->movilRegistro->anho;
        $this->chasis = $this->movilRegistro->chasis;
        $this->transmision_id = $this->movilRegistro->transmision_id;
        $this->eje_id = $this->movilRegistro->eje_id;
        $this->cubiertas_frente = $this->movilRegistro->cubiertas_frente;
        $this->cubiertas_atras = $this->movilRegistro->cubiertas_atras;
        $this->combustible_id = $this->movilRegistro->combustible_id;
        $this->chapa = $this->movilRegistro->chapa;
    }

    // Reglas de validación
    protected function rules()
    {
        return [
            'marca_id' => ['required', 'exists:MAT_moviles_marcas,id_movil_marca'],
            'modelo_id' => ['required', 'exists:MAT_moviles_modelos,id_movil_modelo'],
            'movil_tipo_id' => ['required', 'exists:MAT_moviles_tipos,id_movil_tipo'],
            'movil' => ['required', 'min:2', 'max:5'],
            'anho' => ['required', 'numeric', 'min_digits:4', 'max_digits:4'],
            // 'chasis' => ['required', Rule::unique(Movil::class, 'chasis')->ignore($this->movil_id, 'id_movil')],
            'transmision_id' => ['required', 'exists:MAT_moviles_transmision,id_movil_transmision'],
            'eje_id' => ['required', 'exists:MAT_moviles_ejes,id_movil_eje'],
            'cubiertas_frente' => ['required', 'max:15'],
            'cubiertas_atras' => ['required', 'max:15'],
            'combustible_id' => ['required', 'exists:MAT_moviles_combustibles,id_movil_combustible'],
            'chapa' => [
                'required',
                function ($attribute, $value, $fail) {
                    $valoresPermitidos = ['SIN DATOS'];
                    if (!in_array(strtoupper(trim($value)), $valoresPermitidos)) {
                        $existe = Movil::where('chapa', $value)
                            ->where('id_movil', '!=', $this->movil_id)
                            ->exists();
                        if ($existe) {
                            $fail('El valor del campo chapa ya está registrado en otro móvil.');
                        }
                    }
                }
            ],
            'chasis' => [
                'required',
                function ($attribute, $value, $fail) {
                    $valoresPermitidos = ['SIN DATOS'];
                    if (!in_array(strtoupper(trim($value)), $valoresPermitidos)) {
                        $existe = Movil::where('chasis', $value)
                            ->where('id_movil', '!=', $this->movil_id)
                            ->exists();
                        if ($existe) {
                            $fail('Chasis ya está registrado en otro móvil.');
                        }
                    }
                }
            ]
        ];
    }

    public function actualizar()
    {
        $validados = $this->validate();
        //return dd($validados);
        // Agregar el ID del usuario autenticado al array validado
        $validados['actualizadoPor'] = Auth::id();

        // Obtener los datos actuales del móvil desde una vista en la bd antes de cualquier modificación
        $movilRegistro = VtMayor::findOrFail($this->movil_id);
        // Construir el string con los datos anteriores
        $comentario = "DATOS ANTERIORES: ";
        $comentario .= "CHASIS: " . $movilRegistro->chasis . " - ";
        $comentario .= "MOVIL: " . $movilRegistro->tipo . " - "; // Asume relación con modelo Tipo
        $comentario .= "CODIGO RADIAL: " . $movilRegistro->tipo . "-" . $movilRegistro->movil . " - ";
        $comentario .= "MARCA: " . $movilRegistro->marca . " - "; // Asume relación con modelo Marca
        $comentario .= "MODELO: " . $movilRegistro->modelo . " - "; // Asume relación con modelo Modelo
        $comentario .= "EJE: " . $movilRegistro->eje . " - "; // Asume relación con modelo Eje
        $comentario .= "TRANSMISION: " . $movilRegistro->transmision . " - "; // Asume relación
        $comentario .= "AÑO: " . $movilRegistro->anho . " - ";
        $comentario .= "CHAPA: " . $movilRegistro->chapa . " - ";
        $comentario .= "COMBUSTIBLE: " . $movilRegistro->combustible . " - "; // Asume relación
        $comentario .= "CUBIERTAS DEL: " . $movilRegistro->cubiertas_frente . " - ";
        $comentario .= "CUBIERTAS TRAS: " . $movilRegistro->cubiertas_atras;
        //Generar un comentario con los datos anteriores
        MovilComentario::create([
            'comentario' => $comentario,
            'movil_id' => $movilRegistro->id_movil,
            'accion_id' => 3, // REPORTE
            'creadoPor' => Auth::id(),
        ]);
        // Actualizar el registro
        $movilActualizar = Movil::findOrFail($this->movil_id);
        $movilActualizar->update($validados);
        session()->flash('success', 'Se Actualizo el Material Mayor Correctamente En El Sistema!');
        return redirect()->route('materiales.mayor.show', $this->movil_id);
    }

    public function render()
    {
        return view('livewire.materiales.mayor.ficha-editar', [
            'movilRegistro' => $this->movilRegistro,
            'marcas' => Marca::select('id_movil_marca', 'marca')->get(),
            'modelos' => Modelo::select('id_movil_modelo', 'modelo')->where('marca_id', $this->marca_id)->get(),
            'tipos' => Acronimo::select('id_movil_tipo', 'tipo', 'activo')->where('activo', 1)->get(),
            'transmisiones' => Transmision::select('id_movil_transmision', 'transmision', 'activo')->where('activo', 1)->get(),
            'ejes' => Eje::select('id_movil_eje', 'eje', 'activo')->where('activo', 1)->get(),
            'combustibles' => Combustible::select('id_movil_combustible', 'tipo', 'activo')->where('activo', 1)->get()
        ]);
    }
}
