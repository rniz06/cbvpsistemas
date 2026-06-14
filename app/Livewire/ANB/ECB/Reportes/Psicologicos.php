<?php

namespace App\Livewire\ANB\ECB\Reportes;

use Livewire\Component;

use App\Models\ANB\ECB\PsicoTest;
use App\Models\ANB\ECB\PsicoDimension;
use App\Models\ANB\ECB\PsicoSesion;
use App\Models\ANB\ECB\PsicoResultado;

class Psicologicos extends Component
{
    public $test_id = '';

    public $dimension_id = '';

    public $datos = [];

    public $columnasDinamicas = [];

    public function updatedTestId()
    {
        $this->dimension_id = '';
    }

    public function render()
    {
        $tests = PsicoTest::orderBy('nombre')->get();

        $dimensiones = collect();

        $this->datos = [];

        $this->columnasDinamicas = [];

        if ($this->test_id) {

            $test = PsicoTest::find($this->test_id);

            $dimensiones = PsicoDimension::where(
                'test_id',
                $this->test_id
            )->get();

            if ($test && $test->codigo == 'WONDERLIC') {

                $this->datos = PsicoSesion::with([
                    'aspirante.compania'
                ])
                ->where('test_id', $this->test_id)
                ->where('finalizado', 1)
                ->get();

            } else {

                $query = PsicoResultado::with([
                    'dimension',
                    'sesion.aspirante.compania'
                ])

                ->whereHas(
                    'sesion',
                    function ($q) {
                        $q->where(
                            'test_id',
                            $this->test_id
                        );
                    }
                );

                if ($this->dimension_id) {

                    $query->where(
                        'dimension_id',
                        $this->dimension_id
                    );
                }

                $resultados = $query->get();

                $this->columnasDinamicas =
                    $dimensiones
                        ->pluck('nombre')
                        ->toArray();

                $agrupados = [];

                foreach ($resultados as $resultado) {

                    $aspirante =
                        $resultado
                            ->sesion
                            ->aspirante;

                    $id = $aspirante->id;

                    if (!isset($agrupados[$id])) {

                        $agrupados[$id] = [

                            'cedula' =>
                                $aspirante->cedula,

                            'nombre' =>
                                $aspirante->apellido .
                                ', ' .
                                $aspirante->nombre,

                            'compania' =>
                                $aspirante->compania->descripcion
                                ?? ''

                        ];

                        foreach ($dimensiones as $dimension) {

                            $agrupados[$id]
                            [$dimension->nombre]
                                = '';

                        }
                    }

                    $agrupados[$id]
                    [$resultado->dimension->nombre]
                        = $resultado->puntaje;
                }

                $this->datos =
                    array_values(
                        $agrupados
                    );
            }
        }

        return view(
            'livewire.anb.ecb.reportes.psicologicos',
            compact(
                'tests',
                'dimensiones'
            )
        );
    }
}