<?php

namespace App\Livewire\Personal;

use App\Models\Compania;
use App\Models\Personal;
use App\Models\Personal\Categoria;
use App\Models\Personal\Estado;
use App\Models\Personal\EstadoActualizar;
use App\Models\UserRoleCompania;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reportes extends Component
{
    public $compania_id = '';
    public $categoria_id = '';
    public $estado_id = '';
    public $estado_actualizar_id = '';
    public $esModerador = false;
    public $compania = null;

    public $companias, $categorias, $estados, $estados_actualizar;

    public function mount()
    {
        $usuario = Auth::user();
        $usuarioRoles = $usuario->roles()->where('name', 'like', 'personal_%')->pluck('name')->first();
        switch ($usuarioRoles) {
            case 'personal_moderador_compania':
                $this->esModerador = true;
                $this->compania_id = $usuario->personal->compania_id;
                $this->compania = $usuario->compania;
                break;
            case 'personal_moderador_por_compania':
                $asignacion = UserRoleCompania::where('usuario_id', $usuario->id_usuario)->first();
                $this->esModerador = true;
                $this->compania_id = $asignacion->compania_id;
                $this->compania = $asignacion->compania->compania;
                break;

            default:
                //$personales = Personal::query();
                break;
        }
        $this->companias = Compania::select('idcompanias', 'compania')->orderBy('orden')->get();
        $this->categorias = Categoria::select('idpersonal_categorias', 'categoria')->get();
        $this->estados = Estado::select('idpersonal_estados', 'estado')->get();
        $this->estados_actualizar = EstadoActualizar::select('idpersonal_estado_actualizar', 'estado')->get();
    }

    public function render()
    {
        $query = Personal::query();

        if ($this->compania_id !== '') {
            $query->where('compania_id', $this->compania_id);
        }

        if ($this->categoria_id !== '') {
            $query->where('categoria_id', $this->categoria_id);
        }

        if ($this->estado_id !== '') {
            $query->where('estado_id', $this->estado_id);
        }

        if ($this->estado_actualizar_id !== '') {
            $query->where('estado_actualizar_id', $this->estado_actualizar_id);
        }

        return view('livewire.personal.reportes', [
            'total_personal' => $query->count(),
            'total_combatientes' => (clone $query)->where('categoria_id', 1)->count(),
            'total_activos' => (clone $query)->where('categoria_id', 2)->count(),
            'total_falta_actualizar' => (clone $query)->where('estado_actualizar_id', 1)->count(),
            'total_actualizado' => (clone $query)->where('estado_actualizar_id', 2)->count(),
        ]);
    }
}
