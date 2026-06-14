<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_resultados_examen_fisico_detalle',
            function(
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'resultado_id'
                )
                ->constrained(
                    'ECB_resultados_examen_fisico'
                )
                ->cascadeOnDelete();

                $table->foreignId(
                    'prueba_id'
                )
                ->constrained(
                    'ECB_examen_fisico_pruebas'
                )
                ->cascadeOnDelete();

                $table->decimal(
                    'valor_obtenido',
                    10,
                    2
                );

                $table->integer(
                    'puntaje'
                )
                ->nullable();

                $table->timestamps();

                $table->softDeletes();

            }
        );

    }

    public function down(): void
    {

        Schema::dropIfExists(
            'ECB_resultados_examen_fisico_detalle'
        );

    }

};