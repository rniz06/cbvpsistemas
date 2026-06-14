<?php

namespace App\Livewire\ANB\ECB\ExamenesFisicos;

use Livewire\Component;
use App\Models\ANB\ECB\ExamenFisico;

class Index extends Component
{

    public $buscar='';

    public $mostrarCreate=false;

    public $nombre;

    public $descripcion;

    public $puntaje_aprobacion;

    public $activo=true;



    public function save()
    {

        $this->validate([

            'nombre'=>'required',

        ]);



        ExamenFisico::create([

            'nombre'=>$this->nombre,

            'descripcion'=>$this->descripcion,

            'puntaje_aprobacion'=>$this->puntaje_aprobacion,

            'activo'=>$this->activo,

        ]);



        $this->reset([

            'nombre',

            'descripcion',

            'puntaje_aprobacion'

        ]);



        $this->activo=true;

        $this->mostrarCreate=false;

    }



    public function render()
    {

        $query=ExamenFisico::query();



        if($this->buscar){

            $query->where(

                'nombre',

                'like',

                '%'.$this->buscar.'%'

            );

        }



        $examenes=$query

            ->latest()

            ->get();



        return view(

            'livewire.anb.ecb.examenes-fisicos.index',

            compact('examenes')

        );

    }

}