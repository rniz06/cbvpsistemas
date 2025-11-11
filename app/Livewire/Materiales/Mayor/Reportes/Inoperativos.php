<?php

namespace App\Livewire\Materiales\Mayor\Reportes;

use App\Models\Gral\Compania;
use App\Models\Materiales\AccionCategoria;
use App\Models\Materiales\AccionCategoriaDetalle;
use App\Models\Materiales\Movil\Acronimo;
use App\Models\Materiales\Movil\Eje;
use App\Models\Materiales\Movil\Movil;
use App\Models\Materiales\Movil\Transmision;
use App\Models\Vistas\Materiales\VtMayor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Inoperativos extends Component
{
    use WithPagination;

    // PROPIEDADES PARA SELECT
    public $companias = [], $acronimos = [], $anhos = [], $motivos = [], $detalles = [];

    // PROPIEDADES FILTROS
    public $buscarCompaniaId, $buscarAcronimoId, $buscarAnhoId, $buscarAccionCategoriaId, $buscarCategoriaDetalleId;

    public $paginado = 5;

    public function mount()
    {
        $this->companias     = Compania::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->acronimos     = Acronimo::select('id_movil_tipo', 'tipo')->orderBy('tipo')->get();
        $this->anhos         = Movil::filtrarInoperativos()->distinct()->orderBy('anho', 'desc')->pluck('anho', 'anho')->toArray();
        $this->motivos       = AccionCategoria::select('id_accion_categoria', 'categoria')->orderBy('categoria')->get();
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, [
            'compania_id',
            'acronimo_id',
            'anho_id',
            'motivo_id',
            'detalle_id',
            'paginado'
        ])) {
            $this->resetPage();
        }
    }

    public function cargarResultados()
    {
        return Movil::select(
            'id_movil',
            'movil',
            'movil_tipo_id',
            'compania_id',
            'anho',
        )->filtrarInoperativos()
        ->buscarCompaniaId($this->buscarCompaniaId)
        ->buscarAcronimoId($this->buscarAcronimoId)
        ->buscarAnho($this->buscarAnhoId)
        ->buscarAccionCategoriaId($this->buscarAccionCategoriaId)
        ->buscarCategoriaDetalleId($this->buscarCategoriaDetalleId)
        ->with([
            'acronimo:id_movil_tipo,tipo',
            'compania:id_compania,compania',
            'ultimoComentarioFueraServicio:id_movil_comentario,movil_id,accion_categoria_id,categoria_detalle_id,accion_id,created_at',
            'ultimoComentarioFueraServicio.motivo:id_accion_categoria,categoria',
            'ultimoComentarioFueraServicio.detalle:idaccion_categoria_detalle,detalle',
        ])->paginate($this->paginado);
    }

    public function render()
    {
        return view('livewire.materiales.mayor.reportes.inoperativos', [
            'inoperativos' => $this->cargarResultados()
        ]);
    }

    public function updatedBuscarAccionCategoriaId($value)
    {
        $this->detalles  = AccionCategoriaDetalle::select('idaccion_categoria_detalle', 'detalle')
            ->where('accion_categoria_id', $value)
            ->orderBy('detalle')
            ->get();
    }
}
