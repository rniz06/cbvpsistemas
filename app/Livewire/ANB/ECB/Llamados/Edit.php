<?php

namespace App\Livewire\ANB\ECB\Llamados;

use Livewire\Component;
use App\Models\ANB\ECB\Llamado;

class Edit extends Component
{

    public Llamado $llamado;

    protected $rules=[

        'llamado.nombre'=>'required',

        'llamado.anio'=>'required',

    ];

    public function save()
    {

        $this->validate();

        $this->llamado->save();

        session()->flash(
            'success',
            'Llamado actualizado.'
        );

    }

    public function render()
    {
        return view(
            'livewire.anb.ecb.llamados.edit'
        );
    }
}