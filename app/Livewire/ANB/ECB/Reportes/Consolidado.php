<?php

namespace App\Livewire\ANB\ECB\Reportes;

use Livewire\Component;
use App\Models\ANB\ECB\Aspirante;
use App\Models\ANB\ECB\Llamado;
use App\Models\Gral\Compania;

class Consolidado extends Component
{

    public $buscar='';

    public $llamado='';

    public $compania='';

    public $estado='';

    public function render()
    {

        $query=Aspirante::with([

            'llamado',

            'compania',

            'fichaMedica',

            'resultadosExamenFisico',

            'sesionesPsicologicas.test',

            'sesionesPsicologicas.resultados.dimension'

        ]);

        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
        |--------------------------------------------------------------------------
        */

        if($this->buscar){

            $query->where(function($q){

                $q->where('cedula','like','%'.$this->buscar.'%')

                ->orWhere('nombre','like','%'.$this->buscar.'%')

                ->orWhere('apellido','like','%'.$this->buscar.'%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | LLAMADO
        |--------------------------------------------------------------------------
        */

        if($this->llamado){

            $query->where(

                'llamado_id',

                $this->llamado

            );

        }

        /*
        |--------------------------------------------------------------------------
        | COMPAÑIA
        |--------------------------------------------------------------------------
        */

        if($this->compania){

            $query->where(

                'compania_id',

                $this->compania

            );

        }

        $filas=[];

        foreach(

            $query->orderBy('nombre')

            ->orderBy('apellido')

            ->get()

            as $aspirante

        ){

            /*
            |--------------------------------------------------------------------------
            | EVALUACIONES
            |--------------------------------------------------------------------------
            */

            $medico=$this->evaluarMedico($aspirante);

            $fisico=$this->evaluarFisico($aspirante);

            $wonderlic=$this->evaluarWonderlic($aspirante);

            $neoffi=$this->evaluarNeoFFI($aspirante);

            $lsb50=$this->evaluarLSB50($aspirante);

            /*
            |--------------------------------------------------------------------------
            | RESULTADO FINAL
            |--------------------------------------------------------------------------
            */

            $resultado=$this->resultadoFinal([

                $medico,

                $fisico,

                $wonderlic,

                $neoffi,

                $lsb50

            ]);

            /*
            |--------------------------------------------------------------------------
            | OBSERVACION
            |--------------------------------------------------------------------------
            */

            $observacion=$this->observacion([

                $medico,

                $fisico,

                $wonderlic,

                $neoffi,

                $lsb50

            ]);

            /*
            |--------------------------------------------------------------------------
            | FILTRAR POR RESULTADO
            |--------------------------------------------------------------------------
            */

            if(

                $this->estado &&

                $resultado['estado']!=$this->estado

            ){

                continue;

            }

            $filas[]=[

                'cedula'=>$aspirante->cedula,

                'nombre'=>$aspirante->nombre.' '. $aspirante->apellido,

                'compania'=>$aspirante->compania->compania ?? '',

                'medico'=>$medico,

                'fisico'=>$fisico,

                'wonderlic'=>$wonderlic,

                'neoffi'=>$neoffi,

                'lsb50'=>$lsb50,

                'resultado'=>$resultado,

                'observacion'=>$observacion

            ];

        }

        return view(

            'livewire.anb.ecb.reportes.consolidado',

            [

                'filas'=>$filas,

                'llamados'=>Llamado::all(),

                'companias'=>Compania::companiasValidas()

                    ->orderBy('orden')

                    ->get(['id_compania','compania'])

            ]

        );

    }
    /*
    |--------------------------------------------------------------------------
    | MÉDICO
    |--------------------------------------------------------------------------
    */

    private function evaluarMedico($aspirante)
    {

        if(!$aspirante->fichaMedica){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Pendiente'

            ];

        }

        if(

            filled($aspirante->fichaMedica->ficha_medica_archivo) &&

            filled($aspirante->fichaMedica->ecg_archivo) &&

            filled($aspirante->fichaMedica->radiografia_torax_archivo) &&

            filled($aspirante->fichaMedica->laboratorio_archivo)

        ){

            return [

                'estado'=>'APTO',

                'texto'=>'Apto'

            ];

        }

        return [

            'estado'=>'PENDIENTE',

            'texto'=>'Incompleto'

        ];

    }

/*
|--------------------------------------------------------------------------
| EXAMEN FÍSICO
|--------------------------------------------------------------------------
*/

private function evaluarFisico($aspirante)
{
    $resultado =

        $aspirante
            ->resultadosExamenFisico()
            ->orderByDesc('id')
            ->first();

    if (!$resultado) {

        return [

            'estado' => 'PENDIENTE',

            'texto'  => 'Pendiente'

        ];

    }

    return [

        'estado' => $resultado->aprobado
            ? 'APTO'
            : 'NO APTO',

        'texto' => $resultado->aprobado
            ? 'Aprobado'
            : 'Reprobado'

    ];
}

    /*
    |--------------------------------------------------------------------------
    | WONDERLIC
    |--------------------------------------------------------------------------
    */

    private function evaluarWonderlic($aspirante)
    {

        $sesion=

            $aspirante

                ->sesionesPsicologicas

                ->first(function($s){

                    return

                        optional($s->test)->codigo=='WONDERLIC'

                        &&

                        $s->finalizado;

                });

        if(!$sesion){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Pendiente'

            ];

        }

        if(is_null($sesion->puntaje)){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Sin calcular'

            ];

        }

        return [

            'estado'=>$sesion->puntaje>=15

                ? 'APTO'

                : 'NO APTO',

            'texto'=>$sesion->puntaje.' puntos'

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | NEO FFI
    |--------------------------------------------------------------------------
    */

/*
|--------------------------------------------------------------------------
| NEO FFI
|--------------------------------------------------------------------------
*/

private function evaluarNeoFFI($aspirante)
{
    $sesion =

        $aspirante
            ->sesionesPsicologicas
            ->first(function ($s) {

                return
                    optional($s->test)->codigo == 'NEOFFI'
                    &&
                    $s->finalizado;

            });

    if (!$sesion) {

        return [

            'estado' => 'PENDIENTE',

            'texto' => 'Pendiente'

        ];

    }

    if ($sesion->resultados->count() == 0) {

        return [

            'estado' => 'PENDIENTE',

            'texto' => 'Sin calcular'

        ];

    }

    $observaciones = [];

    foreach ($sesion->resultados as $resultado) {

        $dimension = strtoupper($resultado->dimension->nombre);

        if (!in_array($dimension, [

            'NEUROTICISMO',
            'EXTRAVERSIÓN',
            'EXTRAVERSION',
            'AMABILIDAD'

        ])) {

            continue;

        }

        $nivel = $this->interpretarNeoFFI(

            $dimension,

            $resultado->puntaje

        );

        if (

            in_array(

                $nivel,

                [

                    'Muy bajo',

                    'Bajo'

                ]

            )

        ) {

            $observaciones[] =

                $resultado->dimension->nombre .

                ': ' .

                $nivel;

        }

    }

    if (count($observaciones) > 0) {

        return [

            'estado' => 'NO APTO',

            'texto' => implode(' | ', $observaciones)

        ];

    }

    return [

        'estado' => 'APTO',

        'texto' => 'Apto'

    ];

}
    /*
    |--------------------------------------------------------------------------
    | LSB50
    |--------------------------------------------------------------------------
    */

    private function evaluarLSB50($aspirante)
    {

        $sesion=

            $aspirante

                ->sesionesPsicologicas

                ->first(function($s){

                    return

                        optional($s->test)->codigo=='LSB50-ORIGINAL'

                        &&

                        $s->finalizado;

                });

        if(!$sesion){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Pendiente'

            ];

        }

        if($sesion->resultados->count()==0){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Sin calcular'

            ];

        }

        $irpsi=

            $sesion

                ->resultados

                ->first(function($r){

                    return

                        optional($r->dimension)->codigo=='IRPSI';

                });

        if(!$irpsi){

            return [

                'estado'=>'PENDIENTE',

                'texto'=>'Sin IRPsi'

            ];

        }

        return [

            'estado'=>$irpsi->percentil>=76

                ? 'NO APTO'

                : 'APTO',

            'texto'=>$irpsi->percentil.'%'

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | RESULTADO FINAL
    |--------------------------------------------------------------------------
    */

    private function resultadoFinal($datos)
    {

        foreach($datos as $d){

            if($d['estado']=='PENDIENTE'){

                return [

                    'estado'=>'PENDIENTE',

                    'texto'=>'Pendiente'

                ];

            }

        }

        foreach($datos as $d){

            if($d['estado']=='NO APTO'){

                return [

                    'estado'=>'NO APTO',

                    'texto'=>'No Apto'

                ];

            }

        }

        return [

            'estado'=>'APTO',

            'texto'=>'Apto'

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | OBSERVACIONES
    |--------------------------------------------------------------------------
    */

    private function observacion($datos)
    {

        $obs=[];

        if($datos[0]['estado']!='APTO')
            $obs[]='Médico';

        if($datos[1]['estado']!='APTO')
            $obs[]='Examen Físico';

        if($datos[2]['estado']!='APTO')
            $obs[]='Wonderlic';

        if($datos[3]['estado']!='APTO')
            $obs[]='NEOFFI';

        if($datos[4]['estado']!='APTO')
            $obs[]='LSB50';

        return implode(', ',$obs);

    }
/*
|--------------------------------------------------------------------------
| INTERPRETACIÓN NEOFFI
|--------------------------------------------------------------------------
*/

private function interpretarNeoFFI(
    $dimension,
    $puntaje
)
{

    switch (strtoupper($dimension)) {

        case 'NEUROTICISMO':

            if ($puntaje <= 5) return 'Muy bajo';
            if ($puntaje <= 11) return 'Bajo';
            if ($puntaje <= 17) return 'Medio';
            if ($puntaje <= 26) return 'Alto';

            return 'Muy alto';

        case 'EXTRAVERSIÓN':
        case 'EXTRAVERSION':

            if ($puntaje <= 22) return 'Muy bajo';
            if ($puntaje <= 29) return 'Bajo';
            if ($puntaje <= 35) return 'Medio';
            if ($puntaje <= 41) return 'Alto';

            return 'Muy alto';

        case 'APERTURA':

            if ($puntaje <= 18) return 'Muy bajo';
            if ($puntaje <= 26) return 'Bajo';
            if ($puntaje <= 32) return 'Medio';
            if ($puntaje <= 38) return 'Alto';

            return 'Muy alto';

        case 'AMABILIDAD':

            if ($puntaje <= 24) return 'Muy bajo';
            if ($puntaje <= 30) return 'Bajo';
            if ($puntaje <= 35) return 'Medio';
            if ($puntaje <= 41) return 'Alto';

            return 'Muy alto';

        case 'RESPONSABILIDAD':

            if ($puntaje <= 27) return 'Muy bajo';
            if ($puntaje <= 33) return 'Bajo';
            if ($puntaje <= 38) return 'Medio';
            if ($puntaje <= 44) return 'Alto';

            return 'Muy alto';

    }

    return '-';

}
}