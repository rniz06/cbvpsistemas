<?php

namespace App\Livewire\Personal\Asistencias;

use App\Models\Gral\Anho;
use App\Models\Gral\Compania;
use App\Models\Gral\Mes;
use App\Models\Personal\Asistencia\Asistencia;
use App\Models\Personal\Asistencia\Estado;
use App\Models\UserRoleCompania;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // PROPIEDADES DE FILTRADO
    public $buscarCompaniaId, $buscarAnhoId, $buscarMesId, $buscarEstadoId, $paginado = 5;

    // PROPIEDADES PARA LOS SELECT DE FILTRO
    public $companias = [], $anhos = [], $meses = [], $estados = [];

    public function mount()
    {
        $this->companias = Compania::select('id_compania', 'compania')->orderBy('orden')->get();
        $this->anhos     = Anho::select('id_anho', 'anho')->orderByDesc('anho')->get();
        $this->meses     = Mes::select('id_mes', 'mes')->get();
        //$this->estados   = Estado::select('id_asistencia_estado', 'estado')->where('id_asistencia_estado', '!=', 1)->get();
        $this->estados   = Estado::select('id_asistencia_estado', 'estado')->whereNot('id_asistencia_estado', 1)->get();
    }

    // Limpiar el buscador y la paginación al cambiar de pagina
    public function updating($key): void
    {
        if (in_array($key, ['buscarCompaniaId', 'buscarAnhoId', 'buscarMesId', 'buscarEstadoId', 'paginado',])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $usuario = Auth::user();
        $usuarioRoles = $usuario->roles()->where('name', 'like', 'personal_%')->pluck('name')->first();
        $queryBase = Asistencia::select('id_asistencia', 'compania_id', 'periodo_id', 'estado_id')
            ->with([
                'compania:id_compania,compania',
                'periodo:id_asistencia_periodo,anho_id,mes_id',
                'estado:id_asistencia_estado,estado'
            ])
            ->where('estado_id', '!=', 1); // DISTINTO DE NO INICIADO

        switch ($usuarioRoles) {
            case 'personal_moderador_compania':
                $asistencias = $queryBase->where('compania_id', $usuario->personal->compania_id);
                break;
            case 'personal_moderador_por_compania':
                $asignacion = UserRoleCompania::whereNotNull('compania_id')->where('usuario_id', $usuario->id_usuario)->first();
                $asistencias = $queryBase->where('compania_id', $asignacion->compania_id);
                break;

            default:
                $asistencias = $queryBase;
                break;
        }

        $asistencias = $asistencias->buscarCompaniaId($this->buscarCompaniaId)
            ->buscarAnhoId($this->buscarAnhoId)
            ->buscarMesId($this->buscarMesId)
            ->buscarEstadoId($this->buscarEstadoId)
            ->paginate($this->paginado);

        return view('livewire.personal.asistencias.index', compact('asistencias'));
    }
}
