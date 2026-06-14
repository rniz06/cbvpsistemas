<?php

namespace App\Livewire\ANB\ECB\Llamados;

use Livewire\Component;
use App\Models\ANB\ECB\Llamado;

class Index extends Component
{

    public $buscar='';

    public $mostrarCreate=false;

    public $nombre;

    public $anio;

    public function save()
    {

        $this->validate([

            'nombre'=>'required',

            'anio'=>'required'

        ]);

        Llamado::create([

            'nombre'=>$this->nombre,

            'anio'=>$this->anio,

            'activo'=>true,

        ]);

        $this->reset(
            'nombre',
            'anio'
        );

        $this->mostrarCreate=false;

    }

    public function render()
    {

        $query=Llamado::query();

        if($this->buscar){

            $query->where(
                'nombre',
                'like',
                '%'.$this->buscar.'%'
            );

        }

        $llamados=$query
            ->latest()
            ->get();

        return view(
            'livewire.anb.ecb.llamados.index',
            compact('llamados')
        );

    }

}