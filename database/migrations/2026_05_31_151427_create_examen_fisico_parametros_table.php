<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_examen_fisico_parametros',
            function (
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'prueba_id'
                )
                ->constrained(
                    'ECB_examen_fisico_pruebas'
                )
                ->cascadeOnDelete();

                $table->enum(
                    'sexo',
                    [

                        'M',

                        'F'

                    ]
                );

                $table->integer(
                    'valor_min'
                );

                $table->integer(
                    'valor_max'
                );

                $table->integer(
                    'puntaje'
                );

                $table->timestamps();

                $table->softDeletes();

            }
        );

    }

    public function down(): void
    {

        Schema::dropIfExists(
            'ECB_examen_fisico_parametros'
        );

    }

};