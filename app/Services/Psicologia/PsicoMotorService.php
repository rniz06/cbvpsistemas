<?php

namespace App\Services\Psicologia;

use App\Models\ANB\ECB\PsicoBaremo;
use App\Models\ANB\ECB\PsicoRespuesta;
use App\Models\ANB\ECB\PsicoResultado;
use App\Models\ANB\ECB\PsicoSesion;
use Illuminate\Support\Facades\DB;

class PsicoMotorService
{

    public function corregir(PsicoSesion $sesion): void
    {

        DB::transaction(function () use ($sesion) {

            PsicoResultado::where(
                'sesion_id',
                $sesion->id
            )->delete();

            $respuestas = PsicoRespuesta::with([

                'opcion',

                'pregunta.dimensiones',

            ])
            ->where(
                'sesion_id',
                $sesion->id
            )
            ->get();

            $puntajesBrutos = [];

            foreach ($respuestas as $respuesta) {

                if (
                    !$respuesta->pregunta ||
                    !$respuesta->opcion
                ) {
                    continue;
                }

                $valor = $respuesta->opcion->valor;

                foreach ($respuesta->pregunta->dimensiones as $dimension) {

                    /**
                     * GLOBAL, NUM e INT
                     * se calculan después.
                     */
                    if (
                        in_array(
                            $dimension->codigo,
                            ['GLOBAL','NUM','INT']
                        )
                    ) {
                        continue;
                    }

                    if (!isset($puntajesBrutos[$dimension->id])) {

                        $puntajesBrutos[$dimension->id] = [

                            'dimension' => $dimension,

                            'bruto' => 0

                        ];
                    }

                    $puntajesBrutos[$dimension->id]['bruto'] += $valor;
                }
            }

            $sexo = strtoupper(
                $sesion->aspirante->sexo
            );

            foreach ($puntajesBrutos as $item) {

                $dimension = $item['dimension'];

                $puntajeBruto = $item['bruto'];

                $puntajeDirecto = $puntajeBruto;

                if ($dimension->divisor > 0) {

                    $puntajeDirecto = round(

                        $puntajeBruto /
                        $dimension->divisor,

                        2

                    );

                }

                $baremo = PsicoBaremo::where(

                    'dimension_id',

                    $dimension->id

                )
                ->where(

                    'sexo',

                    $sexo

                )
                ->where(

                    'desde',

                    '<=',

                    $puntajeDirecto

                )
                ->where(

                    'hasta',

                    '>=',

                    $puntajeDirecto

                )
                ->first();

                PsicoResultado::updateOrCreate(

                    [

                        'sesion_id' => $sesion->id,

                        'dimension_id' => $dimension->id

                    ],

                    [

                        'puntaje_bruto' => $puntajeBruto,

                        'puntaje_directo' => $puntajeDirecto,

                        'puntaje' => $puntajeDirecto,

                        'percentil' => $baremo?->percentil,

                        'interpretacion' => $baremo?->interpretacion,

                    ]

                );

            }

            /**
             * ========================================
             * INDICES DERIVADOS
             * ========================================
             */

            $codigos = [];

            foreach ($puntajesBrutos as $item) {

                $codigos[
                    $item['dimension']->codigo
                ] = $item;

            }

            $totalSintomas =

                ($codigos['PR']['bruto'] ?? 0)

                +

                ($codigos['AN']['bruto'] ?? 0)

                +

                ($codigos['HS']['bruto'] ?? 0)

                +

                ($codigos['SM']['bruto'] ?? 0)

                +

                ($codigos['DE']['bruto'] ?? 0)

                +

                ($codigos['SU']['bruto'] ?? 0);

            $cantidadCeros =

                $respuestas

                ->filter(

                    fn($r) =>

                        $r->opcion?->valor == 0

                )

                ->count();

            $pdGlobal = round(

                $totalSintomas / 50,

                2

            );

            $pdNum =

                50 - $cantidadCeros;

            $pdInt =

                $pdNum > 0

                ? round(

                    $totalSintomas /

                    $pdNum,

                    2

                )

                : 0;

            $this->guardarIndice(

                $sesion,

                'GLOBAL',

                $pdGlobal

            );

            $this->guardarIndice(

                $sesion,

                'NUM',

                $pdNum

            );

            $this->guardarIndice(

                $sesion,

                'INT',

                $pdInt

            );

        });

    }
        /**
     * Guarda un índice derivado
     * (GLOBAL, NUM o INT)
     */
    private function guardarIndice(
        PsicoSesion $sesion,
        string $codigo,
        float $puntaje
    ): void
    {

        $dimension =

            $sesion
                ->test
                ->dimensiones()
                ->where(
                    'codigo',
                    $codigo
                )
                ->first();

        if (!$dimension) {
            return;
        }

        $sexo = strtoupper(
            $sesion->aspirante->sexo
        );

        $baremo = PsicoBaremo::where(

            'dimension_id',

            $dimension->id

        )
        ->where(

            'sexo',

            $sexo

        )
        ->where(

            'desde',

            '<=',

            $puntaje

        )
        ->where(

            'hasta',

            '>=',

            $puntaje

        )
        ->first();

        PsicoResultado::updateOrCreate(

            [

                'sesion_id'   => $sesion->id,

                'dimension_id'=> $dimension->id

            ],

            [

                'puntaje_bruto'   => $puntaje,

                'puntaje_directo' => $puntaje,

                'puntaje'         => $puntaje,

                'percentil'       => $baremo?->percentil,

                'interpretacion'  => $baremo?->interpretacion,

            ]

        );

    }

}