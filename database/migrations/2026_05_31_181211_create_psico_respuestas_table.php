<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create(

            'ECB_psico_respuestas',

            function(
                Blueprint $table
            ){

                $table->id();

                $table->foreignId(
                    'sesion_id'
                )
                ->constrained(
                    'ECB_psico_sesiones'
                )
                ->cascadeOnDelete();

                $table->foreignId(
                    'pregunta_id'
                )
                ->constrained(
                    'ECB_psico_preguntas'
                )
                ->cascadeOnDelete();

                $table->foreignId(
                    'opcion_id'
                )
                ->nullable()
                ->constrained(
                    'ECB_psico_opciones'
                )
                ->nullOnDelete();

                $table->timestamps();

            }

        );

    }

    public function down(): void
    {

        Schema::dropIfExists(
            'ECB_psico_respuestas'
        );

    }

};