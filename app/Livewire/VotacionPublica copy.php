<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Mesa;
use Livewire\Component;

class VotacionPublica extends Component
{
    public $mesas;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $pollingInterval = 2000; // 5 segundos

    #[Layout('components.layouts.app')] 
    public function render()
    {
        $this->mesas = Mesa::select('mesa', 'votos')->get();
        return view('livewire.votacion-publica');
    }
}
