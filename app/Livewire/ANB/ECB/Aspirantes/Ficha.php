<?php

namespace App\Livewire\ANB\ECB\Aspirantes;

use Livewire\Component;
use App\Models\ANB\ECB\Llamado;
use App\Models\Gral\Compania;
use App\Models\ANB\ECB\Aspirante;
use Livewire\WithFileUploads;
use App\Models\ANB\ECB\FichaMedica;
use Illuminate\Support\Facades\Storage;
use App\Models\ANB\ECB\ExamenFisico;
use App\Models\ANB\ECB\ResultadoExamenFisico;
use App\Models\ANB\ECB\ResultadoExamenFisicoDetalle;
use App\Models\ANB\ECB\ExamenFisicoParametro;


class Ficha extends Component
{
    use WithFileUploads;

    public Aspirante $aspirante;

    public $modoEditar=false;
    public $nombre;
    public $apellido;
    public $cedula;
    public $ciudad;
    public $llamado_id;
    public $compania_id;
    public $registro_medico;
    public $observacion_medica;
    public $ficha_medica_archivo;
    public $ecg_archivo;
    public $radiografia_torax_archivo;
    public $laboratorio_archivo;
    public $documentacion_complementaria_archivo;
    public $mostrarFichaMedica=false;
    public $sexo;
    public $examen_fisico_id;

    public $resultados=[];

    public $puntajeTotal=0;

    public $mostrarNuevoExamen=false;
    public $mostrarDetallePsico=false;

    public $detallePsico=null;
        
    public $mostrarExamenesFisicos=false;

    public $mostrarEvaluacionesPsico=false;


    public function mount(
        Aspirante $aspirante
    )
    {

        $this->aspirante=$aspirante;

        $this->nombre=$aspirante->nombre;

        $this->apellido=$aspirante->apellido;

        $this->cedula=$aspirante->cedula;

        $this->ciudad=$aspirante->ciudad;

        $this->llamado_id=$aspirante->llamado_id;

        $this->compania_id=$aspirante->compania_id;
        $this->sexo=$aspirante->sexo;



        $ficha=$aspirante->fichaMedica;

        if($ficha){

            $this->registro_medico=$ficha->registro_medico;

            $this->observacion_medica=$ficha->observacion;

        }

    }

    public function save()
    {

        $this->validate([

            'nombre'=>'required',

            'apellido'=>'required',

            'cedula'=>'required',

            'compania_id'=>'required',

            'llamado_id'=>'required',
            'sexo'=>'required',
        ]);

        $this->aspirante->update([

            'nombre'=>$this->nombre,

            'apellido'=>$this->apellido,

            'cedula'=>$this->cedula,

            'ciudad'=>$this->ciudad,

            'llamado_id'=>$this->llamado_id,

            'compania_id'=>$this->compania_id,

            'sexo'=>$this->sexo,
            

        ]);

        $this->aspirante->refresh();

        $this->modoEditar=false;

    }

    public function cancelar()
    {

        $this->nombre=$this->aspirante->nombre;

        $this->apellido=$this->aspirante->apellido;

        $this->cedula=$this->aspirante->cedula;

        $this->ciudad=$this->aspirante->ciudad;

        $this->llamado_id=$this->aspirante->llamado_id;

        $this->compania_id=$this->aspirante->compania_id;


        $this->sexo=$this->aspirante->sexo;
        $this->modoEditar=false;

        

    }

    public function guardarFichaMedica()
    {
        $this->validate([
            'registro_medico'=>'nullable|string|max:255',
            'observacion_medica'=>'nullable|string',
            'ficha_medica_archivo'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'ecg_archivo'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'radiografia_torax_archivo'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'laboratorio_archivo'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documentacion_complementaria_archivo'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        $ficha=FichaMedica::firstOrNew([
            'aspirante_id'=>$this->aspirante->id
        ]);

        $ficha->registro_medico=$this->registro_medico;
        $ficha->observacion=$this->observacion_medica;

        if($this->ficha_medica_archivo){
            $ficha->ficha_medica_archivo=
                $this->ficha_medica_archivo->store(
                    'ecb/fichas_medicas',
                    'public'
                );
        }

        if($this->ecg_archivo){
            $ficha->ecg_archivo=
                $this->ecg_archivo->store(
                    'ecb/fichas_medicas',
                    'public'
                );
        }


        if($this->radiografia_torax_archivo){
            $ficha->radiografia_torax_archivo=
                $this->radiografia_torax_archivo->store(
                    'ecb/fichas_medicas',
                    'public'
                );
        }

        if($this->laboratorio_archivo){

            $ficha->laboratorio_archivo=

                $this->laboratorio_archivo->store(

                    'ecb/fichas_medicas',

                    'public'

                );

        }



        if($this->documentacion_complementaria_archivo){

            $ficha->documentacion_complementaria_archivo=

                $this->documentacion_complementaria_archivo->store(

                    'ecb/fichas_medicas',

                    'public'

                );

        }



        $ficha->save();

    }


    public function delete()
    {

        $this->aspirante
            ->delete();

        return redirect()
            ->route(
                'anb.ecb.aspirantes.index'
            );

    }

   public function render()
{

    $testsPsico=

        ExamenFisico::query();

    $testsPsico=

        \App\Models\ANB\ECB\PsicoTest::all();



    $sesionesPsico=

        $this->aspirante

        ->sesionesPsicologicas()

        ->with(

            'test',

            'respuestas.opcion'

        )

        ->get()

        ->keyBy(
            'test_id'
        );



    return view(

        'livewire.anb.ecb.aspirantes.ficha',

        [

            'llamados'=>

                Llamado::all(),

            'companias'=>

                Compania::companiasValidas()->orderBy('orden')->get(['id_compania','compania']),

            'examenesFisicos'=>

                ExamenFisico::where(

                    'activo',

                    true

                )->get(),

            'resultadosExamenes'=>

                $this->aspirante

                ->resultadosExamenFisico()

                ->with(

                    'examen',

                    'detalles.prueba'

                )

                ->latest()

                ->get(),

            'testsPsico'=>

                $testsPsico,

            'sesionesPsico'=>

                $sesionesPsico

        ]

    );

}

    public function eliminarArchivo(
        $campo
    )
    {

        $ficha=$this->aspirante
            ->fichaMedica;

        if(
            !$ficha
        ){
            return;
        }

        if(
            $ficha->$campo
        ){

            Storage::disk('public')
                ->delete(
                    $ficha->$campo
                );

            $ficha->$campo=null;

            $ficha->save();

        }

    }

    public function getDocumentosMedicosCompletosProperty()
    {

        $ficha=$this->aspirante
            ->fichaMedica;

        if(!$ficha){

            return 0;

        }

        $contador=0;

        if(
            $ficha->ficha_medica_archivo
        ){

            $contador++;

        }

        if(
            $ficha->ecg_archivo
        ){

            $contador++;

        }

        if(
            $ficha->radiografia_torax_archivo
        ){

            $contador++;

        }

        if(
            $ficha->laboratorio_archivo
        ){

            $contador++;

        }

        return $contador;

    }



    public function calcularPuntaje()
    {

        $this->puntajeTotal=0;

        if(
            !$this->examen_fisico_id
        ){

            return;

        }



        $examen=ExamenFisico::with(
            'pruebas.parametros'
        )

        ->find(
            $this->examen_fisico_id
        );



        foreach(

            $examen->pruebas

            as $prueba

        ){

            $valor=

                $this->resultados[
                    $prueba->id
                ]

                ??

                null;



            if(
                $valor===null
            ){

                continue;

            }



            $parametro=

                ExamenFisicoParametro::where(

                    'prueba_id',

                    $prueba->id

                )

                ->where(

                    'sexo',

                    $this->aspirante->sexo

                )

                ->where(

                    'valor_min',

                    '<=',

                    $valor

                )

                ->where(

                    'valor_max',

                    '>=',

                    $valor

                )

                ->first();



            $puntaje=

                $parametro?->puntaje

                ??

                0;



            $this->resultados[
                'puntaje_'.$prueba->id
            ]

            =

            $puntaje;



            $this->puntajeTotal+=

                $puntaje;

        }

    }



    public function guardarExamenFisico()
    {

        $this->calcularPuntaje();

$examen=

ExamenFisico::with(
    'pruebas'
)
->find(
    $this->examen_fisico_id
);



$aprobado=

$this->puntajeTotal >=
(
    $examen->puntaje_aprobacion
    ??
    0
);







        $resultado=

            ResultadoExamenFisico::create([

                'aspirante_id'=>

                    $this->aspirante->id,

                'examen_fisico_id'=>

                    $this->examen_fisico_id,

                'puntaje_total'=>

                    $this->puntajeTotal,

                'aprobado'=>$aprobado

            ]);



        $examen=

            ExamenFisico::with(
                'pruebas'
            )

            ->find(
                $this->examen_fisico_id
            );



        foreach(
            $examen->pruebas
            as $prueba
        ){

            ResultadoExamenFisicoDetalle::create([

                'resultado_id'=>

                    $resultado->id,

                'prueba_id'=>

                    $prueba->id,

                'valor_obtenido'=>

                    $this->resultados[
                        $prueba->id
                    ]

                    ??

                    0,

                'puntaje'=>

                    $this->resultados[
                        'puntaje_'.$prueba->id
                    ]

                    ??

                    0

            ]);

        }



        $this->reset(

            'examen_fisico_id',

            'resultados',

            'puntajeTotal'

        );
        $this->mostrarNuevoExamen=false;
    }

   
    public function abrirDetallePsico($id)
{
    $this->detallePsico=

        \App\Models\ANB\ECB\PsicoSesion

        ::with(

            'test',

            'respuestas.pregunta',

            'respuestas.opcion',

            'resultados.dimension'

        )

        ->find($id);

    $this->mostrarDetallePsico=true;
}


public function interpretarNeoFfi(
    $dimension,
    $puntaje
)
{
    switch(strtoupper($dimension)){

        case 'NEUROTICISMO':

            if($puntaje <= 5) return 'Muy bajo';
            if($puntaje <= 11) return 'Bajo';
            if($puntaje <= 17) return 'Medio';
            if($puntaje <= 26) return 'Alto';

            return 'Muy alto';

        case 'EXTRAVERSION':

            if($puntaje <= 22) return 'Muy bajo';
            if($puntaje <= 29) return 'Bajo';
            if($puntaje <= 35) return 'Medio';
            if($puntaje <= 41) return 'Alto';

            return 'Muy alto';

        case 'APERTURA':

            if($puntaje <= 18) return 'Muy bajo';
            if($puntaje <= 26) return 'Bajo';
            if($puntaje <= 32) return 'Medio';
            if($puntaje <= 38) return 'Alto';

            return 'Muy alto';

        case 'AMABILIDAD':

            if($puntaje <= 24) return 'Muy bajo';
            if($puntaje <= 30) return 'Bajo';
            if($puntaje <= 35) return 'Medio';
            if($puntaje <= 41) return 'Alto';

            return 'Muy alto';

        case 'RESPONSABILIDAD':

            if($puntaje <= 27) return 'Muy bajo';
            if($puntaje <= 33) return 'Bajo';
            if($puntaje <= 38) return 'Medio';
            if($puntaje <= 44) return 'Alto';

            return 'Muy alto';

        default:

            return '-';
    }
}

}