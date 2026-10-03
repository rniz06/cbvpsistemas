<?php

namespace App\Livewire\Personal;

use App\Models\User;
use Livewire\Component;

class HistorialReseteoContrasenha extends Component
{
    public $usuario, $auditorias = [];

    public function mount($personal_id)
    {
        $this->usuario = User::where('personal_id', $personal_id)->first();
        $this->auditorias = $this->cargarAuditorias();
    }

    public function render()
    {
        return view('livewire.personal.historial-reseteo-contrasenha');
    }

    private function cargarAuditorias()
    {
        if (!$this->usuario) {
            return collect();
        }

        return $this->usuario->audits()
            ->where('event', 'updated')
            ->whereJsonContainsKey('old_values->password')
            ->with('user:id_usuario,nombrecompleto')
            ->orderByDesc('created_at')
            ->get(['created_at', 'user_type', 'user_id']);
    }
}
