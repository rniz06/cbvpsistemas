<?php

namespace App\Livewire\ANB\ECB\Aspirantes;

use Livewire\Component;
use App\Models\ANB\ECB\Llamado;
use App\Models\Compania;
use App\Models\ANB\ECB\Aspirante;

class Edit extends Component
{

    public Aspirante $aspirante;

    protected $rules=[

        'aspirante.nombre'=>'required',

        'aspirante.apellido'=>'required',

        'aspirante.cedula'=>'required',

    ];

    public function save()
    {

        $this->validate();

        $this->aspirante->save();

        session()->flash(
            'success',
            'Aspirante actualizado.'
        );
    }

    public function render()
    {

        $llamados=Llamado::all();

        $companias=Compania::all();

        return view(
            'livewire.anb.ecb.aspirantes.edit',
            compact(
                'llamados',
                'companias'
            )
        );
    }
}