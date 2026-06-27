<?php

namespace App\Livewire\ANB\ECB\PsicoBaremos;

use Livewire\Component;

use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoDimension;
use App\Models\ANB\ECB\PsicoBaremo;

class Index extends Component
{
    public PsicoTest $test;

    public $dimension_id='';

    public $sexo='A';
public $desde;

public $hasta;

public $percentil;

public $interpretacion;
public $interpretaciones = [

    'Muy Bajo',

    'Bajo',

    'Promedio Bajo',

    'Promedio',

    'Promedio Alto',

    'Alto',

    'Muy Alto'

];

    public function mount($test_id)
    {
        $this->test=
            PsicoTest::findOrFail($test_id);
    }

    public function render()
    {
        $dimensiones=

            PsicoDimension::where(

                'test_id',

                $this->test->id

            )

            ->orderBy('orden')

            ->get();

        $query=

            PsicoBaremo::with(
                'dimension'
            );

        if($this->dimension_id){

            $query->where(

                'dimension_id',

                $this->dimension_id

            );

        }

        $query->where(

            'sexo',

            $this->sexo

        );

        $baremos=

            $query

            ->orderBy('dimension_id')

            ->orderBy('desde')

            ->get();

        return view(

            'livewire.anb.ecb.psico-baremos.index',

            compact(

                'dimensiones',

                'baremos'

            )

        );
    }

    public function guardar()
{
    $this->validate([

        'dimension_id'=>'required',

        'desde'=>'required|numeric',

        'hasta'=>'required|numeric',

        'percentil'=>'required|integer',

        'interpretacion'=>'required'

    ]);

    PsicoBaremo::create([

        'dimension_id'=>$this->dimension_id,

        'sexo'=>$this->sexo,

        'desde'=>$this->desde,

        'hasta'=>$this->hasta,

        'percentil'=>$this->percentil,

        'interpretacion'=>$this->interpretacion

    ]);

    $this->reset(

        'desde',

        'hasta',

        'percentil',

        'interpretacion'

    );
}

public function eliminar($id)
{
    PsicoBaremo::find($id)?->delete();
}
}