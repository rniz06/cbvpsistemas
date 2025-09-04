<?php

namespace App\Livewire\Personal\Comisionamientos;

use Illuminate\Support\Str;
use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Admin\CompaniaGral;
use App\Models\Gral\Direccion;
use App\Models\Personal\Cargo;
use App\Models\Personal\Comisionamiento;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\Personal\VtComisionamiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public $comisionamiento;

    // propiedades del Comisionamiento
    #[Validate]
    public $fecha_inicio, $cargo_id, $compania_id, $direccion_id, $codigo_comisionamiento, $fecha_fin, $culminado;

    // propiedades de la resolucion
    #[Validate]
    public $resolucion_id, $anho_id, $origen_id, $info_resolucion; // Datos de la resolucion
    public $info_personal_label = 'No encontrado o no seleccionado aún';
    public $info_resolucion_label = 'No encontrado o no seleccionado aún';

    // Variables Para los select
    public $categorias = [], $companias = [], $origenes = [], $nrosResolucion = [], $anhos = [], $cargos = [], $direcciones = [];

    // Varibles para mostrar u ocultar info o campos
    public $mostrarInputCodCom = false;

    public function mount($comisionamiento)
    {
        $this->comisionamiento = VtComisionamiento::findOrFail($comisionamiento);

        // Asignar valores a las propiedades públicas
        $this->cargo_id            = $this->comisionamiento->cargo_id;
        $this->compania_id            = $this->comisionamiento->compania_id;
        $this->direccion_id            = $this->comisionamiento->direccion_id;
        $this->codigo_comisionamiento = $this->comisionamiento->codigo_comisionamiento;
        $this->fecha_inicio           = $this->comisionamiento->fecha_inicio?->format('Y-m-d');
        $this->fecha_fin              = $this->comisionamiento->fecha_fin?->format('Y-m-d');

        $this->resolucion_id          = $this->comisionamiento->resolucion_id;
        // Si la resolucion existe completar los campos
        // if ($this->resolucion_id) {
        //     $resolucion = Resolucion::find($this->comisionamiento->resolucion_id);
        //     $this->anho_id = $resolucion->ano;
        //     $this->origen_id = $resolucion->fuente_origen_id;
        //     $this->info_resolucion_label = $resolucion->concepto;
        // }

        $this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();
        $this->origenes    = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->anhos       = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
        $this->cargos      = Cargo::with('rango')->get();
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->where('compania_id', $this->compania_id)->get();
    }

    protected function rules()
    {
        return [
            'cargo_id'               => ['required', Rule::exists(Cargo::class, 'id_cargo')],
            'compania_id'            => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'direccion_id'           => ['nullable', Rule::exists(Direccion::class, 'id_direccion')],
            'fecha_inicio'           => ['required', 'date', Rule::date()->beforeOrEqual(today()),],
            'codigo_comisionamiento' => ['required', 'string', 'min:2', 'max:5', Rule::unique(Comisionamiento::class, 'codigo_comisionamiento')
                ->where(fn($query) => $query->where('culminado', false))->ignore($this->comisionamiento->id_comisionamiento, 'id_comisionamiento'),],
            'origen_id'              => ['nullable'],
        ];
    }

    // Actualizar propiedad info_resolucion
    public function updatedOrigenId($value)
    {
        $this->nrosResolucion  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $value], ['ano', $this->anho_id]])->get();
    }

    // Actualizar propiedad info_resolucion
    public function updatedAnhoId($value)
    {
        $this->nrosResolucion  = Resolucion::select('id', 'n_resolucion')->where([['fuente_origen_id', $this->origen_id], ['ano', $value]])->get();
    }

    // Actualizar propiedad info_resolucion
    public function updatedResolucionId($value)
    {
        $resolucion = Resolucion::findOrFail($value);

        $this->info_resolucion = $resolucion;
        $this->resolucion_id = $resolucion->id ?? null;
        $this->info_resolucion_label = $resolucion->concepto ?? 'No encontrado o no seleccionado aún';
    }

    public function updatedCargoId($value)
    {
        $cargo = Cargo::findOrFail($value);
        //$this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();

        // BARRER DATOS NO NECESARIOS SEGUN EL CARGO
        if ($cargo->tipo_codigo == TipoCodigo::FIJO || $cargo->tipo_codigo == TipoCodigo::VARIABLE) {
            $this->companias   = CompaniaGral::select('id_compania', 'compania')
                ->whereIn('compania', [
                    'DIRECTORIO',
                    'COMANDANCIA',
                    'ANB',
                ])
                //->orWhere('compania', 'LIKE', 'UN%')
                ->orderBy('orden', 'asc')->get();
        }

        // BARRER DATOS NO NECESARIOS SEGUN EL CARGO
        if ($cargo->tipo_codigo == TipoCodigo::COMPANIA) {
            $this->companias   = CompaniaGral::select('id_compania', 'compania')
                ->whereNotIn('compania', [
                    'DIRECTORIO',
                    'COMANDANCIA',
                    'ANB',
                    'BRAVO GOLF',
                    'BRAVO FENIX',
                ])
                //->where('compania', 'NOT LIKE', 'UN%')
                ->orderBy('orden', 'asc')->get();
        }

        // AUTOCOMPLETA EL CODIGO DE COMISIONAMIENTO FIJO
        if ($cargo->tipo_codigo == TipoCodigo::FIJO) {
            $this->codigo_comisionamiento = $cargo->codigo_base;
        }

        // HABILITA EL INPUT PARA INGRESAR EL CODIGO DE COMISIONAMIENTO
        if ($cargo->tipo_codigo == TipoCodigo::VARIABLE) {
            $this->codigo_comisionamiento = $cargo->codigo_base;
            $this->mostrarInputCodCom = true;
        }
    }

    public function updatedCompaniaId($value)
    {
        $this->direcciones = Direccion::select('id_direccion', 'direccion')
            ->where('compania_id', $value)
            ->get();

        $cargo    = Cargo::find($this->cargo_id);
        $compania = CompaniaGral::findOrFail($value);

        if ($cargo && $cargo->tipo_codigo == TipoCodigo::COMPANIA) {

            // FILTRAR SI LA COMPAÑÍA EMPIEZA CON "UN"
            if (Str::startsWith($compania->compania, 'UN')) {

                if ($cargo->cargo == 'COMANDANTE DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $compania->compania . '1';
                }

                if ($cargo->cargo == '1ER OFICIAL DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $compania->compania . '2';
                }

                if ($cargo->cargo == '2DO OFICIAL DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $compania->compania . '3';
                }

                if ($cargo->cargo == 'CAP. ADMINISTRATIVO') {
                    $this->codigo_comisionamiento = 'D' . $compania->compania;
                }
            }

            // SI LA COMPAÑÍA EMPIEZA CON "K"
            elseif (Str::startsWith($compania->compania, 'K')) {
                $nroCompania = preg_replace('/\D/', '', $compania->compania);

                if ($cargo->cargo == 'COMANDANTE DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $nroCompania . '1';
                }

                if ($cargo->cargo == '1ER OFICIAL DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $nroCompania . '2';
                }

                if ($cargo->cargo == '2DO OFICIAL DE COMPANIA') {
                    $this->codigo_comisionamiento = 'C' . $nroCompania . '3';
                }

                if ($cargo->cargo == 'CAP. ADMINISTRATIVO') {
                    $this->codigo_comisionamiento = 'D' . $compania->compania;
                }
            }
        }
    }

    public function guardar()
    {
        $x=$this->validate();
        //return dd($x);
        $comisionamiento = Comisionamiento::findOrFail($this->comisionamiento->id_comisionamiento);
        $comisionamiento->update([
            'fecha_inicio'           => $this->fecha_inicio ?? null,
            'cargo_id'               => $this->cargo_id ?? null,
            'compania_id'            => $this->compania_id,
            'codigo_comisionamiento' => $this->codigo_comisionamiento ?? null,
            'direccion_id'           => $this->direccion_id ?? null,
            'resolucion_id'          => $this->resolucion_id ?? null,
        ]);

        session()->flash('success', 'Registro de Comisionamiento Actualizado Correctamente!');
        $this->redirectRoute('personal.comisionamientos.index');
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.edit');
    }
}
