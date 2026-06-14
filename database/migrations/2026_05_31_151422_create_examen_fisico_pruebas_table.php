<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_examen_fisico_pruebas',
            function (
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'examen_fisico_id'
                )
                ->constrained(
                    'ECB_examenes_fisicos'
                )
                ->cascadeOnDelete();

                $table->string(
                    'nombre'
                );

                $table->enum(
                    'tipo_medicion',
                    [

                        'DISTANCIA',

                        'REPETICIONES',

                        'TIEMPO'

                    ]
                );

                $table->timestamps();

                $table->softDeletes();

            }
        );

    }

    public function down(): void
    {

        Schema::dropIfExists(
            'ECB_examen_fisico_pruebas'
        );

    }

};