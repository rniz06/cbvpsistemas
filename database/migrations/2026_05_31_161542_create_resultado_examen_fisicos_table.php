<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'ECB_resultados_examen_fisico',
            function(
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'aspirante_id'
                )
                ->constrained(
                    'ECB_aspirantes'
                )
                ->cascadeOnDelete();

                $table->foreignId(
                    'examen_fisico_id'
                )
                ->constrained(
                    'ECB_examenes_fisicos'
                )
                ->cascadeOnDelete();

                $table->integer(
                    'puntaje_total'
                )
                ->nullable();

                $table->boolean(
                    'aprobado'
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
            'ECB_resultados_examen_fisico'
        );

    }

};