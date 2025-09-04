<?php

namespace App\Livewire\Personal\Comisionamientos;

use App\Enums\Personal\Cargo\TipoCodigo;
use App\Models\Admin\CompaniaGral;
use App\Models\Compania;
use App\Models\Gral\Direccion;
use App\Models\Personal\Cargo;
use App\Models\Personal\Categoria;
use App\Models\Personal\Comisionamiento;
use App\Models\Resolucion\Resolucion;
use App\Models\Vistas\VtPersonales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // Variables del Formulario
    // Propiedades para el personal
    #[Validate]
    public $personal_id, $categoria_id, $codigo, $info_personal;
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

    public function mount()
    {
        $this->categorias  = Categoria::select('idpersonal_categorias', 'categoria')->get();
        //$this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();
        $this->origenes    = DB::select('SELECT id, origen FROM cbvp_resoluciones_db.fuente_origen WHERE deleted_at IS NULL');
        $this->anhos       = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
        $this->cargos      = Cargo::with('rango')->get();
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->where('compania_id', $this->compania_id)->get();
    }

    protected function rules()
    {
        return [
            'categoria_id'           => ['required', Rule::exists(Categoria::class, 'idpersonal_categorias')],
            'codigo'                 => ['required', 'numeric', 'min_digits:1', 'max_digits:5'],
            'cargo_id'               => ['required', Rule::exists(Cargo::class, 'id_cargo')],
            'compania_id'            => ['required', Rule::exists(CompaniaGral::class, 'id_compania')],
            'direccion_id'           => ['nullable', Rule::exists(Direccion::class, 'id_direccion')],
            'fecha_inicio'           => ['required', 'date', Rule::date()->beforeOrEqual(today()),],
            'codigo_comisionamiento' => ['required', 'string', 'min:2', 'max:5', Rule::unique(Comisionamiento::class, 'codigo_comisionamiento')
                ->where(fn($query) => $query->where('culminado', false)),],
            'origen_id'              => ['nullable'],
        ];
    }

    // Actualizar propiedad info_personal
    public function updatedCodigo($value)
    {
        $personal = VtPersonales::select('idpersonal', DB::raw("CONCAT(nombrecompleto, ' - ', compania) AS label"))
            ->where([['categoria_id', $this->categoria_id], ['codigo', $value]])
            ->first();

        $this->info_personal = $personal;
        $this->personal_id = $personal->idpersonal ?? null;
        $this->info_personal_label = $personal->label ?? 'No encontrado o no seleccionado aún';
    }

    public function updatedCategoriaId($value)
    {
        $this->updatedCodigo($this->codigo);
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
        $this->companias   = CompaniaGral::select('id_compania', 'compania')->orderBy('orden', 'asc')->get();

        // BARRER DATOS NO NECESARIOS SEGUN EL CARGO
        if ($cargo->tipo_codigo == TipoCodigo::FIJO || $cargo->tipo_codigo == TipoCodigo::VARIABLE) {
            $this->companias   = CompaniaGral::select('id_compania', 'compania')
                ->whereIn('compania', [
                    'DIRECTORIO',
                    'COMANDANCIA',
                    'ANB',
                ])->orWhere('compania', 'LIKE', 'UN%')
                ->orderBy('orden', 'asc')->get();
        }

        // BARRER DATOS NO NECESARIOS SEGUN EL CARGO
        if ($cargo->tipo_codigo == TipoCodigo::COMPANIA) {
            $this->companias   = CompaniaGral::select('id_compania', 'compania')
                ->whereNotIn('compania', [
                    'DIRECTORIO',
                    'COMANDANCIA',
                    'ANB',
                ])->where('compania', 'NOT LIKE', 'UN%')
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
        $this->direcciones = Direccion::select('id_direccion', 'direccion')->where('compania_id', $value)->get();
        $cargo    = Cargo::find($this->cargo_id);
        $compania = CompaniaGral::findOrFail($value);
        $nroCompania = preg_replace('/\D/', '', $compania->compania);
        if ($cargo && $cargo->tipo_codigo == TipoCodigo::COMPANIA) {
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

    public function guardar()
    {
        $this->validate();
        Comisionamiento::create([
            'fecha_inicio'           => $this->fecha_inicio ?? null,
            'fecha_fin'              => $this->fecha_fin ?? null,
            'personal_id'            => $this->personal_id,
            'cargo_id'               => $this->cargo_id,
            'compania_id'            => $this->compania_id,
            'direccion_id'           => $this->direccion_id,
            'resolucion_id'          => $this->resolucion_id ?? null,
            'fecha_fin'              => $this->fecha_fin ?? null,
            'codigo_comisionamiento' => $this->codigo_comisionamiento ?? null,
            'culminado'              => 0, // false por defecto
            'creadoPor'              => Auth::id()
        ]);

        session()->flash('success', 'Comisionamiento Registrado Correctamente!');
        $this->redirectRoute('personal.comisionamientos.index');
    }

    public function render()
    {
        return view('livewire.personal.comisionamientos.create');
    }
}
